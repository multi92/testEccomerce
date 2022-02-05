<?php //DEVELOPER MODE
$controller_version["brendSlider"] = array('controller', '1.0.0.0.1', 'SLIDER OF BRENDS USED ON INDEX','app/controller/brendSlider.php');
?>
<?php
	/*BRENDS*/	
	require_once("app/class/Brend.php");	
	$brends = Brend::GetBrendList();
	/*BRENDS*/
	include($system_conf["theme_path"][1]."views/includes/slider/brendSlider.php");
?>
