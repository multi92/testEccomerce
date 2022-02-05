<?php
	$logged = false;
	include_once("app/class/DeliveryService.php");
	include_once("app/class/Shop.php");
	
	$ShopData=Shop::getShopData();
	$DeliveryService=DeliveryService::getDeliveryService();
	
	if(isset($_SESSION['shopcart']) && !empty($_SESSION['shopcart'])){
		
		if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged'){
			$logged = true;
		}
	}
	if(!isset($_SESSION['shopcart']) && !isset($_SESSION['shopcart_request'])){
		include("views/pageSessionExpired.php");
	} else {
		if(!isset($_SESSION['order']['delivery']['deliverypersonalid'])){$_SESSION['order']['delivery']['deliveryserviceid']=2;};
		if(!isset($_SESSION['order']['delivery']['type'])){$_SESSION['order']['delivery']['type']='d';};
		include($system_conf["theme_path"][1]."views/shopcartCheckout.php");
	}
	
?>
