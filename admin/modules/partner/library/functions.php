<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getitem" : get_item(); break;
			case "savepartnerinfo" : save_partner_info(); break;
			case "delete" : delete(); break;	
			case "changestatus" : change_status(); break;
			case "changesort" : change_sort(); break;
			case "getlanguageslist" : getLanguagesList(); break;	
			case "getpartnertype": get_partner_type(); break;
			case "getpartnercity": get_partner_city(); break;
			//PARTNER APPLICATIONS ##############################################################################################################
			case "getpartnerapplications": get_partner_applications(); break;
			case "createpartnerfrompartnerapplication": create_partner_from_partner_applications(); break;
			case "deletepartnerfrompartnerapplication": delete_partner_from_partner_applications(); break;
			//PARTNER APPLICATIONS END ##########################################################################################################
			//PARTNER ADDRESS ###################################################################################################################			
			case "getpartneraddress": get_partner_address(); break;
			case "savepartneraddress": save_partner_address(); break;
			case "getselectedpartneraddress": get_selected_partner_address(); break;
			case "deleteselectedpartneraddress": delete_selected_partner_address(); break;
			//PARTNER ADDRESS END ###############################################################################################################
			//PARTNER CONTACT ###################################################################################################################			
			case "getpartnercontact": get_partner_contact(); break;
			case "savepartnercontact": save_partner_contact(); break;
			case "getselectedpartnercontact": get_selected_partner_contact(); break;
			case "deleteselectedpartnercontact": delete_selected_partner_contact(); break;
			//PARTNER CONTACT END ###############################################################################################################
			//PARTNER DOCUMENTS #################################################################################################################
			case "getpartnerdocuments": get_partner_documents(); break;
			//PARTNER DOCUMENTS END #############################################################################################################
			//PARTNER TRANSACTIONS ##############################################################################################################
			case "getpartnertransactions": get_partner_transactions(); break;
			//PARTNER TRANSACTIONS END ##########################################################################################################
			//PARTNER CATEGORY REBATE ###################################################################################################################			
			case "getpartnercategoryrebate": get_partner_category_rebate(); break;
			case "savepartnercategoryrebate": save_partner_category_rebate(); break;
			case "getselectedpartnercategoryrebate": get_selected_partner_category_rebate(); break;
			case "deleteselectedpartnercategoryrebate": delete_selected_partner_category_rebate(); break;
			//PARTNER CATEGORY REBATE END ###############################################################################################################
			
			//PARTNER PRICELIST ###################################################################################################################
			case "savepartnerpricelist" : save_partner_pricelist(); break;
			case "partnerpricelistremove" : partner_pricelist_remove(); break;
			//PARTNER PRICELIST END ###################################################################################################################
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT p.*, CONCAT(u.name,' ',u.surname) AS `responsibleperson` 
				FROM partner AS p
				LEFT JOIN user AS u ON p.webuserid=u.ID 
				WHERE p.id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];

		$data['active'] = $row['active'];
		$data['address'] = $row['address'];
		$data['city'] = $row['city'];
		$data['contactperson'] = $row['contactperson'];
		$data['description'] = $row['description'];
		$data['fax'] = $row['fax'];
		$data['name'] = $row['name'];
		$data['partnertype'] = $row['partnertype'];
		$data['phone'] = $row['phone'];
		$data['zip'] = $row['zip'];
		$data['code'] = $row['code'];
		$data['number'] = $row['number'];
		$data['email'] = $row['email'];
		$data['valutedays'] = $row['valutedays'];
		$data['rebatepercent'] = $row['rebatepercent'];
		$data['creditlimit'] = $row['creditlimit'];
		$data['userid'] = $row['userid'];
		$data['webuserid'] = $row['webuserid'];
		$data['website'] = $row['website'];
		$data['img'] = $row['img'];
		$data['sort'] = $row['sort'];
		$data['ts'] = $row['ts'];
		$data['responsibleperson'] = $row['responsibleperson'];

		// $q = "SELECT *, (SELECT value FROM banner_tr WHERE partnerid = ".$_POST['id']." AND langid = l.id ) as valuetr
		// 				 FROM languages l";

  //       $res = mysqli_query($conn, $q);
  //       if ($res && mysqli_num_rows($res) > 0) {
  //           while ($row = mysqli_fetch_assoc($res)) {
		// 		array_push($data['lang'], array(
		// 				'langid'=>$row['id'], 
		// 				'langname'=>$row['name'],
		// 				'default'=>$row['default'],
		// 				'value'=>($row['valuetr'] != NULL)? $row['valuetr']:''));
  //           }
  //       }

        echo json_encode($data);
	}
	
	function save_partner_info(){
		global $conn;
		$lastid =$_POST['partnerid'];
		
		
		$query = "INSERT INTO `partner` (`id`, `active`, `address`, `city`, `contactperson`, `description`, `fax`, `name`, `partnertype`, `phone`, `zip`, `code`, `number`, `email`, `valutedays`, `rebatepercent`, `creditlimit`, `userid`, `website`, `img`, `sort`, `webuserid`, `ts`) 
						 VALUES ('".$_POST['partnerid']."', 
							     '".mysqli_real_escape_string($conn, $_POST['active'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['address'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['city'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['contactperson'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['description'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['fax'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['name'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['partnertype'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['phone'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['zip'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['code'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['number'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['email'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['valutedays'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['rebatepercent'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['creditlimit'])."', 
								 NULL, 
								 '".mysqli_real_escape_string($conn, $_POST['website'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['img'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['sort'])."',  
								 '".mysqli_real_escape_string($conn, $_SESSION['id'])."', 
								CURRENT_TIMESTAMP) 
						 ON DUPLICATE KEY UPDATE `active` = '".mysqli_real_escape_string($conn, $_POST['active'])."',
												 `address` = '".mysqli_real_escape_string($conn, $_POST['address'])."',
												 `city` = '".mysqli_real_escape_string($conn, $_POST['city'])."',
												 `contactperson` = '".mysqli_real_escape_string($conn, $_POST['contactperson'])."',
												 `description` = '".mysqli_real_escape_string($conn, $_POST['description'])."',
												 `fax` = '".mysqli_real_escape_string($conn, $_POST['fax'])."',
												 `name` = '".mysqli_real_escape_string($conn, $_POST['name'])."',
												 `partnertype` = '".mysqli_real_escape_string($conn, $_POST['partnertype'])."',
												 `phone` = '".mysqli_real_escape_string($conn, $_POST['phone'])."',
												 `zip` = '".mysqli_real_escape_string($conn, $_POST['zip'])."',
												 `code` = '".mysqli_real_escape_string($conn, $_POST['code'])."',
												 `number` = '".mysqli_real_escape_string($conn, $_POST['number'])."',
												 `email` = '".mysqli_real_escape_string($conn, $_POST['email'])."',
												 `valutedays` = '".mysqli_real_escape_string($conn, $_POST['valutedays'])."',
												 `rebatepercent` = '".mysqli_real_escape_string($conn, $_POST['rebatepercent'])."',
												 `creditlimit` = '".mysqli_real_escape_string($conn, $_POST['creditlimit'])."',
												 `website` = '".mysqli_real_escape_string($conn, $_POST['website'])."',
												 `img` = '".mysqli_real_escape_string($conn, $_POST['img'])."',
												 `sort` = '".mysqli_real_escape_string($conn, $_POST['sort'])."',
												 `webuserid` = '".mysqli_real_escape_string($conn, $_SESSION['id'])."'";
						
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' || $lastid == 0) $lastid = $_POST['partnerid'];
		
		
		if($_POST['partnerid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['partnerid'], $_SESSION['id'], "change");	
		}
	}
	
	function delete(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			$docEmpty=1;
			$query = "SELECT * FROM b2b_document WHERE partnerid = ".$_POST['id'];
			$res=mysqli_query($conn, $query);
			if (mysqli_num_rows($res) == 0) {
				$docEmpty=0;
			}

			$transEmpty=1;
			$query = "SELECT * FROM bankstatementitem WHERE partnerid = ".$_POST['id'];
			$res=mysqli_query($conn, $query);
			if (mysqli_num_rows($res) == 0) {
				$transEmpty=0;
			}

			$pricelistEmpty=1;
			$query = "SELECT * FROM partnerpricelist WHERE partnerid = ".$_POST['id'];
			$res=mysqli_query($conn, $query);
			if (mysqli_num_rows($res) == 0) {
				$pricelistEmpty=0;
			}

			$candelete=$docEmpty+$transEmpty+$pricelistEmpty;

			if($candelete==0){
				foreach($lang as $data)
				{
					$query = "DELETE FROM user WHERE partnerid = ".$_POST['id'];
					mysqli_query($conn, $query);

					$query = "DELETE FROM partner WHERE id = ".$_POST['id'];
					mysqli_query($conn, $query);
					
					$query = "DELETE FROM partneraddress WHERE partnerid = ".$_POST['id'];
					mysqli_query($conn, $query);
	
						$query = "DELETE FROM partnercontact WHERE partnerid = ".$_POST['id'];
						mysqli_query($conn, $query);
	
						$query = "DELETE FROM partnercategory WHERE partnerid = ".$_POST['id'];
						mysqli_query($conn, $query);
	
						$query = "DELETE FROM partnerpricelist WHERE partnerid = ".$_POST['id'];
						mysqli_query($conn, $query);
				}

				echo 0;

			} else {
				echo 1;
			}
			
		}
	}
	function change_status(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "UPDATE `partner` SET `active`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
				mysqli_query($conn, $query);	
			}
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	function change_sort(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "UPDATE `partner` SET `sort`='".$_POST['sort']."' WHERE id = ".$_POST['id'];	
				mysqli_query($conn, $query);	
			}
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change sort");
		}
	}
	
	function getLanguagesList(){
		global $conn;
		$data = array();
		
		$query = "SELECT * FROM languages";
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id"=>$row['id'], "name"=>$row['name'], "default"=>$row['default']));		
		}
		
		echo json_encode($data);
	}
	function get_partner_type(){
		global $conn;
		$data = array();

		$query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT p.partnertype
					FROM partner AS p ";
		//echo $query; 
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
					array_push($data, array('partnertype'=>$row['partnertype']));
		}
		echo json_encode($data);
	}
	function get_partner_city(){
		global $conn;
		$data = array();

		$query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT p.city
					FROM partner AS p ";
		//echo $query; 
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
					array_push($data, array('partnercity'=>$row['city']));
		}
		echo json_encode($data);
	}

//PARTNER APPLICATIONS ##############################################################################################################
	function get_partner_applications(){
		global $conn;

		$data = array();
		//partnerid
		$aColumns = array(  'papp.id','papp.userid','p.id AS partnerid', 'CONCAT(u.name," ",u.surname)','u.email', 'papp.name', 'papp.code' , 'papp.number', 'papp.contactperson', 'papp.phone', 'papp.fax', 'papp.email', 'papp.website', 'papp.address', 'papp.city', 'papp.zip' );
		$sIndexColumn = "papp.id";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		/*Ordering*/
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
		/*Filtering*/
		$sWhere = " WHERE u.partnerid=0 ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE u.partnerid=0 AND "."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	SELECT SQL_CALC_FOUND_ROWS papp.id,
						   IFNULL(papp.userid,0) AS userid,
						   IFNULL(p.id,0) AS partnerid,
						   CONCAT(u.name,' ',u.surname) AS `username`,
						   u.email AS `useremail`,
						   papp.name AS `partnername`,
						   papp.code AS `partnercode`,
						   papp.number AS `partnernumber`,
						   papp.contactperson AS `partnercontactperson`,
						   papp.phone AS `partnerphone`,
						   papp.fax AS `partnerfax`,
						   papp.email AS `partneremail`,
						   papp.website AS `partnerwebsite`,
						   papp.address AS `partneraddress`,
						   papp.city AS `partnercity`,
						   papp.zip AS `partnerzip`,
		 				   IF(p.id>0 ,IF(papp.email=p.email,'o','n'),'n') AS `status`
						FROM partnerapplications AS papp
						LEFT JOIN user AS u ON papp.userid=u.ID
						LEFT JOIN partner AS p ON u.partnerid=p.id
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
			FROM partnerapplications AS papp 
			LEFT JOIN user AS u ON papp.userid=u.ID
			WHERE u.partnerid=0
		";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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

		$row[0] = $aRow['username'];
		$row[1] = $aRow['useremail'];
		$row[2] = $aRow['partnername'];
		$row[3] = $aRow['partnercode'];
		$row[4] = $aRow['partnernumber'];
		$row[5] = $aRow['partnercontactperson'];
		$row[6] = $aRow['partnerphone'];
		$row[7] = $aRow['partnerfax'];
		$row[8] = $aRow['partneremail'];
		$row[9] = $aRow['partnerwebsite'];
		$row[10] = $aRow['partneraddress'];
		$row[11] = $aRow['partnercity'];
		$row[12] = $aRow['partnerzip'];
		$row[13] = $aRow['status'];

		$row[97] = $aRow['userid'];
		$row[98] = $aRow['partnerid'];
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);

	}
	function create_partner_from_partner_applications(){
		global $conn, $system_conf;
		$userid=$_POST['userid'];
		$partnerapplicationid=$_POST['partnerapplicationid'];
		$final=0;
		if($userid>0 && $partnerapplicationid>0){
			$sQuery="SELECT * FROM partnerapplications WHERE id=".$partnerapplicationid;
			
			$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));
			$rowCount=mysqli_num_rows($rResult);
			
			if($rowCount==1){
				$aRow = mysqli_fetch_array( $rResult );
				$partnerActive="y";
				$partnerAddress=$aRow['address'];
				$partnerCity=$aRow['city'];
				$partnerContactPerson=$aRow['contactperson'];
				$partnerDescription="NULL";
				$partnerFax=$aRow['fax'];
				$partnerName=$aRow['name'];
				$partnerType="B2B Kupac";
				$partnerPhone=$aRow['phone'];
				$partnerZip=$aRow['zip'];
				$partnerCode=$aRow['code'];
				$partnerNumber=$aRow['number'];
				$partnerEmail=$aRow['email'];
				$partnerValuteDays=0;
				$partnerRebatePercent=0;
				$partnerCreditLimit=0;
				$partnerUserId="NULL";
				$partnerWebsite=$aRow['website'];
				$partnerImg="NULL";
				$partnerSort=0;
				$partnerWebUserId=$userid;
				$partnerTimeStamp="CURRENT_TIMESTAMP";
				//echo $partnerCode;
				if($partnerCode!='' && strlen($partnerCode)>0){
					//CHECK PARTNER
					$checkPartnerQuery="SELECT p.id FROM partner AS p WHERE p.code=TRIM('".$partnerCode."')";
					
					$rrResult = mysqli_query($conn, $checkPartnerQuery) or die(mysqli_error($conn));
					$partnerCount=mysqli_num_rows($rrResult);
					//CHECK PARTNER END
					$partnerId=0;
					if($partnerCount==0){
						//PARTNER NOT EXIST
						$insertPartnerQuery="INSERT INTO `partner` (`active`, `address`, `city`, `contactperson`, `description`, `fax`, 
					                                       `name`, `partnertype`, `phone`, `zip`, `code`, `number`, `email`, `valutedays`, `rebatepercent`, `creditlimit`, 
					                                       `userid`, `website`, `img`, `sort`, `webuserid`, `ts`) 
												   VALUES ( '".mysqli_real_escape_string($conn, $partnerActive)."', 
												            '".mysqli_real_escape_string($conn, $partnerAddress)."',
												            '".mysqli_real_escape_string($conn, $partnerCity)."',
												            '".mysqli_real_escape_string($conn, $partnerContactPerson)."',
												             ".mysqli_real_escape_string($conn, $partnerDescription).",
												            '".mysqli_real_escape_string($conn, $partnerFax)."',
												            '".mysqli_real_escape_string($conn, $partnerName)."',
												            '".mysqli_real_escape_string($conn, $partnerType)."',
												            '".mysqli_real_escape_string($conn, $partnerPhone)."',
												            '".mysqli_real_escape_string($conn, $partnerZip)."',
												            '".mysqli_real_escape_string($conn, $partnerCode)."',
												            '".mysqli_real_escape_string($conn, $partnerNumber)."',
												            '".mysqli_real_escape_string($conn, $partnerEmail)."',
												             ".mysqli_real_escape_string($conn, $partnerValuteDays).",
												             ".mysqli_real_escape_string($conn, $partnerRebatePercent).",
												             ".mysqli_real_escape_string($conn, $partnerCreditLimit).",
												             ".mysqli_real_escape_string($conn, $partnerUserId).",
												            '".mysqli_real_escape_string($conn, $partnerWebsite)."',
												             ".mysqli_real_escape_string($conn, $partnerImg).",
												             ".mysqli_real_escape_string($conn, $partnerSort).",
												             ".mysqli_real_escape_string($conn, $partnerWebUserId).",
												             ".mysqli_real_escape_string($conn, $partnerTimeStamp)."
												            )";
						//echo $insertPartnerQuery;
						mysqli_query($conn, $insertPartnerQuery);
						$lastid = mysqli_insert_id($conn);
						$partnerId=$lastid;
						$final=1;
					} else {
						//PARTNER EXIST
						$pRow = mysqli_fetch_array( $rrResult );
						$partnerId=$pRow['id'];
						$final=1;
					}
					if($partnerId>0){
						$updateUserQuery="UPDATE user SET type='partner',  partnerid=".$partnerId." ,email_notif='1', updated='2', status='3' WHERE id=".$userid;
						//echo $updateUserQuery;
						mysqli_query($conn, $updateUserQuery);

						$updateUserQuery="REPLACE INTO  privilages_usergroup (groupid, userid,default, status) VALUES(1,".$userid.",0,'v')";
						mysqli_query($conn, $updateUserQuery);
					}
					

				}
				

			}
		    
			

			
			//$lastid = mysqli_insert_id($conn);

		}
		echo $final;
	}
	function delete_partner_from_partner_applications(){
		global $conn, $system_conf;
		$userid=$_POST['userid'];
		$partnerapplicationid=$_POST['partnerapplicationid'];

		$deleteUserQuery="DELETE FROM user  WHERE id=".$userid;
		mysqli_query($conn, $deleteUserQuery);
		$deletePartnerApplicationQuery="DELETE FROM partnerapplication  WHERE id=".$partnerapplicationid;
		mysqli_query($conn, $deletePartnerApplicationQuery);
		echo 1;
	}
//PARTNER APPLICATIONS END ##########################################################################################################
//PARTNER ADDRESS ###################################################################################################################	
	function get_partner_address(){
		global $conn;
		$data = array();
		//partnerid
		$aColumns = array(  'id', 'address', 'city', 'zip', 'deliverycode','region','objectname','objecttype','salesource',`lasteditedby` );
		$sIndexColumn = "id";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		/*Ordering*/
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
		/*Filtering*/
		$sWhere = " WHERE pa.partnerid=".$_POST["partnerid"]." ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE pa.partnerid=".$_POST["partnerid"]."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "pa.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS pa.id, pa.objectname, pa.address, pa.city, pa.zip, pa.deliverycode, pa.region, pa.objecttype, pa.salessource, CONCAT(u.name,' ',u.surname) as `lasteditedby`
		FROM  partneraddress as pa
		LEFT JOIN user u ON pa.webuserid = u.ID
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
			FROM partneraddress AS pa WHERE pa.partnerid=".$_POST["partnerid"]."
		";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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

		$row[0] = $aRow['objectname'];
		$row[1] = $aRow['address'];
		$row[2] = $aRow['city'];
		$row[3] = $aRow['zip'];
		$row[4] = $aRow['region'];
		$row[5] = $aRow['deliverycode'];
		$row[6] = $aRow['salessource'];
		$row[7] = $aRow['objecttype'];
		$row[8] = $aRow['lasteditedby'];
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);
	}

	function save_partner_address(){
		global $conn;
		$lastid =$_POST['partnerid'];
		
		$query = "INSERT INTO `partneraddress` ( `id`,`address`, `city`, `zip`, `deliverycode`, `partnerid`, `region`, `objectname`, `objecttype`, `salessource`, `webuserid`, `ts`) 
						 VALUES ('".mysqli_real_escape_string($conn, $_POST['partneraddressid'])."',
						 		 '".mysqli_real_escape_string($conn, $_POST['address'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['city'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['zip'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['deliverycode'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['partnerid'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['region'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['objectname'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['objecttype'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['salessource'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['id'])."', 
								CURRENT_TIMESTAMP) 
						 ON DUPLICATE KEY UPDATE `address` = '".mysqli_real_escape_string($conn, $_POST['address'])."',
												 `city` = '".mysqli_real_escape_string($conn, $_POST['city'])."',
												 `zip` = '".mysqli_real_escape_string($conn, $_POST['zip'])."',
												 `deliverycode` = '".mysqli_real_escape_string($conn, $_POST['deliverycode'])."',
												 `region` = '".mysqli_real_escape_string($conn, $_POST['region'])."',
												 `objectname` = '".mysqli_real_escape_string($conn, $_POST['objectname'])."',
												 `objecttype` = '".mysqli_real_escape_string($conn, $_POST['objecttype'])."',
												 `salessource` = '".mysqli_real_escape_string($conn, $_POST['salessource'])."',
												 `webuserid` = '".mysqli_real_escape_string($conn, $_SESSION['id'])."'";
						
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' || $lastid == 0) $lastid = $_POST['partneraddressid'];
		
		
		if($_POST['partneraddressid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add-partneraddress");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['partneraddressid'], $_SESSION['id'], "change-partneraddress");	
		}
	}

	function get_selected_partner_address(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		$partneraddressid=$_POST["partneraddressid"];

		$query="SELECT * FROM partneraddress AS padd WHERE padd.id=".mysqli_real_escape_string($conn, $partneraddressid)." AND padd.partnerid=".mysqli_real_escape_string($conn, $partnerid)." "; 

		$res = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['partneraddressid'] = $row['id'];

		$data['address'] = $row['address'];
		$data['city'] = $row['city'];
		$data['zip'] = $row['zip'];
		$data['deliverycode'] = $row['deliverycode'];
		$data['partnerid'] = $row['partnerid'];
		$data['userid'] = $row['userid'];
		$data['region'] = $row['region'];
		$data['objectname'] = $row['objectname'];
		$data['objecttype'] = $row['objecttype'];
		$data['salessource'] = $row['salessource'];
		$data['webuserid'] = $row['webuserid'];

        echo json_encode($data);




	}

	function delete_selected_partner_address(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		$partneraddressid=$_POST["partneraddressid"];

		$query="DELETE FROM partneraddress  WHERE id=".mysqli_real_escape_string($conn, $partneraddressid)." AND partnerid=".mysqli_real_escape_string($conn, $partnerid)." "; 
		$return=0;
		if($res = mysqli_query($conn, $query)){
			$return=1;
		}
		
		
		userlog($_SESSION['moduleid'], "", $partneraddressid, $_SESSION['id'], "DELETE PARTNERADDRESS FOR ID");

        echo json_encode($return);




	}
//PARTNER ADDRESS END ###############################################################################################################
//PARTNER CONTACT ###################################################################################################################
	function get_partner_contact(){
				global $conn;
		$data = array();
		//partnerid
		$aColumns = array(  'id', 'firstname', 'lastname', 'position', 'phone','email','note',`lasteditedby` );
		$sIndexColumn = "id";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		/*Ordering*/
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
		/*Filtering*/
		$sWhere = " WHERE pc.partnerid=".$_POST["partnerid"]." ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE pc.partnerid=".$_POST["partnerid"]."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "pc.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS pc.id, pc.firstname, pc.lastname, pc.position, pc.phone, pc.email, pc.note, pc.partnerid, pc.webuserid, CONCAT(u.name,' ',u.surname) as `lasteditedby`
		FROM  partnercontact as pc
		LEFT JOIN user u ON pc.webuserid = u.ID
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
			FROM partnercontact AS pc WHERE pc.partnerid=".$_POST["partnerid"]."
		";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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

		$row[0] = $aRow['position'];
		$row[1] = $aRow['firstname'];
		$row[2] = $aRow['lastname'];
		$row[3] = $aRow['phone'];
		$row[4] = $aRow['email'];
		$row[5] = $aRow['note'];
		$row[6] = $aRow['lasteditedby'];
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);

	}

	function save_partner_contact(){
		global $conn;
		$lastid =$_POST['partnerid'];
		
		$query = "INSERT INTO `partnercontact` ( `id`,`firstname`, `lastname`, `position`, `phone`, `email`, `note`, `partnerid`, `webuserid`, `ts`) 
						 VALUES ('".mysqli_real_escape_string($conn, $_POST['partnercontactid'])."',
						 		 '".mysqli_real_escape_string($conn, $_POST['firstname'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['lastname'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['position'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['phone'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['email'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['note'])."', 
								 '".mysqli_real_escape_string($conn, $_POST['partnerid'])."',
								 '".mysqli_real_escape_string($conn, $_POST['id'])."', 
								CURRENT_TIMESTAMP) 
						 ON DUPLICATE KEY UPDATE `firstname` = '".mysqli_real_escape_string($conn, $_POST['firstname'])."',
												 `lastname` = '".mysqli_real_escape_string($conn, $_POST['lastname'])."',
												 `position` = '".mysqli_real_escape_string($conn, $_POST['position'])."',
												 `phone` = '".mysqli_real_escape_string($conn, $_POST['phone'])."',
												 `email` = '".mysqli_real_escape_string($conn, $_POST['email'])."',
												 `note` = '".mysqli_real_escape_string($conn, $_POST['note'])."',
												 `webuserid` = '".mysqli_real_escape_string($conn, $_SESSION['id'])."'";
						
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' || $lastid == 0) $lastid = $_POST['partnercontactid'];
		
		
		if($_POST['partnercontactid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add-partnercontact");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['partnercontactid'], $_SESSION['id'], "change-partnercontact");	
		}
	}

	function get_selected_partner_contact(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		$partnercontactid=$_POST["partnercontactid"];

		$query="SELECT * FROM partnercontact AS padd WHERE padd.id=".mysqli_real_escape_string($conn, $partnercontactid)." AND padd.partnerid=".mysqli_real_escape_string($conn, $partnerid)." "; 

		$res = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['partnercontactid'] = $row['id'];

		$data['position'] = $row['position'];
		$data['firstname'] = $row['firstname'];
		$data['lastname'] = $row['lastname'];
		$data['phone'] = $row['phone'];
		$data['email'] = $row['email'];
		$data['note'] = $row['note'];
		$data['partnerid'] = $row['partnerid'];
		$data['webuserid'] = $row['webuserid'];

        echo json_encode($data);

	}

	function delete_selected_partner_contact(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		$partnercontactid=$_POST["partnercontactid"];

		$query="DELETE FROM partnercontact  WHERE id=".mysqli_real_escape_string($conn, $partnercontactid)." AND partnerid=".mysqli_real_escape_string($conn, $partnerid)." "; 
		$return=0;
		if($res = mysqli_query($conn, $query)){
			$return=1;
		}
		
		
		userlog($_SESSION['moduleid'], "", $partnercontactid, $_SESSION['id'], "DELETE PARTNERCONTACT FOR ID");

        echo json_encode($return);

	}
//PARTNER CONTACT END ###############################################################################################################
//PARTNER DOCUMENTS #################################################################################################################
	function get_partner_documents(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		

		$data = array();
		//partnerid
		$aColumns = array(  'd.id', 'd.documentdate','d.documenttype', 'd.number', 'd.comment' );
		$sIndexColumn = "d.id";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		/*Ordering*/
		if ( isset( $_POST['order'] ) )
		{
			$sOrder = "ORDER BY d.ID ASC ";
			for ( $i=0 ; $i< sizeof($_POST['order']) ; $i++ )
			{
				if ( $_POST['columns'][$i]['orderable'] == "true" )
				{
					$sOrder .= ", ".$aColumns[$i]." ".mysqli_real_escape_string($conn, $_POST['order'][$i]['dir'] ) ;
				}
			}
			
			//$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}
		/*Filtering*/
		$sWhere = " WHERE d.partnerid=".mysqli_real_escape_string($conn, $_POST["partnerid"] )." "." AND LEFT(d.documentdate,10)>='".mysqli_real_escape_string($conn, $_POST["fromdate"] )."' "." AND LEFT(d.documentdate,10)<='".mysqli_real_escape_string($conn, $_POST["todate"] )."' ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE d.partnerid=".mysqli_real_escape_string($conn, $_POST["partnerid"] )." AND LEFT(d.documentdate,10)>='".mysqli_real_escape_string($conn, $_POST["fromdate"] )."' "." AND LEFT(d.documentdate,10)<='".mysqli_real_escape_string($conn, $_POST["todate"] )."' "."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "d.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	SELECT SQL_CALC_FOUND_ROWS d.id AS `id`,
					       d.documentdate,
							 CASE d.documenttype
							 WHEN 'E' THEN 'Porudžbina'
							 WHEN 'Q' THEN 'Upit'
							 WHEN 'R' THEN 'Račun'
							 WHEN 'P' THEN 'Predračun'
							 WHEN 'H' THEN 'Gotovinski račun'
							 WHEN 'M' THEN 'Maloprodaja'
							 WHEN 'I' THEN 'Interni prenos'
							 WHEN 'A' THEN 'Avansni račun'
							 WHEN 'L' THEN 'Manjak'
							 WHEN 'F' THEN 'Otpis'
							 WHEN 'T' THEN 'Trebovanje'
							 WHEN 'C' THEN 'Ulaz robe u komision'
							 WHEN 'K' THEN 'Kalkulacija'
							 WHEN 'W' THEN 'Odjava robe'
							 END AS `documenttype`,
							 d.number,
							 w.name AS `warehousename`,
							 ROUND(SUM(di.itemvalue*(1+(di.taxvalue/100))),2) AS `documentvaluewithvat`,
							 d.comment
					FROM b2b_document AS d 
					LEFT JOIN warehouse AS w ON d.warehouseid=w.warehouseid
					LEFT JOIN b2b_documentitem AS di ON d.id=di.b2b_documentid
					$sWhere
					GROUP BY d.id
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
			FROM b2b_document AS d WHERE d.`status`='p' AND d.direction!=0 AND d.partnerid=".$_POST["partnerid"]."
		";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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

		$row[0] = $aRow['documentdate'];
		$row[1] = $aRow['documenttype'];
		$row[2] = $aRow['number'];
		$row[3] = $aRow['warehousename'];
		$row[4] = $aRow['documentvaluewithvat'];
		$row[5] = $aRow['comment'];
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);

	}
//PARTNER DOCUMENTS END #############################################################################################################
//PARTNER TRANSACTIONS ##############################################################################################################
	function get_partner_transactions(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		

		$data = array();
		//partnerid
		$aColumns = array(  'bsi.id', 'bs.statementdate','bs.number', 'bsi.description', 'bsi.debit' , 'bsi.credit' );
		$sIndexColumn = "bsi.id";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		/*Ordering*/
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
		/*Filtering*/
		$sWhere = " WHERE bs.statementtype='I' AND bsi.partnerid=".mysqli_real_escape_string($conn, $_POST["partnerid"] )." "." AND bs.statementdate>='".mysqli_real_escape_string($conn, $_POST["fromdate"] )."' "." AND bs.statementdate<='".mysqli_real_escape_string($conn, $_POST["todate"] )."' ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE bs.statementtype='I' AND bsi.partnerid=".mysqli_real_escape_string($conn, $_POST["partnerid"] )." AND bs.statementdate>='".mysqli_real_escape_string($conn, $_POST["fromdate"] )."' "." AND bs.statementdate<='".mysqli_real_escape_string($conn, $_POST["todate"] )."' "."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "d.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	SELECT bsi.id, bs.statementdate, bs.number, bsi.description, bsi.debit,bsi.credit 
					FROM bankstatement AS bs
					LEFT JOIN bankstatementitem AS bsi ON bs.id=bsi.bankstatementid
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
			FROM bankstatement AS bs
			LEFT JOIN bankstatementitem AS bsi ON bs.id=bsi.bankstatementid 
			WHERE bs.statementtype='I' AND bsi.partnerid=".$_POST["partnerid"]."
		";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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

		$row[0] = $aRow['statementdate'];
		$row[1] = $aRow['number'];
		$row[2] = $aRow['description'];
		$row[3] = $aRow['debit'];
		$row[4] = $aRow['credit'];

		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);

	}
//PARTNER TRANSACTIONS END ##########################################################################################################
//PARTNER CATEGORY REBATE ###################################################################################################################	
	function get_partner_category_rebate(){
		global $conn;
		$data = array();
		//partnerid
		$aColumns = array("categoryid");
		$sIndexColumn = "categoryid";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".mysqli_real_escape_string($conn, $_POST['start'] ).", ".
				mysqli_real_escape_string($conn, $_POST['length'] );
		}
		/*Ordering*/
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
		/*Filtering*/
		$sWhere = " WHERE pc.partnerid=".$_POST["partnerid"]." ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "WHERE pc.partnerid=".$_POST["partnerid"]."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "pc.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	
		SELECT SQL_CALC_FOUND_ROWS pc.rebatepercent, pc.categoryid, c.name, getCategoryRoot_path(pc.categoryid) as categoryname
		FROM  partnercategory as pc
		LEFT JOIN category c ON pc.categoryid = c.id
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
			FROM partnercategory AS pc WHERE pc.partnerid=".$_POST["partnerid"]."
		";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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
			
		$tmpname = explode('|', $aRow['categoryname']);
		$tmpname = array_reverse($tmpname);
		
		$row[0] = implode(' > ', $tmpname);
		$row[1] = $aRow['rebatepercent']." %";
		$row[2] = '';

		$row[99] = $aRow['categoryid'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);
	}

	function save_partner_category_rebate(){
		global $conn;
		$lastid = $_POST['partnerid'];
		
		$q = "INSERT INTO `partnercategory`(`partnerid`, `categoryid`, `rebatepercent`, `valutedays`, `ts`) VALUES (
				'".mysqli_real_escape_string($conn, $_POST['partnerid'])."',
				'".mysqli_real_escape_string($conn, $_POST['categoryid'])."',
				'".mysqli_real_escape_string($conn, $_POST['rebate'])."',
				0,
				CURRENT_TIMESTAMP) 
				ON DUPLICATE KEY UPDATE `rebatepercent` = '".mysqli_real_escape_string($conn, $_POST['rebate'])."' ";
	
		mysqli_query($conn, $q);
		
	}

	function get_selected_partner_category_rebate(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		$partneraddressid=$_POST["partneraddressid"];

		$query="SELECT * FROM partneraddress AS padd WHERE padd.id=".mysqli_real_escape_string($conn, $partneraddressid)." AND padd.partnerid=".mysqli_real_escape_string($conn, $partnerid)." "; 

		$res = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['partneraddressid'] = $row['id'];

		$data['address'] = $row['address'];
		$data['city'] = $row['city'];
		$data['zip'] = $row['zip'];
		$data['deliverycode'] = $row['deliverycode'];
		$data['partnerid'] = $row['partnerid'];
		$data['userid'] = $row['userid'];
		$data['region'] = $row['region'];
		$data['objectname'] = $row['objectname'];
		$data['objecttype'] = $row['objecttype'];
		$data['salessource'] = $row['salessource'];
		$data['webuserid'] = $row['webuserid'];

        echo json_encode($data);

	}

	function delete_selected_partner_category_rebate(){
		global $conn;
		$partnerid=$_POST["partnerid"];
		$categoryid=$_POST["categoryid"];

		$query="DELETE FROM partnercategory  WHERE categoryid=".mysqli_real_escape_string($conn, $categoryid)." AND partnerid=".mysqli_real_escape_string($conn, $partnerid)." "; 
		$return=0;
		if($res = mysqli_query($conn, $query)){
			$return=1;
		}
		
		
		userlog($_SESSION['moduleid'], "", $partneraddressid, $_SESSION['id'], "DELETE PARTNERCATEGORYREBATE FOR ID");

        echo json_encode($return);




	}
//PARTNER CATEGORY REBATE END ###############################################################################################################
//PARTNER PRICELIST ###################################################################################################################
	function save_partner_pricelist(){
		global $conn;	
		$q = 'INSERT INTO `partnerpricelist`(`pricelistid`, `partnerid`, `status`, `sort`, `ts`) VALUES (
				'.$_POST['pricelistid'].',
				'.$_POST['partnerid'].',
				"v",
				0,
				CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE pricelistid = '.$_POST['pricelistid'];
		if(mysqli_query($conn, $q)){
			echo json_encode(array('status'=>'success', 'status_code'=>0, 'msg'=>"Uspesno dodato."));		
		}else{
			echo json_encode(array('status'=>'fail', 'status_code'=>0, 'msg'=>"Greška prilikom dodavanja."));		
		}
	}	
	
	function partner_pricelist_remove(){
		global $conn;
		$q = "DELETE FROM `partnerpricelist` WHERE partnerid = ".$_POST['partnerid'];
		if(mysqli_query($conn, $q)){
			echo json_encode(array('status'=>'success', 'status_code'=>0, 'msg'=>"Uspesno obrisano."));		
		}else{
			echo json_encode(array('status'=>'fail', 'status_code'=>0, 'msg'=>"Greška prilikom brisanja."));		
		}	
	}
//PARTNER PRICELIST END ###################################################################################################################

?>