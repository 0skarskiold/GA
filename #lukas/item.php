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
                    echo '<a href="/genres/'.$genre['id'].'"><li>'.$genre['name'].'</li></a>';
                }
                foreach($tags as $tag) {
                    echo '<a href="/tags/'.$tag['id'].'"><li>'.$tag['name'].'</li></a>';
                }
                foreach($crew as $artist) {
                    echo '<a href="/crew/'.$artist['id'].'"><li>'.ucfirst($artist['role']).": ".$artist['name'].'</li></a>';
                }
                foreach($collections as $collection) {
                    echo '<a href="/collections/'.$collection['id'].'"><li>'.$collection['name'].'</li></a>';
                }
            ?>
        </ul>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>