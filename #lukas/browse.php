<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/listgen/browse.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <?php include_once("sections/browse_form.php"); ?>
        <section>
            <?php 
                echo $items[1];
                foreach($items as $item){
                    $path = "/public/img/metadata/".$item['type']."/".$item['uid']."/poster.jpg";
                    echo "<a href='/".str_replace("_","-",$item['type'])."/".$item['uid']."' class='poster_container'><h2>".$item['name']." (".$item['year'].")</h2><img src='".$path."' alt='Poster'></a>";
                }
            ?>
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>