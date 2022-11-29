<?php
require_once __DIR__ . "/../boot.php";

echo view('layout', [
	'content' => view('pages/error'),
	'menu' => view('components/menu', [
		'genres' => getGenres(),
	]),
	'title' => "Ой, произошла ошибка",
]);