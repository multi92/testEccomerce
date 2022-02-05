<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	//$_POST['oid'] = '5/2019_WEB_B2B';
	//$_POST['oid'] = '44/2019_WEB';
	
	if(isset($_POST['oid']) && $_POST['oid'] != ''){

		include_once("app/class/Document.php");
		include_once("app/class/Shop.php");
		if(strpos($_POST['oid'], "B2B") !== false){
			/*	B2B	*/	
			$documentData=DocumentB2B::GetB2B_DocumentByDocumentNumber($_POST['oid'],'E');
			$view = 'B2B';
		}else{
			/*	B2C	*/
			$documentData=DocumentB2C::GetB2C_DocumentByDocumentNumber($_POST['oid'],'E');
			$view = 'B2C';
		}
		
		if($documentData->payment == 'k')
		{
			//include($system_conf["theme_path"][1]."config/user.configuration.php");
			//echo $documentData->customeremail."<br />";
			echo "<pre>";
			var_dump($documentData);
			echo "</pre>";

			$email_msg = Shop::createCreditCardOrderEmail($documentData->id);
			
			GlobalHelper::sendEmailOrderRequest(array('client'=>$documentData->documentdetail['customeremail'], 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina-Upit br '.$_POST['oid'] , 'seller'=>' Novi upit na sajtu '), $email_msg );
			
		}
		
		$order_empty = false;
		if(!(array)$documentData)
		{
			$order_empty=true;	
		} 
		
		if(!$order_empty){
			 include_once("app/class/Product.php");
			 foreach ($documentData->documentitem as $key => $cartprod) {
				$documentData->documentitem[$key]['cartposition'] = $key;
    		    //$shopcart[$key]['attrdata'] = json_encode($cartprod['attr']);
    		    	$attrs = array();
    		    	if(isset($documentData->documentitem[$key]['attr']) && is_array(json_decode($documentData->documentitem[$key]['attr']))){
    		    		$a = json_decode($documentData->documentitem[$key]['attr'], true);
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
		    		    //var_dump($a);
						$prodData=Product::getProductDataById($cartprod['id']);
						$productImagesData=Product::getPicturesWithAttributesValueByProductId($cartprod['id']);
						//var_dump($productImagesData[0]['img']);
						$documentData->documentitem[$key]['pic']=$productImagesData[0]['img'];
						$documentData->documentitem[$key]['unitname']=$prodData['unitname'];
						$documentData->documentitem[$key]['unitstep']=$prodData['unitstep'];
						$endprice=$documentData->documentitem[$key]['price'];
						$documentData->documentitem[$key]['price']= $endprice/$_SESSION['currencyvalue'];
						//$enditemvalue=$documentData->documentitem[$key]['itemvalue'];
						//$documentData->documentitem[$key]['itemvalue']= $enditemvalue/$_SESSION['currencyvalue'];
		    		    $documentData->documentitem[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
		    		    $documentData->documentitem[$key]['attrn'] = $attrs;
						$documentData->documentitem[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
						$documentData->documentitem[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
    		    		$documentData->documentitem[$key]['amount'] = Product::getProductWarehouseAmount($cartprod['id']);
			 }

			if($user_conf["shopcartB2Cshort"][1]==1){
        	    include($system_conf["theme_path"][1]."views/shopcartCheckoutFinished".$view."short.php");
        	} else {
        	    include($system_conf["theme_path"][1]."views/shopcartCheckoutFinished".$view.".php");
        	}


			
		}
		
	}

?>