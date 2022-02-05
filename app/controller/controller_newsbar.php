<?php //DEVELOPER MODE
$controller_version["newsbar"] = array('controller', '1.0.0.0.1', 'SYSTEM THEME CONTROLLER','app/controller/controller_categories_newsbar.php');
?>
<?php
	include_once("app/class/News.php");		
	require_once("app/class/Shop.php");
	$shops = Shop::getList();
	$shops = $shops[1];

	include($system_conf["theme_path"][1]."views/newsBar.php");
?>