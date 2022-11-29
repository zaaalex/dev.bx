<?php
require_once __DIR__ . "/../boot.php";

if (!preg_match('/^\d+$/', $_GET['id']))
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("[film.php] Invalid film id!");
}
//проверка выражения пройдена - теперь можно обращаться к БД, будучи уверенным в том, что XSS нет
//$movie = getFilmById($movies, (int)$_GET['id']);
$movie = getFilmById((int)$_GET['id']);

if ($movie === null)
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("[film.php] Invalid film id!");
}

echo view('layout', [
	'content' => view('pages/film', [
		'movie' => $movie,
	]),
	'menu' => view('components/menu', [
		'genres' => getGenres(),
	]),
	'title' => $movie['TITLE'],
]);