<?php
require_once __DIR__ . '/../../boot.php';

/**
 * @var array $movies ;
 * @var array $genres ;
 */

if (!preg_match('/^\d+$/', $_GET['id']) || getFilmById($movies, (int)$_GET['id']) === null)
{
	header("Location: /services/pages/error.php");
	return new InvalidArgumentException("Invalid film id!");
}

$movie = getFilmById($movies, (int)$_GET['id']);

echo view('layout', [
	'content' => view('pages/film', [
		'movie' => $movie,
	]),
	'title' => $movie['title'],
	'genres' => $genres,
]);