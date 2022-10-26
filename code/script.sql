CREATE TABLE IF NOT EXISTS job
(
	ID int not null auto_increment,
	NAME varchar(500) not null,
	PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS worker
(
	ID int not null auto_increment,
	NAME varchar(500) not null,
	SURNAME varchar(500) not null,

	JOB_ID int not null,

	PRIMARY KEY (ID),
	FOREIGN KEY FK_JOB(JOB_ID)
		REFERENCES job(ID)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
);

ALTER TABLE movie_actor ADD COLUMN
	ROLE_NAME varchar(500) not null,
	DROP FOREIGN KEY movie_actor_ibfk_2,
    ADD FOREIGN KEY FK_ACTOR (ACTOR_ID)
	REFERENCES worker(ID)
	ON UPDATE RESTRICT
    ON DELETE RESTRICT;

ALTER TABLE movie DROP FOREIGN KEY movie_ibfk_1,
                    ADD FOREIGN KEY FK_DIRECTOR (DIRECTOR_ID)
	                  REFERENCES worker(ID)
	                  ON UPDATE RESTRICT
	                  ON DELETE RESTRICT;


DROP TABLE actor;
DROP TABLE director;

/*
 Создана таблица job, в которой хранятся названия всех возможных должностей,
 что позволяет с легкостью расширять базу данных при расширении списка.

 Создана таблица worker, которая хранит фамилию, имя и id должности
 из таблицы job.

 Таблицы actor и director были упразднены ввиду дублирования функционала с
 таблицей worker. FOREIGN KEY, которые вели на эти таблицы перенаправлены
 на таблицу worker.

 Решение оставить поле DIRECTOR_ID в таблице movie было принято ввиду того,
 что запрос режиссера фильма будет выполняться часто и, как я предполагаю,
 не рационально каждый раз пробегаться по таблице worker в его поиске.
 */

SELECT mt.MOVIE_ID, mt.TITLE FROM movie_title mt
CROSS JOIN movie_title mt2 on mt.TITLE=mt2.TITLE && mt.MOVIE_ID!=mt2.MOVIE_ID
WHERE mt.LANGUAGE_ID='ru'