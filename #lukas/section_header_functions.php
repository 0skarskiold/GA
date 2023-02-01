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
        $insert_id = '<input type="hidden" name="itemid" value="'.$item_id.'">';
    } else {
        $insert_id = '';
    }

    $html = 
    '<header>
    <a href="/" class="logo_container"><img class="logo" src="" alt="Website logo"></a>
    <nav>
    <a href="/browse" class="button">Browse</a>
    '.$profile.'
    <form action="/section_header_receive.php" method="get" class="search_form">
    <input class="search_bar" type="text" name="search" placeholder="Search">
    <button class="button" type="submit" name="submit-search">Search</button>
    </form>
    '.$acc.'
    <div class="dropdown_container create">
    <div class="open_dropdown">Create</div>
    <form class="dropdown_content" action="/create" method="post">
    '.$insert_id.'
    <button class="dropdown_option" type="submit" name="type" value="review">Review</button>
    <button class="dropdown_option" type="submit" name="type" value="log">Diary entry</button>
    </form>
    </div>
    </nav>
    </header>';

    echo $html;
    return;
}