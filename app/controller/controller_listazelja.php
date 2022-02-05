<?php

$page = 1;
    if(isset($_GET['p']) && $_GET['p'] != ""){
        $page = $_GET['p']; 
    }

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
        $wishlistprods=array();
if(isset($_SESSION["wishlist"]) && count($_SESSION["wishlist"])>0){
    $wishlistprods = GlobalHelper::getWishlistProdInfo($page, $limit,'',$sortord, $sortby, false, $minprice, $maxprice);
    $pagination = GlobalHelper::paging($page, count($_SESSION["wishlist"]), $limit);
    //var_dump($wishlistprods);
}



include($system_conf["theme_path"][1]."views/wishlist.php");

?>