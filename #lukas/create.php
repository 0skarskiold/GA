<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    if(isset($_GET['itemid'])) { require_once("includes/create_fetch.inc.php"); }
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>

        <?php if(!isset($_GET['type'])) {
            header("location: /create?type=log"); // kan enkelt lägga in knappar som bestämmer typ
        } elseif($_GET['type'] === "list") {
            include_once("sections/list.php");
        } elseif(isset($_GET['itemid'])) { ?>

            <section class="create-main">

                <?php echo '<h2>'.$item['name'].'</h2>'; ?>

                <button type="button" name="toggle_log" class="add" <?php if($_GET['type'] !== "review") { echo "hidden"; } ?> >Attach Diary Entry</button>
                <button type="button" name="toggle_review" class="add" <?php if($_GET['type'] !== "log") { echo "hidden"; } ?> >Attach Review</button>
                
                <img id="like" class="inactive" src="https://img.icons8.com/ios-glyphs/30/null/hearts.png"/>
                
                <button type="button" name="toggle_rating" class="add">Add Rating</button>
                <div id="star_container" class="inactive">
                    <div id="stars_false">
                        <div class="half-star r activated" data-nbr="0"></div>
                        <?php 
                            for($i=1; $i<=10; $i+=2) {
                                echo '<div class="half-star l" data-nbr="'.$i.'"></div>
                                <div class="half-star r" data-nbr="'.($i+1).'"></div>';
                            }
                        ?>
                    </div>
                    <div id="stars_true">
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                        <div class="star"></div>
                    </div>
                </div>

                <form action="includes/create.inc.php" method="post">
                    <?php echo '<input type="hidden" value="'.$_GET['itemid'].'" name="item_id" />'; ?>
                    <?php echo '<input type="hidden" value="'.$_SESSION['userid'].'" name="user_id" />'; ?>

                    <input type="hidden" value="off" name="like">
                    <input type="hidden" value="null" name="rating">

                    <?php if($_GET['type'] === "log"): ?>
                        <div class="log-excl">
                            <label for="log-date">When watched</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" name="log-date" />
                            <input type="checkbox" name="rewatch">I've seen this before</input> <!--gör att seen ändras till played om item-type=spel-->
                        </div>
                    <?php endif; ?>

                    <?php if($_GET['type'] === "review"): ?>
                        <div class="review-excl">
                            <textarea name="review_text" maxlength="10000" cols="30" rows="10" style="resize: none;"></textarea>
                            <label for="review-date">Date of review</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" name="review-date" />
                            <input type="checkbox" name="spoilers">Includes Spoilers</input>
                        </div>
                    <?php endif; ?>

                    <button type="submit" <?php if($_GET['type'] === "review") { echo 'name="submit-review"'; } elseif($_GET['type'] === "log") { echo 'name="submit-log"'; } ?> >Submit</button>
                </form>

            </section>

        <?php } else {
            echo '<input type="text" id="csearch">
            <div class="results"></div>';
        } ?>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>