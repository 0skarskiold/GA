<?php

if (isset($_POST["submit"])){
    
    $type = mysqli_real_escape_string($conn, $_GET['type']);
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $rating = $_POST["rating"];
    $date = $_POST["date"];
    $user_id = $_SESSION["userid"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    print_r($date);

    if (invalidRating($rating)) {
        header("location: ../item.php?type=".$type."&id=".$id."&error=invalidrating");
        exit();
    }

    if($date) {
        createEntry($conn, $rating, 0, $user_id, $type, $id, 0, $date, 0);
    } else {
        rate($conn, $user_id, $type, $id, $rating, 0);
    }
}
else {
    header("location: ../signup.php");
    exit();
}