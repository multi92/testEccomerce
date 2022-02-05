<?php

//	include("app/class/ShopHelper.php");
	require_once("app/class/Product.php");
	require_once("app/class/Category.php");
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}

	$data = array();

		
	$prodata = array();
	$prodata[0] = array();
	$prodata[1] = array();
	$pagination = array();
	
	if($user_conf["show_products_all_category"][1] == 0 && !$isLastCategory ){
		//	show products in no last category		
	}
	else{
			
		$sortord = 'ASC';
		$sortby = 'sort';
		if(isset($_GET['sortord'])){ 
			$sortord = $_GET['sortord'];
			$sortby = 'sort';
		}
		
		$q = "SELECT productid FROM productextradetail WHERE extradetailid = 5 ORDER BY RAND()";
		$res = $mysqli->query($q);
		$proids = array();
		if($res->num_rows > 0)
		{
			while($row = $res->fetch_assoc())
			{
				array_push($proids, intval($row['productid']));	
			}
		}

		$prodata = Category::getCategoryProductDetail($proids, $page, $user_conf["product_per_page"][1], '', $sortord, $sortby, false,'','',1);
		//$prolist = array(), $page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "code",  $action = false, $minprice = '', $maxprice = '', $viewtype = 0
		
		$pagination = GlobalHelper::paging($page, $prodata[0], $user_conf["product_per_page"][1]);
	}
	$title = $language["global"][5];
	include($system_conf["theme_path"][1]."views/products_new.php");
	
?>