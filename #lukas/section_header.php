<?php

require_once("section_header_functions.php");

// för att undvika error-meddelandet "undefined array key" nedan
if(!isset($_GET['uid'])) { 
    $item_uid = null; 
} else {
    $item_uid = $_GET['uid']; 
}
if(!isset($_SESSION['useruid'])) { 
    $user_uid = null; 
} else {
    $user_uid = $_SESSION['useruid']; 
}

renderHeader($user_uid, $item_uid); 

?>