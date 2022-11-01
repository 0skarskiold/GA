<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <form action="/includes/listgen/browse.inc.php" method="get">
            <label for="sortby">Sort By</label>
            <select name="sortby">
                <option value="title">Title</option>
                <label for="avarage_rating">Avarage Rating</label>
                <option value="rating_hi">Highest First</option>
                <option value="rating_lo">Lowest First</option>
                <label for="popularity">Popularity</label>
                <option value="popularity">All Time</option>
                <option value="popularity_week">This Week</option>
            </select>
            <label for="genre">Genre</label>
            <select name="genre">
                <option value="*">Any</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="animation">Animation</option>
                <option value="comedy">Comedy</option>
                <option value="crime">Crime</option>
                <option value="documentary">Documentary</option>
                <option value="fantasy">Fantasy</option>
                <option value="history">History</option>
                <option value="horror">Horror</option>
                <option value="music">Music</option>
                <option value="noir">Noir</option>
                <option value="romance">Romance</option>
                <option value="sci-fi">Science/Fiction</option>
                <option value="thriller">Thriller</option>
                <option value="war">War</option>
                <option value="western">Western</option>
            </select>
            <label for="subgenre">Subgenre</label>
            <select name="subgenre">
                <option value="*">Any</option>
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
                <option value="spaghetti">Spagghetti</option>
                <option value="post-apocalypse">Post-Apocalypse</option>
                <option value="teen-drama">Teen Drama</option>
            </select>
            <label for="year">Year</label>
            <select name="year">
                <option value="*">Any</option>
                <?php 
                    for ($y = 1870; $y < date("Y")+2; $y++){
                        if ($y % 10 == 0){
                            echo '<option value="'.$y.'s">'.$y.'s</option>';
                        }
                        echo '<option value="'.$y.'">'.$y.'</option>';
                    }
                ?>
            </select>
            <label for="type">Type</label>
            <select name="type">
                <option value="*">Any</option>
                <option value="Film">Film</option>
                <option value="Short-Film">Short Film</option>
                <option value="Series">Series</option>
                <option value="Seasons">Seasons & Mini-Series</option>
                <option value="Game">Game</option>
            </select>
            <label for="seasons">Include Seasons?</label>
            <input type="checkbox" name="seasons"> <!--only if type=all-->
            <label for="episodes">Include Episodes?</label>
            <input type="checkbox" name="episodes">
            <button type="submit" name="submit-browse">Apply</button>
        </form>
        <?php 
            foreach($_SESSION['items'] as $item){
                if ($item['type'] == "season"){

                } elseif ($item['type'] == "episode"){

                } else {
                    $path = "/public/img/metadata/".$item['type']."/".$item['id'].".jpg";
                    echo "<a href='/".strtolower($item['type'])."/".$item['id']."' class='poster_container'><h2>".$item['name']." (".date("Y", strtotime($item['date'])).")</h2><img src='".$path."' alt='Poster'></a>";
                }
            }
        ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>