<?php

$type = str_replace("-","_",$_GET['type']);
$uid = $_GET['uid'];

$select = "`items`.`id`, `items`.`name`, `items`.`name`, `items`.`name`, `items`.`name`, `items`.`name`";
$sql = "SELECT ".$selelct." FROM `items` INNER JOIN `";

$result = mysqli_query($conn, $sql);

$item = mysqli_fetch_assoc($result);

mysqli_free_result($result);

?>