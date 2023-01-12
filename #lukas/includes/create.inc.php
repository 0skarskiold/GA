<?php

function createReview($conn, $user_id, $item_id, $date, $like, $rating, $text, $spoilers) {
        
    $sql = "INSERT INTO `reviews` (`user_id`, `item_id`, `date`, `like`, `rating`, `text`, `spoilers`) VALUES (?, ?, ?, ?, ?, ?, ?);";
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
        
    $sql = "INSERT INTO `logs` (`user_id`, `item_id`, `date`, `like`, `rating`, `rewatch`) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iisidi", $user_id, $item_id, $date, $like, $rating, $rewatch);
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

    createReview($conn, $user_id, $item_id, $review_date, $like, $rating, $review_text, $spoilers);
    createLog($conn, $user_id, $item_id, $log_date, $like, $rating, $rewatch);

    header("location: /");
    exit();

} elseif(isset($_POST["submit-review"])) {

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
    
    $user_id = intval($_POST['user_id']); // duplicerad kod :(
    $item_id = intval($_POST['item_id']);

    $review_text = $_POST['review_text'];
    $review_date = $_POST['review-date'];
    if($_POST['spoilers'] === "on") {
        $spoilers = 1;
    } elseif($_POST['spoilers'] === "off") {
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

    header("location: /");
    exit();

} elseif(isset($_POST["submit-log"])) {
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

    $user_id = intval($_POST['user_id']); // duplicerad kod :(
    $item_id = intval($_POST['item_id']);

    $dairy_date = $_POST['diary-date'];
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

    createLog($conn, $user_id, $item_id, $diary_date, $like, $rating, $rewatch);

    header("location: /");
    exit();

} else {
    header("location: /");
    exit();
}