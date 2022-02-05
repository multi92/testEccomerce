<?php

include_once("app/class/Product.php");
//Kopirano sa new.logoshome.rs
include_once("app/class/DeliveryService.php");
include_once("app/class/Shop.php");
//end kompirano sa breze.rs

//Kopirano sa new.logoshome.rs
$shopcart = array();
$shopcart_request = array();

$ShopData=Shop::getShopData();
$DeliveryService=DeliveryService::getDeliveryService();

/*if(!isset($_SESSION['order']['deliverycosttotal'])) $_SESSION['order']['deliverycosttotal'] = 0;
//if(!isset($_SESSION['order']['vouchertotal'])) $_SESSION['order']['vouchertotal'] = 0;
if(!isset($_SESSION['order']['shopcarttotal'])) $_SESSION['order']['shopcarttotal'] = 0;
if(!isset($_SESSION['order']['delivery']['type'])) $_SESSION['order']['delivery']['type'] = 'd';

if(!isset($_SESSION['order']['delivery']['deliveryserviceid'])) $_SESSION['order']['delivery']['deliveryserviceid'] = '3';*/


if(!isset($_SESSION['order']['delivery']['deliverypersonalid'])){$_SESSION['order']['delivery']['deliveryserviceid']=3;}; //dodato
if(!isset($_SESSION['order']['delivery']['type'])){$_SESSION['order']['delivery']['type']='d';}; //dodato



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
	if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus']=='logged' && ($_SESSION['type']=='partner' || $_SESSION['type']=='commerc')){ 
		include($system_conf["theme_path"][1]."views/shopcartB2B.php");
	}
	else {
        //Ovo je bilo
        /*if($user_conf["shopcartB2Cshort"][1]==1){
            include($system_conf["theme_path"][1]."views/shopcartB2Cshort.php");
        } else {
            include($system_conf["theme_path"][1]."views/shopcart.php"); 
        }*/
        if( ( ($_SESSION['type']=='guest' || $_SESSION['type']=='user') && $system_conf["system_b2c"][1]=='1') || 
        (($_SESSION['type']=='partner') && $system_conf["system_b2b"][1]=='1') || 
        (($_SESSION['type']=='commerc') && $system_conf["system_commerc"][1]=='1') 
        ){
            if($user_conf["shopcartB2Cshort"][1]==1){
                include($system_conf["theme_path"][1]."views/shopcartWithCheckoutShort.php");
            } else {
                include($system_conf["theme_path"][1]."views/shopcartWithCheckout.php"); 
            }
        } else {
            include($system_conf["theme_path"][1]."views/shopcartWithCheckoutShort.php");
        }		
	}
    
}
