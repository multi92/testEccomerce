                   
					<?php if(isset($brends[1]) && count($brends[1])>0) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="brand-slider">
                                <div class="owl-carousel owl4">
                                <?php foreach($brends[1] as $bval) { ?>
                                    <?php if($bval->hasimage==1){?>
                                        <div class="brands-slider"><a href="<?php echo $bval->link;?>" target="_blank"><img src="<?php echo GlobalHelper::getImage($bval->image, 'small'); ?>" alt="<?php echo $bval->name; ?>" class="img-responsive"></a></div>
                                    <?php } ?>
                                <?php } ?>
                                </div> 
                            </div>             
                        </div>
                    </div>
					<?php } ?>
                    