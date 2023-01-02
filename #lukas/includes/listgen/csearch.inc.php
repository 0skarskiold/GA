<?php

if(isset($_POST['scsearch'])) {
    $input = $_POST['input'];

    $arr = explode(" ", $input);

    $year_str = "";

    for($i=0; $i < count($arr); $i++) {
        if(is_numeric($arr[$i])) {
            $year = $arr[$i];
            $year_str = "AND `year` LIKE '%".$year."%'";
            $input = join(array_splice($array, $i, 1));
            break;
        }
    }

    $sql = "SELECT `id`, `name`, `year` WHERE `name` LIKE '%".$input."%'".$year_str." LIMIT 5;";

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
}