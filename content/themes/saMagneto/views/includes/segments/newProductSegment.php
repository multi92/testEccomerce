<?php if(isset($newproducts[1]) && count($newproducts[1])>3) { ?>
<div class="segments">
<div class="section-title">
	<h4 class="title"><?php echo $language["index_sliders"][3]; // Novo u ponudi ?></h4>
</div>
    <div class="row _unmargin">
		<?php foreach($newproducts[1] as $val){ ?>
			<div class="col-sm-3 col-xs-6 col-seter-zero">
        		<?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
        	</div>
		<?php } ?>
    </div>
    <div class="all-products hide">
    	<a href="" class="links">Pogledajte sve nove proizvode</a>
    </div>
</div>
<?php } ?>