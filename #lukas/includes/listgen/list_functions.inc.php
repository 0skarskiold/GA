<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
function retrieveSortedList($conn, $search, $types, $year, $genre, $tag, $artist, $collection, $factor, $order, $lim) {
    
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


    $stmt = mysqli_stmt_init($conn);

    $select = "`items`.`id`, `items`.`name`, `items`.`type`, `items`.`uid`, `items`.`year`";
    $from = "FROM `items`";
    $where = "";
    $values = [];


    if($genre) {
        $from .= " INNER JOIN `items_genres` ON `items`.`id` = `items_genres`.`item_id`";
        $where = "WHERE `items_genres`.`genre_id` = ?";
        array_push($values,$genre); 
    }
    if($tag) {
        $from .= " INNER JOIN `items_tags` ON `items`.`id` = `items_tags`.`item_id`";
        if($where !== "") {
            $where .= " AND `items_tags`.`tag_id` = ?";
        } else {
            $where = "WHERE `items_tags`.`tag_id` = ?";
        }
        array_push($values,$tag); 
    }
    if($artist) {
        $from .= " INNER JOIN `items_crew` ON `items`.`id` = `items_crew`.`item_id`";
        if($where !== "") {
            $where .= " AND `items_crew`.`artist_id` = ?";
        } else {
            $where = "WHERE `items_crew`.`artist_id` = ?";
        }
        array_push($values,$artist); 
    }
    if($collection) {
        $from .= " INNER JOIN `items_collections` ON `items`.`id` = `items_collections`.`item_id`";
        if($where !== "") {
            $where .= " AND `items_collections`.`collection_id` = ?";
        } else {
            $where = "WHERE `items_collections`.`collection_id` = ?";
        }
        array_push($values,$collection); 
    }


    if($search) {
        if($where !== "") {
            $where .= " AND `items`.`name` LIKE ?";
        } else {
            $where = "WHERE `items`.`name` LIKE ?";
        }
        $search_str = "'%".$search."%'";
        array_push($values,$search_str); 
    }
    if($types) {
        $tmp = "IN (".str_repeat('?, ', count($types)-1)."?)";
        // $types_str = "IN ('".implode("','", $types)."')";
        if($where !== "") {
            $where .= " AND `items`.`type` ".$tmp;
        } else {
            $where = "WHERE `items`.`type` ".$tmp;
        }
        array_push($values,$types);
    }
    if($year) {
        if($year[-1] === "s") {
            $tmp = intval(rtrim($year, "s"));
            $years = [];
            for($y = 0; $y <= 9; $y++) { array_push($years, $tmp+$y); }
            $tmp = "IN (".str_repeat('?, ', 9)."?)";
        } else {
            $years = $year;
            $tmp = "= ?";
        }
        if($where !== "") {
            $where .= " AND `items`.`year` ".$tmp;
        } else {
            $where = "WHERE `items`.`year` ".$tmp;
        }
        array_push($values,$years);
    }


    $sql = "SELECT ".$select." ".$from." ".$where." ORDER BY ".$factor." ".$order." LIMIT ".$lim.";";


    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }
    $val_types = "";
    foreach($values as $val) {
        if(gettype($val) === "integer") {
            $val_types .= "i";
        } elseif(gettype($val) === "string") {
            $val_types .= "s";
        } elseif(gettype($val) === "float") {
            $val_types .= "f";
        } else {
            header("location: /?error=stmtfailed");
            exit();
        }
    }
    if(strlen($val_types) > 0) { mysqli_stmt_bind_param($stmt, $val_types, ...$values); }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
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

function retrieveUsers($conn, $search, $factor, $order, $lim) {

    $sql = "SELECT `id`, `name`, `uid` FROM `users` ORDER BY `name`;";

    $result = mysqli_query($conn, $sql);

    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $users;

}