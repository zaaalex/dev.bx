<?php
/**
* @var string $content
*/
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Главная страница</title>
	<link rel="stylesheet" href = "../views/reset.css">
	<link rel="stylesheet" href = "../views/style.css">
	<link rel="stylesheet" href = "../views/film.css">
</head>
<body>

<div class="container">

	<div class="sidebar">

		<div class="logo">
			<?php //@todo add href?>
			<a href=""></a>
		</div>
		<ul class="menu">
			<li class="menu-item">
				<a href="" >ГЛАВНАЯ</a>
			</li>
			<li class="menu-item">
				<a href="">ТРИЛЛЕР</a>
			</li>
			<li class="menu-item">
				<a href="">КОМЕДИЯ</a>
			</li>
			<li class="menu-item">
				<a href="">ФАНТАСТИКА</a>
			</li>
			<li class="menu-item">
				<a href="">ИЗБРАННОЕ</a>
			</li>
		</ul>
	</div>

	<div class="wrapper">
		<div class="header">

			<div class="search-film">


				<form action="">
					<div class="icon-and-search">
						<div class="search"></div>
						<input type=text name="name" placeholder="Поиск по каталогу..">
					</div>
					<button type="submit" type="button">ИСКАТЬ</button>
				</form>
			</div>

			<form action="" class="add-film">
				<button type="submit" type="button">ДОБАВИТЬ ФИЛЬМ</button>
			</form>

		</div>
		<?= $content?>
	</div>

</div>

</body>
</html>