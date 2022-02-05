
<?php if(isset($brenddata) && count($brenddata)>0) {?>

<?php $j = 0; ?>

		<div class="panel-group extra_details" id="accordionMobileBdF<?php echo $j;?>" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOneBrendsMobile">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMobileBdF<?php echo $j;?>" href="#collapseMobileBdF<?php echo $j;?>" aria-expanded="<?php echo $colapsed; ?>" aria-controls="collapseMobileBdF<?php echo $j;?>">
							<?php echo "Brendovi"; ?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>
						</a>
					</h4>
				</div>
				<div id="collapseMobileBdF<?php echo $j;?>" class="extradet panel-collapse in <?php echo $colapse; ?>" role="tabpanel" aria-labelledby="headingOneBrendsMobile" aria-expanded="<?php echo $colapsed; ?>" >
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

							<input type="checkbox" name="checkboxMobileBdF<?php echo $j."I".$n;?>" id="checkboxMobileBdF<?php echo $j."I".$n;?>" class="css-checkbox core_brendsSelectValueCheckbox <?php echo $check;?>"   <?php echo $ch; ?> brendid="<?php echo $v['id']; ?>" value="<?php echo $n; ?>"/>
							<label for="checkboxMobileBdF<?php echo $j."I".$n;?>" class="css-label x-filter-white"><?php echo $v['name']; ?></label>


						
			<?php	}	
			$j++;
		}
		?>
		
			</div>
		</div>



	</div>
</div>
<?php } ?>
