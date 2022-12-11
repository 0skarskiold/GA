<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/account/profile.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>


    <main>

        
        <div id="test">
            <p>no</p>
        </div>
        <button id="btn">hey</button>

        <?php echo '<h2>'.$user['name'].'</h2>' ?>
        <?php 
        echo $tmp;
        echo $_SESSION['userid'];
        echo $user['id'];
        if(!$following) {
            echo '<button type="button" class="follow" id="follow_'.$user['uid'].'" data-userid="'.$user['id'].'">Follow</button>';
        } else {
            echo '<button type="button" name="unfollow" formaction="includes/account/follow.inc.php?id='.$user['id'].'" formmethod="post">Unfollow</button>';
        }
        ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>