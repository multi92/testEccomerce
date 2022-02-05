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
  						<span itemprop="name"><?php echo $service["name"]; ?></span>
  					</li>
				</ol>
			
		
	
</div>
<section class="product-page" >
	<div class="container">
		
		<div class="container-bckg">
			<div class="row">
			<div class="col-md-12">
				<div class="title-holder">
					<h2 class="title before font-xs-18"><?php echo $service["name"]; ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="image-holder">
					<div class="easyzoom easyzoom--overlay">
						<a href="<?php echo GlobalHelper::getImage($service['image'], 'big') ;?>" class="links">
							<img src="<?php echo GlobalHelper::getImage($service['image'], 'big') ;?>" alt="prod" class="img-responsive image" itemprop="image">
						</a>
					</div>
				</div>
				
			</div>
			<div class="col-sm-6">
				<div class="spec">
					<div class="title-holder">
						<h5 class="title before font-sm-14 font-s-14 font-xs-14"><?php echo $language["service"][1]; //Opis ?></h5>
					</div>
					<div class="table-responsive">
						<p><?php echo $service["description"]; ?></p>
							
					</div>
				</div>
				
			</div>
		</div>
		</div>
		<br>
		<br>
		<br>
	</div>
</section>