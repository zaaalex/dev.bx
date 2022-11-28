<?php

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает фильм с искомым id, либо null, если такого не оказалось
 */
function getFilmById(int $id): ?array
{
	$connection=getDatabaseConnection();

	$result=mysqli_query($connection, "
		SELECT m.ID, m.TITLE, m.ORIGINAL_TITLE, m.DESCRIPTION,
        m.DURATION, m.AGE_RESTRICTION, m.RELEASE_DATE, m.RATING,
        group_concat(CONCAT(' ',a.NAME)) as CAST, d.NAME as DIRECTOR 
		FROM movie m
		JOIN movie_actor ma on m.ID = ma.MOVIE_ID
		JOIN actor a on ma.ACTOR_ID = a.ID
		JOIN director d on m.DIRECTOR_ID = d.ID
		WHERE m.ID = '{$id}'
		GROUP BY m.ID
	");

	if (!$result)
	{
		throw new RuntimeException(mysqli_errno($connection) . ': ' . mysqli_error($connection));
	}

	return mysqli_fetch_assoc($result);
}

function getGenres(): array
{
	$genres=[];
	$connection=getDatabaseConnection();

	$result=mysqli_query($connection, "
		SELECT CODE, NAME from genre
	");

	if (!$result)
	{
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_errno($connection).': '.mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$genres[$row['CODE']]=$row['NAME'];
	}

	return $genres;
}

function getMovies(): array
{
	$movies=[];
	$connection=getDatabaseConnection();

	$result = mysqli_query($connection, "
		SELECT m.ID, m.TITLE, m.ORIGINAL_TITLE, m.DESCRIPTION,
       m.DURATION, m.AGE_RESTRICTION, m.RELEASE_DATE, m.RATING,
       group_concat(a.NAME SEPARATOR ', ') as CAST, d.NAME as DIRECTOR,
       additional.GENRES
		FROM movie m
	     JOIN movie_actor ma on m.ID = ma.MOVIE_ID
	     JOIN actor a on ma.ACTOR_ID = a.ID
	     JOIN director d on m.DIRECTOR_ID = d.ID,
    (SELECT m1.ID as ID, group_concat(g.NAME SEPARATOR ', ')  as GENRES
     FROM movie m1
	          JOIN movie_genre mg on m1.ID = mg.MOVIE_ID
	          JOIN genre g on g.ID = mg.GENRE_ID
     GROUP BY m1.ID) as additional
WHERE m.ID=additional.ID
GROUP BY m.ID
	");

	if (!$result)
	{
		throw new RuntimeException(mysqli_errno($connection).': '.mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$movies[]=$row;
	}

	return $movies;
}

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает массив фильмов, жанр которых совпадает с $genre
 */
function getFilmsByGenre(array $movies, string $genre): ?array
{
	$chooseMovies = [];
	foreach ($movies as $movie)
	{
		if (strpos($movie['GENRES'], ConvertGenreToRu($genre))!==false)
		{
			$chooseMovies[] = $movie;
		}
	}
	return $chooseMovies;
}

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает массив фильмов, в названии которых присутствует поисковый запрос $name
 */
function getFilmsByName(array $movies, string $name): ?array
{
	$chooseMovies = [];
	foreach ($movies as $movie)
	{
		if (
			/*
			 * !==false здесь ввиду того, что в случае совпадения $name с названием фильма
			* с первого символа strpos выдаст 0 в качестве ответа и условие if не сработает
			*/
			strpos(convertToLowerCase($movie['TITLE']), convertToLowerCase($name)) !== false
			|| strpos(convertToLowerCase($movie['ORIGINAL_TITLE']), convertToLowerCase($name)) !== false
		)
		{
			$chooseMovies[] = $movie;
		}
	}
	return $chooseMovies;
}