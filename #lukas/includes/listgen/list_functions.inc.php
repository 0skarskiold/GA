<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
// argument 1: koppling till databasen
// argument 2: item:ets typ, dvs film, serie eller spel
// argument 3: faktorn listan sorteras utefter
// argument 4: ordning. ASC innebär ascending, nerifrån och upp, medan DESC innebär descending, uppifrån och ner
// argument 5: gräns för arrayen. vi behöver inga oändliga listor
function retrieveSortedList($conn, $type, $factor, $order, $lim, $year, $add) {
    
    if ($year[-1] == "s") {
        $tmp = rtrim($year, "s");
        $decade = "";
        for($y = 0; $y < 10; $y++){
            if($y != 10){
                $decade += "'%".$tmp+$y."%' OR ";
            } else {
                $decade += "'%".$tmp+$y."%'";
            } 
        }
        $year = $decade;
    }

    // switch ($add) {
    //     case "11":
    //         $sql = 
    //         "SELECT * FROM 
    //         `seasons` WHERE `date` LIKE $year AND FROM 
    //         `episodes` WHERE `date` LIKE $year AND FROM 
    //         `items` WHERE `date` LIKE $year 
    //         ORDER BY '$factor' $order LIMIT $lim;";
    //         break;
    //     case "10":
    //         $sql = 
    //         "SELECT * FROM 
    //         `seasons` WHERE `date` LIKE $year AND FROM 
    //         `episodes` WHERE `date` LIKE $year AND FROM 
    //         `items` WHERE `date` LIKE $year 
    //         ORDER BY '$factor' $order LIMIT $lim;";
    //         break;
    //     case "01":
    //         $sql = 
    //         "SELECT * FROM 
    //         `episodes` WHERE `date` LIKE $year AND FROM 
    //         `items` WHERE `date` LIKE $year 
    //         ORDER BY '$factor' $order LIMIT $lim;";
    //         break;
    //     default:
    //         break;
    // }

    if ($type == "*" && $year == "*") {
        $sql = "SELECT * FROM `items` ORDER BY '$factor' $order LIMIT $lim;";
    } elseif ($type != "*" && $year != "*") {
        $sql = "SELECT * FROM `items` WHERE `type` = '$type' AND `date` LIKE $year ORDER BY '$factor' $order LIMIT $lim;";
    }

    // utför query, hämtar resultat
    $result = mysqli_query($conn, $sql);

    // skapar arrayen
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $items;
}