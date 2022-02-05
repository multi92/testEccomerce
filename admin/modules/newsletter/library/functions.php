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
			$query = "DELETE FROM `newsletter` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `news` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM news WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];
		if($row['thumb'] != NULL) $data['thumb'] = $row['thumb'];
		if($row['type'] != NULL) $data['type'] = $row['type'];
		if($row['adddate'] != NULL) $data['adddate'] = $row['adddate'];
		$data['title'] = $row['title'];
		$data['body'] = $row['body'];
		$data['shortnews'] = $row['shortnews'];
		$data['searchwords'] = $row['searchwords'];
		
		$q = "SELECT *, (SELECT title FROM news_tr WHERE newsid = ".$_POST['id']." AND langid = l.id ) as titletr,
						(SELECT body FROM news_tr WHERE newsid = ".$_POST['id']." AND langid = l.id ) as bodytr,
						(SELECT searchwords FROM news_tr WHERE newsid = ".$_POST['id']." AND langid = l.id ) as searchwordstr,
						(SELECT shortnews FROM news_tr WHERE newsid = ".$_POST['id']." AND langid = l.id ) as shortnewstr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'title'=>($row['titletr'] != NULL)? $row['titletr']:'',
						'body'=>($row['bodytr'] != NULL)? $row['bodytr']:'',
						'searchwords'=>($row['searchwordstr'] != NULL)? $row['searchwordstr']:'',
						'shortnews'=>($row['shortnewstr'] != NULL)? $row['shortnewstr']:'' ));
            }
        }

        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		
		$defaulttitle = '';
		$defaultbody = '';
		$defaultsearchwords = '';
		$defaultshortnews = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaulttitle = $v['title'];
				$defaultbody = $v['body'];
				$defaultsearchwords = $v['searchwords'];
				$defaultshortnews = $v['shortnews'];
			}	
		}
		
		$query = "INSERT INTO `news`(`id`, `title`, `body`, `shortnews`, `thumb`, `searchwords`, `adddate`, `changedate`, `sort`, `status`, `ownerid`, `type`, `ts`) VALUES ('".$_POST['newsid']."', '".mysqli_real_escape_string($conn, $defaulttitle)."', '".mysqli_real_escape_string($conn, $defaultbody)."', '".mysqli_real_escape_string($conn, $defaultshortnews)."', '".mysqli_real_escape_string($conn, $_POST['thumb'])."', '".mysqli_real_escape_string($conn, $defaultsearchwords)."', NOW(), NOW(), 1, 'h', '".mysqli_real_escape_string($conn, $_SESSION['id'])."','".mysqli_real_escape_string($conn, $_POST['type'])."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `title` = '".mysqli_real_escape_string($conn, $defaulttitle)."' , 
					`body` = '".mysqli_real_escape_string($conn, $defaultbody)."' , 
					`shortnews` = '".mysqli_real_escape_string($conn, $defaultshortnews)."' , 
					`thumb` = '".mysqli_real_escape_string($conn, $_POST['thumb'])."' , 
					`type` = '".mysqli_real_escape_string($conn, $_POST['type'])."' , 
					`searchwords` = '".mysqli_real_escape_string($conn, $defaultsearchwords)."' ";
							
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == 0) $lastid = $_POST['newsid'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `news_tr`(`newsid`, `langid`, `title`, `body`, `shortnews`, `searchwords`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['title'])."', 
			'".mysqli_real_escape_string($conn, $v['body'])."', 
			'".mysqli_real_escape_string($conn, $v['shortnews'])."', 
			'".mysqli_real_escape_string($conn, $v['searchwords'])."', 
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `title` = '".mysqli_real_escape_string($conn, $v['title'])."' , 
					`body` = '".mysqli_real_escape_string($conn, $v['body'])."' , 
					`shortnews` = '".mysqli_real_escape_string($conn, $v['shortnews'])."' ,  
					`searchwords` = '".mysqli_real_escape_string($conn, $v['searchwords'])."' ";
			
			mysqli_query($conn, $query);	
		}	
		
		if($_POST['newsid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['newsid'], $_SESSION['id'], "change");	
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