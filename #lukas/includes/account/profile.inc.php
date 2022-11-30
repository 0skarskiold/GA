<?php

$uid = $_GET['uid'];

$stmt = mysqli_stmt_init($conn);
$sql = "SELECT `id`, `name`, `uid` FROM `users` WHERE `uid` = ? ORDER BY `name` LIMIT 1;";

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_free_result($result);


$id = $user['id'];

$stmt = mysqli_stmt_init($conn);
$sql = "SELECT COUNT(`to_id`) FROM `follow` WHERE `from_id` = ? AND `to_id` = ? LIMIT 1;";

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "ss", $_SESSION['id'], $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$tmp = mysqli_fetch_row($result)[0];
mysqli_free_result($result);

if($tmp >= 1) {
    $following = true;
}