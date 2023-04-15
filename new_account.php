<?php

include_once "functions.php";
include_once "User.php";

session_start();

if (isset($_POST['fname'])
    && ($_POST['lname'])
    && ($_POST['phone'])
    && isset($_POST['username'])
    && isset($_POST['password'])) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = connect();
    $error = "";

    $error = find_user($connection, $fname, $lname, $phone, $username);

    if ($error!= "") {
        echo $error;

    } else {
        $error = "";
        $voter = new User($fname, $lname, $phone, $username, $password);
        add_voter($connection, $voter);
        header("Location: login.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>New Account</title>
        <meta charset="UTF-8">
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>

    <h1>Polling Station</h1>
    <h2>New Account</h2>
    <a href="login.php"><button class="btn">Back</button></a><br><br><br>
    <?php require ('register.php'); ?>

    </body>
</html>

