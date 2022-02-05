<?php
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../../../app/configuration/system.configuration.php");
	include("../../../../".$system_conf["theme_path"][1]."config/user.configuration.php");
	include("../../userlog.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if (isset($_POST['action']) && $_POST['action'] != "") {
		switch ($_POST['action']) {
			case "delete" : delete(); break;
			case "changestatus" : change_status(); break;
			case "getitem" : get_item(); break;
			case "saveaddchange" : save_add_change(); break;
			case "getlanguageslist" : getLanguagesList(); break;

			case "getProductWarehouse" : getProductWarehouse();break;
			case "updateProductWarehousePrice" : updateProductWarehousePrice();break;
			case "updateProductWarehouseAmount" : updateProductWarehouseAmount();break;
			case "addProductWarehouse": addProductWarehouse();break;
			case "deleteProductWarehouse" : deleteProductWarehouse();break;

			case "getProductApplications" : getProductApplications();break;
			case "addProductApplication" : addProductApplication();break;
			case "deleteProductApplication" : deleteProductApplication();break;
			case "changeProductApplicationStatus" : changeProductApplicationStatus();break;

			case "getProductFiles" : getProductFiles();break;
			case "addProductFile" : addProductFile();break;
			case "deleteProductFile" : deleteProductFile();break;
			case "changeProductFileStatus" : changeProductFileStatus();break;


			case "getProductDownload" : getProductDownload();break;
			case "addProductDownload" : addProductDownload();break;
			case "deleteProductDownload" : deleteProductDownload();break;
			case "changeProductDownloadStatus" : changeProductDownloadStatus();break;

			case "getProductCategorys" : getProductCategorys(); break;
			case "addProductCategory" : addProductCategory(); break;
			case "deleteProductCategory" : deleteProductCategory(); break;

			case "getProductExternalCategorys" : getProductExternalCategorys(); break;

			

			case "updateProductExtraDetail" : updateProductExtraDetail(); break;

			case "updateProductAttrValue" : updateProductAttrValue(); break;
			case "saveProductImageAttributeValue" : saveProductImageAttributeValue(); break;
			
			case "getAttributeValues" : getAttributeValues(); break;
			case "updateProductImageSort" : updateProductImageSort();break;
			case "deleteProductImage" : deleteProductImage(); break;

			case "getPartyPossitions" : getPartyPossitions(); break;
			case "getOccupations" : getOccupations(); break;
			case "getQualificationLevels" : getQualificationLevels(); break;
			
			case "setSearchData" : setSearchData(); break;
			case "clearSearchData" : clearSearchData(); break;

			

			case "getMemberDocuments" : getMemberDocuments(); break;

			
			
			
		}
	}

	function getProductFiles(){
		global $conn, $system_conf, $user_conf;

		$aColumns = array(  'pf.id', 'pf.productid', 'pf.contentface','pf.sort');//
		$sIndexColumn = "pf.id";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS pf.* 
						FROM `product_file` AS pf 
						WHERE pf.productid=".$_POST["productid"]."  AND pf.type NOT IN ('img','yt')
					$sWhere 
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(pf.id) FROM `product_file` AS pf WHERE pf.productid=".$_POST["productid"]." AND pf.type NOT IN ('img','yt') ";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		$i = $_POST['start']+1;
		while ( $aRow = mysqli_fetch_array( $rResult ) )
		{
			$fileType='';
			switch ($aRow['type']) {
		    case 'ico':
		        $fileType='Ikona';
		        break;
		    case 'file':
		        $fileType='Fajl';
		        break;
			}

			

			$row = array();
			$row[0] = $i++;
			$row[1] = $fileType;
			$row[2] = $aRow['contentface'];
			$row[3] = $aRow['content'];
			$row[4] = $aRow['status'];
			$row[5] = $aRow['sort'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['id'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	function addProductFile(){
		
	}

	function deleteProductFile(){
		global $conn, $subdirectory;
		
		$q = "SELECT content FROM product_file WHERE id =".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		$filename = $row['content'];
		
		$q = "DELETE FROM product_file WHERE id = ".$_POST['id'];
		mysqli_query($conn, $q);
		
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/thumb/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/small/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/medium/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/big/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/'.$filename);
	}

	function changeProductFileStatus(){
		global $conn;
		$query = "UPDATE product_file SET status = '".mysqli_real_escape_string($conn, $_POST['status'])."' 
				    WHERE id = ".$_POST['id'];
		mysqli_query($conn, $query);
	}

	function getProductDownload(){
		global $conn, $system_conf, $user_conf;

		$aColumns = array(  'pf.id', 'pf.productid', 'pf.contentface','pf.sort');//
		$sIndexColumn = "pf.id";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS pf.* 
						FROM `product_file` AS pf 
						WHERE pf.productid=".$_POST["productid"]."  AND pf.type  IN ('ico','vid','yt')
					$sWhere 
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(pf.id) FROM `product_file` AS pf WHERE pf.productid=".$_POST["productid"]." AND pf.type NOT IN ('img','yt') ";
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		$i = $_POST['start']+1;
		while ( $aRow = mysqli_fetch_array( $rResult ) )
		{
			$fileType='';
			switch ($aRow['type']) {
		    case 'ico':
		        $fileType='Ikona';
		        break;
		    case 'yt':
		        $fileType='YouTube - Video (Embedded)';
		        break;
		    case 'vid':
		        $fileType='Video';
		        break;
			}

			

			$row = array();
			$row[0] = $i++;
			$row[1] = $fileType;
			$row[2] = $aRow['contentface'];
			$row[3] = $aRow['content'];
			$row[4] = $aRow['status'];
			$row[5] = $aRow['sort'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['id'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	function addProductDownload(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		$query = "INSERT INTO `product_file`(`id`, `productid`, `type`, `content`, `contentface`, `attrvalid`, `status`, `sort`, `ts`) 
		VALUES ('' , ".mysqli_real_escape_string($conn, $_POST['productid'])." , '".mysqli_real_escape_string($conn, $_POST['type'])."' , '".mysqli_real_escape_string($conn, $_POST['content'])."' , '".mysqli_real_escape_string($conn, $_POST['contentface'])."', NULL ,'v' , 0 , CURRENT_TIMESTAMP)";
		//echo $query;
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}

		$lastid = mysqli_insert_id($conn);	
				
		echo json_encode(array($err, $lastid));	
	}

	function deleteProductDownload(){
		global $conn, $subdirectory;
		
		$q = "SELECT content FROM product_file WHERE id =".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		$filename = $row['content'];
		
		$q = "DELETE FROM product_file WHERE id = ".$_POST['id'];
		mysqli_query($conn, $q);
		
		//unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/thumb/'.$filename);
		//unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/small/'.$filename);
		//unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/medium/'.$filename);
		//unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/big/'.$filename);
		//unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/'.$filename);
	}

	function changeProductDownloadStatus(){
		global $conn;
		$query = "UPDATE product_file SET status = '".mysqli_real_escape_string($conn, $_POST['status'])."' 
				    WHERE id = ".$_POST['id'];
		mysqli_query($conn, $query);
	}







	function updateProductExtraDetail(){
		global $conn;
		$err = 0;

		if($_POST['status'] != 1)
		{
			$query = "DELETE FROM productextradetail WHERE productid = ".$_POST['proid']." AND extradetailid = ".$_POST['edid'];
			echo $q;
			if(!mysqli_query($conn, $query))
			{
				$err = 1;
			}
		}
		else{
			$query = "INSERT INTO `productextradetail`(`id`, `productid`, `extradetailid`, `ts`) VALUES ('',".intval($_POST['proid']).", ".intval($_POST['edid']).",CURRENT_TIMESTAMP)";	
			echo $q;
			if(!mysqli_query($conn, $query))
			{
				$err = 1;
			}	
		}

		echo json_encode(array($err));		
	}

	function updateProductAttrValue(){
		global $conn;
		$err = 0;
		
		if($_POST['status'] == 0)
		{
			$query = "DELETE FROM attrprodval WHERE productid = ".$_POST['proid']." AND attrvalid = ".$_POST['attrvalid'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;
			}
		}
		else{
			$query = "INSERT INTO `attrprodval`(`productid`, `attrvalid`, `ts`) VALUES (".intval($_POST['proid']).", ".intval($_POST['attrvalid']).",CURRENT_TIMESTAMP)";	
			if(!mysqli_query($conn, $query))
			{
				$err = 1;
			}	
		}
		
		echo json_encode(array($err));
	}

	function saveProductImageAttributeValue(){
		global $conn;
		
		$query = "UPDATE product_file SET attrvalid = ".$_POST['attrvalid']." WHERE id = ".$_POST['imageid'];
		mysqli_query($conn, $query);
	}

	function getAttributeValues(){
		global $conn;
		
		$query = "SELECT id, value FROM attrval WHERE attrid = ".$_POST['attrid'];	
		$re = mysqli_query($conn, $query);
		
		$data = array();
		
		while($row = mysqli_fetch_assoc($re))
		{
			array_push($data, $row);	
		}
		
		echo json_encode($data);
	}

	function updateProductImageSort(){
		global $conn;
	
		$i = 0;
		foreach($_POST['items'] as $k=>$v){
			$q = "UPDATE product_file SET sort = ".$i." WHERE id =".$v;	
			mysqli_query($conn, $q);
			$i++;
		}
	}

	function deleteProductImage(){
		global $conn, $subdirectory;
		
		$q = "SELECT content FROM product_file WHERE id =".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		$filename = $row['content'];
		
		$q = "DELETE FROM product_file WHERE id = ".$_POST['id'];
		mysqli_query($conn, $q);
		
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/thumb/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/small/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/medium/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/big/'.$filename);
		unlink($_SERVER['DOCUMENT_ROOT'].$subdirectory.'fajlovi/product/'.$filename);
	}

	function addProductCategory(){
		global $conn;
		if($_POST['productid'] != "" && $_POST['categoryid'] != "")
		{
			$query = "DELETE FROM `productcategory` WHERE productid = ".$_POST['productid']." AND categoryid = ".$_POST['categoryid'];
			mysqli_query($conn, $query);

			$query = "INSERT INTO `productcategory` (`productid`,`categoryid`, `sort`, `status`) 
						VALUES (".mysqli_real_escape_string($conn, $_POST['productid']).",
							    ".mysqli_real_escape_string($conn, $_POST['categoryid']).",
							   0,
							   'v'
							   )";
			mysqli_query($conn, $query);
		}
	}

	function deleteProductCategory(){
		global $conn;
		if($_POST['productid'] != "" && $_POST['categoryid'] != "")
		{
			$query = "DELETE FROM `productcategory` WHERE productid = ".$_POST['productid']." AND categoryid = ".$_POST['categoryid'];
			mysqli_query($conn, $query);
			
			

			userlog($_SESSION['moduleid'], "PID: ".$_POST['productid']." | CID: ".$_POST['categoryid'], $_POST['productid'], $_SESSION['id'], "delete");
		}
	}





	function getCategoryPath($parid, $string)
	{
		global $conn;
		$tmpstring = $string;
		$query = "SELECT * FROM category WHERE parentid = ".$parid." ORDER BY name ASC ";
		


		$r = mysqli_query($conn,$query);
		if(mysqli_num_rows($r) > 0)
		{
			while($row = mysqli_fetch_assoc($r))
			{
				$tmpstring = $string." >> ".$row['name'];

				get_all_deepest_cat($row["id"],$tmpstring);	

			}
		}else{
			echo '<option value="'.$parid.'">'.$string.'</option>';
				
		}
		return $string;
	}

	function getPartyPossitions(){
		global $conn;

		$data = array();
		/*$query = "SELECT pp.id, pp.name FROM `partyposition` AS pp ORDER BY pp.id ASC";
		$res = mysqli_query($conn, $query);

		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id"=>$row['id'], "name"=>$row['name']));		
		}*/
			
		echo json_encode($data);
	}

	function getOccupations(){
		global $conn;

		$data = array();
		/*$query = "SELECT DISTINCT d.occupation AS `occupation` FROM `member` AS d ORDER BY d.occupation ASC";
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("name"=>$row['occupation']));		
		}*/
		
		echo json_encode($data);
	}

	function getQualificationLevels(){
		global $conn;

		$data = array();
		/*$query = "SELECT ql.id, ql.name FROM `qualificationslevel` AS ql ORDER BY ql.id ASC";
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id"=>$row['id'], "name"=>$row['name']));			
		}*/
		
		echo json_encode($data);
	}

	
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `product` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `product_tr` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productdetail` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `productdetail_tr` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `product_file` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productcategory` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productcodecode` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productextradetail` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productquantityrebate` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productrelations` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `productwarehouse` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `product_app` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			$query = "DELETE FROM `product_rating` WHERE productid = ".$_POST['id'];
			mysqli_query($conn, $query);

			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `product` SET `active`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn, $lang, $subdirectory,$system_conf, $user_conf;
        $data = array();
        
		
		$q = "SELECT p.*, getDefaultImage(p.id) AS `mainimage`, t.value AS `taxvalue` FROM product AS p 
				LEFT JOIN tax AS t ON p.taxid=t.id
				WHERE p.id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];

		
		$data['active']=$row['active'];
		$data['mainimage']=$row['mainimage'];
		$data['code']=$row['code'];
		$data['barcode']=$row['barcode'];
		$data['manufcode']=$row['manufcode'];
		$data['manufname']=$row['manufname'];
		$data['name']=$row['name'];
		$data['altername']=$row['altername'];
		$data['price']=$row['price'];
		$data['pricecurrency']=$row['pricecurrency'];
		$data['pricevisibility']=$row['pricevisibility'];
		$data['taxid']=$row['taxid'];
		$data['taxvalue']=$row['taxvalue'];
		$data['type']=$row['type'];
		$data['unitname']=$row['unitname'];
		$data['unitstep']=$row['unitstep'];
		$data['foreignname']=$row['foreignname'];
		$data['rebate']=$row['rebate'];
		$data['webrebate']=$row['webrebate'];
		$data['brendid']=$row['brendid'];
		$data['sort']=$row['sort'];
		$data['searchwords']=$row['searchwords'];
		$data['pricevisible']=$row['pricevisible'];
		$data['extendedwarranty']=$row['extendedwarranty'];
		$data['developer']=$row['developer'];
		$data['developerlink']=$row['developerlink'];
		$data['numberofdownloads']=$row['numberofdownloads'];
		$data['priceb2c'] =0;
		$data['priceb2cvat'] =0;
		$data['priceb2b'] =0;
		$data['priceb2bvat'] =0;
		$data['quantity'] =0;

		$data['activestring']='';
		switch ($data['active']) {
		    case 'y':
		        $data['activestring']='Aktivan';
		        break;
		    case 'n':
		        $data['activestring']='Neaktivan';
		        break;
		}

		$data['typestring']='';
		switch ($data['type']) {
		    case 'r':
		        $data['typestring']='Regularan';
		        break;
		    case 'q':
		        $data['typestring']='Na upit';
		        break;
		    case 'i':
		        $data['typestring']='Info';
		        break;
		    case 'vp':
		        $data['typestring']='Grupni proizvod';
		        break;
		    case 'vpi-r':
		        $data['typestring']='Član grupnog proizvoda - Regularan';
		        break;
		    case 'vpi-q':
		        $data['typestring']='Član grupnog proizvoda - Na upit';
		        break;
		}

		/*GET LANGUAGE DATA*/
		$data['lang'] = array();
		$q = "SELECT l.* FROM languages AS l ORDER BY l.`default` ASC";
		$resl = mysqli_query($conn, $q);
		$first = true;
		while($rowl = mysqli_fetch_assoc($resl)){
			$q = "SELECT p.*, (SELECT name FROM product_tr WHERE productid = ".$_POST['id']." AND langid = ".$rowl['id'].") as nametr,
							(SELECT altername FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as alternametr, 
							(SELECT manufname FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as manufnametr,
							(SELECT unitname FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as unitnametr,
							(SELECT searchwords FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as searchwordstr,
							(SELECT developer FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as developertr,
							(SELECT price FROM productwarehouse WHERE productid = ".$_POST['id']."  AND warehouseid = ".$user_conf["b2cwh"][1].") as priceb2c,
							(SELECT price FROM productwarehouse WHERE productid = ".$_POST['id']."  AND warehouseid = ".$user_conf["b2bwh"][1].") as priceb2b,
							(SELECT amount FROM productwarehouse WHERE productid = ".$_POST['id']." AND warehouseid = ".$user_conf["b2bwh"][1].") as quantity FROM `product` p  
							WHERE p.id=".$_POST['id'];

			$res = mysqli_query($conn, $q);				
			$rowpro = mysqli_fetch_assoc($res);
														
			$q = "SELECT pd.*, (SELECT characteristics FROM productdetail_tr WHERE productid = ".$_POST['id']." AND langid = ".$rowl['id'].") as characteristicstr, 
							(SELECT description FROM productdetail_tr WHERE productid = ".$_POST['id']." AND langid = ".$rowl['id'].") as descriptiontr,
							(SELECT model FROM productdetail_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as modeltr, 
							(SELECT specification FROM productdetail_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as specificationtr FROM `productdetail` pd WHERE pd.productid=".$_POST['id'];
							
			$res = mysqli_query($conn, $q);											
			$rowprodet = mysqli_fetch_assoc($res);	
			
			if($first){
				$data['priceb2c'] = $rowpro['priceb2c'];
				$data['priceb2cvat'] = round($rowpro['priceb2c']*(1+($data['taxvalue']/100)),2);
				$data['priceb2b'] = $rowpro['priceb2b'];
				$data['priceb2bvat'] =  round($rowpro['priceb2b']*(1+($data['taxvalue']/100)),2);
				$data['quantity'] = $rowpro['quantity'];
				$first = false;
			}
			
			
			
			array_push($data['lang'],array('langid'=>$rowl['id'],
											'langname'=>$rowl['name'],
											'default'=>$rowl['default'],
											'name'=>($rowpro['nametr'] == NULL && $rowl['default'] == 'y')? $rowpro['name']:$rowpro['nametr'],
											'altername'=>($rowpro['alternametr'] == NULL && $rowl['default'] == 'y')? $rowpro['altername']:$rowpro['alternametr'],
											'manufname'=>($rowpro['manufnametr'] == NULL && $rowl['default'] == 'y')? $rowpro['manufname']:$rowpro['manufnametr'],
											'unitname'=>($rowpro['unitnametr'] == NULL && $rowl['default'] == 'y')? $rowpro['unitname']:$rowpro['unitnametr'],
											'searchwords'=>($rowpro['searchwordstr'] == NULL && $rowl['default'] == 'y')? $rowpro['searchwords']:$rowpro['searchwordstr'],
											'developer'=>($rowpro['developertr'] == NULL && $rowl['default'] == 'y')? $rowpro['developer']:$rowpro['developertr'],
											'characteristics'=>($rowprodet['characteristicstr'] == NULL && $rowl['default'] == 'y')? $rowprodet['characteristics']:$rowprodet['characteristicstr'],
											'description'=>($rowprodet['descriptiontr'] == NULL && $rowl['default'] == 'y')? $rowprodet['description']:$rowprodet['descriptiontr'],
											'model'=>($rowprodet['modeltr'] == NULL && $rowl['default'] == 'y')? $rowprodet['model']:$rowprodet['modeltr'],
											'specification'=>($rowprodet['specificationtr'] == NULL && $rowl['default'] == 'y')? $rowprodet['specification']:$rowprodet['specificationtr']));

		}


		/*GET LANGUAGE END*/
		/*GET VISITORS COUNT*/
		$data['viewcount'] = 0;
		$query = "SELECT COUNT(cd.foreign_id) AS `viewcount` FROM countdata AS cd WHERE cd.foreign_table='product' AND cd.foreign_id=".$_POST['id']."  GROUP BY cd.foreign_id";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			$data['viewcount'] = $row["viewcount"];
		}
		/*GET VISITORS COUNT END*/
		/*GET VISITORS STATISTICS*/
		$data['statistics'] = array();
		/*GET VISITORS STATISTICS END*/
		/*GET PRODUCT IMAGES*/
		$data['images'] = array();
		$query = "SELECT pf.*, (SELECT attrid FROM attrval WHERE id=pf.attrvalid) as attrid FROM product_file pf WHERE pf.productid=".$_POST['id']." AND pf.type = 'img' ORDER BY pf.sort ASC";
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result)){
			array_push($data['images'], array("id"=>$row['id'], 
											  "thumb"=>"../fajlovi/product/thumb/".basename($row['content']), 
											  "big"=>"../fajlovi/product/big/".basename($row['content']),
											  'attrvalid'=>$row['attrvalid'], 
											  'attrid'=>$row['attrid']
											));
		}
		/*GET PRODUCT IMAGES END*/

		/*GET PRODUCT FILES*/
		$data['files'] = array();
		$query = "SELECT * FROM product_file WHERE productid = ".$_POST['id']." AND type != 'img'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result)){
				array_push($data['files'], array($row['id'], 
							$row['productid'],
							$row['type'],
							$row['content'],
							$row['contentface'],
							$row['status'],
							$row['sort'],
							$row['ts']));	
			}			
		}
		else
		{
			$data['files'][0] = 0;
		}
		
		/*GET PRODUCT FILES END*/
		/*GET PRODUCT CATEGORYS*/
		$data['categorys'] = array();


		
		$query = "SELECT pc.categoryid, c.name, getCategoryPath(pc.categoryid) AS `categorypath` FROM productcategory AS pc LEFT JOIN category AS c ON pc.categoryid=c.id WHERE productid = ".$_POST['id'];
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result)){
				array_push($data['categorys'], array("categoryid"=>$row['categoryid'],"categoryname"=>$row['name'],"categorypath"=>$row['categorypath'] ));
				
			}			
		}

		$data['extcategorys'] = array();
		$aExtCategorysId = array();
		$query = "SELECT pc.categoryid, c.name, getExternalCategoryPath(pc.categoryid) AS `categorypath` , c.categoryid as localcategoryid
						FROM productcategory_external AS pc LEFT JOIN category_external AS c ON pc.categoryid=c.id WHERE productid =".$_POST['id'];
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result)){
				array_push($data['extcategorys'], array("categoryid"=>$row['categoryid'],"categoryname"=>$row['name'],"categorypath"=>$row['categorypath'] ));
				
				if($row['localcategoryid'] != '0')
				array_push($aExtCategorysId, $row['localcategoryid']);
				
			}			
		}

		//



		/*else
		{
			$data['categorys'][0] = 0;
			
		}*/
		/*GET PRODUCT CATEGORYS END*/

		/*GET PRODUCT EXTRADETAIL*/
		
		$data['extradetail'] = array();
		
		$query = "SELECT ed.id, ed.name, (SELECT ped.id FROM productextradetail ped WHERE extradetailid = ed.id AND productid = ".$_POST['id'].") as pedid 
		FROM extradetail ed ORDER BY ed.id ASC";
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data['extradetail'], array($row['id'], $row['name'], $row['pedid']));	
		}
		/*GET PRODUCT EXTRADETAIL END*/
		/*GET PRODUCT RELATIONS*/
		
		$data['relations'] = array();
		
		$q = "SELECT * FROM relations ORDER BY sort ASC";
		$resrel = mysqli_query($conn, $q); 
		
		while($rowrel = mysqli_fetch_assoc($resrel)){
			$q = "SELECT pr.*, p.name, p.code, p.id as prodid FROM productrelations pr 
					LEFT JOIN product p ON pr.relatedproid = p.id
					WHERE pr.productid = ".$_POST['id']." AND pr.relationsid =".$rowrel['id'];
			$resprrel = mysqli_query($conn, $q);
			
			
			$arr = array();
			$arr['id'] = $rowrel['id'];
			$arr['name'] = $rowrel['name'];
			$arr['status'] = $rowrel['status'];
			$arr['sort'] = $rowrel['sort'];
			$arr['data'] = array();
			
			array_push($data['relations'], $arr);
			
			while($rowprrel = mysqli_fetch_assoc($resprrel)){
				array_push($data['relations'][count($data['relations'])-1]['data'], array('relatedid'=>$rowprrel['relatedproid'], 'code'=>$rowprrel['code'], 'name'=>$rowprrel['name']));
			}
		}
		/*GET PRODUCT RELATIONS END*/
		/*GET PRODUCT ATTRIBUTES*/

		$data['attributes'] = array();
		//var_dump(count($data['categorys']));
		if(count($data['categorys']) > 0 || count($data['extcategorys']) > 0){
			
			$catids=array();
			foreach($data['categorys'] as $cval){
				array_push($catids, $cval["categoryid"]);
			}
			$query = "SELECT ac.*, a.name as aname FROM attrcategory ac
				LEFT JOIN attr a ON ac.attrid = a.id
				Left JOIN category AS c ON ac.categoryid=c.id
			 	WHERE ac.categoryid IN (".implode(',',array_merge($catids,$aExtCategorysId)).") GROUP BY ac.attrid ORDER by ac.attrid ASC, a.name ASC";
			 	//var_dump($query);
			$re = mysqli_query($conn, $query);

			 	

			 if(mysqli_num_rows($re)){
				while($row = mysqli_fetch_assoc($re)){
						/*GET ATRIBUTE CATEGORYS*/
						$attrcatnames=array();
						$query="SELECT c.name AS `categoryname`, getCategoryPath(ac.categoryid) AS `categorypath` 
									FROM attrcategory AS ac 
									LEFT JOIN category AS c ON ac.categoryid=c.id WHERE ac.attrid=".$row['attrid']." AND ac.categoryid IN (".implode(',',$catids).")";
						$catres = mysqli_query($conn, $query);
						while($catrow = mysqli_fetch_assoc($catres))
						{
							array_push($attrcatnames, $catrow["categoryname"]."(".$catrow["categorypath"].")");	
						}
						$catnamesstring=implode(' | ',$attrcatnames);
						//echo $catnamesstring;
						/*GET ATRIBUTE CATEGORYS END*/						

						
						$tmparr = array();
						$query = "SELECT av.*, apv.attrvalid FROM attrval av
								LEFT JOIN attrprodval apv ON av.id = apv.attrvalid AND apv.productid = ".$_POST['id']." 
								WHERE av.attrid = ".$row['attrid'];
								
						$res = mysqli_query($conn, $query);
						while($rowpv = mysqli_fetch_assoc($res))
						{
							array_push($tmparr, array($rowpv['id'], $rowpv['value'], $rowpv['attrvalid']));	
						}
						array_push($data['attributes'], array($row['attrid'], $row['aname'], $tmparr, $catnamesstring));
				}								
			}

						 	
					
		}

		/*$data['atributes'] = array();*/




		/*if($data['categoryids'] != 0){
			$query = "SELECT ac.*, a.name as aname, c.name AS `category`, getCategoryPath(ac.categoryid) AS `categorypath` FROM attrcategory ac
					LEFT JOIN attr a ON ac.attrid = a.id
					Left JOIN category AS c ON ac.categoryid=c.id
			 		WHERE ac.categoryid IN (".implode(',',$data['categoryids']).")";
			// echo $query;	
			$re = mysqli_query($conn, $query);
			if(mysqli_num_rows($re))
			{
				while($row = mysqli_fetch_assoc($re))
				{
					$tmparr = array();
					$query = "SELECT av.*, apv.attrvalid FROM attrval av
							LEFT JOIN attrprodval apv ON av.id = apv.attrvalid AND apv.productid = ".$_POST['id']." 
							WHERE av.attrid = ".$row['attrid'];
							
					$res = mysqli_query($conn, $query);
					while($rowpv = mysqli_fetch_assoc($res))
					{
						array_push($tmparr, array($rowpv['id'], $rowpv['value'], $rowpv['attrvalid']));	
					}
					array_push($data['atributes'], array($row['attrid'], $row['aname'], $tmparr));
				}
				
			}
		}*/
		/*GET PRODUCT ATTRIBUTES END*/
		/*GET PRODUCT QUANTITY REBATE*/
		
		$data['qtyrebate'] = array();
		
		$query = "SELECT * FROM productquantityrebate WHERE productid=".$_POST['id']." ORDER BY quantity ASC";
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data['qtyrebate'], array('id'=>$row['id'], 'quantity'=>$row['quantity'], 'rebate'=>$row['rebate'], 'attrvalid'=>$row['attrvalid'], 'status'=>$row['status']));	
		}
		/*GET PRODUCT QUANTITY REBATE END*/

		/* TODO	*/
        echo json_encode($data);
	}
	
	function save_add_change(){		
		//var_dump($_POST);
		//die();
		global $conn;

		//var_dump("POST PRODUCT ID :".$_POST['productid']);
		$main_productid=$_POST['productid'];
		if($main_productid=='' || $main_productid=='0'){
			$queryNewProductID = "SELECT IFNULL(MAX(id),0)+1 AS `newproductid` FROM product ";
			$resultNewProductID=mysqli_query($conn, $queryNewProductID);
			if(mysqli_num_rows($resultNewProductID)>0){
				$rowNewProductID = mysqli_fetch_assoc($resultNewProductID);
				$main_productid=$rowNewProductID["newproductid"];
			} else {
				die();
			}
		}
		//var_dump("NEW PRODUCT ID :".$main_productid);
		//die();
		$trProductDataArray=array();

		$default_name="";

		foreach($_POST['names'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_name = $v['name'];
			}
			if(!isset($trProductDataArray[$v['langid']])) $trProductDataArray[$v['langid']]=array();
			array_push($trProductDataArray[$v['langid']], "'".$v['name']."'");
		}
		$default_altername="";
		foreach($_POST['alternames'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_altername = $v['altername'];
			}
			if(!isset($trProductDataArray[$v['langid']])) $trProductDataArray[$v['langid']]=array();
			array_push($trProductDataArray[$v['langid']], "'".$v['altername']."'");
		}
		$default_manufname="";
		foreach($_POST['manufnames'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_manufname = $v['manufname'];
			}
			array_push($trProductDataArray[$v['langid']], "'".$v['manufname']."'");
		}
		$default_unitname="";
		foreach($_POST['unitnames'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_unitname = $v['unitname'];
			}
			array_push($trProductDataArray[$v['langid']], "'".$v['unitname']."'");
		}
		$default_searchwords="";
		foreach($_POST['searchwords'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_searchwords = $v['searchwords'];
			}
			array_push($trProductDataArray[$v['langid']], "'".$v['searchwords']."'");
		}
		$default_developer="";
		foreach($_POST['developers'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_developer = $v['developer'];
			}
			array_push($trProductDataArray[$v['langid']], "'".$v['developer']."'");
		}
		//var_dump($trProductDataArray);
		$trProductString="";
		$trProductUpdateString="";
		foreach($trProductDataArray as $k=>$trprodval){
			$trProductString.="('".$main_productid."',".$k.",".implode(',', $trProductDataArray[$k])."),";
			$trProductUpdateString.="";

		}

		$query = "INSERT INTO product_tr (`productid`,`langid`,`name`,`altername`, `manufname`,`unitname`,`searchwords`,`developer`) 
						VALUES ".substr($trProductString,0, -1)." 
						ON DUPLICATE KEY UPDATE `name`=VALUES(name),`altername`=VALUES(altername),`manufname`=VALUES(manufname),`unitname`=VALUES(unitname),`searchwords`=VALUES(searchwords),`developer`=VALUES(developer)";
		//var_dump($query);
		mysqli_query($conn, $query);
		

		$trProductDetailDataArray=array();
		$default_description="";
		foreach($_POST['descriptions'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_description = $v['description'];
			}
			if(!isset($trProductDetailDataArray[$v['langid']])) $trProductDetailDataArray[$v['langid']]=array();
			array_push($trProductDetailDataArray[$v['langid']], "'".$v['description']."'");
		}


		$default_characteristicts="";
		foreach($_POST['characteristics'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_characteristicts = $v['characteristic'];

			}
			array_push($trProductDetailDataArray[$v['langid']], "'".$v['characteristic']."'");
		}
		$default_specification="";
		foreach($_POST['specifications'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_specification = $v['specification'];
			}
			array_push($trProductDetailDataArray[$v['langid']], "'".$v['specification']."'");
		}

		$default_model="";
		foreach($_POST['models'] as $k=>$v){
			if($v['defaultlang'] == 'y'){
				$default_model = $v['model'];
			}
			array_push($trProductDetailDataArray[$v['langid']], "'".$v['model']."'");
		}

		$$trProductDetailString="";
		$trProductDetailUpdateString="";
		foreach($trProductDetailDataArray as $k=>$trproddetailval){
			$trProductDetailString.="('".$main_productid."',".$k.",".implode(',', $trProductDetailDataArray[$k])."),";
			$trProductDetailUpdateString.="";

		}

		$query = "INSERT INTO productdetail_tr (`productid`,`langid`,`description`, `characteristics`,`specification`,`model`) 
						VALUES ".substr($trProductDetailString,0, -1)." 
						ON DUPLICATE KEY UPDATE `description`=VALUES(description),`characteristics`=VALUES(characteristics),`specification`=VALUES(specification),`model`=VALUES(model)";
		//echo $query;
		mysqli_query($conn, $query);


		$query = "INSERT INTO `product` (`id`, 
										 `active`, 
										 `active_doc`, 
										 `barcode`, 
										 `code`, 
										 `inputprice`, 
										 `inputpricecurrency`, 
										 `manufcode`, 
										 `manufname`, 
										 `name`,
										 `altername`, 
										 `price`, 
										 `pricecurrency`, 
										 `pricevisibility`,
										 `taxid`, 
										 `type`, 
										 `unitname`, 
										 `unitstep`, 
										 `rebate`, 
										 `webrebate`,
										 `brendid`, 
										 `sort`,
										 `searchwords`, 
										 `pricevisible`, 
										 `extendwarrnity`, 
										 `numberofdownloads`, 
										 `developer`,
										 `developerlink`, 
										 `ts`
										) VALUES (	'".$main_productid."',
												  	'".mysqli_real_escape_string($conn, $_POST['active'])."',
												  	'n',
												  	'".mysqli_real_escape_string($conn, $_POST['barcode'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['code'])."',
												  	0,
												  	'',
												  	'".mysqli_real_escape_string($conn, $_POST['manufcode'])."',
												  	'".mysqli_real_escape_string($conn, $default_manufname)."',
												  	'".mysqli_real_escape_string($conn, $default_name)."',
												  	'".mysqli_real_escape_string($conn, $default_altername)."',
												  	0,
												  	'',
												  	'".mysqli_real_escape_string($conn, $_POST['pricevisibility'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['taxid'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['type'])."',
												  	'".mysqli_real_escape_string($conn, $default_unitname)."',
												  	'".mysqli_real_escape_string($conn, $_POST['unitstep'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['rebate'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['webrebate'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['brendid'])."',
												  	'".mysqli_real_escape_string($conn, $_POST['sort'])."',
												  	'".mysqli_real_escape_string($conn, $default_searchwords)."',
												  	1,
												  	'',
												  	'".mysqli_real_escape_string($conn, $_POST['numberofdownloads'])."',
												  	'".mysqli_real_escape_string($conn, $default_developer)."',
												  	'".mysqli_real_escape_string($conn, $_POST['developerlink'])."',
												  	CURRENT_TIMESTAMP
									) 
								ON DUPLICATE KEY UPDATE `active`='".mysqli_real_escape_string($conn, $_POST['active'])."', 
														`barcode` = '".mysqli_real_escape_string($conn, $_POST['barcode'])."',
														`code` = '".mysqli_real_escape_string($conn, $_POST['code'])."',
														`manufcode` = '".mysqli_real_escape_string($conn, $_POST['manufcode'])."',
														`manufname` = '".mysqli_real_escape_string($conn, $default_manufname)."',
														`name` = '".mysqli_real_escape_string($conn, $default_name)."',
														`altername` = '".mysqli_real_escape_string($conn, $default_altername)."',
														`pricevisibility` = '".mysqli_real_escape_string($conn, $_POST['pricevisibility'])."',
														`taxid` = '".mysqli_real_escape_string($conn, $_POST['taxid'])."',
														`type` = '".mysqli_real_escape_string($conn, $_POST['type'])."',
														`unitname` = '".mysqli_real_escape_string($conn, $default_unitname)."',
														`unitstep` = '".mysqli_real_escape_string($conn, $_POST['unitstep'])."',
														`rebate` = '".mysqli_real_escape_string($conn, $_POST['rebate'])."',
														`webrebate` = '".mysqli_real_escape_string($conn, $_POST['webrebate'])."',
														`brendid` = '".mysqli_real_escape_string($conn, $_POST['brendid'])."',
														`sort` = '".mysqli_real_escape_string($conn, $_POST['sort'])."',
														`developer` = '".mysqli_real_escape_string($conn, $default_developer)."',
														`developerlink` = '".mysqli_real_escape_string($conn, $_POST['developerlink'])."',
														`numberofdownloads` = '".mysqli_real_escape_string($conn, $_POST['numberofdownloads'])."',
														`searchwords` = '".mysqli_real_escape_string($conn, $_POST['searchwords'])."'   ";
							
		//var_dump($query);
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' || $lastid == 0) $lastid = $main_productid;
		
		
		$query = "INSERT INTO `productdetail`(`productid`, `characteristics`, `description`, `model`, `specification`,`ts`) 
									VALUES (".$main_productid.", 
											'".mysqli_real_escape_string($conn, $default_characteristicts)."',
											'".mysqli_real_escape_string($conn, $default_description)."',
											'".mysqli_real_escape_string($conn, $default_model)."',
											'".mysqli_real_escape_string($conn, $default_specification)."',
											CURRENT_TIMESTAMP
											) 
						ON DUPLICATE KEY UPDATE `characteristics` = '".mysqli_real_escape_string($conn, $default_characteristicts)."' ,
												`description` = '".mysqli_real_escape_string($conn, $default_description)."' , 
												`model` = '".mysqli_real_escape_string($conn, $default_model)."' ,
												`specification` = '".mysqli_real_escape_string($conn, $default_specification)."' , 
												`ts` = CURRENT_TIMESTAMP  ";
		
		mysqli_query($conn, $query);	
			
		$defaultnewsid=0;
		if($main_productid == ""){
			userlog($_SESSION['moduleid'], "", $main_productid, $_SESSION['id'], "add");
			$defaultnewsid=$lastid;
		}else{
			userlog($_SESSION['moduleid'], "", $main_productid, $_SESSION['id'], "change");
			$defaultnewsid=$main_productid;			
		}
		$err = 0;
		
		
		echo json_encode(array($err));
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

	function setSearchData(){
		if(!isset($_SESSION['search'])){
			$_SESSION['search']=array();
		}
		if(!isset($_SESSION['search']['product'])){
			$_SESSION['search']['product']=array();
		}

		$_SESSION['search']['product']['active']=$_POST['active'];
		$_SESSION['search']['product']['type']=$_POST['type'];
		$_SESSION['search']['product']['code']=$_POST['code'];
		$_SESSION['search']['product']['barcode']=$_POST['barcode'];
		$_SESSION['search']['product']['name']=$_POST['name'];
		$_SESSION['search']['product']['manufcode']=$_POST['manufcode'];
		$_SESSION['search']['product']['manufname']=$_POST['manufname'];
		$_SESSION['search']['product']['b2cpricefrom']=$_POST['b2cpricefrom'];
		$_SESSION['search']['product']['b2cpriceto']=$_POST['b2cpriceto'];
		$_SESSION['search']['product']['b2bpricefrom']=$_POST['b2bpricefrom'];
		$_SESSION['search']['product']['b2bpriceto']=$_POST['b2bpriceto'];
		$_SESSION['search']['product']['amountfrom']=$_POST['amountfrom'];
		$_SESSION['search']['product']['amountto']=$_POST['amountto'];
		$_SESSION['search']['product']['withimage']=$_POST['withimage'];
		$_SESSION['search']['product']['withcategory']=$_POST['withcategory'];
		$_SESSION['search']['product']['withextcategory']=$_POST['withextcategory'];
		//$_SESSION['search']['product']['localcommunityid']=$_POST['localcommunityid'];
		//$_SESSION['search']['product']['streetid']=$_POST['streetid'];
		//$_SESSION['search']['product']['zip']=$_POST['zip'];
		//$_SESSION['search']['product']['ethnicity']=$_POST['ethnicity'];
		//$_SESSION['search']['product']['gender']=$_POST['gender'];
		//$_SESSION['search']['product']['phone']=$_POST['phone'];
		//$_SESSION['search']['product']['email']=$_POST['email'];
		//$_SESSION['search']['product']['qualificationlevelid']=$_POST['qualificationlevel'];
		//$_SESSION['search']['product']['active']=$_POST['status'];
		//$_SESSION['search']['product']['memberdate_start']=$_POST['startdatefrom'];
		//$_SESSION['search']['product']['memberdate_end']=$_POST['startdateto'];
		//$_SESSION['search']['product']['workstatus']=$_POST['workstatus'];
		//$_SESSION['search']['product']['marriedstatus']=$_POST['marriedstatus'];



		/**/	

	}
	function clearSearchData(){
		if(isset($_SESSION['search']['product'])){
			unset($_SESSION['search']['product']);
		}
	}


	function getProductWarehouse(){
		global $conn, $system_conf, $user_conf;

		$aColumns = array(  'pw.warehouseid', 'pw.productid', 'w.name');//
		$sIndexColumn = "pw.warehouseid";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS pw.*, 
											  w.name AS `warehousename` ,
											  ROUND(pw.price*(1+(t.value/100)),2) AS `pricevat`, 
											  ROUND(pw.price*(1+(t.value/100))*(1-(p.webrebate/100)),2) AS `pricevatwebrebate` 
						FROM `productwarehouse` AS pw 
						LEFT JOIN product AS p ON pw.productid=p.id 
						LEFT JOIN tax AS t on p.taxid=t.id
						LEFT JOIN warehouse AS w ON pw.warehouseid=w.warehouseid
						WHERE pw.productid=".$_POST["productid"]."  AND pw.warehouseid IN (".$user_conf["b2cwh"][1].",".$user_conf["b2bwh"][1].")
					$sWhere 
					GROUP BY pw.productid, pw.warehouseid
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(pw.warehouseid) FROM `productwarehouse` AS pw WHERE pw.productid=".$_POST["productid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
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
			$row[1] = $aRow['warehousename'];
			$row[2] = $aRow['amount'];
			$row[3] = $aRow['price'];
			$row[4] = $aRow['pricevat'];
			$row[5] = $aRow['pricevatwebrebate'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['warehouseid'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	function updateProductWarehousePrice(){
		global $conn;
		$query = "UPDATE productwarehouse SET price = ".mysqli_real_escape_string($conn, $_POST['newprice'])." 
				    WHERE productid = ".$_POST['productid']." AND warehouseid =".$_POST['warehouseid'];
		mysqli_query($conn, $query);
	}

	function updateProductWarehouseAmount(){
		global $conn;
		$query = "UPDATE productwarehouse SET amount = ".mysqli_real_escape_string($conn, $_POST['newamount'])." 
				    WHERE productid = ".$_POST['productid']." AND warehouseid =".$_POST['warehouseid'];
		mysqli_query($conn, $query);
	}

	function addProductWarehouse(){
		global $conn;
		$query="DELETE FROM productwarehouse WHERE productid=".$_POST['productid']." AND warehouseid=".$_POST['warehouseid'];
		mysqli_query($conn, $query);
		$query = "INSERT INTO `productwarehouse`(`productid`, `warehouseid`, `amount`, `price`) 
					VALUES (".mysqli_real_escape_string($conn, $_POST['productid']).", 
							".mysqli_real_escape_string($conn, $_POST['warehouseid']).", 
							".mysqli_real_escape_string($conn, $_POST['newAmount']).", 
							".mysqli_real_escape_string($conn, $_POST['newPrice']).")";
			mysqli_query($conn, $query);
	}

	function deleteProductWarehouse(){
		global $conn;
		$query = "DELETE FROM productwarehouse 
				    WHERE productid = ".$_POST['productid']." AND warehouseid =".$_POST['warehouseid'];
		mysqli_query($conn, $query);
	}

	function getProductApplications(){
		global $conn, $system_conf, $user_conf;

		$aColumns = array(  'papp.type', 'papp.link', 'papp.status', 'papp.sort');//
		$sIndexColumn = "papp.id";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS papp.* 
						FROM `product_app` AS papp 
						WHERE papp.productid=".$_POST["productid"]."  
					$sWhere 
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(papp.id) FROM `product_app` AS papp WHERE papp.productid=".$_POST["productid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
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
			$appType="";
			switch ($aRow['type']) {
		    case 'googleplay':
		        $appType="Google Play";
		        break;
		    case 'appstore':
		        $appType="App Store";
		        break;
		    case 'amazon':
		        $appType="Amazon";
		        break;
		    case 'steam':
		        $appType="Steam";
		        break;
		    case 'oculus':
		        $appType="Oculus Rift";
		        break;
		    case 'facebook':
		        $appType="Facebook";
		        break;
		    case 'n':
		        $appType="---";
		        break;
			}



			$row[1] = $appType;
			$row[2] = $aRow['link'];
			$row[3] = $aRow['status'];
			$row[4] = $aRow['sort'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['id'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	function addProductApplication(){
		global $conn;
		$query = "INSERT INTO `product_app`(`productid`, `type`, `link`, `status`, `sort`) 
					VALUES (".mysqli_real_escape_string($conn, $_POST['productid']).", 
							'".mysqli_real_escape_string($conn, $_POST['type'])."', 
							'".mysqli_real_escape_string($conn, $_POST['link'])."', 
							'h',0)";
		mysqli_query($conn, $query);
	}

	function deleteProductApplication(){
		global $conn;
		$query = "DELETE FROM product_app 
				    WHERE productid = ".$_POST['productid']." AND id =".$_POST['id'];
		mysqli_query($conn, $query);
	}

	function changeProductApplicationStatus(){
		global $conn;
		$query = "UPDATE product_app SET status = '".mysqli_real_escape_string($conn, $_POST['status'])."' 
				    WHERE id = ".$_POST['id'];
		mysqli_query($conn, $query);
	}

	function getProductCategorys(){
		global $conn;

		$aColumns = array(  'pc.categoryid', 'c.name');//
		$sIndexColumn = "pc.categoryid";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS pc.*, c.name ,getCategoryPath(pc.categoryid) AS `catpath` FROM `productcategory` AS pc LEFT JOIN category AS c ON pc.categoryid=c.id WHERE pc.productid=".$_POST["productid"]." 
					$sWhere 
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(pc.categoryid) FROM `productcategory` AS pc WHERE pc.productid=".$_POST["productid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
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
			$row[1] = $aRow['name'];
			$row[2] = $aRow['catpath'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['categoryid'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
		
	}

	function getProductExternalCategorys(){
		global $conn;

		$aColumns = array(  'pc.categoryid', 'c.name');//
		$sIndexColumn = "pc.categoryid";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS pc.*, c.name ,getExternalCategoryPath(pc.categoryid) AS `catpath` FROM `productcategory_external` AS pc LEFT JOIN category_external AS c ON pc.categoryid=c.id WHERE pc.productid=".$_POST["productid"]." 
					$sWhere 
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(pc.categoryid) FROM `productcategory_external` AS pc WHERE pc.productid=".$_POST["productid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
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
			$row[1] = $aRow['name'];
			$row[2] = $aRow['catpath'];
			
			$row[98] = $aRow['productid'];	
			$row[99] = $aRow['categoryid'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
		
	}

	function getMemberDocuments(){
		global $conn;

		$aColumns = array(  'd.`id`','dt.name', 'd.`name`', 'd.`documentdate`','d.`status`','d.`solvedstatus`');//
		$sIndexColumn = "d.id";


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

		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= " ".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
	
		$data = array();
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS d.*, dt.name AS `documenttype` FROM `document` AS d 
					LEFT JOIN documenttype AS dt ON d.documenttypeid=dt.id WHERE d.memberid=".$_POST["memberid"]." 
					$sWhere 
					$sOrder
					$sLimit
		";

		//echo $sQuery;
	
		$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));

		$sQuery = "SELECT FOUND_ROWS()";
		$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
	
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(d.id) FROM `document` AS d WHERE d.memberid=".$_POST["memberid"];
		$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = mysqli_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

		/*Output*/
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
			$row[1] = $aRow['documenttype'];
			$row[2] = $aRow['name'];
			$row[3] = date(DATE_FORMAT, strtotime($aRow['documentdate']));
			$row[4] = $aRow['status'];
			$row[5] = $aRow['solvedstatus'];
			
			$row[99] = $aRow['id'];	

			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
		
	}

	
?>