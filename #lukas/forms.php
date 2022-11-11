<?php 
    session_start(); 
    require_once("includes/dbh.inc.php");
    require_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>

        <ul id="form_choice">
            <li><a href="" class="button">Log in</a></li>
            <li><a href="" class="button">Sign up</a></li>
        </ul>

        <section>
            <div class="sub_header"><h2>Log In</h2></div>
            <form action="includes/account/login.inc.php" method="post" id="login_form">
                <input type="text" name="uid" placeholder="Username/Email...">
                <input type="password" name="pwd" placeholder="Password...">
                <button type="submit" name="submit-login" class="button">Log In</button>
            </form>
        </section>

        <section>
            <div class="sub_header"><h2>Sign Up</h2></div>
            <form action="includes/account/signup.inc.php" method="post" id="signup_form">
                <input type="text" name="name" placeholder="Name/Nickname...">
                <input type="text" name="email" placeholder="Email..">
                <input type="text" name="uid" placeholder="Usertag..">
                <input type="password" name="pwd" placeholder="Password..">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
                <button type="submit" name="submit-signup" class="button">Sign Up</button>
            </form>
        </section>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>



