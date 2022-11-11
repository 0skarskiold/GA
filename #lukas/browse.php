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
                foreach($items as $item){
                    if ($item['type'] == "season"){

                    } elseif ($item['type'] == "episode"){

                    } else {
                        $path = "/public/img/metadata/".strtolower($item['type'])."/".$item['id'].".jpg";
                        echo "<a href='/".strtolower($item['type'])."/".$item['id']."' class='poster_container'><h2>".$item['name']." (".date("Y", strtotime($item['date'])).")</h2><img src='".$path."' alt='Poster'></a>";
                    }
                }
            ?>
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>