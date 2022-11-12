<?php

// require_once($_SERVER['DOCUMENT_ROOT']."/includes/dbh.inc.php"); // behövs inte eftersom den inkluderas ovanför i browse.php
require_once("list_functions.inc.php");

if (isset($_GET["submit-browse"])){

    $sortby = $_GET["sortby"];
    $genre = $_GET["genre"];
    $year = $_GET["year"];

    if (isset($_GET["type_any"])){
        $types = "any";
    } else {
        $types = [];
        if ($_GET["type_feature_film"]){
            join($types, ["feature_film"]);
        }
        if ($_GET["type_short_film"]){
            join($types, ["short_film"]);
        }
        if ($_GET["type_series"]){
            join($types, ["series"]);
        }
        if ($_GET["type_mini_series"]){
            join($types, ["mini_series"]);
        }
        if ($_GET["type_season"]){
            join($types, ["season"]);
        }
        if ($_GET["type_episode"]){
            join($types, ["episode"]);
        }
        if ($_GET["type_game"]){
            join($types, ["game"]);
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

    $items = retrieveSortedList($conn, $types, $year, $factor, $order, 160);

} else {

    $items = retrieveSortedList($conn, "any", "any", "'rating'", "DESC", 160);

}