<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	
	include("../../../../app/configuration/system.configuration.php");
	include("../../../../".$system_conf["theme_path"][1]."config/user.configuration.php");
	session_start();

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 
	 kolone za WHERE
	 */
	$aColumns = array(  'p.code', 'p.barcode', 'ptr.name', 'p.manufcode', 'p.type', 'p.active', 'p.sort' );//
	
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
		$whereSearch=array();
		
		//$sWhere .= "n.membernumber LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' "  ;
		if(isset($_SESSION['search']['product']['active']) AND $_SESSION['search']['product']['active']!='' AND $_SESSION['search']['product']['active']!='0'){
			array_push($whereSearch, "p.active = '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['active'] )."' ");	
		}
		if(isset($_SESSION['search']['product']['type']) AND $_SESSION['search']['product']['type']!='' AND $_SESSION['search']['product']['type']!='0'){
			array_push($whereSearch, "p.type = '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['type'] )."' ");	
		}
		if(isset($_SESSION['search']['product']['code']) AND $_SESSION['search']['product']['code']!=''){
			array_push($whereSearch, "p.code LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['code'] )."%' ");	
		}
		if(isset($_SESSION['search']['product']['barcode']) AND $_SESSION['search']['product']['barcode']!=''){
			array_push($whereSearch, "p.barcode LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['barcode'] )."%' ");	
		}
		if(isset($_SESSION['search']['product']['name']) AND $_SESSION['search']['product']['name']!=''){
			array_push($whereSearch, "p.name LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['name'] )."%' ");	
			array_push($whereSearch, "ptr.name LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['name'] )."%' ");	
		}
		if(isset($_SESSION['search']['product']['manufcode']) AND $_SESSION['search']['product']['manufcode']!=''){
			array_push($whereSearch, "p.manufcode LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['manufcode'] )."%' ");	
		}
		if(isset($_SESSION['search']['product']['manufname']) AND $_SESSION['search']['product']['manufname']!=''){
			array_push($whereSearch, "p.manufname LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['manufname'] )."%' ");
			array_push($whereSearch, "ptr.manufname LIKE '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['manufname'] )."%' ");		
		}
		if(isset($_SESSION['search']['product']['b2cpricefrom']) AND $_SESSION['search']['product']['b2cpricefrom']!=''){
			array_push($whereSearch, "b2c.price >= ".mysqli_real_escape_string($conn, $_SESSION['search']['product']['b2cpricefrom'] )." ");	
		}
		if(isset($_SESSION['search']['product']['b2cpriceto']) AND $_SESSION['search']['product']['b2cpriceto']!=''){
			array_push($whereSearch, "b2c.price <= ".mysqli_real_escape_string($conn, $_SESSION['search']['product']['b2cpriceto'] )." ");	
		}

		if(isset($_SESSION['search']['product']['b2bpricefrom']) AND $_SESSION['search']['product']['b2bpricefrom']!=''){
			array_push($whereSearch, "b2b.price >= '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['b2bpricefrom'] )."' ");	
		}
		if(isset($_SESSION['search']['product']['b2bpriceto']) AND $_SESSION['search']['product']['b2bpriceto']!=''){
			array_push($whereSearch, "b2b.price <= '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['b2bpriceto'] )."' ");	
		}

		if(isset($_SESSION['search']['product']['amountfrom']) AND $_SESSION['search']['product']['amountfrom']!=''){
			array_push($whereSearch, " (IFNULL(b2c.amount,0)+IFNULL(b2b.amount,0)) >= '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['amountfrom'] )."' ");	
		}
		if(isset($_SESSION['search']['product']['amountto']) AND $_SESSION['search']['product']['amountto']!=''){
			array_push($whereSearch, "(IFNULL(b2c.amount,0)+IFNULL(b2b.amount,0)) <= '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['amountto'] )."' ");	
		}

		if(isset($_SESSION['search']['product']['withimage']) AND $_SESSION['search']['product']['withimage']!='' AND $_SESSION['search']['product']['withimage']!='0'){
			if($_SESSION['search']['product']['withimage']=='y'){
					//LENGTH(getDefaultImage(p.id))=0
				array_push($whereSearch, " LENGTH(getDefaultImage(p.id))>0 ");
			}
			if($_SESSION['search']['product']['withimage']=='n'){
				array_push($whereSearch, " LENGTH(getDefaultImage(p.id))=0 ");
			}
			//array_push($whereSearch, "b2b.price <= '".mysqli_real_escape_string($conn, $_SESSION['search']['product']['b2bpriceto'] )."' ");

		}
		if(isset($_SESSION['search']['product']['withcategory']) AND $_SESSION['search']['product']['withcategory']!='' AND $_SESSION['search']['product']['withcategory']!='0'){
			if($_SESSION['search']['product']['withcategory']=='y'){
				//pc.categoryid IS NOT NULL 
				array_push($whereSearch, " pc.categoryid IS NOT NULL ");
			}
			if($_SESSION['search']['product']['withcategory']=='n'){
				array_push($whereSearch, " pc.categoryid IS NULL ");
			}
			


		}
		if(isset($_SESSION['search']['product']['withextcategory']) AND $_SESSION['search']['product']['withextcategory']!='' AND $_SESSION['search']['product']['withextcategory']!='0'){
			if($_SESSION['search']['product']['withextcategory']=='y'){
				//pc.categoryid IS NOT NULL 
				array_push($whereSearch, " pexc.categoryid IS NOT NULL ");
			}
			if($_SESSION['search']['product']['withextcategory']=='n'){
				array_push($whereSearch, " pexc.categoryid IS NULL ");
			}
			


		}
		
		
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		

		if ( count($whereSearch) > 0 )
		{
			$ssWhere='';
			for ( $i=0 ; $i<count($whereSearch) ; $i++ )
			{
				$ssWhere .= " (".$whereSearch[$i].") AND";
			}

			if($sWhere!='' && strlen($sWhere)>0){
				$sWhere.=' AND ('.substr_replace( $ssWhere, "", -3 ).') ';
				
				//die(); 
			} else {
				$sWhere .="WHERE ".substr_replace( $ssWhere, "", -3 );
			}

		}

		
	/*
	 * SQL queries
	 * Get data to display
	 */
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS p.id, 
								   p.code,
								   p.barcode,
								   p.name AS `name`, 
								   ptr.name AS `nametr`,
								   p.manufcode, 
								   p.manufname, 
								   ptr.manufname AS `manufnametr`, 
								   p.active, 
								   p.type, 
								   p.sort, 
								   p.ts, 
								   (SELECT productcode FROM productcodecode WHERE productid =  p.id) as productcodeid, 
								   pf.id as pfid,
			 					   getDefaultImage(p.id) AS `image`,
			 					   IFNULL(ROUND(b2c.amount,2),' --- ') AS `amount`,
			 					   IFNULL(ROUND(b2c.price,2),' --- ') AS `b2cprice`,
			 					   IFNULL(ROUND(b2b.price,2),' --- ') AS `b2bprice`
		FROM product AS p
		LEFT JOIN product_tr AS ptr ON p.id=ptr.productid 
		LEFT JOIN product_file pf ON p.id = pf.productid AND pf.type = 'img'
		LEFT JOIN productcategory AS pc ON p.id=pc.productid
		LEFT JOIN productcategory_external AS pexc ON p.id=pexc.productid
		LEFT JOIN productwarehouse AS b2c ON p.id=b2c.productid AND b2c.warehouseid=".$user_conf["b2cwh"][1]."
		LEFT JOIN productwarehouse AS b2b ON p.id=b2b.productid AND b2b.warehouseid=".$user_conf["b2bwh"][1]."
		$sWhere  
		GROUP BY p.id
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
		FROM  product AS p
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
		$query = 'SELECT CONCAT(u.name, " ", u.surname) as lastchange, MAX(changedate) as changedate FROM userlogadmin ul
LEFT JOIN user u ON ul.userid = u.id
WHERE ul.id = (SELECT max(id) FROM userlogadmin ul2 WHERE ul2.moduleid = '.$_SESSION['moduleid'].' AND ul2.contentid = '.$aRow['id'].' AND ul2.action = "change")';
	
		$re = mysqli_query($conn, $query);
		$lastrow = mysqli_fetch_assoc($re);
		
		$row = array();
		$image ='';
		if($aRow['image']=='' ){
			$image ='cdn/img/noimg.png';
		} else {
			$image ='../../fajlovi/product/small/'.$aRow['image'];
		}

		$row[0] = $i++;
		$row[1] = $aRow['code'];
		$row[2] = $aRow['barcode'];
		$row[3] = $image;
		$row[4] = $aRow['name'];
		$row[5] = $aRow['manufname'];
		$row[6] = $aRow['type'];
		$row[7] = $aRow['active'];
		$row[8] = $aRow['sort'];
		$row[9] = $aRow['productcodeid'];
		$row[10] = $aRow['amount'];
		$row[11] = $aRow['b2cprice'];
		$row[12] = $aRow['b2bprice'];

		
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );

?>