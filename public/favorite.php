<?php
require_once __DIR__ . "/../boot.php";

echo view('layout', [
	'content' => view('pages/favorite'),
	'menu' => view('components/menu', [
		'genres' => getGenres(),
	]),
	'title' => "Избранное",
]);