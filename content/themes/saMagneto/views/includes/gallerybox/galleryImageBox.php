<div class="col-sm-2 col-xs-4 gallery-pic-col col-seter">
	<div class="gallery-pic-holder">
		<a href="<?php echo GlobalHelper::getImage(rawurldecode($gallery->item), 'big'); ?>" data-fancybox="gallery" data-caption="<?php echo $gallery->title;?>">
			<img src="<?php echo GlobalHelper::getImage(rawurldecode($gallery->item), 'big'); ?>" alt="<?php echo $gallery->title;?>" class="img-responsive" />
		</a>
	</div>
</div>