<section class="create-review" <?php if($_GET['type'] !== "review") { echo "hidden"; } ?> >
    <button name="toggle_log" class="add">Attach Diary Entry</button>
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
        <textarea name="review_text" maxlength="10000" cols="30" rows="10" style="resize: none;"></textarea>
        <input type="date" value="<?php echo date('Y-m-d'); ?>" name="date" />
        <input type="checkbox" name="spoilers">Includes Spoilers</input>
        <button type="submit" name="submit-review">Submit</button>
    </form>
</section>