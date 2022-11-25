<?php

$type = str_replace("-","_",$_GET['type']);
$uid = $_GET['uid'];

$sql = "SELECT * FROM `items` WHERE `type` = '".$type."' AND `uid` = '".$uid."' LIMIT 1;";

$result = mysqli_query($conn, $sql);

$item = mysqli_fetch_assoc($result);

mysqli_free_result($result);

$sql = "SELECT `genres`.`name` FROM `genres` 
INNER JOIN `attach_items_genres` 
    ON `genres`.`id` = `attach_items_genres`.`genre_id` 
INNER JOIN `items` 
    ON `attach_items_genres`.`item_id` = `items`.`id` 
WHERE `attach_items_genres`.`item_id` = ".$item['id'].";";

$result = mysqli_query($conn, $sql);

$genres = mysqli_fetch_array($result);

mysqli_free_result($result);

?>