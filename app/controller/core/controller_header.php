<?php //DEVELOPER MODE
$controller_version["header"] = array('controller', '1.0.0.0.1', 'SYSTEM THEME CONTROLLER','app/controller/core/controller_header.php','');
?>
<?php
	function getChildElements($parent){

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");		
		$menudata = array();
		$q = "SELECT m.*, (SELECT value FROM menu_tr WHERE menuid = m.id AND langid = ".$_SESSION['langid'].") as valuetr FROM menu m WHERE parentid = ".$parent." AND status = 'v' ORDER BY sort ASC";	
		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				
				if($row['link'] == "") $link = "#";
				else{
					if($row['linktype'] == "i") $link = BASE_URL.$row['link'];
					elseif($row['linktype'] == "e") $link = "http://".$row['link'];
					elseif($row['linktype'] == "f") $link = "http://".$_SERVER['SERVER_NAME'].'/'.$row['link'];	
				}
				array_push($menudata, array('id'=>$row['id'], 'value'=>($row['valuetr'] > '')? $row['valuetr']:$row['value'], 'link'=>$link, 'linktype'=>$row['linktype'], 'parentid'=>$row['parentid'], 'baselink'=>$row['link'], 'image'=>$row['image'], 'menutype'=>$row['menutype'], 'childs'=>getChildElements($row['id']) ));	
			}
			return $menudata;
		}
		else return array();
	}
	
	$headermenudata = getChildElements(1);
	include($system_conf["theme_path"][1]."views/includes/header.php");

?>