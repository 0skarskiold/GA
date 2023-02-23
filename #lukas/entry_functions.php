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

function renderEntry($entry) {

    if(isset($entry['log_date']) && isset($entry['review_date'])) {

    } elseif(isset($entry['review_date'])) {

        if($entry['spoilers'] == 1) { 
            $text = 
            '<p>This review may include spoilers!</p>
            <button type="button name="reveal-spoilers">Reveal</button>
            <p class="review-text" hidden>'.$entry['review_text'].'</p>';
        } else {
            $text = 
            '<p class="review-text">'.$entry['review_text'].'</p>';
        }

    } elseif(isset($entry['log_date'])) {

    } else {
        header("location: /?error");
        exit;
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
        $like = '<div class="entry_like"></div>';
    } else { $like = ''; }

    $html =
    '<div class="entry_container">
    <h2>'.$entry['username'].'</h2>
    <h2>'.$entry['item_name'].'</h2>
    <div class="entry_stars">'.$stars.'</div>
    '.$like.'
    <div class="review_text">'.$text.'</div>
    </div>
    ';

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