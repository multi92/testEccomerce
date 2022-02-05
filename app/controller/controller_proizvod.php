<?php

//include("app/class/ShopHelper.php");

include_once("app/class/Category.php");
include_once("app/class/Product.php");

//$data = Product::getDescriptiontest(3);
//$_SESSION['langid'] = 1;

if(isset($command[1]) && $command[1] != ""){
    $prodid = GlobalHelper::getProductIdFromCommand($command);
	GlobalHelper::increaseCountData('product',$prodid);
    GlobalHelper::increaseStatistics('product',$prodid);
    if(!GlobalHelper::isProductVisible($prodid)){
        //var_dump('error controler proizvod no visible');
         include("app/controller/core/controller_error404.php");
        
    } else {

        $product = new Product($prodid);
        
    $lastSeen = GlobalHelper::lastSeen();
//    var_dump($lastSeen);
    $lastSeen = Category::getCategoryProductDetail($lastSeen,1,16, '', '');
//    var_dump($lastSeen);

    GlobalHelper::lastSeen($prodid);


    $breadcrumbs = ShopHelper::getCategoryListFromProduct($prodid);
    
    /*  prepare extradetail for flter   */
    
    $eddata = Category::getExtradetail();
    
//    var_dump($breadcrumbs[1]);
//    var_dump($product);
    //var_dump($product->relations);
//var_dump($product->simularprod);

    include($system_conf["theme_path"][1]."views/product.php");

    }

    
}
else{
    //var_dump('error controler proizvod');

    include("app/controller/core/controller_error404.php");
    
}

//var_dump($product);


//var_dump($data->attrs[0]);

//echo "Proizvod";

?>