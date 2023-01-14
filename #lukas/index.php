<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    if(isset($_SESSION['userid'])) {
        require_once("includes/listgen/index.inc.php");
    }
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <h2><?php echo var_dump($recent); ?></h2>
        <section class="item_list_section">
            <button id="btn_l">left</button>
            <button id="btn_r">right</button>
            <div class="item_list_container">
                <ul class="item_list">
                    <!-- <?php // for($i=1;$i<=20;$i++) {
                        // echo 
                        // '<li class="item_container">
                        //     <div class="block1"></div>
                        //     <div class="block2"></div>
                        //     <div class="block3"></div>
                        // </li>';
                    // } ?> -->
                    <?php foreach($recent as $r) {
                        echo 
                        '<li class="item_container">
                            <div class="block1">'.$r['username'].'</div>
                            <img class="block2" src="/metadata/'.$r['item_type'].'/'.$r['item_uid'].'/'.$r['item_uid'].'.jpg"></img>
                            <div class="block3"></div>
                        </li>';
                    } ?>
                </ul>
            </div>
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>