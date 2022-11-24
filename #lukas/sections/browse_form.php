<form action="/browse" method="get">
    <label for="sortby">Sort By</label>
    <select name="sortby">
        <label for="popularity">Popularity</label>
        <option value="popularity">All Time</option>
        <option value="popularity_week">This Week</option>
        <label for="avarage_rating">Avarage Rating</label>
        <option value="rating_hi">Highest First</option>
        <option value="rating_lo">Lowest First</option>
        <option value="title">Title</option>
    </select>
    <label for="genre">Genre</label>
    <select name="genre">
        <option value="any">Any</option>
        <?php 
            foreach($genres as $genre) {
                echo "<option value='".$genre['id']."'>".$genre['name']."</option>";
            }
        ?>
    </select>
    <label for="tag">Tag</label>
    <select name="tag"> <!--gör att denna modifieras utefter vad för genre som valts-->
        <option value="any">Any</option>
        <?php 
            foreach($tags as $tag) {
                echo "<option value='".$tag['id']."'>".$tag['name']."</option>";
            }
        ?>
    </select>
    <label for="year">Year</label>
    <select name="year">
        <option value="any">Any</option>
        <?php 
            for ($y = 1870; $y < date("Y")+2; $y++){
                if ($y % 10 == 0){
                    echo '<option value="'.$y.'s">'.$y.'s</option>';
                }
                echo '<option value="'.$y.'">'.$y.'</option>';
            }
        ?>
    </select>
    <!-- <label for="type">Type</label>
    <select name="type">
        <option value="any">Any</option>
        <option value="feature_film">Feature Films</option>
        <option value="short_film">Short-films</option>
        <option value="series">Series</option>
        <option value="season">Seasons</option>
        <option value="episode">Episodes</option>
        <option value="game">Games</option>
    </select> -->
    <label for="type_any">Any?</label>
    <input type="checkbox" name="type_any">
    <label for="type_feature_film">Films?</label>
    <input type="checkbox" name="type_feature_film">
    <label for="type_short_film">Short-films?</label>
    <input type="checkbox" name="type_short_film">
    <label for="type_series">Series?</label>
    <input type="checkbox" name="type_series">
    <label for="type_mini_series">Mini-series?</label>
    <input type="checkbox" name="type_mini_series">
    <label for="type_season">Seasons?</label>
    <input type="checkbox" name="type_season">
    <label for="type_episode">Episodes?</label>
    <input type="checkbox" name="type_episode">
    <label for="type_game">Games?</label>
    <input type="checkbox" name="type_game">
    <button type="submit" name="submit-browse">Apply</button>
</form>