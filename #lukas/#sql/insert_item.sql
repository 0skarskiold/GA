
-- template:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('', '', '', '', '', '', '', '', '', '0', '0', '0', '0');

-- breaking bad:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('1', 'series', 'Breaking Bad', 'breaking-bad-2008', '2008', '1', '20', "A chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine with a former student in order to secure his family's future.", 'Change [the] Equation.', '5', '0', '0', '0', '0');

INSERT INTO `attributes_series` (`series_id`, `length_episodes`, `length_avg_minutes`, `finale_year`, `finale_month`, `finale_day`) 
VALUES ('1', '62', '45', '2013', '9', '29');

INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('1', '8');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('1', '6');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('1', '17');

-- breakfast club:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('2', 'feature_film', 'The Breakfast Club', 'breakfast-club-1985', '1985', '7', '5', 'Five high school students meet in Saturday detention and discover how they have a lot more in common than they thought.', 'They only met once, but it changed their lives forever.', '97', '0', '0', '0', '0');

-- barbarian:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('3', 'feature_film', 'Barbarian', 'barbarian-2022', '2022', '9', '9', 'In town for a job interview, a young woman arrives at her Airbnb late at night only to find that it has been mistakenly double-booked.', 'Come for a night. Stay forever.', '103', '0', '0', '0', '0');

INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('3', '11');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('3', '13');
INSERT INTO `items_genres` (`item_id`, `genre_id`) VALUES ('3', '17');

-- genres:
INSERT INTO `genres` (`id`, `name`) VALUES ('1', 'Action');
INSERT INTO `genres` (`id`, `name`) VALUES ('2', 'Adventure');
INSERT INTO `genres` (`id`, `name`) VALUES ('3', 'Animation');
INSERT INTO `genres` (`id`, `name`) VALUES ('4', 'Biography');
INSERT INTO `genres` (`id`, `name`) VALUES ('5', 'Comedy');
INSERT INTO `genres` (`id`, `name`) VALUES ('6', 'Crime');
INSERT INTO `genres` (`id`, `name`) VALUES ('7', 'Documentary');
INSERT INTO `genres` (`id`, `name`) VALUES ('8', 'Drama');
INSERT INTO `genres` (`id`, `name`) VALUES ('9', 'Family');
INSERT INTO `genres` (`id`, `name`) VALUES ('10', 'Fantasy');
INSERT INTO `genres` (`id`, `name`) VALUES ('11', 'Horror');
INSERT INTO `genres` (`id`, `name`) VALUES ('12', 'Music');
INSERT INTO `genres` (`id`, `name`) VALUES ('13', 'Mystery');
INSERT INTO `genres` (`id`, `name`) VALUES ('14', 'Romance');
INSERT INTO `genres` (`id`, `name`) VALUES ('15', 'Science Fiction');
INSERT INTO `genres` (`id`, `name`) VALUES ('16', 'Sports');
INSERT INTO `genres` (`id`, `name`) VALUES ('17', 'Thriller');
INSERT INTO `genres` (`id`, `name`) VALUES ('18', 'War');
INSERT INTO `genres` (`id`, `name`) VALUES ('19', 'Western');

-- tags:
INSERT INTO `tags` (`id`, `name`) VALUES ('1', 'Super-Heroes');
INSERT INTO `tags` (`id`, `name`) VALUES ('2', 'Vampires');
INSERT INTO `tags` (`id`, `name`) VALUES ('3', 'Samurai');
INSERT INTO `tags` (`id`, `name`) VALUES ('4', 'Splatter');
INSERT INTO `tags` (`id`, `name`) VALUES ('5', 'Slasher');
INSERT INTO `tags` (`id`, `name`) VALUES ('6', 'Whodunit');
INSERT INTO `tags` (`id`, `name`) VALUES ('7', 'Noir');
INSERT INTO `tags` (`id`, `name`) VALUES ('8', 'Neo-Noir');
INSERT INTO `tags` (`id`, `name`) VALUES ('9', '2D');
INSERT INTO `tags` (`id`, `name`) VALUES ('10', '3D');
INSERT INTO `tags` (`id`, `name`) VALUES ('11', 'Stop-Motion');
INSERT INTO `tags` (`id`, `name`) VALUES ('12', 'Samurai');
INSERT INTO `tags` (`id`, `name`) VALUES ('13', 'Spaghetti Western');
INSERT INTO `tags` (`id`, `name`) VALUES ('14', 'Psychological');
INSERT INTO `tags` (`id`, `name`) VALUES ('15', 'Mockumentary');
INSERT INTO `tags` (`id`, `name`) VALUES ('16', 'Found-Footage');
INSERT INTO `tags` (`id`, `name`) VALUES ('17', 'Dinosaurs');
INSERT INTO `tags` (`id`, `name`) VALUES ('18', 'Slapstick');
INSERT INTO `tags` (`id`, `name`) VALUES ('19', 'Black Comedy');
INSERT INTO `tags` (`id`, `name`) VALUES ('20', 'Werewolves');
INSERT INTO `tags` (`id`, `name`) VALUES ('21', 'Coming of Age');
INSERT INTO `tags` (`id`, `name`) VALUES ('22', 'Teenagers');
INSERT INTO `tags` (`id`, `name`) VALUES ('23', 'Adolesence');
INSERT INTO `tags` (`id`, `name`) VALUES ('24', 'Cars');
INSERT INTO `tags` (`id`, `name`) VALUES ('25', 'Pirates');
INSERT INTO `tags` (`id`, `name`) VALUES ('26', 'Vikings');
INSERT INTO `tags` (`id`, `name`) VALUES ('27', 'Monsters');
INSERT INTO `tags` (`id`, `name`) VALUES ('28', 'Spies');
INSERT INTO `tags` (`id`, `name`) VALUES ('29', 'Post-Apocalypse');
INSERT INTO `tags` (`id`, `name`) VALUES ('30', 'Dystopian');
INSERT INTO `tags` (`id`, `name`) VALUES ('31', 'Utopian');
INSERT INTO `tags` (`id`, `name`) VALUES ('32', 'Martial-Arts');
INSERT INTO `tags` (`id`, `name`) VALUES ('33', 'Zombies');
INSERT INTO `tags` (`id`, `name`) VALUES ('34', 'Heists');
INSERT INTO `tags` (`id`, `name`) VALUES ('35', 'Gore');
INSERT INTO `tags` (`id`, `name`) VALUES ('36', 'Aliens');
INSERT INTO `tags` (`id`, `name`) VALUES ('37', 'Ghosts');
INSERT INTO `tags` (`id`, `name`) VALUES ('38', 'Time Travel');
INSERT INTO `tags` (`id`, `name`) VALUES ('39', 'School');
INSERT INTO `tags` (`id`, `name`) VALUES ('40', 'Courtroom');
INSERT INTO `tags` (`id`, `name`) VALUES ('41', 'Disaster');
INSERT INTO `tags` (`id`, `name`) VALUES ('42', 'Historical');
INSERT INTO `tags` (`id`, `name`) VALUES ('43', 'Future');
INSERT INTO `tags` (`id`, `name`) VALUES ('44', 'Anime');