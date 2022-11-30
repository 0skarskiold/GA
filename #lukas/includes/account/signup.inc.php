<?php

if (isset($_POST["submit-signup"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRe = $_POST["pwdrepeat"];

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
    require_once 'acc_functions.inc.php';

    if(emptyInputSignup($name, $email, $username, $pwd, $pwdRe) !== false) {
        header("location: /forms?error=emptyinput");
        exit();
    }
    if(invalidUid($username) !== false) {
        header("location: /forms?error=invaliduid");
        exit();
    }
    if(invalidEmail($email) !== false) {
        header("location: /forms?error=invalidemail");
        exit();
    }
    if(pwdMatch($pwd, $pwdRe) !== false) {
        header("location: /forms?error=differentpasswords");
        exit();
    }
    if(uidExists($conn, $username, $email) !== false) {
        header("location: /forms?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, strtolower($username), $pwd);

} else {
    header("location: /");
    exit();
}