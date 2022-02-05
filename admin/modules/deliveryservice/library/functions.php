<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	
	session_start();
	mb_internal_encoding("UTF-8");
	
	function random_password( $length = 8 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getusers" : get_users(); break;	
			case "saveusers" :  save_users(); break;	
			case "deleteusers" : delete_users(); break;	
			
			case "addsavegroup" : add_save_group(); break;	
			case "deletegroup" : delete_group(); break;	
			case "activateuser" : activateuser(); break;
			
			case "deletesocialitempartner" : delete_social_item_partner(); break;	
			case "addSocialItemPartner": add_Social_Item_Partner(); break;
			
			case "changestatus" : change_status(); break;
		}
	}

	function activateuser()
	{
		global $conn;
		$out = array();
		
		/*if($_POST['status']==1){
			$new_status=0;
		}else{
			$new_status=1;
		}
		*/
		
		$query='update `user` set status='.$_POST['status'].' where id='.$_POST['usersid'];

		$re = mysqli_query($conn, $query);
		if($re)
		{
			echo '1';
		}else{
			echo '0';
		}



	}
	
	function get_users(){
		global $conn;
		$out = array();
		$err = 0;
		$show = 0;
		
		if(isset($_POST['usersid']) && $_POST['usersid'] != "")
		{
			$query = 'SELECT * FROM `deliveryservice` p
			WHERE p.id = '.$_POST['usersid'];

			$re = mysqli_query($conn, $query);
			
			$out[0] = mysqli_fetch_assoc($re);
			
			$query = "SELECT am.id as mid, am.showname, b.userid, b.moduleid, b.groupid, ug.name as gname FROM adminmoduls am 
LEFT JOIN (SELECT userid, moduleid, groupid FROM userprivilage WHERE userid = ".$_POST['usersid'].") as b ON am.id = b.moduleid
LEFT JOIN usergroup ug ON b.groupid = ug.id";

			$re = mysqli_query($conn, $query);
			$out[1] = array();
			while($row = mysqli_fetch_assoc($re))
			{
				array_push($out[1], $row);	
			}
			$show = 1;
			
			$q = "SELECT sni.*, sn.name  as networkname FROM socialnetworkitem sni 
			LEFT JOIN socialnetwork sn ON sni.socialnetworkid = sn.id WHERE sni.foreigntable = 'partner' AND sni.foreignkey = '".$_POST['usersid']."'";
			$re = mysqli_query($conn, $q);
			$out[2] = array();
			while($row = mysqli_fetch_assoc($re))
			{
				array_push($out[2], $row);	
			}
			
		}
		
		echo json_encode(array($err, $out, $show));
		
	}
	function save_users(){
		global $conn, $domain_name, $auto_email;

		
		$query = "INSERT INTO `deliveryservice`(`id`, `active`, `code`, `name`, `phone`, `email`, `address`, `city`, `zip`, `description`, `website`,`deliverytracklink`,`img`, `sort`,`status`,`ts`) VALUES ('".$_POST['usersid']."', 
		                                                                                                                                                                           'y', 
																																												   '".mysqli_real_escape_string($conn, $_POST['code'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['name'])."',
																																												   '".mysqli_real_escape_string($conn, $_POST['phone'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['email'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['address'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['city'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['zip'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['description'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['website'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['deliverytracklink'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['image'])."', 
																																												   '".mysqli_real_escape_string($conn, $_POST['sort'])."',
																																													'h',
																																												   CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
		                                            
													active = '".mysqli_real_escape_string($conn, $_POST['active'])."',
													code = '".mysqli_real_escape_string($conn, $_POST['code'])."',
													name = '".mysqli_real_escape_string($conn, $_POST['name'])."',
													phone = '".mysqli_real_escape_string($conn, $_POST['phone'])."',
													email = '".mysqli_real_escape_string($conn, $_POST['email'])."',
													address = '".mysqli_real_escape_string($conn, $_POST['address'])."',
													city = '".mysqli_real_escape_string($conn, $_POST['city'])."',
													zip = '".mysqli_real_escape_string($conn, $_POST['zip'])."',
													description = '".mysqli_real_escape_string($conn, $_POST['description'])."',
													website = '".mysqli_real_escape_string($conn, $_POST['website'])."',
													deliverytracklink = '".mysqli_real_escape_string($conn, $_POST['deliverytracklink'])."',
													sort = '".mysqli_real_escape_string($conn, $_POST['sort'])."',
													img = '".mysqli_real_escape_string($conn, $_POST['image'])."'";
		mysqli_query($conn, $query);	
		echo 1;
	}
	function delete_users(){
		global $conn;
		session_start();
		if($_POST['usersid'] != "" && $_POST['usersid'] != $_SESSION['id'])
		{
			$query = "DELETE FROM deliveryservice WHERE id = ".$_POST['usersid'];
			mysqli_query($conn, $query);
			echo 1;
			userlog($_SESSION['moduleid'], "user", $_POST['usersid'], $_SESSION['id'], "delete");
		}
		else{
			echo 0;	
		}
		
	}
	
	
	function add_save_group(){
		global $conn;
		$err = 0;
		if($_POST['groupid'] == "")
		{
			$query = "INSERT INTO `socialnetwork`(`id`, `name`, `icon`, `status`, `sort`, `ts`) VALUES ('', '".mysqli_real_escape_string($conn, $_POST['name'])."', '".mysqli_real_escape_string($conn, $_POST['image'])."', 'v', 0, CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
			$lastid = mysqli_insert_id($conn);
			userlog($_SESSION['moduleid'], "user group", $lastid, $_SESSION['id'], "add");
		}
		echo json_encode(array($err));
	}
	
	function delete_group(){
		global $conn;
		$err = 0;
		
		if($_POST['groupid'] != "")
		{
			$query = "DELETE FROM `socialnetwork` WHERE id =".$_POST['groupid'];
			mysqli_query($conn, $query);
		}
		
		echo json_encode(array($err));	
	}
	
	function delete_social_item_partner(){
		global $conn;
		$err = 0;
		
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `socialnetworkitem` WHERE foreigntable = 'partner' AND foreignkey =".$_POST['id']." AND socialnetworkid = ".$_POST['socialid'];
			
			mysqli_query($conn, $query);
		}
		
		echo json_encode(array($err));		
	}
	
	function add_Social_Item_Partner(){
		global $conn;
		$err = 0;
		if($_POST['groupid'] == "")
		{
			$query = "INSERT INTO `socialnetworkitem`(`id`, `socialnetworkid`, `foreigntable`, `foreignkey`, `link`, `status`, `sort`, `ts`) VALUES ('', '".mysqli_real_escape_string($conn, $_POST['socialid'])."', 'partner', '".mysqli_real_escape_string($conn, $_POST['id'])."', '".mysqli_real_escape_string($conn, $_POST['link'])."', 'v', '0', CURRENT_TIMESTAMP)";

			mysqli_query($conn, $query);
			$lastid = mysqli_insert_id($conn);
			userlog($_SESSION['moduleid'], "user group", $lastid, $_SESSION['id'], "add");
		}
		echo json_encode(array($err));
	}
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `deliveryservice` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}

?>