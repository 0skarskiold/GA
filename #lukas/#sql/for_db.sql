CREATE TABLE users (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `first_name` varchar(128) NOT NULL,
    `last_name` varchar(128), -- kan vara tom
    `email` varchar(128) NOT NULL,
    `uid` varchar(128) NOT NULL,
    `pwd` varchar(128) NOT NULL
);

CREATE TABLE settings (
    `user_id` int(11) PRIMARY KEY NOT NULL,
    `theme_id` int(11) NOT NULL DEFAULT 0
    -- potentiella:
    -- pronouns
    -- profilbild
    -- bakgrundsbild
    -- biografi
    -- länkar (till typ portfolio/arbete)
    -- land
);

CREATE TABLE favorites (
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `number` int(1)
);

CREATE TABLE themes (
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

CREATE TABLE films_feature (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, -- identifierande nummer
    `name` varchar(128) NOT NULL,  -- namnet på filmen
    `date` date NOT NULL, -- släppsdatum
    `description` text NOT NULL, -- beskrivning
    `length` int(5) NOT NULL, -- i minuter
    `rating` float(2) NOT NULL DEFAULT 0, -- medelvärde på betyg från användare -- ?: uppdateras antingen varje gång någon betygsätter eller en gång per dag
    `multi` bit NOT NULL -- om det finns flera versioner kommer denna vara 1
    -- IMAGES: sökvägar för affischer, bakgrundsbilder och andra relaterade bilder kommer struktureras efter typ (film, serie, osv.) och id
    -- VIEWS: visningar räknas ut baserat på views-bordet, både popularitet över lag, samt popularitet över senaste veckan
);

CREATE TABLE films_alternate ( -- exempelvis theatrical version eller director's cut
    `film_id` int(11) NOT NULL, -- vilken film som versionen tillhör
    `version_name` varchar(128) NOT NULL, -- exempelvis "director's cut"
    `date` date NOT NULL, -- släppsdatum på versionen
    `description` text NOT NULL, -- förklarar hur denna versionen skiljer sig från den/de andra
    `length` int(5) NOT NULL, -- längden på versionen
    `rating` float(2) NOT NULL DEFAULT 0
);

CREATE TABLE films_short (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `date` date NOT NULL,
    `description` text NOT NULL,
    `length` int(5) NOT NULL,
    `rating` float(2) NOT NULL DEFAULT 0
);

CREATE TABLE series (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,  -- namnet på serien
    `description` text NOT NULL, -- beskrivning på serien
    `ongoing` bit NOT NULL DEFAULT 0, -- om serien är pågående -- 0 innebär att den inte är pågående
    `rating` float(2) NOT NULL DEFAULT 0 -- tar medelvärdet mellan medelvärdet på säsongerna och medelvärdet på användar-betyg för serien i helhet
    -- DATE: datumet för när den började, samt datumet för när den slutade baseras på avsnittent, samt om den är pågående
    -- LENGTH: längden i antal säsonger, samt längden i antal avsnitt baseras på series_seasons och series_episodes borden
);

CREATE TABLE series_mini (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,  -- namnet på serien
    `description` text NOT NULL, -- beskrivning på serien
    `rating` float(2) NOT NULL DEFAULT 0
    -- DATE: datum för när den började baseras på det första avsnittet
    -- LENGTH: längden i antal avsnitt baseras på series_episodes bordet
);

CREATE TABLE series_seasons (
    `series_id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `season_number` int(5) NOT NULL, -- säsongens nummer
    `rating` float(2) NOT NULL DEFAULT 0 -- tar medelvärdet mellan medelvärdet på avsnitten och medelvärdet på användar-betyg för säsongen i helhet
    -- DATE: datum för när den började baseras på det första avsnittet
    -- LENGTH: längden i antal avsnitt baseras på series_episodes bordet
);

CREATE TABLE series_episodes (
    `series_id` int(11) NOT NULL,
    `season_number` int(11) NOT NULL,
    `description` text NOT NULL, -- beskrivning på avsnittet
    `length` int(5) NOT NULL, -- i minuter
    `rating` float(2) NOT NULL DEFAULT 0 -- medelvärdet på användarnas betyg
);

CREATE TABLE games (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `date` date NOT NULL,
    `description` text NOT NULL,
    `rating` float(2) NOT NULL DEFAULT 0
    -- LÄNGD: den genomsnittliga längden kommer utvinnas ur användarnas loggningar
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
);

CREATE TABLE attach_items_crew (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `person_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL
);

CREATE TABLE studios (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL
);

CREATE TABLE attach_items_studios (
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `studios_id` int(11) NOT NULL
);

-- CREATE TABLE extras (); -- behind the scenes och featurette

CREATE TABLE views (
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
    `item_type` int(11) NOT NULL,
    `item_id` int(11) NOT NULL,
    `number` int(11) NOT NULL,
    `note` text NOT NULL -- listskaparen kan koppla en anteckning som exempelvis beskriver varför saken är inkluderad
);





-- old:
-- CREATE TABLE items (
--     -- universella:
--     `type` varchar(128) NOT NULL CHECK (`type` IN ('Film', 'Short Film', 'Game', 'Series', 'Mini-Series')),
--     `id` int(11) NOT NULL,
--     `name` varchar(128) NOT NULL,
--     `date` date NOT NULL,
--     `description` text NOT NULL,
--     `rating` float(2) NOT NULL DEFAULT 0,
--     `views_all` int(11) NOT NULL DEFAULT 0,
--     `views_week` int(11) NOT NULL DEFAULT 0,

--     -- `related` json NOT NULL, -- inkluderar både items i samma franchise och liknande items
--     -- `cast` json NOT NULL,
--     -- `crew` json NOT NULL,

--     `length` int(5), -- för spel och filmer, i minuter. spels längd hämtad från howlongtobeat.com

--     `series_length_seasons` int(4),
--     `series_length_eps` int(5),
--     `series_ongoing` bit, -- 1: yes
--     `series_date_last` date -- NULL if ongoing
-- );

-- CREATE TABLE seasons (
--     `number` int(4) NOT NULL,
--     `series_id` varchar(128) NOT NULL,
--     `length_eps` int(5) NOT NULL,
--     `date` date NOT NULL,
-- );

-- CREATE TABLE episodes (
--     `number_of_season` int(5) NOT NULL, -- vilket avsnitt av denna säsongen?
--     `number_of_series` int(5) NOT NULL, -- vilket avsnitt av hela serien?
--     `series_id` varchar(128) NOT NULL,
--     `season` varchar(128) NOT NULL, -- vilken säsong
--     `name` varchar(128) NOT NULL,
--     `date` date NOT NULL,
--     `description` varchar(128) NOT NULL,
--     `length` int(5) NOT NULL,
--     `rating` float(2) NOT NULL DEFAULT 0
-- );

-- CREATE TABLE ratings (
--     `user_id` int(11) NOT NULL,
--     `item_type` varchar(128) NOT NULL,
--     `item_id` int(11) NOT NULL,
--     `rating` float(2), -- mellan 1 och 5. halvpoäng funkar. om 0 => NULL, räknas inte med i avg. 
--     `like` bit NOT NULL
-- );

-- CREATE TABLE entries (
--     `user_id` int(11) NOT NULL,
--     `item_type` varchar(128) NOT NULL,
--     `item_id` int(11) NOT NULL,
--     `rating` float(2) NOT NULL,
--     `like` bit NOT NULL,
--     `date_completion` date NOT NULL,
--     `date_start` date, -- optional
--     `re` bit NOT NULL DEFAULT 0 -- is it a rewatch? 1: yes

--     -- `review` bit NOT NULL,
--     -- `review_id` int(11),
-- );