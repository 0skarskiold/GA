<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php 
            // require_once ("listgen/listgen_functions.php");
            // if (isset($_SESSION["useruid"])){
            //     // $items = retrieveSortedList($conn, "*", "views_week", "desc", 7);
            //     // include(""); // ADD: sidescroll for recent watches. Can you use same file?
            //     echo 'hej';
            // } 
            // include("sections/sidescroll.php"); 
        ?>
        <h2>eirugaeig</h2>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>