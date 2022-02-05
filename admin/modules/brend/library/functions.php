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
			$query = "DELETE FROM `brend` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			$query = "DELETE FROM brend_tr WHERE brendid = ".$_POST['brendid'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `brend` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){

        global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM brend WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$rowo = mysqli_fetch_assoc($res);
		
		if($rowo['id'] != NULL) $data['id'] = $rowo['id'];
		$data['name'] = $rowo['name'];
		$data['image'] = $rowo['image'];
		$data['link'] = $rowo['link'];
		$data['link_target'] = $rowo['link_target'];
		
		$q = "SELECT *, (SELECT name FROM brend_tr WHERE brendid = ".$_POST['id']." AND langid = l.id ) as nametr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'name'=>($row['nametr'] != NULL)? $row['nametr']:''
						 ));
            }
        }

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
			}	
		}
		if($_POST['id'] != ''){
			$query = "INSERT INTO `brend`(`id`, `name`, `image`, `link`, `link_target`, `ts`) VALUES (
		                                            '".$_POST['id']."',
													'".mysqli_real_escape_string($conn, $defaultname)."', 
													'".mysqli_real_escape_string($conn, $_POST['image'])."', 
													'".mysqli_real_escape_string($conn, $_POST['link'])."', 
													'".mysqli_real_escape_string($conn, $_POST['link_target'])."', 											
													CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
													
													name = '".mysqli_real_escape_string($conn, $defaultname)."',
													image = '".mysqli_real_escape_string($conn, $_POST['image'])."',
													link = '".mysqli_real_escape_string($conn, $_POST['link'])."',
													link_target = '".mysqli_real_escape_string($conn, $_POST['link_target'])."'"
													;	

		} else {
			$query = "INSERT INTO `brend`(`id`, `name`, `image`, `link`, `link_target`,`status`, `ts`) VALUES (
		                                            '".$_POST['id']."',
													'".mysqli_real_escape_string($conn, $defaultname)."', 
													'".mysqli_real_escape_string($conn, $_POST['image'])."', 
													'".mysqli_real_escape_string($conn, $_POST['link'])."',
													'".mysqli_real_escape_string($conn, $_POST['link_target'])."',
													'v',  											
													CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
													
													name = '".mysqli_real_escape_string($conn, $defaultname)."',
													image = '".mysqli_real_escape_string($conn, $_POST['image'])."',
													link = '".mysqli_real_escape_string($conn, $_POST['link'])."',
													link_target = '".mysqli_real_escape_string($conn, $_POST['link_target'])."'"
													;	
		}
		
		echo $query;					
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' && $_POST['id'] != '') $lastid = $_POST['id'];

		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `brend_tr`(`brendid`, `langid`, `name`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].",
			'".mysqli_real_escape_string($conn, $v['name'])."',   
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
					`name` = '".mysqli_real_escape_string($conn, $v['name'])."'";
			
			mysqli_query($conn, $query);	
		}	

		if($_POST['id'] == ""){
			userlog($_SESSION['moduleid'], "brend", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "brend", $_POST['id'], $_SESSION['id'], "change");	
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