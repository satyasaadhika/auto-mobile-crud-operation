<?php // Do not put any HTML above this line

session_start();

if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash= '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$failure = false;  // If we have no POST data

if ( isset($_SESSION['failure']) ) {
    $failure = htmlentities($_SESSION['failure']);

    unset($_SESSION['failure']);
}

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) 
{
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) 
    {
        $_SESSION['failure'] = "User name and password are required";
        header("Location: login.php");
        return;
    } 

    $pass = htmlentities($_POST['pass']);
    $email = htmlentities($_POST['email']);

    $check = hash('md5', $salt.$pass);

    if ($check != $stored_hash) 
    {
        error_log("Login fail ".$pass." $check");
        $_SESSION['failure'] = "Incorrect password";

        header("Location: login.php");
        return;
    }

    error_log("Login success ".$email);
    $_SESSION['name'] = $email;

    header("Location: index.php");
    return;

}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
    <title>Priyanshu Maurya's Login Page</title>
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
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
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
        p.hint {
            font-size: 0.9em;
            color: #666;
            margin-top: 20px;
        }
        .failure-message {
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <h1>Please Log In</h1>
        <?php
            if ( $failure !== false ) 
            {
                echo(
                    '<p class="failure-message text-danger">'.
                        htmlentities($failure).
                    "</p>\n"
                );
            }
        ?>
        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">User Email:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="email" id="email" placeholder="Enter your email">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pass">Password:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="pass" id="pass" placeholder="Enter your password">
                </div>
            </div>
            <div class="form-group text-center">
                <input class="btn btn-primary" type="submit" value="Log In">
                <input class="btn btn-default" type="submit" name="logout" value="Cancel">
            </div>
        </form>
        <p class="hint">
            For a password hint, view source and find a password hint in the HTML comments.
            <!-- Hint: The password is the four character sound a cat
            makes (all lower case) followed by 123. -->
        </p>
    </div>
</body>
</html>
