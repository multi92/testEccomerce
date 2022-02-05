<?php
	include("app/class/Konkursi.php");
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];
	}
	
	if($theme_conf["separate_per_year_kokursi"][1] == 1 && !isset($command[1])){
		$cont = Konkursi::allYearList(true);
		include($system_conf["theme_path"][1]."views/konkursiyear.php");
	}
	else{
		$year = date("Y");
		if(isset($command[1]) && is_numeric($command[1])){
				$year = $command[1];
		}
		$cont = Konkursi::getList($year, $page, $theme_conf["konkursi_per_page"][1], false);	
		
		$pagination = GlobalHelper::paging($page, $cont[0], $theme_conf["konkursi_per_page"][1]);
		
		$konkursi = $cont[1];
		
		include($system_conf["theme_path"][1]."views/konkursi.php");	
	}

?>