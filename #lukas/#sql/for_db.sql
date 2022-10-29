CREATE TABLE users (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `email` varchar(128) NOT NULL,
    `uid` varchar(128) NOT NULL,
    `pwd` varchar(128) NOT NULL
);

CREATE TABLE items (
    -- universella:
    `type` varchar(128) NOT NULL CHECK (`type` IN ('Film', 'Short Film', 'Game', 'Series', 'Mini-Series')),
    `id` int(11) NOT NULL,
    `name` varchar(128) NOT NULL,
    `date` date NOT NULL,
    `poster_path` varchar(128) NOT NULL,
    `bg_path` varchar(128) NOT NULL,
    `description` text NOT NULL,
    `rating` float(2) NOT NULL DEFAULT 0,
    `views_all` int(11) NOT NULL DEFAULT 0,
    `views_week` int(11) NOT NULL DEFAULT 0,

    -- `related` json NOT NULL, -- inkluderar både items i samma franchise och liknande items
    -- `cast` json NOT NULL,
    -- `crew` json NOT NULL,

    `length` int(5), -- för spel och filmer, i minuter. spels längd hämtad från howlongtobeat.com

    `series_length_seasons` int(4),
    `series_length_eps` int(5),
    `series_ongoing` bit, -- 1: yes
    `series_date_last` date -- NULL if ongoing
);

CREATE TABLE seasons (
    `number` int(4) NOT NULL,
    `series_id` varchar(128) NOT NULL,
    `length_eps` int(5) NOT NULL,
    `date` date NOT NULL,
    `bg_path` varchar(128) NOT NULL,
    `description` varchar(128) NOT NULL,
);

CREATE TABLE episodes (
    `number_of_season` int(5) NOT NULL, -- vilket avsnitt av denna säsongen?
    `number_of_series` int(5) NOT NULL, -- vilket avsnitt av hela serien?
    `series_id` varchar(128) NOT NULL,
    `season` varchar(128) NOT NULL, -- vilken säsong
    `name` varchar(128) NOT NULL,
    `date` date NOT NULL,
    `bg_path` varchar(128) NOT NULL,
    `description` varchar(128) NOT NULL,
    `length` int(5) NOT NULL,
    `rating` float(2) NOT NULL DEFAULT 0
);

CREATE TABLE ratings (
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `rating` float(2), -- mellan 1 och 5. halvpoäng funkar. om 0 => NULL, räknas inte med i avg. 
    `like` bit NOT NULL
);

CREATE TABLE entries (
    `user_id` int(11) NOT NULL,
    `item_type` varchar(128) NOT NULL,
    `item_id` int(11) NOT NULL,
    `rating` float(2) NOT NULL,
    `like` bit NOT NULL,
    `date_completion` date NOT NULL,
    `date_start` date, -- optional
    `re` bit NOT NULL DEFAULT 0 -- is it a rewatch? 1: yes

    -- `review` bit NOT NULL,
    -- `review_id` int(11),
);