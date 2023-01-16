<?php

function rate($conn, $user_id, $item_id, $like, $rating) {

    $sql = "SELECT COUNT(*) FROM `ratings` WHERE `user_id` = ? AND `item_id` = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $count = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);

    if($count === 0) {
        $stmt = mysqli_stmt_init($conn);
        $sql = "INSERT INTO `ratings` (`user_id`, `item_id`, `like`, `rating`, `created_date`, `last_edited_date`) VALUES (?, ?, ?, ?, ?, ?);";
        
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }

        $date = date('Y-m-d H:i:s');
        
        mysqli_stmt_bind_param($stmt, "iiidss", $user_id, $item_id, $like, $rating, $date, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } elseif($count === 1) {
        $stmt = mysqli_stmt_init($conn);
        $sql = "UPDATE `ratings` SET `like` = ?, `rating` = ?, `last_edited_date` = ? WHERE `user_id` = ? AND `item_id` = ?;";
        
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }

        $date = date('Y-m-d H:i:s');
        
        mysqli_stmt_bind_param($stmt, "idsii", $like, $rating, $date, $user_id, $item_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } elseif($count > 1) {
        $stmt = mysqli_stmt_init($conn);
        $sql = "DELETE FROM `ratings` WHERE `user_id` = ? AND `item_id` = ? ORDER BY `created_date` DESC LIMIT ".($count-1).";";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        $stmt = mysqli_stmt_init($conn);
        $sql = "UPDATE `ratings` SET `like` = ?, `rating` = ?, `last_edited_date` = ? WHERE `user_id` = ? AND `item_id` = ?;";
        
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }

        $date = date('Y-m-d H:i:s');
        
        mysqli_stmt_bind_param($stmt, "idsii", $like, $rating, $date, $user_id, $item_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

}

function createReview($conn, $user_id, $item_id, $date, $like, $rating, $text, $spoilers) {
        
    $sql = "INSERT INTO `entries` (`user_id`, `item_id`, `review_date`, `like`, `rating`, `text`, `spoilers`) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iisidsi", $user_id, $item_id, $date, $like, $rating, $text, $spoilers);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function createLog($conn, $user_id, $item_id, $date, $like, $rating, $rewatch) {
        
    $sql = "INSERT INTO `entries` (`user_id`, `item_id`, `log_date`, `like`, `rating`, `rewatch`) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iisidi", $user_id, $item_id, $date, $like, $rating, $rewatch);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function createFullEntry($conn, $user_id, $item_id, $log_date, $review_date, $like, $rating, $rewatch, $text, $spoilers) {

    // sätt in validering som ser till att alla argument är definierade
        
    $sql = "INSERT INTO `entries` (`user_id`, `item_id`, `log_date`, `review_date`, `like`, `rating`, `rewatch`, `text`, `spoilers`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iissidisi", $user_id, $item_id, $log_date, $review_date, $like, $rating, $rewatch, $text, $spoilers);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if(isset($_POST["submit-log-review"])) {

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

    $user_id = intval($_POST['user_id']);
    $item_id = intval($_POST['item_id']);

    $review_text = $_POST['review_text'];
    $review_date = $_POST['review-date'];
    if($_POST['spoilers'] === "on") {
        $spoilers = 1;
    } elseif($_POST['spoilers'] === "off") {
        $spoilers = 0;
    }

    $log_date = $_POST['log-date'];
    if($_POST['rewatch'] === "on") {
        $rewatch = 1;
    } elseif($_POST['rewatch'] === "off") {
        $rewatch = 0;
    }

    $rating = floatval($_POST['rating']);
    if(($_POST['rating'] === "null") || $rating < 0.0 || $rating > 5.0) { $rating = null; } // lägg till validering så att inget tal som 0.1 eller 4.2 osv. kommer igenom. bara 1.0, 1.5, 2.0 osv.

    if($_POST['like'] === "on") {
        $like = 1;
    } elseif($_POST['like'] === "off") {
        $like = 0;
    }

    createFullEntry($conn, $user_id, $item_id, $log_date, $review_date, $like, $rating, $rewatch, $review_text, $spoilers);
    rate($conn, $user_id, $item_id, $like, $rating);

    header("location: /");
    exit();

} elseif(isset($_POST["submit-review"])) {

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
    
    $user_id = intval($_POST['user_id']); // duplicerad kod :(
    $item_id = intval($_POST['item_id']);

    $review_text = $_POST['review_text'];
    $review_date = $_POST['review-date'];
    if(isset($_POST['spoilers'])) {
        $spoilers = 1;
    } else {
        $spoilers = 0;
    }

    $rating = floatval($_POST['rating']);
    if(($_POST['rating'] === "null") || $rating < 0.0 || $rating > 5.0) { $rating = null; } // lägg till validering så att inget tal som 0.1 eller 4.2 osv. kommer igenom. bara 1.0, 1.5, 2.0 osv.

    if($_POST['like'] === "on") {
        $like = 1;
    } elseif($_POST['like'] === "off") {
        $like = 0;
    }

    createReview($conn, $user_id, $item_id, $review_date, $like, $rating, $review_text, $spoilers);
    rate($conn, $user_id, $item_id, $like, $rating);

    header("location: /");
    exit();

} elseif(isset($_POST["submit-log"])) {
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

    $user_id = intval($_POST['user_id']); // duplicerad kod :(
    $item_id = intval($_POST['item_id']);

    $log_date = $_POST['log-date'];
    if(isset($_POST['rewatch'])) {
        $rewatch = 1;
    } else {
        $rewatch = 0;
    }

    $rating = floatval($_POST['rating']);
    if(($_POST['rating'] === "null") || $rating < 0.0 || $rating > 5.0) { $rating = null; } // lägg till validering så att inget tal som 0.1 eller 4.2 osv. kommer igenom. bara 1.0, 1.5, 2.0 osv.

    if($_POST['like'] === "on") {
        $like = 1;
    } elseif($_POST['like'] === "off") {
        $like = 0;
    }

    createLog($conn, $user_id, $item_id, $log_date, $like, $rating, $rewatch);
    rate($conn, $user_id, $item_id, $like, $rating);

    header("location: /");
    exit();

} else {
    header("location: /");
    exit();
}