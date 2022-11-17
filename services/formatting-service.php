<?php
include_once __DIR__."/../boot.php";

/*
 * Форматирует переданное в минутах время в формат 630мин./10:30
 */
function formatTimeInHourMinute(int $minute): string
{
	if ($minute < 0)
	{
		header("Location: /public/error.php");
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
 * Урезает некоторое описание до необходимой длины (по умолчанию 500). Учитывает тот факт, чтобы при обрезке
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
/*
 * Приводит название жанра на русском, если такой присутствует в массиве данных $genres.
 * Иначе возвращает исключение
 */

function genreToRu($genre):string
{
	/**
	 * @var array $genres ;
	 */
	require ROOT."/data/genres.php";

	if (array_key_exists($genre, $genres))
	{
		return $genres[$genre];
	}

	throw new InvalidArgumentException("[genreToRu]: Invalid genre");
}