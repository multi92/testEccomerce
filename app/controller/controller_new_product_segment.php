<?php 
	/* NEW PRODUCTS */
	$ed_ids = array();
	$q = "SELECT p.id FROM product p
		LEFT JOIN productextradetail ped ON p.id = ped.productid
		WHERE ped.extradetailid = 1 AND p.type IN ('r','q','vp') ";
		
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			array_push($ed_ids, $row['id']);
		}
	}
	$newproducts = Category::getCategoryProductDetail($ed_ids,1,8,'','ASC','random',false,'','',1);	
		//$prolist, $page, $itemsperpage , $search, $sort , $sortby,  $action = false, $minprice = '', $maxprice = '', $viewtype = 0
	/* NEW PRODUCTS */
	
	include($system_conf["theme_path"][1]."views/includes/segments/newProductSegment.php");
?>