<?php 
    session_start(); 
    require_once("conn/dbh.inc.php");

    require_once("create_functions.php");

    if(isset($_POST['submit-create'])) {
        submitCreate($conn, $_POST, $_SESSION['userid']);
    }

    require_once("section_contents.php"); 
?>
<body>
    <?php include_once("section_header.php"); ?>

    <main>

        <?php

        if(!isset($_GET['type'])) {

            header("location: /create?type=log"); // kan enkelt lägga in knappar som bestämmer type

        } elseif(isset($_GET['itemid'])) { 
            
            $item = fetchItem($conn, $_GET['itemid']);
            renderCreatePrompt($_GET['type'], $item, $_SESSION['userid']);
        
        } else {

            echo 
            '<input type="text" id="create-search">
            <div class="results"></div>';

        } 
        
        ?>

    </main>

    <?php include_once("section_footer.php"); ?>
    <?php include_once("create_js.php"); ?>
</body>
</html>