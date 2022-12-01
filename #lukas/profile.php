<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/account/profile.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php echo '<h2>'.$user['name'].'</h2>' ?>

        <?php 
        if(!$following) {
            echo '<button type="submit" name="follow" formaction="includes/account/follow.inc.php?id='.$user['id'].'" formmethod="post">Follow</button>';
        } else {
            echo '<button type="submit" name="unfollow" formaction="includes/account/follow.inc.php?id='.$user['id'].'" formmethod="post">Unfollow</button>';
        }
        ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>