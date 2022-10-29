<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php 
            foreach($_SESSION['items'] as $item){
                $path = "/public/img/metadata/".$item['type']."/".$item['id'].".jpg";
                echo "<a href='/".strtolower($item['type'])."/".$item['id']."' class='poster_container'><h2>".$item['name']."</h2><img src='".$path."' alt='Poster'></a>";
            }
        ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>