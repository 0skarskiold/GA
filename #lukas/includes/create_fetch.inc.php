<?php

$sql = "SELECT * FROM `items` WHERE `id` = ?;"; // not secure, user can put anything in here, make prepared statements
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $_GET['itemid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$item = mysqli_fetch_assoc($result);
mysqli_free_result($result);