<?php
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if (isset($_POST['action']) && $_POST['action'] != "") {
		switch ($_POST['action']) {
			case "delete" : delete(); break;
			case "changestatus" : change_status(); break;
			case "changeexpirationdate" : change_expirationdate(); break;
			case "getitem" : get_item(); break;
			case "saveaddchange" : save_add_change(); break;
			case "getlanguageslist" : getLanguagesList(); break;

			case "getVoucherCategory" : getVoucherCategory(); break;
			case "getVoucherProduct" : getVoucherProduct(); break;

			case "addVoucherCategory" : addVoucherCategory(); break;
			case "addVoucherProduct" : addVoucherProduct(); break;
			case "deleteVoucherCategory" : deleteVoucherCategory(); break;
			case "deleteVoucherProduct" : deleteVoucherProduct(); break;
			
			case "addnewvoucher": add_new_voucher(); break;
			case "checkvoucher": check_voucher(); break;

			case "checkUservoucher": check_User_voucher(); break;
			case "addUserVoucher": add_User_voucher(); break;


			case "getproduct": get_product(); break;
		}
	}

	function generateRandomString($length = 10){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@[]';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
        	$randomString .= $characters[rand(0, $charactersLength - 1)];
   		}
    	return $randomString;
	}



	function addVoucherCategory(){
		global $conn;
		if($_POST['voucherid'] != "")
		{
			echo $_POST;
			$query = "DELETE FROM `voucher_category` WHERE voucherid = ".$_POST['voucherid']." AND categoryid = ".$_POST['categoryid'];
			mysqli_query($conn, $query);

			$query = "INSERT INTO `voucher_category` (`voucherid`,`categoryid`,`value`,`valuetype` ) VALUES( ".$_POST['voucherid'].",".$_POST['categoryid'].",".$_POST['value'].",'".$_POST['valuetype']."')";
			mysqli_query($conn, $query);

		}

	}

	function addVoucherProduct(){
		global $conn;
		if($_POST['voucherid'] != "")
		{
			$query = "DELETE FROM `voucher_product` AS vp WHERE vp.voucherid = ".$_POST['voucherid']." AND vp.productid = ".$_POST['productid'];
			mysqli_query($conn, $query);

			$query = "INSERT INTO `voucher_product` (`voucherid`,`productid`,`value`,`valuetype` ) VALUES( ".$_POST['voucherid'].",".$_POST['productid'].",".$_POST['value'].",'".$_POST['valuetype']."')";
			mysqli_query($conn, $query);
		}

	}
	function deleteVoucherCategory(){
		global $conn;
		if($_POST['voucherid'] != "" && $_POST['categoryid'] != "")
		{
			$query = "DELETE FROM `voucher_category` WHERE voucherid = ".$_POST['voucherid']." AND categoryid = ".$_POST['categoryid'];
			mysqli_query($conn, $query);
		}
	}

	function deleteVoucherProduct(){
		global $conn;
		if($_POST['voucherid'] != "" && $_POST['productid'] != "")
		{
			$query = "DELETE FROM `voucher_product` WHERE voucherid = ".$_POST['voucherid']." AND productid = ".$_POST['productid'];
			echo ($query);
			mysqli_query($conn, $query);
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query ="SELECT * FROM voucher WHERE id IN (SELECT DISTINCT voucherid FROM b2c_document WHERE voucherid!=0 AND voucherid IS NOT null)";
			$res=mysqli_query($conn, $query);
			if(mysqli_num_rows($res) == 0){
				$query = "DELETE FROM `voucher` WHERE id = ".$_POST['id'];
				mysqli_query($conn, $query);
				$query = "DELETE FROM `voucher_category` WHERE voucherid = ".$_POST['id'];
				mysqli_query($conn, $query);
				$query = "DELETE FROM `voucher_product` WHERE voucherid = ".$_POST['id'];
				mysqli_query($conn, $query);
							
				userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
			}
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `voucher` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}


	function change_expirationdate(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `voucher` SET `expirationdate`='".$_POST['expirationdate']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM voucher AS v WHERE v.id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		$row['expirationdate']=date( 'd.m.Y', strtotime($row['expirationdate']));   //H:i:s
        echo json_encode($row);
	}

	function getVoucherCategory(){
		global $conn, $system_conf, $user_conf;

		$aColumns = array(  'vc.voucherid', 'vc.categoryid', 'c.name');//
		$sIndexColumn = "vc.categoryid";


		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		
		
		/*
		 * Ordering
		 */
		if ( isset( $_POST['order'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i< sizeof($_POST['order']) ; $i++ )
			{
				if ( $_POST['columns'][$i]['orderable'] == "true" )
				{
					$sOrder .= $aColumns[$i]." ".mysqli_real_escape_string($conn, $_POST['order'][$i]['dir'] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS vc.*, 
											  c.name AS `categoryname` ,
											  getCategoryPath(c.id) AS `categorypath` 
						FROM `voucher_category` AS vc 
						LEFT JOIN category AS c ON vc.categoryid=c.id
						WHERE vc.voucherid=".$_POST["voucherid"]."  
					$sWhere 
					GROUP BY vc.voucherid, vc.categoryid
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(vc.categoryid) FROM `voucher_category` AS vc WHERE vc.voucherid=".$_POST["voucherid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		$i = $_POST['start']+1;
		while ( $aRow = mysqli_fetch_array( $rResult ) )
		{
			$row = array();
			$row[0] = $i++;
			$row[1] = $aRow['categoryname'];
			$row[2] = $aRow['categorypath'];
			$row[3] = $aRow['value'];
			$voucherValueType = '';
			switch ($aRow['valuetype']) {
	 		   case 'P':
	 		       $voucherValueType = "Popust izrazen u procentima";
	 		       break;
	 		   case 'T':
	 		       $voucherValueType = "Totalni popust";
	 		       break;
	 		   case 'I':
	 		       $voucherValueType = "Individualni popust";
	 		       break;
			}
			$row[4] = $voucherValueType;
			
			
			$row[98] = $aRow['categoryid'];	
			$row[99] = $aRow['voucherid'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	function getVoucherProduct(){
		global $conn, $system_conf, $user_conf;

		$aColumns = array(  'vp.voucherid', 'vp.productid', 'p.name', 'c.name');//
		$sIndexColumn = "vp.voucherid";


		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		
		
		/*
		 * Ordering
		 */
		if ( isset( $_POST['order'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i< sizeof($_POST['order']) ; $i++ )
			{
				if ( $_POST['columns'][$i]['orderable'] == "true" )
				{
					$sOrder .= $aColumns[$i]." ".mysqli_real_escape_string($conn, $_POST['order'][$i]['dir'] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS vp.*, 
											  p.name AS `productname` ,
											  c.name AS `categoryname`,
											  p.code AS `productcode`,
											  p.barcode AS `productbarcode`,
											   getCategoryPath(c.id) AS `categorypath` 
						FROM `voucher_product` AS vp 
						LEFT JOIN `product` AS p ON vp.productid=p.id 
						LEFT JOIN `productcategory` AS pc on vp.productid=pc.productid
						LEFT JOIN `category` AS c ON pc.categoryid=c.id
						WHERE vp.voucherid=".$_POST["voucherid"]."  
					$sWhere 
					GROUP BY vp.voucherid, vp.productid
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(vp.productid) FROM `voucher_product` AS vp WHERE vp.voucherid=".$_POST["voucherid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		$i = $_POST['start']+1;
		while ( $aRow = mysqli_fetch_array( $rResult ) )
		{
			$row = array();
			$row[0] = $i++;
			$row[1] = $aRow['productcode'];
			$row[2] = $aRow['productbarcode'];
			$row[3] = $aRow['productname'];
			$row[4] = $aRow['categoryname'];
			$row[5] = $aRow['categorypath'];
			$voucherValueType = '';
			switch ($aRow['valuetype']) {
	 		   case 'P':
	 		       $voucherValueType = "Popust izrazen u procentima";
	 		       break;
	 		   case 'T':
	 		       $voucherValueType = "Totalni popust";
	 		       break;
	 		   case 'I':
	 		       $voucherValueType = "Individualni popust";
	 		       break;
			}
			$row[6] = $voucherValueType;
			$row[7] = $aRow['value'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['voucherid'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		
		$query = "INSERT INTO `voucher`(`id`, `name`, `value`, `vouchertype`, `valuetype`, `applyonproductwithrebate`, `image`, `type`, `expirationdate`, `status`, `ts`)  VALUES (
		'".$_POST['id']."', 
		'".mysqli_real_escape_string($conn, $_POST['name'])."', 
		 ".mysqli_real_escape_string($conn, $_POST['value']).",
		'".mysqli_real_escape_string($conn, ($_POST['newvoucherquantitydiscount']))."',
		'".mysqli_real_escape_string($conn, ($_POST['newvouchertypediscount']))."',
		'".mysqli_real_escape_string($conn, ($_POST['newapplyonproductwithrebate']))."', 
		'".mysqli_real_escape_string($conn, $_POST['image'])."', 
		'".mysqli_real_escape_string($conn, $_POST['type'])."', 
		'".mysqli_real_escape_string($conn,  date("Y-m-d", strtotime($_POST['expirationdate'])))."', 
		'".mysqli_real_escape_string($conn, $_POST['status'])."',		 
		CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
					`name` = '".mysqli_real_escape_string($conn, $_POST['name'])."' , 
					`value` = ".mysqli_real_escape_string($conn, $_POST['value']).", 
					`image` = '".mysqli_real_escape_string($conn, $_POST['image'])."' ,  
					`expirationdate` = '".mysqli_real_escape_string($conn,  date("Y-m-d", strtotime($_POST['expirationdate'])))."',  
					`ts` = CURRENT_TIMESTAMP
					";
		//echo 	$query;			
		mysqli_query($conn, $query);
		
		echo json_encode(array($err));
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
	
	
	

	
	function add_new_voucher(){
		global $conn;
		if( $_POST['newname'] != "" && $_POST['newwarehouseid'] > 0 && $_POST['newtype'] != "" && $_POST['newexpirationdate'] != "" && $_POST['newvoucherquantitydiscount'] != "" && $_POST['newvouchertypediscount'] != "" && $_POST['newapplyonproductwithrebate'] != "")
		{
			$q = "INSERT INTO `voucher`( `name`, `type`, `vouchertype`, `valuetype`, `applyonproductwithrebate`, `expirationdate`, `warehouseid`, `status`) 
							VALUES ( '".mysqli_real_escape_string($conn, ($_POST['newname']))."',
							         '".mysqli_real_escape_string($conn, ($_POST['newtype']))."',
							         '".mysqli_real_escape_string($conn, ($_POST['newvoucherquantitydiscount']))."',
							         '".mysqli_real_escape_string($conn, ($_POST['newvouchertypediscount']))."',
							         '".mysqli_real_escape_string($conn, ($_POST['newapplyonproductwithrebate']))."',
							         '".mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['newexpirationdate'])))."',
									 ".mysqli_real_escape_string($conn, ($_POST['newwarehouseid'])).",
							         'n'
							     )";  

						     
			$r = mysqli_query($conn, $q);	

			$voucherid=0;
			$voucherid = mysqli_insert_id($conn);
			
			if($voucherid==0){

				echo 0;		
			} else {
				echo 1;
			}
			
		}
	}

	function check_voucher(){
		global $conn;
		$q="SELECT * FROM voucher WHERE name='".$_POST['voucher']."'";
		$r = mysqli_query($conn, $q);
		if(mysqli_num_rows($r)>0){
			echo 1;
		}else{
			echo 0;
		}		
	}

	function check_User_voucher(){
		global $conn;
		$q="SELECT * FROM user_voucher WHERE userid=".$_POST['userid']." AND voucherid=".$_POST['voucherid']." AND LEFT(useddate,4)='0000' ";
		
		$r = mysqli_query($conn, $q);
		if(mysqli_num_rows($r)>0){
			echo 0;
		}else{
			echo 1;
			
		}
	}

	

	function add_User_voucher(){
		global $conn;
		if( $_POST['userid'] != "" && $_POST['voucherid'] != "" )
		{
				//if(self::check_AddUser_voucher($_POST['userid'],$_POST['voucherid'])==0){
					$q = "INSERT INTO `user_voucher`( `userid`, `voucherid`, `vouchercode`, `status`, `createddate`, `warehouseid`) 
									VALUES ( '".mysqli_real_escape_string($conn, ($_POST['userid']))."',
									         '".mysqli_real_escape_string($conn, ($_POST['voucherid']))."',
									         '".mysqli_real_escape_string($conn, (generateRandomString(10)))."',
									         'a',
									         '".mysqli_real_escape_string($conn, date("Y-m-d", date()))."',
									         1
									     )";  
		
									     
						$r = mysqli_query($conn, $q);	
		
						$uservoucherid=0;
						$uservoucherid = mysqli_insert_id($conn);
						
						if($uservoucherid==0){
		
							echo 0;		
						} else {
							echo 1;
					}
			//}
			/*else{
				echo 0;
			}*/
			
		}

	}	

	

	function get_product(){
		global $conn;
		$q="SELECT p.* FROM product AS p WHERE p.code!='' AND p.active='y' AND (p.name LIKE '".$_POST['searchval']."'%' OR p.code LIKE '".$_POST['searchval']."'%' OR p.barcode LIKE '".$_POST['searchval']."'%') ORDER BY code ASC";
		//echo $q;
		$res = mysqli_query($conn, $q);

		$pdata=array();
		while($row = mysqli_fetch_assoc($res)){
			array_push($pdata, array("id"=>$row['id'], "name"=>$row['code']." | ".$row['barcode']." | ".$row['name']));		
		}
		echo json_encode($pdata);
	}
?>