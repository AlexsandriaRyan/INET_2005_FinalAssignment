<?php

function connect() {
    $host= "localhost";
    $username = "root";
    $password = "";
    $db = "polls_db";

    $connection = new mysqli($host, $username, $password, $db);
    if ($connection->connect_error) { die("No connection"); }

    return $connection;
}

function login($connection, $username, $password) {
    $query = "SELECT * FROM user WHERE user_username = '$username' AND user_password = '$password'";
    return $connection->query($query);
}

function find_user($connection, $fname, $lname, $phone, $username) {
    $error = "";
    // check if first & last names are registered
    $query = "SELECT * FROM user WHERE user_fname = '$fname' AND user_lname = '$lname'";
    $query = $connection->query($query);

    if (mysqli_num_rows($query) === 1) {
        $error = "First and last name already registered.";
    }

    // check if phone is already registered
    $query = "SELECT * FROM user WHERE user_phone = '$phone'";
    $query = $connection->query($query);

    if (mysqli_num_rows($query) === 1) {
        $error .= "\nPhone already registered.";
    }

    // check if username is already taken
    $query = "SELECT * FROM user WHERE user_username = '$username'";
    $query = $connection->query($query);

    if (mysqli_num_rows($query) === 1) {
        $error .= "\nUsername already taken.";
    }

    return $error;
}



function add_voter($connection, $new_user) {
    // insert voter details into the voter table
    $query = "INSERT INTO user(user_fname, user_lname, user_phone, user_username, user_password) VALUE ('$new_user->fname', '$new_user->lname', '$new_user->phone', '$new_user->username', '$new_user->password')";
    $connection->query($query);
}

function get_options($connection) {
    $query = "SELECT * FROM poll";
    return $connection->query($query);
}

function vote($connection, $vote, $username) {
    // set user's vote
    $query = "UPDATE poll SET poll_votes = poll_votes + 1 WHERE poll_candidate = '$vote'";
    $connection->query($query);

    // increase candidate's vote count
    $query = "UPDATE user SET user_vote = '$vote' WHERE user_username = '$username'";
    $connection->query($query);
}

function check_user_vote($connection, $username) {
    $query = "SELECT * FROM user WHERE user_username = '$username'";
    $result = $connection->query($query);
    $row = mysqli_fetch_assoc($result);

    if (empty($row['user_vote'])) {
        return false;
    } else {
        return true;
    }

}


// ----- Admin Panel : Voting Buttons

function get_winner($connection) {
    $query = "SELECT poll_candidate, poll_votes FROM poll ORDER BY poll_votes DESC limit 1";
    $results =  $connection->query($query);

    if (mysqli_num_rows($results) == 1) {
        return mysqli_fetch_assoc($results);
    }
}

function get_top_2($connection) {
    $query = "SELECT poll_candidate, poll_votes FROM poll ORDER BY poll_votes DESC limit 2";
    return $connection->query($query);
}

function get_last_place($connection) {
    $query = "SELECT poll_candidate, poll_votes FROM poll ORDER BY poll_votes ASC limit 1";
    $results =  $connection->query($query);

    if (mysqli_num_rows($results) == 1) {
        return mysqli_fetch_assoc($results);
    }
}

function get_all_votes($connection) {
    $query = "SELECT * FROM poll ORDER BY poll_votes DESC";
    return $connection->query($query);
}


// ----- Admin Panel : Voter Buttons

function find_username($connection, $username) {
    $query = "SELECT * FROM user WHERE user_username = '$username'";
    $results = $connection->query($query);

    if (mysqli_num_rows($results) == 1) {
        return mysqli_fetch_assoc($results);
    }
}

function delete_user($connection, $username) {
    $query = "DELETE FROM user WHERE user_username = '$username'";
    $connection->query($query);
}


// ----- Admin Panel : Poll Buttons

function find_option($connection, $option) {
    $query = "SELECT * FROM poll WHERE poll_candidate = '$option'";
    $results = $connection->query($query);

    if (mysqli_num_rows($results) == 1) {
        return mysqli_fetch_assoc($results);
    }
}

function add_option($connection, $option) {
    $query = "INSERT INTO poll(poll_candidate) VALUE ('$option')";
    $connection->query($query);
}

function delete_option($connection, $option) {
    $query = "DELETE FROM poll WHERE poll_candidate = '$option'";
    $connection->query($query);
}


