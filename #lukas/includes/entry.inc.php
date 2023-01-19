<?php

$entry_id = $_GET['id'];

$sql = "SELECT * FROM `entries` WHERE `id` = ? LIMIT 1;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $entry_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$entry = mysqli_fetch_assoc($result);
mysqli_free_result($result);