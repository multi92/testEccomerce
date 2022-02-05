<?php
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if (isset($_POST['action']) && $_POST['action'] != "") {
		switch ($_POST['action']) {
			case "delete" : delete(); break;
			case "changestatus" : change_status(); break;
			case "getitem" : get_item(); break;
			case "saveaddchange" : save_add_change(); break;
			case "addpricelistitem" : add_pricelist_item(); break;
			case "savepricelistitemrebate": save_pricelist_item_rebate(); break;
			case "deletepricelistitem" : delete_pricelist_item(); break;
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `pricelist` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `pricelist` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        
		$q = "SELECT * FROM pricelist WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$data = mysqli_fetch_assoc($res);		
		
		
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		
		$defaultname = '';
		$defaultaddress = '';
		$defaulttext = '';
		$defaultdescription = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultname = $v['name'];
				$defaultaddress = $v['address'];
				$defaulttext = $v['text'];
				$defaultdescription = $v['description'];
			}	
		}
		
		$query = "INSERT INTO `pricelist`(`id`, `name`, `description`, `status`, `sort`, `ts`) VALUES (
							'".$_POST['id']."',
							'".mysqli_real_escape_string($conn, $_POST['name'])."',
							'".mysqli_real_escape_string($conn, $_POST['description'])."',
							'h',
							0,
							CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE 
							`name` = '".mysqli_real_escape_string($conn, $_POST['name'])."', 
							`description` = '".mysqli_real_escape_string($conn, $_POST['description'])."'";						
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' && $_POST['id'] != '') $lastid = $_POST['id'];
		
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
	
	function add_pricelist_item(){
		global $conn;
		$data = array();
		
		$q = "SELECT id FROM product WHERE code like '".mysqli_real_escape_string($conn, $_POST['code'])."'";
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) == 0){
			echo json_encode(array('status'=>'warning', 'status_code'=>0, 'msg'=>"Nevalidna šifra!"));	
		}else{
			$row = mysqli_fetch_assoc($res);
			$productid = $row['id'];
			$q = 'SELECT * FROM pricelistitem WHERE pricelistid = '.$_POST['id'].' AND productid = '.$productid;
			$res = mysqli_query($conn, $q);
			if(mysqli_num_rows($res) > 0){
				echo json_encode(array('status'=>'warning', 'status_code'=>1, 'msg'=>"Šifra već postoji u cenovniku!"));	
			}else{
				$q = 'INSERT INTO `pricelistitem`(`pricelistid`, `productid`, `rebate`, `price`, `status`, `sort`, `ts`) VALUES (
				'.$_POST['id'].',
				'.$productid.',
				0,
				0,
				"v",
				0,
				CURRENT_TIMESTAMP())';	
				if(mysqli_query($conn, $q)){
					echo json_encode(array('status'=>'success', 'status_code'=>0, 'msg'=>"Uspešno dodato!"));		
				}else{
					echo json_encode(array('status'=>'fail', 'status_code'=>0, 'msg'=>"Greška prilikom upisa!"));		
				}
			}
		}
	}	
	
	function save_pricelist_item_rebate(){
		global $conn;
		$q = "INSERT INTO `pricelistitem`(`pricelistid`, `productid`, `rebate`) 
				VALUES (
					".$_POST['pricelistid'].",
					".$_POST['productid'].",
					".$_POST['rebate'].") ON DUPLICATE KEY UPDATE rebate = ".$_POST['rebate'];	
		if(mysqli_query($conn, $q)){
			echo json_encode(array('status'=>'success', 'status_code'=>0, 'msg'=>"Uspešno dodato!"));		
		}else{
			echo json_encode(array('status'=>'fail', 'status_code'=>0, 'msg'=>"Greška prilikom upisa!"));		
		}
	}
	
	function delete_pricelist_item(){
		global $conn;
		if($_POST['pricelistid'] != "" && $_POST['productid'] != "")
		{
			$query = "DELETE FROM `pricelistitem` WHERE pricelistid = ".$_POST['pricelistid']." AND productid = ".$_POST['productid'];
			mysqli_query($conn, $query);
			
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
?>