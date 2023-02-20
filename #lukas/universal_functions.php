<?php

function prepareItemContainer($name, $uid, $year, $type, $for) {
    $path = "'/img/".$type."/".$uid."/".$uid."-poster-small.jpg'";
    $url = '/'.$type.'/'.$uid;

    if($for === "list") {
        $html = 
        '<li class="item_container" data-item-name="'.$name.'" data-item-year="'.$year.'">
        <a class="item_link poster" href="'.$url.'" style="background-image: url('.$path.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></a>
        </li>';
    } else {
        $html = 
        '<div class="item_container" data-item-name="'.$name.'" data-item-year="'.$year.'">
        <a class="item_link poster" href="'.$url.'" style="background-image: url('.$path.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></a>
        </div>';
    }

    return $html;
}

function prepareActivityContainer($user, $user_uid, $entry_id, $rating, $date, $rewatch, $review, $spoilers, $item_name, $item_uid, $item_year, $item_type, $for) {
    $img_path = "'/img/".$item_type."/".$item_uid."/".$item_uid."-poster-small.jpg'";
    $user_url = '/users/'.$user_uid;
    $entry_url = $user_url.'/entries?id='.$entry_id;

    $i = 0;
    $stars = '';
    for($j = $rating; $j > 0; $j -= 0.5) {
        if($i % 2 == 0) {
            $stars .= '<li class="half_star l"></li>';
        } else {
            $stars .= '<li class="half_star r"></li>';
        }
        $i++;
    }

    if($rewatch == 1) { 
        $rewatch = '<div class="icon rewatch"></div>';
    } else { $rewatch = ''; }
    if(isset($review)) { 
        $review = '<div class="icon review"></div>';
    } else { $review = ''; }
    if($spoilers == 1) { 
        $spoilers = '<div class="icon spoilers"></div>';
    } else { $spoilers = ''; }

    if($for === "list") {
        $html = 
        '<li class="activity_container" data-item-name="'.$item_name.'" data-item-year="'.$item_year.'">
        <div class="main">
        <div class="user_container">
        <a class="user_link" href="'.$user_url.'">'.$user.'</a>
        </div>
        <a class="activity_link" href="'.$entry_url.'">
        <div class="poster" style="background-image: url('.$img_path.');"></div>
        <div class="rating">
        <ul class="star_container">
        '.$stars.'
        </ul>
        '.$review.'
        </div>
        </a>
        </div>
        <div class="outer">
        <p class="date">'.$date.'</p>
        '.$rewatch.'
        '.$spoilers.'
        </div>
        </li>';
    } else {
        $html = 
        '<div class="activity_container" data-item-name="'.$item_name.'" data-item-year="'.$item_year.'">
        <div class="main">
        <div class="user_container">
        <a class="user_link" href="'.$user_url.'">'.$user.'</a>
        </div>
        <a class="activity_link" href="'.$entry_url.'">
        <div class="poster" style="background-image: url('.$img_path.');"></div>
        <div class="rating">
        <ul class="star_container">
        '.$stars.'
        </ul>
        '.$review.'
        </div>
        </a>
        </div>
        <div class="outer">
        <p class="date">'.$date.'</p>
        '.$rewatch.'
        '.$spoilers.'
        </div>
        </div>';
    }

    return $html;
}

function prepareReviewContainer($user, $user_uid, $entry_id, $rating, $like, $review, $spoilers, $item_name, $item_uid, $item_year, $item_type, $for) {
    $img_path = "'/img/".$item_type."/".$item_uid."/".$item_uid."-poster-small.jpg'";
    $item_url = '/'.$item_type.'/'.$item_uid;
    $user_url = '/users/'.$user_uid;
    $entry_url = $user_url.'/entries?id='.$entry_id;

    $i = 0;
    $stars = '';
    for($j = $rating; $j > 0; $j -= 0.5) {
        if($i % 2 == 0) {
            $stars .= '<li class="half_star l"></li>';
        } else {
            $stars .= '<li class="half_star r"></li>';
        }
        $i++;
    }

    if($spoilers == 1) { 
        $spoilers = 
        '<div class="spoiler_prompt">
        <div class="icon_spoilers"></div>
        <button type="button" name="reveal_spoilers" class="button">Reveal</button>
        </div>';
        $text = '<p hidden>'.$review.'</p>';
    } else { 
        $spoilers = ''; 
        $text = '<p>'.$review.'</p>';
    }
    if($like == 1) { 
        $like = '<li class="icon_like"></li>';
    } else { $like = ''; }

    $html = 
    '<li class="review_container">
    <div class="review_item_container" data-item-name="'.$item_name.'" data-item-year="'.$item_year.'">
    <a class="review_item_link poster" href="'.$item_url.'" style="background-image: url('.$img_path.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></a>
    <a href="'.$entry_url.'" class="button">Full</a>
    <div class="like_button"></div><p>Like review</p>
    </div>
    <div class="top_container">
    <a href="'.$user_url.'" class="user">'.$user.'</a>
    <ul class="star_container">
    '.$stars.$like.'
    </ul>
    </div>
    <div class="review_text">
    '.$spoilers.$text.'
    </div>
    </li>';

    return $html;
}

function prepareReviewContainerPosterless($user, $user_uid, $entry_id, $rating, $like, $review, $spoilers, $for) {
    $user_url = '/users/'.$user_uid;
    $entry_url = $user_url.'/entries?id='.$entry_id;

    if($spoilers == 1) { 
        $spoilers = 
        '<div class="spoiler_prompt">
        <div class="icon_spoilers"></div>
        <button type="button" name="reveal_spoilers" class="button">Reveal</button>
        </div>';
        $text = '<p hidden>'.$review.'</p>';
    } else { 
        $spoilers = ''; 
        $text = '<p>'.$review.'</p>';
    }
    if($like == 1) { 
        $like = '<li class="icon_like"></li>';
    } else { $like = ''; }

    $html = 
    '<li class="review_container posterless">
    <div class="top_container">
    <a href="'.$user_url.'" class="user">'.$user.'</a>
    <ul class="star_container">
    '.$stars.$like.'
    </ul>
    </div>
    <div class="review_text">
    '.$spoilers.$text.'
    </div>
    <div class="bottom_container">
    <a href="'.$entry_url.'" class="button">Full</a>
    <p>Like review</p><div class="like_button"></div>
    </div>
    </li>';

    return $html;
}

function prepareStars($rating, $length, $like) {

    if($rating === 'open') {

        $i = 0;
        $stars = '';
        for($j = 1; $j <= 5; $j += 0.5) {
            if($i % 2 == 0) {
                $stars .= '<li class="half_star l" data-nbr="'.$j.'"></li>';
            } else {
                $stars .= '<li class="half_star r" data-nbr="'.$j.'"></li>';
            }
            $i++;
        }

        $html = 
        '<ul class="stars open inactive" style="--length-local: '.$length.';">
        '.$stars.'
        </ul>';

    } elseif(is_numeric($rating)) {

        if($like) {
            $like = '<li class="like" style="margin-right: calc(var(--length-local)*0.25);"></li>';
        } else {
            $like = '';
        }

        $i = 0;
        $stars = '';
        for($j = 1; $j <= $rating; $j += 0.5) {
            if($i % 2 == 0) {
                $stars .= '<li class="half_star l"></li>';
            } else {
                $stars .= '<li class="half_star r"></li>';
            }
            $i++;
        }

        $html = 
        '<ul class="stars closed" data-rating="'.$rating.'" style="--length-local: '.$length.';">
        '.$like.$stars.'
        </ul>';

    } else {
        header("location: /?error");
        exit;
    }
    return $html;
}