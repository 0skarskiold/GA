-- TYPES:

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('1', 'Film', 'film');

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('2', 'Short Film', 'short-film');

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('3', 'Series', 'series');

CREATE TABLE items_attr_series (
    `series_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, -- för att koppla
    `limited` bit NOT NULL, -- anger om det är en limited serie eller inte
    `length_episodes` int NOT NULL, -- längden i antal avsnitt -- length (i items tabellen) är antalet säsonger
    `length_minutes` int NOT NULL, -- avsnittens genomsnittliga längd
    `finale_year` int, -- NULL om pågående
    `finale_month` int,
    `finale_day` int
);

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('4', 'Season', 'season');

CREATE TABLE items_attr_seasons (
    `season_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `series_id` int NOT NULL, -- för att koppla till serie
    `number` int NOT NULL -- säsongens nummer i serien
);

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('5', 'Episode', 'episode');

CREATE TABLE items_attr_episodes (
    `episode_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `series_id` int NOT NULL,
    `season_id` int NOT NULL,
    `number_series` int NOT NULL, -- avsnittets nummer i serien
    `number_season` int NOT NULL -- avsnittets nummer i säsongen
);

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('6', 'Game', 'game');

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('7', 'Album', 'album');

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('8', 'Song', 'song');

CREATE TABLE items_attr_songs (
    `song_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `single` bit NOT NULL -- har den släppts som single? (den kommer då hitta egen cover-bild)
);

CREATE TABLE songs_albums (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `song_id` int NOT NULL,
    `album_id` int NOT NULL,
    `number` int NOT NULL-- nummer i album
);

INSERT INTO `types` (`id`, `name`, `uid`) 
VALUES ('9', 'Book', 'book');

-- GENRES:

-- främst för film:
INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('1', 'Action', 'action');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('1', '1', '1');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('2', '1', '2');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('3', '1', '3');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('4', '1', '4');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('5', '1', '5');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('6', '1', '6');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('7', '1', '9');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('2', 'Adventure', 'adventure');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('8', '2', '1');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('9', '2', '2');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('10', '2', '3');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('11', '2', '4');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('12', '2', '5');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('13', '2', '6');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('14', '2', '9');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('3', 'Animation', 'animation');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('15', '3', '1');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('16', '3', '2');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('17', '3', '3');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('18', '3', '4');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('19', '3', '5');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('4', 'Biography', 'biography');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('20', '4', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('5', 'Comedy', 'comedy');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('21', '5', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('6', 'Crime', 'crime');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('22', '6', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('7', 'Documentary', 'documentary');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('23', '7', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('8', 'Drama', 'drama');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('24', '8', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('9', 'Family', 'family');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('25', '9', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('10', 'Fantasy', 'fantasy');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('26', '10', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('11', 'Horror', 'horror');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('27', '11', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('12', 'Music', 'music');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('28', '12', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('13', 'Mystery', 'mystery');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('29', '13', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('14', 'Romance', 'romance');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('30', '14', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('15', 'Sci-Fi', 'sci-fi');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('31', '15', '1');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('16', 'Thriller', 'thriller');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('32', '16', '1');

-- främst för spel:
INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('17', 'Puzzle', 'puzzle');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('33', '17', '6');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('18', 'RP', 'rp');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('34', '18', '6');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('19', 'Simulation', 'simulation');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('35', '19', '6');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('20', 'Strategy', 'strategy');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('36', '20', '6');

INSERT INTO `genres` (`id`, `name`, `uid`) VALUES ('21', 'Multiplayer', 'multiplayer');
INSERT INTO `genres_types` (`id`, `genre_id`, `type_id`) VALUES ('37', '21', '6');

-- TAGS:

-- främst för film:
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('1', 'Superheroes', 'superheroes');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('2', 'Vampires', 'vampires');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('3', 'Samurai', 'samurai');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('4', 'Splatter', 'splatter');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('5', 'Slasher', 'slasher');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('6', 'Whodunnit', 'whodunnit');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('7', 'Noir', 'noir');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('8', 'Neo-Noir', 'neo-noir');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('9', 'Handdrawn Animation', 'handdrawn-animation');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('10', 'CG Animation', 'cg-animation');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('11', 'Stop-Motion', 'stop-motion');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('12', 'War', 'war');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('13', 'Western', 'western');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('14', 'Psychological', 'psychological');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('15', 'Mockumentary', 'mockumentary');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('16', 'Found Footage', 'found-footage');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('17', 'Dinosaurs', 'dinosaurs');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('18', 'Slapstick', 'slapstick');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('19', 'Black Comedy', 'black-comedy');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('20', 'Werewolves', 'werewolves');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('21', 'Coming of Age', 'coming-of-age');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('22', 'Teenagers', 'teenagers');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('23', 'Adolescence', 'adolescence');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('24', 'Cars', 'cars');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('25', 'Pirates', 'pirates');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('26', 'Vikings', 'vikings');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('27', 'Monsters', 'monsters');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('28', 'Spies', 'spies');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('29', 'Post-Apocalypse', 'post-apocalypse');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('30', 'Dystopian', 'dystopian');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('31', 'Utopian', 'utopian');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('32', 'Martial-Arts', 'martial-arts');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('33', 'Zombies', 'zombies');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('34', 'Heists', 'heists');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('35', 'Gore', 'gore');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('36', 'Aliens', 'aliens');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('37', 'Ghosts', 'ghosts');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('38', 'Time Travel', 'time-travel');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('39', 'School', 'school');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('40', 'Courtroom', 'courtroom');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('41', 'Disaster', 'disaster');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('42', 'History', 'history');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('43', 'Future', 'future');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('44', 'Anime', 'anime');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('45', 'Spaghetti Western', 'spaghetti-western');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('46', 'Sports', 'sports');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('47', 'Space', 'space');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('48', 'Cowboys', 'cowboys');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('49', 'Nudity', 'nudity');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('50', 'Racing', 'racing');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('51', 'Underwater', 'underwater');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('52', 'Isolation', 'isolation');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('53', 'Loneliness', 'loneliness');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('54', 'Love', 'love');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('55', 'Skiing', 'skiing');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('56', 'Body Horror', 'body-horror');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('81', 'Drugs', 'drugs');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('82', 'Alcohol', 'alcohol');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('83', 'Violence', 'violence');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('84', 'Kids', 'kids');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('85', 'Planes', 'planes');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('86', 'Boats', 'boats');

-- framst för spel:
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('57', 'Platformer', 'platformer');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('58', 'Collectathon', 'collectathon');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('59', 'Metroidvania', 'metroidvania');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('60', 'Roguelike', 'roguelike');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('61', 'Cards', 'cards');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('62', 'Board', 'board');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('63', '2D', '2d');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('64', '3D', '3d');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('65', 'Shooter', 'shooter');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('66', 'First-Person', 'first-person');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('67', 'Third-Person', 'third-person');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('68', 'Sandbox', 'sandbox');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('69', 'Exploration', 'exploration');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('70', 'Open-World', 'open-world');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('71', 'Story-Heavy', 'story-heavy');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('72', 'MMO', 'mmo');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('73', 'Competetive', 'competetive');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('74', 'Casual', 'casual');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('75', 'Turn-Based', 'turn-based');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('76', 'Fighting', 'fighting');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('77', 'Tower Defence', 'tower-defence');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('78', 'Construction', 'construction');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('79', 'Randomly Generated', 'randomly-generated');
INSERT INTO `tags` (`id`, `name`, `uid`) VALUES ('80', 'Party', 'party');

-- CREW ROLES:
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('1', 'Actor', 'actor');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('2', 'Director', 'director');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('3', 'Writer', 'writer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('4', 'Cinematographer', 'cinematographer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('5', 'Composer', 'composer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('6', 'Producer', 'producer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('7', 'Executive Producer', 'executive-producer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('8', 'Editor', 'editor');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('9', 'Assistant Director', 'assistant-director');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('10', 'Production Assistant', 'production-assistant');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('11', 'Production Designer', 'production-designer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('12', 'Art Director', 'art-director');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('13', 'Set Dresser', 'set-dresser');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('14', 'Prop Master', 'prop-master');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('15', 'Concept Artist', 'concept-artist');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('16', 'Camera Operator', 'camera-operator');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('17', 'Assistant Cameraperson', 'assistant-cameraperson');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('18', 'Digital Imaging', 'digital-imaging');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('19', 'Casting Director', 'casting-director');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('20', 'Gaffer', 'gaffer');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('21', 'Key Grip', 'key-grip');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('22', 'Grip', 'grip');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('23', 'Make-Up', 'make-up');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('24', 'Hair', 'hair');
INSERT INTO `crew_roles` (`id`, `name`, `uid`) VALUES ('25', 'Costume Designer', 'costume-designer');

-- CREW:
INSERT INTO `crew` (`id`, `name`, `uid`, `description`) VALUES ('1', 'Bryan Cranston', 'bryan-cranston', '');
INSERT INTO `crew` (`id`, `name`, `uid`, `description`) VALUES ('2', 'Bob Odenkirk', 'bob-odenkirk', '');

-- COLLECTIONS:
INSERT INTO `collections` (`id`, `name`, `uid`) VALUES ('1', 'Breakage Collection', 'breakage-collection');
INSERT INTO `items_collections` (`id`, `item_id`, `collection_id`) VALUES ('2', '4', '1');

-- ITEMS:

-- breaking bad:
INSERT INTO `items` (`id`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `rating`) 
VALUES ('1', 'Breaking Bad', 'breaking-bad-2008', '2008', '1', '20', "A chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine with a former student in order to secure his family's future.", 'Change [the] Equation.', '5', '0');

INSERT INTO `items_attr_series` (`series_id`, `limited`, `length_episodes`, `length_minutes`, `finale_year`, `finale_month`, `finale_day`) 
VALUES ('1', '0', '62', '45', '2013', '9', '29');

INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('1', '6'); -- crime
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('1', '8'); -- drama
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('1', '16'); -- thriller

INSERT INTO `items_crew` (`item_id`, `artist_id`, `role_id`, `character`, `number`) VALUES ('1', '1', '1', 'Walter White', '1'); -- bryan cranston

INSERT INTO `items_collections` (`item_id`, `collection_id`) VALUES ('1', '1'); -- breakage collection

-- breakfast club:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('2', 'feature_film', 'The Breakfast Club', 'breakfast-club-1985', '1985', '7', '5', 'Five high school students meet in Saturday detention and discover how they have a lot more in common than they thought.', 'They only met once, but it changed their lives forever.', '97', '0', '0', '0', '0');

-- barbarian:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('3', 'feature_film', 'Barbarian', 'barbarian-2022', '2022', '9', '9', 'In town for a job interview, a young woman arrives at her Airbnb late at night only to find that it has been mistakenly double-booked.', 'Come for a night. Stay forever.', '103', '0', '0', '0', '0');

INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('3', '11');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('3', '13');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('3', '17');

-- better call saul:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('4', 'series', 'Better Call Saul', 'better-call-saul-2015', '2015', '2', '8', "The trials and tribulations of criminal lawyer Jimmy McGill in the years leading up to his fateful run-in with Walter White and Jesse Pinkman.", 'Make the Call', '6', '0', '0', '0', '0');

INSERT INTO `attributes_series` (`series_id`, `length_episodes`, `length_avg_minutes`, `finale_year`, `finale_month`, `finale_day`) 
VALUES ('4', '62', '45', '2013', '9', '29');

INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('4', '6');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('4', '8');

INSERT INTO `items_crew` (`item_id`, `artist_id`, `role`, `character`) VALUES ('4', '2', 'actor', 'Jimmy McGill');

-- northman:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('5', 'feature_film', 'Northman', 'northman-2022', '2022', '4', '22', "A young Viking prince is on a quest to avenge his father's murder.", 'Conquer your fate.', '137', '0', '0', '0', '0');

INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('5', '1');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('5', '8');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('5', '17');



-- crew:


-- collections: 
