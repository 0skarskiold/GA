<?php

function renderHeader($user_uid, $item_id) {

    if(isset($user_uid)) {
        $profile = '<a href="/users/'.$user_uid.'" class="button">Profile</a>';
        $acc = '<a href="/section_header_receive.php?logout" class="button">Log Out</a>';
    } else {
        $profile = '';
        $acc = '<a href="/forms" class="button">Log in</a>';
    }
    if(isset($item_id)) {
        $create =
        '<form action="/create" method="post">
        <input type="hidden" name="itemid" value="'.$item_id.'">
        <button type="submit" name="type" value="review">Review</button>
        <button type="submit" name="type" value="log">Diary entry</button>
        </form>';
    } else {
        $create =
        '<form action="/create" method="post">
        <button type="submit" name="type" value="review">Review</button>
        <button type="submit" name="type" value="log">Diary entry</button>
        </form>';
    }

    $html = 
    '<header>
    <a href="/" class="logo"><img src="" alt="Website logo"></a>
    <nav>
    <a href="/browse" class="button">Browse</a>
    '.$profile.'
    <form action="/section_header_receive.php" method="get" id="search_form">
    <input type="text" name="search" placeholder="Search">
    <button type="submit" name="submit-search" class="button">Search</button>
    </form>
    '.$acc.'
    <p>Create:</p>
    '.$create.'
    </nav>
    </header>';

    echo $html;
    return;
}