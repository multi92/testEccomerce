<?php //DEVELOPER MODE
$controller_version["news"] = array('controller', '1.0.0.0.1', 'SYSTEM THEME CONTROLLER MUST HAVE DEFINED VALUE FOR "$theme_conf["news_type"]"" AND "$theme_conf["news_per_page"][1]" PARAMMETERS','app/controller/controller_news.php');
?>
<?php
	include_once("app/class/News.php");
	
	if(isset($command[1]) && $command[1] != ""){
		$news = News::getNews($command[1]);
		
		include($system_conf["theme_path"][1]."views/newssingle.php");
	}
	else{
		$page = 1;
		if(isset($_GET['p']) && $_GET['p'] != ""){
			$page = $_GET['p'];	
		}
		
		$news_per_page=$theme_conf["news_per_page"][1];
		if($theme_conf["news_type"][1]==0  && $page==1) {
			$news_per_page=$theme_conf["news_per_page"][1]+1;
		}
		
		$maincats=GlobalHelper::getAllMainNewsCatsWithSubcat();
		
		$news = News::getNewsList($page, $news_per_page, false);	
		
		$pagination = GlobalHelper::paging($page, $news[0], $news_per_page );
		
		$tags = News::getAllTags();
		
		
		switch ($theme_conf["news_type"][1]) {
			case 0:
				include($system_conf["theme_path"][1]."views/news.php");
				break;
			//case 1:
			//	include("views/news_type_01.php");
			//break;
		}
			
	}

	
?>