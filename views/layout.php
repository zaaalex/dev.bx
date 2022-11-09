<?php
/**
 * @var string $content
 * @var string $title
 * @var string $PathToROOT
 * @var array $genres
 */
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?= $title?></title>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/reset.css>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/style.css>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/index.css>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/film.css>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/addFilm.css>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/favorite.css>
	<link rel="stylesheet" href = <?=$PathToROOT?>/views/css/error.css>
</head>
<body>

<div class="container">

	<div class="sidebar">
		<a href="http://dev.bx/services/pages/index.php?genre=Главная" class="logo">
			<img src="<?=$PathToROOT?>/data/image/logo.png" alt="">
		</a>
		<ul class="menu">
			<li class="menu-item">
				<a href="http://dev.bx/services/pages/index.php?genre=Главная" >ГЛАВНАЯ</a>
			</li>

			<?php foreach ($genres as $genre):?>
				<li class="menu-item">
					<a href="http://dev.bx/services/pages/index.php?genre=<?=$genre?>"><?=$genre?></a>
				</li>
			<?php endforeach;?>

			<li class="menu-item">
				<a href="http://dev.bx/services/pages/favorite.php">ИЗБРАННОЕ</a>
			</li>
		</ul>
	</div>

	<div class="wrapper">
		<div class="header">

			<div class="search-film">
				<form action="http://dev.bx/services/pages/index.php" method="post">
					<div class="icon-and-search">
						<div class="search"></div>
						<input type=text name="search" placeholder="Поиск по каталогу..">
					</div>
					<button type="submit">ИСКАТЬ</button>
				</form>
			</div>

			<form action="http://dev.bx/services/pages/addFilm.php" class="add-film">
				<button type="submit">ДОБАВИТЬ ФИЛЬМ</button>
			</form>

		</div>
		<?= $content?>
	</div>

</div>

</body>
</html>