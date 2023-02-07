<?php
require_once("universal_functions.php");

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

function prepareReviewList($reviews, $name) {

    $list = '';
    foreach($reviews as $review) {
        $list .= prepareReviewContainerPosterless($review['username'], $review['user_uid'], $review['entry_id'], $review['rating'], $review['like'], $review['text'], $review['spoilers'], 'list');
    }

    $html = 
    '<div class="review_list_container">
    <div class="review_list_heading">
    <h2>'.ucfirst($name).'</h2>
    </div>
    <div class="review_list_limits">
    <ul class="review_list" list-name="'.strtolower($name).'">
    '.$list.'
    </ul>
    </div>
    </div>';

    return $html;
}

function renderItem($item) {

    // switch($item['type']) {
    //     case 'film':
    //         $html = prepareItemFilm($item);
    //         break;
    // }

    $reviews10 = [];
    $reviews10 = array_merge($reviews10, $item['reviews_popular'], $item['reviews_popular'], $item['reviews_popular'], $item['reviews_popular']);


    $review_list_popular = prepareReviewList($reviews10, 'popular');
    $review_list_recent = prepareReviewList($item['reviews_recent'], 'recent');
    $review_list_random = prepareReviewList($item['reviews_random'], 'random');

    $poster_path = "'/img/".$item['type']."/".$item['uid']."/".$item['uid']."-poster-full.jpg'";
    $bg_path = '/img/'.$item['type'].'/'.$item['uid'].'/'.$item['uid'].'-bg.jpg';

    $item['directors'] = ['a', 'b'];
    $item['writers'] = ['a', 'c'];
    if(array_intersect($item['directors'], $item['writers']) === $item['writers']) {
        if(count($item['directors']) == 2) {
            $creators_str = 'Written and directed by <a href="">'.$item['directors'][0].'</a> and <a href="">'.$item['directors'][1].'</a>';
        } elseif(count($item['directors']) == 1) {
            $creators_str = 'Written and directed by <a href="">'.$item['directors'][0].'</a>';
        } elseif(count($item['directors']) == 0) {
            header('location: /?error');
            exit;
        }
    } else {
        if(count($item['directors']) == 2) {
            $creators_str = 'Directed by <a href="">'.$item['directors'][0].'</a> and <a href="">'.$item['directors'][1].'</a>';
        } elseif(count($item['directors']) == 1) {
            $creators_str = 'Directed by <a href="">'.$item['directors'][0].'</a>';
        } elseif(count($item['directors']) == 0) {
            header('location: /?error');
            exit;
        }
    
        if(count($item['writers']) == 2) {
            $creators_str .= ', written by <a href="">'.$item['writers'][0].'</a> and <a href="">'.$item['writers'][1].'</a>';
        } elseif(count($item['writers']) == 1) {
            $creators_str .= ', written by <a href="">'.$item['writers'][0].'</a>';
        } elseif(count($item['writers']) == 0) {
            header('location: /?error');
            exit;
        }
    }

    $section1 = 
    '<section id="item_grid_container">
    <div class="left_container">
    <div id="main_poster" style="background-image: url('.$poster_path.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
    </div>
    <div id="title_container">
    <p><span>'.$item['name'].'</span> <a href="#">'.$item['year'].'</a></p>
    <p>'.$creators_str.'</p>
    <p>'.ucfirst($item['type']).' • Age-rating: 16'.$item['age-rating'].'</p>
    </div>
    <div id="actions_container">
    </div>
    <div id="description_container">
    <p>'.$item['description'].'</p>
    </div>
    </section>';

    $section2 = 
    '<section id="review_lists">
    <div class="button_container"><button type="button" class="button">Open all reviews</button></div>'.
    $review_list_popular.
    $review_list_recent.
    $review_list_random.'
    </section>';

    $html = 
    '<div id="main_background_container">
    <img src="'.$bg_path.'">
    </div>
    '.$section1.$section2;
    
    

    // om en director och en writer: "directed by [director], written by [writer]"
    // om director och writer är samma person: "written and directed by [person]"
    // om fler än två directors och fler än två writers: "show directors, show writers"
    // Directed by <a href="#">'.$item['directors'].'</a>, written by <a href="#">'.$item['writers'].'</a>, adapted from <a href="#">'.$item['source'].'</a></h3>



    echo $html;
    return;
}