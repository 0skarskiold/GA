CREATE TABLE users (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `email` varchar(128) NOT NULL,
    `uid` varchar(128) NOT NULL,
    `pwd` varchar(128) NOT NULL
);

CREATE TABLE user_settings (
    `user_id` int(11) PRIMARY KEY NOT NULL,
    `pronouns` varchar(128) NOT NULL DEFAULT "They/Them",
    `profile_img` bit NOT NULL DEFAULT 0, -- 0 innebär att de inte har en profilbild
    `bg_img` bit NOT NULL DEFAULT 0, -- 0 innebär att de inte har en bakgrundsbild -- ska vara baserat på ett item
    `biography` text NOT NULL,
    `country` varchar(128) NOT NULL,
    `language_id` int(11) ENUM("Swedish", "English") DEFAULT "English",
    `links` varchar(128) NOT NULL, -- till typ portfolio/arbete
    `color_theme_id` int(11) NOT NULL DEFAULT 0
);

CREATE TABLE user_favorites (
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `number` ENUM('1', '2', '3', '4')
);

CREATE TABLE color_themes (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `first_color_hex` varchar(128) NOT NULL, 
    `second_color_hex` varchar(128) NOT NULL,
    `third_color_hex` varchar(128) NOT NULL,
    `fourth_color_hex` varchar(128) -- ?: inte nödvändig
);

CREATE TABLE follow ( -- för att kolla vem som följer vem
    `from_id` int(11) NOT NULL, -- den som följer
    `to_id` int(11) NOT NULL -- den som följs
);

-- CREATE TABLE chats (); -- så att folk kan diskutera

CREATE TABLE items (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `type` ENUM('feature_film', 'short_film', 'series', 'season', 'episode', 'mini_series', 'game', 'other'),
    `name` varchar(128) NOT NULL, -- säsonger: nummret
    `url_name` varchar(128) NOT NULL, -- exempelvis breaking-bad-2008 -- ska vara unikt inom typgruppen -- om det finns två av samma titel från samma år: example-title-20XX och example-title-20XX-2
    `year` int(5) NOT NULL,
    `month` int(2) NOT NULL,
    `day` int(2) NOT NULL,
    `description` text, -- beskrivning -- NULL för säsonger
    `length` int(6) NOT NULL, -- filmer: minuter, serier: antal säsonger, säsonger: antal avsnitt, avsnitt: minuter, spel: timmar (genomsnitt, avrundas uppåt)
    `completions` int(11) NOT NULL DEFAULT 0,
    `completions_week` int(11) NOT NULL DEFAULT 0,
    `completions_month` int(11) NOT NULL DEFAULT 0,
    `rating` float(5) NOT NULL DEFAULT 0
    -- IMAGES: sökvägar för affischer, bakgrundsbilder och andra relaterade bilder kommer struktureras efter typ (film, serie, osv.) och url-namn
);

CREATE TABLE attributes_series (
    `id` int(11) NOT NULL, -- för att koppla
    `length_episodes` int(6) NOT NULL, -- längden i antal avsnitt
    `length_avg_minutes` int(6) NOT NULL, -- avsnittens genomsnittliga längd
    `finale_year` int(5), -- NULL om pågående
    `finale_month` int(2),
    `finale_day` int(2)
);

CREATE TABLE attach_seasons_series (
    `id` int(11) NOT NULL, -- för att koppla till item
    `series_id` int(11) NOT NULL, -- för att koppla till serie
);

CREATE TABLE attach_films_versions (
    `original_id` int(11) NOT NULL, -- t.ex. theatrical cut
    `alternate_id` int(11) NOT NULL -- t.ex. director's cut
);

CREATE TABLE collections (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `description` text NOT NULL
);

CREATE TABLE attach_items_collections (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `collection_id` int(11) NOT NULL
);

CREATE TABLE genres (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL
);

CREATE TABLE attach_items_genres (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `genre_id` int(11) NOT NULL
);

CREATE TABLE subgenres (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL
);

CREATE TABLE attach_genres_subgenres (
    `genre_id` int(11) NOT NULL,
    `sub_id` int(11) NOT NULL
    -- exempel: mystery och whodunit
    -- exempel: crime och whodunit
    -- exempel: crime och heist
    -- exempel: animation och 2D, cel, 3D eller stop-motion
);

CREATE TABLE attach_items_subgenres (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `sub_id` int(11) NOT NULL
);

CREATE TABLE tags (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL
);

CREATE TABLE attach_items_tags (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `tag_id` int(11) NOT NULL
);

CREATE TABLE crew_roles (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL
);

CREATE TABLE crew (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL
    `info` text NOT NULL
);

CREATE TABLE attach_items_crew (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `person_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
);

CREATE TABLE studios (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `info` text NOT NULL
);

CREATE TABLE attach_items_studios (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `studios_id` int(11) NOT NULL
);

-- CREATE TABLE extras (); -- behind the scenes och featurette

CREATE TABLE completions (
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `like` bit NOT NULL,
    `rating` float(2) NOT NULL
);

CREATE TABLE logs (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` float(2) -- 0 fungerar -- NULL innebär ingen rating
);

CREATE TABLE reviews (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` float(2),
    `text` text NOT NULL
);

CREATE TABLE attach_logs_reviews ( -- man ska kunna koppla flera recensioner till en logg
    `log_id` int(11) NOT NULL,
    `review_id` int(11) NOT NULL
);

CREATE TABLE lists (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `user_id` int(11) NOT NULL,
    `name` varchar(128) NOT NULL,
    `description` text NOT NULL,
    `date` date NOT NULL,
    `private` bit NOT NULL, -- 1 om den är privat, 0 om public
    `ranking` bit NOT NULL -- 1 om den är rankad, 0 om vanlig
);

CREATE TABLE attach_lists_items (
    `list_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `number` int(11) NOT NULL,
    `note` text NOT NULL -- listskaparen kan koppla en anteckning som exempelvis beskriver varför saken är inkluderad
);

CREATE TABLE game_platforms (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `studio_id` int(11),
);

CREATE TABLE attach_games_platforms (
    `game_id` int(11) NOT NULL,
    `platform_id` int(11) NOT NULL,
);
