<?php

/*
 * Проверяет, присутствует ли $genre в массиве $movieGenre.
 * От использования стандарной функции PHP пришлось отказаться ввиду специфичности данных -
 * названия жанров в данных о фильме начинаются с большой буквы
 */
function genreMatch (array $movieGenre, string $genre):bool
{
	foreach ($movieGenre as $genreM){
		if (mb_convert_case($genre, MB_CASE_LOWER, "UTF-8")===
			mb_convert_case($genreM, MB_CASE_LOWER, "UTF-8"))
		{
			return true;
		}
	}
	return false;
}

/*
 * Форматирует переданное в минутах время в формат 630мин./10:30
 */
function formatTimeInHourMinute(int $minute): string{
	if ($minute<0)
	{
		header("Location: http://dev.bx/services/pages/error.php");
		throw new RuntimeException("Invalid time! Minute must be>=0");
	}

	$str=(string)($minute)."мин. /".(string)(intdiv($minute, 60)).":";

	//для исключение ситуации, когда после ":" окажется одна цифра. Пример: 2:1 - фильм длится 2ч 1мин
	if ($minute%60<10)
	{
		$str.= '0';
	}

	return $str.(string)($minute%60);
}

/*
 * Урезает описание фильма до необходимой длины (по умолчанию 230). Учитывает тот факт, чтобы при обрезке описание
 * не обрывалось на середине слова - при такой ситуации слово будет вырезано полностью.
 */
function decreaseDescription(string $description, int $len=230): string{
	if (strlen($description)>$len)
	{
		$pos=strrpos(mb_strcut($description, 0, 440), " ", 0);
		$description=mb_strcut($description, 0, $pos)."..";
	}
	return $description;
}

/*
 * Формирует путь до картинки фильма по id фильма
 */
function createImagePathByFilmId(int $id):string{
	//Если писать return ROOT."/data/film_image/$id.jpg" будет ошибка, изображения не будут выводиться, почему?(
	return "/data/film_image/$id.jpg";
}

/*
 * [EXTENSION] МОЖЕТ ВОЗВРАЩАТЬ NULL
 * Проверяет, есть ли фильм с id=$id в массиве фильмов $movies - возвращает такой элемент при совпадении,
 * либо NULL при отсутствии.
 */
function getFilmById (array $movies, int $id): ?array
{
	foreach ($movies as $movie)
	{
		if ($movie['id']===$id)
		{
			return $movie;
		}
	}
	return NULL;
}