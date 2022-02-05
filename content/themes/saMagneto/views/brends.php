
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
  						<span itemprop="name"><?php echo $language["brends"][1]; //Brendovi ?></span>
  					</li>
				</ol>

</div>
<section>
    <div class="container">
    	<div class="content-page ">
    		<div class="row">
            <div class="col-md-3 hidden-sm hidden-xs">
                <?php include($system_conf["theme_path"][1]."views/includes/shop/leftPanelBrends.php");?>
            </div>
            <div class="col-md-9 col-sm-12">
                <?php include($system_conf["theme_path"][1]."views/includes/shop/topShopBrendsCategorysBox.php");?>       
            </div>
        </div>
    	</div>
        
    </div>
</section>