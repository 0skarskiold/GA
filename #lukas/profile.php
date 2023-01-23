<?php 
    session_start(); 
    require_once("conn/dbh.inc.php");
    require_once("includes/account/profile.inc.php");
    require_once("section_contents.php"); 
?>
<body>
    <?php include_once("section_header.php"); ?>

    <main>
        <?php

            // $user = fetchUser($conn, $_GET['uid']);
            // if(isset($_SESSION['userid'])) {
            //     $following = isFollowing($conn, $_SESSION['userid'], $user['id']);
            // }

            $user = fetchUser($conn, $_GET['uid'], $_SESSION['userid']);
            renderProfile($user);

        ?>
    </main>

    <?php include_once("section_footer.php"); ?>
</body>
</html>