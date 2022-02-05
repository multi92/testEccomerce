<?php
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if (isset($_POST['action']) && $_POST['action'] != "") {
		switch ($_POST['action']) {
			case "addChangeProductcode" : add_Change_Productcode(); break;
			case "getProductcode" : get_Productcode(); break;
			case "getProductcodeItems" : get_Productcode_Items(); break;
			case "addProductcodeItems" : add_Productcode_Items(); break;
			case "deleteProductcodeItems" : delete_Productcode_Items(); break;
			case "getAttrValList" : get_Attr_Val_List(); break;
		}
	}
	
	function add_Change_Productcode(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";

		$query = "INSERT INTO `productcode`(`id`, `name`, `sort`, `ts`) VALUES ('".$_POST['id']."', '".mysqli_real_escape_string($conn, $_POST['name'])."', 0, CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".mysqli_real_escape_string($conn, $_POST['name'])."'";
		if(!mysqli_query($conn, $query))
		{
			$err = 1;	
		}else{
			$lastid = mysqli_insert_id($conn);	
		}

		echo json_encode(array($err, $lastid));		
	}
	
	function get_Productcode(){
		global $conn;
		$err = 0;
		$data = array();
		
		$q = "SELECT * FROm productcode WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		$data['id'] = $row['id'];
		$data['name'] = $row['name'];
					
		echo json_encode(array($err, $data));		
	}
	
	function get_Productcode_Items(){
		global $conn;
		$err = 0;
		$data = array();
		
		$q = "SELECT pci.*, a.name as attrname, av.value as valuename FROM productcodeitem pci
			LEFT JOIN attr a ON pci.attrid = a.id
			LEFT JOIN attrval av ON pci.attrvalid = av.id
			 WHERE pci.productcodeid = ".$_POST['id']." ORDER BY attrid ASC";
		$res = mysqli_query($conn, $q);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("productcodeid" => $row['productcodeid'], "attrid" => $row['attrid'], "attrvalid" => $row['attrvalid'], "value"=>$row['value'], "attrname" => $row['attrname'], "valuename" => $row['valuename']));	
		}
		
		echo json_encode(array($err, $data));	
	}
	
	function add_Productcode_Items(){
		global $conn;
		$err = 0;
		
		$q = "INSERT INTO `productcodeitem`(`productcodeid`, `attrvalid`, `attrid`, `value`, `sort`, `status`, `ts`) VALUES ('".mysqli_real_escape_string($conn, $_POST['productcodeid'])."', '".mysqli_real_escape_string($conn, $_POST['attrvalid'])."', '".mysqli_real_escape_string($conn, $_POST['attrid'])."', '".mysqli_real_escape_string($conn, $_POST['value'])."', 0, 'v', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE value = '".mysqli_real_escape_string($conn, $_POST['value'])."'";
		
		if(!mysqli_query($conn, $q))
		{
			$err = 1;	
		}
		
		echo json_encode(array($err));	
	}
	
	function delete_Productcode_Items(){
		global $conn;
		$err = 0;
		
		$q = "DELETE FROM productcodeitem WHERE productcodeid = '".mysqli_real_escape_string($conn, $_POST['productcodeid'])."' AND attrid = '".mysqli_real_escape_string($conn, $_POST['attrid'])."' AND attrvalid = '".mysqli_real_escape_string($conn, $_POST['attrvalid'])."'";
		if(!mysqli_query($conn, $q))
		{
			$err = 1;	
		}
		
		echo json_encode(array($err));		
	}
	
	function get_Attr_Val_List(){
		global $conn;
		$err = 0;
		$data = array();
		
		$q = "SELECT * FROM attrval WHERE attrid = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id" => $row['id'], "value" => $row['value']));	
		}
		
		echo json_encode(array($err, $data));
	}
?>