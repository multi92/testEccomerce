<?php

include_once("app/class/Product.php");
$shopcart = array();
$shopcart_request = array();
if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
    $shopcart = $_SESSION['shopcart'];
}
if(isset($_SESSION['shopcart_request']) && is_array($_SESSION['shopcart_request'])){
    $shopcart_request = $_SESSION['shopcart_request'];
}
if(empty($shopcart) && empty($shopcart_request)){
    include($system_conf["theme_path"][1]."views/shopcartempty.php");
}
else{
    //MP
    foreach ($shopcart as $key => $cartprod) {
        $shopcart[$key]['cartposition'] = $key;
        //$shopcart[$key]['attrdata'] = json_encode($cartprod['attr']);
        $attrs = array();
        if(isset($cartprod['attr']) && is_array(json_decode($cartprod['attr']))){
        $a = json_decode($cartprod['attr'], true);
        foreach ($a as $attr) {

			array_push($attrs,
                array(
                    'attrid' => $attr[0],
                    'attrname' => GlobalHelper::getAttrName($attr[0]),
                    'attrvalid' => $attr[1],
                    'attrvalname' => GlobalHelper::getAttrValName($attr[1])
                )
            );
        }
        }

        $newprice=array();
        $newprice=Product::getProductPrice($cartprod['id']);
        $shopcart[$key]['price']=strval($newprice['price']);
        $shopcart[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
        $shopcart[$key]['attrn'] = $attrs;
		$shopcart[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
		$shopcart[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
        $shopcart[$key]['amount'] = Product::getProductWarehouseAmount($cartprod['id']);
    }
	//VP
    foreach ($shopcart_request as $key => $cartprod) {
        $shopcart_request[$key]['cartposition'] = $key;
        //$shopcart[$key]['attrdata'] = json_encode($cartprod['attr']);
        $attrs = array();
        if(isset($cartprod['attr']) && is_array(json_decode($cartprod['attr'], true)) && count(json_decode($cartprod['attr'], true))>0){
        $a = json_decode($cartprod['attr'], true);
        foreach ($a as $attr) {

			array_push($attrs,
                array(
                    'attrid' => $attr[0],
                    'attrname' => GlobalHelper::getAttrName($attr[0]),
                    'attrvalid' => $attr[1],
                    'attrvalname' => GlobalHelper::getAttrValName($attr[1])
                )
            );
        }
        }

        $shopcart_request[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
        $shopcart_request[$key]['attrn'] = $attrs;
		$shopcart_request[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
		$shopcart_request[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
    }
    
//    foreach ($shopcart[0]['link'][0]['url'] as $catname) {
//
//    }
    $deliveryPersonalInfoData=array();
    $deliveryServiceInfoData=array();
    
    if(isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['type']) && $_SESSION['order']['delivery']['type']!='h'){
        if($_SESSION['order']['delivery']['type']=='p' && isset($_SESSION['order']['delivery']['deliverypersonalid']) && $_SESSION['order']['delivery']['deliverypersonalid']>0 ){
            include_once("app/class/Shop.php");
            $deliveryPersonalInfoData = Shop::getShopDataByShopId($_SESSION['order']['delivery']['deliverypersonalid']);

        }
        if($_SESSION['order']['delivery']['type']=='d' && isset($_SESSION['order']['delivery']['deliveryserviceid']) && $_SESSION['order']['delivery']['deliveryserviceid']>0 ){
            include_once("app/class/DeliveryService.php");
            $deliveryServiceInfoData = DeliveryService::getDeliveryServiceAssocById( $_SESSION['order']['delivery']['deliveryserviceid']);
        }
    }

	if(!isset($_SESSION['shopcart']) && !isset($_SESSION['shopcart_request'])){
        include("views/pageSessionExpired.php");
    } else {
        if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus']=='logged' && ($_SESSION['type']=='partner' || $_SESSION['type']=='commerc') ){ 
            include($system_conf["theme_path"][1]."views/shopcartCheckoutConfirmationB2B.php");
        }
        else {
            if($user_conf["shopcartB2Cshort"][1]==1){
                include($system_conf["theme_path"][1]."views/shopcartCheckoutConfirmationB2Cshort.php");
            } else {
                include($system_conf["theme_path"][1]."views/shopcartCheckoutConfirmation.php"); 
            }
        }
        
    }
    
}
