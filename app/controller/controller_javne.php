<?php
	include("app/class/Javne.php");
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];
	}

	$parnum = 1;
	if($command[0] == 'dokumenta') $parnum = 2;
	
	if($theme_conf["separate_per_year_javne"][1] == 1 && !isset($command[$parnum])){
		$cont = Javne::allYearList(true);
		include($system_conf["theme_path"][1]."views/javnenabavkeyear.php");	
	}
	else{
		$year = date("Y");
		if(isset($command[$parnum]) && is_numeric($command[$parnum])){
				$year = $command[$parnum];
		}
		$cont = Javne::getList($year, $page, $theme_conf["javne_per_page"][1], false);
		$pagination = GlobalHelper::paging($page, $cont[0], $theme_conf["javne_per_page"][1]);
	
		$javne = $cont[1];
		
		
		include($system_conf["theme_path"][1]."views/javnenabavke.php");		
	}

		
	
?>