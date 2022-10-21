CREATE TABLE IF NOT EXISTS language
(
	ID varchar(2) unique not null,
	NAME varchar(500) not null,
	PRIMARY KEY (ID)

);

INSERT IGNORE INTO language (ID, NAME)
values ('ru', 'русский'), ('en', 'english'), ('de', 'deutsch');

CREATE TABLE IF NOT EXISTS movie_title
(
	MOVIE_ID int not null,
	LANGUAGE_ID varchar(2) not null,
	TITLE varchar(500) not null,
	PRIMARY KEY (MOVIE_ID, LANGUAGE_ID),
	FOREIGN KEY FK_MOVIE (MOVIE_ID)
		REFERENCES movie(ID)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	FOREIGN KEY FK_LANGUAGE (LANGUAGE_ID)
		REFERENCES language(ID)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
);

INSERT INTO movie_title (LANGUAGE_ID, TITLE, MOVIE_ID)
SELECT language.ID, TITLE, movie.ID FROM movie, language
WHERE language.NAME='русский';

ALTER TABLE movie DROP TITLE;