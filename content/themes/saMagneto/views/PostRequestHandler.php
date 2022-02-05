<?php

$class_version["postrequesthandler"] = array('module', '1.0.0.0.1', 'Nema opisa');

class PostRequestHandler
{
    public $requestKey;
    public $requestVal;

    public function __construct(){

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->requestKey=array_keys($_POST);
            $this->requestVal=$_POST;
            self::RequestHandler();
        }

    }

    private function RequestHandler()
    {
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "sendrecommendedprice"){
            $data = GlobalHelper::sendRecommendedPrice($_POST['price'], $_POST['email']);
            echo json_encode($data);
        }   
        
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "acceptcookies"){
                $_SESSION['acceptcookies']="off";
                echo '1';
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "splashscreenvalidation"){
            if($_POST['validationcode']=='SaPass2020'){
                $_SESSION['splashscreen']="off";
            }


        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "checkotherattrval"){
			echo json_encode(GlobalHelper::checkotherattrval($_POST['prodid'], $_POST['attrvalid']));
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "search"){
			global $theme_conf,$language ;
			include_once("app/class/Search.php");
			include_once("app/class/Category.php");
			$brend = '';
			$categoryid = 0;
			$attrvalid = 0;
			
			if($_POST['brend'] == '') $_POST['brend'] = array();
			if($_POST['category'] == '') $_POST['category'] = array();
			if($_POST['attrval'] == '') $_POST['attrval'] = array();
			
			$proids = Search::productSearch($_POST['q'],  $page = 1, $itemsperpage = 30, $_POST['brend'], $_POST['category'],$_POST['attrval']);
			
			$prodata = Category::getCategoryProductDetail(array_slice($proids,0,20), 1, 18,'','ASC','code',false,'','',1);
			$prodata['strings'] = array();
			
			$prodata['strings']['actionimage'] = $theme_conf["action"][$_SESSION["langid"]][1];
			$prodata['strings']['code'] = $language["productBoxSearchModal"][1];
            
			echo json_encode($prodata);
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "secondpartcode"){
			echo json_encode(GlobalHelper::getsecondpartcode($_POST['prodid'], $_POST['attrvalids']));
        }
		
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "userlogdatauinsertpdate"){
			if(isset($_SESSION['id'])){
				User::updateUserLogData($_SESSION['id']);
				echo '1';
			} 
			//ShopHelper::update_shopcart_comment();
		}
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "updateshopcartcomment"){
			ShopHelper::update_shopcart_comment();
		}
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setorderinfodata"){
            if(!isset($_SESSION['order'])){
                $_SESSION['order']=array();
            }
            if(!isset( $_SESSION['order']['customer'])){
                 $_SESSION['order']['customer']=array();
            }
            $_SESSION['order']['customer']['name'] = $_POST['customername'];
            $_SESSION['order']['customer']['lastname'] = $_POST['customerlastname'];
            $_SESSION['order']['customer']['email'] = $_POST['customeremail'];
            $_SESSION['order']['customer']['phone'] = $_POST['customerphone'];
            $_SESSION['order']['customer']['address'] = $_POST['customeraddress'];
            $_SESSION['order']['customer']['city'] = $_POST['customercity'];
            $_SESSION['order']['customer']['zip'] = $_POST['customerzipcode'];
            //$_SESSION['order']['customer']['paymentmetod'] = $_POST['customerpaymentmethod'];
            $_SESSION['order']['paymenttype'] = $_POST['customerpaymenttype'];
            if(!isset( $_SESSION['order']['recipient'])){
                 $_SESSION['order']['recipient']=array();
            }
            $_SESSION['order']['recipient']['name'] = $_POST['recipientname'];
            $_SESSION['order']['recipient']['lastname'] = $_POST['recipientlastname'];
            $_SESSION['order']['recipient']['phone'] = $_POST['recipientphone'];
            $_SESSION['order']['recipient']['address'] = $_POST['recipientaddress'];
            $_SESSION['order']['recipient']['city'] = $_POST['recipientcity'];
            $_SESSION['order']['recipient']['zip'] = $_POST['recipientzipcode'];
            if(!isset( $_SESSION['order']['delivery'])){
                 $_SESSION['order']['delivery']=array();
            }
            $_SESSION['order']['delivery']['type'] = $_POST['deliverytype'];   
            $_SESSION['order']['delivery']['deliverypersonalid'] = $_POST['deliverypersonalid']; 
            $_SESSION['order']['delivery']['deliveryserviceid'] = $_POST['deliveryserviceid']; 
			
			if(isset($_SESSION['shoptype']) && $_SESSION['shoptype'] == 'b2c')
			{
				if(isset($_SESSION['shopcart_request']) && count($_SESSION['shopcart_request']) > 0)
				{
					$b2c_request_data = Shop::createReservationRequestFromSessionB2C();
					if($b2c_request_data['status'] == 'success'){
						//echo json_encode($b2c_request_data);
						$_SESSION['success_notifications'][] = 'Vaš upit je uspešno prosleđen.';
						//echo json_encode(array('status'=>'success', "message"=>''));
					}else{
						$_SESSION['error_notifications'][] = 'Greška prilikom prosleđivanja upita.';	
					}
				}
			}else if(isset($_SESSION['shoptype']) && $_SESSION['shoptype'] == 'b2b' ){
				if(isset($_SESSION['shopcart_request']) && count($_SESSION['shopcart_request']) > 0)
				{
					if(Shop::createReservationRequestFromSessionB2B()){
						$_SESSION['success_notifications'][] = 'Vaš upit je uspešno prosleđen.';
					}
				}
			}
			   
			
            echo 'orderinfodataset';
			
			
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "getReportModalParmData"){
			    include_once("app/class/Report.php");
				echo json_encode(Report::getReportWithParametars($_POST['id']));
		}
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "getdocumentitems"){
			$a = User::getDocumentItems($_POST['docid']);
			echo json_encode($a);
        }
		
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "getpovratnice"){
			User::getUserpanelData();
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "isloged"){
           if(isset($_SESSION['loginstatus']) && ($_SESSION['loginstatus']!='')){
			   echo '1';
		   }
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "changelang"){
            include_once("app/class/core/GlobalHelper.php");
            setcookie("lang", $_POST['langid']);
            setcookie("langcode", GlobalHelper::getLangCode($_POST['langid']));
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "changecurrency"){
            include_once("app/class/core/GlobalHelper.php");
            include_once("app/class/Product.php");
            setcookie("currencyid", $_POST['currencyid']);
            setcookie("currencycode", GlobalHelper::getCurrencyCode($_POST['currencyid']));
            setcookie("currencyvalue", GlobalHelper::getCurrencyValue($_POST['currencyid']));
            /*if(isset($_SESSION['shopcart'])){
                foreach($_SESSION['shopcart'] as $key =>  $cartitem){
                    $newprice=array();
                    $newprice=Product::getProductPrice($cartitem['id']);
                    if(isset($newprice['price'])){
                       $_SESSION['shopcart'][$key]['price']=strval($newprice['price']); 
                    }
                    echo($newprice['price']);
                    
                }
            }*/
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addnewsletter"){
            echo GlobalHelper::add_newsletter($this->requestVal['email']);
			
        }
        //ADD TO CART
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addtocart"){
		   include_once("app/class/Product.php");
		   $productdata=Product::get_price_tax_rebate($this->requestVal['id']);

           $unitstep=$this->requestVal['unitstep'];
           if($this->requestVal['unitstep']=='' || $this->requestVal['unitstep']==0 || is_null($this->requestVal['unitstep'])){
                $unitstep=1;
           }
		
		   $prod=array('id' => $this->requestVal['id'],
                'name' => $this->requestVal['name'],
                'price' => $productdata["price"],
				'rebate' =>  $productdata["rebate"],
				//'qtyrebate' =>  $this->requestVal['qtyrebate'],
				'tax' => $productdata["tax"],
                'pic' => $this->requestVal['pic'],
                'qty' => $this->requestVal['qty'],
                'attr' => $this->requestVal['attr'],
                'unitname' => $this->requestVal['unitname'],
                'unitstep' => $unitstep
            );

            $current_product_quantity=0;
            $current_product_quantity=$this->requestVal['qty'];

            if(isset($_SESSION['shopcart'])){
                $ret=OrderingHelper::IsInCart($_SESSION['shopcart'],$prod);
                //var_dump($ret);

                if(!empty($ret) && $ret['index']!='-1')
                {
//                    Session::SetMatVal('shopcart',$ret['index'],'qty',$ret['qty']+$prod['qty']);
                    //var_dump('ret is not empty and not -1');
                    $_SESSION['shopcart'][$ret['index']]['qty'] = $ret['qty']+$prod['qty'];
                    $current_product_quantity = $ret['qty']+$prod['qty'];

                }else{
//                    Session::SetArrValNext('shopcart',$prod);
                    $_SESSION['shopcart'][] = $prod;
                    $current_product_quantity = $prod['qty'];
                }
                if(isset($_SESSION['logged']) ){
                    GlobalHelper::partnerLogShopcartData($prod['id'], $prod['qty'], $prod['name'], $prod['price'], $prod['rebate']);
                }
				
            }
            else
            {
//                Session::SetArrValNext('shopcart',$prod);
                $_SESSION['shopcart'][] = $prod;
                $current_product_quantity = $prod['qty'];
                if(isset($_SESSION['logged']) ){
				    GlobalHelper::partnerLogShopcartData($prod['id'], $prod['qty'], $prod['name'], $prod['price'], $prod['rebate']);
                }
            }

            $current_shopcart_item_count=OrderingHelper::GetCartCount()+OrderingHelper::GetCartRequestCount();
            $_SESSION['cart_item_counter'] = $current_shopcart_item_count;
            $final=array();
            array_push($final, array('shopcartitemcount'=>$current_shopcart_item_count, 'lastaddedproductqty'=>$current_product_quantity." ".$this->requestVal['unitname'] ));
            echo json_encode($final);
        }
        //ADD TO CART END
        //ADD TO CART REQUEST
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addtocartrequest"){
           include_once("app/class/Product.php");
           $productdata=Product::get_price_tax_rebate($this->requestVal['id']);

           $unitstep=$this->requestVal['unitstep'];
           if($this->requestVal['unitstep']=='' || $this->requestVal['unitstep']==0 || is_null($this->requestVal['unitstep'])){
                $unitstep=1;
           }

          
            
           $prod=array('id' => $this->requestVal['id'],
                'name' => $this->requestVal['name'],
                'price' => $productdata["price"],
                'rebate' =>  $productdata["rebate"],
                //'qtyrebate' =>  $this->requestVal['qtyrebate'],
                'tax' => $productdata["tax"],
                'pic' => $this->requestVal['pic'],
                'qty' => $this->requestVal['qty'],
                'attr' => $this->requestVal['attr'],
                'unitname' => $this->requestVal['unitname'],
                'unitstep' => $unitstep
            );

            $current_product_quantity=0;
            $current_product_quantity=$this->requestVal['qty'];

            if(isset($_SESSION['shopcart_request'])){
                $ret=OrderingHelper::IsInCart($_SESSION['shopcart_request'],$prod);
                //var_dump($ret);

                if(!empty($ret) && $ret['index']!='-1')
                {
                    $_SESSION['shopcart_request'][$ret['index']]['qty'] = $ret['qty']+$prod['qty'];
                    $current_product_quantity = $ret['qty']+$prod['qty'];
                }else{
                    $_SESSION['shopcart_request'][] = $prod;
                    $current_product_quantity = $prod['qty'];
                }
                //GlobalHelper::partnerLogShopcartData($prod['id'], $prod['qty'], $prod['name'], $prod['price'], $prod['rebate']);
            }
            else
            {
                $_SESSION['shopcart_request'][] = $prod;
                $current_product_quantity = $prod['qty'];
                //GlobalHelper::partnerLogShopcartData($prod['id'], $prod['qty'], $prod['name'], $prod['price'], $prod['rebate']);
            }
           
            $current_shopcart_item_count=OrderingHelper::GetCartCount()+OrderingHelper::GetCartRequestCount();
            $_SESSION['cart_item_counter'] = $current_shopcart_item_count;
            $final=array();
            array_push($final, array('shopcartitemcount'=>$current_shopcart_item_count, 'lastaddedproductqty'=>$current_product_quantity." ".$this->requestVal['unitname'] ));
            echo json_encode($final);
        }
        //ADD TO CART REQUEST END
        //ADD TO CART B2B 
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addtocartB2B"){
           include_once("app/class/Product.php");
           $productdata=Product::get_price_tax_rebate($this->requestVal['id']);

           $unitstep=$this->requestVal['unitstep'];
           if($this->requestVal['unitstep']=='' || $this->requestVal['unitstep']==0 || is_null($this->requestVal['unitstep'])){
                $unitstep=1;
           }
           
     

           $prod=array('id' => $this->requestVal['id'],
                'name' => $this->requestVal['name'],
                'price' =>  $productdata["price"],
                'rebate' =>  $this->requestVal['rebate'],
                'tax' =>  $this->requestVal['tax'],
                'pic' => $this->requestVal['pic'],
                'qty' => $this->requestVal['qty'],
                'attr' => $this->requestVal['attr'],
                'unitname' => $this->requestVal['unitname'],
                'unitstep' => $unitstep
            );
            $current_product_quantity=0;
            $current_product_quantity=$this->requestVal['qty'];
            if(isset($_SESSION['shopcart'])){
                $ret=OrderingHelper::IsInCart($_SESSION['shopcart'],$prod);
                
                if(!empty($ret) && $ret['index']!='-1')
                {
                    $_SESSION['shopcart'][$ret['index']]['qty'] = $ret['qty']+$prod['qty'];
                    $current_product_quantity = $ret['qty']+$prod['qty'];
                }else{
                    $_SESSION['shopcart'][] = $prod;
                    $current_product_quantity = $prod['qty'];
                }
                $counterB2B=OrderingHelper::GetCartB2BCount();
                $_SESSION['cart_item_counterB2B'] = $counterB2B;
                GlobalHelper::partnerLogShopcartData($prod['id'], $prod['qty'], $prod['name'], $prod['price'], $prod['rebate']);
                //echo $counterB2B;
            }
            else
            {
//                Session::SetArrValNext('shopcart',$prod);
                $_SESSION['shopcart'][] = $prod;
                $current_product_quantity = $prod['qty'];
                GlobalHelper::partnerLogShopcartData($prod['id'], $prod['qty'], $prod['name'], $prod['price'], $prod['rebate']);
            }

            //$counter=OrderingHelper::GetCartCount();
            //$counterB2B=OrderingHelper::GetCartB2BCount();
            
            //$_SESSION['cart_item_counter'] = $counter;
            //echo json_encode($current_product_quantity." ".$this->requestVal['unitname']);

            $current_shopcart_item_count=OrderingHelper::GetCartCount()+OrderingHelper::GetCartRequestCount();
            $_SESSION['cart_item_counter'] = $current_shopcart_item_count;
            $final=array();
            array_push($final, array('shopcartitemcount'=>$current_shopcart_item_count, 'lastaddedproductqty'=>$current_product_quantity." ".$this->requestVal['unitname'] ));
            echo json_encode($final);

        }
        //ADD TO CART B2B END
        //ADD TO CART REQUEST B2B
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addtocartrequestb2b"){
           include_once("app/class/Product.php");
           $productdata=Product::get_price_tax_rebate($this->requestVal['id']);
           
           $unitstep=$this->requestVal['unitstep'];
           if($this->requestVal['unitstep']=='' || $this->requestVal['unitstep']==0 || is_null($this->requestVal['unitstep'])){
                $unitstep=1;
           }
           
           /*$prodprice=array();
           $prodprice=Product::getProductPrice($this->requestVal['id']);
           //$prprice = $productdata["price"];
           $prprice = 0;
           
           if(isset($prodprice['price'])){
              $prprice=strval($newprice['price']); 
           }*/

           $prod=array('id' => $this->requestVal['id'],
                'name' => $this->requestVal['name'],
                'price' =>  $productdata["price"],
                'rebate' =>  $this->requestVal['rebate'],
                'tax' =>  $this->requestVal['tax'],
                'pic' => $this->requestVal['pic'],
                'qty' => $this->requestVal['qty'],
                'attr' => $this->requestVal['attr'],
                'unitname' => $this->requestVal['unitname'],
                'unitstep' => $unitstep
            );

            $current_product_quantity=0;
            $current_product_quantity=$this->requestVal['qty'];
            if(isset($_SESSION['shopcart_request'])){
                $ret=OrderingHelper::IsInCart($_SESSION['shopcart_request'],$prod);
                //var_dump($ret);
                
                if(!empty($ret) && $ret['index']!='-1')
                {
//                    Session::SetMatVal('shopcart',$ret['index'],'qty',$ret['qty']+$prod['qty']);
                    //var_dump('ret is not empty and not -1');
                    $_SESSION['shopcart_request'][$ret['index']]['qty'] = $ret['qty']+$prod['qty'];
                    $current_product_quantity = $ret['qty']+$prod['qty'];

                }else{
//                    Session::SetArrValNext('shopcart',$prod);
                    $_SESSION['shopcart_request'][] = $prod;
                    $current_product_quantity = $prod['qty'];
                }
            }
            else
            {
                $_SESSION['shopcart_request'][] = $prod;
                $current_product_quantity = $prod['qty'];
            }
            
            
            //$counter=OrderingHelper::GetCartRequestCount();
            //$counterB2B=OrderingHelper::GetCartB2BCount();
            
            //$_SESSION['cart_item_counter_request'] = $counter;

            //echo json_encode($current_product_quantity." ".$this->requestVal['unitname']);
            /*$_SESSION['cart_item_counterB2B'] = $counterB2B;
            echo $counterB2B;*/
            $current_shopcart_item_count=OrderingHelper::GetCartCount()+OrderingHelper::GetCartRequestCount();
            $_SESSION['cart_item_counter'] = $current_shopcart_item_count;
            $final=array();
            array_push($final, array('shopcartitemcount'=>$current_shopcart_item_count, 'lastaddedproductqty'=>$current_product_quantity." ".$this->requestVal['unitname'] ));
            echo json_encode($final);
        }
        //ADD TO CART REQUEST B2B END
		
        if(isset($this->requestVal['contactsubmit']) && $this->requestVal['contactsubmit'] == "POSALJI"){
            global $user_conf;
            $mdata = array();
            $mdata['name'] = $_POST['name'];
            $mdata['mail'] = $_POST['mail'];
            $mdata['message'] = $_POST['message'];
            GlobalHelper::sendEmail($user_conf['contact_address'][1], $user_conf["autoemail"][1], 'kontakt mail sa sajta', $mdata, 'contact');
            header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . '/' . BASE_SUBPATH . '/contact');
        }
		
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "prodhaveattrs"){
            $prodid = $this->requestVal['id'];
//            $haveattr = ProdHelper::HaveAttr($prodid);//napraviti u prod helper
            $haveattr = false;
            if($haveattr){
                echo 1;
            }
            else{
                echo 0;
            }
        }

        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "emptycart"){
            unset($_SESSION['shopcart']);
			unset($_SESSION['shopcartB2B']);
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "changeProdQtyInCart"){
            if (isset($_SESSION['shopcart'][$this->requestVal['cartposition']])) {
                $_SESSION['shopcart'][$this->requestVal['cartposition']]['qty'] = $this->requestVal['qty'];
                echo 1;
            }
            else{
                echo -1;
            }
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "changeProdQtyInCartB2B"){
            if (isset($_SESSION['shopcartB2B'][$this->requestVal['cartposition']])) {
                $_SESSION['shopcartB2B'][$this->requestVal['cartposition']]['qty'] = $this->requestVal['qty'];
                echo 1;
            }
            else{
                echo -1;
            }
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeProdInCart"){
			//var_dump($this->requestVal['cartposition']);
            if (isset($_SESSION['shopcart'][$this->requestVal['cartposition']]))
			{
				if(GlobalHelper::partnerDeleteShopcartData($this->requestVal['cartposition']) == 1)
				{
                	unset($_SESSION['shopcart'][$this->requestVal['cartposition']]);
                	echo 1;
				}else{
					echo 0;	
				}
            }
            else{
                echo 0;
            }
			
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeProdInCartRequest"){
            if (isset($_SESSION['shopcart_request'][$this->requestVal['cartposition']])) {
                unset($_SESSION['shopcart_request'][$this->requestVal['cartposition']]);
                echo 1;
            }
            else{
                echo -1;
            }
            
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeProdInCartB2B"){
            if (isset($_SESSION['shopcartB2B'][$this->requestVal['cartposition']])) {
                unset($_SESSION['shopcartB2B'][$this->requestVal['cartposition']]);
                echo 1;
            }
            else{
                echo -1;
            }
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addProdToWatched"){
            if(GlobalHelper::addToWatched($this->requestVal['prodid'])){
                echo 1;
            }
            else{
                echo 0;
            }
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "createReservation"){
			
			
            if(Shop::createReservationFromSession()){
                echo 1;
            }
            else{
                echo 0;
            }
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "get_all_shops"){


            $shops = Shop::getList();
            $shops = $shops[1];
            echo json_encode($shops);

        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "get_all_shops_from_city"){

            $shops = Shop::getList(1, 0, $_POST['cityid']);
            $shops = $shops[1];
            echo json_encode($shops);

        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "get_shop"){

            $shops = new ShopExtra($_POST['shopid']);
            echo json_encode($shops);
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addToCompare"){

            $res = GlobalHelper::addToCompare($_POST['prodid']);
			if($res) echo 1;
			else echo 0;
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeFromCompare"){

            $res = GlobalHelper::removeFromCompare($_POST['prodid']);
			if($res) echo 1;
			else echo 0;
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "clearCompareProducts"){

            $res = GlobalHelper::clearCompareProducts();
            if($res) echo 1;
            else echo 0;
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "addToWishList"){

            $res = GlobalHelper::addToWishList($_POST['prodid']);
            
            if($res){
                GlobalHelper::save_user_wishlist();
                echo 1;
            }
            else {
                echo 0;
            }
        }
        
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeFromWishList"){

            $res = GlobalHelper::removeFromWishList($_POST['prodid']);
            
            if($res){
                GlobalHelper::save_user_wishlist();
                echo 1;
            }
            else {
                echo 0;
            }
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "clearWishListProducts"){

            $res = GlobalHelper::clearWishListProducts();
            if($res) echo 1;
            else echo 0;
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setarticleqtyinshopcart"){
            $_SESSION['shopcart'][$_POST['cart_position']]['qty'] = $_POST['qty'];
			
			GlobalHelper::partnerUpdateShopcartData($_POST['cart_position']);
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setarticleqtyinshopcartrequest"){
            $_SESSION['shopcart_request'][$_POST['cart_position']]['qty'] = $_POST['qty'];
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setarticleqtyinshopcartB2B"){
            $_SESSION['shopcartB2B'][$_POST['cart_position']]['qty'] = $_POST['qty'];
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeArticlefromshopcart"){
            unset($_SESSION['shopcart'][$_POST['cart_position']]);
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removeArticlefromshopcartB2B"){
            unset($_SESSION['shopcartB2B'][$_POST['cart_position']]);
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setorderingaddress"){
            if(!isset($_SESSION['ordering_address'])) $_SESSION['ordering_address'] = array();
            $_SESSION['ordering_address']['ime'] = $_POST['ime'];
            $_SESSION['ordering_address']['prezime'] = $_POST['prezime'];
            $_SESSION['ordering_address']['adresa'] = $_POST['adresa'];
            $_SESSION['ordering_address']['telefon'] = $_POST['telefon'];
            $_SESSION['ordering_address']['mesto'] = $_POST['mesto'];
            $_SESSION['ordering_address']['postbr'] = $_POST['postbr'];
            $_SESSION['ordering_address']['email'] = $_POST['email'];
            echo 1;
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setorderingaddressdelivery"){
            if(!isset($_SESSION['ordering_address_delivery'])) $_SESSION['ordering_address_delivery'] = array();
            $_SESSION['ordering_address_delivery']['ime'] = $_POST['ime'];
            $_SESSION['ordering_address_delivery']['prezime'] = $_POST['prezime'];
            $_SESSION['ordering_address_delivery']['adresa'] = $_POST['adresa'];
            $_SESSION['ordering_address_delivery']['telefon'] = $_POST['telefon'];
            $_SESSION['ordering_address_delivery']['mesto'] = $_POST['mesto'];
            $_SESSION['ordering_address_delivery']['postbr'] = $_POST['postbr'];
            $_SESSION['ordering_address_delivery']['email'] = $_POST['email'];
            echo 1;
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "deleteorderingaddress"){
            if(isset($_SESSION['ordering_address'])){
                unset ($_SESSION['ordering_address']);
                echo 1;
            }
            else{
                echo 0;
            }

        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setorderpayment"){
            if(isset($_SESSION['ordering_address'])){
                $_SESSION['ordering_address']['payment'] = $_POST['payment'];
				
                echo 1;
            }
            else{
                echo 0;
            }

        }
		
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setorderdelivery"){
			if(!isset($_SESSION['ordering_address'])) $_SESSION['ordering_address'] = array();
            if(isset($_SESSION['ordering_address'])){
                $_SESSION['ordering_address']['delivery'] = $_POST['delivery'];
				$_SESSION['ordering_address']['deliveryid'] = $_POST['deliveryid'];
                echo 1;
            }
            else{
                echo 0;
            }

        }

        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "userlogin"){
            echo User::login($_POST['username'], $_POST['pass']);
			GlobalHelper::partnerLoadShopcartData();
            GlobalHelper::load_user_wishlist();
            
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "userlogout"){
            GlobalHelper::save_user_wishlist();
            User::logout();

        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "create_reservation"){
            
            /*IMPORTANT RESET TO DEFAULT CURRENCY*/
            global $user_conf, $language;
            include_once("app/class/core/GlobalHelper.php");
            GlobalHelper::resetCurrency();

            $language["moneta"][1] = $_SESSION["currencycode"];

            $system_minimal_order_limit=$user_conf["minimal_order_limit"][1];
            $user_conf["minimal_order_limit"][1]=strval(Round(floatval($system_minimal_order_limit/floatval($_SESSION["currencyvalue"])),2));
            
            $system_free_delivery_from=$user_conf["free_delivery_from"][1];
            $user_conf["free_delivery_from"][1]=strval(Round(floatval($system_free_delivery_from/floatval($_SESSION["currencyvalue"])),2));
            
            $system_delivery_cost=$user_conf["delivery_cost"][1];
            $user_conf["delivery_cost"][1] = strval(Round(floatval($system_delivery_cost/floatval($_SESSION["currencyvalue"])),2));

            /*IMPORTANT RESET TO DEFAULT CURRENCY END*/



			/*	Google recaptcha check	*/
			include_once("plugins/recaptchalib.php");
			$secret = "6LfNp6gUAAAAADVUKAsf9dbQzh7zmvTiRd9ulwbe";
			$response = null;
			$reCaptcha = new ReCaptcha($secret);
			$continue = false;
			if($_POST["grr"] && $_POST["grr"] == 'p'){
				$continue = true;	
			}else{
				$response = $reCaptcha->verifyResponse( $_SERVER["REMOTE_ADDR"], $_POST["grr"]);
				if(isset($response) && $response->success)
				{
					$continue = true;
				}
			}
			if($continue)
			{
				$b2c_data = Shop::createReservationFromSessionB2C();
				if($b2c_data['status'] == 'success'){
					echo json_encode($b2c_data);
					$_SESSION['success_notifications'][] = 'Vaša porudžbina je uspešno prosleđena.';
					//echo json_encode(array('status'=>'success', "message"=>''));
				}
			    if((!isset($_SESSION['shopcart']) || count($_SESSION['shopcart'])==0)){
					if(isset($_SESSION['order']["comment"])){
						unset($_SESSION['order']["comment"]);
					}
					if(isset($_SESSION['order']["paymenttype"])){
						unset($_SESSION['order']["paymenttype"]);
					}
					if(isset($_SESSION['order']["recipient"])){
						unset($_SESSION['order']["recipient"]);
					}
					if(isset($_SESSION['order']["delivery"])){
						unset($_SESSION['order']["delivery"]);
					}
					if(isset($_SESSION['voucher'])){
						unset($_SESSION['voucher']);
					}
				}
			}else{
				echo json_encode(array('status'=>'fail', 'message'=>"Nevalidna rechapacha!"));	
			}
            
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "create_reservationB2B"){
            /*IMPORTANT RESET TO DEFAULT CURRENCY*/
            global $user_conf, $language;
            include_once("app/class/core/GlobalHelper.php");
            GlobalHelper::resetCurrency();

            $language["moneta"][1] = $_SESSION["currencycode"];

            $system_minimal_order_limit=$user_conf["minimal_order_limit"][1];
            $user_conf["minimal_order_limit"][1]=strval(Round(floatval($system_minimal_order_limit/floatval($_SESSION["currencyvalue"])),2));
            
            $system_free_delivery_from=$user_conf["free_delivery_from"][1];
            $user_conf["free_delivery_from"][1]=strval(Round(floatval($system_free_delivery_from/floatval($_SESSION["currencyvalue"])),2));
            
            $system_delivery_cost=$user_conf["delivery_cost"][1];
            $user_conf["delivery_cost"][1] = strval(Round(floatval($system_delivery_cost/floatval($_SESSION["currencyvalue"])),2));

            /*IMPORTANT RESET TO DEFAULT CURRENCY END*/

            $b2b_data = Shop::createReservationFromSessionB2B();
			if($b2b_data['status'] == 'success'){
				echo json_encode($b2b_data);
				$_SESSION['success_notifications'][] = 'Vaša porudžbina je uspešno prosleđena.';
				//echo json_encode(array('status'=>'success', "message"=>''));
			}
			
            if((!isset($_SESSION['shopcart']) || count($_SESSION['shopcart'])==0) && (!isset($_SESSION['shopcart_request']) || count($_SESSION['shopcart_request'])==0)){
                
                if(isset($_SESSION['order']["comment"])){
                    unset($_SESSION['order']["comment"]);
                }
                if(isset($_SESSION['order']["paymenttype"])){
                    unset($_SESSION['order']["paymenttype"]);
                }
                if(isset($_SESSION['order']["recipient"])){
                    unset($_SESSION['order']["recipient"]);
                }
                if(isset($_SESSION['order']["delivery"])){
                    unset($_SESSION['order']["delivery"]);
                }
                if(isset($_SESSION['voucher'])){
                    unset($_SESSION['voucher']);
                }
            }
        }
   //      if(isset($this->requestVal['action']) && $this->requestVal['action'] == "orderporuci"){
			// if($_SESSION['shoptype']=='b2c'){
			// 	if(Shop::createReservationFromSessionB2C()){
			// 		$_SESSION['success_notifications'][] = 'Uspesno priblelezena porudzbina.';
			// 	}
			// } 
			// if($_SESSION['shoptype']=='b2b'){
			// 	if(Shop::createReservationFromSession()){
			// 		$_SESSION['success_notifications'][] = 'Uspesno priblelezena porudzbina.';
			// 	}
			// }
	
   //      }

		// if(isset($this->requestVal['action']) && $this->requestVal['action'] == "orderporucib2b"){
  //           if(Shop::b2b_create_reservation()){
  //               $_SESSION['success_notifications'][] = 'Uspesno priblelezena porudzbina.';
  //           }
  //       }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "userregister"){
            echo User::register($_POST['email'], $_POST['password'], $_POST['passwordconf'], $_POST['name'], $_POST['lastname'], $_POST['adresa'], $_POST['mesto'], $_POST['postbr'], $_POST['telefon'],0, $_POST['defaultlang']);
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "partnerapplicationregister"){
            $res =0;
            $fin =-1;
            $res = User::register($_POST['email'], $_POST['password'], $_POST['passwordconf'], $_POST['name'], $_POST['surname'], $_POST['address'], $_POST['city'], $_POST['zip'], $_POST['phone'],1, $_POST['defaultlang'],$_POST['birthday']);

            if($res=='1'){
                $newid=User::getUserIdByEmail($_POST['email']);
                if($newid>0){
                     $mdata = array();
                     $mdata['userid'] = $newid;
                     $mdata['name'] = $_POST['name'];
                     $mdata['surname'] = $_POST['surname'];
                     $mdata['email'] = $_POST['email'];
                     $mdata['address'] = $_POST['address'];
                     $mdata['city'] = $_POST['city'];
                     $mdata['zip'] = $_POST['zip'];
                     $mdata['birthday'] = $_POST['birthday'];
                     $mdata['phone'] = $_POST['phone'];
                     $mdata['cellphone'] = $_POST['cellphone'];
                     $mdata['usersdefaultlang'] = $_POST['defaultlang'];
                     $mdata['partnername'] = $_POST['partnername'];
                     $mdata['partnernumber'] = $_POST['partnernumber'];
                     $mdata['partnercode'] = $_POST['partnercode'];
                     $mdata['partnercontactperson'] = $_POST['partnercontactperson'];
                     $mdata['partnerphone'] = $_POST['partnerphone'];
                     $mdata['partnerfax'] = $_POST['partnerfax'];
                     $mdata['partneremail'] = $_POST['partneremail'];
                     $mdata['partnerwebsite'] = $_POST['partnerwebsite'];
                     $mdata['partneraddress'] = $_POST['partneraddress'];
                     $mdata['partnercity'] = $_POST['partnercity'];
                     $mdata['partnerzip'] = $_POST['partnerzip'];

                     include_once("app/class/Partner.php");
                     $newpartnerapplicationid=0;
                     $newpartnerapplicationid=Partner::addPartnerApplicationData($mdata['userid'], 
                                                  $mdata['partneraddress'], 
                                                  $mdata['partnercity'], 
                                                  $mdata['partnercontactperson'], 
                                                  $mdata['partnerfax'], 
                                                  $mdata['partnername'], 
                                                  $mdata['partnerphone'], 
                                                  $mdata['partnerzip'], 
                                                  $mdata['partnercode'],
                                                  $mdata['partnernumber'],
                                                  $mdata['partneremail'],
                                                  $mdata['partnerwebsite']
                                              );
                    if($newpartnerapplicationid>0){
                       $fin=1; 
                    }
                }
            } else {
                $fin=$res;
            }
            echo $fin; 
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "lostpass"){
            echo User::forgotPass($_POST['email']);
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "changepassword"){
			$stat = 0;
			if(User::checkPassword($_POST['oldpass'])){
				$stat = User::changePass($_SESSION['email'], $_POST['newpass']);
			}	
			echo $stat;
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "partenrnotemptycart"){
            echo (User::isPartnerNotEmptyCart($_POST['username'], $_POST['pass']))? 1:0;
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "remmemberme"){
            //echo (User::isPartnerNotEmptyCart($_POST['username'], $_POST['pass']))? 1:0;
			if($_POST['remmember_me']=='on' && $_SESSION['loginstatus']=='logged'){
			
			$hour = time() + 3600 * 24 * 30;
            setcookie('username', $_POST['username'], $hour);
			//$pass=User::pass_enc($_POST['pass']);
            setcookie('h264', md5(sha1($_POST['username'].md5($_POST['pass']))), $hour);
			}
			//setcookie('password', $_POST['pass'], $hour);
        }
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "saveuserdata"){
			echo User::setUserData($_POST['userid'], $_POST['name'], $_POST['lastname'], -1, -1, -1, -1);
        }
		if(isset($this->requestVal['changeviewtype']))
        {
            $cookie_name = "viewtype";
            $cookie_value = $this->requestVal['changeviewtype'];
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

            $_SESSION['viewtype'] = $this->requestVal['changeviewtype'];
            header('location: '.$_SERVER['REQUEST_URI']);
            die();
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "sendcontactform"){
			global $user_conf;
			$mdata = array();
			
            $mdata['name'] = $_POST['name'];
            $mdata['mail'] = $_POST['mail'];
			$mdata['phone'] = $_POST['phone'];
            $mdata['message'] = $_POST['message'];
			GlobalHelper::sendEmail($user_conf['contact_address'][1], $user_conf["autoemail"][1], 'Poruka sa sajta', $mdata, $type='contact');
			
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "userupdatedata"){
			global $user_conf;
			$mdata = array();

			$mdata['userid'] = $_SESSION['id'];
            $mdata['name'] = $_POST['name'];
            $mdata['surname'] = $_POST['surname'];
            $mdata['email'] = $_POST['email'];
			$mdata['address'] = $_POST['address'];
			$mdata['city'] = $_POST['city'];
			$mdata['zip'] = $_POST['zip'];
			$mdata['phone'] = $_POST['phone'];
			$mdata['cellphone'] = $_POST['cellphone'];
            $mdata['birthday'] = $_POST['birthday'];

			
			User::updateUserData($mdata['userid'], $mdata['name'], $mdata['surname'], $mdata['email'], $mdata['address'], $mdata['city'], $mdata['zip'], $mdata['phone'], $mdata['cellphone'],0,'user',1,$mdata['birthday']);
			
			$_SESSION['shoptype']='b2c';
			$_SESSION['type']='user';
			$_SESSION['partnerid']=0;
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "partnerupdatedata"){
			global $system_conf, $user_conf;
			$mdata = array();
			$mdata['userid'] = $_SESSION['id'];
            $mdata['name'] = $_POST['name'];
            $mdata['surname'] = $_POST['surname'];
            $mdata['email'] = $_POST['email'];
			$mdata['address'] = $_POST['address'];
			$mdata['city'] = $_POST['city'];
			$mdata['zip'] = $_POST['zip'];
			$mdata['phone'] = $_POST['phone'];
			$mdata['cellphone'] = $_POST['cellphone'];
            $mdata['partnername'] = $_POST['partnername'];
            $mdata['partnernumber'] = $_POST['partnernumber'];
            $mdata['partnercode'] = $_POST['partnercode'];
			$mdata['partnercontactperson'] = $_POST['partnercontactperson'];
			$mdata['partnerphone'] = $_POST['partnerphone'];
			$mdata['partnerfax'] = $_POST['partnerfax'];
			$mdata['partneremail'] = $_POST['partneremail'];
			$mdata['partnerwebsite'] = $_POST['partnerwebsite'];
			$mdata['partneraddress'] = $_POST['partneraddress'];
			$mdata['partnercity'] = $_POST['partnercity'];
			$mdata['partnerzip'] = $_POST['partnerzip'];
			
			
			$newpartnerid=0;
			include_once("app/class/Partner.php");
            //if($system_conf["sync"][1]==0){
            //    $newpartnerid=Partner::addPartnerData($mdata['userid'], 
            //                                      $mdata['partneraddress'], 
            //                                      $mdata['partnercity'], 
            //                                      $mdata['partnercontactperson'], 
            //                                      $mdata['partnerfax'], 
            //                                      $mdata['partnername'], 
            //                                      $mdata['partnerphone'], 
            //                                      $mdata['partnerzip'], 
            //                                      $mdata['partnercode'],
            //                                      $mdata['partnernumber'],
            //                                      $mdata['partneremail'],
            //                                      $mdata['partnerwebsite']);
            //}
			
            $newpartnerapplicationid=0;
            $newpartnerapplicationid=Partner::addPartnerApplicationData($mdata['userid'], 
                                                  $mdata['partneraddress'], 
                                                  $mdata['partnercity'], 
                                                  $mdata['partnercontactperson'], 
                                                  $mdata['partnerfax'], 
                                                  $mdata['partnername'], 
                                                  $mdata['partnerphone'], 
                                                  $mdata['partnerzip'], 
                                                  $mdata['partnercode'],
                                                  $mdata['partnernumber'],
                                                  $mdata['partneremail'],
                                                  $mdata['partnerwebsite']);
			

			if($newpartnerid>0){
				User::updateUserData($mdata['userid'], $mdata['name'], $mdata['surname'], $mdata['email'], $mdata['address'], $mdata['city'], $mdata['zip'], $mdata['phone'], $mdata['cellphone'],$newpartnerid,'partner',2);
				$_SESSION['updated']=2;
				$_SESSION['shoptype']='b2b';
				$_SESSION['type']='partner';
				$_SESSION['partnerid']=$newpartnerid;
				
			} else {
                User::updateUserData($mdata['userid'], $mdata['name'], $mdata['surname'], $mdata['email'], $mdata['address'], $mdata['city'], $mdata['zip'], $mdata['phone'], $mdata['cellphone'],$newpartnerid,'user',2);
                $_SESSION['updated']=2;
                $_SESSION['shoptype']='b2c';
                $_SESSION['type']='user';
                $_SESSION['partnerid']=0;
            }





        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "saveuserdata"){
			echo User::setUserData($_POST['userid'], $_POST['name'], $_POST['lastname'], -1, -1, -1, -1);
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "getsmallshopcartdata"){
			echo json_encode(ShopHelper::getShopcartSmallData());
        }	

        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "getcommercialistpartner"){
            include_once("app/class/Partner.php");
            Partner::GetCommercialistPartnerList();
            GlobalHelper::partnerLoadShopcartData();
        }	
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "setcommercialistpartner"){
            $_SESSION['partnerid']=$_POST['partnerid'];
            $_SESSION['partneraddressid']=$_POST['partneraddressid'];
           GlobalHelper::partnerLoadShopcartData();
        }
        if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removecommercialistselectedpartner"){
            $_SESSION['partnerid']=0;
            $_SESSION['partneraddressid']=0;
           GlobalHelper::partnerLoadShopcartData();
        }
        
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "menusubcategorydata"){
			$data = ShopHelper::getCategoryChild($_POST['catid']);
			echo json_encode($data);
        }

		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "getcoupon"){
			$response = ShopHelper::check_coupon($_POST['coupon']);
			if($response[0] == 'success'){
				echo 0;	
			}else{
				echo 1;	
			}
        }
		
		if(isset($this->requestVal['action']) && $this->requestVal['action'] == "removecoupon"){
			unset($_SESSION['voucher']);
			echo 0;	
        }
		
		


	} // RequestHandler() End
}
?>