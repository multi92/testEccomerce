<?php
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}
	$isLastCategory = false;
	/*	prepare extradetail for flter	*/
	$eddata = Category::getExtradetailWelcomePage();
	
	/*	left categories		*/
	$catdata = ShopHelper::getCategoryChild(0);
	
	for($i = 0; $i < count($catdata); $i++){
		$tmp = ShopHelper::getCategoryChildArray($catdata[$i]['id']);
		$catdata[$i]['subcats'] = $tmp;
	}
	/*	left categories		*/
		
	/*	prepare attr for flter	*/
	$extradetail_array = array();
	if(isset($_GET['ed'])){
		$extradetail_array = $_GET['ed'];
	}


	
	include_once("app/class/News.php");	
	
	$news = News::getNewsList($page, $theme_conf["news_on_pocetna"][1], false);
	
	include($system_conf["theme_path"][1]."views/pocetna.php");	
	
?>