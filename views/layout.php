<?php
/**
 * @var string $content
 * @var string $title
 * @var array $genres
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
	<link rel="stylesheet" href="/views/css/addFilm.css">
	<link rel="stylesheet" href="/views/css/favorite.css">
	<link rel="stylesheet" href="/views/css/error.css">
</head>
<body>

<div class="container">

	<div class="sidebar">
		<a href="/services/pages/index.php?genre=Главная" class="logo">
			<img src="/data/image/logo.png" alt="">
		</a>
		<ul class="menu">
			<li class="menu-item">
				<a href="/services/pages/index.php?genre=Главная">ГЛАВНАЯ</a>
			</li>

			<?php foreach ($genres as $genre): ?>
				<li class="menu-item">
					<a href="/services/pages/index.php?genre=<?= $genre ?>"><?= $genre ?></a>
				</li>
			<?php endforeach ?>

			<li class="menu-item">
				<a href="/services/pages/favorite.php">ИЗБРАННОЕ</a>
			</li>
		</ul>
	</div>

	<div class="wrapper">
		<div class="header">

			<div class="search-film">
				<form action="/services/pages/index.php" method="post">
					<div class="icon-and-search">
						<div class="search"></div>
						<input type=text name="search" placeholder="Поиск по каталогу..">
					</div>
					<button type="submit">ИСКАТЬ</button>
				</form>
			</div>

			<form action="/services/pages/addFilm.php" class="add-film">
				<button type="submit">ДОБАВИТЬ ФИЛЬМ</button>
			</form>

		</div>
		<?= $content ?>
	</div>

</div>

</body>
</html>