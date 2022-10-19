<?php include_once("../modules/dbh.php"); // is this okay to do? ?>
<!DOCTYPE html>
<html lang="en">
<?php include_once("sections/contents.php"); ?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php
            if (isset($_SESSION["useruid"])){
                require_once ("inc/functions.inc.php");
                $items = retrieveSortedList($conn, "*", "popularity_week", "desc", 7);
                include_once("list_recent.php");
            } 
        ?>

        <?php include_once("sections/sidescroll.php"); ?>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>