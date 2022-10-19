<?php

// SIGNUP & LOGIN

function emptyInputSignup($name, $email, $username, $pwd, $pwdRe) {
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRe)) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRe) {
    if ($pwd !== $pwdRe) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM `users` WHERE `uid` = ? OR `email` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
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

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO `users` (`name`, `email`, `uid`, `pwd`) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) {
    if (empty($username) || empty($pwd)) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["pwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["useruid"] = $uidExists["uid"];
        header("location: ../index.php");
        exit();
    }
}

// RATING

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
// används exempelvis
// argument 1: koppling till databasen
// argument 2: item:ets typ, dvs film, serie eller spel
// argument 3: faktorn listan sorteras utefter
// argument 4: ordning. ASC innebär ascending, nerifrån och upp, medan DESC innebär descending, uppifrån och ner
// argument 5: gräns för arrayen. vi behöver inga oändliga listor
function retrieveSortedList($conn, $item_type, $factor, $order, $lim) {
    
    if ($order == "asc") {
        if($item_type == "*") {
            // skriven query för att hämta värden
            $sql = "SELECT * FROM `items` ORDER BY '$factor' ASC LIMIT $lim;";
        } else {
            $sql = "SELECT * FROM `items` WHERE `type` = '$item_type' ORDER BY '$factor' ASC LIMIT $lim;";
        }
    } else if ($order == "desc") {
        if ($item_type == "*") {
            $sql = "SELECT * FROM `items` ORDER BY '$factor' DESC LIMIT $lim;";
        } else {
            $sql = "SELECT * FROM `items` WHERE `type` = '$item_type' ORDER BY '$factor' DESC LIMIT $lim;";
        }
    }

    // utför query, hämtar resultat
    $result = mysqli_query($conn, $sql);

    // skapar arrayen
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $items;
}

// tar in betygsättningen och kollar så att inget skumt värde har angivits
// vi vill bara tillåta tal med en enda decimal som ligger mellan 0.1 och 5
function invalidRating($rating) {

    $result = true;
    $i = 0.1;

    while($result && ($i <= 5)) {
        if($rating == $i) {
            $result = false;
        }
        $i += 0.1;
    }

    return $result;
}

// betygsättningen.
// tar in värden för alla kolumner i ratings-tablet, samt koppling till databasen
function rate($conn, $user_id, $item_type, $item_id, $rating, $like){

    // kollar efter rader i ratings som uppfyller personen och item:et. nämligen en betygsättning per person och item
    $sql = "SELECT * FROM `ratings` WHERE `user_id` = $user_id AND `item_type` = '$item_type' AND `item_id` = $item_id;";
    
    $result = mysqli_query($conn, $sql);

    // bestämmer om det finns en rad som ska uppdateras eller om en ny rad ska skapas
    if(mysqli_fetch_all($conn, MYSQLI_ASSOC)){
        $sql = "UPDATE `ratings` SET `rating` = ? AND `like` = ? WHERE `user_id` = ? AND `item_type` = ? AND `item_id` = ?;";
    } else {
        $sql = "INSERT INTO `ratings` (`rating`, `like`, `user_id`, `item_type`, `item_id`) VALUES (?, ?, ?, ?, ?);";
    }

    // initierar mysqli statement
    $stmt = mysqli_stmt_init($conn);
    // används för att hindra sql injection
    // behövs främst vid användning av input-fält<

    // förbereder statement, samt kollar om något går fel. innebär i princip att query:n skickas till databasen i förväg för att hindra injection
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    // binder variabler till query:n
    mysqli_stmt_bind_param($stmt, "diisi", $rating, $like, $user_id, $item_type, $item_id);
    // "diisi" innebär datatyperna på de insatta variablerna -- double, integer, integer, string, integer

    // utför
    mysqli_stmt_execute($stmt);

    // stänger statement
    mysqli_stmt_close($stmt);

    header("location: ../index.php");
    exit();
}

//liknar rate-funktionen men inkluderar datum, samt om personen sett filmen eller spelat spelet förut, och den skapar alltid ny rad i entries-tablet
function createEntry($conn, $rating, $like, $user_id, $item_type, $item_id, $re, $date_completion, $date_first){

    $sql = "INSERT INTO `entries` (`rating`, `like`, `user_id`, `item_type`, `item_id`, `re`, `date_completion`, `date_first`) VALUES (?, ?, ?, ?, ?; ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "diisiiii", $rating, $like, $user_id, $item_type, $item_id, $re, $date_completion, $date_first);
    // timestamp är integer

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../index.php");
    exit();
}

// function avgRating($conn, $item_type, $item_id){ // tänkt att uppdatera varje gång någon betygsätter saken. borde man kanske göra så att den inte börjar från början varje gång?
    
//     // skriven query för att hämta värden
//     $sql = "SELECT `rating` FROM `ratings` WHERE `item_id` = $item_id AND `item_type` = $item_type AND `rating` >= 0.1;";
    
//     // utför, hämta resultat
//     $result = mysqli_query($conn, $sql);

//     // fetch:ar resulterande värden som en array, ett format vi kan använda
//     $ratings = mysqli_fetch_array($result);
    
//     // summera ratings
//     $sum = array_sum($ratings);

//     // medelvärde
//     $avg = $sum / count($ratings);

//     // för att uppdatera avg
//     $sql = "UPDATE `items` SET `rating` = $avg WHERE `type` = '$item_type' AND `id` = $item_id;";
    
//     // utför
//     mysqli_query($conn, $sql);
// }

// function popularityAllTime($conn, $item_type, $item_id){
    
//     $sql = "SELECT COUNT(*) FROM `entries` WHERE `item_id` = $item_id AND `item_type` = '$item_type';";

//     $result = mysqli_query($conn, $sql);

//     $array = mysqli_fetch_array($result);
//     $value = intval($array[0]);

//     $sql = "UPDATE `items` SET `popularity_all` = $value WHERE `type` = '$item_type' AND `id` = $item_id;";
    
//     mysqli_query($conn, $sql);
// }

// function popularityThisWeek($conn, $item_type, $item_id) {

//     // hämtar tiden för en vecka sedan och gör till passande format
//     $tmp = strtotime("-1 Week");
//     $date_lim = date("Y-m-d H:i:s", $tmp);
//     // hur fixar man för tidszoner?

//     $sql = "SELECT COUNT(*) FROM `entries` WHERE `item_id` = $item_id AND `item_type` = '$item_type' AND `date_completion` >= '$date_lim';";

//     $result = mysqli_query($conn, $sql);

//     $array = mysqli_fetch_array($result);
//     $value = intval($array[0]);

//     $sql = "UPDATE `items` SET `popularity_week` = $value WHERE `type` = '$item_type' AND `id` = $item_id;";
    
//     mysqli_query($conn, $sql);
// }