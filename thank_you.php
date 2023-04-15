<?php

session_start();
if (isset($_POST["logout"])) {
    session_destroy();
    unset($_SESSION['username']);
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Vote</title>
        <meta charset="UTF-8">
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>
    <h1>Polling Station</h1>
    <form method="post">
        <button type="submit"
                name="logout">Logout</button><br><br>
    </form>

    <h2>Thank You for Voting!</h2>

    </body>
</html>
