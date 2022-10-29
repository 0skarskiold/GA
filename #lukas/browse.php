<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>
        <form action="/includes/listgen/browse.inc.php">
            <select name="sortby">
                <label for="avarage_rating">Avarage Rating</label>
                <option value="rating_hi">Highest First</option>
                <option value="rating_lo">Lowest First</option>
                <label for="popularity">Popularity</label>
                <option value="popularity">All Time</option>
                <option value="popularity_week">This Week</option>
                <option value="title">Title</option>
            </select>
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
                <option value="romance">Romance</option>
                <option value="sci-fi">Science Fiction</option>
                <option value="thriller">Thriller</option>
                <option value="war">War</option>
                <option value="western">Western</option>
            </select>
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
                $path = "/public/img/metadata/".$item['type']."/".$item['id'].".jpg";
                echo "<a href='/".strtolower($item['type'])."/".$item['id']."' class='poster_container'><h2>".$item['name']."</h2><img src='".$path."' alt='Poster'></a>";
            }
        ?>
    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>