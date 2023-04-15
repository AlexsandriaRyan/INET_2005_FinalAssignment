<?php

include_once "functions.php";

session_start();
// if submit is selected & username / password are filled...
if(isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["password"])) {

    // set username and password variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // connect and try login method
    $connection = connect();
    $login = login($connection, $username, $password);

    // if login matches
    if (mysqli_num_rows($login) === 1) {
        echo "hi";
        echo $username;
        echo $password;

        $row = $login->fetch_assoc();

        if ($row['user_username'] == $username && $row['user_password'] == $password) {

            // check if login belongs to admin or voter
            if ($row['user_admin'] == 0) {
                $_SESSION['username'] = $username;
                header("Location: voter_page.php");

            } else {
                header("Location: admin_page.php");
            }

        } else {
            echo "Username or Password is not valid.";
        }

    } else {
        echo "Username or Password is not valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>
    <h1>Polling Station</h1> <br>
    <h2>Login</h2>

    <form method="post">

        <!-- username field-->
        <label name="username">Username:</label>
        <input type="text" name="username"  required>

        <!-- password -->
        <br><br>
        <label name="password">Password: </label>
        <input type="password" name="password"  required>

        <!-- sign in button -->
        <br><br>
        <button class="submit"  type="submit"  name="submit">Sign In</button>
    </form>

    <!-- new account button -->
    <br><br>
    <p>Not registered?</p>
    <a href="new_account.php"><button class="btn">Register</button></a>

    </body>
</html>