<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/item.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php echo '<h2>'.$item['name'].'</h2>'; ?>
        <?php echo '<h2>'.$item['name'].'</h2>'; ?>
        <?php echo '<h2>'.$genres[0]['name'].'</h2>'; ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>