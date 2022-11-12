
CREATE TABLE films_feature (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, -- identifierande nummer
    `name` varchar(128) NOT NULL,  -- namnet på filmen
    `date` date NOT NULL, -- släppsdatum
    `description` text NOT NULL, -- beskrivning
    `length` int(5) NOT NULL, -- i minuter
    `rating` float(5) NOT NULL DEFAULT 0, -- medelvärde på betyg från användare -- ?: uppdateras antingen varje gång någon betygsätter eller en gång per dag
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
    `rating` float(5) NOT NULL DEFAULT 0
);

CREATE TABLE films_short (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `date` date NOT NULL,
    `description` text NOT NULL,
    `length` int(5) NOT NULL,
    `rating` float(5) NOT NULL DEFAULT 0
);

CREATE TABLE series (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,  -- namnet på serien
    `description` text NOT NULL, -- beskrivning på serien
    `ongoing` bit NOT NULL DEFAULT 0, -- om serien är pågående -- 0 innebär att den inte är pågående
    `rating` float(5) NOT NULL DEFAULT 0 -- tar medelvärdet mellan medelvärdet på säsongerna och medelvärdet på användar-betyg för serien i helhet
    -- DATE: datumet för när den började, samt datumet för när den slutade baseras på avsnittent, samt om den är pågående
    -- LENGTH: längden i antal säsonger, samt längden i antal avsnitt baseras på series_seasons och series_episodes borden
);

CREATE TABLE series_mini (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,  -- namnet på serien
    `description` text NOT NULL, -- beskrivning på serien
    `rating` float(5) NOT NULL DEFAULT 0
    -- DATE: datum för när den började baseras på det första avsnittet
    -- LENGTH: längden i antal avsnitt baseras på series_episodes bordet
);

CREATE TABLE series_seasons (
    `series_id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `season_number` int(5) NOT NULL, -- säsongens nummer
    `rating` float(5) NOT NULL DEFAULT 0 -- tar medelvärdet mellan medelvärdet på avsnitten och medelvärdet på användar-betyg för säsongen i helhet
    -- DATE: datum för när den började baseras på det första avsnittet
    -- LENGTH: längden i antal avsnitt baseras på series_episodes bordet
);

CREATE TABLE series_episodes (
    `series_id` int(11) NOT NULL,
    `season_number` int(11) NOT NULL,
    `description` text NOT NULL, -- beskrivning på avsnittet
    `length` int(5) NOT NULL, -- i minuter
    `rating` float(5) NOT NULL DEFAULT 0 -- medelvärdet på användarnas betyg
);

CREATE TABLE games (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` varchar(128) NOT NULL,
    `date` date NOT NULL,
    `description` text NOT NULL,
    `rating` float(5) NOT NULL DEFAULT 0
    -- LÄNGD: den genomsnittliga längden kommer utvinnas ur användarnas loggningar
);