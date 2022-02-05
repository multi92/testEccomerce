<?php 

	
	function get_order_value($orderid){
		global $conn;

		//include_once $_SERVER['DOCUMENT_ROOT']."/configs/user.configuration.php";
		
		$q = "SELECT d.*, dd.customeremail AS email 
				FROM b2c_document d
				LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
				WHERE d.id = ".$orderid;
		$dres = mysqli_query($conn, $q);
		$drow = mysqli_fetch_assoc($dres);
		
		$q = "SELECT dia.id, dia.quantity, dia.attrvalue, dia.status, di.rebate, di.price, di.productid, di.productname, di.taxvalue 
				FROM b2c_documentitemattr dia
				LEFT JOIN b2c_documentitem di ON dia.b2c_documentitemid = di.id
    			WHERE di.b2c_documentid = ".$orderid;
		$res = mysqli_query($conn, $q);
		
		if(mysqli_num_rows($res) > 0){
			$total_mass = 0;
			$total_no_pdv = 0;
			$total_pdv = 0;
			while($row = mysqli_fetch_assoc($res))
			{
				$attr = json_decode($row['attrvalue']);
				$attr_data = '';
				$color = '';
				$mass = '';
				/*foreach($attr as $key => $val){
					$attr_data .= $key." : ".$val." <br />";
					if($key == 'boja') $color = $val;
					if($key == 'masa') $mass = $val;
				}*/
				
				// single item price
				$price = $row['price']*(1+($row['taxvalue']/100))*(1-($row['rebate']/100));
				$order_itemvalue_nopdv = $row['price']*(1-($row['rebate']/100))*$row['quantity'];
				//*/ SUMMARY CALC	//*/
				
				$order_itemvalue = (((100-$row['rebate'])*0.01)*((100+$row['taxvalue'])*0.01)*$row['price'])*$row['quantity'];
				
				if($row['status'] != 'd'){
					$total_mass = $total_mass + ($mass/1000*$row['quantity']);
					$total_no_pdv += $order_itemvalue_nopdv;
					$total_pdv += $order_itemvalue;
				}				
			}
			
			/*if($drow['warehouseid'] == '9')
			{
				// SRBIJA
				if($total_pdv>=$besplatna_dostava){
					$troskovi_dostave = 0;
				}	
				$total_pdv = $total_pdv + $troskovi_dostave;

			}else{
				// BIH + MNE
				if($drow['warehouseid'] == '90') $exchange_rate = $user_conf["exchange_rate_km"][1];
				if($drow['warehouseid'] == '91') $exchange_rate = $user_conf["exchange_rate_eur"][1];
				$pricedata = postexpres_calc($total_mass, $total_pdv*floatval($exchange_rate));
				$troskovi_dostave = $pricedata/$exchange_rate;
				$total_pdv = $total_pdv + floatval($pricedata/$exchange_rate);
			}	*/
		}
		
		return $total_pdv;
	}
	
	function calc_coupon_value($orderamount, $type){
		$orderamount = floatval($orderamount);
		
		if($type == 'RS')
		{
			if($orderamount > 2500 && $orderamount < 5001){
				return 1;
			}elseif($orderamount > 5000 && $orderamount < 10001){
				return 2;
			}elseif($orderamount > 10000){
				return 3;
			}else{
				return 0;
			}
		}

		if($type == 'BIH')
		{
			if($orderamount > 50 && $orderamount < 100){
				return 8;
			}elseif($orderamount > 100 && $orderamount < 250){
				return 9;
			}elseif($orderamount > 250){
				return 10;
			}else{
				return 0;
			}
		}

		if($type == 'MNE')
		{
			if($orderamount > 25 && $orderamount < 50){
				return 5;
			}elseif($orderamount > 50 && $orderamount < 120){
				return 6;
			}elseif($orderamount > 120){
				return 7;
			}else{
				return 0;
			}
		}

		
	
	}

	function generate_coupon($orderid){
		global $conn;
		$q = "SELECT d.*, uc.couponcode, u.email FROM b2c_document d 
				LEFT JOIN usercoupon uc ON d.couponid = uc.id
				LEFT JOIN user u ON d.partnerid = u.id
				WHERE d.couponid = 0 AND d.id = ".$orderid;
				
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) > 0){
			/*	doesnt have coupon	*/	
			$row = mysqli_fetch_assoc($res);
			
			$cid = calc_coupon_value(get_order_value($orderid), "RS");
			$valute = 'RSD';
			$warehouse = $row['warehouseid'];
			
			if($cid > 0)
			{
				$q = "INSERT INTO `usercoupon`( `email`, `couponsid`, `status`, `createddate`, `warehouseid`) VALUES ( '".mysqli_real_escape_string($conn, $row['email'])."', ".intval($cid).", 'n', NOW(), ".$warehouse.")";	
				$re = mysqli_query($conn, $q);
				
				$lastid = mysqli_insert_id($conn);
				
				$q = "UPDATE `usercoupon` SET `couponcode`= CRC32(MD5(CONCAT('katrin',".$lastid."))) WHERE id = ".$lastid;
				$re = mysqli_query($conn, $q);
				
				$q = "SELECT id, couponcode FROM `usercoupon` WHERE id = ".$lastid;
				$re = mysqli_query($conn, $q);
				$row = mysqli_fetch_assoc($re);
				
				return array($row['id'], $row['couponcode']);
			}
			else{
				return array(0, 0);
			}
		}
		else{
			$row = mysqli_fetch_assoc($res);
			return array($row['id'], $row['couponcode']);
		}
		
		
	}

?>