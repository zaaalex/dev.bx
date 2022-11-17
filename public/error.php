<?php
require_once __DIR__ . "/../boot.php";

/**
 * @var array $genres ;
 */

echo view('layout', [
	'content' => view('pages/error'),
	'title' => "Ой, произошла ошибка",
	'genres' => $genres,
]);