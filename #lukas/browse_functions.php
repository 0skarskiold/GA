<?php
require_once("universal_functions.php");

function fetchGenres($conn) {
    $sql = "SELECT * FROM `genres` ORDER BY `name`;";
    $result = mysqli_query($conn, $sql);
    $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $genres;
}

function fetchTags($conn) {
    $sql = "SELECT * FROM `tags` ORDER BY `name`;";
    $result = mysqli_query($conn, $sql);
    $tags = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $tags;
}

function renderBrowseFilter($conn, $type) {

    $genres = fetchGenres($conn);
    $glist = '';
    foreach($genres as $genre) {
        $glist .= '<option value="'.$genre['id'].'">'.$genre['name'].'</option>';
    }

    $tags = fetchTags($conn);
    $tlist = '';
    foreach($tags as $tag) {
        $tlist .= '<option value="'.$tag['id'].'">'.$tag['name'].'</option>';
    }

    $ylist = '';
    for ($y = date("Y")+1; $y >= 1870; $y--){
        if ($y % 10 == 0){
            $ylist .= '<option value="'.$y.'s">'.$y.'s</option>';
        }
        $ylist .= '<option value="'.$y.'">'.$y.'</option>';
    }

    if($type === 'browse') {

    } elseif($type === 'search') {
        
    } elseif($type === 'users') {

    } elseif($type === 'collection') {

    } elseif($type === 'artist') {

    } elseif($type === 'films') {

    } elseif($type === 's-films') {

    } elseif($type === 'series') {

    } elseif($type === 'm-series') {

    } elseif($type === 'series-s') {

    } elseif($type === 'series-e') {

    } elseif($type === 'games') {

    } elseif($type === 'books') {

    } else {
        return;
    }

    $html = 
    '<section id="filter">
    <form method="post">

    <div class="filter_segment">
    <div class="filter_option">
    <label for="sort-by">Sort by</label>
    <select name="sort-by">
        <option value="popularity">Popularity</option>
        <option value="rating">Rating</option>
        <option value="name">Name</option>
    </select>
    </div>

    <div class="filter_option extra">
    <select name="sort-by-popularity">
    <option value="week">This week</option>
    <option value="month">This month</option>
    <option value="all-time">All time</option>
    </select>
    </div>

    <div class="filter_option">
    <label for="genre">Genre</label>
    <select name="genre">
    <option value="any">Any</option>
    '.$glist.'
    </select>
    </div>

    <div class="filter_option">
    <label for="tag">Tag</label>
    <select name="tag">
    <option value="any">Any</option>
    '.$tlist.'
    </select>
    </div>

    <div class="filter_option">
    <label for="year">Year</label>
    <select name="year">
    <option value="any">Any</option>
    '.$ylist.'
    </select>
    </div>
    </div>

    <div class="filter_segment">
    <div class="filter_option">
    <label for="type-film">Films</label>
    <input type="checkbox" name="type-film" checked>
    </div>

    <div class="filter_option">
    <label for="type-short-film">Short-films</label>
    <input type="checkbox" name="type-short-film" checked>
    </div>

    <div class="filter_option">
    <label for="type-series">Series</label>
    <input type="checkbox" name="type-series" checked>
    </div>

    <div class="filter_option">
    <label for="type-mini-series">Mini-series</label>
    <input type="checkbox" name="type-mini-series" checked>
    </div>

    <div class="filter_option">
    <label for="type-series-s">Seasons</label>
    <input type="checkbox" name="type-series-s" checked>
    </div>

    <div class="filter_option">
    <label for="type-series-e">Episodes</label>
    <input type="checkbox" name="type-series-e" checked>
    </div>

    <div class="filter_option">
    <label for="type-game">Games</label>
    <input type="checkbox" name="type-game" checked>
    </div>

    <div class="filter_option">
    <label for="type-book">Books</label>
    <input type="checkbox" name="type-book" checked>
    </div>
    </div>

    <div class="button_container">
    <button type="submit" class="button">Apply</button>
    <div class="arrow u"></div>
    </div>

    </form>
    </section>';

    echo $html;
    return;
}

function fetchListBrowse($conn, $filter_arr, $type) {

    if($type === 'browse') {

        $stmt = mysqli_stmt_init($conn);
        $values = [];
        $select = "";
        $from = "";
        $where = "";
        $from = "FROM `items`";


        if(!isset($filter_arr["sortby"])) {
            $factor = "`popularity`";
            $tmp = date('Y-m-d', strtotime('-1 week'));
            $select .=  // todo: ändra så att om entry och rating är från samma tillfälle så räknas endast en av dem med
            "(
                (SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id` AND `ratings`.`created_date` > '$tmp') 
                + 
                (SELECT COUNT(*) FROM `entries` WHERE `entries`.`item_id` = `items`.`id` AND `entries`.`log_date` > '$tmp')
            ) AS `popularity`,";
            $order = "DESC";

        } else {

            switch($filter_arr["sortby"]) {
                case "rating-high":
                    $factor = "`rating`";
                    $select = "(SELECT AVG(`rating`) FROM `ratings` WHERE `item_id` = `items`.`id`) AS `rating`";
                    $order = "DESC";
                    break;
                case "rating-low":
                    $factor = "`rating`";
                    $select = "(SELECT AVG(`rating`) FROM `ratings` WHERE `item_id` = `items`.`id`) AS `rating`";
                    $order = "ASC";
                    break;
                case "popularity-week":
                    $factor = "`popularity`";
                    $tmp = date('Y-m-d', strtotime('-1 week'));
                    $select .= 
                    "(
                        (SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id` AND `ratings`.`created_date` > '$tmp')
                        + 
                        (SELECT COUNT(*) FROM `entries` WHERE `entries`.`item_id` = `items`.`id` AND `entries`.`log_date` > '$tmp')
                    ) AS `popularity`,";
                    $order = "DESC";
                    break;
                case "popularity-month":
                    $factor = "`popularity`";
                    $tmp = date('Y-m-d', strtotime('-1 month'));
                    $select .= 
                    "(
                        (SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id` AND `ratings`.`created_date` > '$tmp')
                        + 
                        (SELECT COUNT(*) FROM `entries` WHERE `entries`.`item_id` = `items`.`id` AND `entries`.`log_date` > '$tmp')
                    ) AS `popularity`,";
                    $order = "DESC";
                    break;
                case "popularity-all":
                    $factor = "`popularity`";
                    $select .= "(SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id`) AS `popularity`,";
                    $order = "DESC";
                    break;
                case "title":
                    $factor = "`items`.`name`";
                    $order = "ASC";
                    break;
                default:
                    $factor = "`popularity`";
                    $tmp = date('Y-m-d', strtotime('-1 week'));
                    $select .= 
                    "(
                        (SELECT COUNT(*) FROM `ratings` WHERE `ratings`.`item_id` = `items`.`id` AND `ratings`.`created_date` > '$tmp')
                        + 
                        (SELECT COUNT(*) FROM `entries` WHERE `entries`.`item_id` = `items`.`id` AND `entries`.`log_date` > '$tmp')
                    ) AS `popularity`,";
                    $order = "DESC";
                    break;
            }
        }


        if(isset($filter_arr['page'])) {
            $offset = "OFFSET ".(160*($filter_arr['page']-1));
        } else {
            $offset = "";
        }


        if(isset($filter_arr["genre"]) && $filter_arr["genre"] !== "any") {

            $from .= " INNER JOIN `items_genres` ON `items`.`id` = `items_genres`.`item_id`";
            $where = "WHERE `items_genres`.`genre_id` = ?";
            array_push($values, intval($filter_arr['genre']));
        }

    
        if(isset($filter_arr["tag"]) && $filter_arr["tag"] !== "any") {

            $from .= " INNER JOIN `items_tags` ON `items`.`id` = `items_tags`.`item_id`";

            if($where !== "") {
                $where .= " AND `items_tags`.`tag_id` = ?";
            } else {
                $where = "WHERE `items_tags`.`tag_id` = ?";
            }

            array_push($values, intval($filter_arr['tag']));
        }
        
    
        if(isset($filter_arr['year']) && $filter_arr['year'] !== "any") {
    
            if(is_numeric($filter_arr['year'])) {

                $year = intval($filter_arr['year']);
                $tmp = "= ?";
                array_push($values,$year);
    
            } elseif($filter_arr['year'][-1] === "s") {
    
                $tmp = intval(rtrim($filter_arr['year'], "s"));
                $year = [];
    
                for($y = $tmp; $y <= $tmp+9; $y++) { 
                    array_push($year, $y); 
                }

                $tmp = "IN (".str_repeat('?, ', 9)."?)";
                array_push($values,...$year);
            } 

            if($where !== "") {
                $where .= " AND `items`.`year` ".$tmp;
            } else {
                $where = "WHERE `items`.`year` ".$tmp;
            }
        }

        
        $types = [];
        if(isset($filter_arr['type-film'])) {
            array_push($types,"film");
        }
        if(isset($filter_arr['type-short-film'])) {
            array_push($types,"short-film");
        }
        if(isset($filter_arr['type-series'])) {
            array_push($types,"series");
        }
        if(isset($filter_arr['type-mini-series'])) {
            array_push($types,"mini-series");
        }
        if(isset($filter_arr['type-series-s'])) {
            array_push($types,"series-s");
        }
        if(isset($filter_arr['type-series-e'])) {
            array_push($types,"series-e");
        }
        if(isset($filter_arr['type-game'])) {
            array_push($types,"game");
        }
        if(isset($filter_arr['type-book'])) {
            array_push($types,"book");
        }
        if($types !== []) {

            $tmp = "IN (".str_repeat('?, ', count($types)-1)."?)";

            if($where !== "") {
                $where .= " AND `items`.`type` ".$tmp;
            } else {
                $where = "WHERE `items`.`type` ".$tmp;
            }

            array_push($values,...$types);
        }

        $param_str = "";

        foreach($values as $val) {

            if(gettype($val) === "integer") {
                $param_str .= "i";

            } elseif(gettype($val) === "string") {
                $param_str .= "s";
                
            } elseif(gettype($val) === "double") {
                $param_str .= "d";

            } else {
                return [];
            }
        }
    
    
        $sql = "SELECT 
        `items`.`id`,
        `items`.`name`,
        `items`.`type`,
        `items`.`uid`,
        $select
        `items`.`year` 
        $from 
        $where
        ORDER BY $factor $order 
        LIMIT 160 
        $offset
        ;";

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            return [];
        }

        if(strlen($param_str) > 0) { 
            mysqli_stmt_bind_param($stmt, $param_str, ...$values); 
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        return $items;

    } elseif($type === "search") {

        // if(isset($filter_arr["search"])) {
        //     $search = $filter_arr["search"];
        // } else {
        //     $search = false;
        // }

        // if($search) {
        //     if($where !== "") {
        //         $where .= " AND `items`.`name` LIKE ?";
        //     } else {
        //         $where = "WHERE `items`.`name` LIKE ?";
        //     }
        //     $search_str = "'%".$search."%'";
        //     array_push($values,$search_str); 
        // }

    } elseif($type === "collection") {

        // if($collection) {
        //     $from .= " INNER JOIN `items_collections` ON `items`.`id` = `items_collections`.`item_id`";
        //     if($where !== "") {
        //         $where .= " AND `items_collections`.`collection_id` = ?";
        //     } else {
        //         $where = "WHERE `items_collections`.`collection_id` = ?";
        //     }
        //     array_push($values,$collection); 
        // }

    } elseif($type === "artist") {

        // if($artist) {
        //     $from .= " INNER JOIN `items_crew` ON `items`.`id` = `items_crew`.`item_id`";
        //     if($where !== "") {
        //         $where .= " AND `items_crew`.`artist_id` = ?";
        //     } else {
        //         $where = "WHERE `items_crew`.`artist_id` = ?";
        //     }
        //     array_push($values,$artist); 
        // }

    } elseif($type === "users") {

        // $sql = "SELECT `id`, `name`, `uid` FROM `users` ORDER BY `name`;";
        // $result = mysqli_query($conn, $sql);
        // $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // mysqli_free_result($result);
        // return $users;

    }
}

function renderListBrowse($fetched, $type) {

    if($type === 'browse') {

        if(count($fetched) > 0) {
            $list = '';
            foreach($fetched as $item) {
                $list .= prepareItemContainer($item['name'], $item['uid'], $item['year'], $item['type'], 'list');
            }
        } else {
            $list = '';
        }

        $html = 
        '<section class="list_section grid" list-name="browse">
        <h2>Browse</h2>
        <p>Filters:</p>
        <div class="list_container" list-name="browse">
        <div class="list_limits" list-name="browse">
        <ul class="list" list-name="browse">
        '.$list.'
        </ul>
        </div>
        </div>
        </section>';

        echo $html;
        return;

    } elseif($type === 'users') {

        if(count($fetched) > 0) {
            $list = '<ul>';

            foreach($fetched as $user) {

                $path = "/profile-imgs/".$user['uid'].".jpg";
    
                $list .= 
                '<li class="user_container">
                <a href="/'.$user['uid'].'">
                <h2>'.$user['username'].'</h2>
                <h3>@'.$user['uid'].'</h3>
                <img class="poster" src="'.$path.'" alt="Profile picture for '.$user['username'].'">
                </a>
                </li>';
            }
            $list .= '</ul>';
        } else {
            $list = '';
        }

        $html = 
        '<section id="browse_users">
        '.$list.'
        </section>';

        echo $html;
        return;

    } elseif($type === 'crew') {

    } else {
        return;
    }
}