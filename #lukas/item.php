<?php 
    session_start(); 
    require_once("conn/dbh.php");

    require_once("item_functions.php");

    require_once("section_contents.php"); 
?>
<body>
    <?php include_once("section_header.php"); ?>

    <main>
        <?php

            $item = fetchItem($conn, $_GET['type'], $_GET['uid']);
            renderItem($item);

        ?>
    </main>

    <?php include_once("section_footer.php"); ?>
</body>
</html>