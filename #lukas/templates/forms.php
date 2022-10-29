<?php 
    session_start(); 
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/modules/dbh.php";
    include_once($path);
    include_once("sections/contents.php"); 
?>
<body>
    <?php include_once("sections/header.php"); ?>

    <main>

        <ul id="form_choice">
            <li><a href="login.php" class="button">Log in</a></li>
            <li><a href="signup.php" class="button">Sign up</a></li>
        </ul>

        <section>
            <div class="sub_header"><h2>Log In</h2></div>
            <form action="/modules/auth/login.php" method="post" id="login_form">
                <input type="text" name="uid" placeholder="Username/Email...">
                <input type="password" name="pwd" placeholder="Password...">
                <button type="submit" name="submit" class="button">Log In</button>
            </form>
        </section>

        <section>
            <div class="sub_header"><h2>Sign Up</h2></div>
            <form action="/modules/auth/signup.php" method="post" id="login_form">
                <input type="text" name="name" placeholder="Full Name...">
                <input type="text" name="email" placeholder="Email..">
                <input type="text" name="uid" placeholder="Username..">
                <input type="password" name="pwd" placeholder="Password..">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
                <button type="submit" name="submit" class="button">Sign Up</button>
            </form>
        </section>

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>




