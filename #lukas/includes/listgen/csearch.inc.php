<?php

if(isset($_POST['scsearch'])) {
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
    $stmt = mysqli_stmt_init($conn);
    
    $input = rtrim($_POST['input']);
    $arr = explode(" ", $input);

    for($i = 0; $i < count($arr); $i++) {
        if(is_numeric($arr[$i])) {
            $year = "%".$arr[$i]."%";
            array_splice($arr, $i, 1);
            $input = join($arr);
            break;
        }
    }

    $input = "%".$input."%";

    if(!$year) {
        $sql = "SELECT `id`, `name`, `year` FROM `items` WHERE `name` LIKE ? LIMIT 5;";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $input);
    } else {
        $sql = "SELECT `id`, `name`, `year` FROM `items` WHERE `name` LIKE ? AND `year` LIKE ? LIMIT 5;";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $input, $year);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    echo json_encode($items);
}