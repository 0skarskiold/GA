<?php

$entry_id = $_GET['id'];
if(isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
    $str = ", (SELECT COUNT(*) FROM `review_likes` WHERE `entry_id` = ? AND `user_id` = ?) AS `liked`";
}

$sql = "SELECT *".$str." FROM `entries` WHERE `id` = ? LIMIT 1;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

if(isset($_SESSION['userid'])) {
    mysqli_stmt_bind_param($stmt, "iii", $entry_id, $user_id, $entry_id);
} else {
    mysqli_stmt_bind_param($stmt, "i", $entry_id);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$entry = mysqli_fetch_assoc($result);
mysqli_free_result($result);