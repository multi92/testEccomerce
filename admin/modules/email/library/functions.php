<?php
	global $subdirectory ;
	$subdirectory = "aswo/";
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getmessageslist" : get_messages_list(); break;
			case "changemessagestatus" : change_message_status(); break;
			case "getmessage" : get_message(); break;
			case "replaymessage" : replay_message(); break;
			
			case "addChangeOdgovori" : add_Change_Odgovori(); break;
			case "deleteOdgovori" : delete_Odgovori(); break;
			case "getOdgovori" : get_Odgovori(); break;
			
			case "changetounread" : change_to_unread(); break;
			case "printdata" : print_data(); break;
		}
	}
	
	
	function get_messages_list(){
		global $conn;
		$err = 0;			
		$data = array();
	
		$page = intval($_POST['page']);
		if($page < 0){
			$page = 1;
		}
		
		$search = "";
		if($_POST['srch'] != "")
		{
			$search = " AND (m.email like '%".$_POST['srch']."%' OR u.email like '%".$_POST['srch']."%' OR u.name like '%".$_POST['srch']."%' OR u.surname like '%".$_POST['srch']."%' )";	
		}
		
		$type= " ";
		if($_POST['messagetype'] != ""){
			$type = " AND m.type = '".$_POST['messagetype']."' ";	
		}
		
		$query = "SELECT SQL_CALC_FOUND_ROWS m.id, m.email, m.name, m.title, m.type, m.status, m.owner, m.createdate, m.changedate, CONCAT(u.name,\" \",u.surname) as uname, u.email as uemail, (SELECT count(id) FROM messages WHERE status='n' AND parent=m.id AND owner != 0) as num
		FROM  messages m LEFT JOIN user u ON m.owner=u.id 
		WHERE parent = 0 ".$type." ".$search." ORDER BY num DESC, status ASC, changedate DESC  
		LIMIT ".(($page-1)*20).", 20";
		
		//echo $query;

		$re = mysqli_query($conn ,$query);
		if(mysqli_num_rows($re) > 0)
		{	
			$sQuery = "SELECT FOUND_ROWS()";
			$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
			$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
			$iTotal = $aResultFilterTotal[0];

			while($aRow = mysqli_fetch_assoc($re))
			{
				$row = array();

				$row[0] = ($aRow['owner'] == 0) ? $aRow['name'] : $aRow['uname'];
				$row[1] = ($aRow['owner'] == 0) ? $aRow['email'] : $aRow['uemail'];
				$row[2] = $aRow['title'];
				$row[3] = $aRow['type'];
				$row[4] = $aRow['status'];
				
				/*$time = strtotime($aRow['createdate']);
				$time = time() - $time; 
				$time = ($time<1)? 1 : $time;
				$tokens = array (
					31536000 => 'godina',
					2592000 => 'meseci',
					604800 => 'nedelja',
					86400 => 'dana',
					3600 => 'sata',
					60 => 'minuta',
					1 => 'sekunda'
				);

				foreach ($tokens as $unit => $text) {
					if ($time < $unit) continue;
					$numberOfUnits = floor($time / $unit);
					$row[5] = $numberOfUnits.' '.$text;
					break;
				}*/
				$da = strtotime($aRow['createdate']);
				
				$row[5] = date("d-m-Y H:i:s",$da);
				$row[6] = $aRow['changedate'];	
				$row[7] = ($aRow['num'] == 0) ? 0 : 1;
				$row[99] = $aRow['id'];	
				array_push($data, $row);
			}
		}
		else{
			$iTotal = 0;	
		}
		
		echo json_encode(array($err, $iTotal, $data));	
			
	}
	function change_message_status(){
		global $conn;
		$err = 0;
		
		$query = "UPDATE messages SET status ='".$_POST['status']."'";
		if(mysqli_query($conn, $query))
		{
			$err= 1;	
		}
		
		echo json_encode(array($err));		
	}
	
	function get_message(){
		global $conn;
		$err = 0;	
		$data = array();
		
		
		$query = "SELECT m.id, m.`name`, m.email, m.title, m.message, m.type, m.status, m.owner, m.createdate, m.changedate, m.documentid, CONCAT(u.name,\" \",u.surname) as uname, u.email as uemail
		FROM  messages m 
		LEFT JOIN user u ON m.owner=u.id 
		WHERE m.parent = ".$_POST['msgid']." OR m.id = ".$_POST['msgid']." ORDER BY id ASC ";
		$re = mysqli_query($conn, $query);
		//echo $query;
		while($aRow = mysqli_fetch_assoc($re))
			{
				if($aRow['status'] == "n"){
					$query = "UPDATE messages SET status ='r' WHERE (id =".$aRow['id']." AND owner != 0) OR id =".$_POST['msgid']."";
					mysqli_query($conn, $query);
				}	
				$row = array();

				$row[0] = ($aRow['owner'] == 0) ? $aRow['name'] : $aRow['uname'];
				$row[1] = ($aRow['owner'] == 0) ? $aRow['email'] : $aRow['uemail'];
				$row[2] = $aRow['title'];
				$row[3] = $aRow['type'];
				$row[4] = $aRow['status'];
				
				$time = strtotime($aRow['createdate']);
				$time = time() - $time; 
				$time = ($time<1)? 1 : $time;
				$tokens = array (
					31536000 => 'godina',
					2592000 => 'meseci',
					604800 => 'nedelja',
					86400 => 'dana',
					3600 => 'sata',
					60 => 'minuta',
					1 => 'sekunda'
				);

				foreach ($tokens as $unit => $text) {
					if ($time < $unit) continue;
					$numberOfUnits = floor($time / $unit);
					$row[5] = $numberOfUnits.' '.$text;
					break;
				}

				$row[6] = $aRow['changedate'];
				
				if($aRow['type'] == "a"){
					$aRow['message'];
					
					$pattern = '/(?=\(\w)/';
					$a = preg_replace($pattern, '<b>', $aRow['message']);
					
					$pattern = '/(?<=kolicina:.\))/';
					$aRow['message'] = preg_replace($pattern, '</b>', $a);
				}	
				
				$row[7] = $aRow['message'];	
				$row[8] = $aRow['documentid'];	
				$row[9] = '';	
				$row[99] = $aRow['id'];	
				array_push($data, $row);
			}
		echo json_encode(array($err,$data));
	}
	
	function replay_message(){
		
		die();
		global $conn;
		$err = 0;
		
		$query = "SELECT type FROM messages WHERE id = ".$_POST['parentid'];
		$re = mysqli_query($conn, $query);
		$ref = mysqli_fetch_array($re);
		$type = $ref[0];
		
		if($type == 'c'){
			$query = "SELECT email FROM messages m
			WHERE m.id = ".$_POST['parentid'];	
		}
		else{
			$query = "SELECT u.email FROM messages m
			LEFT JOIN user u ON m.owner = u.ID
			WHERE m.id = ".$_POST['parentid'];
		}
		$re = mysqli_query($conn, $query);
		$rowid = mysqli_fetch_assoc($re);
		$send_email = $rowid['email'];
		
		$query = "UPDATE messages SET changedate = NOW() WHERE id = ".$_POST['parentid'];
		mysqli_query($conn, $query);
		
		$query = "INSERT INTO `messages`(`id`, `name`, `title`, `phone`, `email`, `message`, `type`, `parent`, `status`, `sort`, `owner`, `createdate`, `changedate`, `documentid`, `messagests`) VALUES ('', '', '".mysqli_real_escape_string($conn, $_POST['title'])."', '', '', '".mysqli_real_escape_string($conn, $_POST['msg'])."', '".$type."', '".mysqli_real_escape_string($conn, $_POST['parentid'])."', 'n', 0, 0, NOW(), NOW(), 0, CURRENT_TIMESTAMP)";
		if(mysqli_query($conn, $query))
		{
			$err= 1;
			$to = $send_email;
			$subject = "NABAVI.RS - Nova poruka";
			if($type == "c"){
				$message = "Poštovani, \r\n\r\n
<br /><br />
".$_POST['msg']."
\r\n\r\n <br /><br />
Nemojte odgovarati na ovu poruku! Ukoliko zelite da postavite neko pitanje posetite stranicu nabavi.rs/kontakt
\r\n\r\n <br /><br />
Srdačan pozdrav,
Nabavi.rs \r\n\r\n <br /><br />";
			}
			else
			{
			$message = "Poštovani, \r\n\r\n
<br /><br />
Imate novu poruku (odgovor) na Vašem nalogu na sajtu: www.nabavi.rs
\r\n\r\n <br /><br />
Ovo je automatska poruka, na nju nemojte odgovarati.
\r\n\r\n <br /><br />
Srdačan pozdrav,
Nabavi.rs \r\n\r\n <br /><br />";
			}
			$headers = 'From: gocrvenikrst.rs webmaster@gocrvenikrst.rs>' . "\r\n";
			$headers .='X-Mailer: PHP/' . phpversion();
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=UTF-8\r\n";  

			mail($to, $subject, $message, $headers);
			
			
		}
		
		echo json_encode(array($err));	
	}
	
	function add_Change_Odgovori(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";
		if($_POST['id'] != ""){
			/**	update */	
			$query = "UPDATE `odgovori` SET `value`='".mysqli_real_escape_string($conn, $_POST['data']['value'])."' WHERE id=".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
			$lastid = $_POST['id'];
		}
		else{
			/**	add new */	
			
			$query = "INSERT INTO `odgovori`(`id`, `value`, `odgovorits`) VALUES ('','".mysqli_real_escape_string($conn, $_POST['data']['value'])."', CURRENT_TIMESTAMP)";
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
			$lastid = mysqli_insert_id($conn);
		}

		echo json_encode(array($err, $lastid));		
	}
	

	function delete_Odgovori(){
		global $conn, $lang;
		$err = 0;
		$lastid = "";
		$query = "DELETE FROM `odgovori` WHERE id=".$_POST['id'];
		if(!mysqli_query($conn, $query))
		{
			$err = 1;	
		}
		$lastid = $_POST['id'];
		echo json_encode(array($err, $lastid));		
	}
	

	function get_Odgovori(){
		global $conn, $lang;
		$err = 0;
		$data = array();
		
		$where = "";
		if($_POST['id'] != ""){
			/**	return 1 extradetail	*/	
			$where = " WHERE id = ".$_POST['id']." ";
			
		}
		
		$query = "SELECT `id`, `value` FROM `odgovori`".$where;
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data, $row);
		}	

			
		echo json_encode(array($err, $data));		
	}

	function change_to_unread(){
		global $conn;
		$err = 0;
		$query = "UPDATE messages SET status = 'n' where id = ".$_POST['id'];
		if(mysqli_query($conn, $query))
		{
			$err = 1;	
		}
		
		echo json_encode(array($err));
	}
	
	function print_data(){
		global $conn;
		$err = 0;
		
		$query = "SELECT m.id, m.message, u.* FROM `messages` m
				LEFT JOIN user u ON m.owner = u.id
				WHERE m.id = ".$_POST['msgid'];	
		$re = mysqli_query($conn, $query);
		
		$data = array();
		
		$row = mysqli_fetch_assoc($re);
		
		preg_match_all('/code:[a-zA-Z0-9]*/', $haystack, $matches);
		
		$proarr = array();
		foreach($matches[0] as $k=>$v)
		{
			$a = explode(":", $v);
			// $a[1]
			$query = "SELECT * FROM lat_product WHERE code = ".$a[1];
			$re = mysqli_query($conn, $query);
			
			$prow = mysqli_fetch_assoc($re);
			
			array_push($proarr, array($prow['id'], $prow['code'], $prow['name']));	
		}
		
		$data[0] = $row['name']." ".$row['surname'];
		$data[1] = $row['address']." ".$row['zip'].", ".$row['city']; 
		$data[2] = $row['email'];
		$data[3] = $row['phone'];
		$data[99] = $row["id"];
		
		echo json_encode(array($err, $data, $proarr));
	}
	
?>