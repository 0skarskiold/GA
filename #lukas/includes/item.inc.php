<?php

$type = str_replace("-","_",$_GET['type']);
$uid = $_GET['uid'];

$sql = "SELECT * FROM `items` WHERE `type` = '".$type."' AND `uid` = '".$uid."' LIMIT 1;";

$result = mysqli_query($conn, $sql);

$item = mysqli_fetch_assoc($result);

mysqli_free_result($result);

?>