<a href="foto_gallery/<?php echo $gallery->id //// Gallery Path?>">
	<div class="gallerys-holder pos" style="background-image: url('<?php echo GlobalHelper::getImage($gallery->img, 'big'); // Gallery Image ?>')">
		<div class="gallerys-info transition">
			<p><?php echo $gallery->name; // Gallery name?></p>
		</div>
	</div>
</a>