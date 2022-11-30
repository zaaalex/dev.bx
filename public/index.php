<?php
require_once __DIR__ . "/../boot.php";

/**
 * @var array $config ;
 */

$chooseMovies = [];
$title = $config["HOME_PAGE"];

if (isset($_GET['genre']))
{
	if (!preg_match('/^[A-Za-zА-Яа-я-]+$/u', $_GET['genre']))
	{
		header("Location: /public/error.php");
		throw new InvalidArgumentException("[public/index.php] Invalid genre!");
	}

	$chooseMovies = getMoviesByGenre($_GET['genre']);
	$title = ConvertGenreToRu($_GET['genre']);
}
else
{
	if (isset($_GET['search']))
	{
		if (!preg_match('/^[A-Za-zА-Яа-я-]+$/u', $_GET['search']))
		{
			header("Location: /public/error.php");
			throw new InvalidArgumentException("[public/index.php] Invalid search text!");
		}
		$chooseMovies = getMoviesByName($_GET['search']);
		$title = $config["SEARCH_FILM_PAGE"];
	}
	else
	{
		$chooseMovies = getMovies();
	}
}

if (empty($chooseMovies))
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("[public/index.php] Movie not found!");
}

echo view('layout', [
	'content' => view('components/movie-item', [
		'movies' => $chooseMovies,
	]),
	'menu' => view('components/menu', [
		'genres' => getGenres(),
	]),
	'title' => $title,
]);