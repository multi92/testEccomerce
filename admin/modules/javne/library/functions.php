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
			case "deletejavneitem" : delete_javne_item(); break;
			case "addjavneitem" : add_javne_item(); break;
			case "changejavneitemstatus" : change_javne_item_status(); break;
			case "getlanguageslist" : getLanguagesList(); break;
			case "saveaddchange" : save_add_change(); break;
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `javne` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `javne_tr` WHERE javneid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `javne` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
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
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		$data['langheader'] = array();
		
		$q = "SELECT id, DATE_FORMAT(expiredate, '%Y-%m-%d' ) as expiredate FROM javne WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];
		if($row['expiredate'] != NULL) $data['expiredate'] = $row['expiredate'];
		
		$q = "SELECT *, (SELECT vrsta FROM javne_tr WHERE javneid = ".$_POST['id']." AND langid = l.id ) as vrstatr,
						(SELECT predmet FROM javne_tr WHERE javneid = ".$_POST['id']." AND langid = l.id ) as predmettr,
						(SELECT number FROM javne_tr WHERE javneid = ".$_POST['id']." AND langid = l.id ) as numbertr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				$tmpitemcont = array();
				
				$q = "SELECT *, DATE_FORMAT(ji.adddate, '%m-%d-%Y %H:%i:%S' ) as adddateformat, (SELECT value FROM javneitem_tr WHERE javneitemid = ji.id AND langid = ".$row['id']." ) as valuetr FROM `javneitem` ji WHERE javneid = ".$_POST['id']." HAVING valuetr IS NOT NULL ORDER BY position ASC, active DESC";
				
				$resi = mysqli_query($conn, $q);				
				if ($resi && mysqli_num_rows($resi) > 0) {
					while ($rowi = mysqli_fetch_assoc($resi)) {
						
						$value = $rowi['valuetr'];
						
						if($row['default'] == 'y' && $rowi['valuetr'] == NULL) $value = $rowi['value'];
						
						if($value != NULL){
							array_push($tmpitemcont, array(
								'id'=>$rowi['id'],
								'adddate'=>$rowi['adddateformat'],
								'active'=>$rowi['active'],
								'position'=>$rowi['position'],
								'docname'=>($rowi['valuetr'] != NULL)? basename(rawurldecode($rowi['valuetr'])): basename(rawurldecode($rowi['value'])),							
								'value'=>$value
							));
						}
					}	
				}
				
				array_push($data['langheader'], array(
					'langid'=>$row['id'], 
					'langname'=>$row['name'],
					'default'=>$row['default'],
					'number'=>($row['numbertr'] != NULL)? $row['numbertr']:'',
					'predmet'=>($row['predmettr'] != NULL)? $row['predmettr']:'',
					'vrsta'=>($row['vrstatr'] != NULL)? $row['vrstatr']:'',
					'data'=>$tmpitemcont
				));
				
            }
        }
		
        echo json_encode($data);
	}
	
	function delete_javne_item(){
		global $conn;
		
		$i = 0;
		
		$q = "DELETE FROM javneitem WHERE id = ".$_POST['id'];
		mysqli_query($conn, $q);
		
		$q = "DELETE FROM javneitem_tr WHERE javneitemid = ".$_POST['id']." AND langid = ".$_POST['langid'];
		
		if(mysqli_query($conn, $q)) $i++;
	
		echo $i;
	}
	
	function add_javne_item(){
		global $conn;
		
		$q = "INSERT INTO `javneitem`(`id`, `javneid`, `value`, `adddate`, `position`, `active`, `ts`) VALUES ('', ".$_POST['javneid'].", '".$_POST['path']."', NOW(), ".$_POST['position'].", 1, CURRENT_TIMESTAMP)";	
		$res = mysqli_query($conn, $q);
		
		$lastid = mysqli_insert_id($conn);
		
		$q = "INSERT INTO `javneitem_tr`(`javneitemid`, `langid`, `value`, `ts`) VALUES (".$lastid.", ".$_POST['langid'].", '".$_POST['path']."', CURRENT_TIMESTAMP)";	
		mysqli_query($conn, $q);
	}
	
	function change_javne_item_status(){
		global $conn;
		
		$q = "UPDATE javneitem SET active = ".$_POST['value']." WHERE id = ".$_POST['id'];
		mysqli_query($conn, $q);
	}
	
	function save_add_change(){
		global $conn;
		
		$defaultnumber = '';
		$defaultvrsta = '';
		$defaultpredmet = '';
		
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultnumber = $v['number'];
				$defaultvrsta = $v['vrsta'];
				$defaultpredmet = $v['predmet'];
			}	
		}
		
		
		$query = "INSERT INTO `javne`(`id`, `number`, `predmet`, `vrsta`, `adddate`, `expiredate`, `owner`, `status`, `ts`) VALUES ('".$_POST['javneid']."', '".mysqli_real_escape_string($conn, $defaultnumber)."', '".mysqli_real_escape_string($conn, $defaultpredmet)."', '".mysqli_real_escape_string($conn, $defaultvrsta)."', NOW(), '".$_POST['expiredate']." 00:00:00', ".$_SESSION['id'].", 'h', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
					`number` = '".mysqli_real_escape_string($conn, $defaultnumber)."', 
					`predmet` = '".mysqli_real_escape_string($conn, $defaultpredmet)."', 
					`vrsta` = '".mysqli_real_escape_string($conn, $defaultvrsta)."', 
					`expiredate` = '".$_POST['expiredate']." 00:00:00'
					";					
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($_POST['javneid'] != '') $lastid = $_POST['javneid'];
		
		foreach($_POST['values'] as $k=>$v){
			
			$query = "INSERT INTO `javne_tr`(`javneid`, `langid`, `number`, `predmet`, `vrsta`, `ts`) VALUES (".$lastid.",
					".$v['langid'].", 
					'".mysqli_real_escape_string($conn, $v['number'])."',
					'".mysqli_real_escape_string($conn, $v['predmet'])."',
					'".mysqli_real_escape_string($conn, $v['vrsta'])."',
					CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `number` = '".mysqli_real_escape_string($conn, $v['number'])."', 
					`predmet` = '".mysqli_real_escape_string($conn, $v['predmet'])."', 
					`vrsta` = '".mysqli_real_escape_string($conn, $v['vrsta'])."'";

			mysqli_query($conn, $query);	
		}	
		userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		
		echo $lastid;
		
	}
?>