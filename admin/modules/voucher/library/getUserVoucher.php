<?php

	include("../../../config/db_config.php");
	session_start();

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 
	 kolone za WHERE
	 */
	$aColumns = array(  'uv.`id`', 'u.`email`', 'uv.`vouchercode`', 'uv.`status`','uv.`createddate`');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "uv.id";
	
	
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
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,  $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	 
	//$aColumns = id, email, vouchercode , type, status, createddate 
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS uv.*, u.name, u.surname, u.phone, u.email,IF(LEFT(uv.useddate,4)='0000',0,1) AS `useddateflag`
		FROM user_voucher as uv
		INNER JOIN user AS u ON uv.`userid`=u.`id`
		$sWhere  
		$sOrder
		$sLimit
	";
	/*$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS uc.*, c.value, 'warehousename', 'warehousecurrency', 'gennumber', 'usednumber'
		FROM usercoupon as uc
		LEFT JOIN coupons c ON uc.couponsid = c.id
		$sWhere  
		AND uc.couponsid > 0
		$sOrder
		$sLimit
	";*/
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
		FROM  user_voucher AS uv 
	";
	$rResultTotal = mysqli_query($conn,  $sQuery ) or die(mysqli_error());
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_POST['draw']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	$i = $_POST['start']+1;
	while ( $aRow = mysqli_fetch_array( $rResult ) ){

		$voucher_status = '';
		switch ($aRow['status']) {
	 		   case 'a':
	 		       $voucher_status = "Vaucer je aktivan";
	 		       break;
	 		   case 'n':
	 		       $voucher_status = "Vaucer nije aktivan";
	 		       break;
		}
		/*$del=0;
		$delquery ="SELECT * FROM user_voucher AS uv WHERE uv.`voucherid` IN (SELECT DISTINCT id FROM voucher WHERE `id`=".$aRow['voucherid']." AND id IS NOT null)";
			$resDel=mysqli_query($conn, $delquery);
			if(mysqli_num_rows($resDel) == 0){
				$del=1;
			}
*/		



		$row = array();
		$row[0] = $i++;
		$row[1] = $aRow['email'];
		$row[2] = $aRow['vouchercode'];
		$row[3] = $voucher_status;
		$row[4] = date( 'd-m-Y H:i:s', strtotime($aRow['createddate']));
		$row[5] = date( 'd-m-Y H:i:s', strtotime($aRow['useddate']));
		$row[6] = $alType;


		$row[97] = $aRow['useddateflag'];
        $row[98] = $aRow['userid'];
		$row[99] = $aRow['id'];
		$output['aaData'][] = $row;

	}

	
	echo json_encode( $output );

?>