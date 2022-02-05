<?php 
	$colapsedR=false;
	$colapseR='collapse';
	$colapseopenR='in';
	if(isset($_GET['reb']) && $_GET['reb']>0){
		$colapsedR=true;
		$colapseR="collapse in";
	}
?>
<div class="panel-group rebate" id="accordionMobileRebF" role="tablist" aria-multiselectable="true">

			<div class="panel panel-default">

				<div class="panel-heading" role="tab" id="headingMobileOne">

					<h4 class="panel-title">

						<a role="button" data-toggle="collapse" data-parent="#accordionMobileRebF" href="#collapseMobileRebF" aria-expanded="<?php echo $colapsedR; ?>" aria-controls="collapseMobileRebF">

							<?php echo $language["side_links"][2]; // Proizvodi na akciji?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>

						</a>

					</h4>

				</div>

				<div id="collapseMobileRebF" class="rebate panel-collapse in <?php echo $colapseR; ?>" role="tabpanel" aria-labelledby="headingMobileOne" aria-expanded="<?php echo $colapsedR; ?>" >

					<div class="panel-body">
						<input type="checkbox" name="checkboxMobileRebF" id="checkboxMobileRebF" class="css-checkbox core_rebYesSelectValueCheckbox <?php echo $checkR;?>"   <?php echo $chR; ?>  value="1"/>

						<label for="checkboxMobileRebF" class="css-label x-filter-white"><?php echo $language["side_links"][3]; //Da?></label>
					</div>
				</div>
			</div>
	</div>


<?php if(isset($eddata) && count($eddata)>0) {?>



<?php $j = 0; ?>



		<div class="panel-group extra_details" id="accordionMobileEdF<?php echo $j;?>" role="tablist" aria-multiselectable="true">

			<div class="panel panel-default">

				<div class="panel-heading" role="tab" id="headingMobileOne">

					<h4 class="panel-title">

						<a role="button" data-toggle="collapse" data-parent="#accordionMobileEdF<?php echo $j;?>" href="#collapseMobileF<?php echo $j;?>" aria-expanded="<?php echo $colapsed; ?>" aria-controls="collapseMobileF<?php echo $j;?>">

							<?php echo $language["side_links"][1]; // Proizvodi ?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>

						</a>

					</h4>

				</div>

				<div id="collapseMobileF<?php echo $j;?>" class="extradet panel-collapse in <?php echo $colapse; ?>" role="tabpanel" aria-labelledby="headingMobileOne" aria-expanded="<?php echo $colapsed; ?>" >

					<div class="panel-body">
					



<?php 

$checkget = false;

if(isset($_GET['ed'])){ $checkget = true;} 



foreach($eddata as $k=>$v){

	$n = 0;

	$temp="";

	$acnt=count($v);



	$colapsed=false;

	$colapse="collapse";



	if(isset($_GET['ed']) AND count($_GET['ed'])>0){

			foreach($_GET['ed'] as $kgval=>$gatval){

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

							if(in_array($v['id'], $_GET['ed'])){ $check = "selected";  $ch="checked"; $hide="show";	$flag_collapsed=true; }

						}

						?>



							<input type="checkbox" name="checkboxMobileF<?php echo $j."I".$n;?>" id="checkboxMobileF<?php echo $j."I".$n;?>" class="css-checkbox core_extraDetailSelectValueCheckbox <?php echo $check;?>"   <?php echo $ch; ?> extradetailid="<?php echo $v['id']; ?>" value="<?php echo $n; ?>"/>

							<label for="checkboxMobileF<?php echo $j."I".$n;?>" class="css-label x-filter-white"><?php echo $v['name']; ?></label>





						

			<?php	}	

			$j++;

		}

		?>

		

			</div>

		</div>







	</div>

</div>

<?php } ?>

