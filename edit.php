<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
	die("ACCESS DENIED");
}

// If the user requested logout go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

$status = false;

if ( isset($_SESSION['status']) ) {
	$status = htmlentities($_SESSION['status']);
	$status_color = htmlentities($_SESSION['color']);

	unset($_SESSION['status']);
	unset($_SESSION['color']);
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

$name = htmlentities($_SESSION['name']);

$_SESSION['color'] = 'red';

if (isset($_REQUEST['autos_id']))
{

	if (isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['make']) && isset($_POST['model'])) 
	{
	    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1)
	    {
	        $_SESSION['status'] = "All fields are required";
	        header("Location: edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
	        return;
	    }

	    if (!is_numeric($_POST['year']) ) 
	    {
	        $_SESSION['status'] = "Year must be an integer";
	        header("Location: edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
			return;
	    } 

	    if ( !is_numeric($_POST['mileage'])) 
	    {
	        $_SESSION['status'] = "Mileage must be an integer";
	        header("Location: edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
	        return;
	    } 

	    $make = htmlentities($_POST['make']);
	    $model = htmlentities($_POST['model']);
	    $year = htmlentities($_POST['year']);
	    $mileage = htmlentities($_POST['mileage']);

    	$auto_id = htmlentities($_REQUEST['autos_id']);

	    $stmt = $pdo->prepare("
	    	UPDATE autos
	    	SET make = :make, model = :model, year = :year, mileage = :mileage
		    WHERE auto_id = :auto_id
	    ");

	    $stmt->execute([
	        ':make' => $make, 
	        ':model' => $model, 
	        ':year' => $year,
	        ':mileage' => $mileage,
	        ':auto_id' => $auto_id,
	    ]);

	    $_SESSION['status'] = 'Record edited';
	    $_SESSION['color'] = 'green';

	    header('Location: index.php');
		return;
	}


	$auto_id = htmlentities($_REQUEST['autos_id']);

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
        .edit-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
        }
        .btn-primary:hover {
            background-color: #6a11cb;
        }
        .status-message {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-horizontal .form-group {
            margin-bottom: 20px;
        }
        .form-horizontal .control-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container edit-container">
        <h1>Editing Automobile</h1>
        <?php
            if ( $status !== false ) 
            {
                echo(
                    '<p class="status-message" style="color: ' .$status_color. ';">'.
                        htmlentities($status).
                    "</p>\n"
                );
            }
        ?>
        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="make">Make:</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="make" id="make" value="<?php echo htmlentities($auto->make); ?>" placeholder="Enter car make">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="model">Model:</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="model" id="model" value="<?php echo htmlentities($auto->model); ?>" placeholder="Enter car model">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="year">Year:</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="year" id="year" value="<?php echo htmlentities($auto->year); ?>" placeholder="Enter year">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="mileage">Mileage:</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="mileage" id="mileage" value="<?php echo htmlentities($auto->mileage); ?>" placeholder="Enter mileage">
                </div>
            </div>
            <div class="form-group text-center">
                <input class="btn btn-primary" type="submit" value="Save">
                <input class="btn btn-default" type="submit" name="cancel" value="Cancel">
            </div>
        </form>
    </div>
</body>
</html>
