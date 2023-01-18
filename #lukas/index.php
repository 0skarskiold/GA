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
        <?php if(count($recent) > 0): ?>
            <section class="item_list_section">

                <button class="scroll l" for="recent" <?php if(count($recent) > 0) { echo "hidden"; } ?> >left</button>
                <div class="item_list_container" id="recent">
                    <ul class="item_list">
                        <?php foreach($recent as $r) {
                            $i = 0;
                            $stars = '<div class="activity_stars">';
                            for($j = $r['rating']; $j > 0; $j -= 0.5) {
                                if($i % 2 == 0) {
                                    $stars .= '<div class="activity_halfstar l"></div>';
                                } else {
                                    $stars .= '<div class="activity_halfstar r"></div>';
                                }
                                $i++;
                            }
                            $stars .= '</div>';
                            echo // lägg till en flik som fälls upp då du hover:ar över användarnamnet som säger "visa all ny aktivitet från [namn]" som ger en länk till just det.
                            '<li class="activity_container">
                                <div class="block1"><a href="/users/'.$r['user_uid'].'">'.$r['username'].'</a></div>
                                <a class="activity_link" href="/users/'.$r['user_uid'].'/entry?entry_id='.$r['entry_id'].'&entry_type='.$entry_type.'&item_uid='.$r['item_uid'].'">
                                    <img class="poster" src="/metadata/'.$r['item_type'].'/'.$r['item_uid'].'/'.$r['item_uid'].'.jpg"></img>
                                    <div class="block2">'.$stars.'</div>
                                </a>
                            </li>';
                        } ?>
                        <li class="show_more">
                            <a href="/recent-activity"></a>
                        </li>
                    </ul>
                </div>
                <button class="scroll r" for="recent" <?php if(count($recent) > 0) { echo "hidden"; } ?> >right</button>

            </section>
        <?php endif; ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>