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
  						<span itemprop="name">Usluge</span>
  					</li>
				</ol>
			
		
	
</div>
<section class="pos" >
	<div class="container">
		<br>
		<br>
		<br>
		<?php //var_dump($services);?>
		<?php foreach($services AS $val){?>
		<?php 	if($val['id'] % 2 == 0) {?>
		<!-- image right -->
		<div class="row">
			<div class="services-holder clearfix">
				<div class="col-sm-6">
					<div class="description">
						<h3 class="title before"><?php echo $val['name']; ?></h3>
						<p class="text"><?php echo $val['description']; ?></p>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="image-holder">
						<img src="<?php echo GlobalHelper::getImage($val['image'], 'big') ;?>" alt="" class="img-responsive image">
						<div class="corner-right hidden-sm hidden-xs"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- .image right -->
		<?php   } else { ?>
		<!-- image left -->
		<div class="row">
			<div class="services-holder clearfix">
				<div class="col-sm-6 col-sm-push-6">
					<div class="description">
						<h3 class="title before"><?php echo $val['name']; ?></h3>
						<p class="text"><?php echo $val['description']; ?></p>
					</div>
				</div>
				<div class="col-sm-6 col-sm-pull-6">
					<div class="image-holder">
						<img src="<?php echo GlobalHelper::getImage($val['image'], 'big') ;?>" alt="" class="img-responsive image">
						<div class="corner-left hidden-sm hidden-xs"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- .image left -->
		<?php   } ?>
		<?php } ?>
		
		
		
	</div>
</section>