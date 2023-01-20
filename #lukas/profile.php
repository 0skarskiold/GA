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
        if(isset($_SESSION['userid'])) { // om du är inloggad
            if(!$following) { // om du följer personen vars sida du är inne på, variabel ordnas (boolean) i profile.inc.php
                echo '<button type="button" class="follow insert" data-userid="'.$user['id'].'">Follow</button>';
            } else {
                echo '<button type="button" class="follow delete" data-userid="'.$user['id'].'">Unfollow</button>';
            }
        }

        ?>

        <ul class="favorites_list">
            <li><a href="/users/<?php echo $user['uid'] ?>/ratings">Ratings</a></li>
            <li><a href="/users/<?php echo $user['uid'] ?>/reviews">Reviews</a></li>
            <li><a href="/users/<?php echo $user['uid'] ?>/diary">Diary</a></li>
        </ul>


        <ul>
            <?php $favorites = $user['favorites'];
            foreach($favorites as $fav) {

                echo 
                '<li class="item_container">
                    <a class="item_link" href="/'.str_replace("_","-",$fav['item_type']).'/'.$fav['item_uid'].'">
                        <img class="poster" src="/metadata/'.$fav['item_type'].'/'.$fav['item_uid'].'/'.$fav['item_uid'].'.jpg"></img>
                    </a>
                </li>';

            } ?>
        </ul>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>