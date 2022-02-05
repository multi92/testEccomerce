<?php
//	$time_start = microtime(true);	
//	include("app/class/ShopHelper.php");
//	include_once("app/class/Product.php");
//	include_once("app/class/Category.php");
	
	require_once("app/class/SliderItem.php");	
	require_once("app/class/Brend.php");
	require_once("app/class/Category.php");
	
	$catsliderdata = SliderItem::GetSliderListById(1);
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}
	$isLastCategory = false;
	/*	prepare extradetail for flter	*/
	
	//$eddata = Category::getExtradetail();

	$brenddata = array();
	$brends = Brend::GetBrendList();
	//$brenddata=$brends[1];
	//var_dump($brenddata);
	/*	left categories		*/
	$eddata = Category::getExtradetail();
	$udata = Category::attrFormatFromUrl();
	
	$extradetail_array = array();
	if(isset($_GET['ed'])){
		$extradetail_array = $_GET['ed'];
	}

	$brend_array = array();
	if(isset($_GET['bd'])){
		$brend_array = $_GET['bd'];
	}
	
	$selectedbd='';
	if(isset($brend_array) && count($brend_array)>0){
		$selectedbd='?';
		foreach($brend_array as $bdval){
			$selectedbd.='&bd[]='.$bdval;
		}
	}
	
	$product_rebate=0;
	if(isset($_GET['reb']) && $_GET['reb']==1){ 
		$product_rebate = 1;
	}

	$brandproids = Category::getCategoryProduct(0, true, $extradetail_array, $udata, array(), $product_rebate );
		//var_dump(count($proids));		
	$brenddata = Category::getBrendsByProducIds($brandproids,$_SESSION['viewtype']);
	$brendids=array();
	foreach($brenddata as $k=>$v){
		array_push($brendids, $v['id']);
	}


	$brandselectedproids = Category::getCategoryProduct(0, true, $extradetail_array, $udata, $brend_array, $product_rebate );
		//var_dump(count($proids));		
	$brendselecteddata = Category::getBrendsByProducIds($brandselectedproids,$_SESSION['viewtype']);
	$brendselectedids=array();
	foreach($brendselecteddata as $k=>$v){
		array_push($brendselectedids, $v['id']);
	}



	
	$cdata = Brend::GetBrendCategories($brendselectedids);
	
	$cids=array();
	foreach($cdata[1] as $k=>$v){
		array_push($cids, $v['catid']);
	}
	$catdata=array();
	$catdata = ShopHelper::getCategoryChildForBrendIds($cids);
	for($i = 0; $i < count($catdata); $i++){
		$tmp = ShopHelper::getCategoryChildArray($catdata[$i]['id']);
		$catdata[$i]['subcats'] = $tmp;
		
		
		
	}
	
	
	include($system_conf["theme_path"][1]."views/brends.php");

	
?>