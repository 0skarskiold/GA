<?php

if (isset($_GET['type'])) {

    $get_type = mysqli_real_escape_string($conn, $_GET['type']);

    if ($get_type == "all") { // case istället
        $type = "*";
    } else if ($get_type == "films") {
        $type = "Film";
    } else if ($get_type == "shortfilms") {
        $type = "ShortFilm";
    } else if ($get_type == "series") {
        $type = "Series";
    } else if ($get_type == "miniseries") {
        $type = "MiniSeries";
    } else if ($get_type == "games") {
        $type = "Game";
    } // seasons?

    require_once("listgen_functions.inc.php");
    $items = retrieveSortedList($conn, $type, "rating", "desc", 160);

} else if (isset($_POST['submit-search'])) {

    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $sql = "SELECT * FROM `items` WHERE `name` LIKE '%$search%' OR `date` LIKE '%$search%';";

    $result = mysqli_query($conn, $sql);

    // $count = mysqli_num_rows($result); -- ifall man vill ge ett meddelande om det inte blir några resultat eller säga hur många resultat det blev

    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

}