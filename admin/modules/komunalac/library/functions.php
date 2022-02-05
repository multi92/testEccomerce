<?php

	include("../../../config/db_config.php");
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getmessage" : get_message(); break;		
		}
	}
	
	function get_message(){
		global $conn;
		if(isset($_POST['messageid']) && $_POST['messageid'] != "")
		{
			$out = array();
			$query = 'SELECT k.*, o.name FROM `komunalac` k 
					LEFT JOIN object o ON k.objectid = o.id 
					WHERE k.id = '.$_POST['messageid'];
			$re = mysqli_query($conn, $query);
			$out = mysqli_fetch_assoc($re);
			$out['cordinate'] = str_replace(" ", "", rtrim(ltrim($out['cordinate'], "("), ")"));
			$out['files'] = array();
			foreach (glob($_SERVER['DOCUMENT_ROOT']."/fajlovi/prijave/".$out['id']."_*") as $filename) {
				$tmp = explode("_", basename($filename));
				unset($tmp[0]);
				unset($tmp[1]);
				array_push($out['files'], array('name'=>implode("_", $tmp), 'link'=>basename($filename)));
			}
			echo json_encode($out);
		}
	}
	
?>