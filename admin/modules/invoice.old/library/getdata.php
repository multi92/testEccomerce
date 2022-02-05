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
	$aColumns = array(  'id', 'link', 'showname', 'delovodni', 'zavodjenjedatum' );
	
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
		$sOrder = "ORDER BY ";
		for ( $i=0 ; $i< sizeof($_POST['order']) ; $i++ )
		{
			if ( $_POST['columns'][$i]['orderable'] == "true" )
			{
				$sort='';
				if($_POST['order'][$i]['dir']=='asc'){
					$sort='desc';
				}
				if($_POST['order'][$i]['dir']=='desc'){
					$sort='asc';
				}
				$sOrder .= $aColumns[$i]." ".mysqli_real_escape_string($conn, $sort ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	} 
	
	//echo $sOrder;
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
				$sWhere .= "d.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
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
		SELECT SQL_CALC_FOUND_ROWS d.id, 
		                           d.documentdate, 
								   d.valutedate, 
								   d.number, 
								   IF(d.status='p','Proknjižen','Neproknjižen') AS status, 
								   d.documenttype,
								   IF(u.type='partner','Partner',IF(u.type='user','Korisnik',IF(u.type='admin','Administrator',''))) AS `usertype`,
								   IF(u.type='partner',p.name,IF(u.type='user',CONCAT(u.name,' ',u.surname ),IF(u.type='admin',CONCAT('Administrator',' - ',CONCAT(u.name,' ',u.surname )),CONCAT(u.name,' ',u.surname )))) AS `partneruser`,
								   IF(d.documentid=0 OR d.documentid IS NULL,'Ne', 'Da' ) AS `syncstatus`, 
								   IF(d.docreturn='y','Da','Ne') AS docreturn, 
								   w.name AS `warehousename`
		FROM   document as d
		LEFT JOIN partner as p ON d.partnerid=p.ID
		LEFT JOIN user AS u ON d.userid=u.ID
		LEFT JOIN warehouse AS w ON d.warehouseid=w.warehouseid
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
		FROM documents
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
		$documenttype='';
		switch($aRow['documenttype'])
		{
		case 'E':
			$documenttype='Rezervacija';
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
		}
		
		//$row[0] = $i++;
		$row[0] = $documenttype;
		$row[1] = $aRow['number'];
		$row[2] = $aRow['documentdate'];
		
		$row[3] = $aRow['valutedate'];
		$row[4] = $aRow['partneruser'];
		$row[5] = $aRow['warehousename'];
		$row[6] = $aRow['docreturn'];
		$row[7] = $aRow['syncstatus'];
		$row[8] = $aRow['status'];
				
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>