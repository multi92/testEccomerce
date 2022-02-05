<?php

	include("../../../config/db_config.php"); 
	include("../../../config/config.php");
	include("../../userlog.php");
	
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getitem" : get_item(); break;
			case "saveaddchange" : save(); break;	
			case "delete" : delete(); break;	
			case "verifypath" : verifypath(); break;	
			case "getlanguageslist" : getLanguagesList(); break;
		}
	}
	
	function get_item(){
		global $conn, $lang;
		if(isset($_POST['id']) && $_POST['id'] != "")
		{
			$data = array();
							
			$query = 'SELECT * FROM `documents` WHERE id='.$_POST['id'];
			$re = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($re);
			
			$data['id'] = $row['id'];
			$data['link'] = rawurldecode($row['link']);
			$data['showname'] = $row['showname'];
			$data['image'] = $row['image'];
			$data['delovodni'] = $row['delovodni'];
			$data['zavodjenjedatum'] = $row['zavodjenjedatum'];
			$data['lang'] = array();
			$data['type'] = $row['type'];
			$q = "SELECT *, (SELECT showname FROM documents_tr WHERE documentsid = ".$_POST['id']." AND langid = l.id ) as shownametr FROM languages l";
	
			$res = mysqli_query($conn, $q);
			if ($res && mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'showname'=>($row['shownametr'] != NULL)? $row['shownametr']:''
					));
				}
			}
			
			echo json_encode($data);
		}
		
	}
	function save(){
		global $conn;
		
		$lastid = "";
		
		$defaultshowname = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultshowname = $v['showname'];
			}	
		}
		
		$query = "INSERT INTO `documents`(`id`, `link`, `showname`, `image`, `delovodni`, `zavodjenjedatum`,`type`, `ts`)
		VALUES ('".$_POST['docid']."', '".mysqli_real_escape_string($conn, rawurlencode($_POST['link']))."', 
			'".mysqli_real_escape_string($conn, $defaultshowname)."', 
			'".mysqli_real_escape_string($conn, $_POST['image'])."', 
			'".mysqli_real_escape_string($conn, $_POST['delovodni'])."',
			'".mysqli_real_escape_string($conn, $_POST['date']." 00:00:00")."',
			'".mysqli_real_escape_string($conn, $_POST['type'])."', 
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
				`link` = '".mysqli_real_escape_string($conn, rawurlencode($_POST['link']))."' , 
				`showname` = '".mysqli_real_escape_string($conn, $_POST['showname'])."' , 
				`image` = '".mysqli_real_escape_string($conn, $_POST['image'])."' ,  
				`delovodni` = '".mysqli_real_escape_string($conn, $_POST['delovodni'])."',
				`zavodjenjedatum` = '".mysqli_real_escape_string($conn, $_POST['date']." 00:00:00")."',
				`type` = '".mysqli_real_escape_string($conn, $_POST['type'])."' ";		
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' && isset($_POST['docid'])) $lastid = $_POST['docid'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `documents_tr`(`documentsid`, `langid`, `showname`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['showname'])."', 
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `showname` = '".mysqli_real_escape_string($conn, $v['showname'])."'";
			mysqli_query($conn, $query);	
		}
		
		
		if($_POST['docid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['docid'], $_SESSION['id'], "change");	
		}
	}
	
	function delete(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "DELETE FROM `documents` WHERE id = ".$_POST['id'];
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM `documents_tr` WHERE documentsid = ".$_POST['id'];
				mysqli_query($conn, $query);
			}
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function verifypath(){
		if(file_exists("../../../../".rawurldecode($_POST['path']))){
			echo 1;	
		}
		else{
			echo 0;	
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