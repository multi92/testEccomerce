<?php //DEVELOPER MODE
$controller_version["actionProductSlider"] = array('controller', '1.0.0.0.1', 'SLIDER OF PRODUCT WITH REBATE IN THEME CONFIG MUST BE DEFINE "products_on_action_product_slider" PARAMETER','app/controller/actionProductSlider.php');
?>

<?php
	/* PRODUCTS WITH REBATE */
	$act_ids = array();
	$q = "SELECT p.id FROM product p 
		WHERE p.rebate > 0 AND p.type IN ('r','q','vp')";
		
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			array_push($act_ids, $row['id']);
		}
	}

	$actionproducts = Category::getCategoryProductDetail($act_ids,1,$theme_conf["products_on_action_product_slider"][1],'','ASC','random', false ,'','',1);	
	/* PRODUCTS WITH REBATE END */
	
	include($system_conf["theme_path"][1]."views/includes/slider/actionProductSlider.php");

?>
