<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doc</title>
    <link rel="stylesheet" media="all" href="css/style.css">
    <?php include_once("sections/js.php"); ?>
</head>
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
        <button id="btn_l">left</button>
        <button id="btn_r">right</button>
        <div class="item_list_container">
            <li class="item_list">

                <?php
                    for($i=1;$i<=20;$i++) {
                        echo 
                        '<ul class="item_container">
                            <div class="block1"></div>
                            <div class="block2"></div>
                            <div class="block3"></div>
                        </ul>';
                    }
                ?>
            </li>
        </div>
        <h2>eirugaeig</h2>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>