<?php

//	$time_start = microtime(true);	
//	include("app/class/ShopHelper.php");
//	include_once("app/class/Product.php");
//	include_once("app/class/Category.php");
	
	require_once("app/class/SliderItem.php");	
	
	$catsliderdata = SliderItem::GetSliderListById(1);
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}
	$isLastCategory = false;
	/*	prepare extradetail for flter	*/
	
	$eddata = Category::getExtradetail();

	/*	left categories		*/
	
	$catdata = ShopHelper::getCategoryChild(0);
	for($i = 0; $i < count($catdata); $i++){
		$tmp = ShopHelper::getCategoryChildArray($catdata[$i]['id']);
		$catdata[$i]['subcats'] = $tmp;
	}
	//var_dump($catdata);
	/*	prepare attr for flter	*/
	
	
	$extradetail_array = array();
	if(isset($_GET['ed'])){
		$extradetail_array = $_GET['ed'];
	}
	
	/*
	$proids = Category::getAllProduct($extradetail_array );
	
	$prodata = Category::getCategoryProductDetail($proids, $page, $user_conf["product_per_page"][1]);
	
	$pagination = GlobalHelper::paging($page, $prodata[0], $user_conf["product_per_page"][1]);
	
	*/
	//echo microtime(true)-$time_start."</br></br>";	
	include($system_conf["theme_path"][1]."views/shop.php");

	
?>