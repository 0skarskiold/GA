<?php

function fetchItem($conn, $id) {

    $sql = "SELECT * FROM `items` WHERE `id` = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: /?error");
        exit; 
    }
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $item = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $item;
}

function renderCreatePrompt($entry_type, $item, $user_id) {

    if($entry_type === "log") { 
        $hideForLog = "hidden"; 
        $hideForReview = "";
    } elseif ($entry_type === "review") {
        $hideForReview = "hidden";
        $hideForLog = "";
    } elseif ($entry_type === "full") { // todo: kan inte bli detta, hur istället?
        $hideForReview = "";
        $hideForLog = "";
    } else {
        return;
    }

    $stars = '<li class="half-star r activated" data-nbr="0"></li>';
    for($i=1; $i<=10; $i+=2) {
        $stars .= 
        '<li class="half-star l" data-nbr="'.$i.'"></li>
        <li class="half-star r" data-nbr="'.($i+1).'"></li>';
    }

    $star_prompt = 
    '<div id="star_container" class="inactive">
    <ul class="stars">
    '.$stars.'
    </ul>
    </div>';

    $date = date('Y-m-d');

    $form = 
    '<form method="post">
    <input type="hidden" value="'.$item['id'].'" name="item-id" />
    <input type="hidden" value="0" name="like">
    <input type="hidden" value="null" name="rating">
    <div class="log-exclusive" '.$hideForReview.'>
    <label for="log-date">When watched</label>
    <input type="date" value="'.$date.'" name="log-date" />
    <input type="checkbox" name="rewatch">I\'ve seen this before</input> <!--gör att seen ändras till played om item-type=spel-->
    </div>
    <div class="review-exclusive" '.$hideForLog.'>
    <textarea name="review-text" maxlength="10000" cols="30" rows="10" style="resize: none;"></textarea>
    <label for="review-date">Date of review</label>
    <input type="date" value="'.$date.'" name="review-date" />
    <input type="checkbox" name="spoilers">Includes spoilers</input>
    </div>
    <button type="submit" name="submit-create">Submit</button>
    </form>';

    $html = 
    '<section class="create">
    <h2>'.$item['name'].'</h2>
    <button type="button" name="toggle-log" class="add" '.$hideForLog.'>Attach diary entry</button>
    <button type="button" name="toggle-review" class="add" '.$hideForReview.'>Attach review</button>
    <div id="like" class="inactive"></div>
    <button type="button" name="toggle-rating" class="add">Add rating</button>
    '.$star_prompt.$form.'
    </section>';

    echo $html;
}

function submitRating($conn, $arr, $user_id) {

    // kollar om du redan rate:at item:et
    $sql = "SELECT COUNT(*) 
    FROM `ratings` 
    WHERE `user_id` = ? AND `item_id` = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: /?error");
        exit; 
    }

    mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $count = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);

    $date = date('Y-m-d H:i:s');

    if($count === 0) {

        // skapar din rating
        $sql = "INSERT INTO 
        `ratings` (`user_id`, `item_id`, `like`, `rating`, `created_date`, `last_edited_date`) 
        VALUES (?, ?, ?, ?, ?, ?);";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "iiidss", $user_id, $arr['item-id'], $arr['like'], $arr['rating'], $date, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } elseif($count === 1) {

        // updaterar din rating
        $sql = "UPDATE `ratings` 
        SET `like` = ?, `rating` = ?, `last_edited_date` = ? 
        WHERE `user_id` = ? AND `item_id` = ?;";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "idsii", $like, $rating, $date, $user_id, $item_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } elseif($count > 1) {

        // om något gått fel och flera skapats så raderas alla förutom den som skapades först
        $sql = "DELETE FROM `ratings` 
        WHERE `user_id` = ? AND `item_id` = ? 
        ORDER BY `created_date` ASC 
        LIMIT ".($count-1).";";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // uppdaterar den oraderade
        $sql = "UPDATE `ratings` 
        SET `like` = ?, `rating` = ?, `last_edited_date` = ? 
        WHERE `user_id` = ? AND `item_id` = ?;";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "idsii", $like, $rating, $date, $user_id, $item_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    return;
}

function submitCreate($conn, $arr, $user_id) {

    if(isset($arr['log-date']) && isset($arr['review-date'])) {

        if(isset($arr['rewatch'])) {
            $rewatch = 1;
        } else {
            $rewatch = 0;
        }
        if(isset($arr['spoilers'])) {
            $spoilers = 1;
        } else {
            $spoilers = 0;
        }

        $sql = "INSERT INTO 
        `entries` (`user_id`, `item_id`, `log_date`, `review_date`, `like`, `rating`, `rewatch`, `text`, `spoilers`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "iissidisi", $user_id, $arr['item-id'], $arr['log-date'], $review_date, $arr['like'], $arr['rating'], $rewatch, $arr['review-text'], $spoilers);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        submitRating($conn, $arr, $user_id);

    } elseif(isset($arr['log-date'])) {

        if(isset($arr['rewatch'])) {
            $rewatch = 1;
        } else {
            $rewatch = 0;
        }

        $sql = 
        "INSERT INTO `entries` (`user_id`, `item_id`, `log_date`, `like`, `rating`, `rewatch`) 
        VALUES (?, ?, ?, ?, ?, ?)
        ;";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "iisidi", $user_id, $arr['item-id'], $arr['log-date'], $arr['like'], $arr['rating'], $rewatch);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        submitRating($conn, $arr, $user_id);

    } elseif(isset($arr['review-date'])) {

        if(isset($arr['spoilers'])) {
            $spoilers = 1;
        } else {
            $spoilers = 0;
        }
        
        $sql = "INSERT INTO 
        `entries` (`user_id`, `item_id`, `review_date`, `like`, `rating`, `text`, `spoilers`) 
        VALUES (?, ?, ?, ?, ?, ?, ?);";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: /?error");
            exit; 
        }

        mysqli_stmt_bind_param($stmt, "iisidsi", $user_id, $arr['item-id'], $arr['review-date'], $arr['like'], $arr['rating'], $arr['review-text'], $spoilers);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        submitRating($conn, $arr, $user_id);

    } else {
        header("location: /?error");
        exit;
    }

    header("location: /");
    return;
}