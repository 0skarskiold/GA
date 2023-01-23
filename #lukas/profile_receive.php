<?php

function followUser($conn, $from_id, $to_id) {

    $sql = 
    "INSERT INTO `follow` (`from_id`, `to_id`) 
    VALUES (?, ?);";
    
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function unfollowUser($conn, $from_id, $to_id) {
    
    $sql = 
    "DELETE FROM `follow` 
    WHERE `from_id` = ? AND `to_id` = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// $to_id = intval($_POST['to_id']);
// $from_id = intval($_POST['from_id']);

// if($_POST['action'] === "follow") {
//     followUser($conn, $from_id, $to_id);
// } elseif($_POST['action'] === "unfollow") {
//     unfollowUser($conn, $from_id, $to_id);
// }