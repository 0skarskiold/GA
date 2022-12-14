CREATE TABLE users (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `email` text NOT NULL,
    `uid` text NOT NULL,
    `pwd` text NOT NULL
);

CREATE TABLE user_settings (
    `user_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `pronouns` text NOT NULL,
    `biography` text NOT NULL,
    `links` text NOT NULL,
    `color_theme_id` int NOT NULL DEFAULT 0
);

CREATE TABLE user_favorites (
    `user_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `number` ENUM('1','2','3','4')
);

CREATE TABLE color_themes (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `first_color_hex` text NOT NULL, 
    `second_color_hex` text NOT NULL,
    `third_color_hex` text NOT NULL,
    `fourth_color_hex` text -- ?: inte nödvändig
);

CREATE TABLE follow ( -- för att kolla vem som följer vem
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `from_id` int NOT NULL, -- den som följer
    `to_id` int NOT NULL -- den som följs
);

-- CREATE TABLE chats (); -- så att folk kan diskutera

CREATE TABLE items (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `type` ENUM('feature_film', 'short_film', 'series', 'season', 'episode', 'mini_series', 'game', 'other'),
    `name` text NOT NULL, -- exempel för säsonger: Season 1
    `uid` text NOT NULL, -- exempelvis breaking-bad-2008 -- ska vara unikt inom typgruppen -- om avsnitt: exempelvis breaking-bad-2008/[säsong]/[nummer]-[avsnittets-namn] -- om det finns två av samma titel från samma år: example-title-20XX och example-title-20XX-2
    `year` int NOT NULL,
    `month` int NOT NULL,
    `day` int NOT NULL,
    `description` text, -- beskrivning -- NULL för säsonger
    `tagline` text,
    `length` int NOT NULL, -- filmer: minuter, serier: antal säsonger, säsonger: antal avsnitt, avsnitt: minuter, spel: timmar (genomsnitt, avrundas uppåt)
    `completions` int NOT NULL DEFAULT 0,
    `completions_week` int NOT NULL DEFAULT 0,
    `completions_month` int NOT NULL DEFAULT 0,
    `rating` float DEFAULT 0
);

CREATE TABLE attributes_series (
    `series_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, -- för att koppla
    `length_episodes` int NOT NULL, -- längden i antal avsnitt
    `length_avg_minutes` int NOT NULL, -- avsnittens genomsnittliga längd
    `finale_year` int, -- NULL om pågående
    `finale_month` int,
    `finale_day` int
);

CREATE TABLE attributes_season (
    `season_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, -- för att koppla
    `series_id` int NOT NULL, -- för att koppla till serie
    `number` int NOT NULL -- längden i antal avsnitt
);

CREATE TABLE attributes_episodes (
    `episode_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, -- för att koppla
    `series_id` int NOT NULL , -- för att koppla till serie
    `number_in_season` int NOT NULL,
    `number_total` int NOT NULL
);

CREATE TABLE versions (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id_1` int NOT NULL, -- t.ex. theatrical cut
    `item_id_2` int NOT NULL -- t.ex. director's cut
);

CREATE TABLE collections (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `description` text
);

CREATE TABLE items_collections (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `collection_id` int NOT NULL
);

CREATE TABLE genres (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
);

CREATE TABLE items_genres (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `genre_id` int NOT NULL
);

CREATE TABLE tags (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
);

CREATE TABLE items_tags (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `tag_id` int NOT NULL
);

CREATE TABLE crew (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
    `description` text
    -- plats för info.txt och bild.jpg kommer genereras utefter id
);

CREATE TABLE items_crew (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `artist_id` int NOT NULL,
    `role` ENUM('director','writer','cinematographer','composer','actor'),
    `character` text -- om skådis
);

CREATE TABLE studios (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `link` text NOT NULL
    -- plats för info och logga genereras utefter id:t
);

CREATE TABLE items_studios (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `studio_id` int NOT NULL
);

-- CREATE TABLE extras (); -- behind the scenes och featurette

CREATE TABLE completions (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `item_id` int NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5','5.0') DEFAULT NULL -- NULL innebär ingen rating
);

CREATE TABLE logs (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `item_id` int NOT NULL,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5','5.0') DEFAULT NULL
);

CREATE TABLE reviews (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `item_id` int NOT NULL,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5','5.0') DEFAULT NULL,
    `text` text NOT NULL
);

CREATE TABLE lists (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `name` text NOT NULL,
    `description` text NOT NULL,
    `date` date NOT NULL,
    `private` bit NOT NULL, -- 1 om den är privat, 0 om public
    `ranking` bit NOT NULL -- 1 om den är rankad, 0 om vanlig
);

CREATE TABLE lists_items (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `list_id` int NOT NULL,
    `item_id` int NOT NULL,
    `number` int NOT NULL,
    `note` text NOT NULL -- listskaparen kan koppla en anteckning som exempelvis beskriver varför saken är inkluderad
);

CREATE TABLE logs_reviews_lists ( -- man ska kunna koppla flera recensioner till en logg
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `log_id` int NOT NULL,
    `review_id` int NOT NULL,
    `list_id` int NOT NULL,
    `list_number` int NOT NULL -- detta item måste vara samma som itemet för recensionen
);

CREATE TABLE platforms (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `studio_id` int
);

CREATE TABLE games_platforms (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `game_id` int NOT NULL,
    `platform_id` int NOT NULL
);
