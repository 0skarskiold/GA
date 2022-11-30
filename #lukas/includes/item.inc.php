<?php

// hämtar data från items
$type = str_replace("-","_",$_GET['type']);
$uid = $_GET['uid'];

$join = "";
if($type === "series") {
    $join = "INNER JOIN `attributes_series` ON `items`.`id` = `attributes_series`.`series_id` ";
}

$sql = "SELECT * FROM `items` ".$join."WHERE `uid` = ? AND `type` = ? LIMIT 1;"; // not secure, user can put anything in here, make prepared statements
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: /?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "ss", $uid, $type);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$item = mysqli_fetch_assoc($result);
mysqli_free_result($result);

// hämtar genrer
$sql = "SELECT `genres`.* FROM `genres` INNER JOIN `items_genres` ON `genres`.`id` = `items_genres`.`genre_id` WHERE `items_genres`.`item_id` = ".$item['id'].";";
$result = mysqli_query($conn, $sql);
$genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

// hämtar taggar
$sql = "SELECT `tags`.* FROM `tags` INNER JOIN `items_tags` ON `tags`.`id` = `items_tags`.`tag_id` WHERE `items_tags`.`item_id` = ".$item['id'].";";
$result = mysqli_query($conn, $sql);
$tags = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

// hämtar involverade
$sql = "SELECT `crew`.*, `items_crew`.* FROM `crew` INNER JOIN `items_crew` ON `crew`.`id` = `items_crew`.`artist_id` WHERE `items_crew`.`item_id` = ".$item['id'].";";
$result = mysqli_query($conn, $sql);
$crew = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

// hämtar samlingar
$sql = "SELECT `collections`.* FROM `collections` INNER JOIN `items_collections` ON `collections`.`id` = `items_collections`.`collection_id` WHERE `items_collections`.`item_id` = ".$item['id'].";";
$result = mysqli_query($conn, $sql);
$collections = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);