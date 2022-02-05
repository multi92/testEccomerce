<?php
	include_once("app/class/News.php");
	//$time_start = microtime(true);
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}
	
	$maincats=GlobalHelper::getAllMainNewsCatsWithSubcat();

	$data = array();

	$isLastCategory = GlobalHelper::isNewsCategoryLast($command[count($command)-1]);
	
		
	$data = ShopHelper::getNewsCategoryIdFromCommand($command);
	
	if($data[count($data)-1]!='news'){
		$lastcatid = $data[count($data)-1];
	} else { 
	$lastcatid=0;
	}
	
	if($lastcatid>0){
		$current_cat_data=NewsCategory::getNewsCategoryData($lastcatid);
	}else{
		$current_cat_data=-1;
	}


	
	
	
	$subcatsdata = array();
	$subcatsdata = ShopHelper::getNewsCategoryChild($lastcatid);

	$catimages = NewsCategory::getNewsCategoryImages($lastcatid);
	//var_dump($subcatsdata);


	/*	left categories		*/

	$catdata = ShopHelper::getNewsCategoryChild(0);
	for($i = 0; $i < count($catdata); $i++){
		$tmp = ShopHelper::getNewsCategoryChildArray($catdata[$i]['id']);
		$catdata[$i]['subcats'] = $tmp;
	}
			
	$newsdata = array();
	$newsdata[0] = array();
	$newsdata[1] = array();
	$pagination = array();
	
	if($theme_conf["show_news_all_newscategory"][1] == 0 && !$isLastCategory ){
		//	show products in no last category	
	}
	else{
		$sortord = 'DESC';
		$sortby = 'adddate';
		

		//var_dump($lastcatid);
		$newsids = NewsCategory::getCategoryNews($lastcatid, true );

		$newsdata = NewsCategory::getNewsCategoryNewsDetail($newsids, $page, $theme_conf["news_per_page"][1],'',$sortord, $sortby, false);
	
		$pagination = GlobalHelper::paging($page, count($newsdata[1]), $theme_conf["news_per_page"][1]);
		

	}
	//echo microtime(true)-$time_start."</br></br>";	

	include($system_conf["theme_path"][1]."views/kategorije_news.php");

	
?>