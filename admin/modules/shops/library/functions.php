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
			case "updateshopsort" : update_shop_sort(); break;
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `shop` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			$query = "DELETE FROM `shop_tr` WHERE shopid = ".$_POST['id'];
			mysqli_query($conn, $query);
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `shop` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        
		$q = "SELECT * FROM shop WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$data = mysqli_fetch_assoc($res);		
		$data['lang'] = array();
		
		$q = "SELECT *, (SELECT name FROM shop_tr WHERE shopid = ".$_POST['id']." AND langid = l.id ) as nametr,
						(SELECT text FROM shop_tr WHERE shopid = ".$_POST['id']." AND langid = l.id ) as texttr,
						(SELECT address FROM shop_tr WHERE shopid = ".$_POST['id']." AND langid = l.id ) as addresstr,
						(SELECT description FROM shop_tr WHERE shopid = ".$_POST['id']." AND langid = l.id ) as descriptiontr
						 FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array(
						'langid'=>$row['id'], 
						'langname'=>$row['name'],
						'default'=>$row['default'],
						'name'=>($row['nametr'] != NULL)? $row['nametr']:(($row['default'] == 'y')? $data['name']:''),
						'text'=>($row['texttr'] != NULL)? $row['texttr']:(($row['default'] == 'y')? $data['text']:''),
						'address'=>($row['addresstr'] != NULL)? $row['addresstr']:(($row['default'] == 'y')? $data['address']:''),
						'description'=>($row['descriptiontr'] != NULL)? $row['descriptiontr']:(($row['default'] == 'y')? $data['description']:'') ));
            }
        }
		
        echo json_encode($data);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		
		$defaultname = '';
		$defaultaddress = '';
		$defaulttext = '';
		$defaultdescription = '';
		foreach($_POST['values'] as $k=>$v){
			if($v['defaultlang'] == 'y'){ 
				$defaultname = $v['name'];
				$defaultaddress = $v['address'];
				$defaulttext = $v['text'];
				$defaultdescription = $v['description'];
			}	
		}
		
		$query = "INSERT INTO `shop`(`id`, `status`, `cityid`, `name`,  `address`, `thumb`, `phone`, `cellphone`, `fax`, `email`, `worktime`, `coordinates`, `type`, `text`, `description`, `warehouseid`, `gallery_id`, `ts`)  VALUES (
		'".$_POST['id']."', 
		'h',
		'".mysqli_real_escape_string($conn, $_POST['cityid'])."', 
		'".mysqli_real_escape_string($conn, $defaultname)."',
		'".mysqli_real_escape_string($conn, $defaultaddress)."', 
		'".mysqli_real_escape_string($conn, $_POST['image'])."', 
		'".mysqli_real_escape_string($conn, $_POST['phone'])."', 
		'".mysqli_real_escape_string($conn, $_POST['mobile'])."', 
		'".mysqli_real_escape_string($conn, $_POST['fax'])."', 
		'".mysqli_real_escape_string($conn, $_POST['email'])."',
		'".json_encode(array('mf'=>array('from'=>mysqli_real_escape_string($conn, $_POST['weekfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['weekto'])),
							'st'=>array('from'=>mysqli_real_escape_string($conn, $_POST['stfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['stto'])),
							'su'=>array('from'=>mysqli_real_escape_string($conn, $_POST['sufrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['suto']))))."',
		'".mysqli_real_escape_string($conn, $_POST['coordinates'])."',
		'".mysqli_real_escape_string($conn, $_POST['type'])."',
		'".mysqli_real_escape_string($conn, $defaulttext)."',
		'".mysqli_real_escape_string($conn, $defaultdescription)."',
		'".mysqli_real_escape_string($conn, $_POST['warehouseid'])."',
		'".mysqli_real_escape_string($conn, $_POST['galleryid'])."',		 
		CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
					`cityid` = '".mysqli_real_escape_string($conn, $_POST['cityid'])."' , 
					`name` = '".mysqli_real_escape_string($conn, $defaultname)."' , 
					`address` = '".mysqli_real_escape_string($conn, $defaultaddress)."' , 
					`thumb` = '".mysqli_real_escape_string($conn, $_POST['image'])."' , 
					`phone` = '".mysqli_real_escape_string($conn, $_POST['phone'])."' , 
					`cellphone` = '".mysqli_real_escape_string($conn, $_POST['mobile'])."' , 
					`fax` = '".mysqli_real_escape_string($conn, $_POST['fax'])."' , 
					`email` = '".mysqli_real_escape_string($conn, $_POST['email'])."' , 
					`worktime` = '".json_encode(array('mf'=>array('from'=>mysqli_real_escape_string($conn, $_POST['weekfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['weekto'])),
							'st'=>array('from'=>mysqli_real_escape_string($conn, $_POST['stfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['stto'])),
							'su'=>array('from'=>mysqli_real_escape_string($conn, $_POST['sufrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['suto']))))."',
 					`coordinates` = '".mysqli_real_escape_string($conn, $_POST['coordinates'])."' , 
					`type` = '".mysqli_real_escape_string($conn, $_POST['type'])."' , 
					`text` = '".mysqli_real_escape_string($conn, $defaulttext)."' , 
					`description` = '".mysqli_real_escape_string($conn, $defaultdescription)."' , 
					`warehouseid` = '".mysqli_real_escape_string($conn, $_POST['warehouseid'])."' , 
					`gallery_id` = '".mysqli_real_escape_string($conn, $_POST['galleryid'])."' ";
						
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' && $_POST['id'] != '') $lastid = $_POST['id'];
		
		foreach($_POST['values'] as $k=>$v){
			$query = "INSERT INTO `shop_tr`(`shopid`, `langid`, `name`, `address`, `text`, `description`, `ts`) VALUES (".$lastid.", 
			".$v['langid'].", 
			'".mysqli_real_escape_string($conn, $v['name'])."', 
			'".mysqli_real_escape_string($conn, $v['address'])."', 
			'".mysqli_real_escape_string($conn, $v['text'])."', 
			'".mysqli_real_escape_string($conn, $v['description'])."', 
			CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `name` = '".mysqli_real_escape_string($conn, $v['name'])."' , 
					`address` = '".mysqli_real_escape_string($conn, $v['address'])."' , 
					`text` = '".mysqli_real_escape_string($conn, $v['text'])."' ,  
					`description` = '".mysqli_real_escape_string($conn, $v['description'])."' ";
			mysqli_query($conn, $query);	
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
	
	function update_shop_sort(){
		global $conn;
		$q = "UPDATE shop SET sort = ".$_POST['value']." WHERE id =".$_POST['id'];
		echo $q;	
		mysqli_query($conn, $q);
	}
	
?>