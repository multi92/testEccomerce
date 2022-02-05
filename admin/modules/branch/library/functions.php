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
			$query = "DELETE FROM `branch` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `branch_tr` WHERE branchid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `branch` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM branch WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		$data['id'] = $row['id'];
		$data['name'] = $row['name'];
		
		$q = "SELECT *, (SELECT name FROM branch_tr WHERE branchid = ".$_POST['id']." AND langid = l.id ) as nametr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'name'=>($row['nametr'] == NULL && $row['default'] == 'y' )? $data['name']:$row['nametr'] ));
            }
        }
		
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		$defaultname = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultname = $v['name'];
			}	
		}
		
		$query = "INSERT INTO `branch`(`id`, `name`, `sort`, `status`, `ts`) VALUES ('".$_POST['id']."', '".mysqli_real_escape_string($conn, $defaultname)."',  0, 'v', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $defaultname)."' ";
			
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0 || $lastid == '') $lastid = $_POST['id'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `branch_tr`(`branchid`, `langid`, `name`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['name'])."',
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $v['name'])."' ";
			mysqli_query($conn, $query);	
		}	
		$defaultnewsid=0;
		if($_POST['id'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
			$defaultnewsid=$lastid;
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change");
			$defaultnewsid=$_POST['id'];			
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