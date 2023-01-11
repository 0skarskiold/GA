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