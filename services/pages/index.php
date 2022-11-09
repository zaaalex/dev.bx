<?php
require_once __DIR__ . '/../../boot.php';

/**
 * @var array $movies;
 * @var array $genres;
 */


if(!preg_match('/^[A-Za-zА-Яа-я\s]+$/u', $_POST['search']) &&
	!preg_match('/^[A-Za-zА-Яа-я\s]+$/u', $_GET['genre']))
{
	header("Location: http://dev.bx/services/pages/error.php");
	return new InvalidArgumentException("Invalid genre!");
}

$chooseMovies=[];
if (!empty($_POST['search']))
{
	$chooseMovies=getFilmsByName($movies, $_POST['search']);
}
else
{

	$chooseMovies=getFilmsByGenre($movies, $_GET['genre']);
}

if (empty($chooseMovies))
{
	header("Location: http://dev.bx/services/pages/error.php");
	return new InvalidArgumentException("Invalid genre!");
}

echo view ('layout',[
	'content' => view('pages/index', [
		'movies'=>$chooseMovies,
	]),
	'title'=>$_GET['genre'],
	'PathToROOT'=>"../../",
	'genres'=>$genres
]);