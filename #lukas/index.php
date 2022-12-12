<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <section class="item_list_section">
            <button id="btn_l">left</button>
            <button id="btn_r">right</button>
            <div class="item_list_container">
                <li class="item_list">
                    <?php
                        for($i=1;$i<=20;$i++) {
                            echo 
                            '<ul class="item_container">
                                <div class="block1"></div>
                                <div class="block2"></div>
                                <div class="block3"></div>
                            </ul>';
                        }
                    ?>
                </li>
            </div>
        </section>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>