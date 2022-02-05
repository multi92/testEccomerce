<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "addnewcatdetail" : add_new_cat_detail(); break;
			case "getcategoryatributes" : get_category_atributes(); break;
			case "changecategorymainimage" : change_category_main_image(); break;
			case "deletecatdetail" : delete_cat_detail(); break;
			case "addattrcategory" : add_attr_category(); break;
			case "deleteattrcat" : delete_attr_cat(); break;
			case "savecategory" : save_category(); break;
			case "addcategory" : add_category(); break;
			
			case "deletemainimage" : delete_category_image(); break;
			case "updateattrcatsort" : update_attr_cat_sort(); break;
			case "changeismandatory" : change_is_mandatory(); break;
			case "changespecificationflag" : change_specification_flag(); break;
			
			case "saveCategoryMainColor" : save_Category_Main_Color(); break;
			
			case "changecategoryrelation" : change_category_relation(); break;
			
			case "addNewCategoryQuantity" : add_New_Category_Quantity(); break;
			case "changecategoryquantitystatus" :	change_Category_Quantity_Status(); break;
			case "deletecatrebate" : delete_cat_rebate(); break;
		}
	}
	
	
	function add_new_cat_detail(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		$query = "INSERT INTO `category_file`(`id`, `categoryid`, `type`, `content`, `contentface`, `sort`, `status`, `ts`) VALUES ('', ".mysqli_real_escape_string($conn, $_POST['catid']).",'".mysqli_real_escape_string($conn, $_POST['type'])."', '".mysqli_real_escape_string($conn, $_POST['cont'])."'  , '".mysqli_real_escape_string($conn, $_POST['contimg'])."' , 0 , 'h', CURRENT_TIMESTAMP)";
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}

		$lastid = mysqli_insert_id($conn);	
				
		echo json_encode(array($err, $lastid));
	}
	
	function get_category_atributes(){
		global $conn, $lang;
		$data = array();
		$err = 0;
		
		$query = "SELECT ac.attrid, ac.mandatory, a.name, ac.specification_flag FROM attrcategory ac LEFT JOIN attr a ON ac.attrid = a.id WHERE ac.categoryid=".$_POST["catid"]." ORDER BY ac.sort ASC";
		
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data, array($row["attrid"], $row['name'], $row['mandatory'], $row['specification_flag']));	
		}
		echo json_encode(array($err, $data));	
	}
	
	function change_category_main_image(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		
		$query = "UPDATE category_file SET sort = 0 WHERE type = 'img' AND categoryid=".$_POST['catid'];
		mysqli_query($conn, $query);
		
		$query = "UPDATE category_file SET sort = 1 WHERE id=".$_POST['primaryid'];
		mysqli_query($conn, $query);
		
		echo json_encode(array($err));	
	}
	
	function delete_cat_detail(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM category_file WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));	
	}
	
	function add_attr_category(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		
		$query = "INSERT INTO `attrcategory`(`attrid`, `categoryid`, `mandatory`, `sort`, `status`, `ts`) VALUES (".$_POST['attrid'].", ".$_POST['catid']." , 0, 0, 'v', CURRENT_TIMESTAMP)";
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		$lastid = mysqli_insert_id($conn);	
				
		echo json_encode(array($err, $lastid));	
	}
	function delete_attr_cat(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM attrcategory WHERE categoryid=".$_POST['catid']." AND attrid = ".$_POST['attrid'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));		
	}
	
	function save_category(){
		global $conn;
		$err = 0;

		
		foreach($_POST['name'] as $k=>$v){
			if($v['default'] == 'y'){
				$query = "UPDATE `category` SET `name`='".mysqli_real_escape_string($conn, $v['name'])."', 
				                                 description = '".mysqli_real_escape_string($conn, $v['description'])."',
				                                `b2cvisible` = ".$_POST['b2cc'].", 
				                                `b2cvisibleprice` = ".$_POST['b2cp'].", 
				                                `b2bvisible` = ".$_POST['b2bc'].", 
				                                `b2bvisibleprice` = ".$_POST['b2bp']." , 
				                                `slug` = '".$_POST['slug']."' 
				                                WHERE id=".$_POST['id'];
				if(!mysqli_query($conn, $query))
				{
					$err = 1;	
				}
			}
			
			$query = "INSERT INTO `category_tr`(`categoryid`, `langid`, `name`, `description`, `ts`) VALUES (".$_POST['id'].", ".$v['langid'].", '".$v['name']."', '".$v['description']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".$v['name']."', description = '".$v['description']."'";
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
		}
				
		echo json_encode(array($err));			
	}
	
	function add_category(){
		global $conn, $lang, $default_lang;
		$lastid = "''";
		$err = 0;
		$query = "SELECT MAX(sort)+1 FROM `category` WHERE parentid = ".$_POST['id'];
		$re = mysqli_query($conn, $query);
		$sortre = mysqli_fetch_array($re);
		if($sortre[0] == NULL){
			$sort = 0;		
		}else{
			$sort = $sortre[0];	
		}
		
		$defaultname = '';
		$defaultdescription = '';
		foreach($_POST['name'] as $k=>$v){
			if($v['default'] == 'y'){
				$defaultname = $v['name'];
				$defaultdescription = $v['description'];
			}
		}
		
		$query = "INSERT INTO `category`(`id`, `name`, `parentid`, `description`, `b2bvisibleprice`, `b2bvisible`, `b2cvisibleprice`, `b2cvisible`, `sort`, `ts`) VALUES ('','".mysqli_real_escape_string($conn, $defaultname)."' ,".$_POST['id']." ,'".mysqli_real_escape_string($conn, $defaultdescription)."' ,".$_POST['b2bp']." ,".$_POST['b2bc']." ,".$_POST['b2cp']." ,".$_POST['b2cc']." , ".$sort.", CURRENT_TIMESTAMP)";
		mysqli_query($conn, $query);
		$lastid = mysqli_insert_id($conn);
		
		foreach($_POST['name'] as $k=>$v){
			$query = "INSERT INTO `category_tr`(`categoryid`, `langid`, `name`, `description`, `ts`) VALUES (".$lastid.", ".$v['langid'].", '".$v['name']."', '".$v['description']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".$v['name']."', description = '".$v['description']."'";
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}	
		}
				
		echo json_encode(array($err));			
	}
	
	function delete_category_image(){
		global $conn;
		$err = 0;	
		$query = "DELETE FROM category_file WHERE id = ".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));	
	}
	
	function update_attr_cat_sort(){
		global $conn;
		$err = 0;	
		if(isset($_POST['items']) && count($_POST['items']) > 0 )
		{
			for($i = 0; $i < count($_POST['items']); $i++)
			{
				$query = "UPDATE `attrcategory` SET `sort` = ".$i." WHERE attrid=".$_POST['items'][$i]." AND categoryid = ".$_POST['categoryid'];
				if(!mysqli_query($conn, $query)){
					$err = 1;	
				}
			}
		}
		echo json_encode(array($err));			
	}
	
	function change_is_mandatory(){
		global $conn;
		$err = 0;	
		$query = "UPDATE `attrcategory` SET `mandatory`=".$_POST['value']." WHERE attrid=".$_POST['attrid']." AND categoryid = ".$_POST['categoryid'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		echo json_encode(array($err));		
	}
	
	function change_specification_flag(){
		global $conn;
		$err = 0;	
		$query = "UPDATE `attrcategory` SET `specification_flag`=".$_POST['value']." WHERE attrid=".$_POST['attrid']." AND categoryid = ".$_POST['categoryid'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		echo json_encode(array($err));		
	}
		
	function save_Category_Main_Color(){
		global $conn;	
		
		$query = "UPDATE category_file SET content = '".mysqli_real_escape_string($conn, $_POST['value'])."' WHERE categoryid = ".$_POST['id']." AND type = 'mc'";
		$res = mysqli_query($conn, $query);
		if(mysqli_affected_rows($conn) == 0){
			$query = "INSERT INTO `category_file`(`id`, `categoryid`, `type`, `content`, `contentface`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['id'].", 'mc', '".mysqli_real_escape_string($conn, $_POST['value'])."', '', 'v', 0, CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
		}
	}
	
	function change_category_relation(){
		global $conn;	
		
		$q = 'UPDATE `category_external` SET `categoryid`='.$_POST['categoryid'].' WHERE id = '.$_POST['id'];
		mysqli_query($conn, $q);	
	}
	
	function add_New_Category_Quantity(){
		global $conn;	
		
		$q = "INSERT INTO `categoryquantityrebate`(`id`, `categoryid`, `quantity`, `rebate`, `status`) VALUES ('', '".$_POST['catid']."', '".$_POST['quantity']."', '".$_POST['rebate']."', 'h') ON DUPLICATE KEY UPDATE rebate = '".$_POST['rebate']."'";	
		if(mysqli_query($conn, $q)){
			$lastid = mysqli_insert_id($conn);
			echo $lastid;
		}else{
			echo '0a0';	
		}
	}
	
	function change_Category_Quantity_Status(){
		global $conn;	
		
		$q = "UPDATE `categoryquantityrebate` SET status = '".$_POST['status']."' WHERE id = ".$_POST['id'];	
		
		if(mysqli_query($conn, $q)){
			echo 1;
		}else{
			echo 0;	
		}
	}
	
	function delete_cat_rebate(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM categoryquantityrebate WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));		
	}
	
?>