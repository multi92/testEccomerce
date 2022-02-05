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
  						<span itemprop="name"><?php echo $language["products_new"][1]; ?></span>
  					</li>
				</ol>

</div>

<?php //include("app/controller/common/controller_outletPageSlider.php");?>
<section>
	<div class="container">
		<div class="row marginBottom30">
			<div class="col-md-12">
				<h4 class="after"><?php echo $language["products_new"][2]; ?></h4>
				<p><?php echo $language["products_new"][3]; ?></p>
			</div>
		</div>
		<div class="row noMargin">
			<?php foreach($prodata[1] as $key=>$val) { ?>
			<div class="col-md-2 col-sm-3 col-xs-4 xsProduct-col col-seter">
				<?php 	include($system_conf["theme_path"][1]."views/includes/productbox/productBox.php");?>
			</div>
			<?php } ?>
		</div>
		<div class="row noMargin">
			
				<div class="col-md-12 col-seter">
					<nav aria-label="Page navigation">
  					<ul class="pagination">
					<?php 	
  					  if($pagination[0] != '') echo '<li><a href="outlet?p='.$pagination[0].'" aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
  					  if($pagination[1] != '') echo '<li><a href="outlet?p='.$pagination[1].'">&lsaquo;</a></li>';
  					  if($pagination[2] != '') echo '<li><a href="outlet?p='.$pagination[2].'">'.$pagination[2].'</a></li>';
  					  if($pagination[3] != '') echo '<li><a href="outlet?p='.$pagination[3].'">'.$pagination[3].'</a></li>';
  					  if($pagination[4] != '') echo '<li class="active"><a href="outlet?p='.$pagination[4].'">'.$pagination[4].'</a></li>';
					  if($pagination[5] != '') echo '<li><a href="outlet?p='.$pagination[5].'">'.$pagination[5].'</a></li>';
  					  if($pagination[6] != '') echo '<li><a href="outlet?p='.$pagination[6].'">'.$pagination[6].'</a></li>';
  					  if($pagination[7] != '') echo '<li><a href="outlet?p='.$pagination[7].'">&rsaquo;</a></li>';
  					  if($pagination[8] != '') echo '<li><a href="outlet?p='.$pagination[8].'" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
					?>
  					</ul>
				</nav>
				</div>
			
		</div>
	</div>
</section>