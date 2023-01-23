<?php

// function like($conn, $user_id, $entry_id) {

//     $stmt = mysqli_stmt_init($conn);
//     $sql = "INSERT INTO `review_likes` (`user_id`, `entry_id`) VALUES (?, ?);";
    
//     if(!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: /?error=stmtfailed");
//         exit();
//     }
    
//     mysqli_stmt_bind_param($stmt, "ii", $user_id, $entry_id);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);

// }

// function unlike($conn, $user_id, $entry_id) {
    
//     $stmt = mysqli_stmt_init($conn);
//     $sql = "DELETE FROM `review_likes` WHERE `user_id` = ? AND `entry_id` = ?;";
    
//     if(!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: /?error=stmtfailed");
//         exit();
//     }
    
//     mysqli_stmt_bind_param($stmt, "ii", $user_id, $entry_id);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
// }


// $entry_id = intval($_POST['entry_id']);
// $user_id = intval($_POST['user_id']);

// if($_POST['action'] === "like") {
//     like($conn, $user_id, $entry_id);
// } elseif($_POST['action'] === "unlike") {
//     unlike($conn, $user_id, $entry_id);
// }