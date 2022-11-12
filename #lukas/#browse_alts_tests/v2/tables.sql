
CREATE TABLE items (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `type` varchar(128) NOT NULL,
    `name` varchar(128) NOT NULL, -- säsonger: nummret
    `url_name` varchar(128) NOT NULL, -- exempelvis breaking-bad-2008 -- ska vara unikt inom typgruppen -- om det finns två av samma titel från samma år: example-title-20XX och example-title-20XX-2
    `year` int(5) NOT NULL,
    `month` int(2) NOT NULL,
    `day` int(2) NOT NULL,
    `description` text, -- beskrivning -- NULL för säsonger
    `length` int(6) NOT NULL, -- filmer: minuter, serier: antal säsonger, säsonger: antal avsnitt, avsnitt: minuter, spel: timmar (genomsnitt, avrundas uppåt)
    `completes` int(11) NOT NULL DEFAULT 0,
    `completes_week` int(11) NOT NULL DEFAULT 0,
    `completes_month` int(11) NOT NULL DEFAULT 0,
    `rating` float(5) NOT NULL DEFAULT 0
    -- IMAGES: sökvägar för affischer, bakgrundsbilder och andra relaterade bilder kommer struktureras efter typ (film, serie, osv.) och url-namn
);

CREATE TABLE attributes_series (
    `id` int(11) NOT NULL, -- för att koppla
    `length_episodes` int(6) NOT NULL, -- längden i antal avsnitt
    `length_avg_minutes` int(6) NOT NULL, -- avsnittens genomsnittliga längd
    `ongoing` bit NOT NULL DEFAULT 0 -- om serien är pågående -- 0 innebär att den inte är pågående
);

CREATE TABLE attach_films_versions (
    `original_id` int(11) NOT NULL, -- t.ex. theatrical cut
    `alternate_id` int(11) NOT NULL -- t.ex. director's cut
);