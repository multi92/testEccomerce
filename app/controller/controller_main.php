<?php

	$views_array = array();////face
	//$time_start = microtime(true);
	#var_dump($command);

	include("app/controller/core/controller_headermain.php");
	
	if(isset($command[0]) && strlen($command[0]) > 0 && $command[0]!='inprogress')
	{
		include("app/controller/core/controller_header.php"); // ~0.22 SEC  
		include("app/controller/controller_topmenu.php");	// ~0.23 SEC  
		

	}
	elseif(!isset($command[0]) || $command[0] == ""){
		if($system_conf["site_in_progress"][1]==0){
			include("app/controller/core/controller_header.php");
			include("app/controller/controller_topmenu.php");
		} 
	} 
	/*	Get news - footer + home	*/
	$newscont = array();
	
	$q="SELECT n.*, ntr.shortnews as shortnewstr, ntr.title as titletr FROM news n
	LEFT JOIN news_tr ntr ON n.id = ntr.newsid
	WHERE ntr.langid=".$_SESSION['langid']." OR ntr.langid IS NULL ORDER BY id DESC LIMIT 4";
	
	/*	dont need including in controller - always visible	*/
	$db = Database::getInstance();
	$mysqli = $db->getConnection();
	$mysqli->set_charset("utf8");
	
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			array_push($newscont, array("id"=>$row['id'], "shortnews"=>($row['shortnewstr'] > '')? $row['shortnewstr']:$row['shortnews'], "title"=>($row['titletr'] > '')? $row['titletr']:$row['title'], "image"=>$row['thumb'] ));
		}
	}



	if(isset($_SESSION['updated']) && $_SESSION['updated']==0 && isset($_SESSION['type']) && $_SESSION['type']!="commerc"){

		include("app/controller/controller_update_personal_info.php");	

		
		
	} else {
		if(isset($_SESSION['type']) && $_SESSION['type']=="commerc" && isset($_SESSION['partnerid']) && $_SESSION['partnerid']==0 ){
			//$command[0]='commercialist_select_partner';
			//echo '123456';
				include("app/controller/controller_commercialist_select_partner.php");
			
		} 

		else {
			//echo '555';
		if(file_exists("app/controller/controller_".strtolower(rawurldecode($command[0])).".php")){
			$currentPageName = strtolower(rawurldecode($command[0]));
			include("app/controller/controller_".strtolower(rawurldecode($command[0])).".php");	
		}
		else
		{
			//echo '666';
			/* stranica se trazi u bazi	*/

		// $q="SELECT p.*, ptr.value as valuetr, ptr.showname as shownametr FROM pages p 
		// 	LEFT JOIN pages_tr ptr ON p.id = ptr.pageid
		// 	WHERE p.name = '".strtolower(rawurldecode($command[0]))."' AND status = 'v' AND (ptr.langid=".$_SESSION['langid']." OR ptr.langid IS NULL)";
		// $res = $mysqli->query($q);

			if(GlobalHelper::isDBPage($command)){
				$currentPageName = 'dbpage';
				include("app/controller/controller_dbpage.php");
			}
			else
			{
				
				/* provera da li je stanica u shop	*/
				$catname = $command[0];
				if(is_numeric($command[0])){
					$catname = $command[1];
				}
				$q="SELECT * FROM category".CATEGORY_SUFIX." WHERE parentid = 0 AND name like '".$mysqli->real_escape_string(rawurldecode($catname))."'";
			//echo $q;
				$res = $mysqli->query($q);
				$q1="SELECT * FROM newscategory WHERE parentid = 0 AND name like '".$mysqli->real_escape_string(rawurldecode($catname))."'";
			//echo $q;
				$res1 = $mysqli->query($q1);
				if($res->num_rows > 0){
					if(GlobalHelper::isProduct($command)){
						$currentPageName = 'proizvod';
						include("app/controller/controller_proizvod.php");

					}
					else{
						$currentPageName = strtolower(rawurldecode($command[0]));
						include("app/controller/controller_categories.php");
					}

				} else if($res1->num_rows > 0){
					if(GlobalHelper::isNews($command)){
						$currentPageName = 'news';
						include("app/controller/controller_newssingle.php");
					}
					else{
					
					/*echo microtime(true)-$time_start."</br></br>";
					$time_start = microtime(true);
					*/ 
						$currentPageName = strtolower(rawurldecode($command[0]));
						include("app/controller/controller_kategorije_news.php");
					}
				}
				else{
					
					include("app/controller/core/controller_error404.php");
				}	
			}
	}
	}

}

	//include ("views/includes/templates.php");

if(isset($command[0]) && strlen($command[0]) > 0 && $command[0]!='inprogress')
{
	include("app/controller/core/controller_footermain.php");

}
elseif(!isset($command[0]) || $command[0] == ""){
	if($system_conf["site_in_progress"][1]==0){
		include("app/controller/core/controller_footermain.php");
	} 
}

if($_SESSION['acceptcookies']=='on'){
	include("views/cookiesinfo.php");
} 

include ("app/components/notification_handler.php");

	//echo microtime(true)-$time_start."</br></br>";
foreach($views_array as $k=>$v){
	include $v;
}

include("app/controller/controller_actionbirthday.php");
?>