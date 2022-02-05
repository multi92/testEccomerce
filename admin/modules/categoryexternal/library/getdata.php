<?php

	include("../../../config/db_config.php");
	session_start();

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 
	 kolone za WHERE
	 */
	$aColumns = array(  'id', 'path' );
	
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
		$sWhere = "WHERE cp2.id IS NULL  ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere .= "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "cp1.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$sWhereConnected = "";		
		if($_POST['connected'] != '0'){
			$sWhereConnected .= " AND cp1.categoryid ";
			if($_POST['connected'] == 'y') $sWhereConnected .= " != 0 ";
			else $sWhereConnected .= " = 0";	
		}
		
		$sWhereSupplier = "";		
		if($_POST['supplier'] != 0){
			$sWhereSupplier .= " AND cp1.supplierid = ".$_POST['supplier'];
		}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	
	$sQuery = "WITH RECURSIVE category_path (id, parentid, name, path, categoryid, supplierid) AS
				(
				  SELECT ce1.id, ce1.parentid, ce1.name, ce1.name as path, ce1.categoryid, ce1.suppliersid
					FROM category_external ce1
					WHERE ce1.parentid = 0
				  UNION ALL
				  SELECT c.id, c.parentid, c.name, CONCAT(cp.path, ' > ', c.name), c.categoryid, c.suppliersid 
					FROM category_path AS cp 
					JOIN category_external AS c ON cp.id = c.parentid
				)
				SELECT SQL_CALC_FOUND_ROWS cp1.*, s.name as suppliername 
				FROM category_path  cp1 
				LEFT JOIN category_path cp2 ON cp1.id = cp2.parentid
				LEFT JOIN suppliers s ON cp1.supplierid = s.id
				$sWhere 
				$sWhereConnected 
				$sWhereSupplier 
				ORDER BY  s.id, cp1.path 

				$sLimit";
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
		SELECT COUNT(ce1.id)
		FROM  category_external ce1
		LEFT JOIN category_external ce2 ON ce1.id = ce2.parentid
		WHERE ce2.id IS NULL
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
	$q = "WITH RECURSIVE category_path (id, parentid, name, path) AS
				(
                    SELECT ce1.id, ce1.parentid, ce1.name, ce1.name as path
                    FROM category ce1
                    WHERE ce1.parentid = 0 
                    UNION ALL
                    SELECT c.id, c.parentid, c.name, CONCAT(cp.path, ' > ', c.name)
                    FROM category_path AS cp 
                    JOIN category AS c ON cp.id = c.parentid
                )
				SELECT cp1.*
				FROM category_path  cp1 
				LEFT JOIN category_path cp2 ON cp1.id = cp2.parentid
				WHERE cp2.id IS NULL  ORDER BY  cp1.path";
	$res = mysqli_query($conn, $q);
	if(mysqli_num_rows($res) > 0){
		while($laRow = mysqli_fetch_assoc($res)){
			array_push($localattroptions, '<option value="'.$laRow['id'].'">'.$laRow['path'].'</option>');
		}
	}
	$localattrstring = '<select |externalid| class="form-control jq_localCategorySelect"><option value="0"> --- izaberite vrednost --- </option>'.implode("", $localattroptions).'</select>';
	
	
	$i = $_POST['start']+1;
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{	
		$row = array();
		$localattrstring_tmp = $localattrstring;
		$localattrstring_tmp = str_replace('|externalid|', ' externalid="'.$aRow['id'].'" ', $localattrstring);
		if($aRow['categoryid'] != "0"){
			$localattrstring_tmp = str_replace('value="'.$aRow['categoryid'].'"', 'value="'.$aRow['categoryid'].'" selected="selected"', $localattrstring_tmp);
		}
		
		$sdTP = $sdTA = 0;
		$sdq = 'SELECT (SELECT COUNT(productid) FROM productcategory_external WHERE categoryid = '.$aRow['id'].' GROUP BY categoryid) as totalproducts,
				(SELECT COUNT(pce.productid) FROM productcategory_external pce 
				LEFT JOIN productwarehouse pw ON pce.productid = pw.productid
				WHERE categoryid = '.$aRow['id'].' AND pw.amount > 0 AND pw.warehouseid = 1 GROUP BY pce.categoryid) as totalproductsavailable ';
				//echo $sdq;
		$sdres = mysqli_query($conn, $sdq);
		if(mysqli_num_rows($sdres) > 0){
			$sdRow = mysqli_fetch_assoc($sdres);
			$sdTA = ($sdRow["totalproductsavailable"] != NULL)? "<b>".$sdRow["totalproductsavailable"]."</b>":'0';
			$sdTP = ($sdRow["totalproducts"] != NULL)? "<b>".$sdRow["totalproducts"]."</b>":'0';
		}
		
		$row[0] = $i++;
		$row[1] = $aRow['suppliername']." >> ".$aRow['path'];
		$row[2] = $sdTP;
		$row[3] = $sdTA;
		$row[4] = $localattrstring_tmp;
		$row[98] = $aRow['categoryid'];	
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>