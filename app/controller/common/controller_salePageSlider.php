 <?php //DEVELOPER MODE
$controller_version["salePageSlider"] = array('controller', '1.0.0.0.1', 'MUST HAVE DEFINED VALUES FOR $theme_conf["sale_top_slider_gallery_id"] PARAMETER','app/controller/common/controller_salePageSlider.php');
?>
 <?php
	/*SALE SLIDER*/	
	require_once("app/class/SliderItem.php");	
	$salepageslider= SliderItem::GetSliderListById($theme_conf["sale_top_slider_gallery_id"][1]);
	/*SALE SLIDER*/
	include($system_conf["theme_path"][1]."views/includes/slider/salePageSlider.php");
?>