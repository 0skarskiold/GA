<?php include_once 'header.php';

if (isset($_SESSION["useruid"])){
    include_once 'list_recent.php';
} 

require_once 'inc/functions.inc.php';
$items = retrieveSortedList($conn, "*", "popularity_week", "desc", 7);

?>

<section>

    <div class="sub_header">
        <h2>Popular</h2>
        <p>This Week</p>
    </div>

    <div class="poster_list horizontal">
        <?php 
            foreach($items as $item){
                echo "<a href='item.php?type=".$item['type']."&id=".$item['id']."' class='poster_container'><img src='".$item['poster_path']."' alt='Poster'></a>";
            }
        ?>
        <a href="#" class="poster_container show_more"><div><h3>Show More</h3></div></a>
    </div>

</section>

<?php include_once 'footer.php' ?>