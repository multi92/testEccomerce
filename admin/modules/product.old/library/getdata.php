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
	$aColumns = array(  'p.code', 'p.barcode', 'p.name', 'p.manufcode', 'p.type', 'p.status', 'p.sort' );
	$aColumnsSearch = array(  'p.code', 'p.name', 'p.manufcode' );
	
	//$aColumns = array(  'n.id', 'n.title', 'n.adddate', 'n.changedate', 'n.status', 'u.newsts' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "p.id";
	
	
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
			$j = intval($_POST['order'][$i]['column']);
			if ( $_POST['columns'][$j]['orderable'] == "true" )
			{
				$sOrder .= ''.$aColumns[$j]." ".mysqli_real_escape_string($conn, $_POST['order'][$i]['dir'] ) .", ";
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
		
		if ( $_POST['prosearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumnsSearch) ; $i++ )
			{
				$sWhere .= $aColumnsSearch[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['prosearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ') ';
		}
		
		$sWhereActive = "";		
		if($_POST['activey'] != 0 || $_POST['activen'] != 0){
			if($sWhere == "") $sWhereActive = " WHERE ( ";			
			else $sWhereActive = " AND ( ";			
			
			if($_POST['activey'] != 0) ($sWhereActive == ' AND ( ' || $sWhere == "")? $sWhereActive.=" p.active = 'y' ": $sWhereActive .= " OR p.active = 'y' ";
			if($_POST['activen'] != 0) ($sWhereActive == ' AND ( ' || $sWhere == "")? $sWhereActive.=" p.active = 'n' ": $sWhereActive .= " OR p.active = 'n' ";
		
			$sWhereActive .= " ) ";			
		}
		
		$sWhereType = "";		
		if($_POST['type'] != 0){
			if($sWhere == "" && $sWhereActive == "") $sWhereType = " WHERE p.type = '".$_POST['type']."' ";
			else $sWhereActive = " AND p.type = '".$_POST['type']."' ";	
		}
		
		
		$sHavingImage = "";		
		if($_POST['imagey'] != 0 || $_POST['imagen'] != 0){
			$sHavingImage = " HAVING ";			
			
			if($_POST['imagey'] != 0) ($sHavingImage == ' HAVING ')? $sHavingImage.=" pfid IS NOT null ": $sHavingImage .= " OR pfid IS NOT null ";
			if($_POST['imagen'] != 0) ($sHavingImage == ' HAVING ')? $sHavingImage.=" pfid IS null ": $sHavingImage .= " OR pfid IS null ";
		
			//$sHavingImage .= " ) ";			
		}
		
		
	/*
	 * SQL queries
	 * Get data to display
	 */
	 
	 //$aColumns = array(  'id', 'title', 'adddate', 'changedate', 'status', 'newsts' );
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS p.id, p.name AS `nametr`, p.code, p.manufcode, p.barcode, p.active, p.type, p.sort, p.ts, (SELECT productcode FROM productcodecode WHERE productid =  p.id) as productcodeid, pf.id as pfid,
			 ptr.name AS `name`
		FROM product p
		LEFT JOIN product_tr AS ptr ON p.id=ptr.productid AND ptr.langid=1
		LEFT JOIN product_file pf ON p.id = pf.productid AND pf.type = 'img'
		$sWhere  $sWhereActive  $sWhereType
		GROUP BY p.id
		$sHavingImage 
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
		FROM product AS p
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
		switch($aRow['type']){
			case 'r': $aRow['type'] = 'Regularan';break;
			case 'q': $aRow['type'] = 'Na upit';break;
			case 'vp': $aRow['type'] = 'Grupni proizvod';break;
			case 'vpi': $aRow['type'] = 'Član grupnog proizvoda';break;	
			case 'vpi-r': $aRow['type'] = 'Član grupnog proizvoda - Regularan';break;
			case 'vpi-q': $aRow['type'] = 'Član grupnog proizvoda - Na upit';break;	
		}
		$row[0] = $aRow['code'];
		$row[1] = $aRow['barcode'];
		$row[2] = $aRow['name'];
		$row[3] = $aRow['manufcode'];
		$row[4] = $aRow['type'];
		$row[5] = ($aRow['active'] == 'y') ? "aktivan" : "neaktivan";	
		$row[6] = $aRow['sort'];
		$row[7] = $aRow['productcodeid'];
		$row[8] = $aRow['ts'];	
		
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>