<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbh.inc.php';
require_once("acc_functions.inc.php");

$from_id = $_SESSION['userid'];
$to_id = $_POST['toid'];

followUser($conn, $from_id, $to_id);