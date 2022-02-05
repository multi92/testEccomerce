<?php if(isset($topslider) && count($topslider)>0){ ?>  
 <section style="padding: 0 !important;">
        <div class="container">
            <div class="row">
                <!-- TOP SLIDER 1 -->
                  <div class="col-md-12">
                    <div class="myslider">
                        <div class="owl-carousel owl1" itemscope itemtype ="http://schema.org/ImageObject">
                            <!-- ODNOS SLIKA U SLAJDERU 2:1 -->
                            <?php 
							$cnt=0;  
							$act='';
							$act_indicators='';
							$indicators='';
							$slides=''; ?>
							<?php foreach ($topslider as $slider) { ?>
								<?php $cnt++; 
									  if($cnt==1){ 
										$act='active'; 
										$act_indicators='class="active"';
									} else { 
										$act=''; 
										$act_indicators='';
									}
								?>
								<div><img src="<?php echo GlobalHelper::getImage($slider['item'], 'big'); ?>" alt="<?php echo $user_conf["sitetitle"];?>" class="img-responsive" itemprop="contentUrl"></div>
							<?php } ?>                            
                        </div>
                    </div>
                </div>
               <!-- .TOP SLIDER 1 -->
            </div>
        </div>
    </section>
<?php } ?>