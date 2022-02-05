<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "addnewcatdetail" : add_new_cat_detail(); break;
			case "changecategorymainimage" : change_category_main_image(); break;
			case "deletecatdetail" : delete_cat_detail(); break;
			
			case "savecategory" : save_category(); break;
			case "addcategory" : add_category(); break;
			
			case "deletemainimage" : delete_category_image(); break;
			case "saveCategoryMainColor" : save_Category_Main_Color(); break;
			case "changecategoryrelation" : change_category_relation(); break;

		}
	}
	
	
	function add_new_cat_detail(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		$query = "INSERT INTO `newscategory_file`(`id`, `newscategoryid`, `type`, `content`, `contentface`, `sort`, `status`, `ts`) VALUES ('', ".mysqli_real_escape_string($conn, $_POST['catid']).",'".mysqli_real_escape_string($conn, $_POST['type'])."', '".mysqli_real_escape_string($conn, $_POST['cont'])."'  , '".mysqli_real_escape_string($conn, $_POST['contimg'])."' , 0 , 'h', CURRENT_TIMESTAMP)";
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}

		$lastid = mysqli_insert_id($conn);	
				
		echo json_encode(array($err, $lastid));
	}
	

	
	function change_category_main_image(){
		global $conn, $lang;
		$lastid = "";
		$err = 0;
		
		$query = "UPDATE newscategory_file SET sort = 0 WHERE type = 'img' AND newscategoryid=".$_POST['catid'];
		mysqli_query($conn, $query);
		
		$query = "UPDATE newscategory_file SET sort = 1 WHERE id=".$_POST['primaryid'];
		mysqli_query($conn, $query);
		
		echo json_encode(array($err));	
	}
	
	function delete_cat_detail(){
		global $conn, $lang;
		$err = 0;

		$query = "DELETE FROM newscategory_file WHERE id=".$_POST['id'];
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
				$query = "UPDATE `newscategory` SET `name`='".mysqli_real_escape_string($conn, $v['name'])."', description = '".mysqli_real_escape_string($conn, $v['description'])."', `icon` = '".mysqli_real_escape_string($conn,$_POST['icon'])."', `color` = '".mysqli_real_escape_string($conn,$_POST['color'])."', `visible` = '".$_POST['visible']."' WHERE id=".$_POST['id'];
				if(!mysqli_query($conn, $query))
				{
					$err = 1;	
				}
			}
			
			$query = "INSERT INTO `newscategory_tr`(`newscategoryid`, `langid`, `name`, `description`, `ts`) VALUES (".$_POST['id'].", ".$v['langid'].", '".$v['name']."', '".$v['description']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".$v['name']."', description = '".$v['description']."'";
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
		$query = "SELECT MAX(sort)+1 FROM `newscategory` WHERE parentid = ".$_POST['id'];
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
		
		$query = "INSERT INTO `newscategory`(`id`, `name`, `parentid`, `description`, `icon`, `color`, `visible`, `sort`, `ts`) VALUES ('','".mysqli_real_escape_string($conn, $defaultname)."' ,".$_POST['id']." ,'".mysqli_real_escape_string($conn, $defaultdescription)."' ,'".mysqli_real_escape_string($conn,$_POST['icon'])."' ,'".mysqli_real_escape_string($conn,$_POST['color'])."' ,".$_POST['visible']." , ".$sort.", CURRENT_TIMESTAMP)";
		mysqli_query($conn, $query);
		$lastid = mysqli_insert_id($conn);
		
		foreach($_POST['name'] as $k=>$v){
			$query = "INSERT INTO `newscategory_tr`(`newscategoryid`, `langid`, `name`, `description`, `ts`) VALUES (".$lastid.", ".$v['langid'].", '".$v['name']."', '".$v['description']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".$v['name']."', description = '".$v['description']."'";
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
		$query = "DELETE FROM newscategory_file WHERE id = ".$_POST['id'];
		if(!mysqli_query($conn, $query)){
			$err = 1;	
		}
		
		echo json_encode(array($err));	
	}
	

	
	function save_Category_Main_Color(){
		global $conn;	
		
		$query = "UPDATE newscategory_file SET content = '".mysqli_real_escape_string($conn, $_POST['value'])."' WHERE newscategoryid = ".$_POST['id']." AND type = 'mc'";
		$res = mysqli_query($conn, $query);
		if(mysqli_affected_rows($conn) == 0){
			$query = "INSERT INTO `newscategory_file`(`id`, `newscategoryid`, `type`, `content`, `contentface`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['id'].", 'mc', '".mysqli_real_escape_string($conn, $_POST['value'])."', '', 'v', 0, CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
		}
	}
	
	function change_category_relation(){
		global $conn;	
		
		$q = 'UPDATE `newscategory_external` SET `newscategoryid`='.$_POST['newscategoryid'].' WHERE id = '.$_POST['id'];
		mysqli_query($conn, $q);	
	}
	


	
?>