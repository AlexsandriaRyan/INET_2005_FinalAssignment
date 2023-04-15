<?php

    include_once "functions.php";

    session_start();
    if(empty($_SESSION['username'])) {
        header("Location: login.php");
    }

    $username = $_SESSION['username'];

    // if vote is selected
    if(isset($_POST["submit"])) {

        $connection = connect();
        $vote = $_POST['vote'];

        vote($connection, $vote, $username);
        header("Location: thank_you.php");
    }

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

    <?php
        include_once "functions.php";

        $connection = connect();
        $username = $_SESSION['username'];

        // check if the user has already voted
        $has_voted = check_user_vote($connection, $username);

        // if the user has already voted, display the poll options
        if (!$has_voted) {
            ?>
            <h2>Pick an Option Below:</h2>
            <form method="post">
                <?php
                include_once "functions.php";
                $connection = connect();

                foreach (get_options($connection) as $option) {
                    echo '<p><input type="radio" name="vote" value="'.$option['poll_candidate'].'" > '.$option['poll_candidate'];
                } ?>

                <br><br><br>
                <button class="submit"
                        type="submit"
                        name="submit">Vote</button>
            </form>

        <?php
        // otherwise display that they have already voted
        } else { ?>
            <h2>Oops! You've already cast your vote.</h2>
        <?php } ?>

    </body>
</html>

<?php

?>
