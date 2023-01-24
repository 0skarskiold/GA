<?php

function fetchQuickSearch($conn, $input) {

    $arr = explode(" ", $input); // delar string till array utefter mellanrum
    for($i = 0; $i < count($arr); $i++) {

        if(is_numeric($arr[$i])) { // om något ord från input är numeriskt

            $year = "%".$arr[$i]."%";
            array_splice($arr, $i, 1);
            $input = join($arr);
            break;
        }
    }
    $input = "%".$input."%";

    $stmt = mysqli_stmt_init($conn);

    if(!isset($year)) {

        $sql = "SELECT 
        `id`, 
        `name`, 
        `year` 
        FROM `items` 
        WHERE `name` LIKE ? 
        LIMIT 5
        ;";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit;
        }

        mysqli_stmt_bind_param($stmt, "s", $input);

    } else {

        $sql = "SELECT 
        `id`, 
        `name`, 
        `year` 
        FROM `items` 
        WHERE `name` LIKE ? 
        AND `year` LIKE ? 
        LIMIT 5
        ;";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit;
        }

        mysqli_stmt_bind_param($stmt, "ss", $input, $year);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    return $items;
}

if(isset($_POST['createSearch'])) {
    
    require_once("conn/dbh.php");
    $items = fetchQuickSearch($conn, rtrim($_POST['input'])); // rtrim tar bort mellanrum i början eller slutet på strängen
    echo json_encode($items);
}