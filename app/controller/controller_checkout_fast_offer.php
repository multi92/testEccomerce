<?php
	$logged = false;
	//include_once("app/class/DeliveryService.php");
	//include_once("app/class/Shop.php");
	
	//$ShopData=Shop::getShopData();
	//$DeliveryService=DeliveryService::getDeliveryService();
	
	if(isset($_SESSION['shopcart']) && !empty($_SESSION['shopcart'])){
		
		if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged'){
			$logged = true;
		}
	}
	if(!isset($_SESSION['shopcart']) && !isset($_SESSION['shopcart_request'])){
		include("views/pageSessionExpired.php");
	} else {
		include($system_conf["theme_path"][1]."views/shopcartCheckoutFastOffer.php");
	}
	
?>