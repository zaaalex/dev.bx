<?php
declare(strict_types = 1);

require "funcions.php";
require "movies.php";
/**@var array $movies */

$age = readline("Enter age: ");
if (is_numeric($age))
{
	getAvailableMovies($movies, floor((float)$age));
}
else
{
	echo "[ERROR]: Age must be numeric!";
}