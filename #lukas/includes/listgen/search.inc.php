<?php

if(isset($_POST['submit'])){

    unset($_SESSION['items']);

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $sql = "SELECT * FROM `items` WHERE `name` LIKE '%$search%' OR `date` LIKE '%$search%' LIMIT 100;";

    $result = mysqli_query($conn, $sql);

    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    session_start();
    $_SESSION['items'] = $items;

    header("location: /browse/search");
}