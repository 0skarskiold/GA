<header>
    <a href="/" class="logo"><img src="" alt="Website Logo"></a>
    <nav>
        <a href="/browse" class="button">Browse</a>
        <?php
            if (isset($_SESSION["useruid"])) {
                echo '<a href="/profile/'.$_SESSION["useruid"].'" class="button">Profile</a>';
            }
        ?>
        <form action="/includes/listgen/search.inc.php" method="get" id="search_form">
            <input type="text" name="search" placeholder="Search">
            <button type="submit" name="submit-search" class="button">Search</button>
        </form>
        <?php
            if (isset($_SESSION["useruid"])) {
                echo '<a href="/includes/account/logout.inc.php" class="button">Log Out</a>';
            } else {
                echo '<a href="/forms" class="button">Log in</a>';
            }
        ?>
    </nav>
</header>