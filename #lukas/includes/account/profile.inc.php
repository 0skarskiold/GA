<?php

require_once("includes/account/acc_functions.inc.php");

$user = fetchUser($conn, $_GET['uid']);
if(isset($_SESSION['userid'])) {
    $following = isFollowing($conn, $_SESSION['userid'], $user['id']);
}