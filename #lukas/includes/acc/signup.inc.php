<?php

if (isset($_POST["submit"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRe = $_POST["pwdrepeat"];

    $dbh_path = $_SERVER['DOCUMENT_ROOT'];
    $dbh_path .= "/includes/dbh.inc.php";
    require_once($dbh_path);
    require_once 'acc_functions.inc.php';

    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRe) !== false) {
        header("location: /forms.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: /forms.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: /forms.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRe) !== false) {
        header("location: /forms.php?error=differentpasswords");
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) {
        header("location: /forms.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);

}
else {
    header("location: /index.php");
    exit();
}