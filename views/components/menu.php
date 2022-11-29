<?php
/**
 * @var array $genres
 */

$currentPage=$_SERVER['REQUEST_URI'];
?>

<ul class="menu">
	<li class="menu-item <?= ($currentPage === "/public/index.php") ? 'menu-item-active' : ''?>">
		<a href="/public/index.php"><?= getConfigurationOption("HOME_PAGE") ?></a>
	</li>

	<?php foreach ($genres as $key => $genre): ?>
		<li class="menu-item <?= ($currentPage === "/public/index.php?genre=$key") ? 'menu-item-active' : ''?>">
			<a href="/public/index.php?genre=<?= $key ?>"><?= $genre ?></a>
		</li>
	<?php endforeach ?>

	<li class="menu-item <?= ($currentPage === "/public/favorite.php") ? 'menu-item-active' : ''?>">
		<a href="/public/favorite.php"><?= getConfigurationOption("FAVORITES_PAGE") ?></a>
	</li>
</ul>