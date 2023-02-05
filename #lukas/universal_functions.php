<?php

function readyItemContainer($name, $uid, $year, $type, $for) {
    $path = "'/metadata/".$type."/".$uid."/".$uid."-poster-small.jpg'";
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

function readyActivityContainer($user, $user_uid, $entry_id, $rating, $date, $rewatch, $review, $spoilers, $item_name, $item_uid, $item_year, $item_type, $for) {
    $img_path = "'/metadata/".$item_type."/".$item_uid."/".$item_uid."-poster-small.jpg'";
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
        $rewatch = '<div class="icon_rewatch"></div>';
    } else { $rewatch = ''; }
    if(isset($review)) { 
        $review = '<div class="icon_review"></div>';
    } else { $review = ''; }
    if($spoilers == 1) { 
        $spoilers = '<div class="icon_spoilers"></div>';
    } else { $spoilers = ''; }

    if($for === "list") {
        $html = 
        '<li class="item_activity_container" data-item-name="'.$item_name.'" data-item-year="'.$item_year.'">
        <div class="block_top"><a href="'.$user_url.'">'.$user.'</a></div>
        <a class="item_activity_link poster" href="'.$entry_url.'" style="background-image: url('.$img_path.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></a>
        <a class="item_activity_link block_bottom" href="'.$entry_url.'">
        <ul class="star_container">'.$stars.'</ul>
        '.$review.'
        </a>
        <div class="outer">
        <p class="date">'.$date.'</p>
        '.$rewatch.'
        '.$spoilers.'
        </div>
        </li>';
    } else {
        $html = 
        '<div class="item_activity_container" data-item-name="'.$item_name.'" data-item-year="'.$item_year.'">
        <div class="block_top"><a href="'.$user_url.'">'.$user.'</a></div>
        <a class="item_activity_link poster" href="'.$entry_url.'" style="background-image: url('.$img_path.'); background-size: cover; background-position: center; background-repeat: no-repeat;"></a>
        <a class="item_activity_link block_bottom" href="'.$entry_url.'">
        <ul class="star_container">'.$stars.'</ul>
        '.$review.'
        </a>
        <div class="outer">
        <p class="date">2023-01-08</p>
        '.$rewatch.'
        '.$spoilers.'
        </div>
        </div>';
    }

    return $html;
}

function readyReviewContainer() {

}