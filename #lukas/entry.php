<?php 
    session_start(); 
    require_once("conn/dbh.php");

    require_once("entry_functions.php")

    require_once("section_contents.php"); 
?>
<body>
    <?php include_once("section_header.php"); 
    if(isset($_GET['id'])): ?>

        <main>

            <?php var_dump($entry); 
            if(isset($entry['text'])) {
                if(isset($entry['liked']) && $entry['liked'] === 1) { echo '<div class="like_review inactive" data-entryid="'.$entry['id'].'" style="height:20px;width:20px;background-color:magenta;"'; } elseif(isset($entry['liked']) && $entry['liked'] === 0) { echo '<div class="like_review active" data-entryid="'.$entry['id'].'" style="height:20px;width:20px;background-color:blue;"'; } else { echo '<div class="like_review inactive" data-entryid="'.$entry['id'].'" hidden'; }
            } ?>

        </main>

    <?php elseif($_GET['list'] === 'ratings'): ?>

        <main>
            
            <?php foreach($ratings as $rating) {
                var_dump($rating);
            } ?>

        </main>

    <?php elseif($_GET['list'] === 'reviews'): ?>

        <main>
            
            <?php foreach($reviews as $review) {
                var_dump($review);
            } ?>

        </main>

    <?php elseif($_GET['list'] === 'logs'): ?>

        <main>

            <?php foreach($diary_entries as $diary_entry) {
                var_dump($diary_entry);
            } ?>

        </main>

    <?php else: header("location: /"); endif; 
    include_once("section_footer.php"); ?>
</body>
</html>