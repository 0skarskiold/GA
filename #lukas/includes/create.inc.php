<?php

function createReview($conn, $user_id, $item_id, $like, $rating, $text) {
    $sql = "INSERT INTO `users` (`user_id`, `item_id`, `date`, `like`, `rating`, `text`) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    $date = date('Y-m-d H:i:s');
    
    mysqli_stmt_bind_param($stmt, "iisifs", $user_id, $item_id, $date, $like, $rating, $text);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if(isset($_POST["submit-review"])) {

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
$user_id = $_SESSION['userid'];
$item_id = $_POST[''];
$review_text = $_POST['review_text'];
$review_id = createReview($conn, $user_id, $item_id, $like, $rating, $review_text);

}