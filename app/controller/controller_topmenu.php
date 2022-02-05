<?php

	require_once("app/class/Category.php");

	$topmenudata = getChildElements(2);

	/*	root categories	*/
	$shoptype=$_SESSION['shoptype'];

	$typevisible='';

	switch ($shoptype) {
    case "b2c":
        $typevisible = ' AND b2cvisible=1 ';
        break;
    case "b2b":
        $typevisible = ' AND b2bvisible=1 ';
        break;
	}

	$db = Database::getInstance();
    $mysqli = $db->getConnection();
    $mysqli->set_charset("utf8");	
	$catcont = array();
	$q = "SELECT c.*,ctr.name as name_tr, ccf.content as caticon FROM category".CATEGORY_SUFIX." as c
	      LEFT JOIN category_tr as ctr ON c.id = ctr.categoryid
	      LEFT JOIN category_file as ccf ON c.id = ccf.categoryid AND ccf.type='icon'
		  WHERE c.parentid = 0 AND (ctr.langid = ". $_SESSION['langid']. " OR ctr.langid is null) ".$typevisible."
		  ORDER BY c.sort ASC";
		  
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$name = $row['name'];
			if($row['name_tr'] != '' || $row['name_tr'] != NULL){
				$name = $row['name_tr'];
			}

			if($row['caticon'] == NULL){
					$row['caticon'] = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
				}
			//array_push($catcont,array('catdata'=> Category::getCategoryData($row['id']),'catchilds'=>ShopHelper::getCategoryChild($row['id'])));
			array_push($catcont,array('catid'=> $row['id'],'catname'=> $name,'catpathname'=>$row['name'],'icon'=>$row['caticon'],'catchilds'=>ShopHelper::getCategoryChildArray($row['id'], CATEGORY_SUFIX)));
			
		}
	}

	//$catdata = ShopHelper::getCategoryChild(0);
	
	//$catdata1 = array_slice($catdata, 0, count($catdata) / 2);
	//$catdata2 = array_slice($catdata, count($catdata) / 2);
	//require_once("app/class/SliderItem.php");
	//$topslider = SliderItem::GetSliderListById(1);
	//echo '<pre>';
	//var_dump($catcont);
	//echo '</pre>';
	//die();
	
	include($system_conf["theme_path"][1]."views/topmenu.php");

	
	
?>