DROP TABLE artists;
CREATE TABLE artists (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name varchar(100) NOT NULL,
    birthday date NOT NULL,
    isMarried boolean NOT NULL,
    numberOfAlbums INTEGER NOT NULL
);

INSERT INTO artists
VALUES
    (NULL, "Bon Jovi", "1962/03/02", 1, 0)
