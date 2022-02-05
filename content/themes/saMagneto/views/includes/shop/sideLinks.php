<?php if(isset($command[0]) && $command[0]!='shop') {?>
<?php 
	$colapsedR=false;
	$colapseR='collapse';
	$colapseopenR='in';
	if(isset($_GET['reb']) && $_GET['reb']>0){
		$colapsedR=true;
		$colapseR="collapse in";
	}
?>
<div class="panel-group rebate" id="accordionRebF" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordionRebF" href="#collapseRebF" aria-expanded="<?php echo $colapsedR; ?>" aria-controls="collapseRebF">
					<?php echo $language["side_links"][2]; // Proizvodi na akciji?>
					<i class="fa fa-angle-down go-right" aria-hidden="true"></i>
				</a>
			</h4>
		</div>
		<?php $checkR=''; ?>
		<?php $chR=''; ?>
		<?php if(isset($_GET['reb']) && $_GET['reb']>0){ ?>
			<?php $checkR='selected'; ?>
			<?php $chR='checked'; ?>
		<?php }?>
		<div id="collapseRebF" class="extradet panel-collapse <?php echo $colapseR; ?> <?php echo $colapseopenR; ?>" role="tabpanel" aria-labelledby="headingOne" aria-expanded="<?php echo $colapsedR; ?>" >
			<div class="panel-body">
				<input type="checkbox" name="checkboxRebFYes" id="checkboxRebFYes" class="css-checkbox core_rebYesSelectValueCheckbox <?php echo $checkR;?>"   <?php echo $chR; ?>  value="1"/>
				<label for="checkboxRebFYes" class="css-label x-filter-white"><?php echo $language["side_links"][3]; //Da?></label>
			</div>
		</div>
	</div>
</div>
<?php }?>



<?php if(isset($eddata) && count($eddata)>0) {?>

<?php $j = 0; ?>
<?php $colapsed=false;
	  $colapse="collapse";
	  $colapseopen = 'in';
?>
		<div class="panel-group extra_details" id="accordionEdF<?php echo $j;?>" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionEdF<?php echo $j;?>" href="#collapseF<?php echo $j;?>" aria-expanded="<?php echo $colapsed; ?>" aria-controls="collapseF<?php echo $j;?>">
							<?php echo $language["side_links"][1]; // Proizvodi ?> <i class="fa fa-angle-down go-right" aria-hidden="true"></i>
						</a>
					</h4>
				</div>
				<div id="collapseF<?php echo $j;?>" class="extradet panel-collapse <?php echo $colapse; ?> <?php echo $colapseopen; ?>" role="tabpanel" aria-labelledby="headingOne" aria-expanded="<?php echo $colapsed; ?>" >
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

							<input type="checkbox" name="checkboxF<?php echo $j."I".$n;?>" id="checkboxF<?php echo $j."I".$n;?>" class="css-checkbox core_extraDetailSelectValueCheckbox <?php echo $check;?>"   <?php echo $ch; ?> extradetailid="<?php echo $v['id']; ?>" value="<?php echo $n; ?>"/>
							<label for="checkboxF<?php echo $j."I".$n;?>" class="css-label x-filter-white"><?php echo $v['name']; ?></label>


						
			<?php	}	
			$j++;
		}
		?>
		
			</div>
		</div>



	</div>
</div>
<?php } ?>
