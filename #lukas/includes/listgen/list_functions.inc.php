<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
function retrieveSortedList($conn, $types, $year, $factor, $order, $lim) {

    // validering
    if($order !== "DESC" && $order !== "ASC") {
        // meddelande?
        exit();
    }

    $filter_str = "";

    if($types !== "any" && is_array($types)) {

        $t = "";
        foreach($types as &$type) {
            if($type !== array_key_last($types)) {
                $t += $type." OR `type` = ";
            } else {
                $t += $type;
            }
        }

        $filter_str += "WHERE `type` = ".$t;

    }

    if($year !== "any") {

        if($year[-1] === "s") {

            $tmp = intval(rtrim($year, "s"));
            $decade = "";

            for($y = 0; $y < 9; $y++) {
                $decade += "'%".strval($tmp + $y)."%' OR `year` LIKE ";
            }

            $year = $decade."'%".strval($tmp + $y)."%'";

        } else {
            $tmp = $year;
            $year = "'%".$tmp."%'";
        }

        if($filter_str !== "") {
            $filter_str += " AND WHERE `year` LIKE ".$year;
        } else {
            $filter_str += "WHERE `year` LIKE ".$year;
        }
        
    }

    $select = "`id`, `name`, `type`, `url_name`, `year`, `rating`";

    $sql = "SELECT ".$select." FROM `items` ".$filter_str." ORDER BY ".$factor." ".$order." LIMIT ".$lim.";";

    // utför query, hämtar resultat
    $result = mysqli_query($conn, $sql);

    // skapar arrayen
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $items;
}