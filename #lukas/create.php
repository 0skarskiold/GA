<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>


    <main>

        <?php if(isset($_GET['itemid'])): ?>

            <section class="create-log inactive" hidden>
                <button>Attach Review</button>
                <button>Attach List</button>
            </section>
            <section class="create-review active">
                <button>Attach Diary Entry</button>
                <button>Attach List</button>
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
                    <input type="checkbox" name="spoilers">Includes Spoilers</input>
                    <button type="submit" name="submit-review">Submit</button>
                </form>
            </section>
            <section class="create-list inactive" hidden>
                <button>Attach Review</button>
            </section>

        <?php else: ?>

            <form action="" method="post"></form>

        <?php endif; ?>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>