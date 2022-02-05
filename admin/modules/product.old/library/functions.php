<?php
	global $subdirectory ;
	$subdirectory = "";
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../../../app/configuration/system.configuration.php");
	include("../../../../".$system_conf["theme_path"][1]."config/user.configuration.php");

	session_start();

	mb_internal_encoding("UTF-8");
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "addChangeExtradetail" : add_Change_Extradetail(); break;
			case "deleteExtradetail" : delete_Extradetail(); break;
			case "getExtradetail" : get_Extradetail(); break;
			
			case "addChangeRelations" : add_Change_Relations(); break;
			case "getRelations" : get_Relations(); break;
			case "relationsGetProductByCode": relations_Get_Product_By_Code(); break;
						
			case "changeSortExtradetail" : change_Sort_Extradetail(); break;
			case "changeStatusExtradetail" : change_Status_Extradetail(); break;
			
			case "getAllCategory" : get_All_Category(); break;
			
			case "getProductCategory" : get_Product_Category(); break;
			case "addChangeProductCategory" : add_Change_Product_Category(); break;
			case "deleteProductCategory" : delete_Product_Category(); break;
			
			case "getproduct" : get_Product(); break;
			case "updateProduct" : update_Product(); break;
			case "deleteProduct" : delete_Product(); break;
			
			case "addnewprodownload" : add_new_pro_download(); break;
			case "deleteprodownload" : delete_pro_download(); break;
			
			case "updatecategory" : update_category(); break;
			case "deleteimage" : delete_image(); break;
			
			case "updateimagesort" : update_image_sort(); break;
			case "updateProductExtraDetail" : update_Product_Extra_Detail(); break;
			
			case "addrelations" : add_relations(); break;		
			case "deleteprodrelations" : delete_prod_relations(); break;	
			
			case "updateProductAttrValue" : update_Product_Attr_Value(); break;
			
			case "getlanguageslist" : getLanguagesList(); break;
			
			case "getattrvalues" : get_attr_values(); break;
			case "saveimgattrvalue" : save_img_attr_value(); break;		
			case "changeProductcode" : change_Productcode(); break;	
			case "changeProductSort" : change_ProductSort(); break;		
			
			case "addnewproduct" : add_new_product(); break;		
			
			case "addNewProductQuantity" : add_New_Product_Quantity(); break;
			case "changeproductquantitystatus" : change_Product_Quantity_Status(); break;
			case "deleteprorebate" : delete_pro_rebate(); break;
			
			case "addNewProductBarometar" : add_New_Product_Barometar(); break;
			case "deleteproBarometar" : delete_pro_barometar(); break;
			
			case "getBarometarDate" : get_Barometar_Date(); break;
			case "copyBarometar" : copy_Barometar(); break;
			
		}
		
	}
	
	function get_category_tree_up($catid, $cont = array())
	{
		global $conn;

		$query = "SELECT * FROM category WHERE id = ".$catid;
		$r = mysqli_query($conn,$query);
		if(mysqli_num_rows($r) > 0)
		{	
			$row = mysqli_fetch_assoc($r);

			if($row['parentid'] != 0)
			{
				
				array_push($cont, array('id' => $row['id'],'partnerid' => $row['parentid'], 'name' =>$row['name']));
				$cont = get_category_tree_up($row['parentid'], $cont);
			}else{
				array_push($cont, array('id' => $row['id'],'partnerid' => $row['parentid'], 'name' => $row['name']));
			}

			
		}	

		return $cont;

	}


	function get_category_path($catid){
		$data = get_category_tree_up($catid);
		$string = '';
		$data = array_reverse($data);
		foreach($data as $k=>$v){
			$string .= rawurlencode($v['name']).DIRECTORY_SEPARATOR;
		}
		return substr($string, 0, -1);
	}






	/**	function for all category list START	*/
	
	function get_all_deepest_cat($parid, $string)
	{
		global $conn;
		$tmpstring = $string;
		$query = "SELECT * FROM category WHERE id = ".$parid;
		$r = mysqli_query($conn,$query);
		if(mysqli_num_rows($r) > 0)
		{
	
		$row = mysqli_fetch_assoc($r);
			if($row['parentid'] == 0)
			{
				$tmpstring .= ">>".$row['name'];
				return $tmpstring;
			}
			else
			{		
				return ">>".$row['name'].get_all_deepest_cat($row["parentid"],$tmpstring);		
			}
		}	
	}


	
	function all_cat_php()
	{
		global $conn;
		$query = "SELECT * FROM category ";
		$result = mysqli_query($conn, $query);
		$i = 1;
		$bdata = array();
		while($ar = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			if($ar["parentid"] == 0)
			{
				$data = array();
				array_push($data, $ar["id"]);
				array_push($data, $ar["name"]);
				array_push($bdata, $data);
			}
			else
			{
				$data = explode(">>", get_all_deepest_cat($ar["parentid"],""));
				unset($data[0]);
				array_push($data,$ar["id"]); 
				$data = array_reverse($data);		
				array_push($data, $ar["name"]);
				array_push($bdata, $data);
			}
		}
		return json_encode($bdata);	
	}

	/**	function for all category list END	*/
	
	/**
	 * Update/add new extradetail
	 *
	 * @param id   $_POST['id']
	 * @param data $_POST['data'] extradetail data
	 *					{
	 *	 					$_POST['data']['name']
	 *						$_POST['data']['image']
	 *						$_POST['data']['status']
	 *					}
	 * 
	 * @return JSON array (function status, afected row id)
	 */ 
	 
	function add_Change_Extradetail(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";

		foreach($_POST['data'] as $k=>$v){
			if($v['default'] == 'y'){
				$query = "INSERT INTO `extradetail`(`id`, `name`, `image`, `sort`, `status`,`showinwelcomepage`,`showinwebshop`,`banerid`, `ts`) 
				VALUES ('".$_POST['id']."', 
						'".mysqli_real_escape_string($conn, $v['name'])."', 
						'".mysqli_real_escape_string($conn, $v['image'])."', 
						0, 
						'".$v['status']."', 
						'".mysqli_real_escape_string($conn, $v['showinwelcomepage'])."',
						'".mysqli_real_escape_string($conn, $v['showinwebshop'])."',
						'".mysqli_real_escape_string($conn, $v['banerid'])."',
						CURRENT_TIMESTAMP) 
						ON DUPLICATE KEY UPDATE name = '".mysqli_real_escape_string($conn, $v['name'])."', 
												image = '".mysqli_real_escape_string($conn, $v['image'])."', 
											   `status` = '".$v['status']."',
											   `showinwelcomepage`= '".mysqli_real_escape_string($conn, $v['showinwelcomepage'])."',
											   `showinwebshop`= '".mysqli_real_escape_string($conn, $v['showinwebshop'])."',
											   `banerid`= '".mysqli_real_escape_string($conn, $v['banerid'])."'    ";
				if(!mysqli_query($conn, $query))
				{
					$err = 1;	
				}else{
					$lastid = mysqli_insert_id($conn);	
				}
			}
			
			$query = "INSERT INTO `extradetail_tr`(`extradetailid`, `langid`, `name`, `image`, `ts`) VALUES (".$lastid.", ".$v['langid'].", '".mysqli_real_escape_string($conn, $v['name'])."', '".mysqli_real_escape_string($conn, $v['image'])."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".mysqli_real_escape_string($conn, $v['name'])."', `image` = '".mysqli_real_escape_string($conn, $v['image'])."'";
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
		}
		
		

		echo json_encode(array($err, $lastid));		
	}
	
	/**
	 * delete extradetail
	 *
	 * @param id   $_POST['id']
	 * 
	 * @return JSON array (function status, afected row id)
	 */ 
	function delete_Extradetail(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";
		$query = "DELETE FROM `extradetail` WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query))
		{
			$err = 1;	
		}
		$query = "DELETE FROM `extradetail_tr` WHERE extradetailid=".$_POST['id'];
		if(!mysqli_query($conn, $query))
		{
			$err = 1;	
		}
		$lastid = $_POST['id'];
		echo json_encode(array($err, $lastid));		
	}
	
	/**
	 * get one or more extradetail
	 *
	 * @param id   $_POST['id']	if not specified returns all extradetail 
	 * 
	 * @return JSON array (function status, array of extradetails)
	 */ 
	function get_Extradetail(){
		global $conn, $lang;
		$err = 0;
		$data = array();
		$data['lang'] = array();
		
		$q = "SELECT * FROM languages l ORDER BY `default` ASC";
		$resl = mysqli_query($conn, $q);
		
		$where = "";
		if($_POST['id'] != ""){
			/**	return 1 extradetail	*/	
			$where = " WHERE ed.id = ".$_POST['id']." ";
			
		}
		
		while($rowl = mysqli_fetch_assoc($resl)){
			$q = "SELECT ed.*, (SELECT name FROM extradetail_tr WHERE extradetailid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as nametr,
								(SELECT image FROM extradetail_tr WHERE extradetailid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as imagetr FROM extradetail ed
						".$where." ORDER BY ed.sort ASC";
			$res = mysqli_query($conn, $q);
			while($row = mysqli_fetch_assoc($res))
			{
				array_push($data['lang'],array('langid'=>$rowl['id'],
												'langname'=>$rowl['name'],
												'default'=>$rowl['default'],
												'id'=>$row['id'],
												'status'=>$row['status'],
												'showinwelcomepage'=>$row['showinwelcomepage'],
												'showinwebshop'=>$row['showinwebshop'],
												'banerid'=>$row['banerid'],
												'name'=>($row['nametr'] == NULL && $rowl['default'] == 'y')? $row['name']:$row['nametr'],
												'image'=>($row['imagetr'] == NULL && $rowl['default'] == 'y')? $row['image']:$row['imagetr']));
			}
		}
					
		echo json_encode(array($err, $data));		
	}
	
	function get_Relations(){
		global $conn, $lang;
		$err = 0;
		$data = array();
		$data['lang'] = array();
		
		$q = "SELECT * FROM languages l ORDER BY `default` ASC";
		$resl = mysqli_query($conn, $q);
		
		$where = "";
		if($_POST['id'] != ""){
			/**	return 1 extradetail	*/	
			$where = " WHERE r.id = ".$_POST['id']." ";
			
		}
		
		while($rowl = mysqli_fetch_assoc($resl)){
			$q = "SELECT r.*, (SELECT name FROM relations_tr WHERE relationsid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as nametr FROM relations r
						".$where." ORDER BY r.sort ASC";
			$res = mysqli_query($conn, $q);
			while($row = mysqli_fetch_assoc($res))
			{
				array_push($data['lang'],array('langid'=>$rowl['id'],
												'langname'=>$rowl['name'],
												'default'=>$rowl['default'],
												'id'=>$row['id'],
												'status'=>$row['status'],
												'name'=>($row['nametr'] == NULL && $rowl['default'] == 'y')? $row['name']:$row['nametr']));
			}
		}
					
		echo json_encode(array($err, $data));		
	}
	
	function relations_Get_Product_By_Code(){
		global $conn, $lang;
		$err = 0;
		$data = array();
		
		$q = "SELECT code, name FROM product p WHERE code = '".mysqli_real_connect($conn, $row['code'])."%' LIMIT 100";
		$res = mysqli_query($conn, $q);
		while($row = mysqli_fetch_assoc($res))
		{
			array_push($data, $row);
		}
		echo json_encode(array($err, $data));	
	}
	
	function add_Change_Relations(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";

		foreach($_POST['data'] as $k=>$v){
			if($v['default'] == 'y'){
				$query = "INSERT INTO `relations`(`id`, `name`,  `sort`, `status`, `ts`) VALUES ('".$_POST['id']."', '".mysqli_real_escape_string($conn, $v['name'])."',  0, '".$v['status']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".mysqli_real_escape_string($conn, $v['name'])."', `status` = '".$v['status']."'";
				if(!mysqli_query($conn, $query))
				{
					$err = 1;	
				}else{
					$lastid = mysqli_insert_id($conn);	
				}
			}
			
			$query = "INSERT INTO `relations_tr`(`relationsid`, `langid`, `name`, `ts`) VALUES (".$lastid.", ".$v['langid'].", '".mysqli_real_escape_string($conn, $v['name'])."',  CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".mysqli_real_escape_string($conn, $v['name'])."'";
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
		}
		
		

		echo json_encode(array($err, $lastid));		
	}

	/**
	 * Update extradetail sort colum
	 *
	 * @param id   $_POST['id']
	 * @param value $_POST['value']
	 * 
	 * @return JSON array (function status, afected row id)
	 */ 
	 
	function change_Sort_Extradetail(){
		global $conn, $lang;
		$err = 0;
				
		echo json_encode(array($err, $lastid));		
	}
	
	/**
	 * Update extradetail status colum
	 *
	 * @param id   $_POST['id']
	 * @param value $_POST['value']
	 * 
	 * @return JSON array (function status, afected row id)
	 */ 
	 
	function change_Status_Extradetail(){
		global $conn, $lang;
		$err = 0;
				
		echo json_encode(array($err, $lastid));		
	}
	
	/**
	 * get all categories
	 *
	 * 
	 * @return JSON array (function status, array of categories)
	 */
	function get_All_Category(){
		global $conn, $lang;
		$err = 0;
		$data = array();
		
		$query = "SELECT id, name FROM lat_categorypr";
		$re = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($re))
		{
			array_push($data, $row);	
		}
		echo json_encode(array($err, $data));	
	}
	
	/**
	 * get all product categories
	 *
	 * @param id   $_POST['id']	
	 * 
	 * @return JSON array (function status, array of categories)
	 */ 
	function get_Product_Category()
	{
		global $conn, $lang;
		$err = 0;
		$data = array();
		
		$query = "SELECT * FROM productcategorypr WHERE producid =".$_POST['id'];
		$re = mysqli_query($conn,$query);
		while($row = mysqli_fetch_assoc($re))
		{
			array_push($data, array($row['id'],$row['categoryid']));
		}
			
		echo json_encode(array($err, $data));		
	}
	
	/**
	 * Update/add new extradetail
	 *
	 * @param id   $_POST['id']
	 * @param productidid   $_POST['productid']
	 * @param categoryid   $_POST['categoryid']
	 * 
	 * @return JSON array (function status, afected row id)
	 */ 
	function add_Change_Product_Category(){
		global $conn, $lang;
		$err = 0;
		
		if($_POST['id'] == ""){
			$query = "INSERT INTO `productcategorypr` (`id`, `productid`, `categoryid`, `productcategoryprts`) VALUES (NULL, '".$_POST['productid']."', '".$_POST['categoryid']."', CURRENT_TIMESTAMP)";
			if(!mysqli_query($conn, $query))
			{
				$lastid = mysqli_insert_id($conn);
				$err = 1;	
			}
		}
		else{
			$query = "UPDATE `productcategorypr` SET `categoryid`=[value-3] WHERE id=".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$lastid = $_POST['id'];
				$err = 1;	
			}	
		}
		echo json_encode(array($err, $lastid));	
	}


	/**
	 * delete productcategory
	 *
	 * @param id   $_POST['id']
	 * 
	 * @return JSON array (function status, afected row id)
	 */ 
	function delete_Product_Category(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";
		$query = "DELETE FROM `productcategorypr` WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query))
		{
			$err = 1;	
		}
		$lastid = $_POST['id'];
		echo json_encode(array($err, $lastid));		
	}
	
	/**
	 * get all product data
	 *
	 * @param id   $_POST['id']	
	 * 
	 * @return JSON array (function status, array of categories)
	 */
	function get_Product(){
		global $conn, $lang, $subdirectory,$system_conf, $user_conf;
		$data = array();
		$data['lang'] = array();
		
		$q = "SELECT * FROM languages l ORDER BY `default` ASC";
		$resl = mysqli_query($conn, $q);
		
		$first = true;
		$productname='';
		while($rowl = mysqli_fetch_assoc($resl)){
			$q = "SELECT p.*, (SELECT name FROM product_tr WHERE productid = ".$_POST['id']." AND langid = ".$rowl['id'].") as nametr, 
							(SELECT manufname FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as manufnametr,
							(SELECT unitname FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as unitnametr,
							(SELECT searchwords FROM product_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as searchwordstr,
							(SELECT price FROM productwarehouse WHERE productid = ".$_POST['id']."  AND warehouseid = ".$user_conf["b2cwh"][1].") as priceb2c,
							(SELECT price FROM productwarehouse WHERE productid = ".$_POST['id']."  AND warehouseid = ".$user_conf["b2bwh"][1].") as priceb2b,
							(SELECT p.name FROM product p WHERE id = ".$_POST['id'].") as originname,
							(SELECT amount FROM productwarehouse WHERE productid = ".$_POST['id']." AND warehouseid = ".$user_conf["b2cwh"][1].") as quantityb2c,
							(SELECT amount FROM productwarehouse WHERE productid = ".$_POST['id']." AND warehouseid = ".$user_conf["b2bwh"][1].") as quantityb2b, 
							t.value as `taxvalue` 
							FROM `product` p  
							LEFT JOIN tax AS t ON p.taxid=t.id
							WHERE p.id=".$_POST['id'];

			//echo $q;
			$res = mysqli_query($conn, $q);				
			$rowpro = mysqli_fetch_assoc($res);
														
			$q = "SELECT pd.*, (SELECT characteristics FROM productdetail_tr WHERE productid = ".$_POST['id']." AND langid = ".$rowl['id'].") as characteristicstr, 
							(SELECT description FROM productdetail_tr WHERE productid = ".$_POST['id']." AND langid = ".$rowl['id'].") as descriptiontr,
							(SELECT model FROM productdetail_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as modeltr, 
							(SELECT specification FROM productdetail_tr WHERE productid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as specificationtr FROM `productdetail` pd WHERE pd.productid=".$_POST['id'];
							
			$res = mysqli_query($conn, $q);											
			$rowprodet = mysqli_fetch_assoc($res);	
			$productname=$rowpro['originname'];
			if($first){
				$data['id'] = $rowpro['id'];
				$data['active'] = $rowpro['active'];
				$data['code'] = $rowpro['code'];
				$data['barcode'] = $rowpro['barcode'];
				$data['manufcode'] = $rowpro['manufcode'];
				$data['taxid'] = $rowpro['taxid'];
				$data['type'] = $rowpro['type'];
				$data['priceb2c'] = $rowpro['priceb2c'];
				$data['priceb2b'] = $rowpro['priceb2b'];
				$data['priceb2cwithvat'] = round($rowpro['priceb2c']*(1+($rowpro['taxvalue']/100)),2);
				$data['priceb2bwithvat'] = round($rowpro['priceb2b']*(1+($rowpro['taxvalue']/100)),2);
				$data['rebate'] = $rowpro['rebate'];
				$data['quantity'] = ($rowpro['quantityb2c'] != '')? $rowpro['quantityb2c']:$rowpro['quantityb2b'];
				$data['extendwarrnity'] = $rowpro['extendwarrnity'];
				$data['brendid'] = $rowpro['brendid'];	
				$data['unitstep'] = $rowpro['unitstep'];
				$first = false;
			}
			
			
			
			array_push($data['lang'],array('langid'=>$rowl['id'],
											'langname'=>$rowl['name'],
											'default'=>$rowl['default'],
											'name'=>($rowpro['nametr'] == NULL && $rowl['default'] == 'y')? $rowpro['name']:$rowpro['nametr'],
											'manufname'=>($rowpro['manufnametr'] == NULL && $rowl['default'] == 'y')? $rowpro['manufname']:$rowpro['manufnametr'],
											'unitname'=>($rowpro['unitnametr'] == NULL && $rowl['default'] == 'y')? $rowpro['unitname']:$rowpro['unitnametr'],
											'searchwords'=>($rowpro['searchwordstr'] == NULL && $rowl['default'] == 'y')? $rowpro['searchwords']:$rowpro['searchwordstr'],
											'characteristics'=>($rowprodet['characteristicstr'] == NULL && $rowl['default'] == 'y')? $rowprodet['characteristics']:$rowprodet['characteristicstr'],
											'description'=>($rowprodet['descriptiontr'] == NULL && $rowl['default'] == 'y')? $rowprodet['description']:$rowprodet['descriptiontr'],
											'model'=>($rowprodet['modeltr'] == NULL && $rowl['default'] == 'y')? $rowprodet['model']:$rowprodet['modeltr'],
											'specification'=>($rowprodet['specificationtr'] == NULL && $rowl['default'] == 'y')? $rowprodet['specification']:$rowprodet['specificationtr']));							
		}
		//var_dump($data);
		/*
			$data['b2bprice'] = $row['b2bprice'];
			$data['b2cprice'] = $row['b2cprice'];
			$data['b2bcategory'] = $row['b2bcategory'];
			$data['b2ccategory'] = $row['b2ccategory']; 
		*/
		
		/* get category	*/
		
		$data['categoryid'] = array();
		
		$query = "SELECT * FROM productcategory WHERE productid = ".$_POST['id'];
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result)){
				array_push($data['categoryid'], $row['categoryid']);	
			}			
		}
		else
		{
			$data['categoryid'] = 0;
		}

		$data['productlink'] = '';
		if($data['categoryid'] != 0 && count($data['categoryid'])>0){
			$data['productlink'] = BASE_URL.get_category_path($data['categoryid'][0]).DIRECTORY_SEPARATOR.$_POST['id'].'-'.rawurlencode($productname);
		}
		
		/*	get product images	*/
		
		$query = "SELECT pf.*, (SELECT attrid FROM attrval WHERE id=pf.attrvalid) as attrid FROM product_file pf WHERE pf.productid=".$_POST['id']." AND pf.type = 'img' ORDER BY pf.sort ASC";
		$result = mysqli_query($conn, $query);
		
		$data['images'] = array();
		
		while($row = mysqli_fetch_assoc($result)){
			array_push($data['images'], array("id"=>$row['id'], "thumb"=>"../fajlovi/product/thumb/".basename($row['content']), "big"=>"../fajlovi/product/big/".basename($row['content']),
			'attrvalid'=>$row['attrvalid'], 'attrid'=>$row['attrid']));
		}
		
		
		/*	get product documents	*/
		
		$query = "SELECT * FROM product_file WHERE productid=".$_POST['id']." ORDER BY type ";
		$result = mysqli_query($conn, $query);
		
		$data['detail'] = array();
		
		$row = mysqli_fetch_assoc($result);
		$type = $row['type'];
		mysqli_data_seek($result,0);
		
		$data['detail'][$type] = array();
		
		while($row = mysqli_fetch_assoc($result))
		{
			if($row['type'] != $type){
				$type = $row['type'];
				$data['detail'][$type] = array();	
			}
			array_push($data['detail'][$type], array(rawurldecode($row['content']), rawurldecode($row['contentface']), $row['sort'], $row['id']));	
		}
		
		/*	get product extradetail	*/
		
		$data['extradetail'] = array();
		
		$query = "SELECT ed.id, ed.name, (SELECT ped.id FROM productextradetail ped WHERE extradetailid = ed.id AND productid = ".$_POST['id'].") as pedid 
		FROM extradetail ed ORDER BY ed.id ASC";
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data['extradetail'], array($row['id'], $row['name'], $row['pedid']));	
		}
		
		/*	get product relations	*/
		
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
		
		/*	get atributes	*/
		
		$data['atributes'] = array();
		if($data['categoryid'] != 0){
			$query = "SELECT ac.*, a.name as aname FROM attrcategory ac
					LEFT JOIN attr a ON ac.attrid = a.id
			 		WHERE ac.categoryid IN (".implode(',',$data['categoryid']).")";	
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
		}
		
		/*	QUANTITY REBATE	*/
		
		$data['qtyrebate'] = array();
		
		$query = "SELECT * FROM productquantityrebate WHERE productid=".$_POST['id']." ORDER BY quantity ASC";
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data['qtyrebate'], array('id'=>$row['id'], 'quantity'=>$row['quantity'], 'rebate'=>$row['rebate'], 'attrvalid'=>$row['attrvalid'], 'status'=>$row['status']));	
		}
		
		
		/*	BAROMETAR	*/
		
		$data['barometar'] = array();
		
		$query = "SELECT b.*, o.name FROM objectproduct_barometer b 
					LEFT JOIN object o ON b.objectid = o.id 
					WHERE productid=".$_POST['id']." ORDER BY o.name ASC";
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data['barometar'], array('id'=>$row['id'], 'min'=>number_format($row['price'],2 ), 'max'=>number_format($row['maxprice'],2), 'name'=>$row['name']));	
		}
			
		
		echo json_encode($data);	
	}
	
	function update_Product(){
		global $conn, $user_conf;
		$lastid = "";
		$err = 0;
		
		$q = "SELECT * FROM productwarehouse WHERE productid = ".$_POST['data']['id']." AND warehouseid =".$user_conf["b2cwh"][1];
		//echo $q;
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) == 0){
			$q = "INSERT INTO `productwarehouse`(`productid`, `warehouseid`, `amount`, `price`) VALUES (".$_POST['data']['id'].", ".$user_conf["b2cwh"][1].", 0, 0)";
			mysqli_query($conn, $q);
		}
		
		$q = "SELECT * FROM productwarehouse WHERE productid = ".$_POST['data']['id']." AND warehouseid =".$user_conf["b2bwh"][1];
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) == 0){
			$q = "INSERT INTO `productwarehouse`(`productid`, `warehouseid`, `amount`, `price`) VALUES (".$_POST['data']['id'].", ".$user_conf["b2bwh"][1].", 0, 0)";
			mysqli_query($conn, $q);
		}
		
		$q = "UPDATE productwarehouse SET price = ".mysqli_real_escape_string($conn, $_POST['data']['priceb2c']).", amount = ".mysqli_real_escape_string($conn, $_POST['data']['quantity'])."  WHERE productid = ".$_POST['data']['id']." AND warehouseid =".$user_conf["b2cwh"][1];
		mysqli_query($conn, $q);	
		$q = "UPDATE productwarehouse SET price = ".mysqli_real_escape_string($conn, $_POST['data']['priceb2b']).", amount = ".mysqli_real_escape_string($conn, $_POST['data']['quantity'])." WHERE productid = ".$_POST['data']['id']." AND warehouseid =".$user_conf["b2bwh"][1];
		mysqli_query($conn, $q);
				
		foreach($_POST['data']['lang'] as $k=>$v){
			
			if($v['default'] == 'y'){
				$name = $v['name'];
				$manufname = $v['manufname'];
				$unitname = $v['unitname'];
				$searchwords = $v['searchwords'];
				
				$q = "UPDATE `product` SET `active`='".mysqli_real_escape_string($conn, $_POST['data']['active'])."', 
					`barcode`='".mysqli_real_escape_string($conn, $_POST['data']['barcode'])."', 
					`code`= '".mysqli_real_escape_string($conn, $_POST['data']['code'])."', 
					`brendid`= '".mysqli_real_escape_string($conn, $_POST['data']['brendid'])."', 
					`taxid`= '".mysqli_real_escape_string($conn, $_POST['data']['taxid'])."', 
					`type`= '".mysqli_real_escape_string($conn, $_POST['data']['type'])."', 
					`rebate`= '".mysqli_real_escape_string($conn, $_POST['data']['rebate'])."', 
					`manufcode`= '".mysqli_real_escape_string($conn, $_POST['data']['manufcode'])."', 
					`manufname`= '".mysqli_real_escape_string($conn, $manufname)."', 
					`unitname`= '".mysqli_real_escape_string($conn, $unitname)."', 
					`unitstep`= ".mysqli_real_escape_string($conn,$_POST['data']['unitstep']).", 
					`name`= '".mysqli_real_escape_string($conn, $name)."', 
					`searchwords`= '".mysqli_real_escape_string($conn, $searchwords)."',
					`extendwarrnity`='".mysqli_real_escape_string($conn, $_POST['data']['extendwarrnity'])."'
				WHERE id = ".$_POST['data']['id'];
				//var_dump($q);
				if(!mysqli_query($conn, $q))
				{
					$err = 1;	
				}
				
				$q = "INSERT INTO `productdetail`(`productid`, `characteristics`, `description`, `model`, `specification`) VALUES (".$_POST['data']['id'].", '".mysqli_real_escape_string($conn, $v['characteristics'])."', '".mysqli_real_escape_string($conn, $v['description'])."', '".mysqli_real_escape_string($conn, $v['model'])."', '".mysqli_real_escape_string($conn, $v['specification'])."') ON DUPLICATE KEY UPDATE  `characteristics` = '".mysqli_real_escape_string($conn, $v['characteristics'])."', 
							`description` = '".mysqli_real_escape_string($conn, $v['description'])."', 
							`model` = '".mysqli_real_escape_string($conn, $v['model'])."', 
							`specification` = '".mysqli_real_escape_string($conn, $v['specification'])."'";
				
				if(!mysqli_query($conn, $q))
				{
					$err = 1;	
				}
			}
			
			$q = "INSERT INTO `product_tr`(`productid`, `langid`, `name`, `manufname`, `unitname`,`searchwords`, `ts`) VALUES (".$_POST['data']['id'].",
										".$v['langid'].", 
										'".mysqli_real_escape_string($conn, $v['name'])."', 
										'".mysqli_real_escape_string($conn, $v['manufname'])."', 
										'".mysqli_real_escape_string($conn, $v['unitname'])."', 
										'".mysqli_real_escape_string($conn, $v['searchwords'])."', 
										CURRENT_TIMESTAMP
								) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $v['name'])."', 
													`manufname` = '".mysqli_real_escape_string($conn, $v['manufname'])."', 
													`unitname` = '".mysqli_real_escape_string($conn, $v['unitname'])."', 
													`searchwords` = '".mysqli_real_escape_string($conn, $v['searchwords'])."'";
			
			if(!mysqli_query($conn, $q))
			{
				$err = 1;	
			}
			
			$q ="INSERT INTO `productdetail_tr`(`productid`, `langid`, `characteristics`, `description`, `model`, `specification`, `ts`) VALUES (
										".$_POST['data']['id'].",
										".$v['langid'].", 
										'".mysqli_real_escape_string($conn, $v['characteristics'])."',
										'".mysqli_real_escape_string($conn, $v['description'])."',
										'".mysqli_real_escape_string($conn, $v['model'])."',
										'".mysqli_real_escape_string($conn, $v['specification'])."',
										CURRENT_TIMESTAMP
								) ON DUPLICATE KEY UPDATE `characteristics` = '".mysqli_real_escape_string($conn, $v['characteristics'])."', 
														`description` = '".mysqli_real_escape_string($conn, $v['description'])."', 
														`model` = '".mysqli_real_escape_string($conn, $v['model'])."', 
														`specification` = '".mysqli_real_escape_string($conn, $v['specification'])."'";
			
			if(!mysqli_query($conn, $q))
			{
				$err = 1;	
			}
			
		}
				
		echo json_encode(array($err, $lastid));		
	}
	
	function delete_Product(){
		global $conn;
		$err = 0;
		
		$q = "DELETE FROM product WHERE id = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM attrprodval WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM productcategory WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM productcodecode WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM productwarehouse WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM productextradetail WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM productquantityrebate WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		$q = "DELETE FROM product_file WHERE productid = ".$_POST['proid'];	
		if(!mysqli_query($conn, $q)){
			$err = 1;
		}
		
		return $err;
	}
	
		
	/**
	 * add new  product download data
	 *	
	 * 
	 * @return JSON array (function status, array of categories)
	 */
	function add_new_pro_download(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		$query = "INSERT INTO `product_file`(`id`, `productid`, `type`, `content`, `contentface`, `attrvalid`, `status`, `sort`, `ts`) VALUES ('' , ".mysqli_real_escape_string($conn, $_POST['proid'])." , '".mysqli_real_escape_string($conn, $_POST['type'])."' , '".mysqli_real_escape_string($conn, $_POST['cont'])."' , '".mysqli_real_escape_string($conn, $_POST['contimg'])."', NULL ,'v' , 0 , CURRENT_TIMESTAMP)";
		//echo $query;
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}

		$lastid = mysqli_insert_id($conn);	
				
		echo json_encode(array($err, $lastid));	
	}
	
	/**
	 * delete product download
	 *
	 * @param id   $_POST['id']
	 * 
	 * @return JSON array (function status, afected row id)
	 */
	function delete_pro_download(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM product_file WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));	
	}
	
	function update_category()
	{
		global $conn, $lang;
		$err = 0;
		if($_POST['catid'] == 0){
			$q = "DELETE FROM productcategory WHERE `productid` = ".$_POST['proid']." AND `categoryid` = ".$_POST['prevcatid']."";	
			if(!mysqli_query($conn, $q)){
				$err = 1;	
			}
		}
		else{
			$q = "DELETE FROM productcategory WHERE `productid` = ".$_POST['proid']." AND `categoryid` = ".$_POST['prevcatid']."";	
			mysqli_query($conn, $q);
			$query = "INSERT INTO `productcategory`(`productid`, `categoryid`, `sort`, `status`, `ts`) VALUES (".$_POST['proid'].",".$_POST['catid'].", 0, 'v', CURRENT_TIMESTAMP) 
			ON DUPLICATE KEY UPDATE productid=".$_POST['proid']." , categoryid = ".$_POST['catid'];
			if(!mysqli_query($conn, $query)){
				$err = 1;	
			}
		}
		
		echo json_encode(array($err));		
	}
	
	function delete_image(){
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
	
	function update_image_sort(){
		global $conn;
	
		$i = 0;
		foreach($_POST['items'] as $k=>$v){
			$q = "UPDATE product_file SET sort = ".$i." WHERE id =".$v;	
			mysqli_query($conn, $q);
			$i++;
		}
	}

	function update_Product_Extra_Detail(){
		global $conn;
		$err = 0;

		if($_POST['status'] != 1)
		{
			$query = "DELETE FROM productextradetail WHERE productid = ".$_POST['proid']." AND extradetailid = ".$_POST['edid'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;
			}
		}
		else{
			$query = "INSERT INTO `productextradetail`(`id`, `productid`, `extradetailid`, `ts`) VALUES ('',".intval($_POST['proid']).", ".intval($_POST['edid']).",CURRENT_TIMESTAMP)";	
			
			if(!mysqli_query($conn, $query))
			{
				$err = 1;
			}	
		}

		echo json_encode(array($err));		
	}
	
	function add_relations(){
		global $conn, $lang;
		$err = 0;
		$data = array();
		
		
		
		$query = "SELECT id, code, name FROM product WHERE code ='".$_POST['code']."'";
		$re = mysqli_query($conn, $query);
		if(mysqli_num_rows($re) > 0)
		{
			$row = mysqli_fetch_assoc($re);
			
			$q = "SELECT productid FROM productrelations WHERE productid = ".$_POST['proid']." AND relatedproid = ".$row["id"]." AND relationsid = ".$_POST["relationid"];
			$res = mysqli_query($conn, $q);
			$num = (mysqli_num_rows($res))+1;
			
			$query = 'INSERT INTO `productrelations`(`productid`, `relatedproid`, `relationsid`, `sort`, `status`, `ts`) VALUES ('.$_POST['proid'].', '.$row["id"].', '.$_POST["relationid"].', '.$num.', "v",  CURRENT_TIMESTAMP)';
			if(mysqli_query($conn, $query))
			{
				array_push($data, array('id'=>$row['id'], 'code'=>$row['code'], 'name'=>$row['name']));	
			}
			else{
				$err = 1;	
			}
		}
		else{
			$err = 1;	
		}
		
		echo json_encode(array($err,$data));	
	}
	
	function delete_prod_relations(){
		global $conn;
		$err = 0;

		$query = "DELETE FROM productrelations WHERE productid=".$_POST['proid']." AND relatedproid = ".$_POST['relatedid']." AND relationsid =".$_POST['relationid'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));	
	}
	
	function update_Product_Attr_Value(){
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
	
	function get_attr_values(){
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
	
	function save_img_attr_value(){
		global $conn;
		
		$query = "UPDATE product_file SET attrvalid = ".$_POST['attrvalid']." WHERE id = ".$_POST['imageid'];
		mysqli_query($conn, $query);	
	}
	
	function change_Productcode(){
		global $conn;
		
		$query = "DELETE FROM `productcodecode` WHERE productid = ".$_POST['proid'];
		$re = mysqli_query($conn, $query);
		
		$query = "INSERT INTO `productcodecode`(`productid`, `productcode`, `ts`) VALUES (".$_POST['proid'].", ".$_POST['productcodeid'].", CURRENT_TIMESTAMP)";	
		$re = mysqli_query($conn, $query);
			
	}
	function change_ProductSort(){
		global $conn;
		
		
		$q = 'UPDATE product SET sort = "'.$_POST['newsort'].'" WHERE id ='.$_POST['proid'];
		$re = mysqli_query($conn, $q);
		
		//*	TODO	*/
		//* resort all	*/
	}
	
	function add_new_product(){
		global $conn, $user_conf;
		
		$lastid = 0;
		$q = "INSERT INTO `product`(`id`, `active`, `active_doc`, `barcode`, `code`, `inputprice`, `inputpricecurrency`, `manufcode`, `manufname`, `name`, `price`, `pricecurrency`, `taxid`, `type`, `unitname`, `foreignname`, `priceformula`, `kasaplu`, `kasagroupid`, `kasasort`, `supplyprice`, `planprice`, `rebate`, `webrebate`, `brendid`, `sort`, `searchwords`, `pricevisible`, `ts`) VALUES ('', 'n', 'n', '', '".mysqli_real_escape_string($conn, $_POST['code'])."', '', '', '', '', '".mysqli_real_escape_string($conn, $_POST['name'])."', 0, '', 0, '".mysqli_real_escape_string($conn, $_POST['type'])."', '', '', '', '', '', 0, '', '', 0, 0, 0, 0, '', 1, CURRENT_TIMESTAMP)";	
		$res = mysqli_query($conn, $q);
		
		$lastid = mysqli_insert_id($conn);
		
		$q = "INSERT INTO `productdetail` (`productid`, `characteristics`, `description`, `model`, `specification`, `treatment`, `taste`, `pakovanje`, `velicina`, `kolicina`, `warranty`, `originalcountry`, `exportcountry`, `importcountry`, `mass`, `commercialpackage`, `commercialpackagebarcode`, `transportpackage`, `transportpackagebarcode`, `minimalorderquantity`, `massgross`, `tariffnumber`, `additionalrebate`, `maxrebate`, `maxretailrebate`, `massunitname`, `secondunitname`, `secondunitnamecoefficient`, `ts`) VALUES (".$lastid.", '', '', NULL, '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP)";
		mysqli_query($conn, $q);
		
		$q = "INSERT INTO `productwarehouse` (`productid`, `warehouseid`, `amount`, `price`, `reservedamount`, `reversedamount`, `orderedamount`, `place`, `minstock`, `maxstock`, `ts`) VALUES (".$lastid.", ".$user_conf["b2cwh"][1].", '0', '0', '0', '0', '0', NULL, '0', '0', CURRENT_TIMESTAMP)";
		mysqli_query($conn, $q);
		$q = "INSERT INTO `productwarehouse` (`productid`, `warehouseid`, `amount`, `price`, `reservedamount`, `reversedamount`, `orderedamount`, `place`, `minstock`, `maxstock`, `ts`) VALUES (".$lastid.", ".$user_conf["b2bwh"][1].", '0', '0', '0', '0', '0', NULL, '0', '0', CURRENT_TIMESTAMP)";
		mysqli_query($conn, $q);
		
		echo json_encode($lastid);
	}
	
	function add_New_Product_Quantity(){
		global $conn;	
		
		$q = "INSERT INTO `productquantityrebate`(`id`, `productid`, `quantity`, `rebate`, `status`) VALUES ('', '".$_POST['proid']."', '".$_POST['quantity']."', '".$_POST['rebate']."', 'h') ON DUPLICATE KEY UPDATE rebate = '".$_POST['rebate']."'";	
		if(mysqli_query($conn, $q)){
			$lastid = mysqli_insert_id($conn);
			echo $lastid;
		}else{
			echo '0';	
		}
	}
	
	function change_Product_Quantity_Status(){
		global $conn;	
		
		$q = "UPDATE `productquantityrebate` SET status = '".$_POST['status']."' WHERE id = ".$_POST['id'];	
		
		if(mysqli_query($conn, $q)){
			echo 1;
		}else{
			echo 0;	
		}
	}
	
	function delete_pro_rebate(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM productquantityrebate WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));		
	}
	
	function add_New_Product_Barometar(){
		global $conn;	
		$q = "INSERT INTO `objectproduct_barometer`(`id`, `objectid`, `productid`, `price`, `maxprice`, `sort`, `barometardate`, `ts`) 
				VALUES ('', '".$_POST['object']."', '".$_POST['proid']."', '".$_POST['min']."', '".$_POST['max']."', 0, '".date("Y-m-d",strtotime($_POST['date']))."', CURRENT_TIMESTAMP) 
				ON DUPLICATE KEY UPDATE `price` = '".$_POST['min']."', 
										`maxprice` = '".$_POST['max']."' ";
		//$q = "INSERT INTO `productquantityrebate`(`id`, `productid`, `quantity`, `rebate`, `status`) VALUES ('', '".$_POST['proid']."', '".$_POST['quantity']."', '".$_POST['rebate']."', 'h') ON DUPLICATE KEY UPDATE rebate = '".$_POST['rebate']."'";	
		if(mysqli_query($conn, $q)){
			$lastid = mysqli_insert_id($conn);
			echo $lastid;
		}else{
			echo '0';	
		}
	}
	
	function delete_pro_barometar(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM objectproduct_barometer WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));		
	}
	
	function get_Barometar_Date(){
		global $conn;
		
		$q = "SELECT opb.*, o.name FROM objectproduct_barometer opb 
			LEFT JOIN object o ON opb.objectid = o.id
		WHERE productid = ".$_POST['id']." AND barometardate = '".date('Y-m-d', strtotime($_POST['date']))."'";
		$res = mysqli_query($conn, $q);
		$data = array();
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
				$row['max'] = number_format($row['maxprice'],2);
				$row['min'] = number_format($row['price'],2);
				array_push($data, $row);	
			}
		}
		echo json_encode($data);	
	}
	
	function copy_Barometar(){
		global $conn;
		
		$q = "INSERT INTO `objectproduct_barometer` (objectid, productid, price, maxprice, sort, barometardate) 
SELECT objectid, productid, price, maxprice, sort, NOW() FROM `objectproduct_barometer` WHERE barometardate = (SELECT MAX(barometardate) FROM objectproduct_barometer)
ON DUPLICATE KEY UPDATE ts = CURRENT_TIMESTAMP";
		if(mysqli_query($conn, $q)){
			echo 1;	
		}
	}
	
?>