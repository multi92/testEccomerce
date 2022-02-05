
<?php if(isset($brenddata) && count($brenddata)>0) {?>

<?php $j = 0; ?>

		<div class="panel-group extra_details" id="accordionBdF<?php echo $j;?>" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOneBrends">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionBdF<?php echo $j;?>" href="#collapseBdF<?php echo $j;?>" aria-expanded="<?php echo $colapsed; ?>" aria-controls="collapseBdF<?php echo $j;?>">
							<?php echo $language["side_brands"][1]; //Brendovi?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>
						</a>
					</h4>
				</div>
				<div id="collapseBdF<?php echo $j;?>" class="extradet panel-collapse <?php echo $colapse; ?> <?php echo $colapseopen; ?>" role="tabpanel" aria-labelledby="headingOneBrends" aria-expanded="<?php echo $colapsed; ?>" >
					<div class="panel-body">


<?php 
$checkget = false;
if(isset($_GET['bd'])){ $checkget = true;} 

foreach($brenddata as $k=>$v){
	$n = 0;
	$temp="";
	$acnt=count($v);

	$colapsed=false;
	$colapse="collapse";

	if(isset($_GET['bd']) AND count($_GET['bd'])>0){
			foreach($_GET['bd'] as $kgval=>$gatval){
				//echo ($gatval)." | ";
				if(isset($gatval) && $gatval==$v["id"] ){
					$colapsed=true;
					$colapse="collapse in";
				}	
			}
	}
		
	if(isset($v) && $v!=NULL){
		?>
		

						
						
						<?php $n++;
						$check = "";
						$ch="";
						$hide="";

						if($checkget){
							if(in_array($v['id'], $_GET['bd'])){ $check = "selected";  $ch="checked"; $hide="show";	$flag_collapsed=true; }
						}
						?>

							<input type="checkbox" name="checkboxBdF<?php echo $j."I".$n;?>" id="checkboxBdF<?php echo $j."I".$n;?>" class="css-checkbox core_brendsSelectValueCheckbox <?php echo $check;?>"   <?php echo $ch; ?> brendid="<?php echo $v['id']; ?>" value="<?php echo $n; ?>"/>
							<label for="checkboxBdF<?php echo $j."I".$n;?>" class="css-label x-filter-white"><?php echo $v['name']; ?></label>


						
			<?php	}	
			$j++;
		}
		?>
		
			</div>
		</div>



	</div>
</div>
<?php } ?>
