<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
  					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
  							<span itemprop="name"><?php echo $language["global"][3]; ?></span>
  						</a>
						
  					</li>
					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="foto_gallery" itemprop="item">
  							<span itemprop="name"><?php echo $language["galleries"][1]; ?></span>
  						</a>
  					</li>
  					
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $galleryInfo['name']; ?></span>
  					</li>
				</ol>

</div>
<section class="pos">
	<div class="gallerys-bckg cms-galleries-bottom-bckg" ></div>
	<div class="container">
		<div class="content-page">
					<div class="row noMargin">
			<div class="col-md-12">
				<h4 class="after marginBottom30"><?php echo $galleryInfo['name']; ?></h4>
			</div>
		</div>
		<div class="row _unmargin">
			<?php foreach ($gallery_items[1] as $gallery) { 
					include($system_conf["theme_path"][1]."views/includes/gallerybox/galleryImageBox.php");
				  } 
			?>
		</div>
		<?php if(strlen($theme_conf["show_all_galleryitems"][1])>0 && $theme_conf["show_all_galleryitems"][1]==0) {?>
		<div class="row _unmargin">
			<div class="col-md-12 col-seter marginTop30">
				<nav aria-label="Page navigation">
  					<ul class="pagination">
					<?php 	
  					  if($pagination[0] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[0].'" aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
  					  if($pagination[1] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[1].'">&lsaquo;</a></li>';
  					  if($pagination[2] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[2].'">'.$pagination[2].'</a></li>';
  					  if($pagination[3] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[3].'">'.$pagination[3].'</a></li>';
  					  if($pagination[4] != '') echo '<li class="active"><a href="foto_gallery/'.$command[1].'?p='.$pagination[4].'">'.$pagination[4].'</a></li>';
					  if($pagination[5] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[5].'">'.$pagination[5].'</a></li>';
  					  if($pagination[6] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[6].'">'.$pagination[6].'</a></li>';
  					  if($pagination[7] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[7].'">&rsaquo;</a></li>';
  					  if($pagination[8] != '') echo '<li><a href="foto_gallery/'.$command[1].'?p='.$pagination[8].'" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
					?>
  					</ul>
				</nav>
			</div>
		</div>
		<?php } ?>
		</div>

	</div>
</section>