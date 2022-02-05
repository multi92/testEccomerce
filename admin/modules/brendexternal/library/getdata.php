<?php

	include("../../../config/db_config.php");
	session_start();

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 
	 kolone za WHERE
	 */
	$aColumns = array(  'id', 'name' );
	
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
		$sWhere = "WHERE be.name != '' ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere .= "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "be.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$sWhereConnected = "";		
		if($_POST['connected'] != '0'){
			$sWhereConnected .= " AND be.brendid ";
			if($_POST['connected'] == 'y') $sWhereConnected .= " != 0 ";
			else $sWhereConnected .= " = 0";	
		}
		
		$sWhereSupplier = "";		
		if($_POST['supplier'] != 0){
			$sWhereSupplier .= " AND be.supplierid = ".$_POST['supplier'];
		}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	 
	 //$aColumns = array(  'id', 'title', 'adddate', 'changedate', 'status', 'newsts' );
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS be.id, be.name, be.brendid, s.name as suppliername
		FROM  brend_external as be
		LEFT JOIN suppliers s ON be.supplierid = s.id
		$sWhere  $sWhereConnected $sWhereSupplier
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
		FROM  brend_external
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
	
	$localattroptions = array();
	$q = "SELECT * FROM brend ORDER BY name ASC";
	$res = mysqli_query($conn, $q);
	if(mysqli_num_rows($res) > 0){
		while($laRow = mysqli_fetch_assoc($res)){
			array_push($localattroptions, '<option value="'.$laRow['id'].'">'.$laRow['name'].'</option>');
		}
	}
	$localattrstring = '<select class="form-control jq_localBrendSelect"><option value="0"> --- izaberite vrednost --- </option>'.implode("", $localattroptions).'</select>';
	
	$i = $_POST['start']+1;
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{	
		$row = array();
		$localattrstring_tmp = $localattrstring;
		if($aRow['brendid'] != "0"){
			$localattrstring_tmp = str_replace('value="'.$aRow['brendid'].'"', 'value="'.$aRow['brendid'].'" selected="selected"', $localattrstring);
		}
		$row[0] = $i++;
		$row[1] = $aRow['suppliername']." >> ".$aRow['name'];
		$row[2] = $localattrstring_tmp;
		$row[3] = '';
		$row[4] = '';
		$row[98] = $aRow['brendid'];	
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>