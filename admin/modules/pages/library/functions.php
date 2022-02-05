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
			$query = "DELETE FROM `pages` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `pages_tr` WHERE pageid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `pages` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM pages WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$rowo = mysqli_fetch_assoc($res);
		
		if($rowo['id'] != NULL) $data['id'] = $rowo['id'];
		if($rowo['leftcol'] != NULL) $data['leftcol'] = $rowo['leftcol'];
		if($rowo['rightcol'] != NULL) $data['rightcol'] = $rowo['rightcol'];
		if($rowo['name'] != NULL) $data['name'] = $rowo['name'];
		$data['value'] = $rowo['value'];
		$data['galleryid'] = $rowo['galleryid'];
		
		$q = "SELECT *, (SELECT name FROM pages_tr WHERE pageid = ".$_POST['id']." AND langid = l.id ) as nametr,
						(SELECT value FROM pages_tr WHERE pageid = ".$_POST['id']." AND langid = l.id ) as valuetr,
						(SELECT showname FROM pages_tr WHERE pageid = ".$_POST['id']." AND langid = l.id ) as shownametr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'showname'=>($row['shownametr'] != NULL)? $row['shownametr']:'',
						'value'=>($row['valuetr'] != NULL)? $row['valuetr']:''
						 ));
            }
        }

        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		
		$defaultbody = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultbody = $v['body'];
				$defaultshowname = $v['showname'];
			}	
		}
		$leftcol = ($_POST['leftcol'])? 1 : 0;
		$rightcol = ($_POST['rightcol'])? 1 : 0;
		
		$query = "INSERT INTO `pages`(`id`, `name`, `showname`, `value`, `status`, `ownerid`, `adddate`, `changedate`, `leftcol`, `rightcol`, `galleryid`, `ts`) VALUES ('".$_POST['pageid']."', '".mysqli_real_escape_string($conn, $_POST['name'])."', '".mysqli_real_escape_string($conn, $defaultshowname)."' , '".mysqli_real_escape_string($conn, $defaultbody)."', 'h', '".mysqli_real_escape_string($conn, $_SESSION['id'])."', NOW(), NOW(), '".mysqli_real_escape_string($conn, $leftcol)."', '".mysqli_real_escape_string($conn, $rightcol)."', '".mysqli_real_escape_string($conn, $_POST['galid'])."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $_POST['name'])."' , 
					`showname` = '".mysqli_real_escape_string($conn, $defaultshowname)."' ,
					`value` = '".mysqli_real_escape_string($conn, $defaultbody)."' , 
					`leftcol` = '".mysqli_real_escape_string($conn, $leftcol)."' , 
					`rightcol` = '".mysqli_real_escape_string($conn, $rightcol)."',
					`galleryid` = '".mysqli_real_escape_string($conn, $_POST['galid'])."'";
							
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0) $lastid = $_POST['pageid'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `pages_tr`(`pageid`, `langid`, `name`, `showname`, `value`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].",
			'',
			'".mysqli_real_escape_string($conn, $v['showname'])."',   
			'".mysqli_real_escape_string($conn, $v['body'])."',   
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
					`value` = '".mysqli_real_escape_string($conn, $v['body'])."',
					`showname` = '".mysqli_real_escape_string($conn, $v['showname'])."'";
			
			mysqli_query($conn, $query);	
		}	
		
		if($_POST['pageid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['pageid'], $_SESSION['id'], "change");	
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