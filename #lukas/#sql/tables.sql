CREATE TABLE users (
    `id` int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` text NOT NULL,
    `email` text NOT NULL,
    `uid` text NOT NULL,
    `pwd` text NOT NULL
);

CREATE TABLE user_settings (
    `user_id` int PRIMARY KEY NOT NULL,
    `pronouns` text NOT NULL DEFAULT "They/Them",
    `profile_img` bit NOT NULL DEFAULT 0, -- 0 innebär att de inte har en profilbild
    `bg_img` bit NOT NULL DEFAULT 0, -- 0 innebär att de inte har en bakgrundsbild -- ska vara baserat på ett item
    `biography` text NOT NULL,
    -- `country` text NOT NULL,
    -- `language` text ENUM("Swedish", "English") DEFAULT "English", -- språket på själva sidan
    `links` text NOT NULL, -- till typ portfolio/arbete
    `color_theme_id` int NOT NULL DEFAULT 0 FOREIGN KEY REFERENCES `color_themes`(`id`) ON DELETE CASCADE
);

CREATE TABLE user_favorites (
    `user_id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `number` int ENUM(1,2,3,4)
);

CREATE TABLE color_themes (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `first_color_hex` text NOT NULL, 
    `second_color_hex` text NOT NULL,
    `third_color_hex` text NOT NULL,
    `fourth_color_hex` text -- ?: inte nödvändig
);

CREATE TABLE follow ( -- för att kolla vem som följer vem
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `from_id` int NOT NULL FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE, -- den som följer
    `to_id` int NOT NULL FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE -- den som följs
);

-- CREATE TABLE chats (); -- så att folk kan diskutera

CREATE TABLE items (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
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
    `series_id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE, -- för att koppla
    `length_episodes` int NOT NULL, -- längden i antal avsnitt
    `length_avg_minutes` int NOT NULL, -- avsnittens genomsnittliga längd
    `finale_year` int, -- NULL om pågående
    `finale_month` int,
    `finale_day` int
);

CREATE TABLE attributes_season (
    `season_id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE, -- för att koppla
    `series_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE, -- för att koppla till serie
    `number` int NOT NULL, -- längden i antal avsnitt
);

CREATE TABLE attributes_episodes (
    `episode_id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE, -- för att koppla
    `series_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE, -- för att koppla till serie
    `number_season` int NOT NULL,
    `number_total` int NOT NULL
);

CREATE TABLE attach_films_versions (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `original_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE, -- t.ex. theatrical cut
    `alternate_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE -- t.ex. director's cut
);

CREATE TABLE collections (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `description` text NOT NULL
);

CREATE TABLE attach_items_collections (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `collection_id` int NOT NULL FOREIGN KEY REFERENCES `collections`(`id`) ON DELETE CASCADE
);

CREATE TABLE genres (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
);

CREATE TABLE attach_items_genres (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `genre_id` int NOT NULL FOREIGN KEY REFERENCES `genres`(`id`) ON DELETE CASCADE
);

CREATE TABLE subgenres (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
);

CREATE TABLE attach_genres_subgenres (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `genre_id` int NOT NULL FOREIGN KEY REFERENCES `genres`(`id`) ON DELETE CASCADE,
    `sub_id` int NOT NULL FOREIGN KEY REFERENCES `subgenres`(`id`) ON DELETE CASCADE
    -- exempel: mystery och whodunit
    -- exempel: crime och whodunit
    -- exempel: crime och heist
    -- exempel: animation och 2D, cel, 3D eller stop-motion
);

CREATE TABLE attach_items_subgenres (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `sub_id` int NOT NULL FOREIGN KEY REFERENCES `subgenres`(`id`) ON DELETE CASCADE
);

CREATE TABLE tags (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
);

CREATE TABLE attach_items_tags (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `tag_id` int NOT NULL FOREIGN KEY REFERENCES `tags`(`id`) ON DELETE CASCADE
);

CREATE TABLE crew_roles (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL
);

CREATE TABLE crew (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `info` text NOT NULL
);

CREATE TABLE attach_items_crew (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `person_id` int NOT NULL FOREIGN KEY REFERENCES `crew`(`id`) ON DELETE CASCADE,
    `role_id` int NOT NULL FOREIGN KEY REFERENCES `crew_roles`(`id`) ON DELETE CASCADE
);

CREATE TABLE studios (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `info` text NOT NULL
);

CREATE TABLE attach_items_studios (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `studios_id` int NOT NULL FOREIGN KEY REFERENCES `studios`(`id`) ON DELETE CASCADE
);

-- CREATE TABLE extras (); -- behind the scenes och featurette

CREATE TABLE completions (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `like` bit NOT NULL,
    `rating` float NOT NULL
);

CREATE TABLE logs (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM(NULL,0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0,4.5,5.0) -- NULL innebär ingen rating
);

CREATE TABLE reviews (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `date` date NOT NULL,
    `like` bit NOT NULL,
    `rating` ENUM(NULL,0.0,0.5,1.0,1.5,2.0,2.5,3.0,3.5,4.0,4.5,5.0),
    `text` text NOT NULL
);

CREATE TABLE attach_logs_reviews ( -- man ska kunna koppla flera recensioner till en logg
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `log_id` int NOT NULL FOREIGN KEY REFERENCES `logs`(`id`) ON DELETE CASCADE,
    `review_id` int NOT NULL FOREIGN KEY REFERENCES `reviews`(`id`) ON DELETE CASCADE
);

CREATE TABLE lists (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `user_id` int NOT NULL FOREIGN KEY REFERENCES `users`(`id`) ON DELETE CASCADE,
    `name` text NOT NULL,
    `description` text NOT NULL,
    `date` date NOT NULL,
    `private` bit NOT NULL, -- 1 om den är privat, 0 om public
    `ranking` bit NOT NULL -- 1 om den är rankad, 0 om vanlig
);

CREATE TABLE attach_lists_items (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `list_id` int NOT NULL FOREIGN KEY REFERENCES `lists`(`id`) ON DELETE CASCADE,
    `item_id` int NOT NULL FOREIGN KEY REFERENCES `items`(`id`) ON DELETE CASCADE,
    `number` int NOT NULL,
    `note` text NOT NULL -- listskaparen kan koppla en anteckning som exempelvis beskriver varför saken är inkluderad
);

CREATE TABLE game_platforms (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `name` text NOT NULL,
    `studio_id` int FOREIGN KEY REFERENCES `studios`(`id`) ON DELETE CASCADE
);

CREATE TABLE attach_games_platforms (
    `id` int NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
    `game_id` int NOT NULL FOREIGN KEY REFERENCES `games`(`id`) ON DELETE CASCADE,
    `platform_id` int NOT NULL FOREIGN KEY REFERENCES `game_platforms`(`id`) ON DELETE CASCADE
);
