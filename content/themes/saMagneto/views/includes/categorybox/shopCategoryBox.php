
                        <a href="<?php echo rawurlencode($sval['urlname']);?>">
                            <div class="categories-holder categories-help transition">
							<?php if($user_conf["show_subcategory_with_image"][1]=='1'){ ?>
							<?php  $catimg = $sval['image']; ?>
							<?php if(is_array($sval['image'])) $catimg = $sval['image'][1]; ?>
								<div class="categories-pic">
									<img src="<?php echo GlobalHelper::getImage(rawurldecode($catimg), 'big'); ?>" alt="<?php echo $sval['name'];?>" class="img-responsive">
								</div>
							
							<?php } ?>
                                <div class="categories-text">
                                    <p><?php echo $sval['name'];?></p>
                                </div>
                            </div>
                        </a>