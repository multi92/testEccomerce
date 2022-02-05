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
		
		$q = "SELECT p.id FROM product p 
				LEFT JOIN productcategory pc ON p.id = pc.productid
				LEFT JOIN category c ON pc.categoryid = c.id
			WHERE c.".$_SESSION['shoptype']."visible = 1 AND p.rebate > 0 ORDER BY RAND()";
		$res = $mysqli->query($q);
		$proids = array();
		if($res->num_rows > 0)
		{
			while($row = $res->fetch_assoc())
			{
				array_push($proids, intval($row['id']));	
			}
		}
	//echo 'test';
		//$prodata = Category::getCategoryProductDetail($proids, $page, $user_conf["product_per_page"][1], '', $sortord, $sortby);
		$prodata = Category::getCategoryProductDetail($proids, $page, $user_conf["product_per_page"][1],'',$sortord, $sortby, false, '', '',$_SESSION['viewtype']);
		
		$pagination = GlobalHelper::paging($page, $prodata[0], $user_conf["product_per_page"][1]);
	}
	$title = $language["global"][4];

	include($system_conf["theme_path"][1]."views/sale.php");
	
?>