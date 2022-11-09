<?php
require_once __DIR__ . '/../../boot.php';

/**
 * @var array $movies;
 * @var array $genres;
 */

if(!preg_match('/^\d+$/', $_GET['id'])||getFilmById($movies, (int)$_GET['id'])===NULL)
{
	header("Location: http://dev.bx/services/pages/error.php");
	return new InvalidArgumentException("Invalid film id!");
}

$movie=getFilmById($movies, (int)$_GET['id']);

echo view ('layout',[
	'content' => view('pages/film', [
		'movie'=> $movie
	]),
	'title'=>$movie['title'],
	'PathToROOT'=>"../../",
	'genres'=>$genres
]);