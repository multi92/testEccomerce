<?php 
	function generate_order_email($orderid){
		
		global $user_conf, $language, $conn;

		include($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");
		include($_SERVER['DOCUMENT_ROOT']."/".$system_conf["theme_path"][1]."/config/user.configuration.php");

		include_once('../../../../app/class/ShopHelper.php');
		include_once('../../../../app/class/core/GlobalHelper.php');
		include_once('../../../../app/class/core/DatabaseAdmin.php');
		$q = "SELECT d.* , dd.*, c.value as `couponvalue`
				FROM b2c_document AS d
				LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
				LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
				LEFT JOIN coupons c ON uc.couponsid = c.id
				WHERE d.id = ".$orderid;
				//echo $q;
		$dres = mysqli_query($conn, $q);
		$drow = mysqli_fetch_assoc($dres);
		$order_number = $drow['number'];
		$orderDocumentStatus= $drow['status'];
		$orderDocumentStatusData='';

		switch ($orderDocumentStatus) {
            case "o":
                //U obradi
                $orderDocumentStatusData = '<div class="container">
					<p class="autoemail">Ova poruka je bila poslata automatski. Na ovaj mail molimo da ne odgovarate. U slučaju dodatnih informacija pišite nam na '.$user_conf["b2c_address"][1].' ili na telefon naveden na sajtu.</p>
				</div>
				<div class="container-fluid logoline">
					<img src="../../../../'.$system_conf["theme_path"][1]."/".$user_conf["sitelogo"][1].'"  />
				</div>
				
				<div class="container">
					<h3 class="bigmessage">VAŠA PONUDA JE U FAZI OBRADE!</h3>
					<p class="infoemail_text">Poštovani '.$drow['customername'].', </p>
							<p class="infoemail_text">NAKON FINALNE PROVERE PROIZVODA KOJE STE PORUČILI <br >
DOBIĆETE KONAČNU POTVRDU DA LI JE VAŠA PONUDA <br >
PRIHVAĆENA I POSLATA , KAO I BROJ ZA PRAĆENJE VAŠE PORUDŽBINE UKOLIKO STE PRILIKOM PORUČIVANJA ODABRALI KURIRSKU SLUŽBU.</p> 
					</p>	
						
				</div>';

                break;
            case "f":
            	//Za slanje
                $orderDocumentStatusData="";
               
                break;
            case "w":
            	//Za slanje na cekanju
                $orderDocumentStatusData="";
                
                break;
            case "s":
            	//Poslata
                $orderDocumentStatusData = '<div class="container">
					<p class="autoemail">Ova poruka je bila poslata automatski. Na ovaj mail molimo da ne odgovarate. U slučaju dodatnih informacija pišite nam na '.$user_conf["b2c_address"][1].' ili na telefon naveden na sajtu.</p>
				</div>
				<div class="container-fluid logoline">
					<img src="../../../../'.$system_conf["theme_path"][1]."/".$user_conf["sitelogo"][1].'"  />
				</div>
				
				<div class="container">
					<h3 class="bigmessage">VAŠA PONUDA JE POSLATA!<br >Vaš kod za praćenje pošiljke je:'.$drow['deliverycode'].' </h3>		
					
				</div>';
                break;
            case "p":
            	//Naplaćena
                $orderDocumentStatusData="";
                
                break;
            case "d":
            	//Odbijena
            	$orderDocumentStatusData = '<div class="container">
					<p class="autoemail">Ova poruka je bila poslata automatski. Na ovaj mail molimo da ne odgovarate. U slučaju dodatnih informacija pišite nam na '.$user_conf["b2c_address"][1].' ili na telefon naveden na sajtu.</p>
				</div>
				<div class="container-fluid logoline">
					<img src="../../../../'.$system_conf["theme_path"][1]."/".$user_conf["sitelogo"][1].'"  />
				</div>
				
				<div class="container">
					<h3 class="bigmessage">VAŠA PONUDA '.$order_number.' JE ODBIJENA!</h3>	
					<p class="infoemail_text">Poštovani '.$drow['customername'].', </p>
					<p class="infoemail_text">Vašu porudžbinu ne možemo isporučiti!</p>		
				</div>';
                
                break;
            case "u":
            	//Odbijena sa razlogom
                $orderDocumentStatusData="";
               
                break;
        }
		
		$orderEmail = $drow['customeremail'];
        $orderDocumentTypeName=$user_conf["document_type_name_B2C"][1]." ".$user_conf["b2c_document_prefix"][1]."-".$order_number;

        //CUSTOMER INFO
        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$drow['customeremail'];
        $orderDetailData .= "<br />Ime : ".$drow['customername'];
        $orderDetailData .= "<br />Prezime : ".$drow['customerlastname'];
        $orderDetailData .= "<br />Telefon : ".$drow['customerphone'];
        $orderDetailData .= "<br />Adresa : ".$drow['customeraddress'].", ".$drow['customerzip']." , ".$drow['customercity'];
        $orderDetailData .= "<br /><br />";
        //CUSTOMER INFO END
        //PAYMENT TYPE
        $paymentData = $drow['payment'];
        $orderPayment="";
        switch ($paymentData) {
            case "p":
                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
                break;
            case "u":
                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
                break;
            case "k":
                $orderPayment="<br/>Plaćanje: Karticom<br/>";
                break;
            case "n":
                $orderPayment="";
                break;
        }
        $orderDetailData .= $orderPayment;
        //PAYMENT TYPE END

        //DELIVERY SERVICE
        $deliveryType = $drow['deliverytype'];
        $deliveryData='';
        switch ($deliveryType) {
            case "p":
                $deliveryData="<br/>Način preuzimanja: Lično<br/>";
                $shopId = $drow['deliveryshopid'];
                require_once('../../../../app/class/Shop.php');
                $shopData = Shop::getShopDataByShopId($shopId);
                $deliveryData .= "<br />Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
                $deliveryData .= "<br />Broj telefona prodavnice: ".$shopData['phone']."<br/>";
                $deliveryData .= "<br />Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
                break;
            case "d":
                require_once("../../../../app/class/DeliveryService.php");
                $deliveryData="<br/>Način preuzimanja: Kurirskom službom<br/>";
                $deliveryServiceId = $drow['deliveryserviceid'];
                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
                $deliveryData .= "<br />Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
                $deliveryData .= "<br />Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
                $deliveryData .= " <br />Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
                if(strlen($deliveryServiceData['deliverytracklink'])>0 && strlen($drow['deliverycode'])>0){
                	$deliveryData .= " <br /><b>Pošiljku možete pratiti na sledećem linku: ".$deliveryServiceData['deliverytracklink']."</b><br/>";
                	$deliveryData .= " <br /><b>Vaš kod za praćenje pošiljke je: ".$drow['deliverycode']."</b><br/>";	
                }
                break;
            case "h":
                $deliveryData="";
                break;
        }
        $orderDetailData .= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment = $drow['comment'];
        $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
        //COMMENT END

        //PREPARE ORDER ITEMS
        /*$qItems = "SELECT di.rebate, di.price, di.taxvalue AS `tax`, p.name AS `productname`, p.code, p.unitname,dia.quantity, dia.attrvalue, d.*, c.value as couponvalue, dd.customeremail AS email, di.productattrstring  
							FROM b2c_documentitemattr dia
								LEFT JOIN b2c_documentitem di ON dia.b2c_documentitemid = di.id
								LEFT JOIN b2c_document d ON di.b2c_documentid = d.id
								LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
								LEFT JOIN product p ON di.productid = p.id
								LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
								LEFT JOIN coupons c ON uc.couponsid = c.id
								WHERE dia.status != 'd' AND di.b2c_documentid = ".$orderid;

		$resItems = mysqli_query($conn, $qItems);
							
		$dataItems = array();
		if(mysqli_num_rows($resItems) > 0){
			while($rowItem = mysqli_fetch_assoc($resItems)){
				array_push($dataItems, $rowItem);
			}
		}*/


		$dataItems = array();
		include_once('../../../../app/class/Document.php');
		$dataItems = DocumentB2C::GetB2C_DocumentItemByDocumentId($orderid);


		$total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue = 0;
        $calc_totalValueWithRebateWithVat = 0;

        $orderItems = array();

        if(isset($dataItems) && is_array($dataItems) && count($dataItems)>0){
        	$orderItems = $dataItems;
        	
        	include_once('../../../../app/class/Product.php');
        	foreach ($orderItems as $key => $cartprod) {
        		//GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //ATRIBUTES
                $attrs = array();
                
                $a = json_decode($cartprod['attr'], true);
                
                if(count($a)>0){
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
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['itemvalue'] = $cartprod['price'] * $cartprod['qty'] *(1-($calc_itemRebate/100));
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = $cartprod['price'] * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += $cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100);
                $calc_totalRebateWithVatValue +=$cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100));
                $calc_totalValueWithRebateVatValue += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                $total_price += $calc_totalRebateValue;
                $total_tax +=$calc_totalRebateValue * (($cartprod['tax'])/100);
                $total_price_pdv += $calc_totalValueWithRebateWithVat;
                //CALCULATIONS END
        	}
        }

        $delivery_cost=0; 
		if(floatval($total_price_pdv-floatval($drow['couponvalue']))>$user_conf["free_delivery_from"][1]){
			$delivery_cost=0;
		} else {
			$delivery_cost= $user_conf["delivery_cost"][1];
		}
		
		$voucher_value = 0;
		$voucher_value = $drow['couponvalue'];
        //PREPARE ORDER ITEMS END 
        if($user_conf["shopcartB2Cshort"][1]==1){
            include("EmailTemplate/EmailOrderB2Cshort.php");
            //INCLUDE CREATES $pdf_msg
           // include("app/class/pdf/PdfOrderB2Cshort.php");
        } else {
            include("EmailTemplate/EmailOrderB2C.php");
            //INCLUDE CREATES $pdf_msg
            //include("app/class/pdf/PdfOrderB2C.php"); 
        }
        return $email_msg;
        //GlobalHelper::sendEmailOrder(array('client'=>$orderEmail, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina br '.$order_number , 'seller'=>' Nova porudzbina na sajtu - '.$order_number), $email_msg, $pdf_header, $pdf_msg, $pdf_footer );
	}
	function generate_pdf_bill($oid){
		global $conn;
		
		$msg = '<html>
					<head>
						<meta charset="utf-8" />
						<base href="/" />

					</head>
					<body>';
						
						
						
							//include($_SERVER['DOCUMENT_ROOT']."/configs/db_config.php");
							//include($_SERVER['DOCUMENT_ROOT']."/configs/global_conf.php");
							//include($_SERVER['DOCUMENT_ROOT']."/configs/user.configuration.php");
				
							$q = "SELECT di.rebate, di.price, di.taxvalue, di.productname, p.code, dia.quantity, dia.attrvalue, d.*, c.value as couponvalue, dd.customeremail AS email 
							FROM b2c_documentitemattr dia
								LEFT JOIN b2c_documentitem di ON dia.b2c_documentitemid = di.id
								LEFT JOIN b2c_document d ON di.b2c_documentid = d.id
								LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
								LEFT JOIN product p ON di.productid = p.id
								LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
								LEFT JOIN coupons c ON uc.couponsid = c.id
								WHERE dia.status != 'd' AND di.b2c_documentid = ".$oid;
							
							$re = mysqli_query($conn, $q);
							
							$data = array();
							if(mysqli_num_rows($re) > 0){
								while($row = mysqli_fetch_assoc($re)){
									array_push($data, $row);
								}
							}
						$docdate=date_create($data[0]['documentdate']);	
						$msg .= '<div class="onethirds">
											<img style="margin:20px 15px 10px 0; max-height:80px; width:auto;" src="../../../../'.$user_conf["sitelogo"][1].'" />
										</div>
										<div class="twothirds headerStyle">
											<p>'.$user_conf["memorandum_line1"][1].'</p>
											<p>'.$user_conf["memorandum_line2"][1].'</p>
											<p>'.$user_conf["memorandum_line3"][1].'</p>
											<p>'.$user_conf["memorandum_line4"][1].'</p>
											<p>'.$user_conf["memorandum_line5"][1].'</p>
										</div>
						<div class="x_half" style="width:50%; float:left; font-size:12px!important; line-height:14px">
							<br>
							<br>
							Email: '.$data[0]['email'].' <br>
							Ime : '.$data[0]['ordname'].' <br>
							Prezime : '.$data[0]['ordlastname'].' <br>
							Adresa : '.$data[0]['ordaddress'].', '.$data[0]['ordzip'].' , '.$data[0]['ordcity'].' <br>
							Telefon : '.$data[0]['ordphone'].' <br>
							Način plaćanja : '.(($data[0]['payment'] == 'poz')? 'pouzećem':'karticom').'<br>
						</div>
						
						<div class="x_half" style="width:50%; float:left; font-size:12px!important; line-height:14px">
							<div class="x_twothirds x_bottomMargin15" style="width:66%; float:left; font-size:12px; margin-bottom:15px">
							<br>
							<br>
								<p>Mesto izdavanja</p>
								<p>Niš</p>
							<br>
								<p>Datum izdavanja</p>
								<p>'.date_format($docdate,"d.m.Y").'</p>
							</div>
							<div class="x_onethirds x_bottomMargin15" style="width:33%; float:left; font-size:12px; margin-bottom:15px">
								<p></p>
								<p></p>
							</div>
						</div>
						<div style="clear:both"></div>
						<h2 class="x_titlenumber" style="font-weight:bold; font-size:12pt; color:#FFF; font-family:\'Arial\'; margin-top:20px; margin-bottom:20px; border:none; text-align:center; text-transform:uppercase; page-break-after:avoid; padding-top:10px; padding-bottom:10px; background-color:#000">
				Račun broj: '.$data[0]['number'].'</h2>
						
						<table border="1" cellpadding="0" cellspacing="0" style="text-align:right; line-height:1.2; margin-top:2pt; margin-bottom:5pt; border-collapse:collapse; width:100%; border-bottom:none; border-left:none; border-right:none; width:100%">
							<thead>
								<tr class="x_tableHeder">
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									R.b.</th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Šifra</th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Proizvod</th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Količina</th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Cena </th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Popust (%)</th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Vrednost <br>
									bez PDV</th>
									<th style="font-weight:bold; vertical-align:top; padding-left:2mm; padding-right:2mm; padding-top:0.5mm; padding-bottom:0.5mm; text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									Vrednost <br>
									sa PDV</th>
								</tr>
							</thead>
							<tbody>';
							
							$i = 1; 
								$totalamount_notax = 0;
								$totalamount = 0;
								foreach($data as $key=>$val){ 
							
								$val['attrvalue'] = json_decode($val['attrvalue'], true);
							
								$msg .= '<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333">
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.$i.'</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.$val['code'].'</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.$val['productname'].' <br>
									šifra: '.$val['code'].'<br>
									mass: '.$val['attrvalue']['mass'].'<br>
									boja: '.$val['attrvalue']['boja'].'<br>
									veličina: '.$val['attrvalue']['veličina'].'<br>
									</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.$val['quantity'].'</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.number_format($val['price']*((100+$val['taxvalue'])*0.01), 2, '.', ',').'</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.$val['rebate'].'</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.number_format($val['price']*((100-$val['rebate'])*0.01)*$val['quantity'], 2, '.', ',').'</td>
									<td style="padding-left:1mm; vertical-align:middle; padding-right:1mm; padding-top:1mm; padding-bottom:1mm; text-align:right; font-family:\'Arial\'; font-size:11px!important; line-height:12px; border-left:1px solid #333!important; border-right:1px solid #333!important">
									'.number_format($val['price']*((100+$val['taxvalue'])*0.01)*((100-$val['rebate'])*0.01)*$val['quantity'], 2, '.', ',').'</td>
								</tr>';
							
									$totalamount_notax += (floatval($val['price'])*((100-floatval($val['rebate']))*0.01)*floatval($val['quantity']));
									$totalamount += (floatval($val['price'])*((100+floatval($val['taxvalue']))*0.01)*((100-floatval($val['rebate']))*0.01)*floatval($val['quantity']));
							
									$i++; 
								} 
								
								
						
							
							$msg .= '</tbody>
							<tfoot>
								<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
								<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
								Ukupno: </td>
								<td style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
								'.number_format($totalamount_notax, 2, '.', ',').'</td>
								<td style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
								'.number_format($totalamount, 2, ',','.').'</td>
								</tr>
								<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
								<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
								Troškovi dostave : </td>
								<td colspan="2" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">';
								if($totalamount < 5000)
									{
										$msg .= '250.00'; 
										$totalamount = (floatval($totalamount)+250);
									}else $msg .= '0.00'; 
								$msg .= '</td>
								</tr>
								<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
								<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
								Kupon : </td>
								<td colspan="2" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">';
									if($data[0]['usedcouponid'] > '') 
									{
										$msg .= "-".$data[0]['couponvalue']; 
									} else $msg .= '0.00'; 
								$msg .= '</td>
								</tr>
								
								<tr class="x_summaryRow x_nobackground" style="border:none; background-color:transparent">
								<td colspan="6" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">';
								
									if($data[0]['usedcouponid'] > ''){
										$totalamount = floatval($totalamount)-floatval($data[0]['couponvalue']);
									}
								$msg .= 'Ukupno za uplatu: </td>
								<td colspan="2" style="text-align:right; font-weight:bold; font-size:12px; border:none!important">
									'.number_format($totalamount, 2, ',','.').'</td>
								</tr>
							</tfoot>
						</table>
						
						<br /><br />
							U SLUČAJU POTREBE ZA REKLAMACIJOM MOLIMO VAS DA NA NAŠEM SAJTU PRVO PROČITATE PRAVILNIK O POSTUPKU I NAČINU REŠAVANJA REKLAMACIJE TAKODJE , NA NAŠEM SAJTU IMATE I POTREBNA DOKUMENTA U PDF FORMATU ZA PODNOŠENJE REKLAMACIJE.
							<br /><br />
							RAČUN JE AUTOMATSKI KREIRAN I VALIDAN JE BEZ PEČATA I POTPISA.
							<br /><br />
							<br /><br />
							<p>
								FAKTURISAO <br />
								___________________
								<span style=\'margin-left: 35%;\'> M.P. </span>
							</p>
								
						
					</body>
				</html> ';
				return $msg;
							
	}
	function get_b2c_header($type, $info){
		/*//
			$type 
			1 - inicijalni email - salje se prilikom porucivanja
			2 - u obradi
			3 - prihvacena
			4 - delimicno prihvacena
			5 - poslata sadrzi track broj
			6 - odbijena
			7 - kupon
			
			$info - array
				$info['name'] - ime kupca
				$info['tracknumber'] - tracking broj
		//*/
		
		global $conn, $user_conf;
		
		if($type == 2){
			$bigmessage = 'INFORMACIJE O PORUDŽBINI';
			$smallmessage = '<p class="infoemail_text">Poštovani '.$info['name'].', </p>
							<p class="infoemail_text">Želimo da Vam se zahvalimo na Vašoj kupovini, Vaša PONUDA je u obradi. <br >
							O toku obrade bićete informisani putem e-mail poruke.</p>';
		}
		
		if($type == 3){
			$bigmessage = 'VAŠA PONUDA JE OBRADJENA!';
			$smallmessage = '<p class="infoemail_text">POŠTOVANI '.strtoupper($info['name']).', </p>
							<p class="infoemail_text">NAKON FINALNE PROVERE PROIZVODA KOJE STE PORUČILI <br >
DOBIĆETE KONAČNU POTVRDU DA JE VAŠA PONUDA <br >
PRIHVAĆENA I POSLATA , KAO I BROJ ZA PRAĆENJE VAŠE PORUDŽBINE .</p>';
		}
		
		if($type == 4){
			$bigmessage = 'VAŠA PONUDA JE DELIMIČNO PRIHVAĆENA!';
			$smallmessage = '<p class="infoemail_text">Poštovani '.$info['name'].', </p>
							<p class="infoemail_text">
								Vašu porudžbinu ne možemo u potpunosti isporučiti! <br /> <br /> 
								U nastavku ove poruke se nalazi vaša PONUDA sa obeleženim stavkama koje nismo u mogućnosti da vam isporučimo. <br /><br />  
								Takođe cena porudžbine je korigovana i uključuje samo stavke koje možemo isporučiti. <br /><br /> 
								Ukoliko želite da odustanete od porudžbine molimo obavestite nas na email '.$user_conf["b2c_address"][1].' u roku od 24h. U suprotnom biće Vam poslati dostupni artikli na adresu koju ste naveli prilikom poručivanja. <br /> 
							</p>';
		}
		
		if($type == 5){
			
			if($info['country'] == 'RSD') {
				$a = '<a href="https://www.cityexpress.rs/pracenje-posiljaka/" target="_blank" >CityExpress</a>';
			}else{
				$a = '<a href="http://www.posta.rs/struktura/lat/aplikacije/alati/posiljke.asp" target="_blank" >Portala Pošte</a>';
			}
			$bigmessage = 'VAŠA PONUDA JE POSLATA!';
			$smallmessage = '<p class="infoemail_text">
								Poštovani '.$info['name'].', </p>
								<p class="infoemail_text">Vaša PONUDA je dostavljena kurirskoj službi CityExpress!</p>
								<p class="infoemail_text">Na dan isporuke bićete obavešteni SMS porukom od strane kurirske službe. Očekujte isporuku u roku od 3 - 6 radnih dana</p>
								<p class="infoemail_text">Kod pošiljke: <b>'.$info['tracknumber'].'</b></p>
								<p class="infoemail_text">Pošiljku možete pratiti preko '.$a.' </p>
								';//<p class="infoemail_text">ili preko našeg sajta <a href="track" target="_blank" >Praćenje porudžbine</a></p>
		}
		
		if($type == 6){
			$bigmessage = 'VAŠA PONUDA JE ODBIJENA!';
			$smallmessage = '<p class="infoemail_text">Poštovani '.$info['name'].', </p>
							<p class="infoemail_text">Vašu porudžbinu ne možemo isporučiti!</p>';
		}
		
		if($type == 7){
			$bigmessage = 'ČESTITAMO!';
			$smallmessage = '<p class="infoemail_text">DOBILI STE VAUČER ZA ONLINE KUPOVINU</p>
							<img src="'.BASE_URL.'images/'.$info['image'].'" style="max-width:100%">
							<div class="vaucerline">
								<p class="infoemail_text">KOD VAUČERA: <b>'.$info['couponcode'].'</b> </p>
							</div>
							<p class="infoemail_text">POŠTOVANI,</p>
							<p class="infoemail_text">VAŠOM PREDHODNOM KUPOVINOM OSTVARILI STE VAUČER U IZNOSU OD '.$info['couponvalue'].' '.$info['valute'].'</p>
							<p class="infoemail_text">VAUČER MOŽETE ISKORISTITI VEĆ PRILIKOM VAŠE SLEDEĆE KUPOVINE I TO TAKO ŠTO ĆETE PO ZAVRŠETKU VAŠE KUPOVINE U DELU UNESI KOD UNETI KOD OVOG VAUČERA KOJI STE DOBILI .</p>
							<p class="infoemail_text">OČEKUJEMO VAS USKORO</p>';
		}
		
		$data = '<div class="container">
					<p class="autoemail">Ova poruka je bila poslata automatski. Na ovaj mail molimo da ne odgovarate. U slučaju dodatnih informacija pišite nam na '.$user_conf["b2c_address"][1].' ili na telefon naveden na sajtu.</p>
				</div>
				<div class="container-fluid logoline">
					<img src="../../../../'.$user_conf["sitelogo"][1].'"  />
				</div>
				
				<div class="container">
					<h3 class="bigmessage">'.$bigmessage.'</h3>	
					'.$smallmessage.'		
				</div>';
		
		return $data;
	}
	
	function get_b2c_info($orderid, $dev = false){
		//* $dev - true return array, false - prepared html for email *//
		global $conn;
		$q = "SELECT d.*, dd.* 
				FROM b2c_document d
				LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
				WHERE d.id = ".$orderid;
				//echo $q;
		$dres = mysqli_query($conn, $q);
		$drow = mysqli_fetch_assoc($dres);
		
		$data = '';
		if($dev) $data = $drow;
		
		
		$data = '<div class="container-fluid orderdetailcont">
					<div class="container orderdetailholder">
						<div class="half">
							<h1 class="smalltitle">Detalji ponude</h1>
							<hr class="smallline"><div class="clear"></div>
						
							<p class="infoline"><span>Broj ponude:</span> '.$drow['number'].' </p>
							<p class="infoline"><span>Datum ponude:</span> '.date('d.m.Y H:i:s', strtotime($drow['documentdate'])).' </p>
							<p class="infoline"><span>Način plaćanja:</span> '.(($drow['payment'] == 'k')? 'karticom':'pouzecem').' </p>
						</div>
						<div class="half">
							<div class="halfspacer"></div>
							<p class="infoline"><span>Email:</span> '.$drow['customeremail'].'</p>
							
						</div>
						
						<div class="clear"></div>
						
						<div class="half">
							<h1 class="smalltitle">Adresa za naplatu:</h1>
							<hr class="smallline"><div class="clear"></div>
							
							<p class="infoline"><span>Ime:</span> '.$drow['customername'].' </p>
							<p class="infoline"><span>Prezime:</span> '.$drow['customerlastname'].' </p>
							<p class="infoline"><span>Email:</span> '.$drow['customeremail'].' </p>
							<p class="infoline"><span>Adresa:</span> '.$drow['customeraddress'].', '.$drow['customerzip'].' '.$drow['customercity'].' </p>
						</div>
						<div class="half">
							<h1 class="smalltitle">Adresa za isporuku:</h1>
							<hr class="smallline"><div class="clear"></div>
							
							<p class="infoline"><span>Ime:</span> '.$drow['recipientname'].' </p>
							<p class="infoline"><span>Prezime:</span> '.$drow['recipientlastname'].' </p>
							<p class="infoline"><span>Email:</span> '.$drow['customeremail'].' </p>
							<p class="infoline"><span>Adresa:</span> '.$drow['customeraddress'].', '.$drow['customerzip'].' '.$drow['customercity'].' </p>
						</div>
						
						<div class="clear"></div>							
					</div>
				</div>';
					
					
		if($dev) return json_encode($data);
		return $data;			
	}
	
	function get_b2c_items($orderid, $dev = false){
		/*// $dev 
				true return array, 
				false - prepared html for email 
		//*/
		global $conn, $user_conf;
		//include_once $_SERVER['DOCUMENT_ROOT']."/configs/global_conf.php";
		include_once($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");  
		include_once($_SERVER['DOCUMENT_ROOT']."/".$system_conf['theme_path'][1]."config/user.configuration.php");
		
		$q = "SELECT * FROM b2c_document d 
				LEFT JOIN b2c_documentdetail dd ON d.id = dd.b2c_documentid
		WHERE d.id = ".$orderid;
		$dres = mysqli_query($conn, $q);
		$drow = mysqli_fetch_assoc($dres);
		
		$q = "SELECT dia.id, dia.quantity, dia.attrvalue, dia.status, di.rebate, di.price, di.productid, di.productname, di.taxvalue, p.code 
				FROM b2c_documentitemattr dia
				LEFT JOIN b2c_documentitem di ON dia.b2c_documentitemid = di.id
				LEFT JOIN product p ON di.productid = p.id
    			WHERE di.b2c_documentid = ".$orderid;
		$res = mysqli_query($conn, $q);
		
		if(mysqli_num_rows($res) > 0){
			$data = '';
			if($dev) $data = array();
			$items = array();
			$total_mass = 0;
			$total_no_pdv = 0;
			$total_pdv = 0;
			while($row = mysqli_fetch_assoc($res))
			{
				
				array_push($items, $row['id']);				
				if($dev){
					array_push($data, $row);
				}
				else{
					$attr = json_decode($row['attrvalue']);
					$attr_data = '';
					$color = '';
					

					$tmpav = array();
					if(isset($row['attrvalue']) && strlen($row['attrvalue'])>0){
					$q = "SELECT a.name, av.value FROM attr a 
							LEFT JOIN attrval av ON a.id = av.attrid
							WHERE av.id IN (".$row['attrvalue'].")";
					$ares = mysqli_query($conn, $q);
					if(mysqli_num_rows($ares) > 0){
						while($arow = mysqli_fetch_assoc($ares))
						{
							$attr_data .= $arow['name']." : ".$arow['value']." <br />";
						}
					}
									
					}
					// single item price
					$price = $row['price']*(1+($row['taxvalue']/100))*(1-($row['rebate']/100));
					$order_itemvalue_nopdv = $row['price']*((100-$row['rebate'])*0.01)*$row['quantity'];
					//*/ SUMMARY CALC	//*/
					
					$order_itemvalue = (((100-$row['rebate'])*0.01)*((100+$row['taxvalue'])*0.01)*$row['price'])*$row['quantity'];
					
					if($row['status'] != 'd'){
						//$total_mass = $total_mass + ($mass/1000*$row['quantity']);
						$total_no_pdv += $order_itemvalue_nopdv;
						$total_pdv += $order_itemvalue;
					}
											
					$image = '';
					$files = glob($_SERVER['DOCUMENT_ROOT']."/images/products/pic_".$row['productid']."*".$color.".jpeg");
					
					$data .= '<div class="itemcont">
							<div class="imageholder">
								
							</div>
							<div class="iteminfoholder">
								<p class="itemname">'.$row["productname"].'</p>
								<p class="itemattr">Šifra: '.$row["code"].'</p>
								<p class="itemattr">'.$attr_data.'</p>
								<p class="itemattr">Količina: '.$row['quantity'].'</p>
								
								<p class="itemprice">Cena po komadu: '.number_format($price, 2).' '.strtoupper($drow['documentcurrency']).'</p>
							</div>';
							if($row['status'] == 'd'){
							$data .= '<div class="outofstock">
									<p>Nedostupno</p>
								</div>';
							}
							$data .= '<div class="clear"></div>
								</div>';
				}
								
			}
			
			if($dev){
				//*/	TODO - export array for development		//*/
			}
			else{
				
				$troskovi_dostave = $drow['deliverycost'];
				$couponamount = 0;
				if($drow['usedcouponid'] != 0 )
				{
					$q = "SELECT uc.couponcode, c.value FROM usercoupon uc 
						LEFT JOIN coupons c ON uc.couponsid = c.id WHERE uc.id = ".$drow['usedcouponid'];
					$cpres = mysqli_query($conn, $q);
					$cprow = mysqli_fetch_assoc($cpres);
					$couponamount = $cprow['value'];
				}
				
				$data .= '<div class="container ordersummarycont">
							<div class="summaryrow">
								<div class="summarytext">Cena bez PDV-a	</div>
								<div class="summaryvalue">'.number_format($total_no_pdv,2).' '.strtoupper($drow['documentcurrency']).'</div>
							</div>
							<div class="summaryrow">
								<div class="summarytext">Poštanski troškovi	</div>
								<div class="summaryvalue">'.number_format($troskovi_dostave,2).' '.strtoupper($drow['documentcurrency']).'</div>
							</div>
							<div class="summaryrow">
								<div class="summarytext">PDV</div>
								<div class="summaryvalue">'.number_format($total_pdv-$total_no_pdv,2).' '.strtoupper($drow['documentcurrency']).'</div>
							</div>';
							
							if($drow['usedcouponid'] != 0)
							{
								$data .= '<div class="summaryrow">
									<div class="summarytext">KUPON</div>
									<div class="summaryvalue">'.number_format($couponamount,2).' '.strtoupper($drow['documentcurrency']).'</div>
								</div>';
							}
							
							$data .= '<div class="summaryrow">
								<div class="summarytextprice">UKUPNO</div>
								<div class="summaryvalueprice">'.number_format($total_pdv-$couponamount+$troskovi_dostave, 2).' '.strtoupper($drow['documentcurrency']).'</div>
							</div>
							
							<div class="clear"></div>
						</div>';	
			}
			
			if($dev) return json_encode($data);
			return $data;
		}
	}
	
	function get_b2c_footer(){
		global $conn, $user_conf;	
		
		$data = '<div class="container">
					<p class="footertext">HVALA VAM ŠTO POSEĆUJETE NAŠ SAJT : <br />
						OČEKUJEMO VAS PONOVO</p>
				</div>
				
				<div class="container-fluid footer">
					<p>Copyright © '.date('Y').' '.$user_conf["company"][1].'</p>
				</div>
				</body>
			</html>';
		return $data;
	}
	
	
	function send_b2c_email($to, $from, $subject, $messagedata, $oid = 0){
		global $conn;
		global $user_conf;
		//require_once($_SERVER['DOCUMENT_ROOT'].'/configs/user.configuration.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/cdn/phpmailer/PHPMailerAutoload.php');
	
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($from, $user_conf["company"][1]);
	
		$mail->Body = "<html>
				<head>
					<style>
						body{font-family:'Open Sans',Arial,sans-serif;font-size:12px!important;line-height:12px;margin:0;padding:0}
						p{text-align:center;margin-bottom:0;margin-top:0}
						.clear{clear:both!important}
						.container{width:auto;max-width:900px;margin-left:auto;margin-right:auto}
						.container-fluid{width:100%;margin-left:auto;margin-right:auto}
						.autoemail{padding:20px 10px;font-size:14px;line-height:14px;max-width:700px;margin:0 auto;background-color:#ecc9c9;color:#a94442}
						.logoline{text-align:center;background-color:#000;height:70px}
						.logoline img{height:70px;width:auto}
						.bigmessage{text-align:center;margin:70px 10px;font-size:22px;line-height:30px;font-family:'Open Sans',Arial,sans-serif;color:#343434;letter-spacing:8px}
						.bigmessage_infomail{text-align:center;margin:70px 10px 10px;font-size:65px;line-height:80px;font-family:'Open Sans',Arial,sans-serif;color:#343434;letter-spacing:8px}
						.orderdetailcont{background-color:#eee;border-top:#90C 4px solid;padding:30px 0}
						.orderdetailholder{text-align:left}
						.half{width:50%;float:left;font-size:12px!important;line-height:14px;margin:10px 0}
						.halfspacer{height:68px}
						.smallline{width:100px;float:left;border:1px solid #8500b1;margin:10px 0}
						.smallline_center{width:100px;border:1px solid #8500b1;margin:10px auto}
						.smalltitle{font-size:20px}
						.infoline{text-align:left;line-height:30px;font-size:16px;color:#343434}
						.infoline span{font-weight:700}
						.itemcont{margin:10px 0;border-bottom:2px solid #eee;position:relative}
						.imageholder{width:30%;display:inline-block;float:left;text-align:center}
						.imageholder img{height:180px}
						.iteminfoholder{width:60%;float:left;text-align:left}
						.itemname{text-align:left;font-size:20px;margin-bottom:15px;margin-top:30px}
						.itemattr{text-align:left;font-size:14px;line-height:17px;color:#666}
						.itemprice{text-align:left;font-size:16px;color:#8500b1;font-weight:700;margin:10px 0}
						.ordersummarycont{margin-bottom:50px;margin-top:30px}
						.summarytext{width:75%;float:left;text-align:right;font-size:18px;color:#343434;line-height:22px}
						.summaryvalue{width:25%;float:left;text-align:right;font-size:18px;color:#343434;line-height:22px}
						.summarytextprice{width:75%;float:left;text-align:right;font-size:25px;line-height:32px;color:#8500b1;font-weight:700}
						.summaryvalueprice{width:25%;float:left;text-align:right;font-size:25px;line-height:32px;color:#8500b1;font-weight:700}
						.footertext{margin:20px auto;font-size:14px;line-height:17px;color:#666}
						.footer{background-color:#8500b1;height:36px}
						.footer p{text-align:center;line-height:36px;color:#fff;font-size:14px}
						.infoemail_text{font-size:15px;margin-bottom:20px;margin-top:20px;line-height:16px}
						.vaucerline{text-align:center;background-color:#000;height:50px;color:#fff}
						.vaucerline p{color:#fff;font-size:20px;line-height:46px}
						.outofstock{position:absolute;width:100%;height:100%;background-color:rgba(0,0,0,0.55)}
						.outofstock p{font-size:26px;font-weight:700;color:#ff9b00;margin-left:25%;margin-top:8%}
						@media screen and (max-width: 768px) {
						.half{width:100%;margin:5px 20px}
						.halfspacer{height:0}
						.bigmessage{margin:50px 10px;font-size:40px;line-height:65px;letter-spacing:6px}
						.summarytext{width:50%}
						.summaryvalue{width:50%}
						.summarytextprice{width:50%}
						.summaryvalueprice{width:50%}
						}
					</style>
				</head>".$messagedata;
				
			/*	ADD PDF BILL	*/
			if($oid != 0){
				//require_once($_SERVER['DOCUMENT_ROOT']."/cdn/html2pdf/mpdf.php");
				//$mpdf=new mPDF('utf-8','A4','','Arial',6,6,0,10,3,3,'P'); 
				//$mpdf->SetDisplayMode('fullpage');
				//$mpdf->list_indent_first_level = 0;	
				
				//$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cdn/html2pdf/mpdfstyletables.css');
				//$mpdf->WriteHTML($stylesheet,1);
				
				/*$mpdf->SetHTMLHeader('<div class="onethirds">
											<img style="margin:20px 15px 10px 0; max-height:80px; width:auto;" src="'.$_SERVER['DOCUMENT_ROOT'].'/'.$user_conf["memorandum_logo"][1].'" />
										</div>
										<div class="twothirds headerStyle">
											<p>'.$user_conf["memorandum_line1"][1].'</p>
											<p>'.$user_conf["memorandum_line2"][1].'</p>
											<p>'.$user_conf["memorandum_line3"][1].'</p>
											<p>'.$user_conf["memorandum_line4"][1].'</p>
											<p>'.$user_conf["memorandum_line5"][1].'</p>
										</div>');*/
				//$mpdf->SetHTMLFooter('<p style="width:100%; text-align:center;">{PAGENO}</p>');
				//$mpdf->WriteHTML(generate_pdf_bill($oid),2);
				//$file = $mpdf->Output($_SERVER['DOCUMENT_ROOT'].'/cdn/html2pdf/mpdf.pdf','S');
					
				//$mail->AddStringAttachment($file, 'Porudzbina.pdf', 'base64', 'application/pdf');	
			}
			$mail->addAddress($to);    
			$mail->Subject = $subject;
	
			if(!$mail->send()) {
				//echo 'Message could not be sent.';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
				//$_SESSION['error_notifications'][0]='Poruka nije poslata';
				return false;
			} else {
				return true;
				//echo 'Message has been sent';
				//$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
			}

				
	} 

?>