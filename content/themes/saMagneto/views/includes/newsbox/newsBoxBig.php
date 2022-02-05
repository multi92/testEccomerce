<div class="col-sm-12 col-seter">
	<a href="news/<?php echo $val->id; ?>">
		<div class="big-news-holder" itemscope itemtype="http://schema.org/Article">
			<div class="big-news-pic" style="background-image: url('<?php echo rawurldecode(GlobalHelper::getImage($val->thumb, 'big')); //News Image ?>');" itemprop="image">
				<div class="news-filter transition"></div>
				<div class="news-head transition">
					<small>Autor: <span itemprop="author"><?php echo $user_conf["company"][1];?></span></small>
					<span class="timeSpan">
						<time datetime="<?php echo $val->date; //News date ?>" itemprop="datePublished"><?php echo $val->date; //News date ?></time>
					</span>
					<h4 itemprop="name"><?php echo $val->title; //News title ?></h4>
					<p>
						<i class="fa fa-angle-right transition" aria-hidden="true"></i> <?php echo $val->shortnews; //News short ?>
					</p>
					<a href="news/<?php echo $val->id; ?>" class="sa-button">Pročitaj više</a>
				</div>
			</div>
		</div>
	</a>
</div>