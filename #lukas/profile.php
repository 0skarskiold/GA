<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php echo '<h2>'.$_GET['id'].'</h2>' ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>