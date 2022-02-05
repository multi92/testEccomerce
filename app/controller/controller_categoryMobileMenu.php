<?php //DEVELOPER MODE
$controller_version["categoryMobileMenu"] = array('controller', '1.0.0.0.1', 'MUST BE DEFINED "show_products_all_category" and "product_per_page" PARAMETER in theme.configuration file','');
?>

<?php
	require_once("app/class/Category.php");

	/*	root categories	*/
	$shoptype=$_SESSION['shoptype'];

	$typevisible='';

	switch ($shoptype) {
    case "b2c":
        $typevisible = ' AND b2cvisible=1 ';
        break;
    case "b2b":
        $typevisible = ' AND b2bvisible=1 ';
        break;
	}

	$db = Database::getInstance();
    $mysqli = $db->getConnection();
    $mysqli->set_charset("utf8");	
	$catMobileMenu = array();
	$q = "SELECT c.*,ctr.name as name_tr FROM category as c
	      LEFT JOIN category_tr as ctr ON c.id = ctr.categoryid
		  WHERE c.parentid = 0 AND (ctr.langid = ". $_SESSION['langid']. " OR ctr.langid is null) ".$typevisible."
		  ORDER BY c.sort ASC";
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$name = $row['name'];
			if($row['name_tr'] != '' || $row['name_tr'] != NULL){
				$name = $row['name_tr'];
			}
			//array_push($catcont,array('catdata'=> Category::getCategoryData($row['id']),'catchilds'=>ShopHelper::getCategoryChild($row['id'])));
			array_push($catMobileMenu,array('catid'=> $row['id'],'catname'=> $name,'catpathname'=>$row['name'],'catchilds'=>ShopHelper::getCategoryChildArray($row['id'])));
		}
	}

	include($system_conf["theme_path"][1]."views/includes/menu/categoryMobileMenu.php");
?>