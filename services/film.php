<?php

require_once __DIR__.'/../boot.php';

echo view ('layout',[
	'content' => view('pages/film')
]);