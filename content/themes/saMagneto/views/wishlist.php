<div class="page-head">

	<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
		<li itemprop="itemListElement" itemscope
		itemtype="http://schema.org/ListItem">
		<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
			<span itemprop="name"><?php echo $language["global"][3]; ?></span>

		</a>

	</li>

	<li class="active" itemprop="itemListElement" itemscope
	itemtype="http://schema.org/ListItem">
	<span itemprop="name"><?php echo $language["wishlist"][1];?></span>
</li>
</ol>

</div>
<section>
	<div class="container">
		<div class="content-page">

			<?php if(isset($_SESSION["wishlist"]) && count($_SESSION["wishlist"])>0){ ?>
				<div class="row">
					<div class="col-md-12 ">



						<?php if(is_array($wishlistprods[1]) && count($wishlistprods[1]) > 0 ){?>
						<?php foreach ($wishlistprods[1] as $val) { ?>
							<div class="col-lg-3 col-md-4 col-xs-6 _unpadding border-seter">
								<?php include($system_conf["theme_path"][1]."views/includes/productbox/productBox.php");?>
							</div>
						<?php } ?>
						<?php } ?>



					</div>
				</div>
				<!--PAGINATION-->
				<div class="row noMargin">
					<div class="col-md-12 col-seter marginTop30">
						<nav aria-label="Page navigation">
							<ul class="pagination">
								<?php 	
								if($pagination[0] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[0].'&'.$getnopage.'" aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
								if($pagination[1] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[1].'&'.$getnopage.'">&lsaquo;</a></li>';
								if($pagination[2] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[2].'&'.$getnopage.'">'.$pagination[2].'</a></li>';
								if($pagination[3] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[3].'&'.$getnopage.'">'.$pagination[3].'</a></li>';
								if($pagination[4] != '') echo '<li class="active"><a href="'.implode("/", $command).'/?p='.$pagination[4].'&'.$getnopage.'">'.$pagination[4].'</a></li>';
								if($pagination[5] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[5].'&'.$getnopage.'">'.$pagination[5].'</a></li>';
								if($pagination[6] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[6].'&'.$getnopage.'">'.$pagination[6].'</a></li>';
								if($pagination[7] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[7].'&'.$getnopage.'">&rsaquo;</a></li>';
								if($pagination[8] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[8].'&'.$getnopage.'" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
								?>
							</ul>
						</nav>
					</div>
				</div>
				<!--PAGINATION END-->
			<?php } else {?>
				<div class="row">
					<div class="col-md-12 ">

						<div class="col-md-12">
							<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["empty_wishlist"][1]; ?>" alt="<?php echo $language["shopcartempty"][1]; //Vaša korpa je prazna ?>" class="img-responsive empty-cart">
							<h1 class="text-center"><?php echo $language["wishlist"][2]; //Lista zelja je prazna ?></h1>
							<p class="text-center"><a href="pocetna"><?php echo $language["shopcartempty"][2]; //Vratite se na početnu stranicu ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></p>
						</div>
						

					</div>
				</div>
			<?php } ?>
		</div>


	</div>

</section>