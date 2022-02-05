<!-- Podkategorije modal -->
					<?php if(!$isLastCategory){?>
                    <button type="button" class="btn myBtn modalPod visible-xs visible-sm" data-toggle="modal" data-target=".bs-example-modal-lg1">Podkategorije</button>
                    <div class="modal fade bs-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <h4 class="text-left pod-heading"><?php echo $language['kategorije'][2];?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <br>
                                <ul class="list-podkategorija ">
									<?php foreach($subcatsdata as $val){
									echo '<a href="'.Category::getCategoryPath($lastcatid).'/'.$val['urlname'].'">
											<li class="col-md-6 col-lg-4"><i class="fa fa-cog" aria-hidden="true"></i>'.$val['name'].'</li>
										  </a>';
									}?>                                    
                                </ul>
                            </div>
                        </div>
                    </div>
					<?php }?>
<!-- .Podkategorije modal end-->