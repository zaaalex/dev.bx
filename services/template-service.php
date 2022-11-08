<?php

/*
 * Дополняет переданный $path до абсолютного и отображает страничку с $variables массивом значений
 */
function view(string $path, array $variables = []):string
{
	if(!preg_match('/^[0-9A-Za-z\/_-]+$/', $path))
	{
		throw new RuntimeException('Invalid path');
	}

	$absolutePath=ROOT."/views/$path.php";

	if (!file_exists($absolutePath))
	{
		throw new RuntimeException('Invalid path');
	}

	extract($variables,  EXTR_OVERWRITE);

	ob_start();
	require $absolutePath;
	return ob_get_clean();
}