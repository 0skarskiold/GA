<?php 
    session_start(); 
    require_once("conn/dbh.php");

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

        if(!isset($_POST['type'])) {

            header("location: /?error");

        } elseif(isset($_POST['itemid'])) { 
            
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