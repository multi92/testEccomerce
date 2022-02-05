
					<?php if(isset($topproducts[1]) && count($topproducts[1])>3) { ?>
                    <h4 class="after section-title"><?php echo $language["index_sliders"][2]; // Najprodavanije ?></h4>
                    <div class="product-slider-holder">
                        <div class="owl-carousel owl3">
							<?php foreach($topproducts[1] as $val){ ?>
                            <?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
							<?php } ?>
                        </div>
                    </div>
					<?php } ?>
