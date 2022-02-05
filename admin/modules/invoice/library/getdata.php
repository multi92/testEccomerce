<?php
	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);*/

	// function postexpres_calc($mass, $value){
	// 	if($mass < 1) $mprice = 990;
	// 	if($mass >= 1 && $mass < 2) $mprice = 1280;
	// 	if($mass >= 2 && $mass < 5) $mprice = 1790;
	// 	if($mass >= 5 && $mass < 10) $mprice = 2490;
	// 	if($mass >= 10 && $mass < 15) $mprice = 3280;
	// 	if($mass >= 15 && $mass < 20) $mprice = 4090;
	// 	$vprice = round($value/10000, 0, PHP_ROUND_HALF_UP) * 80;
	// 	return $mprice+$vprice;
	// }
	
	include("../../../config/db_config.php");
	session_start();

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 
	 kolone za WHERE
	 */
	$aColumns = array('d.id', 'd.number', 'CONCAT(dd.customername," ",dd.customerlastname) ', 'd.documentdate', 'd.deliverycode', 'u.email', 'd.admitiondocumentdate', 'dd.customeremail');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "d.id";
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
			mysqli_real_escape_string($conn, $_POST['length'] );
	}
	
	//echo $sLimit;
	/*
	 * Ordering
	 */
	 
	 /*	ORDER OVERRIDE	*/
	
	//$sOrder = ' ORDER BY FIELD(d.status,"n","o","f","w","d","s","p")';
	
	
	 
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
	
	$sOrder = ' ORDER BY d.documentdate DESC';
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	 //var_dump($_POST['search']['value']);
		$sWhere = "";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = " WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,  trim($_POST['search']['value']) )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
			//echo $sWhere;
		}
		if($sWhere == '') $sWhere = " WHERE dd.customeremail != '' ";
		else{
			$sWhere .= " AND dd.customeremail != '' ";	
		}
		
	/*	Custom filter START	*/
	$sWhereCustom = ' ';
	if($_POST['filterstatus'] != '')
	{
		$sWhereCustom .= " AND d.status = '".$_POST['filterstatus']."' ";
	}
	if($_POST['filterpayment'] != '')
	{
		$sWhereCustom .= " AND d.payment = '".$_POST['filterpayment']."' ";
	}
	if($_POST['filtercountry'] != '')
	{
		$sWhereCustom .= " AND d.warehouseid = '".$_POST['filtercountry']."' ";
	}
	if($_POST['filtertype'] != '')
	{
		$sWhereCustom .= " AND d.documenttype = '".$_POST['filtertype']."' ";
	}
	/*	Custom filter END	*/
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	 //$aColumns = array(  'id', 'title', 'adddate', 'changedate', 'status', 'newsts' );
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS d.*, TIME_FORMAT(TIMEDIFF(d.timerstart + INTERVAL 1 DAY, NOW()), '%Hh:%im') as timeremaining, dd.customeremail, dd.customername, dd.customerlastname
		FROM b2b_document as d
		LEFT JOIN b2b_documentdetail AS dd ON d.id=dd.b2b_documentid
		LEFT JOIN user u ON d.userid = u.ID
		$sWhere 
		$sWhereCustom  
		$sOrder
		$sLimit
	";
	//echo $sQuery;

	$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query($conn,  $sQuery ) or die(mysqli_error());
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM  b2b_document AS d LEFT JOIN b2b_documentdetail AS dd ON d.id=dd.b2b_documentid
	";
	$rResultTotal = mysqli_query($conn,  $sQuery ) or die(mysqli_error());
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*$q = "SELECT di.price*dia.quantity*(1-(di.rebate*0.01))*(1+(di.taxvalue*0.01)) as totalvalue, c.value, d.documentcurrency, d.warehouseid 
	 	  FROM `b2b_documentitem` di 
	 		LEFT JOIN b2b_documentitemattr dia ON di.id = dia.b2b_documentitemid
	 		LEFT JOIN b2b_document d ON di.b2b_documentid = d.id
	 		LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
	 		LEFT JOIN coupons c ON uc.couponsid = c.id
	 		WHERE d.status = 's' AND dia.status = 'a' GROUP BY d.number";
	$res = mysqli_query($conn, $q);*/
	$totalsentvaluerow = 0;
	// if(mysqli_num_rows($res) > 0)
	// {
		// while($rowtv = mysqli_fetch_assoc($res))
		// {
		// 	if($rowtv['warehouseid'] == '9')
		// 	{
		// 		// SRBIJA
		// 		if($rowtv['totalvalue']>=doubleval($besplatna_dostava)){
		// 			$troskovi_dostave = 0;
		// 		}
		// 	}else{
		// 		// BIH + MNE
		// 		if($rowtv['warehouseid'] == '90') $exchange_rate = $user_conf["exchange_rate_km"][1];
		// 		if($rowtv['warehouseid'] == '91') $exchange_rate = $user_conf["exchange_rate_eur"][1];
		// 		$pricedata = postexpres_calc($total_mass, $rowtv['totalvalue']*floatval($exchange_rate));
		// 		$troskovi_dostave = $pricedata/$exchange_rate;
		// 	}
		// 	$totalsentvaluerow = $totalsentvaluerow + $rowtv['totalvalue']+$troskovi_dostave;
		// }
	// }
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_POST['draw']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array(),
		"totalvalue" => number_format(round($totalsentvaluerow),2)." RSD"
	);
	
	$i = $_POST['start']+1;
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$q = 'SELECT SUM(di.price*dia.quantity*(1-(di.rebate*0.01))*(1+(di.taxvalue*0.01))) as totalvalue, c.value 
		FROM `b2b_documentitem` as di 
		LEFT JOIN b2b_documentitemattr dia ON di.id = dia.b2b_documentitemid
LEFT JOIN b2b_document d ON di.b2b_documentid = d.id
LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
LEFT JOIN coupons c ON uc.couponsid = c.id
WHERE di.b2b_documentid = '.$aRow['id'].' AND dia.status = "a"';

		$res = mysqli_query($conn, $q);
		$valuerow = mysqli_fetch_assoc($res);
				
		
		//include_once $_SERVER['DOCUMENT_ROOT']."/configs/global_conf.php";
		//include_once $_SERVER['DOCUMENT_ROOT']."/configs/user.configuration.php";
		
		// if($aRow['warehouseid'] == '9')
		// {
		// 	// SRBIJA
		// 	if($valuerow['totalvalue']>=doubleval($besplatna_dostava)){
		// 		$troskovi_dostave = 0;
		// 	}
		// }else{
		// 	// BIH + MNE
		// 	if($aRow['warehouseid'] == '90') $exchange_rate = $user_conf["exchange_rate_km"][1];
		// 	if($aRow['warehouseid'] == '91') $exchange_rate = $user_conf["exchange_rate_eur"][1];
		// 	$pricedata = postexpres_calc($total_mass, $total_pdv*floatval($exchange_rate));
		// 	$troskovi_dostave = $pricedata/$exchange_rate;
		// }
		
		
		
		$troskovi_dostave = 0;
		if(substr($aRow['timeremaining'],0,1) == '-' && $aRow['status'] == 'w')
		{
			$q = "UPDATE b2b_document SET status = 'f' WHERE id = ".$aRow['id'];
			mysqli_query($conn, $q);
		}
		
		$documenttype='';
		switch($aRow['documenttype'])
		{
		case 'E':
			$documenttype='Porudžbina';
			break;
		case 'R':
			$documenttype='Račun';
			break;
		case 'H':
			$documenttype='Gotovinski račun';
			break;
		case 'P':
			$documenttype='Predračun';
			break;
		case 'Q':
			$documenttype='Upit';
			break;
		}
		
		$row = array();
		$row[0] = $i++;
		$row[1] = $documenttype.'-'.$aRow['number'];
		$row[2] = number_format($valuerow['totalvalue']+(($valuerow['value'] != NULL)? ($valuerow['value']*(-1)):0) , 2).' '.$aRow['documentcurrency'];
		$row[3] = date('d.m.Y H:i:s', strtotime($aRow['documentdate']));
		if(is_null($aRow['admitiondocumentdate'])){
			$row[4] = '';
		} else {
			$row[4] = date('d.m.Y H:i:s', strtotime($aRow['admitiondocumentdate']));
		}
		$row[5] = $aRow['customeremail'];
		$row[6] = $aRow['customername']." ".$aRow['customerlastname'];
		$row[7] = (($aRow['payment'] == 'k')? "kartica":"pouzeće")." / ".(($aRow['payment'] == 'k')? $aRow['bankstatus']:"");
		$row[8] = $aRow['status'];
		$row[9] = '';
		$row[10] = $aRow['deliverycode'];
		$row[11] = $aRow['payment'];
		$row[12] = $aRow['bankstatus'];
		$row[13] = $aRow['timeremaining'];
		$row[14] = $aRow['warehouseid'];
		
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>