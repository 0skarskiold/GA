<?php

function isFollowing($conn, $from_id, $to_id) {

    $sql = 
    "SELECT COUNT(`to_id`) 
    FROM `follow` 
    WHERE `from_id` = ? AND `to_id` = ? 
    LIMIT 1;";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error");
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $tmp = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);

    if($tmp === 1) {
        return true;

    } elseif($tmp < 1) {
        return false;

    } elseif($tmp > 1) {

        $lim = $tmp - 1;

        $sql = 
        "DELETE FROM `follow` 
        WHERE `from_id` = ? AND `to_id` = ? 
        LIMIT $lim;";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error");
            exit;
        }

        mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return true;
    }
}

function fetchUser($conn, $uid) {

    // $stmt = mysqli_stmt_init($conn);
    // $sql = "SELECT `id`, `name`, `uid`
    // FROM `users` 
    // WHERE `uid` = ? 
    // ORDER BY `name` 
    // LIMIT 1;";

    // if(!mysqli_stmt_prepare($stmt, $sql)) {
    //     header("location: /?error=stmtfailed");
    //     exit();
    // }

    // mysqli_stmt_bind_param($stmt, "s", $uid);
    // mysqli_stmt_execute($stmt);
    // $result = mysqli_stmt_get_result($stmt);
    // mysqli_stmt_close($stmt);
    // $user = mysqli_fetch_assoc($result);
    // mysqli_free_result($result);

    // return $user;
}

function renderProfile() {

    // echo '<h2>'.$user['name'].'</h2>';
    // if(isset($_SESSION['userid'])) { // om du är inloggad
    //     if(!$following) { // om du följer personen vars sida du är inne på, variabel ordnas (boolean) i profile.inc.php
    //         echo '<button type="button" class="follow insert" data-userid="'.$user['id'].'">Follow</button>';
    //     } else {
    //         echo '<button type="button" class="follow delete" data-userid="'.$user['id'].'">Unfollow</button>';
    //     }
    // }

    // <ul class="favorites_list">
    //     <li><a href="/users/ echo $user['uid'] /ratings">Ratings</a></li>
    //     <li><a href="/users/ echo $user['uid'] /reviews">Reviews</a></li>
    //     <li><a href="/users/ echo $user['uid'] /diary">Diary</a></li>
    // </ul>
}