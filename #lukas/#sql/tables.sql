CREATE TABLE users (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    `email` text NOT NULL,
    `uid` text NOT NULL,
    `pwd` text NOT NULL,
    PRIMARY KEY (`user_id` AUTO_INCREMENT)
);

CREATE TABLE user_settings (
    `user_id` int UNIQUE NOT NULL,
    `pronouns` text NOT NULL,
    `biography` text NOT NULL,
    `links` text NOT NULL,
    `color_theme_id` int NOT NULL DEFAULT 0,
    PRIMARY KEY (`user_id` AUTO_INCREMENT),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`color_theme_id`) REFERENCES `color_themes`(`id`) ON DELETE CASCADE
);

CREATE TABLE user_favorites (
    `user_id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `number` int ENUM(1,2,3,4),
    PRIMARY KEY (`user_id` AUTO_INCREMENT),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE color_themes (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    `first_color_hex` text NOT NULL, 
    `second_color_hex` text NOT NULL,
    `third_color_hex` text NOT NULL,
    `fourth_color_hex` text, -- ?: inte nödvändig
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE follow ( -- för att kolla vem som följer vem
    `id` int UNIQUE NOT NULL,
    `from_id` int NOT NULL, -- den som följer
    `to_id` int NOT NULL, -- den som följs
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`from_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`to_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- CREATE TABLE chats (); -- så att folk kan diskutera

CREATE TABLE items (
    `id` int UNIQUE NOT NULL,
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
    `rating` float DEFAULT 0,
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE attributes_series (
    `series_id` int UNIQUE NOT NULL, -- för att koppla
    `length_episodes` int NOT NULL, -- längden i antal avsnitt
    `length_avg_minutes` int NOT NULL, -- avsnittens genomsnittliga längd
    `finale_year` int, -- NULL om pågående
    `finale_month` int,
    `finale_day` int,
    PRIMARY KEY (`series_id`),
    FOREIGN KEY (`series_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE attributes_season (
    `season_id` int UNIQUE NOT NULL, -- för att koppla
    `series_id` int NOT NULL, -- för att koppla till serie
    `number` int NOT NULL, -- längden i antal avsnitt
    PRIMARY KEY (`season_id`),
    FOREIGN KEY (`season_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
    FOREIGN KEY (`series_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE attributes_episodes (
    `episode_id` int UNIQUE NOT NULL, -- för att koppla
    `series_id` int NOT NULL , -- för att koppla till serie
    `number_in_season` int NOT NULL,
    `number_total` int NOT NULL,
    PRIMARY KEY (`episode_id`),
    FOREIGN KEY (`episode_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`series_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE attach_films_versions (
    `id` int UNIQUE NOT NULL,
    `original_id` int NOT NULL, -- t.ex. theatrical cut
    `alternate_id` int NOT NULL, -- t.ex. director's cut
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`original_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`alternate_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE collections (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    `description` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE attach_items_collections (
    `id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `collection_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`collection_id`) REFERENCES `collections`(`id`) ON DELETE CASCADE
);

CREATE TABLE genres (
    `id` int UNIQUE NOT NULL,
    `type` ENUM(),
    `name` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE attach_items_genres (
    `id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `genre_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`genre_id`) REFERENCES `genres`(`id`) ON DELETE CASCADE
);

CREATE TABLE subgenres (
    `id` int UNIQUE NOT NULL ,
    `name` text NOT NULL,
    `genre_id` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`genre_id`) REFERENCES `genres`(`id`) ON DELETE CASCADE
    -- exempel: mystery och whodunit
    -- exempel: crime och whodunit
    -- exempel: crime och heist
    -- exempel: animation och 2D, cel, 3D eller stop-motion
);

CREATE TABLE attach_items_subgenres (
    `id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `sub_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`sub_id`) REFERENCES `subgenres`(`id`) ON DELETE CASCADE
);

CREATE TABLE tags (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE attach_items_tags (
    `id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `tag_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE
);

CREATE TABLE crew (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    `info` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE attach_items_crew (
    `id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `person_id` int NOT NULL,
    `role` ENUM('director','screenwriter','story','cinematographer','composer','actor'),
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`person_id`) REFERENCES `crew`(`id`) ON DELETE CASCADE
);

CREATE TABLE studios (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    `info` text NOT NULL,
    `link` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT)
);

CREATE TABLE attach_items_studios (
    `id` int UNIQUE NOT NULL,
    `item_id` int NOT NULL,
    `studio_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`studio_id`) REFERENCES `studios`(`id`) ON DELETE CASCADE
);

-- CREATE TABLE extras (); -- behind the scenes och featurette

CREATE TABLE completions (
    `id` int UNIQUE NOT NULL,
    `user_id` int NOT NULL,
    `item_id` int NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM(NULL,0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0,4.5,5.0), -- NULL innebär ingen rating
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE logs (
    `id` int UNIQUE NOT NULL,
    `user_id` int NOT NULL,
    `item_id` int NOT NULL,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM(NULL,0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0,4.5,5.0),
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE reviews (
    `id` int UNIQUE NOT NULL,
    `user_id` int NOT NULL,
    `item_id` int NOT NULL,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM(NULL,0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0,4.5,5.0),
    `text` text NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE attach_logs_reviews ( -- man ska kunna koppla flera recensioner till en logg
    `id` int UNIQUE NOT NULL,
    `log_id` int NOT NULL,
    `review_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`log_id`) REFERENCES `logs`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`review_id`) REFERENCES `reviews`(`id`) ON DELETE CASCADE
);

CREATE TABLE lists (
    `id` int UNIQUE NOT NULL,
    `user_id` int NOT NULL,
    `name` text NOT NULL,
    `description` text NOT NULL,
    `date` date NOT NULL,
    `private` bit NOT NULL, -- 1 om den är privat, 0 om public
    `ranking` bit NOT NULL -- 1 om den är rankad, 0 om vanlig
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE attach_lists_items (
    `id` int UNIQUE NOT NULL,
    `list_id` int NOT NULL,
    `item_id` int NOT NULL,
    `number` int NOT NULL,
    `note` text NOT NULL, -- listskaparen kan koppla en anteckning som exempelvis beskriver varför saken är inkluderad
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`list_id`) REFERENCES `lists`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
);

CREATE TABLE game_platforms (
    `id` int UNIQUE NOT NULL,
    `name` text NOT NULL,
    `studio_id` int,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`studio_id`) REFERENCES `studios`(`id`) ON DELETE CASCADE -- nintendo för switch, sony för ps4 osv.
);

CREATE TABLE attach_games_platforms (
    `id` int UNIQUE NOT NULL,
    `game_id` int NOT NULL,
    `platform_id` int NOT NULL,
    PRIMARY KEY (`id` AUTO_INCREMENT),
    FOREIGN KEY (`game_id`) REFERENCES `items`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`platform_id`) REFERENCES `game_platforms`(`id`) ON DELETE CASCADE
);
