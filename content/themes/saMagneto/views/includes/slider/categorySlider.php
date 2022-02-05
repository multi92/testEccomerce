<div class="myslider2">
            <div class="owl-carousel owl2" itemscope itemtype ="http://schema.org/ImageObject">
                <!-- ODNOS SLIKA U SLAJDERU 2:1 -->
				<?php 
							$cnt=0;  
							$act='';
							$act_indicators='';
							$indicators='';
							$slides=''; ?>
				<?php foreach ($catsliderdata as $sliderdata) { ?>
									<?php $cnt++; 
										if($cnt==1){ 
											$act='active'; 
											$act_indicators='class="active"';
										} else { 
											$act=''; 
											$act_indicators='';
										}
									?>
								<div><img src="<?php echo GlobalHelper::getImage($sliderdata['item'], 'big'); ?>" alt="<?php echo $current_cat_data->name;?>" class="img-responsive" itemprop="contentUrl"></div>
				<?php } ?>
            </div>
</div>