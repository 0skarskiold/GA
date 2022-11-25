<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
function retrieveSortedList($conn, $search, $types, $year, $genre, $tag, $factor, $order, $lim) {
    
    // validering
    if($order !== "DESC" && $order !== "ASC") {
        header("location: /?error=order");
        exit();
    }
    if($types) {
        foreach($types as $type) {
            $enum = ['feature_film','short_film','series','season','episode','mini_series','game','other'];
            if(!in_array($type,$enum,true)) { // om type inte finns i listan
                header("location: /?error=type");
                exit();
            }
        }
    }

    $select = "`items`.`id`, `items`.`name`, `items`.`type`, `items`.`uid`, `items`.`year`";
    $from = "FROM `items`";
    $where = "";

    if($genre) {
        $from .= " INNER JOIN `items_genres` ON `items`.`id` = `items_genres`.`item_id`";
        $where = "WHERE `items_genres`.`genre_id` = ".$genre;
    }
    if($tag) {
        $from .= " INNER JOIN `items_tags` ON `items`.`id` = `items_tags`.`item_id`";
        if($where !== "") {
            $where .= " AND WHERE `items_tags`.`tag_id` = ".$tag;
        } else {
            $where = "WHERE `items_tags`.`tag_id` = ".$tag;
        }
    }

    if($search) {
        if($where !== "") {
            $where .= " AND WHERE `name` LIKE '%".$search."%'";
        } else {
            $where = "WHERE `name` LIKE '%".$search."%'";
        }
    }

    // fixar sql-string för typ -- lägg till validering som kollar om alla element är vad som står inom enum på databasen
    if($types) {
        $types_str = "IN ('".implode("','", $types)."')";
        if($where !== "") {
            $where .= " AND WHERE `type` ".$types_str;
        } else {
            $where = "WHERE `type` ".$types_str;
        }
    }

    // fixar sql-string för årtal
    if($year) {
        if($year[-1] === "s") {
            $tmp = intval(rtrim($year, "s"));
            $decade = "IN (";
            for($y = 0; $y < 9; $y++) {
                $decade .= strval($tmp + $y).", ";
            }
            $year = $decade.strval($tmp + 9).")";
        } else {
            $tmp = $year;
            $year = "= ".$tmp;
        }
        if($where !== "") {
            $where .= " AND WHERE `year` ".$year;
        } else {
            $where = "WHERE `year` ".$year;
        }
    }

    $sql = "SELECT ".$select." ".$from." ".$where." ORDER BY ".$factor." ".$order." LIMIT ".$lim.";";

    // utför query, hämtar resultat
    $result = mysqli_query($conn, $sql);

    // skapar arrayen
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $items;
}

function retrieveGenres($conn) {

    $sql = "SELECT * FROM `genres` ORDER BY `name`;";

    $result = mysqli_query($conn, $sql);

    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $genres;

}

function retrieveTags($conn) {

    $sql = "SELECT * FROM `tags` ORDER BY `name`;";

    $result = mysqli_query($conn, $sql);

    $tags = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $tags;

}