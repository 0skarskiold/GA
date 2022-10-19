<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<?php

$x = 5;

function f() {
    $y = 10;
    echo $GLOBALS['x']; // =10 (not recommended to be used this way)
}

f();

echo $_GET['name']
echo $_POST['name2']

?>

<form method="GET"> <!--get method-->
    <input type="hidden" name="name" value="Lukas">
    <button type="submit">Press</button>
</form>

<form method="GET"> <!--post method, som get fast osynlig i url:en-->
    <input type="hidden" name="name2" value="Lukas2">
    <button type="submit">Press</button>
</form>

<?php

$_COOKIE;
$_SESSION;

session_start();

setcookie("name", "Daniel", time() + 86400);

$_SESSION['username'] = "luk48s";

if(!isset($_SESSION['username'])) {
    echo "not logged in";
} else {
    echo "youre logged in";
}




?>



</body>
</html>