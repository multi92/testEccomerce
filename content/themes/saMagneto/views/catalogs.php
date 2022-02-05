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
  						<span itemprop="name"><?php echo $language["catalogs"][1]; //Katalozi ?></span>
  					</li>
				</ol>

</div>
<section class="pos">
	<div class="gallerys-bckg cms-galleries-bottom-bckg"></div>
	<div class="container">
		<div class="content-page">
			
		
			<div class="row">
			<div class="col-md-12">
				<h4 class="after marginBottom30"><?php echo $language["catalogs"][2]; //Katalozi naših proizvoda ?></h4>
			</div>
			</div>
			<div class="row _unmargin">
			<?php if(isset($catalogs) && is_array($catalogs)){ 
					foreach($catalogs as $k=>$v){
						
						include($system_conf["theme_path"][1]."views/includes/catalogbox/catalogBox.php");
					}
				 } else { ?>
       	     <h2><?php echo $language["catalogs"][3]; //Trenutno nema postavljenih kataloga ?></h2>
       	 <?php } ?>		
			</div>
	</div>
	</div>
</section>