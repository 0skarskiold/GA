<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>


    <main>

        <?php if(!isset($_GET['type'])) {
            header("location: /?error=type"); // kan enkelt lägga in knappar som bestämmer typ
        } elseif($_GET['type'] === "list") {
            include_once("sections/list.php");
        } elseif(isset($_GET['itemid'])) {
            include_once("sections/log.php");
            include_once("sections/review.php");
        } else {
            echo '<input type="text" id="csearch">
            <div class="results"></div>';
        } ?>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>