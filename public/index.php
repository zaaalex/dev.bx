<?php
require_once __DIR__ . "/../boot.php";

/**
 * @var array $config ;
 */

$chooseMovies = [];
$movies = getMovies();
$title = $config["HOME_PAGE"];

if (isset($_GET['genre']))
{
	if (!preg_match('/^[A-Za-zА-Яа-я-]+$/u', $_GET['genre']))
	{
		header("Location: /public/error.php");
		throw new InvalidArgumentException("[public/index.php] Invalid genre!");
	}

	$chooseMovies = getFilmsByGenre($movies, $_GET['genre']);
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
		$chooseMovies = getFilmsByName($movies, $_GET['search']);
		$title = $config["SEARCH_FILM_PAGE"];
	}
	else
	{
		$chooseMovies = $movies;
	}
}

if (empty($chooseMovies))
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("[public/index.php] Movie not found!");
}

echo view('layout', [
	'content' => view('pages/index', [
		'movies' => $chooseMovies,
	]),
	'menu' => view('pages/menu', [
		'genres' => getGenres(),
	]),
	'title' => $title,
]);