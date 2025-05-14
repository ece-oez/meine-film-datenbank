-- Datenbank in SQL (MyAdmin erstellen)

-- benutzer Konto anlegen in MyAdmin
-- Datenbank erstellt
-- Tabellen 'filme' und 'genres' erstellen

CREATE DATABASE  mfdb;

DROP TABLE IF EXISTS filme;
DROP TABLE IF EXISTS genres;

CREATE TABLE filme(
    FilmeID tinyint(255) AUTO_INCREMENT,
    Titel varchar(255),
    Altersfreigabe tinyint(255),
    Erscheinungsjahr SMALLINT(255),
    Genre1 varchar(255),
    Genre2 varchar(255),
    Genre3 varchar(255),
    Filmlaenge SMALLINT(255),
    file varchar(65535),
    PRIMARY KEY(FilmeID)
);

CREATE TABLE genres(
    GenreID tinyint(255) AUTO_INCREMENT,
    GenreName varchar(255),
    PRIMARY KEY (GenreID)
);