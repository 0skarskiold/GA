<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("includes/listgen/browse.inc.php");
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
                <label for="title">Popularite</label>
                <option value="popularity">All Time</option>
                <option value="popularity_week">This Week</option>
                <option value="title">Title</option>
            </select>
            <select name="genre">
            </select>
            <select name="year">
            </select>
            <select name="type">
            </select>
            <input type="checkbox" name="seasons" placeholder="Include seasons?"> <!--only if type=all-->
            <input type="checkbox" name="episodes" placeholder="Include episodes?">
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