<?php if(isset($topslider) && count($topslider)>0){ ?> 
  <section style="padding: 0 !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
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
				<?php if(isset($topslider_slidebanner) && count($topslider_slidebanner)>0){ ?>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 col-xs-6 slide-xs">
                            <div class="myslider2">
                                <div class="owl-carousel owl2" itemscope itemtype ="http://schema.org/ImageObject">
                                    <!-- ODNOS SLIKA U SLAJDERU 2:1 -->
									<?php foreach ($topslider_slidebanner as $sliderbanner) { ?>
									<?php $cnt++; 
										if($cnt==1){ 
											$act='active'; 
											$act_indicators='class="active"';
										} else { 
											$act=''; 
											$act_indicators='';
										}
									?>
								<div><img src="<?php echo GlobalHelper::getImage($sliderbanner['item'], 'big'); ?>" alt="<?php echo $user_conf["sitetitle"];?>" class="img-responsive" itemprop="contentUrl"></div>
							<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-6 slide-xs" itemscope itemtype ="http://schema.org/ImageObject">
                            <div class="mybaner"><?php echo $topsliderbanner[0]["value"]; ?></div>
                        </div>
                    </div>
                </div>
				<?php } ?>
            </div>
        </div>
    </section>
<?php } ?>