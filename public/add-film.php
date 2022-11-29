<?php
require_once __DIR__ . "/../boot.php";

echo view('layout', [
	'content' => view('pages/add-film'),
	'menu' => view('components/menu', [
		'genres' => getGenres(),
	]),
	'title' => "Добавить фильм",
]);