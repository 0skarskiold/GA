<?php

function createReview($conn, $user_id, $item_id, $date, $like, $rating, $text) {
    $sql = "INSERT INTO `reviews` (`user_id`, `item_id`, `date`, `like`, `rating`, `text`) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "iisifs", $user_id, $item_id, $date, $like, $rating, $text);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt); 

    header("location: /");
    exit();
}


if(isset($_POST["submit-review"])) {

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

    $user_id = $_SESSION['userid'];
    $item_id = intval($_POST['item_id']);
    $review_text = $_POST['review_text'];
    $date = date('Y-m-d H:i:s');

    if(($_POST['rating'] === "null") || ($rating = intval($_POST['rating']) <= 0 || $rating >= 5)) { $rating = null; }

    if($_POST['like'] === "on") {
        $like = 1;
    } elseif($_POST['like'] === "off") {
        $like = 0;
    }

    createReview($conn, $user_id, $item_id, $date, $like, $rating, $review_text);

}