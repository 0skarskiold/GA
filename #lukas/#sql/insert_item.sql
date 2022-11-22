
-- template:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('', '', '', '', '', '', '', '', '', '0', '0', '0', '0');

-- breaking bad:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('1', 'series', 'Breaking Bad', 'breaking-bad-2008', '2008', '1', '20', "A chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine with a former student in order to secure his family's future.", 'Change [the] Equation.', '5', '0', '0', '0', '0');

INSERT INTO `attributes_series` (`id`, `length_episodes`, `length_avg_minutes`, `finale_year`, `finale_month`, `finale_day`) 
VALUES ('1', '62', '45', '2013', '9', '29');

-- breakfast club:
INSERT INTO `items` (`id`, `type`, `name`, `uid`, `year`, `month`, `day`, `description`, `tagline`, `length`, `completions`, `completions_week`, `completions_month`, `rating`) 
VALUES ('2', 'feature_film', 'The Breakfast Club', 'breakfast-club-1985', '1985', '7', '5', 'Five high school students meet in Saturday detention and discover how they have a lot more in common than they thought.', 'They only met once, but it changed their lives forever.', '97', '0', '0', '0', '0');


