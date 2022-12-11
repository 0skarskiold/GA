<?php

// kollar om något fält är tomt vid signup
function emptyInputSignup($name, $email, $username, $pwd, $pwdRe) {
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRe)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// kollar om användarnamnet använder godkända tecken
function invalidUid($username) {
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// validerar emailen
function invalidEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// kollar så att lösenorden matchar
function pwdMatch($pwd, $pwdRe) {
    if($pwd !== $pwdRe) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// kollar om användarnamnet (redan) existerar
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM `users` WHERE `uid` = ? OR `email` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /forms?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

// skapar användaren
function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO `users` (`name`, `email`, `uid`, `pwd`) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /forms?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: /forms?error=none");
    exit();
}

// kollar om något fält är tomt vid login
function emptyInputLogin($username, $pwd) {
    if(empty($username) || empty($pwd)) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

// loggar in användaren
function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false) {
        header("location: /forms?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["pwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false) {
        header("location: /forms?error=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["useruid"] = $uidExists["uid"];
        header("location: /");
        exit();
    }
}

function isFollowing($conn, $from_id, $to_id) {

    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT COUNT(`to_id`) FROM `follow` WHERE `from_id` = ? AND `to_id` = ? LIMIT 1;";

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $tmp = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);

    if($tmp === 1) {
        return true;
    } elseif($tmp < 1) {
        return false;
    } elseif($tmp > 1) {
        header("location: /?error=dbmistake");
        exit();
    }
}

function fetchUser($conn, $uid) {

    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT `id`, `name`, `uid` FROM `users` WHERE `uid` = ? ORDER BY `name` LIMIT 1;";

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $user;
}

function followUser($conn, $from_id, $to_id) {

    $stmt = mysqli_stmt_init($conn);
    $sql = "INSERT INTO `follow` (`from_id`, `to_id`) VALUES (?, ?);";
    
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function unfollowUser($conn, $from_id, $to_id) {
    
    $stmt = mysqli_stmt_init($conn);
    $sql = "DELETE FROM `follow` WHERE `from_id` = ? AND `to_id` = ?;";
    
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $from_id, $to_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}