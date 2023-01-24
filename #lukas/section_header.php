<?php

require_once("section_header_functions.php");
if(!isset($_GET['uid'])) { $_GET['uid'] = null; } // för att undvika error-meddelandet "undefined array key" nedan
renderHeader($_SESSION['useruid'], $_GET['uid']); 

?>