<?php 
if(isset($_GET["search"])) {
    $action = "/search/".$_GET["search"];
} else {
    $action = "/browse";
}
echo "<form action='".$action."' method='get'>";
?>
    <label for="sortby">Sort By</label>
    <select name="sortby">
        <label for="popularity">Popularity</label>
        <option value="popularity">All Time</option>
        <option value="popularity-week">This Week</option>
        <label for="avarage-rating">Avarage Rating</label>
        <option value="rating-hi">Highest First</option>
        <option value="rating-lo">Lowest First</option>
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
    <label for="type--feature-film">Films</label>
    <input type="checkbox" name="type--feature-film">
    <label for="type--short-film">Short-films</label>
    <input type="checkbox" name="type--short-film">
    <label for="type--series">Series</label>
    <input type="checkbox" name="type--series">
    <label for="type--mini-series">Mini-series</label>
    <input type="checkbox" name="type--mini-series">
    <label for="type--season">Seasons</label>
    <input type="checkbox" name="type--season">
    <label for="type--episode">Episodes</label>
    <input type="checkbox" name="type--episode">
    <label for="type--game">Games</label>
    <input type="checkbox" name="type--game">
    <button type="submit">Apply</button>
</form>