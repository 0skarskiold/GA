<?php 
    session_start(); 
    require_once("conn/dbh.php");

    require_once("browse_functions.php");

    require_once("section_contents.php"); 
?>
<body>
    <?php include_once("section_header.php"); ?>

    <main>

        <?php 
            renderBrowseFilter($conn, 'browse'); // todo: $_GET['type'] eller liknande som andra argument så småningom
            $items = fetchListBrowse($conn, $_POST, 'browse');
            renderListBrowse($items, 'browse');
        ?>

    </main>

    <?php include_once("section_footer.php"); ?>
    <?php include_once("browse_js.php"); ?>
</body>
</html>