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

	PRIMARY KEY (ID)
);

ALTER TABLE movie_actor ADD COLUMN
	ROLE_NAME varchar(500) not null,
	DROP FOREIGN KEY movie_actor_ibfk_2,
    ADD FOREIGN KEY FK_ACTOR (ACTOR_ID)
	REFERENCES worker(ID)
	ON UPDATE RESTRICT
    ON DELETE RESTRICT;

ALTER TABLE movie DROP FOREIGN KEY movie_ibfk_1,DROP COLUMN DIRECTOR_ID;


DROP TABLE actor;
DROP TABLE director;

CREATE TABLE IF NOT EXISTS movie_worker_job
(
	MOVIE_ID int not null,
	WORKER_ID int not null,
	JOB_ID int not null,

	PRIMARY KEY (MOVIE_ID, WORKER_ID, JOB_ID),
	FOREIGN KEY FK_MOVIE (MOVIE_ID)
		REFERENCES worker(ID)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	FOREIGN KEY FK_WORKER (WORKER_ID)
		REFERENCES worker(ID)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT,
	FOREIGN KEY FK_JOB (JOB_ID)
		REFERENCES job(ID)
		ON UPDATE RESTRICT
		ON DELETE RESTRICT
);

/*
 Создана таблица job, в которой хранятся названия всех возможных должностей,
 что позволяет с легкостью расширять базу данных при расширении списка.

 Создана таблица worker, которая хранит фамилию, имя сотрудника.
 Создана таблица worker-job-movie, которая связывает фильм и id сотрудника,
 принимающго участие в нем, с указанием id должности из таблицы job.

 Таблицы actor и director были упразднены ввиду дублирования функционала с
 таблицей worker.
 */

SELECT mv.MOVIE_ID, mv.WORKER_ID FROM movie_worker_job mv
INNER JOIN movie_worker_job mv2
    on mv.MOVIE_ID=mv2.MOVIE_ID &&
       mv.WORKER_ID=mv2.WORKER_ID
WHERE mv.JOB_ID = 2 || mv.JOB_ID=1
GROUP BY mv. MOVIE_iD, mv.WORKER_ID;

SELECT mt.MOVIE_ID, mt.TITLE FROM movie_title mt
INNER JOIN movie_title mt2 on mt.TITLE=mt2.TITLE && mt.MOVIE_ID!=mt2.MOVIE_ID
WHERE mt.LANGUAGE_ID='ru'
GROUP BY mt.MOVIE_ID;