<?php
require_once("universal_functions.php");

function fetchRecent($conn, $user_id) { // model
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT `to_id` FROM `follow` WHERE `from_id` = ?;";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $following = mysqli_fetch_row($result);
    mysqli_free_result($result);

    if(!(isset($following) && count($following) > 0)) {
        return [];
    }

    $num = count($following);
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
        header("location: /?error");
        exit();
    }    
    mysqli_stmt_bind_param($stmt, $param_str, ...$following);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $recent = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    if(!(count($recent) > 0)) {
        return [];
    }

    // följande är för att ta bort alla förutom den senaste av de av samma användare

    $i=0;
    $arr = [];

    while($i < 19) {

        if(in_array($recent[$i]['user_id'], $arr)) {
            array_splice($recent, $i, 1);
        } else {
            $arr += [$recent[$i]['user_id']];
            $i++;
        }
        if(count($recent) <= $i) {
            break;
        }

    }

    foreach($recent as $k => $r) {
        if(isset($r['log_date'])) {

            if(isset($r['review_date'])) {

                $t = strtotime($r['log_date']);
                $log_date = date('Y-m-d', $t);

                $t = strtotime($r['review_date']);
                $review_date = date('Y-m-d', $t);

                if($r['review_date'] > $r['log_date']) {
                    $date = $review_date;
                } elseif($r['log_date'] > $r['review_date']) {
                    $date = $log_date;
                } else {
                    $date = $review_date;
                }

            } else {
                $date = date('Y-m-d', strtotime($r['log_date']));
            }
        } else {
            $date = date('Y-m-d', strtotime($r['review_date']));
        }
        $recent[$k]['date'] = $date;
    }

    return $recent;
}

function renderListRecent($recent) { // view

    if(!(count($recent) > 0)) {
        return;
    }

    $list = '';
    foreach($recent as $r) {
        $list .= prepareActivityContainer($r['username'], $r['user_uid'], $r['entry_id'], $r['rating'], $r['date'], $r['rewatch'], $r['review'], $r['spoilers'], $r['item_name'], $r['item_uid'], $r['item_year'], $r['item_type'], 'list');
    }
    if(count($recent) === 19) {
        $list .= 
        '<li class="special_container show_more">
        <a class="link show_more" href="/recent-activity">
        <p class="text">Show more</p>
        <p class="plus">+</p>
        </a>
        </li>';
    } elseif(count($recent) < 19) {
        $list .= 
        '<li class="special_container find_more">
        <a class="link find_more" href="/users">
        <p class="text">Find others to follow</p>
        <div class="plus"></div>
        </a>
        </li>';
    } else {
        header("location: /?error");
        exit;
    }

    $html =
    '<section class="list_section horizontal" list-name="recent">
    <h2>Recent</h2>
    <div class="list_container" list-name="recent">
    <div class="arrow l"></div>
    <div class="list_limits" list-name="recent">
    <ul class="list" list-name="recent">'.$list.'</ul>
    </div>
    <div class="arrow r"></div>
    </div>
    </section>';

    echo $html;
    return;
}

function fetchPopular($conn, $factor) { // model

    // validering
    if($factor !== 'week' && $factor !== 'month' && $factor !== 'all') {
        return [];
    }

    if($factor === 'all') {
        $popularity = "SELECT 
        COUNT(*) 
        FROM `ratings` 
        WHERE `ratings`.`item_id` = `items`.`id`
        ";
    } elseif($factor === 'month') {
        $date = date('Y-m-d', strtotime('-1 month'));
        $popularity = // todo: ändra så att om entry och rating är från samma tillfälle så räknas endast en av dem med
            "(SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id` AND `ratings`.`created_date` > '$date')
            + 
            (SELECT COUNT(*) FROM `entries` WHERE `entries`.`item_id` = `items`.`id` AND `entries`.`log_date` > '$date')
        ";
    } elseif($factor === 'week') {
        $date = date('Y-m-d', strtotime('-1 week'));
        $popularity = 
            "(SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id` AND `ratings`.`created_date` > '$date') 
            + 
            (SELECT COUNT(*) FROM `entries` WHERE `entries`.`item_id` = `items`.`id` AND `entries`.`log_date` > '$date')
        ";
    } else {
        return [];
    }

    $sql = "SELECT 
    `id`, 
    `name`, 
    `year`, 
    `uid`, 
    `type`, 
    ($popularity) AS `popularity` 
    FROM `items` 
    ORDER BY `popularity` DESC 
    LIMIT 19
    ;";

    $result = mysqli_query($conn, $sql);
    $popular = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $popular;
}

function renderListPopular($popular) { // view

    if(!(count($popular) > 0)) {
        return;
    }

    $list = '';
    foreach($popular as $p) {
        $list .= prepareItemContainer($p['name'], $p['uid'], $p['year'], $p['type'], 'list');
    }
    if(count($popular) === 19) {
        $list .= 
        '<li class="item_container show_more">
        <a class="item_link show_more" href="/recent-activity">
        <p class="1">Show more</p>
        <p class="2">+</p>
        </a>
        </li>';
    }

    $html =
    '<section class="list_section horizontal" list-name="popular">
    <h2>Popular</h2>
    <select name="popular-type">
    <option value="week">This week</option>
    <option value="all">All time</option>
    <option value="week">This month</option>
    </select>
    <div class="list_container" list-name="popular">
    <div class="arrow l"></div>
    <div class="list_limits" list-name="popular">
    <ul class="list" list-name="popular">
    '.$list.'
    </ul>
    </div>
    <div class="arrow r"></div>
    </div>
    </section>';

    echo $html;
    return;
}