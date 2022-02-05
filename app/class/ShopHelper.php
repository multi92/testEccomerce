<?php

$class_version["shophelper"] = array('class', '1.0.0.0.1', 'Nema opisa');

class ShopHelper{
	
	public static function getCategoryTreeUp($catid, $cont = array()){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT * FROM category".CATEGORY_SUFIX." WHERE id = ".$catid;

		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			
			$row = $res->fetch_assoc();
			if($row['parentid'] != 0)
			{
				
				array_push($cont, array('id' => $row['id'],'partnerid' => $row['parentid'], 'name' =>$row['name']));
				$cont = ShopHelper::getCategoryTreeUp($row['parentid'], $cont);
			}else{
				array_push($cont, array('id' => $row['id'],'partnerid' => $row['parentid'], 'name' => $row['name']));
			}
		}
		return $cont;
	}
	
	public static function getNewsCategoryTreeUp($catid, $cont = array()){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT * FROM newscategory WHERE id = ".$catid;

		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			
			$row = $res->fetch_assoc();
			if($row['parentid'] != 0)
			{
				
				array_push($cont, array('id' => $row['id'],'partnerid' => $row['parentid'], 'name' =>$row['name']));
				$cont = ShopHelper::getNewsCategoryTreeUp($row['parentid'], $cont);
			}else{
				array_push($cont, array('id' => $row['id'],'partnerid' => $row['parentid'], 'name' => $row['name']));
			}
		}
		return $cont;
	}
	
	public static function getCategoryTreeIdDown($catid, $cont = array()){
		array_push($cont, $catid);
		$data = ShopHelper::getCategoryChild($catid);
		foreach($data as $k=>$v){
			$cont = ShopHelper::getCategoryTreeIdDown($v['id'], $cont);	
		}
		return $cont;
	}
	
	public static function getNewsCategoryTreeIdDown($catid, $cont = array()){
		array_push($cont, $catid);
		$data = ShopHelper::getNewsCategoryChild($catid);
		foreach($data as $k=>$v){
			$cont = ShopHelper::getNewsCategoryTreeIdDown($v['id'], $cont);	
		}
		return $cont;
	}
	
	public static function getCategoryChild($catid){
		// retrun first level childs
		global $system_conf, $user_conf, $theme_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$cattype = " AND b2bvisible = 1 ";	
		if($_SESSION['shoptype'] == "b2c"){
			$cattype = " AND b2cvisible = 1 ";	
		}
		
		
		$q = "SELECT c.id, c.parentid, c.name, c.description, ctr.name as nametr, ctr.description as descriptiontr , cf.content as catimage, ccf.content as caticon FROM category".CATEGORY_SUFIX." c
			LEFT JOIN category_tr ctr ON c.id = ctr.categoryid
			LEFT JOIN category_file as cf ON c.id = cf.categoryid AND cf.type = 'img'
			LEFT JOIN category_file as ccf ON c.id = ccf.categoryid AND ccf.type='icon'
			WHERE parentid = ".$catid." AND (ctr.langid =". $_SESSION['langid']. " OR ctr.langid is null)  ".$cattype." ORDER BY c.sort ASC";
		//echo $q;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				$description = $row['description'];
				if($row['descriptiontr'] != NULL){
					$description = $row['descriptiontr'];	
				}

				if($row['catimage'] == NULL){
					$row['catimage'] = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
				}

				if($row['caticon'] == NULL){
					$row['caticon'] = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
				}

				$query = "SELECT id FROM category".CATEGORY_SUFIX." WHERE parentid = ".$row['id'];
				$cres = $mysqli->query($query);
				
				$catobject = Category::getCategoryData($row['id']);
				array_push($data, array('id' => $row['id'], 'urlname'=>$row['name'], 'name' => $name,'image' => $row['catimage'] ,'icon' => $row['caticon'] ,'childs' => $cres->num_rows, 'catobj'=>$catobject));
			}
		}
		
		return $data;
	}
	
	public static function getCategoryChildForBrendIds($catids=array() ){
		// retrun first level childs
		global $system_conf, $user_conf, $theme_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$cattype = " AND b2bvisible = 1 ";	
		if($_SESSION['shoptype'] == "b2c"){
			$cattype = " AND b2cvisible = 1 ";	
		}
		//echo implode(',', $catids[1]);
		
		$q = "SELECT c.id, c.parentid, c.name, c.description, ctr.name as nametr, ctr.description as descriptiontr , cf.content as catimage FROM category c
			LEFT JOIN category_tr ctr ON c.id = ctr.categoryid
			LEFT JOIN category_file as cf ON c.id = cf.categoryid
			WHERE c.id IN (".implode(',', $catids).")  AND (ctr.langid =". $_SESSION['langid']. " OR ctr.langid is null) AND (cf.type = 'img' OR cf.type is NULL) ".$cattype."  ORDER BY c.sort ASC";

		//echo $q;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				$description = $row['description'];
				if($row['descriptiontr'] != NULL){
					$description = $row['descriptiontr'];	
				}

				if($row['catimage'] == NULL){
					$row['catimage'] = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
				}

				$query = "SELECT id FROM category WHERE parentid = ".$row['id'];
				$cres = $mysqli->query($query);
				
				$catobject = Category::getCategoryData($row['id']);
				array_push($data, array('id' => $row['id'], 'urlname'=>$row['name'], 'name' => $name,'image' => $row['catimage'] ,'childs' => $cres->num_rows, 'catobj'=>$catobject));
			}
		}
		
		return $data;
	}

	public static function getNewsCategoryChild($catid){
		// retrun first level childs
		global $user_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT c.id, c.parentid, c.name, c.description, ctr.name as nametr, ctr.description as descriptiontr 
		    FROM newscategory c
			LEFT JOIN newscategory_tr ctr ON c.id = ctr.newscategoryid
			WHERE parentid = ".$catid." AND (ctr.langid =". $_SESSION['langid']. " OR ctr.langid is null)  ORDER BY c.sort ASC";
		//echo $q;	
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				$description = $row['description'];
				if($row['descriptiontr'] != NULL){
					$description = $row['descriptiontr'];	
				}
				$catobject = NewsCategory::getNewsCategoryData($row['id']);
				array_push($data, array('id' => $row['id'], 'urlname'=>$row['name'], 'name' => $name, 'catobj'=>$catobject));
			}
		}
		
		return $data;
	}
	
	public static function getCategoryChildArray($catid){
		// retrun first level childs
		global $user_conf, $system_conf, $theme_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$cattype = " AND b2bvisible = 1 ";	
		if($_SESSION['shoptype'] == "b2c"){
			$cattype = " AND b2cvisible = 1 ";	
		}
		
		
		$q = "SELECT c.id, c.parentid, c.name, c.description, ctr.name as nametr, ctr.description as descriptiontr , cf.content as img FROM category".CATEGORY_SUFIX." c
			LEFT JOIN category_tr ctr ON c.id = ctr.categoryid
			LEFT JOIN category_file as cf ON c.id = cf.categoryid
			WHERE parentid = ".$catid." AND (ctr.langid =". $_SESSION['langid']. " OR ctr.langid is null) AND (cf.type = 'img' OR cf.type is NULL) ".$cattype." ORDER BY c.sort ASC";
			 
		//echo $q;	
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				$description = $row['description'];
				if($row['descriptiontr'] != NULL){
					$description = $row['descriptiontr'];	
				}
				
				if($row['img'] == NULL){
					$row['img'] = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
				}
				
				
				
				array_push($data, array('id' => $row['id'], 'urlname'=>$row['name'], 'name' => $name, 'description'=>$description,'catimage'=>$row['img'],'catchilds'=>self::getCategoryChildArray($row['id'])));
			}
		}
		
		return $data;
	}
	
	public static function getNewsCategoryChildArray($catid){
		// retrun first level childs
		global $user_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		
		$q = "SELECT c.id, c.parentid, c.name, c.description, ctr.name as nametr, ctr.description as descriptiontr FROM newscategory c
			LEFT JOIN newscategory_tr ctr ON c.id = ctr.newscategoryid
			WHERE parentid = ".$catid." AND (ctr.langid =". $_SESSION['langid']. " OR ctr.langid is null)  ORDER BY c.sort ASC";
		//echo $q;	
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				$description = $row['description'];
				if($row['descriptiontr'] != NULL){
					$description = $row['descriptiontr'];	
				}
				
				array_push($data, array('id' => $row['id'], 'urlname'=>$row['name'], 'name' => $name, 'description'=>$description));
			}
		}
		
		return $data;
	}
	
	public static function getCategoryIdFromCommand($data, $cont = array()){
		/**
		*	@ $data = array ($command)
		*/
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		$parentid = 0;	
		$error = false;	
					
		foreach($data as $k=>$v){
			$res = ShopHelper::getCategoryIdFromName($v, $parentid);
			if($res){
				$parentid = $res;
				array_push($cont, $res);		
			}else{
				array_push($cont, false);
				break;			
			}
		}
		return $cont;
	}

	public static function getNewsCategoryIdFromCommand($data, $cont = array()){
		/**
		*	@ $data = array ($command)
		*/
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		$parentid = 0;	
		$error = false;	
					
		foreach($data as $k=>$v){
			$res = ShopHelper::getNewsCategoryIdFromName($v, $parentid);
			if($res){
				$parentid = $res;
				array_push($cont, $res);		
			}else{
				array_push($cont, false);
				break;			
			}
		}
		return $cont;
	}
	
	/**
	 * help for getCategoryIdFromCommand()
     */
	public static function getCategoryIdFromName($name, $parentid){

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT * FROM category".CATEGORY_SUFIX." WHERE name LIKE '".$mysqli->real_escape_string(rawurldecode($name))."' AND parentid=".$parentid;

		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			return $row['id'];
		}else{
			return false;	
		}
	}
	
	public static function getNewsCategoryIdFromName($name, $parentid){

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT * FROM newscategory WHERE name LIKE '".$mysqli->real_escape_string(rawurldecode($name))."' AND parentid=".$parentid;
        
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			return $row['id'];
		}else{
			return false;	
		}
	}

	/**
	 * nazalzi sve putanje do proizvoda kroz category tree
	 * nalazi sve kategorije gde se nalazi zadati proizvod
	 */
	public static function getCategoryListFromProduct($proid){

		global $system_conf;
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		$resdata = false;
		$q = "SELECT categoryid FROM productcategory WHERE productid = ".$proid;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			$resdata = $res;
		}else{
			$q = "SELECT ce.categoryid FROM productcategory_external pce 
				LEFT JOIN category_external ce ON pce.categoryid = ce.id
				WHERE pce.productid = ".$proid;
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				$resdata = $res;
			}
		}
		
		/*if($system_conf["category_type"][1] == '1'){
			// relacije aktivne
			$q = "SELECT * FROM productcategory pc 
			LEFT JOIN category_external ce ON pc.categoryid = ce.id
			WHERE productid = ".$proid;	
		}else{
			$q = "SELECT * FROM productcategory WHERE productid = ".$proid;	
		}
		*/
		
		
		//echo $q;
		//$res = $mysqli->query($q);
		if($resdata)
		{
			while($row = $resdata->fetch_assoc()){
				
				$data = ShopHelper::getCategoryTreeUp($row['categoryid']);
				$data = array_reverse($data);
				$tempstr = "";
				foreach($data as $key=>$val){
					$tempstr .= rawurlencode($val['name']).DIRECTORY_SEPARATOR;
				}
				array_push($cont, array('catdata' => $data, 'url' => $tempstr));
			}
		}
		
		return $cont;
	}
	
	/**
	 *  breadcrumbs za kategorije
	 */
	public static function getCategoryListFromCategory($catid){

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
					
		$data = ShopHelper::getCategoryTreeUp($catid);
		$data = array_reverse($data);
		$tempstr = "";
		foreach($data as $key=>$val){
			$tempstr .= $val['name'].DIRECTORY_SEPARATOR;
		}
		array_push($cont, array('catdata' => $data, 'url' => $tempstr));
		
		
		return $cont;
	}
	
	public static function getNewsCategoryListFromNewsCategory($catid){

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
					
		$data = ShopHelper::getNewsCategoryTreeUp($catid);
		$data = array_reverse($data);
		$tempstr = "";
		foreach($data as $key=>$val){
			$tempstr .= $val['name'].DIRECTORY_SEPARATOR;
		}
		array_push($cont, array('catdata' => $data, 'url' => $tempstr));
		
		
		return $cont;
	}

	/**
	 *
	 * 	vraca podatke o artiklima koji su trnutno u korpi
	 * 
	 */
	public static function getShopcartSmallData(){
		$cont = array();
		
		$totalnopdv = 0;
		$total = 0;
		$pdv = 0;
		//include_once("");
		
		
		if(isset($_SESSION['shopcart']))
		{
			
			foreach($_SESSION['shopcart'] as $k=>$v){
				$maxrebate=0;
				$mrebate=Product::getMaxRebate($v["id"]);
				if($mrebate=NULL){
					$maxrebate=0;
					
				}else{
					$maxrebate=$mrebate;
				
				}
				$quantityrebate=0;
				$full_rebate=0;
				$quantityrebatedata=Product::getProductQuantityRebate($v["id"]);
				if(isset($quantityrebatedata) && count($quantityrebatedata)>0){
					foreach($quantityrebatedata as $qval){
						if($v['qty']>=$qval['quantity']){
							$quantityrebate=$qval['rebate'];
						}
						
					}
				}
				
				$item_rebate=0;
				$item_rebate=($v['rebate']+((100-$v['rebate'])*($quantityrebate/100)));
				

				if($item_rebate>=$maxrebate){
					if($maxrebate>0){
						$full_rebate=$maxrebate;
					} else {
						$full_rebate=$item_rebate;
					}
				} else {
					$full_rebate=$item_rebate;
				}
				
				$tmparray = json_decode($v['attr']);
				$attrvalcont = array();
				foreach($tmparray as $key=>$val){
					$attrdata = GlobalHelper::getAttrValImage($val[1]);
					array_push($attrvalcont, array(GlobalHelper::getAttrName($val[0]), GlobalHelper::getAttrValName($val[1]), $attrdata));
				}	

				$v['aattr'] = $attrvalcont;	
				
				$totalnopdv += number_format($v['price']*(1-($full_rebate/100))*$v['qty'], 2, '.', '');
				$total += number_format($v['price']*(1+($v['tax']/100))*(1-($full_rebate/100))*$v['qty'], 2, '.', '') ;
				
				$v['itemvalue'] = number_format(($v['price']*(1+($v['tax']/100)))*(1-($full_rebate/100))*$v['qty'], 2, '.', ',');
				//$v['itemvalue'] = $quantityrebate;//$v['price']*(1+($v['tax']/100))*(1-($full_rebate/100));
				$v['shopcartposition']=$k;
				array_push($cont, $v);	
			}
			$pdv = number_format(($total-$totalnopdv), 2, '.', ',');
			return array('data'=>$cont, 'total'=>$total, 'totalnopdv'=>$totalnopdv, 'pdv'=>$pdv);
		}
		else{
			$pdv = number_format(($total-$totalnopdv), 2, '.', ',');
			return array('data'=>$cont, 'total'=>$total, 'totalnopdv'=>$totalnopdv, 'pdv'=>$pdv);
		}
	}
	
	
	public static function update_shopcart_comment(){
		if(!isset($_SESSION['order'])){
			$_SESSION['order']=array();
		}
		$_SESSION['order']['comment'] = $_POST['comment'];
	}
	
	
	public static function check_coupon($coupon){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
			
		$q = "SELECT uc.id, uc.email, c.value  FROM usercoupon uc 
		LEFT JOIN coupons c ON uc.couponsid = c.id 
		WHERE uc.status = 'n' AND uc.couponcode = '".$coupon."'";
		$re = $mysqli->query($q);	
		if($re->num_rows > 0){
			 $row = $re->fetch_assoc();
			 if(!isset($_SESSION['voucher'])) $_SESSION['voucher'] = array();
			 $_SESSION['voucher']['id'] = $row['id'];
			 $_SESSION['voucher']['code'] = $coupon;
			 $_SESSION['voucher']['value'] = $row['value'];
			 
			 return array('success', 'Validan kupon!');	
		}else{
			return array('error', 'Nevalidan kupon!');	
		}
	}	

	
		
}

?>