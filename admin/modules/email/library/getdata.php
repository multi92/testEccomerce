<?php

	include("../../../config/db_config.php");
	session_start();

	//var_dump($_REQUEST);
	
	/*$query = "SELECT ln.*, u.name, u.surname FROM lat_news ln LEFT JOIN user u ON ln.ownerid = ID ";
	$re = mysqli_query($conn, $query);
	if(mysqli_num_rows($re) > 0)
	{
		$newscont = array();
		while($row = mysqli_fetch_assoc($re))
		{
			array_push($newscont, $row);
		}	
	}
	
		*/
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array(  'id', 'title', 'code', 'changedate', 'status' );
	$aColumnsSearch = array(  'email', 'type' );
	
	//$aColumns = array(  'n.id', 'n.title', 'n.adddate', 'n.changedate', 'n.status', 'u.newsts' );
	
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
		if ($_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumnsSearch) ; $i++ )
			{
				$sWhere .= $aColumnsSearch[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['prosearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ' AND parentid = 0)';
		}
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	 
	 //$aColumns = array(  'id', 'title', 'adddate', 'changedate', 'status', 'newsts' );
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS m.id, m.`from`, m.email, m.type, m.status, m.owner, m.createdate, m.changedate, CONCAT(u.name,\" \",u.surname) as uname, u.email as uemail
		FROM  messages m LEFT JOIN user u ON m.owner=u.id 
		$sWhere  
		$sOrder
		$sLimit
	";
	//echo $sQuery;
	
	$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM  lat_product 
	";
	$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
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

		$row[0] = ($aRow['owner'] == 0) ? $aRow['from'] : $aRow['uname'];
		$row[1] = ($aRow['owner'] == 0) ? $aRow['email'] : $aRow['uemail'];
		$row[2] = ($aRow['type'] == "s") ? 'pretraga' : (($aRow['type'] == "a") ? "dostupnost" : "kontakt");
		$row[3] = $aRow['status'];
		$row[4] = $aRow['createdate'];
		$row[5] = $aRow['changedate'];	
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>