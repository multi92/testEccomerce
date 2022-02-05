<?php //DEVELOPER MODE
$controller_version["categories"] = array('controller', '1.0.0.0.1', 'MUST BE DEFINED "show_products_all_category" and "product_per_page" PARAMETER in theme.configuration file','');
?>

<?php
	
	//$time_start = microtime(true);
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}

	$data = array();
//	$data = ShopHelper::getCategoryTreeUp(4);

//	$data = ShopHelper::getCategoryListFromProduct(2);

	//$data = ShopHelper::getCategoryTreeIdDown(1);

	//$data = ShopHelper::getCategoryChild(3);
	
	//$data = ShopHelper::getCategoryIdFromCommand($command);
	//if(!$data[count($data)-1]){
		// error url - show error404	
	//}
// TODO lang:2 getCategoryAttr(2) za srednju velicinu javlja se velicina na lang 1 kao dodatni atribut
//	$_SESSION['langid'] = '2';
//	$data = Category::getCategoryAttr(3);

//	$data = Category::getCategoryData(3);


//getCategoryProduct($catid, $page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "name",  $sub = true, $extradetail = array(), $action = false, $attrval = array(), $minprice = '', $maxprice = '' ){
	//$data = Category::getCategoryProduct(1,1,5,'','DESC', 'name', true, array(), false, array(), '', '' );

	//$data = Category::getRebate(4, 1);

	///$pagination = GlobalHelper::paging($page, $totalitems, $itemperpage);

	/*	check - is last category	*/
	
	//$extraDetails = GlobalHelper::getExtraDetailData();	
	$isLastCategory = GlobalHelper::isCategoryLast($command, CATEGORY_SUFIX);
	
	$data = ShopHelper::getCategoryIdFromCommand($command);

	$lastcatid = $data[count($data)-1];
	/*echo "<pre>";
	var_dump($lastcatid);
	echo "</pre>";*/
	if($lastcatid>0){
		$current_cat_data=Category::getCategoryData($lastcatid);
	}else{
		$current_cat_data=-1;
	}

	if($isLastCategory){
		// 'This is last category'	
		$attrdata = Category::getCategoryAttr($lastcatid);	
	}
	//echo '<pre>';
	//var_dump($attrdata);
	//echo '</pre>';
	//die();
	/*	get subcategories	*/
	$subcatsdata = array();	
	$subcatsdata = ShopHelper::getCategoryChild($lastcatid, CATEGORY_SUFIX);
	
	$catslider = Category::getCategorySlider($lastcatid);
	$catsliderdata=array();
	if(isset($catslider) && count($catslider)>0){
		require_once("app/class/SliderItem.php");
		$catsliderdata=SliderItem::GetSliderListById($catslider[0]['galleryid']);
	}
	$catimages = Category::getCategoryImages($lastcatid);
	//var_dump($subcatsdata);

	/*	prepare extradetail for flter	*/
	
	$eddata = Category::getExtradetail();

	$brenddata = array();//Category::getBrends();

	/*	left categories		*/
	
	$catdata = ShopHelper::getCategoryChild(0, CATEGORY_SUFIX);
	for($i = 0; $i < count($catdata); $i++){
		$tmp = ShopHelper::getCategoryChildArray($catdata[$i]['id'], CATEGORY_SUFIX);
		$catdata[$i]['subcats'] = $tmp;
	}
			
	/*	prepare attr for flter	*/
	
	$udata = Category::attrFormatFromUrl();
	
	$extradetail_array = array();
	if(isset($_GET['ed'])){
		$extradetail_array = $_GET['ed'];
	}

	$brend_array = array();
	if(isset($_GET['bd'])){
		$brend_array = $_GET['bd'];
	}
	
	
	$prodata = array();
	$prodata[0] = array();
	$prodata[1] = array();
	$pagination = array();
	
	if($theme_conf["show_products_all_category"][1] == 0 && !$isLastCategory ){
		//	show products in no last category	
	}
	else{
		$sortord = 'ASC';
		$sortby = 'sort';
		$minprice = '';
		$maxprice = '';
		
		$selectedmin = '';
		$selectedmax = '';
		
		if(isset($_GET['sort'])){ 
			$sortord = $_GET['sort'];
			$sortby = 'price';
		}
		
		if(isset($_GET['min'])){ 
			$minprice = $_GET['min'];
			$selectedmin = $_GET['min'];
		}
		if(isset($_GET['max'])){ 
			$maxprice = $_GET['max'];
			$selectedmax = $_GET['max'];
		}
		
		$limit= $theme_conf["product_per_page"][1];
		
		if(isset($_GET['limit'])){ 
			$limit= $_GET['limit'];
			$selectedlimit = $_GET['limit'];
		}

		$product_rebate=0;
		if(isset($_GET['reb']) && $_GET['reb']==1){ 
			$product_rebate = 1;
		}
		
		$proids = Category::getCategoryProduct($lastcatid, true, $extradetail_array, $udata, $brend_array, $product_rebate ); 
				
		$brandproids = Category::getCategoryProduct($lastcatid, true, $extradetail_array, $udata, array(), $product_rebate ); 
		
		$brenddata = Category::getBrendsByProducIds($brandproids,$_SESSION['viewtype']);
		//$prodata = Category::getCategoryProductDetail($proids, $page, $user_conf["product_per_page"][1], '', $sortord, $sortby, false, $minprice, $maxprice);
					
		if(isset($_SESSION['viewtype']) && $_SESSION['viewtype']==3){
			$prodataTemp = Category::getCategoryProductDetail($proids, $page, $limit,'',$sortord, $sortby, false, $minprice, $maxprice,$_SESSION['viewtype']);
			$prodata = Category::parseCategoryProductDataForB2BView($prodataTemp,$lastcatid,$minprice, $maxprice);
		} else {
			$prodataTemp = Category::getCategoryProductDetail($proids, $page, $limit,'',$sortord, $sortby, false, $minprice, $maxprice,$_SESSION['viewtype']);
			//var_dump($prodataTemp);
			$prodata = $prodataTemp;
		}
		
		//var_dump(($prodataTemp[0]));
		/*if((isset($_SESSION['type']) && $_SESSION['type'] == 'commerc') || ($_SESSION['viewtype'] == 3 && $_SESSION['type'] == 'partner'))
		{
			$prodata = Category::getCategoryProductDetail($proids, $page, $limit,'',$sortord, $sortby, false, $minprice, $maxprice, true);
		}*/
	
		//$prodata = Category::getCategoryProductDetail($proids, $page, $limit,'',$sortord, $sortby, false, $minprice, $maxprice, true);
	
		$pagination = GlobalHelper::paging($page, $prodataTemp[0], $limit);
		
		
		$pricemin = $prodataTemp['min']; 
		$pricemax = $prodataTemp['max'];
		
		if(!isset($_GET['min'])) $selectedmin = $prodataTemp['min'];
		if(!isset($_GET['max'])) $selectedmax = $prodataTemp['max'];	
		
		/*
		$q = 'SELECT ROUND(pw.price*(1+t.value/100),2) as price FROM productwarehouse pw
				LEFT JOIN product p ON pw.productid = p.id
				LEFT JOIN tax t ON p.taxid = t.id
				WHERE pw.productid in ('.implode(',',$proids).') AND pw.warehouseid = "'.$_SESSION['warehouseid'].'" ORDER BY price ASC LIMIT 1';
		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			$prow = $res->fetch_assoc();
			$pricemin = $prow['price'];
			if($selectedmin == ''){
				$selectedmin = $prow['price'];	
			}
		}
		$q = 'SELECT ROUND(pw.price*(1+t.value/100),2) as price FROM productwarehouse pw
				LEFT JOIN product p ON pw.productid = p.id
				LEFT JOIN tax t ON p.taxid = t.id
				WHERE pw.productid in ('.implode(',',$proids).') AND pw.warehouseid = "'.$_SESSION['warehouseid'].'" ORDER BY price DESC LIMIT 1';
		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			$prow = $res->fetch_assoc();
			$pricemax = $prow['price'];
			if($selectedmax == ''){
				$selectedmax = $prow['price'];	
			}
		}
		*/
	}
		
	include($system_conf["theme_path"][1]."views/categories.php");
	
?>
