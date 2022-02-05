
                        <a href="<?php echo Category::getCategoryPath($lastcatid).'/'.rawurlencode($sval['urlname']);?>">
                            <div class="categories-holder categories-help">
							<?php if($user_conf["show_subcategory_with_image"][1]=='1'){?>

							<?php $catimg = $sval['catobj']->image;  ?>

							    <?php if(is_array($sval['catobj']->image)) $catimg = $sval['catobj']->image[1]; ?>
                                <?php //var_dump($catimg);   ?>
								<div class="categories-pic">
									<img src="<?php echo GlobalHelper::getImage(($catimg), 'small'); ?>" alt="<?php echo $sval['name'];?>" class="img-responsive">
								</div>
							
							<?php }  ?>

                                <div class="categories-text">
                                    <p><?php echo $sval['name'];?></p>
                                </div>
                            </div>
                        </a>
