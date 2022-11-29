<?php

$type = str_replace("-","_",$_GET['type']);
$uid = $_GET['uid'];

$select = "SELECT `items`.`id`, `items`.`name`, `items`.`year`, `items_genres`.`genre_id`, `items_tags`.`tag_id`";
$from = "FROM `items` LEFT OUTER JOIN `items_genres` ON `items`.`id` = `items_genres`.`item_id` LEFT OUTER JOIN `items_tags` ON `items`.`id` = `items_tags`.`item_id`";
$where = "WHERE `items`.`uid` = '".$uid."' AND `items`.`type` = '".$type."'";
$sql = $select." ".$from." ".$where." LIMIT 1;";

$result = mysqli_query($conn, $sql);

$item = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

// $result = mysqli_query($conn, $sql);

// $genres = mysqli_fetch_all($result, MYSQLI_ASSOC)

// mysqli_free_result($result);