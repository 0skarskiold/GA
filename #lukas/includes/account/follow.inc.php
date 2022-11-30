<?php

$id = $_GET['id'];
$stmt = mysqli_stmt_init($conn);

if(isset($_POST['follow'])) {
    $sql = "INSERT INTO `follow` (`from_id`, `to_id`) VALUES (?, ?);";
} elseif(isset($_POST['follow'])) {
    $sql = "DELETE FROM `follow` WHERE `from_id` = ? AND `to_id = ?;";
}

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "ss", $_SESSION['id'], $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

unset($_POST['follow']);