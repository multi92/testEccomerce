<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getitem" : get_item(); break;
			case "saveaddchange" : save_add_change(); break;
			case "delete" : delete(); break;	
			case "changestatus" : change_status(); break;
			case "changesort" : change_sort(); break;
			case "getlanguageslist" : getLanguagesList(); break;	
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM banner WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		if($row['id'] != NULL) $data['id'] = $row['id'];
		$data['position']='c';
		if($row['position'] != NULL) $data['position'] = $row['position'];
		$data['page']='';
		if($row['page'] != NULL) $data['page'] = $row['page'];
		if($row['adddate'] != NULL) $data['adddate'] = $row['adddate'];
		$data['name'] = $row['name'];
		$data['value'] = $row['value'];
		
		$q = "SELECT *, (SELECT value FROM banner_tr WHERE bannerid = ".$_POST['id']." AND langid = l.id ) as valuetr
						 FROM languages l";

        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'value'=>($row['valuetr'] != NULL)? $row['valuetr']:''));
            }
        }

        echo json_encode($data);
	}
	
	function save_add_change(){

		global $conn;
		$lastid =$_POST['bannerid'];
		
		$defaultvalue = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultvalue = $v['value'];
			}	
		}
		
		
		$query = "INSERT INTO `banner`(`id`, `position`, `name`, `value`, `adddate`, `changedate`, `sort`, `status`, `ownerid`, `ts`) VALUES ('".$_POST['bannerid']."', 
		'".mysqli_real_escape_string($conn, $_POST['position'])."', 
		'".mysqli_real_escape_string($conn, $_POST['name'])."', 
		'".mysqli_real_escape_string($conn, $defaultvalue)."', 
		NOW(), 
		NOW(), 
		0, 
		'h', 
		'".mysqli_real_escape_string($conn, $_SESSION['id'])."', 
		CURRENT_TIMESTAMP) 
		ON DUPLICATE KEY UPDATE `value` = '".mysqli_real_escape_string($conn, $defaultvalue)."',
									position = '".mysqli_real_escape_string($conn, $_POST['position'])."'";
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0 ) $lastid = $_POST['bannerid'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `banner_tr`(`bannerid`, `langid`, `value`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['value'])."',
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `value` = '".mysqli_real_escape_string($conn, $v['value'])."'";
			mysqli_query($conn, $query);	
		}	
		
		if($_POST['bannerid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['bannerid'], $_SESSION['id'], "change");	
		}
	}
	
	function delete(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "DELETE FROM banner WHERE id = ".$_POST['id'];
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM banner_tr WHERE bannerid = ".$_POST['id'];
				mysqli_query($conn, $query);
			}
		}
	}
	function change_status(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "UPDATE `banner` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
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
				$query = "UPDATE `banner` SET `sort`='".$_POST['sort']."' WHERE id = ".$_POST['id'];		
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

?>