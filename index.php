<?php
session_start();

$logged_in = false;
$autos = [];

if (isset($_SESSION['name'])) {

    $logged_in = true;
    $status = false;

    if (isset($_SESSION['status'])) {
        $status = htmlentities($_SESSION['status']);
        $status_color = htmlentities($_SESSION['color']);
        unset($_SESSION['status']);
        unset($_SESSION['color']);
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=crud_db", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $all_autos = $pdo->query("SELECT * FROM autos");

        while ($row = $all_autos->fetch(PDO::FETCH_OBJ)) {
            $autos[] = $row;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Priyanshu Maurya Autos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            padding: 50px 0;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 30px;
            border-radius: 12px;
						margin: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 900px;
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 2rem;
        }
        .status-msg {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
        }
        table {
            background-color: #fff;
            border-radius: 8px;
        }
        th {
            background: #667eea;
            color: #fff;
        }
        td a {
            text-decoration: none;
            color: #667eea;
            margin-right: 10px;
        }
        td a:hover {
            text-decoration: underline;
        }
        .btn-main {
            background: #667eea;
            border: none;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            margin-right: 10px;
            transition: 0.3s;
        }
        .btn-main:hover {
            background: #5a67d8;
        }
        .top-actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Automobiles Database</h1>

        <?php if (!$logged_in) : ?>
            <p class="text-center">
                <a class="btn btn-main" href="login.php">Please log in</a>
                <a class="btn btn-secondary" href="add.php">Attempt to add data</a>
            </p>
        <?php else : ?>
            
            <?php if ($status !== false) : ?>
                <div class="status-msg" style="color: <?php echo $status_color; ?>;">
                    <?php echo $status; ?>
                </div>
            <?php endif; ?>

            <?php if (empty($autos)) : ?>
                <p class="text-center">No records found.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Mileage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($autos as $auto) : ?>
                                <tr>
                                    <td><?php echo $auto->make; ?></td>
                                    <td><?php echo $auto->model; ?></td>
                                    <td><?php echo $auto->year; ?></td>
                                    <td><?php echo $auto->mileage; ?></td>
                                    <td>
                                        <a href="edit.php?autos_id=<?php echo $auto->auto_id; ?>">Edit</a> /
                                        <a href="delete.php?autos_id=<?php echo $auto->auto_id; ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="top-actions">
                <a class="btn btn-main" href="add.php">Add New Entry</a>
                <a class="btn btn-secondary" href="logout.php">Logout</a>
            </div>

        <?php endif; ?>
    </div>
</body>
</html>
