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
			case "saveusers" : save_users(); break;	
			case "deleteusers" : delete_users(); break;	
			
			case "addsavegroup" : add_save_group(); break;	
			case "deletegroup" : delete_group(); break;	
			case "activateuser" : activateuser(); break;
			case "sendnewpassword" : send_new_password(); break;
			case "changepassword" : change_password(); break;
		}
	}

	function activateuser()
	{
		global $conn, $domain_name, $auto_email, $contact_admin_email;
		$out = array();
		
		/*if($_POST['status']==1){
			$new_status=0;
		}else{
			$new_status=1;
		}
		*/
		//$userid=$_POST['usersid']
		
		$query='UPDATE `user` SET status='.$_POST['status'].' ,updated=2 WHERE id='.$_POST['usersid'];

		$re = mysqli_query($conn, $query);

			$query1 = "INSERT INTO `privilages_usergroup` (`groupid`, `userid`, `default`, `status`,`ts`) 
						 VALUES ('1', 
							     '".mysqli_real_escape_string($conn, $_POST['usersid'])."', 
								 '0', 
								 'v', 
								CURRENT_TIMESTAMP) 
						 ON DUPLICATE KEY UPDATE `default` = '0',
												 `status` = ".$_POST['status']." ";
			$re1 = mysqli_query($conn, $query1);

		if($re && ($_POST['status']=='3' || $_POST['status']=='0'))
		{
			$query = "SELECT email FROM user WHERE id = '".$_POST['usersid']."'";
			//echo $query;
			$ere = mysqli_query($conn, $query);
			if(mysqli_num_rows($ere) > 0)
			{
				$msgstatus='0';
				$adminmsgstatus='0';
				$erow = mysqli_fetch_assoc($ere);
				$useremail=$erow['email'];
				$to = $useremail;
				$subject = "Aktivacija korisnika ".$domain_name."";
				if($_POST['status']=='3'){
					$message = "Vaša nalog za mail adresu ".$to." je aktiviran od strane administratora na ".$domain_name." \r\n\r\n";
				} else if($_POST['status']=='0'){
					$message = "Vaša nalog za mail adresu ".$to." je deaktiviran od strane administratora na ".$domain_name." \r\n\r\n";
					$message .= "Za više informacija obratite se na mail ".$contact_admin_email." \r\n\r\n";
				}
				
		
					$headers = 'From: '.$domain_name.' <'.$auto_email.'>' . "\r\n";
					$headers .='X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=UTF-8\r\n";  
								
						if(mail($to, $subject, $message, $headers)){
							
							//echo json_encode(array('status'=>"success", "status_code"=>0, "msg"=>"Uspešno ste izmenili status korisnika."));	
							$msgstatus= '1';	
						}else{
							$msgstatus= '0';
							//var_dump(error_get_last());
							//echo json_encode(array('status'=>"fail", "status_code"=>2, "msg"=>"Greška prilikom slanja emaila!"));			
						}

				
				$to = $contact_admin_email;
				$subject = "Promenjen status korisnika ".$domain_name."";
				if($_POST['status']=='3'){
					$message = "Nalog za mail adresu ".$useremail." je aktiviran od strane administratora ".ucfirst($_SESSION['ime'])." ".ucfirst($_SESSION['prezime'])." na ".$domain_name." \r\n\r\n";
				} else if($_POST['status']=='0'){
					$message = "Nalog za mail adresu ".$useremail." je deaktiviran od strane administratora ".ucfirst($_SESSION['ime'])." ".ucfirst($_SESSION['prezime'])." na ".$domain_name." \r\n\r\n";
					//$message .= "Za više informacija obratite se na mail ".$contact_admin_email." \r\n\r\n";
				}
				
		
					$headers = 'From: '.$domain_name.' <'.$auto_email.'>' . "\r\n";
					$headers .='X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=UTF-8\r\n";  
								
						if(mail($to, $subject, $message, $headers)){
							
							//echo json_encode(array('status'=>"success", "status_code"=>0, "msg"=>"Uspešno ste izmenili status korisnika."));	
							$adminmsgstatus= '1';	
						}else{
							$adminmsgstatus= '0';
							//var_dump(error_get_last());
							//echo json_encode(array('status'=>"fail", "status_code"=>2, "msg"=>"Greška prilikom slanja emaila!"));			
						}
					if($msgstatus=='1' && $adminmsgstatus=='1'){
						echo '1';
					} else {
						echo '0';
					}
					//echo '1';
				} else {
					echo '0';
				}
			
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
			if($_SESSION['id'] != $_POST['usersid'])
			{
				$query = 'SELECT u.*, p.id as partnerid FROM `user` u 
					LEFT JOIN partner p ON u.partnerid = p.id 
				WHERE u.id = '.$_POST['usersid'];

				$re = mysqli_query($conn, $query);

				$urow = mysqli_fetch_assoc($re);
                
				$urow['birthday'] = date("d.m.Y", strtotime($urow['birthday']));
				
				$out[0] = $urow;
				
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
			}
		}
		
		echo json_encode(array($err, $out, $show));
		
	}
	function save_users(){
		global $conn, $domain_name, $auto_email;
		if($_POST['usersid'] == "")
		{
			$query = "SELECT * FROM user WHERE email = '".$_POST['email']."'";
			$re = mysqli_query($conn, $query);
			if(mysqli_num_rows($re) > 0)
			{
				echo "Email već posoji u bazi.";
			}
			else
			{
				$pass= random_password(8);
				$query = "INSERT INTO `user`(`partnerid`, `username`, `password`, `email`, `type`, `last_logged`, `name`, `surname`, `address`, `city`, `zip`,`birthday`, `phone`, `mobile`, `rebate`, `email_notif`, `status`,`picture`,
				`default_langid`) VALUES ( '".$_POST['partnerid']."' ,'".$_POST['username']."','".md5($pass)."','".$_POST['email']."', '".$_POST['type']."' ,NOW(),'".$_POST['name']."','".$_POST['surname']."','".$_POST['address']."','".$_POST['city']."','".$_POST['zip']."','".mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['birthday'])))."','".$_POST['phone']."','".$_POST['mobile']."',0,1,1,'".$_POST['picture']."',".$_POST['default_langid'].")";
				//echo $query;
				mysqli_query($conn, $query);
				$lastid = mysqli_insert_id($conn);
				
				
				$to = $_POST['email'];
				$subject = "Registracija korisnika ".$domain_name[1]."";
				$message = "Vaša email adresa je upravo registrovana na ".$domain_name[1]." \r\n\r\n";
				$message .= "Lozinka: ".$pass." \r\n";
	
				$headers = 'From: '.$domain_name[1].' <'.$auto_email[1].'>' . "\r\n";
				$headers .='X-Mailer: PHP/' . phpversion();
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";  
						
				mail($to, $subject, $message, $headers);
				echo 1;
				userlog($_SESSION['moduleid'], "user", $lastid, $_SESSION['id'], "add");
			}
		}
		else
		{
			$query = "UPDATE `user` SET `name`='".$_POST['name']."', partnerid = '".$_POST['partnerid']."' ,`surname`='".$_POST['surname']."', `username`='".$_POST['username']."', `type`='".$_POST['type']."' , `email`='".$_POST['email']."', `address`='".$_POST['address']."', `city`='".$_POST['city']."', `zip`='".$_POST['zip']."', `birthday`='".mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['birthday'])))."', `phone`='".$_POST['phone']."', `mobile`='".$_POST['mobile']."', `picture`='".$_POST['picture']."', `default_langid`=".$_POST['default_langid']." WHERE ID = ".$_POST['usersid'];	
			mysqli_query($conn, $query);
			//echo $query;
			$q = "INSERT INTO `privilages_usergroup`(`groupid`, `userid`, `default`, `status`, `ts`) VALUES (
				1,
				".$_POST['usersid'].",
				0,
				'v',
				CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE status = 'v'";	
			mysqli_query($conn, $q);
				
			if(isset($_POST['up']))
			{
				foreach($_POST['up'] as $key=>$val)
				{
					$query = "INSERT INTO `userprivilage`(`userid`, `moduleid`, `groupid`, `ts`) VALUES (".$_POST['usersid']." , ".$val['modulid'].", ".$val['groupid'].", CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `groupid`=".$val['groupid'];	
					if($val['groupid'] == ''){
						$query = 'DELETE FROM `userprivilage` WHERE userid='.$_POST['usersid'].' AND moduleid = '.$val['modulid'];	
					}
					
					mysqli_query($conn, $query);
				}
			}
			echo 2;
			userlog($_SESSION['moduleid'], "user", $_POST['usersid'], $_SESSION['id'], "change");
		}
	}
	function delete_users(){
		global $conn;
		session_start();
		if($_POST['usersid'] != "" && $_POST['usersid'] != $_SESSION['id'])
		{
			$query = "DELETE FROM user WHERE id = ".$_POST['usersid'];
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
			$query = "INSERT INTO `usergroup`(`id`, `name`, `see`, `change`, `add`, `delete`, `activate`, `status`, `ts`) VALUES ('', 
			'".mysqli_real_escape_string($conn, $_POST['name'])."', '".$_POST['see']."', '".$_POST['change']."', '".$_POST['add']."', '".$_POST['delete']."', '".$_POST['activate']."', '', CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
			$lastid = mysqli_insert_id($conn);
			userlog($_SESSION['moduleid'], "user group", $lastid, $_SESSION['id'], "add");
		}
		else{
			$query = 'UPDATE `usergroup` SET `see`="'.$_POST['see'].'", `change`="'.$_POST['change'].'", `add`="'.$_POST['add'].'", `delete`="'.$_POST['delete'].'", `activate`="'.$_POST['activate'].'" WHERE id='.$_POST['groupid'];
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "user group", $_POST['groupid'], $_SESSION['id'], "change");
		}
		echo json_encode(array($err));
	}
	
	function delete_group(){
		global $conn;
		$err = 0;
		
		if($_POST['groupid'] != "")
		{
			$query = "DELETE FROM `usergroup` WHERE id =".$_POST['groupid'];
			mysqli_query($conn, $query);
		}
		
		echo json_encode(array($err));	
	}
	
	function send_new_password(){
		global $conn, $domain_name, $auto_email;
		if(isset($_POST['id']) && $_POST['id'] != "")
		{
			$query = "SELECT email FROM user WHERE id = '".$_POST['id']."'";
			$re = mysqli_query($conn, $query);
			if(mysqli_num_rows($re) > 0)
			{
				$row = mysqli_fetch_assoc($re);
				$pass= random_password(8);
				$q = "UPDATE `user` SET `password`= '".md5($pass)."' WHERE id = ".$_POST['id'];
				if(mysqli_query($conn, $q)){
					$to = $row['email'];
					$subject = "Registracija korisnika ".$domain_name."";
					$message = "Vaša lozinka je upravo promenjena od strane administratora na ".$domain_name." \r\n\r\n";
					$message .= "Nova lozinka: ".$pass." \r\n";
		
					$headers = 'From: '.$domain_name.' <'.$auto_email.'>' . "\r\n";
					$headers .='X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=UTF-8\r\n";  
							
					if(mail($to, $subject, $message, $headers)){
						echo json_encode(array('status'=>"success", "status_code"=>0, "msg"=>"Uspešno poslato!"));		
					}else{
						var_dump(error_get_last());
						echo json_encode(array('status'=>"fail", "status_code"=>2, "msg"=>"Greška prilikom slanja emaila!"));			
					}
				}
			}else{
				echo json_encode(array('status'=>"fail", "status_code"=>1, "msg"=>"Nevalidan korisnik!"));		
			}
		}else{
			echo json_encode(array('status'=>"fail", "status_code"=>0, "msg"=>"Nedostaju parametri!"));	
		}
	}

	function change_password(){
		global $conn, $domain_name, $auto_email;
		if(isset($_POST['userid']) && $_POST['userid'] != "" && $_POST['newpass']==$_POST['newrepeatpass'])
		{
			$query = "SELECT email FROM user WHERE id = '".$_POST['userid']."'";
			$re = mysqli_query($conn, $query);
			if(mysqli_num_rows($re) > 0)
			{
				$row = mysqli_fetch_assoc($re);
				$pass= $_POST['newpass'];
				$q = "UPDATE `user` SET `password`= '".md5($pass)."' WHERE id = ".$_POST['userid'];
				if(mysqli_query($conn, $q)){
					$to = $row['email'];
					$subject = "Registracija korisnika ".$domain_name."";
					$message = "Vaša lozinka je upravo promenjena od strane administratora na ".$domain_name." \r\n\r\n";
					$message .= "Nova lozinka: ".$pass." \r\n";
		
					$headers = 'From: '.$domain_name.' <'.$auto_email.'>' . "\r\n";
					$headers .='X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=UTF-8\r\n";  
							
					if(mail($to, $subject, $message, $headers)){
						echo json_encode(array('status'=>"success", "status_code"=>0, "msg"=>"Uspešno ste promenili šifru, Email sa novom šifrom je uspešno poslat korisniku."));		
					}else{
						var_dump(error_get_last());
						echo json_encode(array('status'=>"fail", "status_code"=>2, "msg"=>"Greška prilikom slanja emaila!"));			
					}
				}
			}else{
				echo json_encode(array('status'=>"fail", "status_code"=>1, "msg"=>"Nevalidan korisnik!"));		
			}
		}else{
			echo json_encode(array('status'=>"fail", "status_code"=>0, "msg"=>"Nedostaju parametri!"));	
		}
	}

?>