<!-- Atributi modal -->
					<?php if($isLastCategory){?>
                    <button type="button" class="btn myBtn modalAtr visible-xs visible-sm marginBottom20 marginTop20" data-toggle="modal" data-target=".bs-example-modal-lg2">Atributi</button>
                    <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content attr-modal">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="atributi">
                                    <h4>Atributi</h4>
                                    <hr>
                                    <h5>Opseg cena</h5>
                                    <div class="panel-body >
                            	<p>
									<b class="pull-left"> <?php echo $pricemin; ?> </b> 
                                	<b class="pull-right"> <?php echo $pricemax; ?></b> 
                                </p>
								
                                <input id="ex3" type="text" class="span2" value="" data-slider-min="<?php echo $pricemin; ?>" data-slider-max="<?php echo $pricemax; ?>" data-slider-step="1" data-slider-value="[<?php echo $selectedmin; ?>,<?php echo $selectedmax; ?>]" />    
                            </div>
                                    <?php
							$j = 0;
							$checkget = false;
			   			if(isset($_GET['at'])){ $checkget = true;}

               	   		foreach($attrdata as $k=>$v){
							echo '<hr>
								  <h5>'.$k.'</h5>';

							$n = 0;
							$temp="";
							
							$acnt=count($v);
							
							foreach($v as $vk=>$vv){
								$n++;
								$check = "";
								$ch="";
								if($checkget){
									if(in_array($vv['avid'], $_GET['at'])){ $check = "selected";	$ch="checked";	$flag_collapsed=true; }
								}
						
								if ($vv['mi'] != '')
								{
									if($n==1){
										$temp.='<div id="checkboxes">';
									}
									//slicica
									$temp.= '<input type="checkbox" name="rGroup'.$j.'" id="r'.$n.'"  class="jq_attrSelectValueCheckbox boja '.$check.'" '.$ch.' attrvalid="'.$vv['avid'].'" value="'.$n.'"/>
											<label style="background-image:url('.$vv['mi'].')" class="bgblack " for="r'.$n.'"><span>&nbsp;'.$vv['qty'].'&nbsp;</span></label>';
											
		
									if($n==$acnt){
										$temp.='</div>';
									}
								}
								else if($vv['mc'] != '')
								{
									//boja
									if($n==1){
										$temp.='<div id="checkboxes">';
									}
									$temp.='<input type="checkbox" name="rGroup'.$j.'" id="r'.$n.'"  class="jq_attrSelectValueCheckbox boja '.$check.'" '.$ch.' attrvalid="'.$vv['avid'].'" value="'.$n.'"/>
											<label style="background-color:'.$vv['mc'].'" class="bgblack " for="r'.$n.'"><span>&nbsp;'.$vv['qty'].'&nbsp;</span></label>';
											//<input type="checkbox" name="rGroup" value="1" id="r1" />
											//<label class="whatever1" for="r1"><span>&nbsp;54&nbsp;</span></label>
											
									if($n==$acnt){
										$temp.='</div>';
									}
								}
								else 
								{	
									if($n==1){
										$temp.='<form>';
									}
									$temp.= '
											<div class="checkbox">
												<label><input type="checkbox" class="jq_attrSelectValueCheckbox '.$check.'" '.$ch.' attrvalid="'.$vv['avid'].'">'.$vv['avvalue'].'</label>
												<p class="pull-right">['.$vv['qty'].']</p>
											</div>
											
										';
									if($n==$acnt){
										$temp.='</form>';
									}			
									
								}

							}
							
							
							echo $temp;
							
							$j++;
						}
						?>
                                </div>
                            </div>
                        </div>
                    </div>
<?php }?>
                    <!-- .Atributi modal -->