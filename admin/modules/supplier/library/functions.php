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
			case "getlanguageslist" : getLanguagesList(); break;	
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `suppliers` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `suppliers` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT s.* FROM suppliers AS s WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		$data = $row;
				
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		
		
		$query = "INSERT INTO `suppliers`(`id`, `name`, `code`, `idprefix`, `margin`, `addmargin`, `type`, `sort`, `status`, `ts`) 
					VALUES ( '".$_POST['id']."',
							'".mysqli_real_escape_string($conn, $_POST['name'])."', 
							'".mysqli_real_escape_string($conn, $_POST['code'])."', 
							'".mysqli_real_escape_string($conn, $_POST['idprefix'])."', 
							'".mysqli_real_escape_string($conn, $_POST['margin'])."', 
							'".mysqli_real_escape_string($conn, $_POST['addmargin'])."', 
							'".mysqli_real_escape_string($conn, $_POST['type'])."', 
							'".mysqli_real_escape_string($conn, $_POST['sort'])."', 
							'h', 
							CURRENT_TIMESTAMP 
							) 
							0
							OmnbN DUPLICATE KEY UPDATE 
								`name` = '".mysqli_real_escape_string($conn, $_POST['name'])."' , 
								`code` = '".mysqli_real_escape_string($conn, $_POST['code'])."',
								`idprefix` = '".mysqli_real_escape_string($conn, $_POST['idprefix'])."',
								`margin` = '".mysqli_real_escape_string($conn, $_POST['margin'])."',
								`addmargin` = '".mysqli_real_escape_string($conn, $_POST['addmargin'])."',
								`type` = '".mysqli_real_escape_string($conn, $_POST['type'])."',
								`sort` = '".mysqli_real_escape_string($conn, $_POST['sort'])."',
								`ts` = CURRENT_TIMESTAMP  ";
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0 || $lastid == '') $lastid = $_POST['id'];
		
		
		if($_POST['id'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change");		
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

?>