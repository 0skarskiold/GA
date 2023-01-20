<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/item.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php echo var_dump($item); ?>
        <?php echo var_dump($genres); ?>
        <?php echo var_dump($tags); ?>
        <ul>
            <?php
                foreach($genres as $genre) {
                    echo '<li><a href="/genres/'.$genre['id'].'">'.$genre['name'].'</a></li>';
                }
                foreach($tags as $tag) {
                    echo '<li><a href="/tags/'.$tag['id'].'">'.$tag['name'].'</a></li>';
                }
                foreach($crew as $artist) {
                    echo '<li><a href="/crew/'.$artist['id'].'">'.ucfirst($artist['role']).": ".$artist['name'].'</a></li>';
                }
                foreach($collections as $collection) {
                    echo '<li><a href="/collections/'.$collection['id'].'">'.$collection['name'].'</a></li>';
                }
            ?>
        </ul>

        <ul>
            <?php 
                foreach($reviews_liked as $review) {
                    echo 
                    '<li>
                        <a href="/users/'.$review['user_uid'].'">'.$review['username'].'</a>
                        <a href="/users/'.$review['user_uid'].'/entry?id='.$review['id'].'">'.$review['text'].'</a>
                    </li>';
                }
            ?>
        </ul>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>