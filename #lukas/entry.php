<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); 
    if(isset($_GET['id'])): 
    require_once("includes/entry.inc.php"); ?>

        <main>

            <?php var_dump($entry); ?>

        </main>

    <?php elseif($_GET['list'] === 'ratings'): 
    require_once("includes/ratings.inc.php"); ?>

        <main>
            
            <?php foreach($ratings as $rating) {
                var_dump($rating);
            } ?>

        </main>

    <?php elseif($_GET['list'] === 'reviews'): 
    require_once("includes/reviews.inc.php"); ?>

        <main>
            
            <?php foreach($reviews as $review) {
                var_dump($review);
            } ?>

        </main>

    <?php elseif($_GET['list'] === 'logs'): 
    require_once("includes/diary.inc.php"); ?>

        <main>

            <?php foreach($diary_entries as $diary_entry) {
                var_dump($diary_entry);
            } ?>

        </main>

    <?php else: header("location: /"); endif; ?>
    <?php include_once("sections/footer.php"); ?>
</body>
</html>