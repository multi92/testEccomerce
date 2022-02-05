<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	session_start();
	mb_internal_encoding("UTF-8");
		
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "addNewAttr" : add_New_Attr(); break;
			case "deleteAttr" : delete_Attr(); break;
			case "getAttr" : get_Attr(); break;
			case "deleteAttrVal" : delete_Attr_Val(); break;
			case "addNewAttrVal" : add_New_Attr_Val(); break;
			case "changeAttrVal" : change_Attr_Val(); break;
			case "updateSortAttrVal" : update_Sort_Attr_Val(); break;
			case "addNewAttrDownload" : add_New_Attr_Download(); break;
			case "deleteAttrDocument" : delete_Attr_Document(); break;
			case "saveAttrValMainImage" : save_Attr_Val_Main_Image(); break;
			case "saveAttrValMainColor" : save_Attr_Val_Main_Color(); break;
		}
	}
	
	
	function add_New_Attr(){
		global $conn;
		$err = 0;
		$lastid = "";
		
		$defaultval = "";
		foreach($_POST['data'] as $k=>$v){
			if($v['default'] == 'y'){
				$defaultval = $v['value'];	
			}
		}

		$query = "INSERT INTO `attr`(`id`, `name`, `sort`, `status`, `ts`) VALUES ('".$lastid."', '".mysqli_real_escape_string($conn, $defaultval)."', 0, 'v', CURRENT_TIMESTAMP)";
		
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);	
	
		foreach($_POST['data'] as $k=>$v){
			$query = "INSERT INTO `attr_tr`(`attrid`, `langid`, `name`, `ts`) VALUES ('".$lastid."', ".$v['langid'].", '".mysqli_real_escape_string($conn, $v['value'])."', CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
		}

		echo json_encode(array($err, $lastid));	
	}
	function delete_Attr(){
		global $conn, $lang;
		$err = 0;
		if($_POST['id'] != "")
		{
			$attrvalid = array();
			$q = "SELECT id FROM attrval WHERE attrid = ".$_POST['id'];
			$res = mysqli_query($conn, $q);
			if(mysqli_num_rows($res) > 0){
				while($row = mysqli_fetch_assoc($res))
				{
					array_push($attrvalid, $row['id']);
				}
				
				$query = "DELETE FROM `attrval` WHERE id in (".implode(",", $attrvalid).")";
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM `attrval_file` WHERE attrvalid in (".implode(",", $attrvalid).")";
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM `attrval_tr` WHERE attrvalid in (".implode(",", $attrvalid).")";
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM `attrprodval` WHERE attrvalid in (".implode(",", $attrvalid).")";
				mysqli_query($conn, $query);
								
			}	
			
			$query = "DELETE FROM `attr` WHERE id = ".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
			$query = "DELETE FROM `attr_tr` WHERE attrid = ".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
			$query = "DELETE FROM `attrcategory` WHERE attrid = ".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
		}
		echo $err;	
	}
	function get_Attr(){
		global $conn, $lang;
		
		$data = array();
		$data['documents'] = array();
		$data['lang'] = array();
		
		$data['values'] = array();
		
		if($_POST['id'] != "")
		{
			$q = "SELECT * FROM attr_file WHERE attrid = ".$_POST['id']." ORDER BY type ASC";
			$res = mysqli_query($conn, $q);
			while($row = mysqli_fetch_assoc($res)){
				array_push($data['documents'], $row);	
			}
			
			$q = "SELECT * FROM languages l ORDER BY `default` ASC";
			$resl = mysqli_query($conn, $q);
			
			while($rowl = mysqli_fetch_assoc($resl)){
				
				//$data['lang'][$rowl['shortname']] = array();
				
				$q = "SELECT a.*, (SELECT name FROM attr_tr WHERE attrid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as nametr FROM attr a
						WHERE a.id = ".$_POST['id']."
						ORDER BY a.sort ASC";
						
				$res = mysqli_query($conn, $q);
				$rowattr = mysqli_fetch_assoc($res);
				
				array_push($data['lang'],array('langid'=>$rowl['id'],
													'langname'=>$rowl['name'],
													'default'=>$rowl['default'],
													'id'=>$rowattr['id'],
													'name'=>($rowattr['nametr'] == NULL && $rowl['default'] == 'y')? $rowattr['name']:$rowattr['nametr']));
				
				$q = "SELECT av.* , (SELECT `value` FROM attrval_tr WHERE attrvalid = av.id AND langid = ".$rowl['id']." ) as `valuetr` FROM `attrval` av WHERE av.attrid = ".$_POST['id']." ORDER BY av.sort ASC";
				$resattrval = mysqli_query($conn, $q);
				while($rowaval = mysqli_fetch_assoc($resattrval)){
					
					//var_dump($rowaval);
					
					$q = "SELECT * FROM attrval_file WHERE type = 'mc' AND attrvalid=".$rowaval['id'];
					$resm = mysqli_query($conn, $q);
					$rowmc = mysqli_fetch_assoc($resm);
					$contmc = array('content'=>$rowmc['content'], 
									'contentface'=>$rowmc['contentface'],
									'id'=>$rowmc['id'],
									'type'=>$rowmc['type']);
					
					$q = "SELECT * FROM attrval_file WHERE type = 'mi' AND attrvalid=".$rowaval['id'];
					$resm = mysqli_query($conn, $q);
					$rowmi = mysqli_fetch_assoc($resm);
					$contmi = array('content'=>$rowmi['content'], 
									'contentface'=>$rowmi['contentface'],
									'id'=>$rowmi['id'],
									'type'=>$rowmi['type']);
					
					$q = "SELECT * FROM attrval_file WHERE type != 'mi' AND type != 'mc' AND attrvalid=".$rowaval['id'];
					$resdoc = mysqli_query($conn, $q);
					
					$doccont = array();
					while($rowdoc  = mysqli_fetch_assoc($resdoc)){
						array_push($doccont, $rowdoc);	
					}
					
					$found = false;
					$key = false;
					foreach($data['values'] as $k=>$v){
						if($v['id'] == $rowaval['id']){
							$found = true;
							$key = $k;
							break;	
						}
					}
					
					if(!$found)	{ 
						array_push($data['values'], array('lang'=>array())); 
						$key = count($data['values'])-1;
					}
					
					$data['values'][$key]['id'] = $rowaval['id'];
					$data['values'][$key]['documents'] = $doccont;
					$data['values'][$key]['mi'] = $contmi;
					$data['values'][$key]['mc'] = $contmc;
										
					array_push($data['values'][$key]['lang'], array('langid'=>$rowl['id'],
													'langname'=>$rowl['name'],
													'default'=>$rowl['default'],
													'id'=>$rowaval['id'],
													'value'=>($rowaval['valuetr'] == NULL && $rowl['default'] == 'y')? $rowaval['value']:$rowaval['valuetr']));
						
				}
				
			}
			
		}
		echo json_encode($data);	
	}
	
	function delete_Attr_Val(){
		global $conn, $lang;
		$err = 0;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `attrval` WHERE id = ".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
			$query = "DELETE FROM `attrval_tr` WHERE attrvalid = ".$_POST['id'];
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			} 
		}
		echo $err;		
	}
	
	function add_New_Attr_Val(){
		
		global $conn;
		$err = 0;
		$lastid = "";
		
		$defaultval = "";
		foreach($_POST['data'] as $k=>$v){
			if($v['default'] == 'y'){
				$defaultval = $v['value'];	
			}
		}

		$query = "INSERT INTO `attrval`(`id`, `attrid`, `value`, `sort`, `status`, `ts`) VALUES ('".$lastid."', ".$_POST['attrid'].", '".mysqli_real_escape_string($conn, $defaultval)."', 0, 'v', CURRENT_TIMESTAMP)";
		
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);	
	
		foreach($_POST['data'] as $k=>$v){
			$query = "INSERT INTO `attrval_tr`(`attrvalid`, `langid`, `value`, `ts`) VALUES ('".$lastid."', ".$v['langid'].", '".mysqli_real_escape_string($conn, $v['value'])."', CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
		}

		echo json_encode(array($err, $lastid));	
	}
	
	function change_Attr_Val(){
		global $conn;
		$err = 0;
		
		foreach($_POST['data'] as $k=>$v){
			if($v['default'] == 'y'){
				$query = "UPDATE `attr` SET `name`='".$v['name']."' WHERE id=".$_POST['attrid'];
				if(!mysqli_query($conn, $query))
				{
					$err = 1;	
				}
			}
			
			$query = "INSERT INTO `attr_tr`(`attrid`, `langid`, `name`, `ts`) VALUES (".$_POST['attrid'].", ".$v['langid'].", '".$v['name']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".$v['name']."'";
			if(!mysqli_query($conn, $query))
			{
				$err = 1;	
			}
		}
		
		echo $err;	
	}
	
	function update_Sort_Attr_Val(){
		global $conn;	
		
		$count = 1;
		foreach($_POST['data'] as $k=>$v){
			$q = "UPDATE `attrval` SET `sort`=".$count." WHERE id = ".$v;
			mysqli_query($conn, $q);
			$count++;
		}
	}
	
	function add_New_Attr_Download(){
		global $conn;
		$err = 0;
		
		$query = "INSERT INTO `attr_file`(`id`, `attrid`, `type`, `content`, `contentface`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['attrid'].", '".$_POST['type']."', '".mysqli_real_escape_string($conn, $_POST['content'])."', '".mysqli_real_escape_string($conn, $_POST['contentface'])."', 'v', 0, CURRENT_TIMESTAMP)";	
		if(!mysqli_query($conn, $query))
		{
			$err = 1;
		}else{
			$lastid = mysqli_insert_id($conn);	
		}
		echo json_encode(array($err, $lastid));
	}
	
	function delete_Attr_Document(){
		global $conn;
		
		$query = "DELETE FROM attr_file WHERE id = ".$_POST['id'];	
		mysqli_query($conn, $query);
	}
	
	function save_Attr_Val_Main_Color(){
		global $conn;	
		
		$query = "UPDATE attrval_file SET content = '".mysqli_real_escape_string($conn, $_POST['value'])."' WHERE attrvalid = ".$_POST['id']." AND type = 'mc'";
		$res = mysqli_query($conn, $query);
		if(mysqli_affected_rows($conn) == 0){
			$query = "INSERT INTO `attrval_file`(`id`, `attrvalid`, `type`, `content`, `contentface`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['id'].", 'mc', '".mysqli_real_escape_string($conn, $_POST['value'])."', '', 'v', 0, CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
		}
	}
	
	function save_Attr_Val_Main_Image(){
		global $conn;	
		
		$query = "UPDATE attrval_file SET content = '".mysqli_real_escape_string($conn, $_POST['value'])."' WHERE attrvalid = ".$_POST['id']." AND type = 'mi'";
		$res = mysqli_query($conn, $query);
		if(mysqli_affected_rows($conn) < 1){
			$query = "INSERT INTO `attrval_file`(`id`, `attrvalid`, `type`, `content`, `contentface`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['id'].", 'mi', '".mysqli_real_escape_string($conn, $_POST['value'])."', '', 'v', 0, CURRENT_TIMESTAMP)";
			mysqli_query($conn, $query);
		}
	}
?>