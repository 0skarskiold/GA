<?php

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

            $t = strtotime($r['log_date']);
            $log_date = date('Y-m-d', $t);

            if(isset($r['review_date'])) {

                $t = strtotime($r['review_date']);
                $review_date = date('Y-m-d', $t);

                $entry_type = 'full';

                if($r['review_date'] > $r['log_date']) {
                    $date_str = 'Reviewed '.$review_date;
                } elseif($r['log_date'] > $r['review_date']) {
                    $date_str = 'Watched '.$log_date;
                } else {
                    $date_str = 'Watched and reviewed '.$review_date;
                }

            } else {

                $entry_type = 'log';
                $date_str = 'Watched '.$log_date;
            }
        } else {

            $t = strtotime($r['review_date']);
            $review_date = date('Y-m-d', $t);

            $entry_type = 'review';
            $date_str = 'Reviewed '.$review_date;

        }

        $recent[$k]['entry_type'] = $entry_type;
        $recent[$k]['date_string'] = $date_str;
    }

    return $recent;
}

function renderListRecent($recent) { // view

    if(!(count($recent) > 0)) {
        return;
    }

    $list = '';

    foreach($recent as $r) {

        $i = 0;
        $stars = '';

        for($j = $r['rating']; $j > 0; $j -= 0.5) {
            if($i % 2 == 0) {
                $stars .= '<li class="half_star l"></li>';
            } else {
                $stars .= '<li class="half_star r"></li>';
            }
            $i++;
        }

        if($r['rewatch'] == 1) { 
            $rewatch = '<div class="icon rewatch"></div>';
        } else { $rewatch = ''; }
        if($r['spoilers'] == 1) { 
            $spoilers = '<div class="icon spoilers"></div>';
        } else { $spoilers = ''; }

        $path = '/metadata/'.$r['item_type'].'/'.$r['item_uid'].'/'.$r['item_uid'].'.jpg';

        // todo: lägg till en flik som fälls upp då du hover:ar över användarnamnet som säger "visa all ny aktivitet från [namn]" som ger en länk till just det.
        $list .=   
        '<li class="item_container activity">
        <div class="block1"><a href="/users/'.$r['user_uid'].'">'.$r['username'].'</a></div>
        <a class="item_link activity" href="/users/'.$r['user_uid'].'/entries?id='.$r['entry_id'].'">
        <img class="poster" src="'.$path.'"></img>
        <div class="block2">
        <ul class="stars">'.$stars.'</ul>
        <p>'.$r['date_string'].'</p>
        '.$rewatch.$spoilers.'
        </div>
        </a>
        </li>';
    }

    $html =
    '<section class="item_list_section" list-name="recent">
    <h2>Recent</h2>
    <div class="item_list_container" list-name="recent">
    <button class="button scroll l" list-name="recent"><</button>
    <div class="item_list_limits" list-name="recent">
    <ul class="item_list activity" list-name="recent">
    '.$list.'
    <li class="show_more">
    <a href="/recent-activity"></a>
    </li>
    </ul>
    </div>
    <button class="button scroll r" list-name="recent">></button>
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

        $path = '/metadata/'.$p['type'].'/'.$p['uid'].'/'.$p['uid'].'.jpg';

        $list .= 
        '<li class="item_container">
        <p hidden>'.$p['name'].' ('.$p['year'].')</p>
        <a class="item_link" href="/'.$p['type'].'/'.$p['uid'].'">
        <img class="poster" src="'.$path.'"></img>
        </a>
        </li>';
    }

    $html =
    '<section class="item_list_section" list-name="popular">
    <h2>Popular</h2>
    <select name="popular-type">
    <option value="week">This week</option>
    <option value="all">All time</option>
    <option value="week">This month</option>
    </select>
    <div class="item_list_container" list-name="popular">
    <button class="button scroll l" list-name="popular"><</button>
    <div class="item_list_limits" list-name="popular">
    <ul class="item_list" list-name="popular">
    '.$list.'
    <li class="show_more">
    <a href="/popular"></a>
    </li>
    </ul>
    </div>
    <button class="button scroll r" list-name="popular">></button>
    </div>
    </section>';

    echo $html;
    return;
}