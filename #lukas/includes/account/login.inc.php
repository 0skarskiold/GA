<?php

if (isset($_POST["submit-login"])) {
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
    require_once 'acc_functions.inc.php';

    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: /forms?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $pwd);
} 
else {
    header("location: /");
    exit();
}