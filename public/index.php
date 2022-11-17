<?php
require_once __DIR__ . "/../boot.php";

/**
 * @var array $movies ;
 * @var array $genres ;
 */

$chooseMovies = [];
if(isset($_GET['genre']))
{
	if (!preg_match('/^[A-Za-zА-Яа-я]+$/u', $_GET['genre']))
	{
		header("Location: /public/error.php");
		throw new InvalidArgumentException("Invalid genre!");
	}

	$chooseMovies = getFilmsByGenre($movies, $_GET['genre']);
}
else
{
	if(isset($_POST['search']))
	{
		if (!preg_match('/^[A-Za-zА-Яа-я]+$/u', $_POST['search']))
		{
			header("Location: /public/error.php");
			throw new InvalidArgumentException("Invalid genre!");
		}
		$chooseMovies = getFilmsByName($movies, $_POST['search']);
	}
	else
	{
		$chooseMovies = $movies;
	}
}

if (empty($chooseMovies))
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("Movie not found!");
}

echo view('layout', [
	'content' => view('pages/index', [
		'movies' => $chooseMovies,
	]),
	'title' => $_GET['genre'],
	'genres' => $genres,
]);