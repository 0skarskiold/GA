<?php

if(isset($_GET['submit-search'])){

    if (empty($_GET["search"])) {
        header("location: /search?error=emptyinput");
        exit();
    }

    unset($_SESSION['items']);

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM `items` WHERE `name` LIKE '%$search%' OR `date` LIKE '%$search%' LIMIT 160;";

    $result = mysqli_query($conn, $sql);

    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    session_start();
    $_SESSION['items'] = $items;

    header("location: /search/".$_GET["search"]);
    exit();

} else {
    header("location: /");
    exit();
}