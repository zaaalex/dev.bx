<?php

/*
 * Проверяет, присутствует ли $genre в массиве $movieGenre.
 * От использования стандартной функции PHP пришлось отказаться ввиду специфичности данных -
 * названия жанров в данных о фильме начинаются с большой буквы
 */
function genreMatch(array $movieGenre, string $genre): bool
{
	foreach ($movieGenre as $genreM)
	{
		if (convertToLowerCase($genre) === convertToLowerCase($genreM))
		{
			return true;
		}
	}
	return false;
}

/*
 * Форматирует переданное в минутах время в формат 630мин./10:30
 */
function formatTimeInHourMinute(int $minute): string
{
	if ($minute < 0)
	{
		header("Location: /services/pages/error.php");
		throw new RuntimeException("Invalid time! Minute must be>=0");
	}

	$str = (string)($minute) . "мин. /" . (string)(intdiv($minute, 60)) . ":";

	//Для исключения ситуации, когда после ":" окажется одна цифра. Пример: 2:1 - фильм длится 2ч 1мин
	if ($minute % 60 < 10)
	{
		$str .= '0';
	}

	return $str . (string)($minute % 60);
}

/*
 * Урезает описание фильма до необходимой длины (по умолчанию 500). Учитывает тот факт, чтобы при обрезке
 * описание не обрывалось на середине слова - при такой ситуации слово будет вырезано полностью.
 */
function decreaseDescription(string $description, int $len = 500): string
{
	if (strlen($description) > $len)
	{
		$pos = strrpos(mb_strcut($description, 0, $len), " ", 0);
		$description = mb_strcut($description, 0, $pos) . "..";
	}
	return $description;
}

/*
 * Формирует путь до картинки фильма по id фильма
 */
function createImagePathByFilmId(int $id): string
{
	return "/data/film_image/$id.jpg";
}

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает фильм с искомым id, либо null, если такого не оказалось
 */
function getFilmById(array $movies, int $id): ?array
{
	foreach ($movies as $movie)
	{
		if ($movie['id'] === $id)
		{
			return $movie;
		}
	}
	return null;
}

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает массив фильмов, жанр которых совпадает с $genre
 */
function getFilmsByGenre(array $movies, string $genre): ?array
{
	$chooseMovies = [];
	if ($_GET['genre'] === "Главная")
	{
		$chooseMovies = $movies;
	}
	else
	{
		foreach ($movies as $movie)
		{
			if (genreMatch($movie['genres'], $genre))
			{
				$chooseMovies[] = $movie;
			}
		}
	}
	return $chooseMovies;
}

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Возвращает массив фильмов, в названии которых присутствует поисковый запрос $name
 */
function getFilmsByName(array $movies, string $name): ?array
{
	$chooseMovies = [];
	foreach ($movies as $movie)
	{
		/*
		 * При попытке заменить на функцию str_contains() -
		 *
		 * Fatal error: Uncaught Error: Call to undefined function str_contains()
		 * in C:\OSPanel\domains\dev.bx\services\command.php:111
		 * Stack trace:
		 * #0 C:\OSPanel\domains\dev.bx\services\pages\index.php(24): getFilmsByName()
		 * #1 {main} thrown in C:\OSPanel\domains\dev.bx\services\command.php on line 111
		 */
		if (
			/*
			 * !==false здесь ввиду того, что в случае совпадения $name с названием фильма
			* с первого символа strpos выдаст 0 в качестве ответа и условие if не сработает
			*/
			strpos(convertToLowerCase($movie['title']), convertToLowerCase($name)) !== false
			|| strpos(convertToLowerCase($movie['original-title']), convertToLowerCase($name)) !== false
		)
		{
			$chooseMovies[] = $movie;
		}
	}
	return $chooseMovies;
}

/*
 * Переводит строчку в LowerCase. Корректно работает со строчками на русском языке
 */
function convertToLowerCase(string $str): string
{
	return mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
}

/*
 * Возвращает строку, являющуюся результатом сокращения названия фильма до 38 символов с добавлением
 * года выпуска в скобках.
 */
function getFilmTitleWithYear($movie, $lengthTitle = 38): string
{
	return decreaseDescription($movie['title'], $lengthTitle)
		. " ("
		. $movie['release-date']
		. ")";
}