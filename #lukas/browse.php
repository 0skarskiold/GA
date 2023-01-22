<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");

    require_once("browse_functions.php");

    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>

        <?php 
            renderBrowseFilter($conn, 'browse'); // $_GET['type'] som andra argument så småningom
            $items = fetchBrowseList($conn, $_POST, 'browse');
            renderBrowseList($items, 'browse');
        ?>


        <section>
           
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>