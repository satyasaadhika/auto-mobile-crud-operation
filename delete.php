<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
	die("ACCESS DENIED");
}

try 
{
    $pdo = new PDO("mysql:host=localhost;dbname=crud_db", "root");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}

if (isset($_REQUEST['autos_id']))
{
    $auto_id = htmlentities($_REQUEST['autos_id']);

    if (isset($_POST['delete'])) 
    {
        $stmt = $pdo->prepare("
            DELETE FROM autos
            WHERE auto_id = :auto_id
        ");

        $stmt->execute([
            ':auto_id' => $auto_id, 
        ]);

        $_SESSION['status'] = 'Record deleted';
        $_SESSION['color'] = 'green';

        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("
        SELECT * FROM autos 
        WHERE auto_id = :auto_id
    ");

    $stmt->execute([
        ':auto_id' => $auto_id, 
    ]);

    $auto = $stmt->fetch(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Priyanshu Maurya Autos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }
        .delete-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
        }
        .btn-primary:hover {
            background-color: #6a11cb;
        }
        .btn-default {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container delete-container">

        <p>
            Confirm: Deleting <?php echo htmlentities($auto->make); ?>
        </p>

        <form method="post" class="form-horizontal">
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="delete" value="Delete">
                <a class="btn btn-default" href="index.php">Cancel</a>
            </div>
        </form>

    </div>
</body>
</html>
