<?php

$class_version["orderinghelper"] = array('module', '1.0.0.0.1', 'Nema opisa');

/**
 * Created by PhpStorm.
 * User: SoftArt-Milos
 * Date: 2/8/2016
 * Time: 10:05
 */
class OrderingHelper
{

    /**
     * @param $cart
     * @param $prod
     * @return array(index pozicije u korpi, qty);
     */

    public static function IsInCartCheck($productid, $attr)
    {
        //echo 'p='.$productid.' atr'.$attr;
        $ret = false;
        if(isset($_SESSION['shopcart']) && $_SESSION['shopcart']!=''){
        foreach($_SESSION['shopcart'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid && $val['attr']==$attr){
                $ret=true;
                    return $ret;
            }
        }
        }

        return $ret;
    }

    public static function IsInCartRequestCheck($productid, $attr)
    {
        
        $ret = false;
        if(isset($_SESSION['shopcart_request']) && $_SESSION['shopcart_request']!=''){
        foreach($_SESSION['shopcart_request'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid && $val['attr']==$attr){
                $ret=true;
                    return $ret;
            }
        }
        }

        return $ret;
    }

    public static function QtyInCartCheck($productid, $attr)
    {
        
        $ret = 0;
        if(isset($_SESSION['shopcart']) && $_SESSION['shopcart']!=''){
        foreach($_SESSION['shopcart'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid && $val['attr']==$attr){
                $ret=true;
                    return $val['qty'];
            }
        }
        }

        return $ret;
    }

   

    public static function QtyInCartRequestCheck($productid, $attr)
    {
        
        $ret = 0;
        if(isset($_SESSION['shopcart_request']) && $_SESSION['shopcart_request']!=''){
        foreach($_SESSION['shopcart_request'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid && $val['attr']==$attr){
                $ret=true;
                    return $val['qty'];
            }
        }
        }

        return $ret;
    }


    public static function IsInCartCheckB2B($productid, $attr)
    {
        
        $ret = false;
		if(isset($_SESSION['shopcart']) && $_SESSION['shopcart']!=''){
		foreach($_SESSION['shopcart'] as $val){
			//echo $val['id'].'='.$productid.'   -----';
			//var_dump($val['attr']);var_dump($attr);
			if($val['id']==$productid && $val['attr']==$attr){
				$ret=true;
                    return $ret;
			}
		}
        }

        return $ret;

    }


    public static function ProductQtyInCartCheck($productid)
    {
        
        $ret = 0;
        if(isset($_SESSION['shopcart']) && $_SESSION['shopcart']!=''){
        foreach($_SESSION['shopcart'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid ){
                $ret=$ret+$val['qty'];
            }
        }
        }

        return $ret;
    }

    public static function ProductRequestQtyInCartCheck($productid)
    {
        
        $ret = 0;
        if(isset($_SESSION['shopcart_request']) && $_SESSION['shopcart_request']!=''){
        foreach($_SESSION['shopcart_request'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid ){
                $ret=$ret+$val['qty'];
            }
        }
        }

        return $ret;
    }


    public static function getB2BCartProductByProductData($productid, $attr)
    {
        
        $ret = array();
		if(isset($_SESSION['shopcart']) && $_SESSION['shopcart']!=''){
		foreach($_SESSION['shopcart'] as $val){
			if($val['id']==$productid && $val['attr']==$attr){
				array_push($ret,$val);
			}
		}
        }
        return $ret;
    }	
	 
    public static function IsInCartB2B($cart, $prod)
    {
        $itemscount = count($cart);
        $ret = array();

        for ($i = 0; $i < $itemscount; $i++) {
            if ($cart[$i]['id'] == $prod['id']) {
                if ($cart[$i]['attr'] == $prod['attr']) {
                    $ret['index'] = $i;
                    $ret['qty'] = $cart[$i]['qty'];
                    return $ret;
                } else {
                    $ret['index'] = '-1';//nadjena su dva ista poroizvoda ali im se lista atributa ne poklapa
                }
            }
        }

        return $ret;

    }
    public static function IsInCart($cart, $prod)
    {
        $itemscount = count($cart);
        $ret = array();

        for ($i = 0; $i < $itemscount; $i++) {
            if ($cart[$i]['id'] == $prod['id']) {
                if ($cart[$i]['attr'] == $prod['attr']) {
                    $ret['index'] = $i;
                    $ret['qty'] = $cart[$i]['qty'];
                    return $ret;
                } else {
                    $ret['index'] = '-1';//nadjena su dva ista poroizvoda ali im se lista atributa ne poklapa
                }
            }
        }

        return $ret;

    }
    public static function GetCartCount()
    {
		$count = 0;
        if(isset($_SESSION['shopcart']))
		{
			foreach ($_SESSION['shopcart'] as $item) {
				$count += $item['qty'];
			}
		}

        return $count;

    }
	public static function GetCartB2BCount()
    {
        $count = 0;
        if(isset($_SESSION['shopcart'])){
            $cart = $_SESSION['shopcart'];
            foreach ($cart as $item) {
                $count += $item['qty'];
            }
        }
        return $count;

    }
    public static function GetCartRequestCount()
    {
        $count = 0;
        if(isset($_SESSION['shopcart_request'])){
            $cart = $_SESSION['shopcart_request'];
        
            foreach ($cart as $item) {
                $count += $item['qty'];
            }
        }
        return $count;
    }
}