<?php
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}
	
	/*	left categories		*/
	
	$catdata = ShopHelper::getCategoryChild(0);
	
	for($i = 0; $i < count($catdata); $i++){
		$tmp = ShopHelper::getCategoryChildArray($catdata[$i]['id']);
		$catdata[$i]['subcats'] = $tmp;	
	}		
	
	if($user_conf["show_products_all_category"][1] == 0 ){
		//	show products in no last category	
	}
	else{

		$proids = array();
		$q = "SELECT id FROM product WHERE rebate > 0";		
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			
			while($rows = $res->fetch_assoc()){
				array_push($proids, $rows['id']);	
			}	
		}
		$prodata = Category::getCategoryProductDetail($proids, $page, $user_conf["product_per_page"][1]);
		$pagination = GlobalHelper::paging($page, count($proids), $user_conf["product_per_page"][1]);
		
	}
	
	include($system_conf["theme_path"][1]."views/promotion.php");

	
?>