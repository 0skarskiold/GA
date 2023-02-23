<?php

function renderHeader($user_uid, $item_id) {

    if($item_id) {
        $insert_id = '<input type="hidden" name="itemid" value="'.$item_id.'">';
    } else {
        $insert_id = '';
    }
    if($user_uid) {

        $create = 
        '<form action="/create" method="get" class="create_form">
        '.$insert_id.'
        <select name="type">
        <option value="review">Review</option>
        <option value="log">Diary Entry</option>
        </select>
        <button class="button" type="submit">Create</button>
        </form>';

        $profile = '<a href="/user-'.$user_uid.'" class="button">Profile</a>';
        $acc = '<a href="/section_header_receive.php?logout" class="button">Log Out</a>';
    } else {
        $create = '';
        $profile = '';
        $acc = '<a href="/forms" class="button">Log in</a>';
    }

    $html = 
    '<header>
    <a href="/" class="button">Home</a>
    <a href="/browse" class="button">Browse</a>
    '.$profile.'
    <form action="/browse_recieve.php" method="get" class="search_form">
    <input class="search_bar" type="text" name="search" placeholder="Search">
    <button class="button" type="submit">Search</button>
    </form>
    '.$create.$acc.'
    </div>
    </nav>
    </header>';

    echo $html;
    return;
}