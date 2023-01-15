<?php

function fetchRecent($conn, $user_id) {

    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT `to_id` FROM `follow` WHERE `from_id` = ?;";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $following = mysqli_fetch_row($result);
    mysqli_free_result($result);

    if(isset($following[0])) {
        $num = count($following);
        if($num > 0) {

            $stmt = mysqli_stmt_init($conn);
            if($num >= 2) { $marks = "(?".str_repeat(",?", $num-1).")"; } else { $marks = "(?)"; }
            $date_lim = date('Y-m-d H:i:s', strtotime('-1 week')); // gör h:i:s till 00:00:00
            $sql = "SELECT 
            `entries`.`user_id` AS `user_id`, 
            `users`.`uid` AS `user_uid`, 
            `users`.`name` AS `username`, 
            `entries`.`like` AS `like`, 
            `entries`.`rating` AS `rating`, 
            `entries`.`item_id` AS `item_id`, 
            `entries`.`log_date` AS `log_date`, 
            `entries`.`review_date` AS `review_date`, 
            `entries`.`rewatch` AS `rewatch`, 
            `entries`.`spoilers` AS `spoilers`, 
            `items`.`type` AS `item_type`, 
            `items`.`uid` AS `item_uid`, 
            `items`.`name` AS `item_name`, 
            `items`.`year` AS `item_year`
            FROM `entries` 
            INNER JOIN `items` ON `items`.`id` = `entries`.`item_id` 
            INNER JOIN `follow` ON `follow`.`to_id` = `entries`.`user_id` 
            INNER JOIN `users` ON `users`.`id` = `follow`.`to_id` 
            WHERE `follow`.`to_id` IN $marks AND 
            (CASE 
            WHEN `log_date` IS NULL THEN `review_date` >= '$date_lim' 
            WHEN `review_date` > `log_date` THEN `review_date` >= '$date_lim' 
            WHEN `review_date` IS NULL THEN `log_date` >= '$date_lim' 
            WHEN `log_date` > `review_date` THEN `log_date` >= '$date_lim' 
            END) 
            ORDER BY 
            (CASE 
            WHEN `log_date` IS NULL THEN `review_date` 
            WHEN `review_date` > `log_date` THEN `review_date` 
            WHEN `review_date` IS NULL THEN `log_date` 
            WHEN `log_date` > `review_date` THEN `log_date` 
            END) 
            LIMIT 19;";

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: /?error=stmtfailed");
                exit();
            }
        
            $param_str = str_repeat("i", $num);

            mysqli_stmt_bind_param($stmt, $param_str, ...$following);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            $recent = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);

        }
    }

    return $recent;
}

$recent = fetchRecent($conn, $_SESSION['userid']);