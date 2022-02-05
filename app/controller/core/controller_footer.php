<?php //DEVELOPER MODE
$controller_version["footer"] = array('controller', '1.0.0.0.1', 'SYSTEM THEME CONTROLLER - MUST HAVE DEFINED VALUES FOR $theme_conf["speed_menu_id"] AND $theme_conf["help_menu_id"][1] PARAMETER','app/controller/core/controller_footer.php');
?>
<?php
	
	$footerSpeedLinkMenu = getChildElements($theme_conf["speed_menu_id"][1]);	
	$footerHelpMenu = getChildElements($theme_conf["help_menu_id"][1]);	

	
	include ($system_conf["theme_path"][1]."views/includes/footer.php");
	
?>
