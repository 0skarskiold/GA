<?php

unset($_SESSION['items']);

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
require_once 'list_functions.inc.php';

if (isset($_POST['submit-browse'])){

    $sortBy = $_POST["sortby"];
    $type = $_POST["type"];
    $genre = $_POST["genre"];
    $year = $_POST["year"];

    switch ($sortBy) {
        case "rating_hi":
            $factor = "rating";
            $order = "DESC";
            break;
        case "rating_lo":
            $factor = "rating";
            $order = "ASC";
            break;
        case "popularity":
            $factor = "views";
            $order = "DESC";
            break;
        case "popularity_week":
            $factor = "views_week";
            $order = "DESC";
            break;
        case "title":
            $factor = "name";
            $order = "DESC";
            break;
    }

    $add = "00";

    if ($type == "*") {
        if ($_POST["seasons"] == "on") {
            $add[0] = "1";
        } 
        if ($_POST["episodes"] == "on") {
            $add[1] = "1";
        }
    }

    $items = retrieveSortedList($conn, $type, $factor, $order, 160, $year, $add);

    session_start();
    $_SESSION['items'] = $items;

    header("location: /browse");
    exit();

} else {

    $items = retrieveSortedList($conn, "*", "rating", "desc", 160, "*", "00");

    session_start();
    $_SESSION['items'] = $items;

    header("location: /browse");
    exit();

}