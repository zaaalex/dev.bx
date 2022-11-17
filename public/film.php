<?php
require_once __DIR__ . "/../boot.php";

/**
 * @var array $movies ;
 * @var array $genres ;
 */

if (!preg_match('/^\d+$/', $_GET['id']))
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("[film.php] Invalid film id!");
}
//проверка выражения пройдена - теперь можно обращаться к БД, будучи уверенным в том, что sql-инъекции нет
$movie = getFilmById($movies, (int)$_GET['id']);


if ($movie===null)
{
	header("Location: /public/error.php");
	throw new InvalidArgumentException("[film.php] Invalid film id!");
}


echo view('layout', [
	'content' => view('pages/film', [
		'movie' => $movie,
	]),
	'title' => $movie['title'],
	'genres' => $genres,
]);