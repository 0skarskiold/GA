<?php

if(isset($_POST["submit-review"])) {

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';

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

    $user_id = intval($_POST['user_id']);
    $item_id = intval($_POST['item_id']);
    $review_text = $_POST['review_text'];
    $date = date('Y-m-d');

    $rating = floatval($_POST['rating']);
    if(($_POST['rating'] === "null") || $rating < 0.0 || $rating > 5.0) { $rating = null; } // lägg till validering så att inget tal som 0.1 eller 4.2 osv. kommer igenom. bara 1.0, 1.5, 2.0 osv.

    if($_POST['like'] === "on") {
        $like = 1;
    } elseif($_POST['like'] === "off") {
        $like = 0;
    }

    // echo "userid: ".var_dump($user_id);
    // echo "itemid: ".var_dump($item_id);
    // echo "reviewtext: ".var_dump($review_text);
    // echo "date: ".var_dump($date);
    // echo "rating: ".var_dump($rating);
    // echo "like: ".var_dump($like);

    createReview($conn, $user_id, $item_id, $date, $like, $rating, $review_text);

} else {
    header("location: /");
    exit();
}