<?php
/**
 * @var array $genres
 */
?>

<ul class="menu">
	<li class="menu-item">
		<a href="/public/index.php"><?= getConfigurationOption("HOME_PAGE") ?></a>
	</li>

	<?php
	foreach ($genres as $key => $genre): ?>
		<li class="menu-item">
			<a href="/public/index.php?genre=<?= $key ?>"><?= $genre ?></a>
		</li>
	<?php
	endforeach ?>

	<li class="menu-item">
		<a href="/public/favorite.php"><?= getConfigurationOption("FAVORITES_PAGE") ?></a>
	</li>
</ul>