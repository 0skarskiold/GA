<?php

unset($_SESSION['items']);

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
require_once 'list_functions.inc.php';

if (isset($_GET['submit-browse'])){

    $sortBy = $_GET["sortby"];
    $types = $_GET["types"]; #array
    $genre = $_GET["genre"];
    $year = $_GET["year"];

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
        if ($_GET["seasons"] == "on") {
            $add[0] = "1";
        } 
        if ($_GET["episodes"] == "on") {
            $add[1] = "1";
        }
    }

    $items = retrieveSortedList($conn, $type, $factor, $order, 160, $year, $add);

} else {

    $items = retrieveSortedList($conn, "*", "rating", "desc", 160, "*", "00");

    exit();

}