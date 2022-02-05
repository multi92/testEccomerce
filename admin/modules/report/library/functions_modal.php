<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");


	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "filterpartnermodal": filter_partner_modal(); break;
			case "clearfilterpartnermodal": clear_filter_partner_modal(); break;
			case "getpartnertype": get_partner_type(); break;
			case "getusergroup": get_user_group(); break;
		}
	}

	
	function filter_partner_modal(){
		global $conn;
		//$tabledata = array();
		//var_dump($_POST['filterPartnerName']);
		//die();
		$sIndexColumn = "id";

		$whereCondition="";
		if(isset($_SESSION["filterPartnerModal"])){
			unset($_SESSION["filterPartnerModal"]);	
		}
		$_SESSION["filterPartnerModal"]=array();
		$_SESSION["filterPartnerModal"]['filterPartnerName']=$_POST['filterPartnerName'];
		$_SESSION["filterPartnerModal"]['filterPartnerCode']=$_POST['filterPartnerCode'];
		$_SESSION["filterPartnerModal"]['filterPartnerType']=$_POST['filterPartnerType'];
		$_SESSION["filterPartnerModal"]['filterPartnerNumber']=$_POST['filterPartnerNumber'];
		$_SESSION["filterPartnerModal"]['filterPartnerCity']=$_POST['filterPartnerCity'];
		$_SESSION["filterPartnerModal"]['filterPartnerZip']=$_POST['filterPartnerZip'];
		$_SESSION["filterPartnerModal"]['filterPartnerActive']=$_POST['filterPartnerActive'];
		$_SESSION["filterPartnerModal"]['filterResponsiblePersonName']=$_POST['filterResponsiblePersonName'];
		$_SESSION["filterPartnerModal"]['filterResponsiblePersonLastName']=$_POST['filterResponsiblePersonLastName'];
		$_SESSION["filterPartnerModal"]['filterIdent']=$_POST['filterIdent'];
		$_SESSION["filterPartnerModal"]['filterPartnerDescription']=$_POST['filterPartnerDescription'];

		if($_POST['filterPartnerName']!='' || 
		   $_POST['filterPartnerCode']!='' ||
		   $_POST['filterPartnerType']!='' ||
		   $_POST['filterPartnerNumber']!='' ||
		   $_POST['filterPartnerCity']!='' ||
		   $_POST['filterPartnerZip']!='' ||
		   $_POST['filterPartnerActive']!='---' ||
		   $_POST['filterResponsiblePersonName']!='' ||
		   $_POST['filterResponsiblePersonLastName']!='' ||
		   $_POST['filterIdent']!='' ||
		   $_POST['filterPartnerDescription']!='' 
		){
			if($_POST['filterPartnerName']!=''){
				
				if(strlen($whereCondition)>0){
					$whereCondition.=" AND p.name LIKE '".$_POST['filterPartnerName']."%'";
				} else {
					
					$whereCondition.=" WHERE p.name LIKE '".$_POST['filterPartnerName']."%'";
				}
			}
			if($_POST['filterPartnerCode']!=''){
				
				if(strlen($whereCondition)>0){
					$whereCondition.=" AND p.code LIKE '".$_POST['filterPartnerCode']."%'";
				} else {
					
					$whereCondition.=" WHERE p.code LIKE '".$_POST['filterPartnerCode']."%'";
				}
			}
			if($_POST['filterPartnerType']!='' && $_POST['filterPartnerType']!='---'){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.partnertype = '".$_POST['filterPartnerType']."'";
				} else {
					
					$whereCondition.=" WHERE p.partnertype = '".$_POST['filterPartnerType']."'";
				}
			}
			if($_POST['filterPartnerNumber']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.number LIKE '".$_POST['filterPartnerNumber']."%'";
				} else {
					
					$whereCondition.=" WHERE p.number LIKE '".$_POST['filterPartnerNumber']."%'";
				}
			}
			if($_POST['filterPartnerCity']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.city LIKE '".$_POST['filterPartnerCity']."%'";
				} else {
					
					$whereCondition.=" WHERE p.city LIKE '".$_POST['filterPartnerCity']."%'";
				}
			}
			if($_POST['filterPartnerZip']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.zip LIKE '".$_POST['filterPartnerZip']."%'";
				} else {
					
					$whereCondition.=" WHERE p.zip LIKE '".$_POST['filterPartnerZip']."%'";
				}
			}
			if($_POST['filterPartnerActive']!='' && $_POST['filterPartnerActive']!='---'){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.active = '".$_POST['filterPartnerActive']."'";
				} else {
					
					$whereCondition.=" WHERE p.active = '".$_POST['filterPartnerActive']."'";
				}
			}
			if($_POST['filterResponsiblePersonName']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND u.name LIKE '".$_POST['filterResponsiblePersonName']."%'";
				} else {
					
					$whereCondition.=" WHERE u.name LIKE '".$_POST['filterResponsiblePersonName']."%'";
				}
			}
			if($_POST['filterResponsiblePersonLastName']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND u.surname LIKE '".$_POST['filterResponsiblePersonName']."%'";
				} else {
					
					$whereCondition.=" WHERE u.surname LIKE '".$_POST['filterResponsiblePersonName']."%'";
				}
			}
			if($_POST['filterIdent']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.id = ".$_POST['filterIdent'];
				} else {
					
					$whereCondition.=" WHERE p.id = '".$_POST['filterIdent'];
				}
			}
			if($_POST['filterPartnerDescription']!='' ){
				
				if(strlen($whereCondition)>0  ){
					$whereCondition.=" AND p.description LIKE '%".$_POST['filterPartnerDescription']."%'";
				} else {
					
					$whereCondition.=" WHERE p.description LIKE '%".$_POST['filterPartnerDescription']."%'";
				}
			}

		} else {
			$whereCondition="";
		}

		if($_POST['initTable']>0){
		$query = "SELECT SQL_CALC_FOUND_ROWS p.id AS `Ident`, 
						 p.name AS `Naziv`,
						 p.code AS  `PIB`,
						 p.partnertype `Tip`,
						 p.number AS `Matični broj`,
						 p.address AS `Adresa`,
						 p.city AS `Grad`,
						 p.phone AS `Telefon`,
						 p.email AS `Email`,
						 p.contactperson AS `Kontrakt osoba`,
						 IFNULL('',p.description) AS `Opis delatnosti`,
						 IFNULL('',CONCAT(u.name, ' ' ,u.surname )) AS `Odgovorna osoba`
					FROM partner AS p
						LEFT JOIN user AS u ON p.userid=u.id
						$whereCondition
					ORDER BY p.id ASC
					";
		} else {
			$query = "SELECT SQL_CALC_FOUND_ROWS p.id AS `Ident`, 
						 p.name AS `Naziv`,
						 p.code AS  `PIB`,
						 p.partnertype `Tip`,
						 p.number AS `Matični broj`,
						 p.address AS `Adresa`,
						 p.city AS `Grad`,
						 p.phone AS `Telefon`,
						 p.email AS `Email`,
						 p.contactperson AS `Kontrakt osoba`,
						 IFNULL('',p.description) AS `Opis delatnosti`,
						 IFNULL('',CONCAT(u.name, ' ' ,u.surname )) AS `Odgovorna osoba`
					FROM partner AS p
						LEFT JOIN user AS u ON p.userid=u.id
						WHERE p.id<0
					ORDER BY p.id ASC
					";
		}
		//echo $query;
		
		$res = mysqli_query($conn, $query);


		/* Data set length after filtering */
		
			$sQuery = "SELECT FOUND_ROWS()";
			$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
			$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
			$iFilteredTotal = $aResultFilterTotal[0];
		
	
		/* Total data set length */
		if($_POST['initTable']>0){
			$sQuery = "SELECT COUNT(".$sIndexColumn.") FROM partner";
		} else {
			$sQuery = "SELECT COUNT(".$sIndexColumn.") FROM partner WHERE id<0";
		}
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		unset($output);
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);





		//var_dump($_POST['initTable']);
		//if($_POST['initTable']>0){







		while($row = mysqli_fetch_assoc($res)){
			
			$rowTD = array();
			//echo $row['Ident'];
			$rowTD[0] = $row['Ident'];
			$rowTD[1] = $row['Naziv'];
			$rowTD[2] = $row['PIB'];
			$rowTD[3] = $row['Tip'];
			$rowTD[4] = $row['Matični broj'];
			$rowTD[5] = $row['Adresa'];
			$rowTD[6] = $row['Grad'];
			$rowTD[7] = $row['Telefon'];
			$rowTD[8] = $row['Email'];
			$rowTD[9] = $row['Kontrakt osoba'];
			$rowTD[10] = $row['Opis delatnosti'];
			$rowTD[11] = $row['Odgovorna osoba'];
		
			//$rowTD[99] = $aRow['id'];	
			
			$output['aaData'][] = $rowTD;	
		}

		//}
		
		
		echo json_encode($output);
	}

	function clear_filter_partner_modal(){
		if(isset($_SESSION["filterPartnerModal"])){
			unset($_SESSION["filterPartnerModal"]);	
		}
		echo json_encode('true');
	}

	function get_partner_type(){
		global $conn;
		$data = array();

		$query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT p.partnertype
					FROM partner AS p ";

		$res = mysqli_query($conn, $query);
		if($_SESSION["filterPartnerModal"]['filterPartnerType']!='' && $_SESSION["filterPartnerModal"]['filterPartnerType']=='---'){
			array_push($data, array('partnertype'=>'---','selected'=>'y'));
		} else {
			array_push($data, array('partnertype'=>'---','selected'=>'n'));
		}
		while($row = mysqli_fetch_assoc($res)){
			if(isset($_SESSION["filterPartnerModal"])){
				if($_SESSION["filterPartnerModal"]['filterPartnerType']!='' && $_SESSION["filterPartnerModal"]['filterPartnerType']==$row['partnertype']){
					array_push($data, array('partnertype'=>$row['partnertype'],'selected'=>'y'));
				} else {
					array_push($data, array('partnertype'=>$row['partnertype'],'selected'=>'n'));
				}
			}	
		}
		echo json_encode($data);
	}
	function get_user_group(){
		global $conn;
		$data = array();

		$query = "SELECT SQL_CALC_FOUND_ROWS ug.*
					FROM usergroup AS ug ";

		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
					array_push($data, array('usergroupid'=>$row['id'],'name'=>$row['name']));
			
		}
		echo json_encode($data);
	}


?>