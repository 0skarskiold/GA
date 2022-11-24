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
                echo "<option value='".$genre['id']."'>".ucwords($genre['name'])."</option>";
            }
        ?>
    </select>
    <label for="subgenre">Subgenre</label>
    <select name="subgenre"> <!--gör att denna modifieras utefter vad för genre som valts-->
        <option value="any">Any</option>
        <option value="whodunit">Whodunit</option>
        <option value="superhero">Superhero</option>
        <option value="creature-feature">Creature-Feature</option>
        <option value="vampires">Vampires</option>
        <option value="zombies">Zombies</option>
        <option value="aliens">Aliens</option>
        <option value="samurai">Samurai</option>
        <option value="pirates">Pirates</option>
        <option value="vikings">Vikings</option>
        <option value="ghosts">Ghosts</option>
        <option value="found-footage">Found Footage</option>
        <option value="werewolf">Werewolf</option>
        <option value="dinosaurs">Dinosaurs</option>
        <option value="cars">Cars</option>
        <option value="time-travel">Time Travel</option>
        <option value="slasher">Slasher</option>
        <option value="splatter">Splatter</option>
        <option value="disaster">Disaster</option>
        <option value="spy">Spy</option>
        <option value="martial-arts">Martial Arts</option>
        <option value="cga">CG Animation</option>
        <option value="traditional">Traditional Animation</option>
        <option value="stop-motion">Stop-Motion</option>
        <option value="black-comedy">Black Comedy</option>
        <option value="slapstick">Slapstick</option>
        <option value="mockumentary">Mockumentary</option>
        <option value="biopic">Biopic</option>
        <option value="dystopian">Dystopian</option>
        <option value="utopian">Utopian</option>
        <option value="psychological">Psychological</option>
        <option value="spaghetti">Spaghetti</option>
        <option value="post-apocalypse">Post-Apocalypse</option>
        <option value="teen-drama">Teen Drama</option>
        <option value="coming-of-age">Coming of Age</option>
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