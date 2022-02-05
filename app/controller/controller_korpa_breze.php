<?php

include_once("app/class/Product.php");
include_once("app/class/DeliveryService.php");
include_once("app/class/Shop.php");
$shopcart = array();
$shopcart_request = array();
$ShopData=Shop::getShopData();
$shopCartTotal=ShopHelper::getShopcartSmallData();
$DeliveryService=DeliveryService::getDeliveryService();

if(!isset($_SESSION['order']['delivery']['type'])) $_SESSION['order']['delivery']['type'] = 'd';
    
if(!isset($_SESSION['order']['delivery']['deliveryserviceid'])) $_SESSION['order']['delivery']['deliveryserviceid'] = '3';
    
if(isset($_SESSION['shopcart']) && !empty($_SESSION['shopcart'])){
        if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged'){
            $logged = true;
        }
}


if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
    /*PROMOCODE*/
    if(isset($_SESSION['promocode'])){
        if($_SESSION['promocode']['type']=='a'){
            foreach($_SESSION['shopcart']  AS $key => $cp) {   
                if(!isset($_SESSION['shopcart'][$key]['promocode'])){
                    $_SESSION['shopcart'][$key]['oldrebate'] = $_SESSION['shopcart'][$key]['rebate'];
                    if($_SESSION['shopcart'][$key]['rebate']>0){
                        if($_SESSION['promocode']['applyonproductwithrebate']=='y'){
                            $_SESSION['shopcart'][$key]['rebate']=floatval($_SESSION['shopcart'][$key]['oldrebate'])+((100-floatval($_SESSION['shopcart'][$key]['oldrebate']))*( floatval($_SESSION['promocode']['value'])/100));


                            // ((100-floatval($_SESSION['shopcart'][$key]['oldrebate']))*( floatval($_SESSION['promocode']['value'])/100))

                        } else {
                            $_SESSION['shopcart'][$key]['rebate']=$_SESSION['shopcart'][$key]['oldrebate'];
                        }
                    } else {
                       $_SESSION['shopcart'][$key]['rebate']=$_SESSION['promocode']['value'];
                    }
                    $_SESSION['shopcart'][$key]['promocode']=1;
                }
            }           
        }
        if($_SESSION['promocode']['type']=='c'){
            foreach($_SESSION['shopcart']  AS $key => $cp) {
                if(!isset($_SESSION['shopcart'][$key]['promocode'])){
                     $_SESSION['shopcart'][$key]['oldrebate'] = $_SESSION['shopcart'][$key]['rebate'];
                     $pcat=Product::getProductCategoryId($_SESSION['shopcart'][$key]['id']);
                     foreach($_SESSION['promocode']['category'] AS $pccat){
                        if($pcat==$pccat['categoryid']){
                            if($_SESSION['shopcart'][$key]['rebate']>0){
                                if($_SESSION['promocode']['applyonproductwithrebate']=='y'){
                                    $_SESSION['shopcart'][$key]['rebate']=floatval($_SESSION['shopcart'][$key]['oldrebate'])+((100-floatval($_SESSION['shopcart'][$key]['oldrebate']))*( floatval($pccat['value'])/100));
                                    //floatval($_SESSION['shopcart'][$key]['oldrebate'])+((100-floatval($_SESSION['shopcart'][$key]['oldrebate']))*( $pccat['value']/100));
                                } else {
                                    $_SESSION['shopcart'][$key]['rebate']=$_SESSION['shopcart'][$key]['oldrebate'];
                                }
                            } else {
                               $_SESSION['shopcart'][$key]['rebate']=$pccat['value'];
                            }

                        }
                     }
                     $_SESSION['shopcart'][$key]['promocode']=1;
                } 
            }
        }
        if($_SESSION['promocode']['type']=='p'){
            foreach($_SESSION['shopcart']  AS $key => $cp) { 
                if(!isset($_SESSION['shopcart'][$key]['promocode'])){
                     $_SESSION['shopcart'][$key]['oldrebate'] = $_SESSION['shopcart'][$key]['rebate'];
                     $pid=$_SESSION['shopcart'][$key]['id'];
                     foreach($_SESSION['promocode']['product'] AS $pcprod){
                        if($pid==$pcprod['productid']){
                            if($_SESSION['shopcart'][$key]['rebate']>0){
                                if($_SESSION['promocode']['applyonproductwithrebate']=='y'){
                                    $_SESSION['shopcart'][$key]['rebate']=floatval($_SESSION['shopcart'][$key]['oldrebate'])+((100-floatval($_SESSION['shopcart'][$key]['oldrebate']))*( floatval($pcprod['value'])/100));
                                    //floatval($_SESSION['shopcart'][$key]['oldrebate'])+((100-floatval($_SESSION['shopcart'][$key]['oldrebate']))*( floatval($pcprod['value'])/100));
                                } else {
                                    $_SESSION['shopcart'][$key]['rebate']=$_SESSION['shopcart'][$key]['oldrebate'];
                                }
                            } else {
                               $_SESSION['shopcart'][$key]['rebate']=$pcprod['value'];
                            }

                        }
                     }
                     $_SESSION['shopcart'][$key]['promocode']=1;
                }
            }   
        }
    }
    if(!isset($_SESSION['promocode']) && isset($shopcart[$key]['oldrebate'])){
        foreach($_SESSION['shopcart']  AS $key => $cp) { 
            $_SESSION['shopcart'][$key]['rebate']=$_SESSION['shopcart'][$key]['oldrebate'];
            unset($_SESSION['shopcart'][$key]['oldrebate']);
            unset($_SESSION['shopcart'][$key]['promocode']);
        }
    }
        /*PROMOCODE END*/



    $shopcart = $_SESSION['shopcart'];


}
if(isset($_SESSION['shopcart_request']) && is_array($_SESSION['shopcart_request'])){
    $shopcart_request = $_SESSION['shopcart_request'];
}
if(empty($shopcart) && empty($shopcart_request)){
    if( ( ($_SESSION['type']=='guest' || $_SESSION['type']=='user') && $system_conf["system_b2c"][1]=='1') || 
        (($_SESSION['type']=='partner') && $system_conf["system_b2b"][1]=='1') || 
        (($_SESSION['type']=='commerc') && $system_conf["system_commerc"][1]=='1') 
        ){
        include($system_conf["theme_path"][1]."views/shopcartempty.php");
    } else {
        include("app/controller/controller_register.php");
    }
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



        $shopcart[$key]['barcode'] = Product::getProductBarcodeById($cartprod['id']);
        $shopcart[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
        $shopcart[$key]['attrn'] = $attrs;
        $shopcart[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
        $shopcart[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);


        $shopcart_amount=Product::productQtyInCartCheckByProductId($cartprod['id']);
        $reserved_amount=Product::getProductReservedAmount($cartprod['id']);
        $amount=Product::getProductWarehouseAmount($cartprod['id']);
        $free_amount=$amount-$reserved_amount;
        if($free_amount<0){
            $free_amount=0;
        }
        $maxAllowedAmount=$amount-$reserved_amount;
        if($maxAllowedAmount<0){
            $maxAllowedAmount=0;
        }
        
        $shopcart[$key]['amount'] = $free_amount;

        $shopcart[$key]['free_amount'] = $free_amount;
        $shopcart[$key]['shopcart_amount'] = $shopcart_amount;
        if($free_amount==0 && $shopcart_amount>=0){
            $shopcart[$key]['qty']=0;
            $_SESSION['shopcart'][$key]['qty']=0;
            //echo '<script type="text/javascript">alertify.alert(Proizvod '.$shopcart[$key]['name'].' nije više dostupan!);</script>';
        }




        
        
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
        $shopcart_request[$key]['barcode'] = Product::getProductBarcodeById($cartprod['id']);
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
        //echo $system_conf["system_b2c"][1]; 
        if( ( ($_SESSION['type']=='guest' || $_SESSION['type']=='user') && $system_conf["system_b2c"][1]=='1') || 
        (($_SESSION['type']=='partner') && $system_conf["system_b2b"][1]=='1') || 
        (($_SESSION['type']=='commerc') && $system_conf["system_commerc"][1]=='1') 
        ){
          include($system_conf["theme_path"][1]."views/shopcartWithCheckout.php");
        } else {
            include("app/controller/controller_register.php");
        }
    
    }
    
}
