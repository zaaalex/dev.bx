# 1. Вывести список фильмов, в которых снимались
# одновременно Арнольд Шварценеггер и Линда Хэмилтон.
# Формат: ID фильма, Название на русском языке, Имя режиссёра.


SELECT m.ID, d.NAME, mt.TITLE FROM movie m, director d, movie_title mt
WHERE m.ID IN
      (SELECT ma1.MOVIE_ID FROM movie_actor ma1
		INNER JOIN movie_actor ma2 ON ma1.MOVIE_ID = ma2.MOVIE_ID
		WHERE ma1.ACTOR_ID=1 && ma2.ACTOR_ID=3
		GROUP BY ma1.MOVIE_ID)
	&& m.DIRECTOR_ID=d.ID
	&& mt.MOVIE_ID=m.ID
	&& mt.LANGUAGE_ID='ru';

# 2. Вывести список названий фильмов на английском языке
# с "откатом" на русский, в случае если название на английском не задано.
# Формат: ID фильма, Название.

(SELECT m.ID, mt.TITLE FROM movie m
INNER JOIN movie_title mt ON mt.MOVIE_ID = m.ID && mt.LANGUAGE_ID='en')
UNION
(SELECT m.ID, mt.TITLE
 FROM movie m
	      INNER JOIN movie_title mt ON mt.MOVIE_ID = m.ID && mt.LANGUAGE_ID = 'ru'
 WHERE m.ID IN (SELECT mm.ID
                FROM movie mm
                WHERE not exists(
	                SELECT '1'
	                FROM movie_title mtt
	                WHERE mtt.MOVIE_ID = mm.ID && mtt.LANGUAGE_ID = 'en'
	                )
                )
 )
ORDER BY ID;

# 3. Вывести самый длительный фильм Джеймса Кэмерона.
# Формат: ID фильма, Название на русском языке, Длительность.
# (Бонус – без использования подзапросов)

SELECT m1.ID, mt1.TITLE, m1.LENGTH FROM movie m1
INNER JOIN movie_title mt1 on m1.ID = mt1.MOVIE_ID
                                 && LANGUAGE_ID='ru'
                                 && m1.DIRECTOR_ID=1
WHERE m1.LENGTH = (
    SELECT max(m.LENGTH) FROM movie m
    WHERE m.DIRECTOR_ID=1
);

# 4. Вывести список фильмов с названием, сокращённым до 10 символов.
# Если название короче 10 символов – оставляем как есть.
# Если длиннее – сокращаем до 10 символов и добавляем многоточие.
# Формат: ID фильма, сокращённое название

(SELECT m1.ID, mt1.TITLE, mt1.LANGUAGE_ID FROM movie m1
INNER JOIN movie_title mt1 on m1.ID = mt1.MOVIE_ID
                                 && CHAR_LENGTH(mt1.TITLE)< 10)
UNION
(SELECT m2.ID, CONCAT(RTRIM(LEFT(mt2.TITLE, 10)),'..'), mt2.LANGUAGE_ID FROM movie m2
INNER JOIN movie_title mt2 on m2.ID = mt2.MOVIE_ID
	&& CHAR_LENGTH(mt2.TITLE)>10
)
ORDER BY ID;

# 5. Вывести количество фильмов, в которых снимался каждый актёр.
# Формат: Имя актёра, Количество фильмов актёра.

SELECT a.NAME, count(ma.MOVIE_ID)  FROM actor a
INNER JOIN movie_actor ma ON a.ID = ma.ACTOR_ID
GROUP BY a.NAME;

# 6. Вывести жанры, в которых никогда не снимался Арнольд Шварценеггер.
# Формат: ID жанра, название

SELECT g.ID, g.NAME FROM genre g
INNER JOIN movie_genre mg ON g.ID = mg.GENRE_ID
WHERE mg.MOVIE_ID IN (
    SELECT m.ID FROM movie m
        INNER JOIN movie_actor ma on m.ID = ma.MOVIE_ID
                && ma.ACTOR_ID=1
	)
GROUP BY g.ID;

# 7. Вывести список фильмов, у которых больше 3-х жанров.
# Формат: ID фильма, название на русском языке

SELECT m1.ID, mt.TITLE FROM movie m1
INNER JOIN movie_title mt on m1.ID = mt.MOVIE_ID && LANGUAGE_ID='ru'
WHERE m1.ID IN (
	SELECT m2.ID FROM movie m2
    INNER JOIN movie_genre mg on m2.ID = mg.MOVIE_ID
	GROUP BY m2.ID
	HAVING count(mg.GENRE_ID)>3
	)
ORDER BY m1.ID;

# 8. Вывести самый популярный жанр для каждого актёра.
# Формат вывода:
# Имя актёра, Жанр, в котором у актёра больше всего фильмов.

SELECT calculate_count.NAME, calculate_count.count
     , calculate_count.genre
FROM
(
   SELECT additional.NAME, max(additional.count) as max
   FROM (
            SELECT a.NAME,count(mg.GENRE_ID) as count, mg.GENRE_ID
            FROM actor a
            INNER JOIN movie_actor ma on ma.ACTOR_ID=a.ID
            INNER JOIN movie_genre mg ON mg.MOVIE_ID=ma.MOVIE_ID
            INNER JOIN genre g on mg.GENRE_ID = g.ID
            GROUP BY a.NAME, mg.GENRE_ID) as additional
   GROUP BY additional.NAME
) as seach_max,
	(
	    SELECT a.NAME,count(mg.GENRE_ID)as count, g.NAME as genre
	    FROM actor a
	    INNER JOIN movie_actor ma on ma.ACTOR_ID=a.ID
	    INNER JOIN movie_genre mg ON mg.MOVIE_ID=ma.MOVIE_ID
	    INNER JOIN genre g on mg.GENRE_ID = g.ID
	    GROUP BY a.NAME, mg.GENRE_ID
	) as calculate_count

WHERE calculate_count.count=seach_max.max
          && calculate_count.NAME=seach_max.NAME
ORDER BY calculate_count.NAME;












SELECT additional.NAME, max(additional.count) as max
FROM (
SELECT a.NAME,count(mg.GENRE_ID) as count FROM actor a
INNER JOIN movie_actor ma on ma.ACTOR_ID=a.ID
INNER JOIN movie_genre mg ON mg.MOVIE_ID=ma.MOVIE_ID
INNER JOIN genre g on mg.GENRE_ID = g.ID
GROUP BY a.NAME, mg.GENRE_ID) as additional
GROUP BY additional.NAME