<?php
/**
 * @var array $movie
 */
?>


<div class="content">
	<div class="movie">
		<div class="movie-header">
			<div class="title-heart">
				<div class="movie-title"><?= $movie['title'] ?></div>
				<form action="">
					<!--можно поменять на true и посмотреть изменение состояния-->
					<?php if (false): ?>
						<button class="heart-active"></button>
					<?php else: ?>
						<button class="heart"></button>
					<?php endif; ?>
				</form>
			</div>
			<div class="title-age">
				<div class="movie-original"><?= $movie['original-title'] ?></div>
				<div class="movie-age"><?= $movie['age-restriction'] . '+' ?></div>
			</div>
			<div class="movie-header-border"></div>
		</div>
		<div class="movie-footer">
			<img src=<?= createImagePathByFilmId($movie['id']) ?>>
			<div class="movie-info">
				<div class="rating-bar">
					<ul class="boxes">
						<?php for ($i = 1; $i <= 10; ++$i): ?>
							<?php if ($i === (int)floor($movie['rating'])): ?>
								<li class="box-choose box box-<?= $i ?>"></li>
							<?php else: ?>
								<li class="box box-<?= $i ?>"></li>
							<?php endif; ?>
						<?php endfor; ?>
					</ul>
					<div class="ellipse-rating"><?= $movie['rating'] ?></div>
				</div>
				<div class="info-text">О фильме</div>
				<div class="movie-year">
					<div class="block1-text">Год производства:</div>
					<div class="block2-text"><?= $movie['release-date'] ?></div>
				</div>
				<div class="director">
					<div class="block1-text">Режиссер:</div>
					<div class="block2-text"><?= $movie['director'] ?></div>
				</div>
				<div class="actor">
					<div class="block1-text">В главных ролях:</div>
					<div class="block2-text"><?= implode(", ", $movie['cast']) ?></div>
				</div>
				<div class="info-text">Описание</div>
				<div class="block3-text"><?= $movie['description'] ?></div>
			</div>
		</div>

	</div>
</div>