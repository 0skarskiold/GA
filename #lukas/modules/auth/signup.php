<?php

if (isset($_POST["submit"])) {
    
//     $name = $_POST["name"];
//     $email = $_POST["email"];
//     $username = $_POST["uid"];
//     $pwd = $_POST["pwd"];
//     $pwdRe = $_POST["pwdrepeat"];

    require_once '/modules/dbh.php';
//     require_once("/modules/auth/auth_functions.php");

//     if (emptyInputSignup($name, $email, $username, $pwd, $pwdRe) !== false) {
//         header("location: /templates/forms.php?error=emptyinput");
//         exit();
//     }
//     if (invalidUid($username) !== false) {
//         header("location: /templates/forms.php?error=invaliduid");
//         exit();
//     }
//     if (invalidEmail($email) !== false) {
//         header("location: /templates/forms.php?error=invalidemail");
//         exit();
//     }
//     if (pwdMatch($pwd, $pwdRe) !== false) {
//         header("location: /templates/forms.php?error=differentpasswords");
//         exit();
//     }
//     if (uidExists($conn, $username, $email) !== false) {
//         header("location: /templates/forms.php?error=usernametaken");
//         exit();
//     }

//     createUser($conn, $name, $email, $username, $pwd);

// } else {
    header("location: /templates/forms.php");
    exit();
}