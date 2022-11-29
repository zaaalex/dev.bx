<?php
/**
 * @var array $movies
 */
?>

<div class="content">
	<?php foreach ($movies as $movie): ?>
		<div class="content-item">
			<div class="film-overlay">
				<a href="/public/film.php?id=<?= $movie['ID'] ?>">ПОДРОБНЕЕ</a>
			</div>
			<img src="<?= createImagePathByFilmId((int)$movie['ID']) ?>">
			<div class="film-title"><?= getFilmTitleWithYear($movie) ?></div>
			<div class="film-original-title"><?= $movie['ORIGINAL_TITLE'] ?></div>
			<div class="film-border"></div>
			<div class="film-description"><?= decreaseDescription($movie['DESCRIPTION']) ?></div>

			<div class="film-time-container">
				<div class="container-time">
					<div class="time-image"></div>
					<div class="time"><?= formatTimeInHourMinute($movie['DURATION']) ?></div>
				</div>
				<div class="genre"><?= decreaseDescription(($movie['GENRES']), 100) ?></div>
			</div>
		</div>
	<?php endforeach; ?>
</div>