<header>
    <a href="/" class="logo"><img src="" alt="Website Logo"></a>
    <nav>
        <a href="/browse" class="button">Browse</a>
        <?php
            if (isset($_SESSION["useruid"])) {
                echo '<a href="/users/'.$_SESSION["useruid"].'" class="button">Profile</a>';
            }
        ?>
        <form action="/includes/listgen/search.inc.php" method="get" id="search_form">
            <input type="text" name="search" placeholder="Search">
            <button type="submit" class="button">Search</button>
        </form>
        <?php
            if (isset($_SESSION["useruid"])) {
                echo '<a href="/includes/account/logout.inc.php" class="button">Log Out</a>';
            } else {
                echo '<a href="/forms" class="button">Log in</a>';
            }
        ?>
        <p>create:</p>
        <!-- <form action="/create" method="post">
            <input type="hidden" value="review" name="type">
            <button type="submit">Review</button>
        </form> -->
        <?php
            if(isset($item["id"])) {
                echo '<a href="/create?type=log&itemid='.$item["id"].'">Diary Entry</a>
                <a href="/create?type=review&itemid='.$item["id"].'">Review</a>
                <a href="/create?type=list&itemid='.$item["id"].'">List</a>';
            } else {
                echo '<a href="/create?type=log">Diary Entry</a>
                <a href="/create?type=review">Review</a>
                <a href="/create?type=list">List</a>';
            }
        ?>
    </nav>
</header>