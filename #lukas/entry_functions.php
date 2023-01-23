<?php

function fetchEntry($conn, $entry_id, $user_id) {

    if(isset($user_id)) {
        $str = "SELECT COUNT(*) 
        FROM `review_likes` 
        WHERE `entry_id` = ? AND `user_id` = ? 
        LIMIT 1";

        $subsql = ",(".$str.") AS `liked`";
    }

    $sql = "SELECT * $subsql 
    FROM `entries` 
    WHERE `id` = ? 
    LIMIT 1;";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }

    if(isset($user_id)) {
        mysqli_stmt_bind_param($stmt, "iii", $entry_id, $user_id, $entry_id);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $entry_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $entry = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $entry;
}

function fetchReviews($conn, $user_uid) {

    $sql = "SELECT `entries`.*, 
    `items`.`name` AS `item_name`, 
    `items`.`year` AS `item_year`, 
    `items`.`uid` AS `item_uid`, 
    `items`.`type` AS `item_type`
    FROM `entries` 
    INNER JOIN `users` ON `entries`.`user_id` = `users`.`id` 
    INNER JOIN `items` ON `entries`.`item_id` = `items`.`id` 
    WHERE `review_date` IS NOT NULL AND `users`.`uid` = ? 
    ORDER BY `review_date`;";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $user_uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $reviews;
}

function fetchDiary($conn, $user_uid) {

    $sql = "SELECT `entries`.*, 
    `items`.`name` AS `item_name`, 
    `items`.`year` AS `item_year`, 
    `items`.`uid` AS `item_uid`, 
    `items`.`type` AS `item_type`
    FROM `entries` 
    INNER JOIN `users` ON `entries`.`user_id` = `users`.`id` 
    INNER JOIN `items` ON `entries`.`item_id` = `items`.`id` 
    WHERE `log_date` IS NOT NULL AND `users`.`uid` = ? 
    ORDER BY `log_date`;";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $user_uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $diary = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $diary;
}