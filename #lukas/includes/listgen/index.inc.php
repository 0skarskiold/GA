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

    if(isset($following) && $num = count($following) > 0) {

        $marks = "(".str_repeat("?, ", $num-1)."?)";

        $sql = "SELECT 
        `entries`.`user_id` AS `user_id`, 
        `users`.`uid` AS `user_uid`, 
        `users`.`name` AS `username`, 
        `entries`.`id` AS `entry_id`, 
        `entries`.`like` AS `like`, 
        `entries`.`rating` AS `rating`, 
        `entries`.`item_id` AS `item_id`, 
        `entries`.`log_date` AS `log_date`, 
        `entries`.`review_date` AS `review_date`, 
        IF(
            `review_date` IS NULL, `log_date`, IF(
                `log_date` IS NULL, `review_date`, IF(
                    `log_date` >= `review_date`, `log_date`, `review_date`
                )
            )
        ) AS `main_date`, 
        -- ROW_NUMBER() OVER (PARTITION BY `user_id` ORDER BY `main_date` DESC) AS `count_user_id`, -- funkar inte whyyyy
        -- COUNT(*) AS `n`, -- funkar inte whyyyy
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
        WHERE `follow`.`to_id` IN $marks 
        ORDER BY `main_date` DESC 
        LIMIT 200 -- hade hellre haft 19 här men kan inte då vi inte vill ha dubletter, och har inte lyckats ta bort de direkt i query:n, så eftersom de ska tas bort efter att query:n körts så behöver vi hämte fler än vad som troligen behövs
        ;";
    
        $param_str = str_repeat("i", $num);

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }    
        mysqli_stmt_bind_param($stmt, $param_str, ...$following);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $recent = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        foreach($recent as $k1 => $r) { // pilen gör k1 till index för r1
            for($k2=$k1+1; $k2<count($recent);$k2++) {
                if($r['user_id'] == $recent[$k2]['user_id']) {
                    unset($recent[$k2]);
                }
                if($k1 > 19 && count($recent[0...$k1]) >= 19) {
                    $tmp = $recent[0\...$k1];
                    if() {

                    }
                    $tmp = $recent[0...$k1];
                    exit();
                }
            }
        }
        $i=0;
        $arr = [];
        while($i<19) {
            if(in_array($recent[$i]['user_id'], $arr)) {
                $arr += $recent[$i]['user_id'];
                unset
            }
            
        }

        $recent = $tmp;

        foreach($recent as $k1 => $r) {

            if(isset($recent[$k1])) {

                if(isset($r['log_date'])) {

                    $t = strtotime($r['log_date']);
                    $log_date = date('Y-m-d', $t);

                    if(isset($r['review_date'])) {

                        $t = strtotime($r['review_date']);
                        $review_date = date('Y-m-d', $t);

                        $entry_type = 'full';

                        if($r['review_date'] > $r['log_rate']) {
                            $date_str = 'Reviewed '.$review_date;
                        } elseif($r['log_rate'] > $r['review_date']) {
                            $date_str = 'Logged '.$log_date;
                        } else {
                            $date_str = 'Logged and reviewed '.$review_date;
                        }

                    } else {

                        $entry_type = 'log';
                        $date_str = 'Logged '.$log_date;
                    }
                } else {

                    $t = strtotime($r['review_date']);
                    $review_date = date('Y-m-d', $t);

                    $entry_type = 'review';
                    $date_str = 'Reviewed '.$review_date;

                }

                $recent[$k1]['entry_type'] = $entry_type;
                $recent[$k1]['date_string'] = $date_str;
            }
        }
    }

    return $recent;
}

$recent = fetchRecent($conn, $_SESSION['userid']);