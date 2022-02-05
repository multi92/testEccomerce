<?php 


foreach(ShopHelper::getCategoryIdFromCommand($command) as $key=>$val){
	//$a = Category::getCategoryData($val);
	?>
	
<?php } ?>



<div class="page-head">
	<ol class="breadcrumb">
		<li>
			<a href="<?php  echo HOME_PAGE ;?>">
				<span><?php echo $language["global"][3]; ?></span>
			</a>
		</li>
		<?php 
		
			foreach(ShopHelper::getCategoryIdFromCommand($command) as $key=>$val){
				$a = Category::getCategoryData($val); 
				if($key == count($command)-1){ ?>
					<li class="active">
						<span><?php echo ucfirst($a->name); ?></span>
					</li>
				<?php }else{ ?>
					<li >
						<a href="<?php  echo $a->path ;?>">
							<span><?php echo ucfirst($a->name); ?></span>
						</a>
					</li>
				<?php }
			} ?>

</ol>

</div>
<section>
	<div class="container">
		<div class="content-page -noPadding">
			<div class="row">
				<?php  if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged" && isset($_SESSION["shoptype"]) && $_SESSION["shoptype"]=="b2b"){ ?>

				<div class="col-sm-12">
					<?php include($system_conf["theme_path"][1]."views/includes/shop/B2BTopPanel.php");?>
				</div>
				<div class="col-sm-12">
					<?php include($system_conf["theme_path"][1]."views/includes/shop/topCategorysBox.php");?>
                  
                    <?php include($system_conf["theme_path"][1]."views/includes/shop/topFiltesWithModalsBox.php");?>
					
					<?php include($system_conf["theme_path"][1]."views/includes/shop/productView.php");?>
				</div>
			<?php }else {?>
				<div class="col-md-3 hidden-sm hidden-xs">
					<?php include($system_conf["theme_path"][1]."views/includes/shop/leftPanel.php");?>
				</div>
				<div class="col-md-9">
					<?php include($system_conf["theme_path"][1]."views/includes/shop/topCategorysBox.php");?>
                    
                    <?php include($system_conf["theme_path"][1]."views/includes/shop/topFiltesWithModalsBox.php");?>
					
					
					<?php include($system_conf["theme_path"][1]."views/includes/shop/productView.php");?>
				</div>

			<?php }?>
			</div>

		</div>
	</div>
</section>
<?php include($system_conf["theme_path"][1]."views/includes/modal/categoryTopFilterModal.php");?>
