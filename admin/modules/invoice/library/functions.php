<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	include_once("../../../config/db_config.php"); 
	include("../../../config/config.php");
	include("../../userlog.php");
	
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getitem" : get_item(); break;
			case "changestatus" : change_status(); break;
			case "verifypath" : verifypath(); break;	
			case "getlanguageslist" : getLanguagesList(); break;			
			case "updateitemamount" : updateItemAmount(); break;
			case "deleteorderitem" : deleteOrderItem(); break;
			
			/*	add new product	*/
			case "getorderB2Cproduct": get_order_b2b_product(); break;
			//case "getorderB2Cproductsizes": get_order_b2b_product_sizes(); break;
			case "addNewItemToOrder": add_New_Item_To_Order(); break;
			
			/*	accept order */
			case "acceptorder": accept_order(); break;
			
			/*	decline order */
			case "declineorder": decline_order(); break;
			
			case "sendDeliveryCodeEmail": send_Delivery_Code_Email(); break;
			case "confirmPaymentButton": confirm_Payment(); break;
			/*	bank command	*/
			case "bankcommand": bank_command(); break;
			/*	prodavnica	*/
			case "getprodavnicadata": get_prodavnica_data(); break;
			
			/*	dodaj interni komentar	*/
			case "addinternalcomment": add_internal_comment(); break;
		}
	}
	
	
	
	function postexpres_calc($mass, $value){
		if($mass < 1) $mprice = 990;
		if($mass >= 1 && $mass < 2) $mprice = 1280;
		if($mass >= 2 && $mass < 5) $mprice = 1790;
		if($mass >= 5 && $mass < 10) $mprice = 2490;
		if($mass >= 10 && $mass < 15) $mprice = 3280;
		if($mass >= 15 && $mass < 20) $mprice = 4090;
		$vprice = round($value/10000, 0, PHP_ROUND_HALF_UP) * 80;
		return $mprice+$vprice;
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			
			$query = "UPDATE `b2b_document` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			

			mysqli_query($conn, $query);	
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
			
		}
	}
	
	function get_item(){
		
		global $conn;	
		//include_once $_SERVER['DOCUMENT_ROOT']."/configs/global_conf.php";
		//include_once $_SERVER['DOCUMENT_ROOT']."/configs/user.configuration.php";
		
		$q = "SELECT d.id as docid, d.status, d.documentdate, d.warehouseid, d.payment,
		                            dia.quantity, dia.orgquantity, dia.attrvalue, dia.id as documentitemattrid, dia.b2b_documentitemid, dia.status as rowstatus, di.rebate , di.price, di.taxvalue, di.productid, p.name, p.code 
		        FROM b2b_document d 
				LEFT JOIN b2b_documentitem di ON d.id = di.b2b_documentid 
				LEFT JOIN b2b_documentitemattr dia ON di.id = dia.b2b_documentitemid 
				LEFT JOIN product p ON di.productid = p.id 
				WHERE d.id = ".$_POST['id']." ORDER BY dia.id ASC";
				
		$re = mysqli_query($conn, $q);
		$data = array();
		$data['items'] = array();
		$total_mass = 0;
		$total_pdv = 0;
		if(mysqli_num_rows($re) > 0){
			while($row = mysqli_fetch_assoc($re)){
				//$row['attrvalue'] = json_decode($row['attrvalue']);
				$row['payment'] = ($row['payment'] == 'p')? 'pouzecem':'karticom';
				$row['taxvalue'] = (100+$row['taxvalue'])*0.01;
				$row['rebate'] = (100-$row['rebate'])*0.01;
				
				$order_itemvalue = ($row['rebate']*$row['taxvalue']*$row['price'])*$row['quantity'];
				$mass = '';
				
				$tmpav = array();
				if($row['attrvalue']!='' && strlen($row['attrvalue'])>0){
				$q = "SELECT a.name, av.value FROM attr a 
						LEFT JOIN attrval av ON a.id = av.attrid
						WHERE av.id IN (".$row['attrvalue'].")";
				$ares = mysqli_query($conn, $q);
				if(mysqli_num_rows($ares) > 0){
					while($arow = mysqli_fetch_assoc($ares))
					{
						array_push($tmpav, array($arow['name'], $arow['value']));
					}
				}
				}
				$row['attrvalue'] = json_encode($tmpav);
				
			/*	foreach($row['attrvalue'] as $key => $val){
					if($key == 'masa') $mass = $val;
					if($key == 'boja'){
				 		$imgs = glob($_SERVER['DOCUMENT_ROOT'].'/images/products/pic_'.$row['productid'].'-*_'.$val.'.jpeg');
				 		$t = explode('_',basename($imgs[0]));
				 		$w = explode('-', $t[1]);
				 		$row['colornumber'] = $w[1];
				 	}
				}
				if($row['rowstatus'] != 'd'){
					$total_mass = $total_mass + ($mass/1000*$row['quantity']);
					$total_pdv += $order_itemvalue;
				}
				*/
				array_push($data['items'], $row);
			}
			$query = "UPDATE `b2b_document` SET `status`='o' WHERE status = 'n' AND id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
		}	
		
		$q = "SELECT d.*, dd.customername, dd.customerlastname, dd.customeraddress, dd.customercity, dd.customerzip, dd.customeremail, dd.customerphone, 
						dd.recipientname, dd.recipientlastname, dd.recipientaddress, dd.recipientcity, dd.recipientzip, dd.recipientphone, 
						dd.additionalcomment, p.name AS partnername, p.address AS paddress, p.city AS partnercity, p.zip AS partnerzip, p.code AS partnercode, p.email AS partneremail, IFNULL(padd.objectname,'') AS partneraddressobjectname, IFNULL(padd.address,'') AS partneraddressaddress, IFNULL(padd.city,'') AS partneraddresscity, IFNULL(padd.zip,'') AS partneradddresszip , d.partneraddressid 
				FROM b2b_document d 
				LEFT JOIN b2b_documentdetail AS dd ON d.id=b2b_documentid
				LEFT JOIN partner p ON d.partnerid = p.id 
				LEFT JOIN partneraddress AS padd ON d.partnerid=padd.partnerid AND d.partneraddressid=padd.id
				WHERE d.id = ".$_POST['id'];
		$re = mysqli_query($conn, $q);
		$drow = mysqli_fetch_assoc($re);
		
		$troskovi_dostave = 0;
		// if($drow['warehouseid'] == '9')
		// {
		// 	// SRBIJA
		// 	if($total_pdv>=doubleval($besplatna_dostava)){
		// 		$troskovi_dostave = 0;
		// 	}	
		// }else{
		// 	// BIH + MNE
		// 	if($drow['warehouseid'] == '90') $exchange_rate = $user_conf["exchange_rate_km"][1];
		// 	if($drow['warehouseid'] == '91') $exchange_rate = $user_conf["exchange_rate_eur"][1];
		// 	$pricedata = postexpres_calc($total_mass, $total_pdv*floatval($exchange_rate));
		// 	$troskovi_dostave = $pricedata/$exchange_rate;
		// }
		
		$drow['documentdate'] = date("d.m.Y H:m:s", strtotime($drow['documentdate']) );
		
		$drow['couponamount'] = 0;
		$drow['couponcode'] = 0;
		if($drow['usedcouponid'] != 0 )
		{
			$q = "SELECT uc.couponcode, c.value FROM usercoupon uc 
				LEFT JOIN coupons c ON uc.couponsid = c.id WHERE uc.id = ".$drow['usedcouponid'];
			$cpres = mysqli_query($conn, $q);
			$cprow = mysqli_fetch_assoc($cpres);
			$drow['couponamount'] = $cprow['value'];
			$drow['couponcode'] = $cprow['couponcode'];
		}

		$data['document'] = $drow;
		
		echo json_encode($data);
	}

	

	
	function verifypath(){
		if(file_exists("../../../../".rawurldecode($_POST['path']))){
			echo 1;	
		}
		else{
			echo 0;	
		}
	}
	function getLanguagesList(){
		global $conn;
		$data = array();
		
		$query = "SELECT * FROM languages";
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id"=>$row['id'], "name"=>$row['name'], "default"=>$row['default']));		
		}
		
		echo json_encode($data);
	}

	function updateItemAmount(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `b2b_documentitemattr` SET `quantity`='".mysqli_real_escape_string($conn, $_POST['amount'])."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);
			
			$query = "UPDATE `b2b_documentitem` SET `quantity`= 
						(SELECT SUM(quantity) FROM b2b_documentitemattr WHERE b2b_documentitemid = 
						(SELECT b2b_documentitemid FROM b2b_documentitemattr WHERE id = ".$_POST['id'].")  AND status = 'a') 
					WHERE id = (SELECT b2b_documentitemid FROM b2b_documentitemattr WHERE id = ".$_POST['id']." )";
			mysqli_query($conn, $query);
				
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change quantity");
		}
	}
	
	function deleteOrderItem(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `b2b_documentitemattr` SET `status`='d' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);
			
			$query = "UPDATE `b2b_documentitem` SET `quantity`= 
						(SELECT SUM(quantity) FROM b2b_documentitemattr WHERE b2b_documentitemid = 
						(SELECT b2b_documentitemid FROM b2b_documentitemattr WHERE id = ".$_POST['id'].") AND status = 'a')
					WHERE id = (SELECT b2b_documentitemid FROM b2b_documentitemattr WHERE id = ".$_POST['id']." )";
			mysqli_query($conn, $query);
				
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change quantity");
		}	
	}
	
	function get_order_b2b_product(){
		//include $_SERVER['DOCUMENT_ROOT']."/configs/global_conf.php";
		global $conn;		
		
		$q = "SELECT p.name, p.id, p.rebate, p.additionalrebate, ab.value, t.value as taxvalue, pw.price FROM product p 
				LEFT JOIN attr_boja ab ON p.productid = ab.productid
				LEFT JOIN productwarehouse pw ON p.productid = pw.productid
				LEFT JOIN tax t ON p.taxid = t.taxid
				WHERE p.code = '".$_POST['code']."' AND pw.warehouseid = (SELECT warehouseid FROM b2cdocument WHERE id = '".$_POST['docid']."')";
		$re = mysqli_query($conn, $q);
		$data = array();
		$data['color'] = array();
		if(mysqli_num_rows($re) > 0){
			
			$row = mysqli_fetch_assoc($re);
			$data['name'] = $row['name'];
			$data['productid'] = $row['productid'];
			$data['rebate'] = 100-(((100-$row['rebate'])*0.01)*((100-$row['additionalrebate'])*0.01)*((100-intval($web_global_rebate))*0.01))*100;
			$data['price'] = $row['price'];
			$data['tax'] = $row['taxvalue'];
			$a = explode(',', $row['value']);
			foreach($a as $key=>$val){
				array_push($data['color'], trim($val));
			}
			echo json_encode($data);
		}	
	}	
	// function get_order_b2b_product_sizes(){
	// 	global $conn;		
		
	// 	$q = "SELECT SUM(amount) as tamount, velicinaid FROM productshop WHERE productid = ".$_POST['productid']." AND bojaid = '".$_POST['color']."' GROUP BY velicinaid HAVING tamount > 0 ";
	// 	$re = mysqli_query($conn, $q);
	// 	$data = array();
	// 	if(mysqli_num_rows($re) > 0){
	// 		while($row = mysqli_fetch_assoc($re)){
	// 			array_push($data, $row['velicinaid']);
	// 		}
	// 		echo json_encode($data);
	// 	}	
	// }
	
	function add_New_Item_To_Order(){
		global $conn;
		
		$q = "SELECT p.id AS `productid`, p.name, p.rebate, t.taxid, t.value as taxvalue, pw.price, pd.mass FROM product p 
				LEFT JOIN productdetail pd ON p.productid = pd.productid
				LEFT JOIN productwarehouse pw ON p.productid = pw.productid
				LEFT JOIN tax t ON p.taxid = t.taxid
				WHERE p.code = '".$_POST['code']."' AND pw.warehouseid = (SELECT warehouseid FROM b2cdocument WHERE id = '".$_POST['docid']."')";
				
		$re = mysqli_query($conn, $q);
		if(mysqli_num_rows($re) > 0){
			$row = mysqli_fetch_assoc($re);
			
			
			$query = "INSERT INTO `b2b_documentitem`(`rebate`, `rebatetype`, `b2b_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `ts`) VALUES (   
							'".mysqli_real_escape_string($conn, $row['rebate'])."',
							'T', 
							'".mysqli_real_escape_string($conn, $_POST['docid'])."',
							'".mysqli_real_escape_string($conn, $row['price'])."',  
							'0',
							'".mysqli_real_escape_string($conn, $row['price']*((100-$row['rebate'])*0.01))."', 
							'".mysqli_real_escape_string($conn, $row['productid'])."',
							'".mysqli_real_escape_string($conn, $row["name"])."', 
							'".mysqli_real_escape_string($conn, $_POST['amount'])."', 
							1, 
							'".mysqli_real_escape_string($conn, $row["taxvalue"])."', 
							'".mysqli_real_escape_string($conn, $row["taxid"])."', 
							CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE quantity = quantity+".mysqli_real_escape_string($conn, $_POST['amount']);
							 
			mysqli_query($conn, $query);
			$documentitemid = mysqli_insert_id($conn);
			
			$q = "UPDATE `b2b_documentitem` SET itemvalue = quantity*price*((100-rebate)*0.01) WHERE id = ".$documentitemid;
			mysqli_query($conn, $q);
			
			
			$data = array();
			$data['mass'] = $row["mass"];
			$data['boja'] = $_POST['color'];
			$data['veličina'] = $_POST['size'];
			
			
			$query = "INSERT INTO `b2b_documentitemattr` ( `b2b_documentitemid`, `quantity`, `orgquantity`, `attrvalue`, `addedby`, `ts`) 
				VALUES ( ".mysqli_real_escape_string($conn, $documentitemid).", 
						'".mysqli_real_escape_string($conn, $_POST['amount'])."',
						'".mysqli_real_escape_string($conn, $_POST['amount'])."', 
						'".mysqli_real_escape_string($conn, json_encode($data))."', 
						'a',
						CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE quantity = quantity+".mysqli_real_escape_string($conn, $_POST['amount']);
			mysqli_query($conn, $query);
			echo json_encode(array('1'));
		}	
	}
	
	function accept_order(){
		global $conn, $user_conf;
		include_once 'email.php';
				
		$q = "SELECT d.*, dd.customeremail AS email, dd.customername FROM b2b_document d
			LEFT JOIN b2b_documentdetail AS dd ON d.id = dd.b2b_documentid
			WHERE d.id = ".$_POST['id'];
		$dres = mysqli_query($conn, $q);
		$drow = mysqli_fetch_assoc($dres);
		
		/*	prihvacena cela	*/	
		$q = "UPDATE b2b_document SET status = 'f' WHERE id = ".$_POST['id'];	
		if(mysqli_query($conn, $q)){
			$message = get_b2b_header("3", array('name'=>$drow['customername'])).get_b2b_info($_POST['id']).get_b2b_items($_POST['id']).get_b2b_footer();
			send_b2b_email($drow['email'], $user_conf['autoemail'][1], 'Prihvaćena porudžbina', $message);
		}
		
	}
	
	function decline_order(){
		global $conn, $user_conf;
		
		$q = "UPDATE b2b_document SET status = 'd' WHERE id = ".$_POST['id'];	

		if(mysqli_query($conn, $q)){
			include_once 'email.php';
			
			$q = "SELECT d.*, dd.customeremail AS email, dd.customername 
				FROM b2b_document d
				LEFT JOIN b2b_documentdetail AS dd ON d.id=dd.b2b_documentid
				WHERE d.id = ".$_POST['id'];
				//echo $q;
			$dres = mysqli_query($conn, $q);
			$drow = mysqli_fetch_assoc($dres);
			if($drow['usedcouponid'] != '0'){
				$q = "UPDATE usercoupon SET status = 'n' WHERE id = ".$drow['usedcouponid'];
				if(mysqli_query($conn, $q)){
					$q = "UPDATE b2cdocument SET usedcouponid = 0 WHERE id = ".$drow['id'];
					mysqli_query($conn, $q);
				}
			}
			$message = get_b2b_header("6", array('name'=>$drow['customername'])).get_b2b_info($_POST['id']).get_b2b_items($_POST['id']).get_b2b_footer();
			send_b2b_email($drow['email'], $user_conf['autoemail'][1], 'Odbijena porudžbina', $message);
			
			/*	send decline email	*/	
		}
	}
	
	function send_Delivery_Code_Email(){
		include_once 'email.php';
		global $conn, $user_conf;
		
		$q = "SELECT payment, bankstatus, status FROM b2b_document d WHERE number = '".mysqli_real_escape_string($conn, $_POST['number'])."'";
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);

		if($row['payment'] == 'k' && $row['status'] == 'p' && $row['bankstatus'] == 'post'){ 
			$q = "UPDATE b2b_document SET deliverycode = '".mysqli_real_escape_string($conn, $_POST['code'])."'  , admitiondocumentdate = now()  WHERE number = '".mysqli_real_escape_string($conn, $_POST['number'])."' ";
		}else{
			$q = "UPDATE b2b_document SET status = 's', deliverycode = '".mysqli_real_escape_string($conn, $_POST['code'])."'  , admitiondocumentdate = now()  WHERE number = '".mysqli_real_escape_string($conn, $_POST['number'])."' ";
		}
		if(mysqli_query($conn, $q)){
			$q = "SELECT d.*, dd.customeremail AS email 
				FROM b2b_document d
				LEFT JOIN b2b_documentdetail AS dd ON d.id=dd.b2b_documentid
				WHERE d.number = '".$_POST['number']."'";
			$dres = mysqli_query($conn, $q);
			$drow = mysqli_fetch_assoc($dres);
			$message = get_b2b_header("5", array('name'=>$drow['customername'], 'tracknumber'=>$_POST['code'], 'country'=>$drow['documentcurrency'])).get_b2b_info($drow['id']).get_b2b_items($drow['id']).get_b2b_footer();
			send_b2b_email($drow['email'], $user_conf['autoemail'][1], 'Poslata porudžbina', $message, $drow['id']);
			echo 1;
		}		
	}
	
	function confirm_Payment(){
		include_once 'email.php';
		include_once 'coupon.php';
		global $conn, $user_conf;
		
		$q = "UPDATE b2b_document SET status = 'p' WHERE number = '".mysqli_real_escape_string($conn, $_POST['number'])."' ";
		if(mysqli_query($conn, $q)){	
			/*$q = "SELECT d.*, dd.customeremail AS email 
				FROM b2b_document d
				LEFT JOIN b2b_documentdetail AS dd ON d.id=dd.b2b_documentid
				WHERE d.number = '".$_POST['number']."'";
			$dres = mysqli_query($conn, $q);
			$drow = mysqli_fetch_assoc($dres);
			
			$coupondata = generate_coupon($drow['id']);
			
			if(intval($coupondata[0]) > 0){
				
				$q = "UPDATE b2b_document SET couponid = ".$coupondata[0]." WHERE number = '".mysqli_real_escape_string($conn, $_POST['number'])."' ";
				mysqli_query($conn, $q);
				
				$q = "SELECT c.value FROM usercoupon uc 
						LEFT JOIN coupons c ON uc.couponsid = c.id
						WHERE uc.couponcode = '".$coupondata[1]."'";
				$cres = mysqli_query($conn, $q);
				$crow = mysqli_fetch_assoc($cres);
				
				$message = get_b2b_header("7", array('image'=>'vaucer'.$crow['value'].'.jpg', 'couponcode'=>$coupondata[1], "couponvalue"=>$crow['value'], "valute"=>strtoupper($drow['documentcurrency']))).get_b2b_footer();
				send_b2b_email($drow['email'], $user_conf['autoemail'][1], 'Online vaučer', $message);
				
			}
			*/
			echo 1;
		}
	}


	function bank_command(){
		
		global $conn;
		if(isset($_POST['type'])){
			$continnue = false;
			if($_POST['type'] == 'postauthOrder'){
				$xml = "<CC5Request>
							<Name>katrinapi</Name>
							<Password>R83v#5K8123456</Password>
							<ClientId>13IN060452</ClientId>
							<Type>PostAuth</Type>
							<OrderId>".$_POST['oid']."</OrderId>
							<Total>".$_POST['total']."</Total>
							<Currency>941</Currency>
						</CC5Request>";
						$continnue = true;	
			}
			elseif($_POST['type'] == 'refundOrder'){
				$xml = "<CC5Request>
							<Name>katrinapi</Name>
							<Password>R83v#5K8123456</Password>
							<ClientId>13IN060452</ClientId>
							<Type>Credit</Type>
							<OrderId>".$_POST['oid']."</OrderId>
							<Total>".$_POST['total']."</Total>
							<Currency>941</Currency>
						</CC5Request>";
						$continnue = true;
			}
			elseif($_POST['type'] == 'cancelOrder'){
				$xml = "<CC5Request>
							<Name>katrinapi</Name>
							<Password>R83v#5K8123456</Password>
							<ClientId>13IN060452</ClientId>
							<Type>Void</Type>
							<OrderId>".$_POST['oid']."</OrderId>
							<Total>".$_POST['total']."</Total>
							<Currency>941</Currency>
						</CC5Request>";
						$continnue = true;
			}
			elseif($_POST['type'] == 'orderStatusQuery'){
				$xml = "<CC5Request>
							<Name>katrinapi</Name>
							<Password>R83v#5K8123456</Password>
							<ClientId>13IN060452</ClientId>
							<OrderId>".$_POST['oid']."</OrderId>
							<Extra>
								<ORDERSTATUS>QUERY</ORDERSTATUS>
							</Extra>
						</CC5Request>";
						$continnue = true;
			}
			
			$oldPOST = $_POST;
			if($_POST['type'] == 'postauthOrder'){
					$q = "UPDATE `b2b_document` SET status = 'p', `bankstatus`= 'post' WHERE number = '".mysqli_real_escape_string($conn, $_POST['oid'])."'";	
					mysqli_query($conn, $q);
				}
				elseif($_POST['type'] == 'cancelOrder'){
					$q = "UPDATE `b2b_document` SET status = 'd', `bankstatus`= 'void' WHERE number = '".mysqli_real_escape_string($conn, $_POST['oid'])."'";	
					mysqli_query($conn, $q);
				}
			
			if($continnue){
				
				/*
					BANCA INTESA produkcioni link
					$url = "https://bib.eway2pay.com/fim/api";
				*/
				//$url = "https://testsecurepay.eway2pay.com/fim/api";
				$url = "https://bib.eway2pay.com/fim/api";
				$headers = array(
					"Content-type: application/xml; charset=utf-8",
					"Content-length: " . strlen($xml),
					"Connection: close",
				);
				
				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);	
				
				$data = curl_exec($ch);
				$data = new SimpleXMLElement($data);
				
				if($oldPOST['type'] == 'postauthOrder'){
					$q = "UPDATE `b2b_document` SET status = 'p', `bankstatus`= 'post' WHERE number = '".mysqli_real_escape_string($conn,$oldPOST['oid'])."'";	
					mysqli_query($conn, $q);
				}
				elseif($oldPOST['type'] == 'cancelOrder'){
					$q = "UPDATE `b2b_document` SET status = 'd' `bankstatus`= 'void' WHERE number = '".mysqli_real_escape_string($conn,$oldPOST['oid'])."'";	
					mysqli_query($conn, $q);
				}
				
				echo json_encode($data);
			
				if(curl_errno($ch))
					print curl_error($ch);
				else
					curl_close($ch);
				}
		}
	}
	
	function get_prodavnica_data(){
		global $conn;
		
		$data = array();
		$q = "SELECT ps.*, s.showname FROM productshop ps
				LEFT JOIN shops s ON ps.shopid = s.shopsid
				WHERE ps.productid = ".$_POST['productid']." AND ps.bojaid = '".$_POST['boja']."' AND ps.velicinaid = '".$_POST['velicina']."' ORDER BY s.sort";
		$res = mysqli_query($conn, $q);
		while($row = mysqli_fetch_assoc($res))
		{
			array_push($data, $row);
		}
		
		echo json_encode($data);
	}
	
	function add_internal_comment(){
		global $conn;
		$q = "UPDATE b2b_documentdetail SET additionalcomment = '".mysqli_real_escape_string($conn, $_POST['value'])."' WHERE b2b_documentid = ".$_POST['orderid'];	
		if(mysqli_query($conn, $q))
		{
			echo 0;	
		}else{
			echo 1;	
		}
	}

?>