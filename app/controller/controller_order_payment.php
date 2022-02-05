<?php

if(isset($_SESSION['ordering_address'])){
    $ord_adr = $_SESSION['ordering_address'];
    $ukupan_iznos = 0;
    foreach ($_SESSION['shopcart'] as $article) {
        $ukupan_iznos += $article['price'] * $article['qty'] * (1+$article['tax']/100) * (1-$article['rebate']/100);
    }

    include($system_conf["theme_path"][1]."views/order_payment.php");
}
else{
    header( "Location: order_address" );
}

