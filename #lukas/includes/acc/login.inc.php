<?php

if (isset($_POST["submit"])) {
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    $dbh_path = $_SERVER['DOCUMENT_ROOT'];
    $dbh_path .= "/includes/dbh.inc.php";
    require_once($dbh_path);
    require_once 'acc_functions.inc.php';

    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: /forms.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $pwd);
} 
else {
    header("location: /index.php");
    exit();
}