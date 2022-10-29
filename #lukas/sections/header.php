<header>
    <a href="index.php" class="logo"><img src="" alt="Website Logo"></a>
    <nav>
        <a href="/list.php" class="button">Browse</a>
        <?php
            if (isset($_SESSION["useruid"])) {
                echo '<a href="profile.php" class="button">Profile</a>';
            }
        ?>
        <form action="list.php" method="post" id="search_form">
            <input type="text" name="search" placeholder="Search">
            <button type="submit" name="submit-search" class="button">Search</button>
        </form>
        <?php
            if (isset($_SESSION["useruid"])) {
                echo '<a href="/includes/acc/logout.inc.php" class="button">Log Out</a>';
            } else {
                echo '<a href="/forms.php" class="button">Log in</a>';
            }
        ?>
    </nav>
</header>