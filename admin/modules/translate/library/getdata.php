<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
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
	$aColumns = array(  'id', 'key', 'value');
	
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
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "t.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	 
	 //$aColumns = array(  'id', 'title', 'adddate', 'changedate', 'status', 'newsts' );
	 
	$selectedcolums = array(); 
	$selectedtables = "";
	foreach($langfull as $val)
	{
		array_push($selectedcolums, " ta".$val[0].".value as val".$val[0]);
		$selectedtables .= " LEFT JOIN (SELECT value, `key` FROM translations WHERE lang_id = (SELECT id FROM languages WHERE short_name = '".$val[0]."') ) as ta".$val[0]." ON t.`key` = ta".$val[0].".`key` ";
	}
	 
	$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS t.id, t.key, ".implode(",", $selectedcolums)."
		FROM  translations as t
		".$selectedtables."
		$sWhere 
		GROUP BY t.`key` 
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
		SELECT COUNT(DISTINCT(".$sIndexColumn."))
		FROM translations 
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
		$query = 'SELECT CONCAT(u.name, " ", u.surname) as lastchange, MAX(changedate) as changedate FROM userlog ul
LEFT JOIN user u ON ul.userid = u.ID
WHERE ul.id = (SELECT max(id) FROM userlog ul2 WHERE ul2.moduleid = '.$_SESSION['moduleid'].' AND ul2.contentid = '.$aRow['id'].' AND ul2.action = "change")';
		$re = mysqli_query($conn, $query);
		$lastrow = mysqli_fetch_assoc($re);
		
		$row = array();

		$row[0] = $i++;
		$row[1] = $aRow['key'];
		
		$i = 2;
		foreach($langfull as $val)
		{
			$row[$i] = $aRow['val'.$val[0]];
			$i++;
		}
		$row[99] = $aRow['id'];
		$row[100] = $i;	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>