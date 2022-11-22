<?php

// require_once($_SERVER['DOCUMENT_ROOT']."/includes/dbh.inc.php"); // behövs inte eftersom den inkluderas ovanför i browse.php
require_once("list_functions.inc.php");

if (isset($_GET["submit-browse"])){

    $sortby = $_GET["sortby"];
    $genre = $_GET["genre"];
    $year = $_GET["year"];

    if($_GET["subgenre"] !== "any") {
        $genre = "subgenre_".$_GET["subgenre"];
    }

    if (isset($_GET["type_any"])){
        $types = "any";
    } else {
        $types = [];
        if (isset($_GET["type_feature_film"])){
            array_push($types,"feature_film");
        }
        if (isset($_GET["type_short_film"])){
            array_push($types,"short_film");
        }
        if (isset($_GET["type_series"])){
            array_push($types,"series");
        }
        if (isset($_GET["type_mini_series"])){
            array_push($types,"mini_series");
        }
        if (isset($_GET["type_season"])){
            array_push($types,"season");
        }
        if (isset($_GET["type_episode"])){
            array_push($types,"episode");
        }
        if (isset($_GET["type_game"])){
            array_push($types,"game");
        }
        if ($types === []){
            $types = "any";
        }
    }

    switch ($sortby) {
        case "rating_hi":
            $factor = "`rating`";
            $order = "DESC";
            break;
        case "rating_lo":
            $factor = "`rating`";
            $order = "ASC";
            break;
        case "popularity":
            $factor = "`completions`";
            $order = "DESC";
            break;
        case "popularity_week":
            $factor = "`completions_week`";
            $order = "DESC";
            break;
        case "title":
            $factor = "`name`";
            $order = "DESC";
            break;
        default:
            $factor = "`completions`";
            $order = "DESC";
            break;
    }

    $items = retrieveSortedList($conn, $search, $types, $year, $genre, $factor, $order, 160);

} else {

    $items = retrieveSortedList($conn, "any", "any", "any", "any", "`rating`", "DESC", 160);

}