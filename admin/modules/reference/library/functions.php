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
			$query = "DELETE FROM `reference` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `reference_tr` WHERE cityid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `reference` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM reference WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		$data['id'] = $row['id'];
		$data['name'] = $row['name'];
		$data['link'] = $row['link'];
		$data['description'] = $row['description'];
		$data['image'] = $row['image'];
		$data['cityid'] = $row['cityid'];
		$data['branchid'] = $row['branchid'];
		
		$q = "SELECT *, (SELECT name FROM reference_tr WHERE referenceid = ".$_POST['id']." AND langid = l.id ) as nametr,
						(SELECT description FROM reference_tr WHERE referenceid = ".$_POST['id']." AND langid = l.id ) as desctr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'name'=>($row['nametr'] == NULL && $row['default'] == 'y' )? $data['name']:$row['nametr'],
						'desc'=>($row['desctr'] == NULL && $row['default'] == 'y' )? $data['description']:$row['desctr'] ));
            }
        }
		
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		$defaultname = '';
		$defaultdesc = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultname = $v['name'];
				$defaultdesc = $v['desc'];
			}	
		}
		
		$query = "INSERT INTO `reference`(`id`, `name`, `link`, `description`, `image`, `cityid`, `branchid`, `status`, `ts`) VALUES ('".$_POST['id']."', '".mysqli_real_escape_string($conn, $defaultname)."', '".mysqli_real_escape_string($conn, $_POST['link'])."', '".mysqli_real_escape_string($conn, $defaultdesc)."', '".mysqli_real_escape_string($conn, $_POST['image'])."', ".mysqli_real_escape_string($conn, $_POST['cityid']).", ".mysqli_real_escape_string($conn, $_POST['branchid']).", 'h', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $defaultname)."' , 
					`link` = '".mysqli_real_escape_string($conn, $_POST['link'])."',
					`description` = '".mysqli_real_escape_string($conn, $defaultdesc)."',
					`image` = '".mysqli_real_escape_string($conn, $_POST['image'])."',
					`cityid` = '".mysqli_real_escape_string($conn, $_POST['cityid'])."',
					`branchid` = '".mysqli_real_escape_string($conn, $_POST['branchid'])."'  ";
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0 || $lastid == '') $lastid = $_POST['id'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `reference_tr`(`referenceid`, `langid`, `name`, `description`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['name'])."',
			'".mysqli_real_escape_string($conn, $v['desc'])."',
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $v['name'])."',
														`description` = '".mysqli_real_escape_string($conn, $v['desc'])."' ";
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