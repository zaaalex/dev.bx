<?php
include_once __DIR__."/../boot.php";

/*
 * Дополняет переданный $path до абсолютного и отображает страничку с $variables массивом значений
 */
function view(string $path, array $variables = []): string
{
	if (!preg_match('/^[0-9A-Za-z\/_-]+$/', $path))
	{
		throw new RuntimeException('Invalid path');
	}

	$absolutePath = ROOT . "/views/$path.php";

	if (!file_exists($absolutePath))
	{
		throw new RuntimeException('Invalid path');
	}

	extract($variables, EXTR_OVERWRITE);

	ob_start();
	require $absolutePath;
	return ob_get_clean();
}

/*
 * Формирует путь до картинки фильма по id фильма
 */
function createImagePathByFilmId(int $id): string
{
	return "/data/film-image/$id.jpg";
}

function getConfigurationOption(string $name, string $defaultValue = null)
{
	/**
	 * @var array $config ;
	 * @var array $localConfig ;
	 */
	require ROOT . "/config.php";

	file_exists(ROOT . "/local-config.php") ? require ROOT . '/local-config.php' : $localConfig=[];

	$config=array_merge($config, $localConfig);

	if (array_key_exists($name, $config))
	{
		return $config[$name];
	}

	if ($defaultValue !== null)
	{
		return $defaultValue;
	}

	throw new \RuntimeException("Configuration option $name not found!");
}