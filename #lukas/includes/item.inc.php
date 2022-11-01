<?php

$type = ucfirst($_GET['type']);
$id = $_GET['id'];

$sql = "SELECT * FROM `items` WHERE `type` = '$type' AND `id` = $id LIMIT 1;";

$result = mysqli_query($conn, $sql);

$item = mysqli_fetch_assoc($result);

mysqli_free_result($result);

?>