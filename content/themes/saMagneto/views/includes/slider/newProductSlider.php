					<?php if(isset($newproducts[1]) && count($newproducts[1])>3) { ?>
                    <h4 class="after section-title"><?php echo $language["index_sliders"][3]; // Novo u ponudi ?></h4>
                    <div class="product-slider-holder">
                        <div class="owl-carousel owl3">
							<?php foreach($newproducts[1] as $val){ ?>
                            <?php 	include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
							<?php } ?>
                        </div>
                    </div>
					<?php } ?>