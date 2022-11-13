<?php
/**
 * @var array $movie
 */
?>


<div class="content">
	<div class="movie">
		<div class="movie-header">
			<div class="title-heart">
				<div class="movie-title"><?=$movie['title']?></div>
				<?php //@todo add heart condition?>
				<div class="heart"></div>
			</div>
			<div class="title-age">
				<div class="movie-original"><?=$movie['original-title']?></div>
				<div class="movie-age"><?=$movie['age-restriction'].'+'?></div>
			</div>
			<div class="movie-header-border"></div>
		</div>
		<div class="movie-footer">
			<img src=<?=createImagePathByFilmId($movie['id']) ?>>
			<div class="movie-info">
				<div class="rating-bar">
					<ul class="boxes">
						<li class="box box-1"></li>
						<li class="box box-2"></li>
						<li class="box box-3"></li>
						<li class="box box-4"></li>
						<li class="box box-5"></li>
						<li class="box box-6"></li>
						<li class="box box-7"></li>
						<li class="box box-8"></li>
						<li class="box box-9"></li>
						<li class="box box-10"></li>
					</ul>
					<div class="ellipse-rating"><?=$movie['rating']?></div>
				</div>
				<div class="info-text">О фильме</div>
				<div class="movie-year">
					<div class="block1-text">Год производства:</div>
					<div class="block2-text"><?=$movie['release-date']?></div>
				</div>
				<div class="director">
					<div class="block1-text">Режиссер</div>
					<div class="block2-text"><?=$movie['director']?></div>
				</div>
				<div class="actor">
					<div class="block1-text">В главных</div>
					<div class="block2-text"><?=implode(", ", $movie['cast'])?></div>
				</div>
				<div class="info-text">Описание</div>
				<div class="block3-text"><?=$movie['description']?></div>
			</div>
		</div>

	</div>
</div>