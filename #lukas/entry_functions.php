<?php
require_once('universal_functions.php');

function fetchEntry($conn, $entry_id, $user_id) {

    // kollar om du likat den
    if(isset($user_id)) {
        $str = "SELECT COUNT(*) 
        FROM `review_likes` 
        WHERE `entry_id` = ? AND `user_id` = ? 
        LIMIT 1";

        $subsql = 
        ", 
        IF(`user_id` = ?, 0, 1) AS `yours`,
        (".$str.") AS `liked`";
    }

    $sql = "SELECT 
    `entries`.*,
    `users`.`name` AS `username`,
    `users`.`uid` AS `user_uid`,
    `items`.`name` AS `item_name`,
    `items`.`uid` AS `item_uid`,
    `items`.`year` AS `item_year`,
    `types`.`uid` AS `item_type`
    $subsql
    FROM `entries` 
    INNER JOIN `users` ON `entries`.`user_id` = `users`.`id`
    INNER JOIN `items` ON `entries`.`item_id` = `items`.`id`
    INNER JOIN `types` ON `items`.`type_id` = `types`.`id`
    WHERE `entries`.`id` = ? 
    LIMIT 1;";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }

    if(isset($user_id)) {
        mysqli_stmt_bind_param($stmt, "iiii", $user_id, $entry_id, $user_id, $entry_id);
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

function renderEntry($entry) {

    $date_str = '';
    if(isset($entry['log_date']) && isset($entry['review_date'])) {
        if($entry['log_date'] === $entry['review_date']) {
            $date_str .= 'Whatched and reviewed '.date('Y-m-d', strtotime($entry['log_date']));
        } else {
            $date_str .= 'Whatched '.date('Y-m-d', strtotime($entry['log_date'])).' and reviewed '.date('Y-m-d', strtotime($entry['review_date']));
        }
    } else {
        if(isset($entry['log_date'])) {
            $date_str .= 'Watched '.date('Y-m-d', strtotime($entry['log_date']));
        }
        if(isset($entry['review_date'])) {
            $date_str .= 'Reviewed '.date('Y-m-d', strtotime($entry['review_date']));
    
            // if($entry['spoilers'] == 1) { 
            //     $text = 
            //     '<p>This review may include spoilers!</p>
            //     <button type="button name="reveal-spoilers">Reveal</button>
            //     <p class="review-text" hidden>'.$entry['review_text'].'</p>';
            // } else {
            //     $text = 
            //     '<p class="review-text">'.$entry['review_text'].'</p>';
            // }
        }
    }

    if(!isset($entry['text'])) {
        $entry['text'] = '';
    }

    if(isset($entry['rating'])) {
        $i = 0;
        $stars = '';
        for($j = $entry['rating']; $j > 0; $j -= 0.5) {
            if($i % 2 == 0) {
                $stars .= '<div class="review half-star l"></div>';
            } else {
                $stars .= '<div class="review half-star r"></div>';
            }
            $i++;
        }
    }
    if($entry['like'] == 1) { 
        $like = '<div class="icon like"></div>';
    } else { $like = ''; }

    if($entry['liked'] == 1) { 
        $like_button = '<div class="like_button on"></div>';
    } else { $like_button = '<div class="like_button off"></div>'; }

    $html =
    '<div class="entry_container">
    <div class="top_container">
    <a class="item_name" href="/type-'.$entry['item_type'].'/'.$entry['item_uid'].'">'.$entry['item_name'].'</a>
    <p class="by">'.$date_str.' by <a href="/user-'.$entry['user_uid'].'">'.$entry['username'].'</a></p>
    </div>
    <div class="poster_parent">
    '.prepareItemContainer($entry['item_name'], $entry['item_uid'], $entry['item_year'], $entry['item_type'], 'non-list').'
    </div>
    <div class="text_container"><p class="review">'.$entry['text'].'</p></div>
    <div class="bottom_container">
    <div class="right">
    '.prepareClosedStars($entry['rating']).'
    '.$like.'
    </div>
    <div class="left">
    '.$like_button.'
    </div>
    </div>';

    echo $html;


    // <div class="entry_container">
    // <div class="top_container">
    // <a class="item_name">Northman</a>
    // <a class="username" href="user-Array">Oskar</a>
    // </div>
    // <p class="date">Whatched and reviewed 2023-02-28</p>
    // <div class="poster_parent">
    // <div class="item_container" data-item-name="Northman" data-item-year="2022">
    // <a class="item_link poster" href="/type-film/northman-2022" style="background-image: url('/img/film/northman-2022/northman-2022-poster-small.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;"></a>
    // </div>
    // </div>
    // <div class="text_container"><p class="review">meh</p></div>
    // </div>
    // <div class="bottom_container">
    // <div class="right">
    // <ul class="star_container closed" data-rating="2.5";">
    // <li class="half_star l"></li><li class="half_star r"></li><li class="half_star l"></li><li class="half_star r"></li><li class="half_star l"></li>
    // </ul>
    // </div>
    // <div class="left">
    // <div class="like_button off"></div>
    // </div>
    // </div>  
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

function renderReviews($reviews) {

    $username = $reviews[0]['username'];

    $list = '';
    foreach($reviews as $review) {

        $i = 0;
        $stars = '';

        for($j = $review['rating']; $j > 0; $j -= 0.5) {
            if($i % 2 == 0) {
                $stars .= '<div class="review half-star l"></div>';
            } else {
                $stars .= '<div class="review half-star r"></div>';
            }
            $i++;
        }

        if($review['like'] == 1) { 
            $like = '<div class="review_like"></div>';
        } else { $like = ''; }
        if($review['spoilers'] == 1) { 
            $text = 
            '<p>This review may include spoilers!</p>
            <button type="button name="reveal-spoilers">Reveal</button>
            <p class="review-text" hidden>'.$review['text'].'</p>';
        } else {
            $text = 
            '<p class="review-text">'.$review['text'].'</p>';
        }

        $list .= 
        '<li class="review_container">
        <h3 class="reviewer">'.$review['username'].'</h3>
        <div class="review_stars">'.$stars.'</div>
        '.$like.'
        <div class="review_text">'.$text.'</div>
        </li>';
    }

    $html = 
    '<h2>'.$username.'</h2>
    <ul class="list_reviews">
    '.$list.'
    </ul>';

    echo $html;
    return;
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