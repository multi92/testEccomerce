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
		
		$q = "SELECT * FROM person WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$rowdefault = mysqli_fetch_assoc($res);
		
		$data['id'] = $rowdefault['id'];
		$data['name'] = $rowdefault['name'];
		$data['description'] = $rowdefault['description'];
		$data['phone'] = $rowdefault['phone'];
		$data['title'] = $rowdefault['title'];
		$data['picture'] = $rowdefault['picture'];
		$data['email'] = $rowdefault['email'];
		$data['sort'] = $rowdefault['sort'];
		
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
				
		$query = "INSERT INTO `person`(`id`, `name`, `description`, `phone`, `title`, `picture`, `email`, `sort`, `status`, `ts`) VALUES ('".$_POST['id']."', 
		'".mysqli_real_escape_string($conn, $_POST['name'])."', 
		'".mysqli_real_escape_string($conn, $_POST['description'])."', 
		'".mysqli_real_escape_string($conn, $_POST['phone'])."',
		'".mysqli_real_escape_string($conn, $_POST['title'])."',
		'".mysqli_real_escape_string($conn, $_POST['picture'])."',
		'".mysqli_real_escape_string($conn, $_POST['email'])."',
		'".mysqli_real_escape_string($conn, $_POST['sort'])."',
		'h', 
		CURRENT_TIMESTAMP) 
		ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $_POST['name'])."',
								`description` = '".mysqli_real_escape_string($conn, $_POST['description'])."',
								`phone` = '".mysqli_real_escape_string($conn, $_POST['phone'])."',
								`title` = '".mysqli_real_escape_string($conn, $_POST['title'])."',
								`picture` = '".mysqli_real_escape_string($conn, $_POST['picture'])."',
								`email` = '".mysqli_real_escape_string($conn, $_POST['email'])."',
								`sort` = '".mysqli_real_escape_string($conn, $_POST['sort'])."'";
		mysqli_query($conn, $query);
		
		
		
		if($_POST['id'] == ""){
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
				$query = "DELETE FROM cenovnik WHERE id = ".$_POST['id'];
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM cenovnik_tr WHERE cenovnikid = ".$_POST['id'];
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
				$query = "UPDATE `person` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
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
				$query = "UPDATE `person` SET `sort`='".$_POST['sort']."' WHERE id = ".$_POST['id'];		
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