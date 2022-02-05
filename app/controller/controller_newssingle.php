<?php //DEVELOPER MODE
$controller_version["categories_newssingle"] = array('controller', '1.0.0.0.1', 'SYSTEM THEME CONTROLLER','app/controller/controller_categories_newssingle.php');
?>
<?php
	include_once("app/class/News.php");
	
	if(isset($command[1]) && $command[1] != ""){
		$news = News::getNews($command[1]);
		
		include($system_conf["theme_path"][1]."views/newssingle.php");
	}
?>