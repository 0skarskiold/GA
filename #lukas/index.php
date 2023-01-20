<?php 
    session_start(); // tillåter sessions
    require_once("includes/dbh.inc.php"); // connect:ar till servern
    if(isset($_SESSION['userid'])) { // om du är inloggad
        require_once("includes/listgen/index.inc.php"); // hämtar ny aktivitet av användare du följer
    }
    require_once("sections/contents.php"); // html-head, kopplar css och js
?>
<body>
    <?php include_once("sections/header.php"); // html header ?> 

    <main>

        <!-- <h2><?php // echo var_dump($recent); ?></h2> -->
        <?php if(isset($_SESSION['userid']) && count($recent) > 0): // om du är inloggad och databasen hittar aktivitet från de du följer ?> 
            <section class="item_list_section recent_activity">

                <button class="scroll l" for="recent" <?php if(count($recent) > 0) { echo "hidden"; } ?> >left</button>
                <div class="item_list_container" id="recent">
                    <ul class="item_list">

                        <?php foreach($recent as $r) {
                            $i = 0;
                            $stars = '';
                            for($j = $r['rating']; $j > 0; $j -= 0.5) {
                                if($i % 2 == 0) {
                                    $stars .= '<div class="activity_halfstar l"></div>';
                                } else {
                                    $stars .= '<div class="activity_halfstar r"></div>';
                                }
                                $i++;
                            }
                            if($r['rewatch'] == 1) { 
                                $rewatch = '<div class="icon rewatch"></div>';
                            } else { $rewatch = ''; }
                            if($r['spoilers'] == 1) { 
                                $spoilers = '<div class="icon spoilers"></div>';
                            } else { $spoilers = ''; }

                            echo // lägg till en flik som fälls upp då du hover:ar över användarnamnet som säger "visa all ny aktivitet från [namn]" som ger en länk till just det.
                            '<li class="activity_container">
                                <div class="block1"><a href="/users/'.$r['user_uid'].'">'.$r['username'].'</a></div>
                                <a class="activity_link" href="/users/'.$r['user_uid'].'/entries?id='.$r['entry_id'].'">
                                    <img class="poster" src="/metadata/'.$r['item_type'].'/'.$r['item_uid'].'/'.$r['item_uid'].'.jpg"></img>
                                    <div class="block2">
                                        <div class="activity_stars">'.$stars.'</div>
                                        <p>'.$r['date_string'].'</p>
                                        '.$rewatch.$spoilers.'
                                    </div>
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

        <section class="item_list_section popular">

            <select name="popular-type">
                <option value="all">All time</option>
                <option value="week">This week</option>
            </select>

            <button class="scroll l" for="popular" <?php $popular=[]; if(count($popular) > 0) { echo "hidden"; } ?> >left</button>
            <div class="item_list_container" id="popular">
                <ul class="item_list">

                    <?php foreach($popular as $p) {

                        echo // att göra: lägg till en flik som fälls upp då du hover:ar över användarnamnet som säger "visa all ny aktivitet från [namn]" som ger en länk till just det.
                        '<li class="item_container">
                            <a class="item_link" href="/'.str_replace("_","-",$p['item_type']).'/'.$p['item_uid'].'">
                                <img class="poster" src="/metadata/'.$p['item_type'].'/'.$p['item_uid'].'/'.$p['item_uid'].'.jpg"></img>
                            </a>
                        </li>';

                    } ?>

                    <li class="show_more">
                        <a href="/popular-all-time"></a> <!--ska påverkas av select:popular-type-->
                    </li>
                </ul>
            </div>
            <button class="scroll r" for="recent" <?php if(count($popular) > 0) { echo "hidden"; } ?> >right</button>

            </section>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>