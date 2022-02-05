
			<div class="col-md-2 col-sm-3 col-xs-4 catalog-col col-seter">
				<div class="catalog-holder">
					<a href="fajlovi/<?php echo $v[0]->relativepath; ?>" target="_blank" title="<?php echo $language["global"][9]; // Preuzmi?>">
						<div class="catalog-filter transition">
							<img src="<?php echo $system_conf["theme_path"][1];?>img/icons/download-arrow.png " alt="<?php echo $language["global"][9]; // Preuzmi?>" class="img-responsive catalog-down transition">
						</div>
						<img src="<?php echo $v[0]->showimage ;?>" alt="<?php echo $v[0]->showname ;?>" class="img-responsive catalog-img">
						
					</a>
				</div>	
				<p class="catalog-name"><?php echo $v[0]->showname ;?></p>
			</div>