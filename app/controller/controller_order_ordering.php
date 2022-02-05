<?php

if(isset($_SESSION['type']) && $_SESSION['type'] == 'partner'){
	if(!isset($_SESSION['ordering_address'])) $_SESSION['ordering_address'] = array();
	$_SESSION['ordering_address']['ime'] = '';
	$_SESSION['ordering_address']['prezime'] = '';
	$_SESSION['ordering_address']['adresa'] = '';
	$_SESSION['ordering_address']['telefon'] = '';
	$_SESSION['ordering_address']['mesto'] = '';
	$_SESSION['ordering_address']['postbr'] = '';
	$_SESSION['ordering_address']['email'] = '';
	$_SESSION['ordering_address']['payment'] = '';
}

if(isset($_SESSION['ordering_address'])){
    $ord_adr = $_SESSION['ordering_address'];

        $shopcart = array();
        if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
            $shopcart = $_SESSION['shopcart'];
            foreach ($shopcart as $key => $cartprod) {
                $shopcart[$key]['cartposition'] = $key;
                $attrs = array();
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


                $shopcart[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
				$shopcart[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
				$shopcart[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $shopcart[$key]['attrn'] = $attrs;

            }
        }
        if(empty($shopcart)){
            include($system_conf["theme_path"][1]."views/shopcartempty.php");
        }
        else{
            include($system_conf["theme_path"][1]."views/order_ordering.php");
        }

}
else{
    header( "Location: order_address" );
}




