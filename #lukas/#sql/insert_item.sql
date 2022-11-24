
-- template:
INSERT INTO `items` (`type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('', '', '', '', '', '', '', '', '0', '0', '0', '0');

-- breaking bad:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('1', 'series', 'Breaking Bad', 'breaking-bad-2008', '2008', '1', '20', "A chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine with a former student in order to secure his family's future.", 'Change [the] Equation.', '5', '0', '0', '0', '0');

INSERT INTO `attributes_series` (`series_id`, `length_episodes`, `length_avg_minutes`, `finale_year`, `finale_month`, `finale_day`) 
VALUES ('1', '62', '45', '2013', '9', '29');

-- breakfast club:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('2', 'feature_film', 'The Breakfast Club', 'breakfast-club-1985', '1985', '7', '5', 'Five high school students meet in Saturday detention and discover how they have a lot more in common than they thought.', 'They only met once, but it changed their lives forever.', '97', '0', '0', '0', '0');

-- barbarian:
INSERT INTO `items` (`type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('feature_film', 'Barbarian', 'barbarian-2022', '2022', '9', '9', 'In town for a job interview, a young woman arrives at her Airbnb late at night only to find that it has been mistakenly double-booked.', 'Come for a night. Stay forever.', '103', '0', '0', '0', '0');

-- genres:
INSERT INTO `genres` (`id`, `name`) VALUES ('1', 'action');
INSERT INTO `genres` (`name`) VALUES ('adventure');
INSERT INTO `genres` (`name`) VALUES ('animation');
INSERT INTO `genres` (`name`) VALUES ('biography');
INSERT INTO `genres` (`name`) VALUES ('comedy');
INSERT INTO `genres` (`name`) VALUES ('crime');
INSERT INTO `genres` (`name`) VALUES ('documentary');
INSERT INTO `genres` (`name`) VALUES ('drama');
INSERT INTO `genres` (`name`) VALUES ('family');
INSERT INTO `genres` (`name`) VALUES ('fantasy');
INSERT INTO `genres` (`name`) VALUES ('horror');
INSERT INTO `genres` (`name`) VALUES ('music');
INSERT INTO `genres` (`name`) VALUES ('mystery');
INSERT INTO `genres` (`name`) VALUES ('romance');
INSERT INTO `genres` (`name`) VALUES ('science fiction');
INSERT INTO `genres` (`name`) VALUES ('sports');
INSERT INTO `genres` (`name`) VALUES ('thriller');
INSERT INTO `genres` (`name`) VALUES ('war');
INSERT INTO `genres` (`name`) VALUES ('western');

INSERT INTO `attach_items_genres` (`item_id`, `genre_id`) VALUES ('1', '7');
INSERT INTO `attach_items_genres` (`item_id`, `genre_id`) VALUES ('1', '6');
INSERT INTO `attach_items_genres` (`item_id`, `genre_id`) VALUES ('1', '5');

UPDATE `genres` SET `name` = 'action' WHERE `genres`.`id` = 1;