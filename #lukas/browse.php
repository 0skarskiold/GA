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
                $items = fetchListBrowse($conn, $_GET, 'users');
                renderListBrowse($_SESSION['user-id'], $items, 'users');
            } else {
                if(isset($_GET['search'])) {
                    renderBrowseFilter($conn, $_GET['search']);
                } else {
                    renderBrowseFilter($conn, false);
                }
                $items = fetchListBrowse($conn, $_GET, 'items');
                renderListBrowse($_SESSION['user-id'], $items, 'items');
            }
        ?>

    </main>

    <?php include_once("section_footer.php"); ?>
    <?php include_once("browse_js.php"); ?>
</body>
</html>