<?php include_once 'header.php'; ?>

<section>
    <div class="sub_header"><h2>Categories</h2></div>
    <div id="categories">
        <a href="grid.php?type=all" class="category_wrap all"><div class="category full"><h3>All</h3></div></a>
        <div class="category_wrap films"> 
            <div class="category full" id="fold_films"><h3>Movies</h3></div> 
            <div class="subcategories">
                <a href="grid.php?type=films" class="button">Feature Films</a>
                <a href="grid.php?type=shortfilms" class="button">Shorts</a>
            </div>
        </div>
        <div class="category_wrap series"> 
            <div class="category full" id="fold_series"><h3>Series</h3></div> 
            <div class="subcategories">
                <a href="grid.php?type=series" class="button">Series</a>
                <a href="grid.php?type=miniseries" class="button">Mini Series</a>
            </div>
        </div>
        <a href="grid.php?type=games" class="category_wrap games"><div class="category full"><h3>Games</h3></div></a>
    </div>
</section>

<?php include_once 'footer.php'; ?>