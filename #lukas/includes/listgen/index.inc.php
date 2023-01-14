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
            $sql = "SELECT `logs`.`user_id` AS `user_id`, `logs`.`date` AS `date`, `logs`.`like` AS `like`, `logs`.`rating` AS `rating`, `logs`.`rewatch` AS `rewatch`, '' AS `review_text`, 0 AS `spoilers`, `logs`.`item_id` AS `item_id`, `items`.`uid` AS `item_uid`, `items`.`name` AS `item_name`, `items`.`year` AS `item_year` 
            FROM `logs` 
            INNER JOIN `items` ON `items`.`id` = `logs`.`item_id` 
            INNER JOIN `follow` ON `follow`.`to_id` = `logs`.`user_id` 
            WHERE `follow`.`to_id` IN $marks 
            UNION 
            SELECT `reviews`.`user_id` AS `user_id`, `reviews`.`date` AS `date`, `reviews`.`like` AS `like`, `reviews`.`rating` AS `rating`, 0 AS `rewatch`, `reviews`.`text` AS `review_text`, `reviews`.`spoilers` AS `spoilers`, `reviews`.`item_id` AS `item_id`, `items`.`uid` AS `item_uid`, `items`.`name` AS `item_name`, `items`.`year` AS `item_year` 
            FROM `reviews` 
            INNER JOIN `items` ON `items`.`id` = `reviews`.`item_id` 
            INNER JOIN `follow` ON `follow`.`to_id` = `reviews`.`user_id` 
            WHERE `follow`.`to_id` IN $marks 
            ORDER BY `date` DESC;";

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