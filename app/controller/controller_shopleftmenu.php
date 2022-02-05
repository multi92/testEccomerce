<?php 
	require_once("app/class/Product.php");
	require_once("app/class/Category.php");
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}

	$data = array();

	/*	left categories		*/
		
	$catdata = GlobalHelper::getAllMainCatsWithSubcat();
	
	/*	baneri levo	*/
	
	$db = Database::getInstance();
    $mysqli = $db->getConnection();
    $mysqli->set_charset("utf8");
	
	$bannersleft = array();
	$q="SELECT b.*, btr.value as valuetr FROM banner b
		LEFT JOIN banner_tr btr ON b.id = btr.bannerid
		WHERE b.position = 1 AND status = 'v' AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid is null) 
		ORDER BY sort ASC";
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc())
		array_push($bannersleft, array("id"=>$row['id'], 'name'=>$row['name'], 'value'=>(($row['valuetr'] == NULL)? $row['value']:$row['valuetr']) ));
	}

	include($system_conf["theme_path"][1]."views/shopleftmenu.php");
?>