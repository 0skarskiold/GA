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
                    echo '<a href="/genre/'.$genre['id'].'"><li>'.$genre['name'].'</li></a>';
                }
            ?>
        </ul>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>