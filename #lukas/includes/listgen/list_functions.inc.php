<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
// argument 1: koppling till databasen
// argument 2: item:ets typ, dvs film, serie eller spel
// argument 3: faktorn listan sorteras utefter
// argument 4: ordning. ASC innebär ascending, nerifrån och upp, medan DESC innebär descending, uppifrån och ner
// argument 5: gräns för arrayen. vi behöver inga oändliga listor
function retrieveSortedList($conn, $item_type, $factor, $order, $lim) {
    
    if ($order == "asc") {
        if ($item_type == "*") {
            $sql = "SELECT * FROM `items` ORDER BY '$factor' ASC LIMIT $lim;";
        } else {
            $sql = "SELECT * FROM `items` WHERE `type` = '$item_type' ORDER BY '$factor' ASC LIMIT $lim;";
        }
    } elseif ($order == "desc") {
        if ($item_type == "*") {
            $sql = "SELECT * FROM `items` ORDER BY '$factor' DESC LIMIT $lim;";
        } else {
            $sql = "SELECT * FROM `items` WHERE `type` = '$item_type' ORDER BY '$factor' DESC LIMIT $lim;";
        }
    }

    // utför query, hämtar resultat
    $result = mysqli_query($conn, $sql);

    // skapar arrayen
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $items;
}