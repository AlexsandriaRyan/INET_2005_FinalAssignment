<?php

    include_once "functions.php";

    $connection = connect();

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
        <title>Admin</title>
        <meta charset="UTF-8">
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>
    <h1>Polling Station</h1>
    <h2>Admin Panel</h2>

    <form method="post">
        <!-- Logout Button -->
        <button type="submit" name="logout">Logout</button> <br><br><br>

        <!-- Voting Buttons -->
        <h2>Voting Results</h2>
        <button class="btn" type="submit" name="winner">Winner</button>
        <button class="btn" type="submit" name="top2">Top 2</button>
        <button class="btn" type="submit" name="last">Last Place</button>
        <button class="btn" type="submit" name="all">All</button>

        <br><br>
        <div class="result">
            <?php

            include_once "functions.php";
            include_once "User.php";
            $connection = connect();

            // open Winner view
            if (isset($_POST["winner"])) {
                $results = get_winner($connection);
                echo "<p>" .$results['poll_candidate'] . " - " . $results['poll_votes'];
            }

            // open Top 2 view
            if (isset($_POST["top2"])) {
                foreach (get_top_2($connection) as $option) {
                    echo "<p>" .$option['poll_candidate'] . " - " . $option['poll_votes'].'<br>';
                }
            }

            // open Last Place view
            if (isset($_POST["last"])) {
                $results = get_last_place($connection);
                echo "<p>" . $results['poll_candidate'] . " - " . $results['poll_votes'];
            }

            // open All Poll Options view
            if (isset($_POST["all"])) {
                foreach (get_all_votes($connection) as $option) {
                    echo "<p>" .$option['poll_candidate'] . " - " . $option['poll_votes'].'<br>';
                }
            } ?>
        </div>



        <!-- Voter Buttons -->
        <br><br><br>
        <h2>Voter Options</h2>
        <br>
        <button class="btn" type="submit" name="add_voter">Add A Voter</button>
        <button class="btn" type="submit" name="find_voter">Find A Voter</button>
        <button class="btn" type="submit" name="delete_voter">Delete A Voter</button>

        <br><br>
        <div class="result">
            <?php

            // open Add Voter view
            if (isset($_POST["add_voter"])) {
            ?> <h2>New Account</h2> <?php
            require('register.php');
            }

            // open Find Voter view
            if (isset($_POST["find_voter"])) {
            ?> <h2>Find Voter</h2>
            <form method="post">
                <!-- username field-->
                <label name="username">Username:</label>
                <input type="text" name="user"><br><br>
                <button class="submit"  type="submit" name="search">Search</button><br><br>
            </form>
            <?php
            }

            // open Delete Voter view
            if (isset($_POST["delete_voter"])) {
            ?> <h2>Delete Voter</h2>
            <form method="post">
                <!-- username field-->
                <label name="username">Username:</label>
                <input type="text" name="user"><br><br>
                <button class="delete"  type="submit" name="delete">Delete</button><br><br>
            </form>

            <?php
            }

            // if user completes a voter new account...
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

                $error = "";

                $error = find_user($connection, $fname, $lname, $phone, $username);

                if ($error!= "") {
                    echo $error;

                } else {
                    $voter = new User($fname, $lname, $phone, $username, $password);
                    add_voter($connection, $voter);
                    $error = "";
                    echo "New voter " . $fname . " " . $lname . " successfully added.<br>";
                }
            }

            // if user completes a voter search...
            if (isset($_POST['search'])) {
                $username = $_POST['user'];
                $results = find_username($connection, $username);

                if (!empty($results)) {
                    echo "<p>" . "Name: " . $results['user_fname'] . " " . $results['user_lname'] . '<br>' . "Phone: " . $results['user_phone'] . '<br>' . "Vote: " . $results['user_vote'];

                } else {
                    echo "Could not find username " . $username;
                }


            }

            // if user completes a voter delete...
            if (isset($_POST['delete'])) {
                $username = $_POST['user'];
                $results = find_username($connection, $username);
                if (!empty($results)) {
                    delete_user($connection, $username);

                    echo "<p>" . "Name: " . $results['user_fname'] . " " . $results['user_lname'] . " has been deleted.";
                } else {
                    echo "<p>" . "No user detected for delete.";
                }
            } ?>

        </div>

        <!-- Poll Buttons -->
        <br><br>
        <h2>Poll Options</h2>
        <br>
        <button class="btn" type="submit" name="add_poll">Add A Poll Option</button>
        <button class="btn" type="submit" name="delete_poll">Delete A Poll Option</button>

        <br><br>
        <div class="result">
            <?php

            // open Add Poll view
            if (isset($_POST["add_poll"])) {
                ?> <h2>Add Poll option</h2>
                <form method="post">
                    <!-- option field-->
                    <label name="option">Option Name:</label>
                    <input type="text" name="option"><br><br>
                    <button class="submit"  type="submit" name="add_option">Submit</button><br><br>
                </form>
                <?php
            }

            // open Delete Poll view
            if (isset($_POST["delete_poll"])) {
                ?> <h2>Delete Poll Option</h2>
                <form method="post">
                    <!-- option field-->
                    <label name="option">Option Name:</label>
                    <input type="text" name="option"><br><br>
                    <button class="delete"  type="submit" name="delete_option">Delete</button><br><br>
                </form>

                <?php
            }

            // if user completes a poll add...
            if (isset($_POST['add_option'])) {
                $option = $_POST['option'];
                $already_exists = find_option($connection, $option);

                if(empty($already_exists)) {
                    add_option($connection, $option);
                    echo "New option " . $option . " successfully added.<br>";

                } else {
                    echo $option . " already exists.<br>";
                }
            }

            // if user completes a poll delete...
            if (isset($_POST['delete_option'])) {
                $option = $_POST['option'];
                $results = find_option($connection, $option);
                if (!empty($results)) {
                    delete_option($connection, $option);
                    echo "<p>" . "Option: " . $results['poll_candidate'] . " has been deleted.";

                } else {
                    echo "<p>" . "No option detected for delete.";
                }
            }
            ?>
        </div>

    </form>

    </body>
</html>