<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
function retrieveSortedList($conn, $search, $types, $year, $genre, $factor, $order, $lim) {

    // validering
    if($order !== "DESC" && $order !== "ASC") {
        header("location: /browse?error=order");
        exit();
    }
    if(is_array($types)) {
        foreach($types as $type) {
            $enum = ['feature_film','short_film','series','season','episode','mini_series','game','other'];
            if(!in_array($type,$enum,true)) { // om type inte finns i listan
                header("location: /browse?error=type");
                exit();
            }
        }
    }

    $filter_str = "";

    if($search !== "any") {
        $filter_str = " WHERE `name` OR `year` LIKE '%".$search."%'"; // kan man använda or såhär?
    }

    // fixar sql-string för typ -- lägg till validering som kollar om alla element är vad som står inom enum på databasen
    if($types !== "any") {
        $types_str = " IN ('".implode("','", $types)."')";
        if($filter_str !== "") {
            $filter_str .= " AND WHERE  `type`".$types_str;
        } else {
            $filter_str = " WHERE `type`".$types_str;
        }
    }

    // fixar sql-string för årtal
    if($year !== "any") {
        if($year[-1] === "s") {
            $tmp = intval(rtrim($year, "s"));
            $decade = " IN (";
            for($y = 0; $y < 9; $y++) {
                $decade .= strval($tmp + $y).", ";
            }
            $year = $decade.strval($tmp + 9).")";
        } else {
            $tmp = $year;
            $year = "=".$tmp;
        }
        if($filter_str !== "") {
            $filter_str .= " AND WHERE `year`".$year;
        } else {
            $filter_str = " WHERE `year`".$year;
        }
    }

    if($genre !== "any") {
        if($filter_str !== "") {
            $filter_str .= " AND INNER JOIN `attach_items_genres` ON `items`.`id` = `attach_items_genres`.`item_id` INNER JOIN `genres` ON `attach_items_genres`.`genre_id` = `genres`.`id` WHERE `genres`.`id` = ".$genre.";";
        } else {
            $filter_str = " INNER JOIN `attach_items_genres` ON `items`.`id` = `attach_items_genres`.`item_id` INNER JOIN `genres` ON `attach_items_genres`.`genre_id` = `genres`.`id` WHERE `genres`.`id` = ".$genre.";";
        }
    }

    $select = "`id`, `name`, `type`, `uid`, `year`, `rating`";

    $sql = "SELECT ".$select." FROM `items`".$filter_str." ORDER BY ".$factor." ".$order." LIMIT ".$lim.";";

    // utför query, hämtar resultat
    $result = mysqli_query($conn, $sql);

    // skapar arrayen
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $items;
}