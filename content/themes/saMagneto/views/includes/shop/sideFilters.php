<?php if($isLastCategory){ ?>

<?php $j = 0;
$checkget = false;
if(isset($_GET['at'])){ $checkget = true;} 

foreach($attrdata as $k=>$v){
	$n = 0;
	$temp="";
	$acnt=count($v);

	$colapsed=true;
	$colapse="collapse in";
	foreach($v as $vflag){
			//var_dump($vflag);
		if(isset($_GET['at']) AND count($_GET['at'])>0){
			foreach($_GET['at'] as $kgval=>$gatval){
				//echo ($gatval)." | ";
				if(isset($gatval) && $gatval==$vflag["avid"] ){
					//$colapsed=true;
					//$colapse="collapse in";
				}	
			}
		}
	}
	if(isset($v) && $v!=NULL){
		?>
		
		<div class="panel-group atributi" id="accordionATRF<?php echo $j;?>" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionATRF<?php echo $j;?>" href="#collapseATRF<?php echo $j;?>" aria-expanded="<?php echo $colapsed; ?>" aria-controls="collapseATRF<?php echo $j;?>">
							<?php echo $k; ?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>
						</a>
					</h4>
				</div>
				<div id="collapseATRF<?php echo $j;?>" class="panel-collapse <?php echo $colapse; ?>" role="tabpanel" aria-labelledby="headingOne" aria-expanded="<?php echo $colapsed; ?>" >
					<div class="panel-body">
						
						<?php foreach($v as $vv){ ?>
						<?php $n++;
						$check = "";
						$ch="";
						$hide="";

						if($checkget){
							if(in_array($vv['avid'], $_GET['at'])){ $check = "selected";  $ch="checked"; $hide="show";	$flag_collapsed=true; }
						}
						if ($vv['mi'] != '' || $vv['mc'] != ''){ 
							if($theme_conf["product_attr_box_type"][1]=='s'){
								$cms_atribute_box_type="filter-color-sqr";
							} else if($theme_conf["product_attr_box_type"][1]=='c'){
								$cms_atribute_box_type="";
							} else {
								$cms_atribute_box_type="filter-color-sqr";;
							}
							if($n==1){ ?>
							<ul class="filter-color-ul clearfix">
								<?php } ?>
								<?php if($vv['mi'] != ''){ //IMAGE ?> 
								<li class="filter-color-li <?php echo $cms_atribute_box_type; // SQUARE OR CIRCLE ?> core_attrSelectValueCheckbox <?php echo $check;?>" style="background-image: url('<?php echo $vv['mi']; ?>');" <?php echo $ch; ?> attrvalid="<?php echo $vv['avid']; ?>" value="<?php echo $n; ?>" ><i class="fa fa-times x-filter-white <?php echo $hide; ?>" aria-hidden="false"></i></li>
								<?php } ?>
								<?php if($vv['mc'] != ''){ //COLOR ?>
								<li class="filter-color-li <?php echo $cms_atribute_box_type; // SQUARE OR CIRCLE ?> core_attrSelectValueCheckbox <?php echo $check;?>" style="background: <?php echo $vv['mc']; ?>;" <?php echo $ch; ?> attrvalid="<?php echo $vv['avid']; ?>" value="<?php echo $n; ?>" ><i class="fa fa-times x-filter-white <?php echo $hide; ?>" aria-hidden="false"></i></li>
								<?php } ?>		

								<?php if($n==$acnt){ ?>
							</ul>
							<?php } ?>
							<?php } else { // TEXT ?>

							<input type="checkbox" name="checkboxATRF<?php echo $j."I".$n;?>" id="checkboxATRF<?php echo $j."I".$n;?>" class="css-checkbox core_attrSelectValueCheckbox <?php echo $check;?>"   <?php echo $ch; ?> attrvalid="<?php echo $vv['avid']; ?>" value="<?php echo $n; ?>"/>
							<label for="checkboxATRF<?php echo $j."I".$n;?>" class="css-label x-filter-white"><?php echo $vv['avvalue']; ?></label>

							<?php }	
							?>

							
							<?php } ?>

						</div>
					</div>



				</div>
			</div>
			<?php	}	
			$j++;
		}
		?>
		<?php } ?> 
