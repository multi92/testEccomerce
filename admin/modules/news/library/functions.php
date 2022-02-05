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
			case "getNewsCategory" : get_News_Category(); break;
			case "updatecategory" : update_category(); break;
			
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `news` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `news_tr` WHERE newsid = ".$_POST['id'];
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
		$data['adddate'] = date("d.m.Y", strtotime($row['adddate']));
		$data['title'] = $row['title'];
		$data['body'] = $row['body'];
		$data['shortnews'] = $row['shortnews'];
		$data['searchwords'] = $row['searchwords'];
		$data['galleryid'] = $row['galleryid'];
		
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
		
		/* get category	*/
		
		$data['categoryid'] = array();
		
		$query = "SELECT * FROM newscategorynews WHERE newsid = ".$_POST['id'];
		//var_dump($query);
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result)){
				array_push($data['categoryid'], $row['newscategoryid']);	
			}			
		}
		else
		{
			$data['categoryid'][0] = 0;
		}
		//var_dump($data['categoryid']);

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
		
		$query = "INSERT INTO `news`(`id`, `title`, `body`, `shortnews`, `thumb`, `searchwords`, `adddate`, `changedate`, `sort`, `status`, `ownerid`, `galleryid`, `ts`) VALUES ('".$_POST['newsid']."', '".mysqli_real_escape_string($conn, $defaulttitle)."', '".mysqli_real_escape_string($conn, $defaultbody)."', '".mysqli_real_escape_string($conn, $defaultshortnews)."', '".mysqli_real_escape_string($conn, $_POST['thumb'])."', '".mysqli_real_escape_string($conn, $defaultsearchwords)."', NOW(), NOW(), 1, 'h', '".mysqli_real_escape_string($conn, $_SESSION['id'])."', '".mysqli_real_escape_string($conn, $_POST['galid'])."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `title` = '".mysqli_real_escape_string($conn, $defaulttitle)."' , 
					`body` = '".mysqli_real_escape_string($conn, $defaultbody)."' , 
					`shortnews` = '".mysqli_real_escape_string($conn, $defaultshortnews)."' , 
					`thumb` = '".mysqli_real_escape_string($conn, $_POST['thumb'])."' , 
					`adddate` = '".mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['adddate'])))."' , 
					`galleryid` = '".mysqli_real_escape_string($conn, $_POST['galid'])."' , 
					`searchwords` = '".mysqli_real_escape_string($conn, $defaultsearchwords)."' ";
							
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' || $lastid == 0) $lastid = $_POST['newsid'];
		
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
		$defaultnewsid=0;
		if($_POST['newsid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
			$defaultnewsid=$lastid;
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['newsid'], $_SESSION['id'], "change");
			$defaultnewsid=$_POST['newsid'];			
		}
		$err = 0;
		if($_POST['catid'] == 0){
			$q = "DELETE FROM newscategorynews WHERE `newsid` = ".$defaultnewsid." AND `newscategoryid` = ".$_POST['prevcatid']."";	
			//var_dump ($q);
			if(!mysqli_query($conn, $q)){
				$err = 1;	
			}
		}
		else{
			$q = "DELETE FROM newscategorynews WHERE `newsid` = ".$defaultnewsid." AND `newscategoryid` = ".$_POST['prevcatid']."";	
			//var_dump ($q);
			mysqli_query($conn, $q);
			$query = "INSERT INTO `newscategorynews`(`newsid`, `newscategoryid`, `sort`, `status`, `ts`) VALUES (".$defaultnewsid.",".$_POST['catid'].", 0, 'v', CURRENT_TIMESTAMP) 
			ON DUPLICATE KEY UPDATE newsid=".$defaultnewsid." , newscategoryid = ".$_POST['catid'];
			//var_dump ($query);
			if(!mysqli_query($conn, $query)){
				$err = 1;	
			}
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
	
	function get_News_Category()
	{
		global $conn, $lang;
		$err = 0;
		$data = array();
		
		$query = "SELECT * FROM newscategorynews WHERE newsid =".$_POST['id'];
		$re = mysqli_query($conn,$query);
		while($row = mysqli_fetch_assoc($re))
		{
			array_push($data, array($row['id'],$row['categoryid']));
		}
			
		echo json_encode(array($err, $data));		
	}
	
	function update_category()
	{
		global $conn, $lang;
		$err = 0;
		if($_POST['catid'] == 0){
			$q = "DELETE FROM newscategorynews WHERE `newsid` = ".$_POST['newsid']." AND `newscategoryid` = ".$_POST['prevcatid']."";	
			var_dump ($q);
			if(!mysqli_query($conn, $q)){
				$err = 1;	
			}
		}
		else{
			$q = "DELETE FROM newscategorynews WHERE `newsid` = ".$_POST['newsid']." AND `newscategoryid` = ".$_POST['prevcatid']."";	
			var_dump ($q);
			mysqli_query($conn, $q);
			$query = "INSERT INTO `newscategorynews`(`newsid`, `newscategoryid`, `sort`, `status`, `ts`) VALUES (".$_POST['newsid'].",".$_POST['catid'].", 0, 'v', CURRENT_TIMESTAMP) 
			ON DUPLICATE KEY UPDATE newsid=".$_POST['newsid']." , newscategoryid = ".$_POST['catid'];
			var_dump ($query);
			if(!mysqli_query($conn, $query)){
				$err = 1;	
			}
		}
		
		echo json_encode(array($err));		
	}
	
?>