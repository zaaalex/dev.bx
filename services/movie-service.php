<?php

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает фильм с искомым id, либо null, если такого не оказалось
 */
function getFilmById(array $movies, int $id): ?array
{
	foreach ($movies as $movie)
	{
		if ($movie['id'] === $id)
		{
			return $movie;
		}
	}
	return null;
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
		if (in_array(genreToRu($genre), $movie['genres'],true))
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
		/*
		 * При попытке заменить на функцию str_contains() -
		 *
		 * Fatal error: Uncaught Error: Call to undefined function str_contains()
		 * Stack trace:
		 * #0 getFilmsByName()
		 */
		if (
			/*
			 * !==false здесь ввиду того, что в случае совпадения $name с названием фильма
			* с первого символа strpos выдаст 0 в качестве ответа и условие if не сработает
			*/
			strpos(convertToLowerCase($movie['title']), convertToLowerCase($name)) !== false
			|| strpos(convertToLowerCase($movie['original-title']), convertToLowerCase($name)) !== false
		)
		{
			$chooseMovies[] = $movie;
		}
	}
	return $chooseMovies;
}