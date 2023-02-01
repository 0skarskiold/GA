<?php 
    session_start(); 
    require_once("conn/dbh.php");

    require_once("entry_functions.php");

    require_once("section_contents.php"); 
?>
<body>
    <?php include_once("section_header.php"); 
    if(isset($_GET['id'])): ?>

        <main>

            <?php
                $entry = fetchEntry($conn, $_GET['id'], $_SESSION['userid']);
                renderEntry($entry);
            ?>

        </main>

    <?php elseif($_GET['list'] === 'ratings'): ?>

        <main>
            


        </main>

    <?php elseif($_GET['list'] === 'reviews'): ?>

        <main>
            
            <?php 
                $reviews = fetchReviews($conn, $_GET['user_uid']);
                renderReviews($reviews);
            ?>

        </main>

    <?php elseif($_GET['list'] === 'logs'): ?>

        <main>



        </main>

    <?php else: header("location: /error"); endif; 
    include_once("section_footer.php"); ?>
</body>
</html>