<?php 
    session_start(); 
    require_once("conn/dbh.php");

    require_once("browse_functions.php");

    require_once("section_contents.php"); 
?>
<body id="browse">
    <?php include_once("section_header.php"); ?>

    <main>

        <?php 
            if(isset($_GET['users'])) {
                // $users = fetchListUsers($conn, $_POST, 'browse');
                // renderListUsers($items, 'browse');
            } else {
                renderBrowseFilter($conn);
                $items = fetchListBrowse($conn, $_GET, 'browse');
                renderListBrowse($items, 'browse');
            }
        ?>

    </main>

    <?php include_once("section_footer.php"); ?>
    <?php include_once("browse_js.php"); ?>
</body>
</html>