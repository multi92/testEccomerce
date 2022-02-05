<?php if(isset($actionproducts[1]) && count($actionproducts[1])>3) { ?>
<div class="segments">
	<div class="section-title">
		<h4 class="title"><?php echo $language["index_sliders"][1]; // Hit Akcija ?></h4>
	</div>
    <div class="row _unmargin">
		<?php foreach($actionproducts[1] as $val){ ?>
        	<div class="col-sm-3 col-xs-6 col-seter-zero">
            	<?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
        	</div>
		<?php } ?>
    </div>
    <div class="all-products">
    	<a href="sale" class="links">Pogledajte sve proizvode na akciji</a>
    </div>
</div>
	
<?php } ?>