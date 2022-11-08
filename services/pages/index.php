<?php
require_once __DIR__ . '/../../boot.php';

/**
 * @var array $movies;
 * @var array $genres;
 */

if(!preg_match('/^[A-Za-zА-Яа-я]+$/u', $_GET['genre']))
{
	header("Location: http://dev.bx/services/pages/error.php");
	return new InvalidArgumentException("Invalid genre!");
}

$chooseMovies=[];
if ($_GET['genre']==="Главная")
{
	$chooseMovies=$movies;
}
else
{
	foreach ($movies as $movie)
	{
		if (genreMatch($movie['genres'],  $_GET['genre']))
		{
			$chooseMovies[]=$movie;
		}
	}
}

echo view ('layout',[
	'content' => view('pages/index', [
		'movies'=>$chooseMovies,
	]),
	'title'=>$_GET['genre'],
	'PathToROOT'=>"../../",
	'genres'=>$genres
]);