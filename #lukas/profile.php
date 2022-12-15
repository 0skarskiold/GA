<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/account/profile.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>


    <main>

        <?php 

        echo '<h2>'.$user['name'].'</h2>';
        if(isset($_SESSION['userid'])) {
            if(!$following) {
                echo '<button type="button" class="follow insert" data-userid="'.$user['id'].'">Follow</button>';
            } else {
                echo '<button type="button" class="follow delete" data-userid="'.$user['id'].'">Unfollow</button>';
            }
        }

        ?>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>