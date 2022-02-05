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
			$query = "DELETE FROM `extradetail` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `extradetail_tr` WHERE extradetailid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `extradetail` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT ed.* FROM extradetail AS ed WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		$data['id'] = $row['id'];
		$data['name'] = $row['name'];
		$data['sort'] = $row['sort'];
		$data['sort'] = $row['sort'];

		$data['status'] = $row['status'];
		$data['showinwelcomepage'] = $row['showinwelcomepage'];
		$data['showinwebshop'] = $row['showinwebshop'];
		$data['banerid'] = $row['banerid'];

		
		$q = "SELECT *, (SELECT name FROM extradetail_tr WHERE extradetailid = ".$_POST['id']." AND langid = l.id ) as nametr,
						(SELECT image FROM extradetail_tr WHERE extradetailid = ".$_POST['id']." AND langid = l.id ) as imagetr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($rowd = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$rowd['id'], 
						'langname'=>$rowd['name'],
						'default'=>$rowd['default'],
						'name'=>($rowd['nametr'] == NULL && $rowd['default'] == 'y' )? $data['name']:$rowd['nametr'],
						'image'=>($rowd['imagetr'] == NULL && $rowd['default'] == 'y' )? $data['image']:$rowd['imagetr'] ));
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
				$defaultimage = $v['image'];
			}	
		}
		
		$query = "INSERT INTO `extradetail`(`id`, `name`,`image`,`sort`,`showinwelcomepage`,`showinwebshop`,`banerid`, `ts`) 
					VALUES ( '".$_POST['id']."',
							'".mysqli_real_escape_string($conn, $defaultname)."', 
							'".mysqli_real_escape_string($conn, $defaultimage)."', 
							
							'".mysqli_real_escape_string($conn, $_POST['sort'])."', 
							'".mysqli_real_escape_string($conn, $_POST['showinwelcomepage'])."',
							'".mysqli_real_escape_string($conn, $_POST['showinwebshop'])."',
							'".mysqli_real_escape_string($conn, $_POST['banerid'])."',
							CURRENT_TIMESTAMP 
							) 
							ON DUPLICATE KEY UPDATE 
								`name` = '".mysqli_real_escape_string($conn, $defaultname)."' , 
								`image` = '".mysqli_real_escape_string($conn, $defaultimage)."',
								`sort` = '".mysqli_real_escape_string($conn, $_POST['sort'])."',
								`showinwelcomepage`= '".mysqli_real_escape_string($conn, $_POST['showinwelcomepage'])."',
								`showinwebshop`= '".mysqli_real_escape_string($conn, $_POST['showinwebshop'])."',
								`banerid`= '".mysqli_real_escape_string($conn, $_POST['banerid'])."',
								`ts` = CURRENT_TIMESTAMP  ";
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0 || $lastid == '') $lastid = $_POST['id'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `extradetail_tr`(`extradetailid`, `langid`, `name`, `image`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['name'])."',
			'".mysqli_real_escape_string($conn, $v['image'])."',
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $v['name'])."',
														`image` = '".mysqli_real_escape_string($conn, $v['image'])."' ";
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