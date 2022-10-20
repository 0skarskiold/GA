<?php include_once("../modules/dbh.php"); // is this okay to do? ?>
<!DOCTYPE html>
<html lang="en">
<?php include_once("sections/contents.php"); ?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php 
            require_once ("listgen/listgen_functions.php");
            if (isset($_SESSION["useruid"])){
                // $items = retrieveSortedList($conn, "*", "views_week", "desc", 7);
                // include(""); // ADD: sidescroll for recent watches. Can you use same file?
                echo 'hej';
            } 
            include("sections/sidescroll.php"); 
        ?>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>