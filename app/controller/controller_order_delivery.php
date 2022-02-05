<?php
	include_once("app/class/DeliveryService.php");
	include_once("app/class/Shop.php");
	
	$ShopData=Shop::getShopData();
	$DeliveryService=DeliveryService::getDeliveryService();
	
	if(isset($_SESSION['ordering_address'])){
		$ord_adr = $_SESSION['ordering_address'];
		$ukupan_iznos = 0;
		foreach ($_SESSION['shopcart'] as $article) {
			$ukupan_iznos += $article['price'] * $article['qty'] * (1+$article['tax']/100) * (1-$article['rebate']/100);
		}

		include($system_conf["theme_path"][1]."views/order_delivery.php");
	}
	else{		
		if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus']=='logged' && $_SESSION['type']=='partner'){
			include "views/order_delivery.php";
		} else {	
			header( "Location: order_payment" );
		}
	}