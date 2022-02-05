<?php //DEVELOPER MODE
$controller_version["outletPageSlider"] = array('controller', '1.0.0.0.1', 'MUST HAVE DEFINED VALUES FOR $theme_conf["outlet_top_slider_gallery_id"] PARAMETER','app/controller/controller_outletPageSlider.php');
?>
<?php
	/*SALE SLIDER*/	
	require_once("app/class/SliderItem.php");	
	$outletpageslider= SliderItem::GetSliderListById($theme_conf["outlet_top_slider_gallery_id"][1]);
	/*SALE SLIDER*/
	include($system_conf["theme_path"][1]."views/includes/slider/outletPageSlider.php");
?>