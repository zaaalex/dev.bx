<?php
/**
 * @var string $content
 * @var string $menu
 * @var string $title
 */
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="/views/css/reset.css">
	<link rel="stylesheet" href="/views/css/layout.css">
	<link rel="stylesheet" href="/views/css/index.css">
	<link rel="stylesheet" href="/views/css/film.css">
	<link rel="stylesheet" href="/views/css/add-film.css">
	<link rel="stylesheet" href="/views/css/favorite.css">
	<link rel="stylesheet" href="/views/css/error.css">
	<link rel="stylesheet" href="/views/css/menu.css">
</head>
<body>

<div class="container">

	<div class="sidebar">
		<a href="/public/index.php" class="logo">
			<img src="/data/image/logo.png" alt="">
		</a>

		<?=$menu?>

	</div>

	<div class="wrapper">
		<div class="header">

			<div class="search-film">
				<form action="/public/index.php" method="get">
					<div class="icon-and-search">
						<div class="search"></div>
						<input type=text name="search" placeholder="Поиск по каталогу..">
					</div>
					<button type="submit"><?=option("SEARCH") ?></button>
				</form>
			</div>

			<form action="/public/add-film.php" class="add-film">
				<button type="submit"><?=option("ADD_FILM") ?></button>
			</form>

		</div>
		<?= $content ?>
	</div>

</div>

</body>
</html>