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

        }
        require_once("includes/listgen/filter.inc.php");
        include_once("sections/filter.php"); ?>
        <section>
            <?php 
                if(isset($_GET['users'])) {
                    require_once("includes/listgen/users.inc.php");
                    foreach($users as $user){
                        $path = "/public/img/users/".$user['uid']."/profile.jpg";
                        echo "<a href='/users/".$user['uid']."' class='user_container'><h2>".$user['name']." (".$user['uid'].")</h2><img src='".$path."' alt='Profile Image'></a>";
                    }
                } else {
                    require_once("includes/listgen/browse.inc.php");
                    foreach($items as $item){
                        $path = "/public/img/metadata/".$item['type']."/".$item['uid']."/poster.jpg";
                        echo "<a href='/".str_replace("_","-",$item['type'])."/".$item['uid']."' class='poster_container'><h2>".$item['name']." (".$item['year'].")</h2><img src='".$path."' alt='Poster'></a>";
                    }
                }
            ?>
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>