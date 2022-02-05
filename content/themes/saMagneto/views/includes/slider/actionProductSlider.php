
<?php //DEVELOPER MODE
if($system_conf["developer_mode"][1]==1){
	echo '<!--COMMENT-->';
	echo '<!--SEGMENT ACTION PRODUCT SLIDER-->';
	echo '<!--THEME PATH views/includes/personbox/personBox.php-->';	
}?>
					<?php if(isset($actionproducts[1]) && count($actionproducts[1])>3) { ?>
					<h4 class="section-title after"><?php echo $language["index_sliders"][1]; // Hit Akcija ?></h4>
                    <div class="product-slider-holder">
                        <div class="owl-carousel owl3">
							<?php foreach($actionproducts[1] as $val){ ?>
                            <?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
							<?php } ?>
                        </div>
                    </div>
					<?php } ?>

<?php //DEVELOPER MODE
if($system_conf["developer_mode"][1]==1){
	echo '<!--SEGMENT ACTION PRODUCT SLIDER-->';	
}?>
