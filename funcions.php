<?php

function printMovie($movie, $movieNumber):void{
	echo "{$movieNumber}. ".$movie["title"]." ({$movie["release_year"]}), "."{$movie["age_restriction"]}+."." Rating - {$movie["rating"]}\n";
}

function getAvailableMovies(array $movies, int $age): void{
	$countAvailableMovies = 0;
	foreach ($movies as $film) {
		if ($film["age_restriction"]>=$age){
			$countAvailableMovies++;
			printMovie($film, $countAvailableMovies);
		}
	}
}