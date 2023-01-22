<?php

// returnerar en tvådimensionell, associativ array av "items", dvs filmer, serier och spel, sorterad utefter angiven faktor, exempelvis genomsnittligt betyg eller popularitet
function retrieveSortedList($conn, $search, $types, $year, $genre, $tag, $artist, $collection, $factor, $order, $lim) {
    
    // validering
    
}

function retrieveUsers($conn) {

    $sql = "SELECT `id`, `name`, `uid` FROM `users` ORDER BY `name`;";

    $result = mysqli_query($conn, $sql);

    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $users;

}