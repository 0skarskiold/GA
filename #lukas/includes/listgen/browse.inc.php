<?php

// require_once($_SERVER['DOCUMENT_ROOT']."/includes/dbh.inc.php"); // behövs inte eftersom den inkluderas ovanför i browse.php
require_once("list_functions.inc.php");

$genres = retrieveGenres($conn);
$tags = retrieveTags($conn);

switch ($_GET["sortby"]) {
    case "rating-hi":
        $factor = "`items`.`rating`";
        $order = "DESC";
        break;
    case "rating-lo":
        $factor = "`items`.`rating`";
        $order = "ASC";
        break;
    case "popularity":
        $factor = "`items`.`completions`";
        $order = "DESC";
        break;
    case "popularity-week":
        $factor = "`items`.`completions_week`";
        $order = "DESC";
        break;
    case "title":
        $factor = "`items`.`name`";
        $order = "ASC";
        break;
    default:
        $factor = "`items`.`completions`";
        $order = "DESC";
        break;
}

if(isset($_GET["tag"]) && $_GET["tag"] !== "any") {
    $tag = $_GET["tag"];
} else {
    $tag = false;
}

if(isset($_GET["genre"]) && $_GET["genre"] !== "any") {
    $genre = $_GET["genre"];
} else {
    $genre = false;
}

if(isset($_GET["year"]) && $_GET["year"] !== "any") {
    $year = $_GET["year"];
} else {
    $year = false;
}

if(isset($_GET["search"])) {
    $search = $_GET["search"];
} else {
    $search = false;
}

$types = [];
if(isset($_GET["type--feature-film"])) {
    array_push($types,"feature_film");
}
if(isset($_GET["type--short-film"])) {
    array_push($types,"short_film");
}
if(isset($_GET["type--series"])) {
    array_push($types,"series");
}
if(isset($_GET["type--mini-series"])) {
    array_push($types,"mini_series");
}
if(isset($_GET["type--season"])) {
    array_push($types,"season");
}
if(isset($_GET["type--episode"])) {
    array_push($types,"episode");
}
if(isset($_GET["type--game"])) {
    array_push($types,"game");
}
if($types === []) {
    $types = false;
}

$items = retrieveSortedList($conn, $search, $types, $year, $genre, $tag, $factor, $order, 160);