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
			case "savemenu" : save_menu(); break;
			case "getlanguageslist" : getLanguagesList(); break;
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `news` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `news_tr` WHERE newsid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `news` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function save_menu(){
		global $conn;
		
		$defaultvalue = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y') $defaultvalue = $v['value'];	
		}
		
		if($_POST['parentid'] == '') $_POST['parentid'] = 0;
		
		$query = "INSERT INTO `menu`(`id`, `parentid`, `value`, `linktype`, `link`, `image`, `status`, `menutype`, `sort`, `ts`) VALUES ('".$_POST['menuid']."', '".mysqli_real_escape_string($conn, $_POST['parentid'])."', '".mysqli_real_escape_string($conn, $defaultvalue)."', '".mysqli_real_escape_string($conn, $_POST['linktype'])."', '".mysqli_real_escape_string($conn, $_POST['link'])."', '".mysqli_real_escape_string($conn, $_POST['image'])."', '".mysqli_real_escape_string($conn, $_POST['status'])."', '".mysqli_real_escape_string($conn, $_POST['menutype'])."', '".mysqli_real_escape_string($conn, $_POST['sortnum'])."', CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE `parentid` = '".mysqli_real_escape_string($conn, $_POST['parentid'])."' , 
						`value` = '".mysqli_real_escape_string($conn, $defaultvalue)."' , 
						`link` = '".mysqli_real_escape_string($conn, $_POST['link'])."' , 
						`linktype` = '".mysqli_real_escape_string($conn, $_POST['linktype'])."' ,
						`image` = '".mysqli_real_escape_string($conn, $_POST['image'])."' ,  
						`status` = '".mysqli_real_escape_string($conn, $_POST['status'])."' , 
						`menutype` = '".mysqli_real_escape_string($conn, $_POST['menutype'])."' , 
						`sort` = '".mysqli_real_escape_string($conn, $_POST['sortnum'])."' ";

		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0) $lastid = $_POST['menuid'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `menu_tr`(`menuid`, `langid`, `value`, `ts`) VALUES (".$lastid.", ".$v['langid'].", '".$v['value']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE  `value` = '".$v['value']."' ";
			mysqli_query($conn, $query);	
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
	
?>