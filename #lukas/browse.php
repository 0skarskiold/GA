<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php if(isset($_GET['artist'])) {
            echo '<h2>'.$crew['name'].'</h2>';
        } elseif(isset($_GET['collection'])) {
            echo '<h2>'.$collection['name'].'</h2>';
        }
        require_once("includes/listgen/filter.inc.php");
        include_once("sections/filter.php"); ?>
        <section>
            <?php 
                if(isset($_GET['users'])) {
                    require_once("includes/listgen/users.inc.php"); 
                    echo '<a href="/browse">Browse media</a><ul>';
                    foreach($users as $user) {
                        echo 
                        "<li class='user_container'><a href='/users/".$user->uid."'>
                            <h2>".$user['name']." (".$user['uid'].")</h2>
                        </a>";
                    }
                    echo '</ul>';
                } else {
                    require_once("includes/listgen/browse.inc.php");
                    echo '<a href="/users">Browse users</a><ul>';
                    foreach($items as $item){
                        $path = "/metadata/".$item['type']."/".$item['uid']."/".$item['uid'].".jpg";
                        echo 
                        "<li class='item_container'><a href='/".str_replace("_","-",$item['type'])."/".$item['uid']."'>
                            <h2>".$item['name']." (".$item['year'].")</h2>
                            <img class='poster' src='".$path."' alt='Poster'>
                        </a></li>";
                    }
                    echo '</ul>';
                }
            ?>
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>