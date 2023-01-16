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
            // $sql = "SELECT 
            // `entries`.`user_id` AS `user_id`, 
            // `users`.`uid` AS `user_uid`, 
            // `users`.`name` AS `username`, 
            // `entries`.`like` AS `like`, 
            // `entries`.`rating` AS `rating`, 
            // `entries`.`item_id` AS `item_id`, 
            // `entries`.`log_date` AS `log_date`, 
            // `entries`.`review_date` AS `review_date`, 
            // `entries`.`rewatch` AS `rewatch`, 
            // `entries`.`spoilers` AS `spoilers`, 
            // `items`.`type` AS `item_type`, 
            // `items`.`uid` AS `item_uid`, 
            // `items`.`name` AS `item_name`, 
            // `items`.`year` AS `item_year`
            // FROM `entries` 
            // INNER JOIN `items` ON `items`.`id` = `entries`.`item_id` 
            // INNER JOIN `follow` ON `follow`.`to_id` = `entries`.`user_id` 
            // INNER JOIN `users` ON `users`.`id` = `follow`.`to_id` 
            // WHERE `follow`.`to_id` IN $marks AND 
            // (CASE 
            // WHEN `log_date` IS NULL THEN `review_date` >= '$date_lim' 
            // WHEN `review_date` > `log_date` THEN `review_date` >= '$date_lim' 
            // WHEN `review_date` IS NULL THEN `log_date` >= '$date_lim' 
            // WHEN `log_date` > `review_date` THEN `log_date` >= '$date_lim' 
            // END) 
            // ORDER BY 
            // (CASE 
            // WHEN `log_date` IS NULL THEN `review_date` 
            // WHEN `review_date` > `log_date` THEN `review_date` 
            // WHEN `review_date` IS NULL THEN `log_date` 
            // WHEN `log_date` > `review_date` THEN `log_date` 
            // END) 
            // LIMIT 19;";
            $sql = "SELECT 
            `logs`.`user_id` AS `user_id`, 
            `users`.`uid` AS `user_uid`, 
            `users`.`name` AS `username`, 
            `logs`.`date` AS `date`, 
            `logs`.`like` AS `like`, 
            `logs`.`rating` AS `rating`, 
            `logs`.`rewatch` AS `rewatch`, 
            '' AS `review_text`, 
            0 AS `spoilers`, 
            `logs`.`item_id` AS `item_id`, 
            `items`.`type` AS `item_type`, 
            `items`.`uid` AS `item_uid`, 
            `items`.`name` AS `item_name`, 
            `items`.`year` AS `item_year` 
            FROM `logs` 
            INNER JOIN `items` ON `items`.`id` = `logs`.`item_id` 
            INNER JOIN `follow` ON `follow`.`to_id` = `logs`.`user_id` 
            INNER JOIN `users` ON `users`.`id` = `follow`.`to_id`   
            WHERE `follow`.`to_id` IN $marks 
            UNION 
            SELECT 
            `reviews`.`user_id` AS `user_id`, 
            `users`.`uid` AS `user_uid`, 
            `users`.`name` AS `username`, 
            `reviews`.`date` AS `date`, 
            `reviews`.`like` AS `like`, 
            `reviews`.`rating` AS `rating`, 
            0 AS `rewatch`, 
            `reviews`.`text` AS `review_text`, 
            `reviews`.`spoilers` AS `spoilers`, 
            `reviews`.`item_id` AS `item_id`, 
            `items`.`type` AS `item_type`, 
            `items`.`uid` AS `item_uid`, 
            `items`.`name` AS `item_name`, 
            `items`.`year` AS `item_year` 
            FROM `reviews` 
            INNER JOIN `items` ON `items`.`id` = `reviews`.`item_id` 
            INNER JOIN `follow` ON `follow`.`to_id` = `reviews`.`user_id` 
            INNER JOIN `users` ON `users`.`id` = `follow`.`to_id` 
            WHERE `follow`.`to_id` IN $marks AND `date` >= '$date_lim' 
            ORDER BY `date` DESC
            LIMIT 19;";

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: /?error=stmtfailed");
                exit();
            }
        
            $param_str = str_repeat("i", 2*$num);

            mysqli_stmt_bind_param($stmt, $param_str, ...$following, ...$following);
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