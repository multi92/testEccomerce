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
  						<span itemprop="name"><?php echo $language["shopcart"][1]; //Korpa ?></span>
  					</li>
				</ol>

</div>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["empty_shopcart"][1]; ?>" alt="<?php echo $language["shopcartempty"][1]; //Vaša korpa je prazna ?>" class="img-responsive empty-cart">
				<h1 class="text-center"><?php echo $language["shopcartempty"][1]; //Vaša korpa je prazna ?></h1>
				<p class="text-center"><a href="<?php echo $language["global"][3]; ?>"><?php echo $language["shopcartempty"][2]; //Vratite se na početnu stranicu ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></p>
			</div>
		</div>
	</div>
</section>