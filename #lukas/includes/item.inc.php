<?php

$type = str_replace("-","_",$_GET['type']);
$uid = $_GET['uid'];

$sql = "SELECT * FROM `items` WHERE `uid` = '".$uid."' AND `type` = '".$type."' LIMIT 1;"; // not secure, user can put anything in here, make prepared statements

$result = mysqli_query($conn, $sql);

$item = mysqli_fetch_assoc($result);

mysqli_free_result($result);


$sql = "SELECT `genres`.* FROM `genres` INNER JOIN `items_genres` ON `genres`.`id` = `items_genres`.`genre_id` WHERE `items_genres`.`item_id` = ".$item['id'].";";

$result = mysqli_query($conn, $sql);

$genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);


$sql = "SELECT `tags`.* FROM `tags` INNER JOIN `items_tags` ON `tags`.`id` = `items_tags`.`tag_id` WHERE `items_tags`.`item_id` = ".$item['id'].";";

$result = mysqli_query($conn, $sql);

$tags = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);