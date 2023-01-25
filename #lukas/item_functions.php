<?php

function fetchGenres($conn, $item_id) {

    $sql = "SELECT 
    `genres`.* 
    FROM `genres` 
    INNER JOIN `items_genres` ON `genres`.`id` = `items_genres`.`genre_id` 
    WHERE `items_genres`.`item_id` = $item_id
    ;";

    $result = mysqli_query($conn, $sql);
    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $genres;
}

function fetchTags($conn, $item_id) {

    $sql = "SELECT 
    `tags`.* 
    FROM `tags` 
    INNER JOIN `items_tags` ON `tags`.`id` = `items_tags`.`tag_id` 
    WHERE `items_tags`.`item_id` = $item_id
    ;";
    
    $result = mysqli_query($conn, $sql);
    $tags = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $tags;
}

function fetchCrewAndCollections($conn, $item_id) {

    $sql = "SELECT 
    `crew`.*, 
    `items_crew`.`role`, 
    `items_crew`.`character`
    FROM `crew` 
    INNER JOIN `items_crew` ON `crew`.`id` = `items_crew`.`artist_id` 
    WHERE `items_crew`.`item_id` = $item_id
    ;";

    $result = mysqli_query($conn, $sql);
    $crew = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    $sql = "SELECT 
    `collections`.* 
    FROM `collections` 
    INNER JOIN `items_collections` ON `collections`.`id` = `items_collections`.`collection_id` 
    WHERE `items_collections`.`item_id` = $item_id
    ;";

    $result = mysqli_query($conn, $sql);
    $collections = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return [$crew, $collections];
}

function fetchReviews($conn, $item_id) {

    // hämtar de tio populäraste recensionerna
    $sql = "SELECT 
    `entries`.*, 
    `users`.`uid` AS `user_uid`, 
    `users`.`name` AS `username`, 
    (
        SELECT 
        COUNT(*) 
        FROM `review_likes` 
        WHERE `entry_id` = `entries`.`id`
    ) AS `likes` 
    FROM `entries` 
    INNER JOIN `users` ON `entries`.`user_id` = `users`.`id` 
    WHERE `review_date` IS NOT NULL AND `item_id` = $item_id 
    ORDER BY `likes` DESC 
    LIMIT 10
    ;";
    
    $result = mysqli_query($conn, $sql);
    $reviews_popular = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    
    // hämtar de tio senaste recensionerna
    $sql = "SELECT 
    `entries`.*, 
    `users`.`uid` AS `user_uid`, 
    `users`.`name` AS `username`, 
    (
        SELECT 
        COUNT(*) 
        FROM `review_likes` 
        WHERE `entry_id` = `entries`.`id`
    ) AS `likes` 
    FROM `entries` 
    INNER JOIN `users` ON `entries`.`user_id` = `users`.`id` 
    WHERE `review_date` IS NOT NULL AND `item_id` = $item_id 
    ORDER BY `review_date` DESC 
    LIMIT 10
    ;";
    
    $result = mysqli_query($conn, $sql);
    $reviews_recent = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    
    // hämtar tio slumpmässigt utvalda recensioner
    $sql = "SELECT 
    `entries`.*, 
    `users`.`uid` AS `user_uid`, 
    `users`.`name` AS `username`, 
    (
        SELECT 
        COUNT(*) 
        FROM `review_likes` 
        WHERE `entry_id` = `entries`.`id`
    ) AS `likes` 
    FROM `entries` 
    INNER JOIN `users` ON `entries`.`user_id` = `users`.`id` 
    WHERE `review_date` IS NOT NULL AND `item_id` = $item_id 
    ORDER BY RAND() 
    LIMIT 10
    ;";
    
    $result = mysqli_query($conn, $sql);
    $reviews_random = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return array('popular' => $reviews_popular, 'recent' => $reviews_recent, 'random' => $reviews_random);
}

function fetchReviewsFull($conn, $item_id) {

}

function fetchItem($conn, $type, $uid) {

    if($type === 'film') {

        $sql = 
        "SELECT 
        `items`.*, 
        (
            SELECT AVG(`rating`) 
            FROM `ratings` 
            WHERE `ratings`.`item_id` = `items`.`id`
        ) AS `rating` 
        FROM `items` 
        WHERE `items`.`type` = ? AND `items`.`uid` = ? 
        LIMIT 1
        ;";

    } elseif($type === 'series') {

        $sql = 
        "SELECT 
        `items`.*, 
        (
            SELECT AVG(`rating`) 
            FROM `ratings` 
            WHERE `ratings`.`item_id` = `items`.`id`
        ) AS `rating`,
        `attributes_series`.*
        FROM `items` 
        INNER JOIN `attributes_series` ON `items`.`id` = `attributes_series`.`series_id`
        WHERE `items`.`type` = ? AND `items`.`uid` = ? 
        LIMIT 1
        ;";

    } // elseif($type === 'games') {

    //     $sql = 
    //     "SELECT 
    //     `items`.*, 
    //     (
    //         SELECT AVG(`rating`) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id`
    //     ) AS `rating` 
    //     FROM `items` 
    //     WHERE `items`.`type` = ? AND `items`.`uid` = ? 
    //     LIMIT 1
    //     ;";

    // } elseif($type === 'books') {

    //     $sql = 
    //     "SELECT 
    //     `items`.*, 
    //     (
    //         SELECT AVG(`rating`) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id`
    //     ) AS `rating` 
    //     FROM `items` 
    //     WHERE `items`.`type` = ? AND `items`.`uid` = ? 
    //     LIMIT 1
    //     ;";

    // } 

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $type, $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $item = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    $genres = fetchGenres($conn, $item['id']);
    $tags = fetchGenres($conn, $item['id']);
    list($crew, $collections) = fetchCrewAndCollections($conn, $item['id']);
    $reviews = fetchReviews($conn, $item['id']);

    $item['genres'] = $genres;
    $item['tags'] = $tags;
    $item['crew'] = $crew;
    $item['collections'] = $collections;
    $item['reviews_popular'] = $reviews['popular'];
    $item['reviews_recent'] = $reviews['recent'];
    $item['reviews_random'] = $reviews['random'];

    return $item;
}

function renderReviewList($reviews) {

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
            <p class="review-text" hidden>'.$review['review_text'].'</p>';
        } else {
            $text = 
            '<p class="review-text">'.$review['review_text'].'</p>';
        }

        $list .= 
        '<li class="review_container">
        <h3 class="reviewer">'.$review['username'].'</h3>
        <div class="review_stars">'.$stars.'</div>
        '.$like.'
        <div class="review_text">'.$text.'</div>
        </li>';
    }

    return $list;
}

function renderItem($item) {

    $review_list_popular = renderReviewList($item['reviews_popular']);
    $review_list_recent = renderReviewList($item['reviews_recent']);
    $review_list_random = renderReviewList($item['reviews_random']);

    $html =
    '<div class="poster_container">
    <img src="/metadata/'.$item['type'].'/'.$item['uid'].'/'.$item['uid'].'.jpg"></img>
    </div>
    <h2>'.$item['name'].' ('.$item['year'].')</h2>
    <p class="subheading type">'.ucfirst($item['type']).'</p>
    <p class="description">'.$item['description'].'</p>
    <ul class="list_reviews popular">
    '.$review_list_popular.'
    </ul>
    <ul class="list_reviews recent">
    '.$review_list_recent.'
    </ul>
    <button type="button" name="shuffle">Shuffle</button>
    <ul class="list_reviews random">
    '.$review_list_random.'
    </ul>
    ';

    echo $html;
    return;
}