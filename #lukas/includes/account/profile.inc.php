<?php

require_once("includes/account/acc_functions.inc.php");

$user = fetchUser($conn, $_GET['uid']);
$following = isFollowing($conn, $_SESSION['userid'], $user['id']);