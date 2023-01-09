<?php
require_once("list_functions.inc.php");
$genres = retrieveGenres($conn);
$tags = retrieveTags($conn);