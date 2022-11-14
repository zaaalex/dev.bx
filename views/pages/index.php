<?php
/**
 * @var array $movies
 */
?>

<div class="content">
	<?php foreach ($movies as $movie):?>
	<div class="content-item">
		<div class="film-overlay">
			<a href="http://dev.bx/services/pages/film.php?id=<?=$movie['id']?>">ПОДРОБНЕЕ</a>
		</div>
		<img src="<?=createImagePathByFilmId($movie['id']) ?>">
		<div class="film-title"><?=decreaseDescription($movie['title'],38)." (".$movie['release-date'].")"?></div>
		<div class="film-original-title"><?=$movie['original-title']?></div>
		<div class="film-border"></div>
		<div class="film-description"><?=decreaseDescription($movie['description']) ?></div>

		<div class="film-time-container">
			<div class="container-time">
				<div class="time-image"></div>
				<div class="time"><?=formatTimeInHourMinute($movie['duration'])?></div>
			</div>
			<div class="genre"><?=implode(", ", $movie['genres'])?></div>
		</div>
	</div>
	<?php endforeach; ?>
</div>