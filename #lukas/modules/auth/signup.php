<?php

if (isset($_POST["submit"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRe = $_POST["pwdrepeat"];

    require_once("modules/dbh.inc.php");
    require_once("modules/auth/functions.php");

    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRe) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRe) !== false) {
        header("location: ../signup.php?error=differentpasswords");
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);

}
else {
    header("location: ../signup.php");
    exit();
}