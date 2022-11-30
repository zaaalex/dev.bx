<?php

function getGenres(): ?array
{
	$genres = [];
	$connection = getDatabaseConnection();

	$result = mysqli_query($connection, "SELECT CODE, NAME from genre");

	if (!$result)
	{
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_errno($connection) . ': ' . mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$genres[$row['CODE']] = $row['NAME'];
	}

	return $genres;
}

function getMovies(): ?array
{
	$movies = [];
	$connection = getDatabaseConnection();

	$result = mysqli_query($connection, "
	SELECT m.ID,
		   m.TITLE,
		   m.ORIGINAL_TITLE,
		   m.DESCRIPTION,
		   m.DURATION,
		   m.AGE_RESTRICTION,
		   m.RELEASE_DATE,
		   m.RATING,
		   group_concat(a.NAME SEPARATOR ', ') as CAST,
		   d.NAME                              as DIRECTOR,
		   additional.GENRES
	FROM movie m
			 JOIN movie_actor ma on m.ID = ma.MOVIE_ID
			 JOIN actor a on ma.ACTOR_ID = a.ID
			 JOIN director d on m.DIRECTOR_ID = d.ID,
		 (SELECT m1.ID as ID, group_concat(g.NAME SEPARATOR ', ') as GENRES
		  FROM movie m1
				   JOIN movie_genre mg on m1.ID = mg.MOVIE_ID
				   JOIN genre g on g.ID = mg.GENRE_ID
		  GROUP BY m1.ID) as additional
	WHERE m.ID = additional.ID
	GROUP BY m.ID
	LIMIT 100
	");

	if (!$result)
	{
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_errno($connection) . ': ' . mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$movies[] = $row;
	}

	return $movies;
}

function getFilmById(int $id): ?array
{
	$connection = getDatabaseConnection();

	$result = mysqli_query($connection, "
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
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_errno($connection) . ': ' . mysqli_error($connection));
	}

	return mysqli_fetch_assoc($result);
}

function getMoviesByGenre(string $codeGenre): ?array
{
	$chooseMovies = [];
	$connection = getDatabaseConnection();

	$result = mysqli_query($connection, "
	SELECT m.ID,
		   m.TITLE,
		   m.ORIGINAL_TITLE,
		   m.DESCRIPTION,
		   m.DURATION,
		   m.AGE_RESTRICTION,
		   m.RELEASE_DATE,
		   m.RATING,
		   group_concat(a.NAME SEPARATOR ', ') as CAST,
		   d.NAME                              as DIRECTOR,
		   additional.GENRES
	FROM movie m
			 JOIN movie_actor ma on m.ID = ma.MOVIE_ID
			 JOIN actor a on ma.ACTOR_ID = a.ID
			 JOIN director d on m.DIRECTOR_ID = d.ID,
		 (SELECT m1.ID as ID, group_concat(g.NAME SEPARATOR ', ') as GENRES
		  FROM movie m1
				   JOIN movie_genre mg on m1.ID = mg.MOVIE_ID
				   JOIN genre g on g.ID = mg.GENRE_ID
		  GROUP BY m1.ID) as additional
	WHERE m.ID = additional.ID && m.id in (SELECT m2.ID as ID
										   FROM movie m2
													JOIN movie_genre mg on m2.ID = mg.MOVIE_ID
													JOIN genre g on g.ID = mg.GENRE_ID
										   WHERE g.CODE = '${codeGenre}'
										   GROUP BY m2.ID)
	GROUP BY m.ID
	LIMIT 100
	");

	if (!$result)
	{
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_errno($connection) . ': ' . mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$chooseMovies[]=$row;
	}

	return $chooseMovies;
}

function getMoviesByName(string $name): ?array
{
	$chooseMovies = [];
	$connection = getDatabaseConnection();

	$result = mysqli_query($connection, "
	SELECT m.ID,
		   m.TITLE,
		   m.ORIGINAL_TITLE,
		   m.DESCRIPTION,
		   m.DURATION,
		   m.AGE_RESTRICTION,
		   m.RELEASE_DATE,
		   m.RATING,
		   group_concat(a.NAME SEPARATOR ', ') as CAST,
		   d.NAME                              as DIRECTOR,
		   additional.GENRES
	FROM movie m
			 JOIN movie_actor ma on m.ID = ma.MOVIE_ID
			 JOIN actor a on ma.ACTOR_ID = a.ID
			 JOIN director d on m.DIRECTOR_ID = d.ID,
		 (SELECT m1.ID as ID, group_concat(g.NAME SEPARATOR ', ') as GENRES
		  FROM movie m1
				   JOIN movie_genre mg on m1.ID = mg.MOVIE_ID
				   JOIN genre g on g.ID = mg.GENRE_ID
		  GROUP BY m1.ID) as additional
	WHERE m.ID = additional.ID && (INSTR(m.TITLE, '${name}') || INSTR(m.ORIGINAL_TITLE, '${name}'))
	GROUP BY m.ID
	LIMIT 100
	");

	if (!$result)
	{
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_errno($connection) . ': ' . mysqli_error($connection));
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$chooseMovies[]=$row;
	}

	return $chooseMovies;
}