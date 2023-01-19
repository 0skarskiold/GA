<?php
$user_uid = $_GET['user_uid'];

$sql = "SELECT `entries`.*, 
`items`.`name` AS `item_name`, 
`items`.`year` AS `item_year`, 
`items`.`uid` AS `item_uid`, 
`items`.`type` AS `item_type`
FROM `entries` 
INNER JOIN `users` ON `entries`.`user_id` = `users`.`id` 
INNER JOIN `items` ON `entries`.`item_id` = `items`.`id` 
WHERE `log_date` IS NOT NULL AND `users`.`uid` = ? 
ORDER BY `log_date`;";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $user_uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$diary_entries = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);