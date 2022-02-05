<?php

	include("../../../config/db_config.php");
	session_start();

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 
	 kolone za WHERE
	 */
	$aColumns = array(  'uc.id', 'uc.email', 'uc.couponcode', 'uc.createddate', 'uc.usetdate', 'c.value' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	
	
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
	 
	//$aColumns = array(  'id', 'title', 'adddate', 'changedate', 'status', 'newsts' );
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS uc.*, c.value, w.name as warehousename, w.warehousecurrency, (SELECT d1.number FROM b2cdocument AS d1 WHERE d1.couponid=uc.id LIMIT 1) as gennumber, (SELECT d1.number FROM b2cdocument AS d1 WHERE d1.usedcouponid=uc.id ORDER BY id DESC LIMIT 1) as usednumber
		FROM usercoupon as uc
		LEFT JOIN coupons c ON uc.couponsid = c.id
		LEFT JOIN warehouse w ON uc.warehouseid = w.warehouseid
		$sWhere  
		AND uc.couponsid > 0
		$sOrder
		$sLimit
	";
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS uc.*, c.value, 'warehousename', 'warehousecurrency', 'gennumber', 'usednumber'
		FROM usercoupon as uc
		LEFT JOIN coupons c ON uc.couponsid = c.id
		$sWhere  
		AND uc.couponsid > 0
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
		FROM  usercoupon
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
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$row = array();

		$row[0] = $i++;
		$row[1] = $aRow['couponcode'];
		$row[2] = $aRow['value']." ".$aRow['warehousecurrency'];
		$row[3] = $aRow['warehousename'];
		$row[4] = $aRow['email'];
		$row[5] = $aRow['status'];
		$row[6] = date( 'd-m-Y H:i:s', strtotime($aRow['createddate']));
		$row[7] = ($aRow['usetdate'] == '0000-00-00 00:00:00')? '/':date( 'd-m-Y H:i:s', strtotime($aRow['usetdate']));
		
		$row[8] = $aRow['gennumber'];
		$row[9] = $aRow['usednumber'];
		$row[10] = $aRow['type'];
				
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>