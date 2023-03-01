<?php 
    session_start(); 
    require_once("conn/dbh.php");

    require_once("entry_functions.php");

    require_once("section_contents.php"); 
?>
<body id="entry">
    <?php include_once("section_header.php"); ?>
    <main>
    <?php if(isset($_GET['id'])) {

        $entry = fetchUserEntry($conn, $_GET['id'], $_SESSION['user-id']);
        renderUserEntry($entry);

    } elseif($_GET['list'] === 'ratings') {

        $entry = fetchUserRatings($conn, $_GET['user_uid']);
        renderListRatings($entry);

    } elseif($_GET['list'] === 'reviews') {

        $reviews = fetchUserReviews($conn, $_GET['user_uid']);
        renderListUserReviews($reviews);

    } elseif($_GET['list'] === 'logs') {

        $entry = fetchUserEntries($conn, $_GET['user_uid']);
        renderListDiary($entry);

    } else { header("location: /?error"); } ?>
    </main>
    <?php include_once("section_footer.php"); ?>
</body>
</html>