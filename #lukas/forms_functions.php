<?php

// // kollar om något fält är tomt vid signup
// function emptyInputSignup($name, $email, $username, $pwd, $pwdRe) {
//     if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRe)) {
//         $result = true;
//     } else {
//         $result = false;
//     }
//     return $result;
// }

// // kollar om användarnamnet använder godkända tecken
// function invalidUid($username) {
//     if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
//         $result = true;
//     } else {
//         $result = false;
//     }
//     return $result;
// }

// // validerar emailen
// function invalidEmail($email) {
//     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $result = true;
//     } else {
//         $result = false;
//     }
//     return $result;
// }

// // kollar så att lösenorden matchar
// function pwdMatch($pwd, $pwdRe) {
//     if($pwd !== $pwdRe) {
//         $result = true;
//     } else {
//         $result = false;
//     }
//     return $result;
// }

// // kollar om användarnamnet (redan) existerar
// function uidExists($conn, $username, $email) {
//     $sql = "SELECT * FROM `users` WHERE `uid` = ? OR `email` = ?;";
//     $stmt = mysqli_stmt_init($conn);
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: /forms?error=stmtfailed");
//         exit();
//     }
    
//     mysqli_stmt_bind_param($stmt, "ss", $username, $email);
//     mysqli_stmt_execute($stmt);

//     $resultData = mysqli_stmt_get_result($stmt);

//     if ($row = mysqli_fetch_assoc($resultData)) {
//         return $row;
//     } 
//     else {
//         $result = false;
//         return $result;
//     }

//     mysqli_stmt_close($stmt);
// }

// // skapar användaren
// function createUser($conn, $name, $email, $username, $pwd) {
//     $sql = "INSERT INTO `users` (`name`, `email`, `uid`, `pwd`) VALUES (?, ?, ?, ?);";
//     $stmt = mysqli_stmt_init($conn);
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: /forms?error=stmtfailed");
//         exit();
//     }

//     $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    
//     mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
//     header("location: /forms?error=none");
//     exit();
// }

// // kollar om något fält är tomt vid login
// function emptyInputLogin($username, $pwd) {
//     if(empty($username) || empty($pwd)) {
//         $result = true;
//     } 
//     else {
//         $result = false;
//     }
//     return $result;
// }

// // loggar in användaren
// function loginUser($conn, $username, $pwd) {
//     $uidExists = uidExists($conn, $username, $username);

//     if($uidExists === false) {
//         header("location: /forms?error=wronglogin");
//         exit();
//     }

//     $pwdHashed = $uidExists["pwd"];
//     $checkPwd = password_verify($pwd, $pwdHashed);

//     if($checkPwd === false) {
//         header("location: /forms?error=wronglogin");
//         exit();
//     } else if ($checkPwd === true) {
//         session_start();
//         $_SESSION["userid"] = $uidExists["id"];
//         $_SESSION["useruid"] = $uidExists["uid"];
//         header("location: /");
//         exit();
//     }
// }

function submitSignup() {

    // if (isset($_POST["submit-signup"])) {
    
    //     $name = $_POST["name"];
    //     $email = $_POST["email"];
    //     $username = $_POST["uid"];
    //     $pwd = $_POST["pwd"];
    //     $pwdRe = $_POST["pwdrepeat"];
    
    //     require_once $_SERVER['DOCUMENT_ROOT'].'/conn/dbh.inc.php';
    //     require_once 'acc_functions.inc.php';
    
    //     if(emptyInputSignup($name, $email, $username, $pwd, $pwdRe) !== false) {
    //         header("location: /forms?error=emptyinput");
    //         exit();
    //     }
    //     if(invalidUid($username) !== false) {
    //         header("location: /forms?error=invaliduid");
    //         exit();
    //     }
    //     if(invalidEmail($email) !== false) {
    //         header("location: /forms?error=invalidemail");
    //         exit();
    //     }
    //     if(pwdMatch($pwd, $pwdRe) !== false) {
    //         header("location: /forms?error=differentpasswords");
    //         exit();
    //     }
    //     if(uidExists($conn, $username, $email) !== false) {
    //         header("location: /forms?error=usernametaken");
    //         exit();
    //     }
    
    //     createUser($conn, $name, $email, strtolower($username), $pwd);
    
    // } else {
    //     header("location: /");
    //     exit();
    // }
}

function submitLogin() {

    // if (isset($_POST["submit-login"])) {
    //     $username = $_POST["uid"];
    //     $pwd = $_POST["pwd"];
    
    //     require_once $_SERVER['DOCUMENT_ROOT'].'/conn/dbh.inc.php';
    //     require_once 'acc_functions.inc.php';
    
    //     if (emptyInputLogin($username, $pwd) !== false) {
    //         header("location: /forms?error=emptyinput");
    //         exit();
    //     }
    
    //     loginUser($conn, $username, $pwd);
    // } 
    // else {
    //     header("location: /");
    //     exit();
    // }
}

function renderForms() {

    // <ul id="form_choice">
    //     <li><a href="" class="button">Log in</a></li>
    //     <li><a href="" class="button">Sign up</a></li>
    // </ul>

    // <section>
    //     <div class="sub_header"><h2>Log In</h2></div>
    //     <form action="includes/account/login.inc.php" method="post" id="login_form">
    //         <input type="text" name="uid" placeholder="Username/Email...">
    //         <input type="password" name="pwd" placeholder="Password...">
    //         <button type="submit" name="submit-login" class="button">Log In</button>
    //     </form>
    // </section>

    // <section>
    //     <div class="sub_header"><h2>Sign Up</h2></div>
    //     <form action="includes/account/signup.inc.php" method="post" id="signup_form">
    //         <input type="text" name="name" placeholder="Name/Nickname...">
    //         <input type="text" name="email" placeholder="Email..">
    //         <input type="text" name="uid" placeholder="Usertag..">
    //         <input type="password" name="pwd" placeholder="Password..">
    //         <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
    //         <button type="submit" name="submit-signup" class="button">Sign Up</button>
    //     </form>
    // </section>

}