<?php

	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
			
			case "updatelocalattr" : updateLocalAttr(); break;	
			case "addlocalattr" : addLocalAttr(); break;	
			
			case "updatelocalattrval" : updateLocalAttrval(); break;	
			case "addlocalattrval" : addLocalAttrval(); break;			
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `city` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `city_tr` WHERE cityid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `city` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM city WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		$data['id'] = $row['id'];
		$data['name'] = $row['name'];
		$data['coordinates'] = $row['coordinates'];
		
		$q = "SELECT *, (SELECT name FROM city_tr WHERE cityid = ".$_POST['id']." AND langid = l.id ) as nametr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'name'=>($row['nametr'] == NULL && $row['default'] == 'y' )? $data['name']:$row['nametr'] ));
            }
        }
		
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		$defaultname = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultname = $v['name'];
			}	
		}
		
		$query = "INSERT INTO `city`(`id`, `name`, `coordinates`, `sort`, `status`, `ts`) VALUES ('".$_POST['id']."', '".mysqli_real_escape_string($conn, $defaultname)."',  '".mysqli_real_escape_string($conn, str_replace('(','', str_replace(')', '', $_POST['coordinates'])))."', 0, 'v', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $defaultname)."' , 
					`coordinates` = '".mysqli_real_escape_string($conn, str_replace('(','', str_replace(')', '', $_POST['coordinates'])))."'  ";
			
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0 || $lastid == '') $lastid = $_POST['id'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `city_tr`(`cityid`, `langid`, `name`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['name'])."',
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $v['name'])."' ";
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
	
	function updateLocalAttr(){
		global $conn;
		
		$q = "UPDATE `attr_external` SET `attrid` = '".$_POST['localattrid']."' WHERE `attr_external`.`id` = ".$_POST['id'];
		if(mysqli_query($conn, $q)){
			echo json_encode(array("status"=>"success"));
		}else{
			echo json_encode(array("status"=>"fail"));
		}			
	}
	
	function addLocalAttr(){
		global $conn;
		
		$q = "SELECT ae.name FROM attr_external ae
				LEFT JOIN attr a ON ae.name = a.name
				WHERE ae.id = ".$_POST['id']." AND a.name IS NULL";
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) == 1){
			$row = mysqli_fetch_assoc($res); 
			
			$q = "INSERT INTO `attr`(`name`, `sort`, `status`) VALUES ('".$row['name']."',0,'v')";
			if(mysqli_query($conn, $q)){
				$lastid = mysqli_insert_id($conn);
				$q = "UPDATE `attr_external` SET `attrid` = '".$lastid."' WHERE `attr_external`.`id` = ".$_POST['id'];
				if(mysqli_query($conn, $q)){
					echo json_encode(array("status"=>"success", "message"=>"Uspešno dodato!"));
				}else{
					echo json_encode(array("status"=>"fail", "message"=>"Greška prilikom ažuriranja učitanog atributa!"));
				}
			}else{
				echo json_encode(array("status"=>"fail", "message"=>"Greška prilikom dodavanja lokalnog atributa!"));	
			}
		}else{
			echo json_encode(array("status"=>"fail", "message"=>"Atribut sa ovim nazivom već postoji!"));	
		}		
	}
	
	function updateLocalAttrval(){
		global $conn;
		
		$q= "SELECT attrvalid FROM `attrval_external` WHERE id = ".$_POST['id']." AND attrvalid != 0";
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) > 0){
			$row = mysqli_fetch_assoc($res);
			$q = "DELETE FROM attrprodval WHERE attrvalid = ".$row['attrvalid'];
			mysqli_query($conn, $q);
		}
		
		$q = "UPDATE `attrval_external` SET `attrvalid` = '".$_POST['localattrvalid']."' WHERE `attrval_external`.`id` = ".$_POST['id'];
		if(mysqli_query($conn, $q)){
			echo json_encode(array("status"=>"success"));
		}else{
			echo json_encode(array("status"=>"fail"));
		}			
	}
	
	function addLocalAttrval(){
		global $conn;
		
		$q = "SELECT ave.value, ae.attrid FROM attrval_external ave
				LEFT JOIN attr_external ae ON ave.attrid = ae.id
				LEFT JOIN attrval av ON ave.value = av.value
				WHERE ave.id = ".$_POST['id']." AND av.value IS NULL";
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) == 1){
			$row = mysqli_fetch_assoc($res); 
			
			$q = "INSERT INTO `attrval`(`attrid`, `value`, `sort`, `status`) VALUES ('".$row['attrid']."', '".$row['value']."',0,'v')";
			if(mysqli_query($conn, $q)){
				$lastid = mysqli_insert_id($conn);
				$q = "UPDATE `attrval_external` SET `attrvalid` = '".$lastid."' WHERE `attrval_external`.`id` = ".$_POST['id'];
				if(mysqli_query($conn, $q)){
					echo json_encode(array("status"=>"success", "message"=>"Uspešno dodato!"));
				}else{
					echo json_encode(array("status"=>"fail", "message"=>"Greška prilikom ažuriranja učitane vrednosti atributa!"));
				}
			}else{
				echo json_encode(array("status"=>"fail", "message"=>"Greška prilikom dodavanja lokalne vrednosti atributa!"));	
			}
		}else{
			echo json_encode(array("status"=>"fail", "message"=>"Vrednost atributa već postoji!"));	
		}		
	}
	
	
?>