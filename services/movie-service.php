<?php

function getQueryMovieIdByGenre(mysqli $connection, string $codeGenre): string
{
	mysqli_real_escape_string($connection, $codeGenre);

	return "m.id in (SELECT m2.ID as ID FROM movie m2
						JOIN movie_genre mg on m2.ID = mg.MOVIE_ID
						JOIN genre g on g.ID = mg.GENRE_ID
					 WHERE g.CODE = '$codeGenre'
					 GROUP BY m2.ID)";
}

function getQueryMovieByTitle(mysqli $connection, string $movieTitle): string
{
	mysqli_real_escape_string($connection, $movieTitle);

	return "(m.TITLE LIKE '%$movieTitle%'|| m.ORIGINAL_TITLE LIKE '$movieTitle%')";
}

function getMovies(string $codeGenre = null, string $movieTitle = null): array
{
	$chooseMovies = [];
	$connection = getDatabaseConnection();

	$queryMovieIdByGenre = $codeGenre ? getQueryMovieIdByGenre($connection, $codeGenre) : "1";
	$queryMovieByTitle = $movieTitle ? getQueryMovieByTitle($connection, $movieTitle) : "1";

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
	WHERE m.ID = additional.ID && $queryMovieIdByGenre && $queryMovieByTitle
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