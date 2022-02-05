<?php
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "addgallery" : add_gallery(); break;	
			case "getgalleryitems" : get_gallery_items(); break;	
			case "delete" : delete(); break;	
			case "changestatus" : change_status(); break;
			case "deletegalleryitem" : delete_gallery_item(); break;
			case "addgalleryitem" : add_gallery_item(); break;
			
			case "getgalleryitemdata" : get_gallery_item_data(); break;	
			case "savegalleryitemdetail" : save_gallery_item_detail(); break;
			case "changegallerydesc" : changegallerydesc(); break;
			case "addnewgallery" : add_newgallery(); break;
			
			case "saveaddchange" : save_add_change(); break;
			
			case "updateimagesort" : update_image_sort(); break;
			case "updategallerysort" : update_gallery_sort(); break;
			
		}

	}
	function add_newgallery(){
		global $conn;
		$query = "INSERT INTO `gallery`(`id`, `name`, `img`, `description`, `adddate`, `position`, `delete`, `status`, `sort`, `ts`) VALUES ('', '".mysqli_real_escape_string($conn, $_POST['name'])."', '', '', NOW(), '".mysqli_real_escape_string($conn, $_POST['position'])."', '1', 'v', 0, CURRENT_TIMESTAMP)";
		if(mysqli_query($conn, $query))
		{
			$lastid = mysqli_insert_id($conn);
			
			$q = "INSERT INTO `gallery_tr`(`galleryid`, `langid`, `name`, `description`, `ts`) VALUES (".$lastid.", (SELECT id FROM languages WHERE `default` = 'y'), '".mysqli_real_escape_string($conn, $_POST['name'])."', '', CURRENT_TIMESTAMP)";
			mysqli_query($conn, $q);
			echo 1;
		}
		else{
			echo $query;
		}
	}

	function changegallerydesc(){
		global $conn;
		$query="update gallery set name='".$_POST['gname']."', description='".$_POST['gdesc']."', sort='".$_POST['gsort']."' where id=".$_POST['id'];
		$result=mysqli_query($conn, $query);
		if($result){
			echo '1';
		}else{
			echo '0';
		}
		die();
	}

	function add_gallery(){
		global $conn, $lang, $default_lang;
		$query = 'INSERT INTO `gallery`(`id`, `name`, `description`, `adddate`, `position`, `type`, `status`, `sort`, `galleryts`) VALUES ("", "'.mysqli_real_escape_string($conn,$_POST['name'.$default_lang]).'","",NOW(),"'.mysqli_real_escape_string($conn,$_POST['position']).'", "", "v", "0", CURRENT_TIMESTAMP)';
		mysqli_query($conn, $query);
		$lastid = mysqli_insert_id($conn);
		foreach($lang as $data)
		{
			$query = 'INSERT INTO `gallery_tr`(`galleryid`, `lang_id`, `name`, `description`) VALUES ('.$lastid.', (SELECT id FROM languages WHERE short_name = "'.$data.'") ,"'.mysqli_real_escape_string($conn,$_POST['name'.$data]).'", "'.mysqli_real_escape_string($conn,$_POST['desc'.$data]).'")';
			mysqli_query($conn, $query);
		}
		userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");

	}
	function get_gallery_items(){
		global $conn, $lang;
		
		if(isset($_POST['id']) && $_POST['id'] != "")
		{
			$out = array();
			
			$query = "SELECT * FROM galleryitem WHERE galleryid = ".$_POST['id'];
			$queryG = "SELECT id,`name`,`description`,`sort` FROM gallery WHERE id = ".$_POST['id'];
			$reG = mysqli_query($conn, $queryG);
			if(($rowDATA = mysqli_fetch_assoc($reG)) != FALSE)
			{
				$rowDATA['type']='data';
				$out[]=$rowDATA;
			}
			$re = mysqli_query($conn, $query);
			while(($row = mysqli_fetch_assoc($re)) != FALSE)
			{
				array_push($out, $row);	
			}
			echo json_encode($out);
		}
	}

	function delete(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM gallery WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
			$query = "DELETE FROM gallery_tr WHERE galleryid = ".$_POST['id'];
			mysqli_query($conn, $query);
	
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}

	function change_status(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "UPDATE `gallery` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];
				
				mysqli_query($conn, $query);	
			}
			$t = userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
			
		}
	}
	
	function delete_gallery_item(){
		global $conn;
		if(isset($_POST['id']) && $_POST['id'] != "")
		{
			$query = "DELETE FROM galleryitem WHERE id = ".$_POST['id'];
			if(mysqli_query($conn, $query))
			{
				$query = "DELETE FROM galleryitem_tr WHERE galleryitemid = ".$_POST['id'];
				mysqli_query($conn, $query);
				echo "1";
			}
			// userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change");
		}
	}
	function add_gallery_item(){
		global $conn;
		$lastid = "";
		foreach($_POST['values'] as $key=>$val){
			if($val['defaultlang'] == 'y'){
				$query = "INSERT INTO `galleryitem`(`id`, `item`, `galleryid`, `type`, `text`, `title`, `link`, `sort`, `status`, `ts`)
	                                VALUES (
	                                '',
	                                 '".mysqli_real_escape_string($conn, trim($_POST['link']))."',
	                                 '".$_POST['id']."',
	                                 '".mysqli_real_escape_string($conn, $_POST['type'])."',
	                                 '".mysqli_real_escape_string($conn, $val['desc'])."',
									 '".mysqli_real_escape_string($conn, $val['title'])."',
	                                 '".mysqli_real_escape_string($conn, $_POST['jumplink'])."',
	                                 '0',
									 'v',
	                                 CURRENT_TIMESTAMP)";
				mysqli_query($conn, $query);	
				$lastid = mysqli_insert_id($conn);
		
			}
		}
		
		foreach($_POST['values'] as $key=>$val){
			
			$q = "INSERT INTO `galleryitem_tr`(`galleryitemid`, `langid`, `text`, `title`, `ts`) VALUES (
					'".mysqli_real_escape_string($conn, $lastid)."',
					'".mysqli_real_escape_string($conn, $val['langid'])."',
					'".mysqli_real_escape_string($conn, $val['desc'])."',
					'".mysqli_real_escape_string($conn, $val['title'])."',
					CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE text = '".mysqli_real_escape_string($conn, $val['desc'])."', title = '".mysqli_real_escape_string($conn, $val['title'])."'";
			mysqli_query($conn, $q);	
			
			echo $q;
		}
		
		echo $lastid;
	}
	
	function get_gallery_item_data(){
		/*global $conn, $lang, $default_lang;
		$out = array();
		foreach($lang as $data)
		{
			$query = "SELECT gi.id, gi.item, gi.galleryid, gi.link, gi.sort, gi.title, gi.text, gitr.text as texttr, gitr.title as titletr  FROM galleryitem gi 
					LEFT JOIN galleryitem_tr gitr ON gi.id = gitr.galleryitemid
					LEFT JOIN languages la ON gitr.langid = la.id
					WHERE (la.shortname = '".$data."' OR la.shortname IS NULL) AND gi.id = ".$_POST['id'];
			$re = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($re);
		
			$out['id'] = $row['id'];
			$out['item'] = $row['item'];
			$out['galleryid'] = $row['galleryid'];
			$out['link'] = $row['link'];
			$out['sort'] = $row['sort'];
			$out[$data]['title'] = $row['titletr'];
			$out[$data]['desc'] = $row['texttr'];
			if($data == $default_lang){
				$out[$data]['title'] = ($row['titletr'] > '')? $row['titletr']:$row['title'];
				$out[$data]['desc'] = ($row['texttr'] > '')? $row['texttr']:$row['text'];
			}
		}
		echo json_encode($out);
		*/
		global $conn, $lang;
		$err = 0;
		$data = array();
		$data['lang'] = array();
		
		$q = "SELECT * FROM languages l ORDER BY `default` ASC";
		$resl = mysqli_query($conn, $q);
		while($rowl = mysqli_fetch_assoc($resl)){
			$q = "SELECT gi.*, (SELECT title FROM galleryitem_tr WHERE galleryitemid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as titletr,
								(SELECT text FROM galleryitem_tr WHERE galleryitemid = ".$_POST['id']."  AND langid = ".$rowl['id'].") as texttr FROM galleryitem gi
						WHERE gi.id = ".$_POST['id']."";
			$res = mysqli_query($conn, $q);
			while($row = mysqli_fetch_assoc($res))
			{
				$data['link'] = $row['link'];
				$data['show_info'] = $row['show_info'];
				$data['info_position'] =$row['info_position'];
				$data['info_img'] =$row['info_img'];
				array_push($data['lang'],array('langid'=>$rowl['id'],
												'langname'=>$rowl['name'],
												'default'=>$rowl['default'],
												'id'=>$row['id'],
												'title'=>($row['titletr'] == NULL && $rowl['default'] == 'y')? $row['title']:$row['titletr'],
												'text'=>($row['texttr'] == NULL && $rowl['default'] == 'y')? $row['text']:$row['texttr']));
			}
		}
					
		echo json_encode($data);	
	}
	
	function save_gallery_item_detail(){
		global $conn;

		foreach($_POST['lang'] as $k=>$v){
			if($v['default'] == 'y'){
				$q = "UPDATE `galleryitem` SET `text`='".mysqli_real_escape_string($conn, $v['desc'])."',
											   `title`='".mysqli_real_escape_string($conn, $v['title'])."',
											   `link`='".mysqli_real_escape_string($conn, $_POST['jumplink'])."',
											   `show_info`='".mysqli_real_escape_string($conn, $_POST['show_info'])."',
											   `info_img`='".mysqli_real_escape_string($conn, $_POST['info_img'])."',
											   `info_position`='".mysqli_real_escape_string($conn, $_POST['info_position'])."' 

											   WHERE id = ".$_POST['itemid'];
				mysqli_query($conn, $q);
			}
			
			$q = "INSERT INTO `galleryitem_tr`(`galleryitemid`, `langid`, `text`, `title`, `ts`) VALUES (".$_POST['itemid'].", '".$v['langid']."', '".mysqli_real_escape_string($conn, $v['desc'])."', '".mysqli_real_escape_string($conn, $v['title'])."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE title = '".mysqli_real_escape_string($conn, $v['title'])."', text = '".mysqli_real_escape_string($conn, $v['desc'])."'";
			mysqli_query($conn, $q);
		}
		echo 1;
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
				
		foreach($_POST['values'] as $key=>$val){
			if($val['defaultlang'] == 'y'){
				$pos = " `position` = '".mysqli_real_escape_string($conn, $_POST['position'])."', ";
				if($_POST['position'] == 'nochange') $pos = '';
				
				$q = "UPDATE `gallery` SET `name`= '".mysqli_real_escape_string($conn, $val['title'])."', `description` = '".mysqli_real_escape_string($conn, $val['desc'])."', ".$pos." `sort` = '".mysqli_real_escape_string($conn, $_POST['sort'])."', `img` = '".mysqli_real_escape_string($conn, $_POST['img'])."' WHERE id = ".$_POST['galleryid'];
				mysqli_query($conn, $q);	
			}
			
			$q = "INSERT INTO `gallery_tr`(`galleryid`, `langid`, `name`, `description`, `ts`) VALUES (".$_POST['galleryid'].", ".$val['langid'].", '".mysqli_real_escape_string($conn, $val['title'])."', '".mysqli_real_escape_string($conn, $val['desc'])."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE name = '".mysqli_real_escape_string($conn, $val['title'])."', description = '".mysqli_real_escape_string($conn, $val['desc'])."'";
			mysqli_query($conn, $q);
		}
		echo json_encode($err);
	}
	
	function update_image_sort(){
		global $conn;
	
		$i = 0;
		foreach($_POST['items'] as $k=>$v){
			$q = "UPDATE galleryitem SET sort = ".$i." WHERE id =".$v;	
			mysqli_query($conn, $q);
			$i++;
		}
	}
	
	function update_gallery_sort(){
		global $conn;
		$q = "UPDATE gallery SET sort = ".$_POST['value']." WHERE id =".$_POST['id'];	
		mysqli_query($conn, $q);
	}


?>