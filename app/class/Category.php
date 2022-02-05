<?php
$module_version["category"] = array('module', '1.0.0.0.1', 'Nema opisa');
class Category{
	public $id;
	public $parentid;
	public $name;
	public $description;
	public $image;
	public $path;
	public $maincolor;
	public $icon;
	
	public function __construct($id, $parentid, $name, $description, $image, $path, $maincolor, $icon){
		$this->id=$id;
		$this->parentid=$parentid;
		$this->name=$name;
		$this->description=$description;
		$this->image=$image;
		$this->path=$path;
		$this->maincolor=$maincolor;
		$this->icon=$icon;
	}

	/**
	 * @param $catid
	 * @return Category object ili '0' if category with this id not exist
     */
	public static function getCategoryData($catid){
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		global $user_conf, $system_conf, $theme_conf;
		$query = "SELECT c.id, c.parentid, c.name, c.description, ctr.name as name_tr, ctr.description as description_tr, cf.content as img FROM category".CATEGORY_SUFIX." as c
					LEFT JOIN category_tr as ctr ON c.id = ctr.categoryid
					LEFT JOIN category_file as cf ON c.id = cf.categoryid AND cf.`type` = 'img'
					WHERE c.id = ".$catid." AND (ctr.langid = ". $_SESSION['langid']. " OR ctr.langid is null)";
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$name = $row['name'];
			if($row['name_tr'] != '' || $row['name_tr'] != NULL){
				$name = $row['name_tr'];
			}
			$description = $row['description'];
			if($row['description_tr'] != '' || $row['description_tr'] != NULL){
				$description = $row['description_tr'];
			}
			$catimg='';
			if($row['img']== NULL){
				$catimg = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
			} else {
				$catimg = $row['img'];
			}
			
			$query = "(SELECT * FROM `category_file` WHERE type = 'mc' AND categoryid = ".$catid.")
					UNION
				  (SELECT * FROM `category_file` WHERE type = 'icon' AND categoryid = ".$catid."  ORDER BY RAND() LIMIT 1)";
			$res2 = $mysqli->query($query);
			
			$mc = '';
			$icon = '';
			
			if($res2->num_rows > 0){
				while($rowd = $res2->fetch_assoc()){
					if($rowd['type'] == 'mc'){
						$mc = $rowd['content'];	
					}
					if($rowd['type'] == 'icon'){
						$icon = $rowd['content'];	
					}
				}
			}
			
			return new Category($row['id'], $row['parentid'], $name, $description, $catimg, self::getCategoryPath($row['id']), $mc, $icon);
		}
		return 0;
	}
	
	public static function getAllProduct($extradetail = array()){
	
		/**
		*	$extradetail array of extradetailid
		*/
		
		global $user_conf, $theme_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		//	$categorylist id kategorija u kojima se sve trazi proizvod
		
		$categorylist = array();
		$q = "SELECT id FROM category WHERE parentid = 0";
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				array_push($categorylist, $row['id']);	
				array_merge($categorylist, ShopHelper::getCategoryTreeIdDown($row['id']));
			}
		}
		
		
						
		// extradetail
		
		$ex_cont = 1;
		$extradetail_cont = '';
		if(!empty($extradetail)){
			//	array of extradetailid
			$extradetail_cont = " AND ";
			$string = '';
						
			foreach($extradetail as $k=>$v){
				$string .= ' ped'.$ex_cont.'.extradetailid = '.$v.' AND ';
				$ex_cont++;
			}
			$string = substr($string, 0, -4);
			$extradetail_cont .= $string;
		}
		
		
		
		$q = "SELECT pc.productid FROM productcategory pc
			 LEFT JOIN attrprodval apv ON pc.productid = apv.productid ";
			$q .= "LEFT JOIN attrval av ON apv.attrvalid = av.id";
			for($i = 1; $i <= $ex_cont; $i++){
				$q .= " LEFT JOIN productextradetail ped".$i." ON pc.productid = ped".$i.".productid ";	
			}
			$q .= "WHERE pc.categoryid IN (".implode(',', $categorylist).") ".$extradetail_cont." GROUP BY pc.productid";
			
		$res = $mysqli->query($q);

		$productlist = array();
		while($row = $res->fetch_assoc()){
			array_push($productlist, $row['productid']);
		}	
		
		
		return $productlist;
	}
	
	
	public static function getCategoryProduct($catid, $sub = true, $extradetail = array(), $attrval = array(), $brends = array(), $rebate=0 ){
		
		/**
		*	$extradetail array of extradetailid
		*/

		global $user_conf, $system_conf, $theme_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
				
		$categorylist = array();		
				
		// $sub if true = get all subcat products, false = get only child products
		
		//	$categorylist id kategorija u kojima se sve trazi proizvod
		if($sub){
			$categorylisttemp = ShopHelper::getCategoryTreeIdDown($catid);
			if($system_conf["category_type"][1] == 1){
				$q = "SELECT id FROM category_external WHERE categoryid IN (".implode(',',$categorylisttemp).")";
				$catres = $mysqli->query($q);
				while($catrow = $catres->fetch_assoc()){
					array_push($categorylist, $catrow['id']);	
				}
				
			}else{
				$categorylist = ShopHelper::getCategoryTreeIdDown($catid);
			}
		}else{
			if($system_conf["category_type"][1] == 1){
				$q = "SELECT id FROM category_external WHERE categoryid = ".$catid;
				$catres = $mysqli->query($q);
				while($catrow = $catres->fetch_assoc()){
					array_push($categorylist, $catrow['id']);
				}
			}else{
				$categorylist = array($catid);
			}
		}
		
		
		//just with rebate
		
		$productrebate_cont = '';
		if($rebate>0){
			//	array of extradetailid
			$productrebate_cont = " AND p.rebate>0 ";
		}	

		// extradetail
		
		$ex_cont = 1;
		$extradetail_cont = '';
		if(!empty($extradetail)){
			//	array of extradetailid
			$extradetail_cont = " AND ";
			$string = '';
						
			foreach($extradetail as $k=>$v){
				$string .= ' ped'.$ex_cont.'.extradetailid = '.$v.' AND ';
				$ex_cont++;
			}
			$string = substr($string, 0, -4);
			$extradetail_cont .= $string;
		}
		
		//	attr
		
		$apv_cont = 1;
		$attrval_cont = "";
		if(!empty($attrval)){
			//	array of attrvalid
			
			$attrval_cont = " AND ";
			$string = '';
						
			foreach($attrval as $k=>$v){
				$string .= ' apv'.$apv_cont.'.attrvalid IN ('.implode(',', $v).') AND ';
				$apv_cont++;
			}
			$string = substr($string, 0, -4);
			$attrval_cont .= $string;
		}

		// extradetail
		
		$bd_cont = 1;
		$brend_cont = '';
		if(!empty($brends)){
			//	array of extradetailid
			$brend_cont = " AND p.brendid IN (".implode(',', $brends).") ";
			
		}
		//var_dump($brend_cont);
		
		
		$where = "";
		if($extradetail_cont != "" || $attrval_cont != "" || $brend_cont != ""){
			//$where = "AND (".$extradetail_cont.")";
		}
		
		/*	Local products	*/
		$q = "SELECT * FROM (SELECT pc.productid, p.barcode FROM productcategory pc";
		for($i = 1; $i <= $apv_cont; $i++){
			$q .= " LEFT JOIN attrprodval apv".$i." ON pc.productid = apv".$i.".productid ";	
		}
		$q .= "LEFT JOIN attrval av ON apv1.attrvalid = av.id";
		for($i = 1; $i <= $ex_cont; $i++){
			$q .= " LEFT JOIN productextradetail ped".$i." ON pc.productid = ped".$i.".productid ";	
		}
		//if($brend_cont!=''){
		$q .= " LEFT JOIN product p ON pc.productid = p.id ";	
		//}
		
		$q .= "WHERE p.active='y' AND pc.categoryid IN (".implode(',', $categorylist).") ".$attrval_cont." ".$extradetail_cont." ".$brend_cont." ".$productrebate_cont."";
		
		/*	Supplier products	*/		
		$q .= "UNION SELECT
					pce.productid, IF(p.barcode = '', NULL, p.barcode)
				FROM
					productcategory_external pce
				LEFT JOIN category_external ce ON pce.categoryid = ce.id";
		for($i = 1; $i <= $apv_cont; $i++){
			$q .= " LEFT JOIN attrprodval apv".$i." ON pce.productid = apv".$i.".productid ";	
		}
		$q .= "LEFT JOIN attrval av ON apv1.attrvalid = av.id";
		for($i = 1; $i <= $ex_cont; $i++){
			$q .= " LEFT JOIN productextradetail ped".$i." ON pce.productid = ped".$i.".productid ";	
		}
		$q .= " LEFT JOIN product p ON pce.productid = p.id ";	
		$q .= "WHERE p.active='y' AND ce.categoryid IN (".implode(',', $categorylist).") ".$attrval_cont." ".$extradetail_cont." ".$brend_cont." ".$productrebate_cont." GROUP BY COALESCE(p.barcode, p.id) ";
		
		$q .= " ) as t1 GROUP BY t1.productid";
		//echo $q;
		$res = $mysqli->query($q);
        
		$productlist = array();
		if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			array_push($productlist, $row['productid']);
		}
		}
		
		
 
		return $productlist;
	}
	
	//B2C MODE WHEN USER IS LOGGED AS ADMIN IN ADMIN PANEL THIS FUNCTION RETURNS EMPTY ARRAY JUST LOGOFF FROM ADMIN AND EVERETHING WILL BE OK
	public static function getCategoryProductDetail($prolist = array(), $page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "code",  $action = false, $minprice = '', $maxprice = '', $viewtype = 0 ){
	
		/*
		*	$extradetail array of extradetailid
		*/
		//var_dump($prolist);
		global $user_conf,$system_conf,$theme_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

		$data = array();
		$data[0] = 0;
		$data[1] = array();

		$productlist = $prolist;

		/*	start prepare query parts	*/

		$wheresearch = '';
		$wheresearchtmp = '';
		if($search != ''){
			$tmp = explode(' ', $search);
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$wheresearchtmp .= "
						   (
							   CASE
									WHEN ptr.name > '' THEN ptr.name
									ELSE p.name
							   END like '%".$v."%'
							   OR
							   CASE
									WHEN ptr.manufname > '' THEN ptr.manufname
									ELSE p.manufname
							   END like '%".$v."%'
							   OR
							   CASE
									WHEN ptr.searchwords > '' THEN ptr.searchwords
									ELSE p.searchwords
							   END like '%".$v."%'
							   OR
							   p.code like '".$v."%'
							   OR
							   p.barcode like '".$v."%'
						   ) OR ";
			}
			$wheresearch = " AND (".substr($wheresearchtmp, 0, -3).")";
		}

		$having = '';
		
		$minpricequery = "";
		if($minprice != ''){
			$minpricequery = "totalprice_pdv >= ".intval($minprice)." AND ";
		}
		$maxpricequery = "";
		if($maxprice != ''){
			$maxpricequery = "totalprice_pdv <= ".intval($maxprice)." AND ";
		}

		$hasimagequery = "";
		if($user_conf["show_only_products_with_image"][1]=='1'){
			$hasimagequery = " LENGTH(defaultimage)>0  AND ";
		}

		$hasdescriptionquery = "";
		/*if($user_conf["show_only_products_with_description"][1]=='1'){
			$hasdescriptionquery = "";
		}*/

		if($minpricequery != "" || $maxpricequery != "" || $hasimagequery != "" ){
			$having = " HAVING ";
			$having .= $minpricequery . $maxpricequery . $hasimagequery;
		}
		$having = substr($having, 0, -4);


		/*$having2 = '';
		if($hasimagequery != "" ){
			$having2 = " HAVING ";
			$having2 .= $hasimagequery ;
		}
		$having2 = substr($having2, 0, -4);
*/
		//echo $having2;
		//$having2 = " HAVING  ";

		$sortstring = '';
			if($sortby == 'price'){
				$sortstring = ' totalprice_pdv ';	
			}elseif($sortby == 'random'){
				$sortstring = ' RAND() ';
				$sort = '';
			}elseif($sortby == 'pattern'){
				$sortstring = ' field(p.id,  '.$sort.')';
				$sort = '';
			}else{
				$sortstring = ' p.code ';
			}
			
			$start = ($page-1) * $itemsperpage;
        	$end = $itemsperpage;
		
		$q = "CREATE TEMPORARY TABLE tmptable(
				id BIGINT(30) DEFAULT NULL,
				code VARCHAR(50) DEFAULT NULL,
				barcode VARCHAR(50) DEFAULT NULL,
				name VARCHAR(512) DEFAULT NULL COLLATE 'utf8_unicode_ci',
				nametr VARCHAR(512) DEFAULT NULL COLLATE 'utf8_unicode_ci',
				type VARCHAR(8) DEFAULT NULL ,
				descript mediumtext DEFAULT NULL COLLATE 'utf8_unicode_ci',
				descripttr mediumtext DEFAULT NULL COLLATE 'utf8_unicode_ci',
				actionrebate DOUBLE DEFAULT NULL,
				pricevisible VARCHAR(10) DEFAULT NULL,
				pricevisibility ENUM('n','a','c','b','cb') NOT NULL DEFAULT 'a' COLLATE 'utf8_unicode_ci',
				defaultimage VARCHAR(512) DEFAULT NULL,
				pwprice DOUBLE DEFAULT NULL,
				amount DOUBLE DEFAULT NULL,
				value DOUBLE DEFAULT NULL,
				maxrebate DOUBLE DEFAULT NULL,
				pricelistrebate DOUBLE DEFAULT NULL,
				pricelistprice DOUBLE DEFAULT NULL,
				inheritedrebate DOUBLE DEFAULT NULL,
				inheritedprice DOUBLE DEFAULT NULL,
				parrebate DOUBLE DEFAULT NULL,
				catparrebate DOUBLE DEFAULT NULL,			
				umnozak DOUBLE DEFAULT NULL,
				totalprice_pdv DOUBLE DEFAULT NULL,
				brendid INT DEFAULT NULL,
				brendname VARCHAR(512) DEFAULT NULL COLLATE 'utf8_unicode_ci',
				brendnametr VARCHAR(512) DEFAULT NULL COLLATE 'utf8_unicode_ci',
				brendimage VARCHAR(256) DEFAULT NULL,
				unitname VARCHAR(512) DEFAULT NULL COLLATE 'utf8_unicode_ci',
				unitnametr VARCHAR(512) DEFAULT NULL COLLATE 'utf8_unicode_ci',
				unitstep DECIMAL(26,2) NULL DEFAULT '1'
		)";
		$res = $mysqli->query($q);
		$havingstockZero='';

		switch ($viewtype) {
    	case 0:
        	$alowed_type = " AND p.type IN ('vpi-r','vpi-q') ";
       		break;
    	case 1:
        	$alowed_type = " AND (( p.type IN ('r','q','vp') )) ";
        	break;
        case 2:
        	$alowed_type = " AND (( p.type IN ('r','q','vp') )) ";
        	break;
    	case 3:
        	$alowed_type = " AND (( p.type IN ('r','q','vpi-r','vpi-q') )) ";
        	break;
    	default:
       		$alowed_type = " AND p.type IN ('vpi-r','vpi-q') ";
       	}




		if($_SESSION['shoptype'] == "b2b"){

			//------------------------------------------------------  PRICELISTITEM FOR PARTNER  -----------------------------------------------------------------
			$q ="DROP TABLE IF EXISTS tmp_pricelist";
			$res = $mysqli->query($q);

			$q = "CREATE TEMPORARY TABLE `tmp_pricelist` (
				`pricelistid` BIGINT(30) NOT NULL,
				`productid` BIGINT(30) NOT NULL,
				`rebate` DOUBLE NOT NULL,
				`price` DOUBLE NOT NULL,
				`status` VARCHAR(16) NOT NULL COLLATE 'utf8_unicode_ci',
				`sort` INT(11) NOT NULL,
				`ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`pricelistid`, `productid`),
				INDEX `pricelistid` (`pricelistid`),
				INDEX `productid` (`productid`),
				INDEX `pricelistid_2` (`pricelistid`),
				INDEX `productid_2` (`productid`)
			)";
			$res = $mysqli->query($q);

			$q = "INSERT INTO tmp_pricelist (`pricelistid`,`productid`,`rebate`,`price`,`status`,`sort`,`ts`)
					SELECT pli.pricelistid,
							pli.productid,
							pli.rebate,
							pli.price,
							pli.status,
							pli.sort,
							pli.ts 
					FROM partnerpricelist ppl 
					LEFT JOIN pricelist AS p ON ppl.pricelistid=p.id
					LEFT JOIN pricelistitem pli ON p.id = pli.pricelistid
					WHERE  p.status='v' AND ppl.partnerid = ".$_SESSION['partnerid']." AND pli.productid IN (".implode(',', $productlist).")
			";
			$res = $mysqli->query($q);


			//------------------------------------------------------  PRICELISTITEM FOR END  -----------------------------------------------------------------
						
			//------------------------------------------------------  B2B  -----------------------------------------------------------------
						
			$action_rebate_string = '((100-p.rebate)/100) * ';
			$web_rebate_string = '((100-'.intval($user_conf["webrebate"][1]).')/100) * ';
			$rebate_string = "CASE
									WHEN plih.rebate > '' THEN ((100-plih.rebate)/100)
									WHEN pli.rebate > '' THEN ((100-pli.rebate)/100)
									ELSE  
										CASE
											WHEN getRebateFunc(pc.categoryid, ".$_SESSION['partnerid'].") > '' THEN ((100-getRebateFunc(pc.categoryid, ".$_SESSION['partnerid']."))/100)
											WHEN getPartnerRebate(".$_SESSION['partnerid'].") > '' THEN ((100-getPartnerRebate(".$_SESSION['partnerid']."))/100)
											ELSE 1
										END 
								END * ";
			$tmpstring2 = '';
			if($user_conf["act_priority"][1] == 1){
				// action only
				if($user_conf["combine_act_web"][1] == 1){
					// action + web 
					$tmpstring = $action_rebate_string . $web_rebate_string;
					$tmpstring2 = $web_rebate_string;
				}else{
					// action	
					$tmpstring = $action_rebate_string;
				}
			}
			else{
				if($user_conf["combine_act_web"][1] == 1){
					// action + web + (plih.rebate > pl.rebate > pc.rebate > p.rebate	)
					$tmpstring = $action_rebate_string . $web_rebate_string . $rebate_string;
					$tmpstring2 = $web_rebate_string;
				}else{
					// action + (plih.rebate > pl.rebate > pc.rebate > p.rebate	)
					$tmpstring = $action_rebate_string . $rebate_string;
				}
			}
			
			$tmpstring = substr($tmpstring, 0, -3);
			$tmpstring2 .= $rebate_string;
			$tmpstring2 = substr($tmpstring2,0,-3);

			
			
			$q = "INSERT INTO tmptable (id, code, barcode, name, nametr, type, descript, descripttr, actionrebate, pricevisible,pricevisibility, defaultimage, pwprice, amount, value, maxrebate, pricelistrebate, pricelistprice,	inheritedrebate, inheritedprice, parrebate, catparrebate, umnozak, totalprice_pdv, brendid, brendname, brendnametr, brendimage, unitname, unitnametr,unitstep) 
				SELECT p.id, 
				p.code, 
				p.barcode, 
				p.name, 
				ptr.name as nametr, 
				p.type, 
				pd.description,
				pdtr.description AS descripttr,
				p.rebate as actionrebate,
				p.pricevisible,
				p.pricevisibility,
				getDefaultImage(p.id) as `defaultimage`, 
				getProductPriceWithMargin(p.id, ".$_SESSION['warehouseid'].") as pwprice, 
				getProductAmount(p.id, ".$_SESSION['warehouseid'].") as amount, 
				t.value, 
				pd.maxrebate as maxrebate, 
				pli.rebate as pricelistrebate,
				pli.price as pricelistprice, 
				plih.rebate as inheritedrebate,
				plih.price as inheritedprice,
				getPartnerRebate(".$_SESSION['partnerid'].") as parrebate, 
				MAX(getRebateFunc(pc.categoryid, ".$_SESSION['partnerid'].")) as catparrebate ,
				MIN(CASE
					WHEN p.rebate > 0 THEN
						/*	rabate politic	*/
						CASE
							WHEN ( ".$tmpstring." ) < ((100-pd.maxrebate)/100) THEN ".$tmpstring." 
							ELSE ((100-pd.maxrebate)/100)
						END	
						/*	end rabate politic	*/	
					ELSE	
						/*  proizvod nema akciju	*/
						CASE 
							WHEN( " .$tmpstring2." ) < ((100-pd.maxrebate)/100) THEN ((100-pd.maxrebate)/100)
							ELSE ( " .$tmpstring2.")
						END
				END) as umnozak,
				MIN((pw.price*(1+(t.value/100))) * 
				CASE
					WHEN p.rebate > 0 THEN
						/*	rabate politic	*/
						CASE
							WHEN ( ".$tmpstring." ) < ((100-pd.maxrebate)/100) THEN  ((100-pd.maxrebate)/100)
							ELSE ".$tmpstring."
						END	
						/*	end rabate politic	*/	
					ELSE	
						/*  proizvod nema akciju	*/
						CASE 
							WHEN( " .$tmpstring2." ) < ((100-pd.maxrebate)/100) THEN ((100-pd.maxrebate)/100)
							ELSE ( " .$tmpstring2.")
						END
				END) as totalprice_pdv,
			p.brendid,
			br.name as brandname,
			brtr.name as brandnametr,
			br.image as brandimage,
			p.unitname,
			ptr.unitname AS unitnametr,
			p.unitstep	 
			FROM product AS p 
			LEFT JOIN productcategory AS pc ON p.id=pc.productid
			LEFT JOIN partnercategory pac ON pc.categoryid = pac.categoryid AND (pac.partnerid = ".$_SESSION['partnerid']." OR pac.partnerid IS NULL)
			LEFT JOIN product_tr ptr ON p.id = ptr.productid AND (ptr.langid = ". $_SESSION['langid']. " OR ptr.langid IS NULL )
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid AND (pdtr.langid = ". $_SESSION['langid']. " OR pdtr.langid is NULL )
			LEFT JOIN productwarehouse pw ON p.id = pw.productid AND pw.warehouseid=".$_SESSION['warehouseid']."
			LEFT JOIN tax t ON p.taxid = t.id			

			LEFT JOIN tmp_pricelist pli ON p.id = pli.productid 
			LEFT JOIN pricelistinherited plih ON p.id = plih.productid AND ".$_SESSION['partnerid']." = plih.partnerid
			LEFT JOIN brend AS br ON p.brendid=br.id
			LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL )
			WHERE pw.warehouseid = ".$_SESSION['warehouseid']."
			".(($user_conf["show_product_with_stack_zero"][1] == 1)? " AND pw.amount > 0 ":"")."
			AND p.id IN (".implode(',', $productlist).") AND p.active = 'y' ".$alowed_type."
			
			AND ((ptr.langid = ". $_SESSION['langid']. " OR ptr.langid IS NULL ) AND (pdtr.langid = ". $_SESSION['langid']. " OR pdtr.langid is NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ))
			
			".$wheresearch."
			GROUP BY p.id
			 ".$having." 
			ORDER BY ".$sortstring." ".$sort." ";
			
			//AND (pac.partnerid = ".$_SESSION['partnerid']." OR pac.partnerid IS NULL)			

		}
		else{
			
			//--------------------------------------------------------  B2C  ------------------------------------------------------
			
			if($user_conf["combine_act_web"][1] == '1'){
				$pricetype = '( ((100-p.rebate)/100) * ((100-'.intval($user_conf["webrebate"][1]).')/100) )';	
			}
			else{
				$pricetype = ' 1-(p.rebate/100) ';	
			}

			

			$q = "INSERT INTO tmptable (id, code, barcode, name, nametr, type, descript, descripttr, actionrebate, pricevisible, pricevisibility, defaultimage, pwprice, amount, value, maxrebate, umnozak, totalprice_pdv, brendid, brendname, brendnametr, brendimage, unitname, unitnametr,unitstep) 
			 SELECT p.id,
			 p.code, 
			 p.barcode, 
			 p.name, 
			 ptr.name as nametr,
			 p.type,
			 pd.description,
			 pdtr.description AS descripttr,
			 p.rebate,
			 p.pricevisible,
			 p.pricevisibility,
			 getDefaultImage(p.id) as `defaultimage`,
			 getProductPriceWithMargin(p.id, ".$_SESSION['warehouseid'].") as pwprice , 
			 getProductAmount(p.id, ".$_SESSION['warehouseid'].") as amount, 
			 t.value, 
			 pd.maxretailrebate as maxrebate, 
				CASE 
					WHEN ".$pricetype." < 1-(pd.maxretailrebate/100) THEN 1-(pd.maxretailrebate/100)
					ELSE ".$pricetype."
				END as umnozak,
				(pw.price*(1+(t.value/100))) * CASE 
					WHEN ".$pricetype." < 1-(pd.maxretailrebate/100) THEN 1-(pd.maxretailrebate/100)
					ELSE ".$pricetype."
				END as totalprice_pdv,
			p.brendid,
			br.name as brandname,
			brtr.name as brandnametr,
			br.image as brandimage,
			p.unitname,
			ptr.unitname AS unitnametr,
			p.unitstep		 
			FROM product p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid
			LEFT JOIN product_file pf ON p.id = pf.productid
			LEFT JOIN productwarehouse pw ON p.id = pw.productid
			LEFT JOIN tax t ON p.taxid = t.id
			LEFT JOIN brend AS br ON p.brendid=br.id
			LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
			WHERE 
				pw.warehouseid = ".$_SESSION['warehouseid']." 
				
				".(($user_conf["show_product_with_stack_zero"][1] == 1)? " AND pw.amount > 0 ":"")."
				
				AND 
				 
				p.id IN (".implode(',', $productlist).") AND p.active = 'y' ".$alowed_type."
				
				AND
				
				
				((ptr.langid = ". $_SESSION['langid']. " OR ptr.langid IS NULL ) AND (pdtr.langid = ". $_SESSION['langid']. " OR pdtr.langid is NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL )) 
				
			   ".$wheresearch."
			 GROUP BY p.id   
			    ".$having." 
			ORDER BY ".$sortstring." ".$sort." ";
			
		}
		
		$tmpres = $mysqli->query("SET @@SESSION.max_sp_recursion_depth = 255");

		if(gethostbyname('obicni.ddns.name') == $_SERVER['REMOTE_ADDR'])
		{ 
			//echo ($q);
		}
		
		$mysqli->query($q);
				
		$q = "SELECT MIN(totalprice_pdv) as min, MAX(totalprice_pdv) as max FROM tmptable";
		$mmres = $mysqli->query($q);
		$mmrow = $mmres->fetch_assoc();
		
		$data['min'] = $mmrow['min'];
		$data['max'] = $mmrow['max'];

		$q = "SELECT SQL_CALC_FOUND_ROWS * FROM tmptable LIMIT " . $start . "," . $end;
		
		$res = $mysqli->query($q);

		if($res->num_rows > 0){
			$sQuery = "SELECT FOUND_ROWS()";
			$sRe = $mysqli->query($sQuery);
			$aRe = $sRe->fetch_array();
			$data[0] = $aRe[0];
			
			while($row = $res->fetch_assoc()){
				$query = "SELECT ped.*, ed.image, ed.name, edtr.name as nametr, edtr.image as imagetr FROM productextradetail ped 
				LEFT JOIN extradetail ed ON ped.extradetailid = ed.id
				LEFT JOIN extradetail_tr edtr ON ed.id = edtr.extradetailid
				WHERE (edtr.langid = ". $_SESSION['langid']. " OR edtr.langid IS NULL) AND ped.productid = ".$row['id']." ORDER BY ed.sort ASC";
				$resed = $mysqli->query($query);
				
				$edcont = array();
				while($edrow = $resed->fetch_assoc()){
					$img = $edrow['image'];
					if($edrow['imagetr'] != NULL){
						$img = $edrow['imagetr'];	
					}
					$name = $edrow['name'];
					if($edrow['nametr'] != NULL){
						$name = $edrow['nametr'];	
					}
					array_push($edcont, array('extradetailid' => $edrow['extradetailid'], 'name' => $name, 'image' => $img));	
				}
				
				$q = "SELECT * FROM attrprodval WHERE productid = ".$row['id'];
				$ares = $mysqli->query($q);
				$ha = false;
				if($ares->num_rows > 0){ $ha = true;}
				//
				
			/*	if($system_conf["category_type"][1]==1){	
					// relacije aktivne
					$q = "SELECT ".$_SESSION['shoptype']."visibleprice FROM productcategory pc 
					LEFT JOIN category_external ce ON pc.categoryid = ce.id
					LEFT JOIN category c ON ce.categoryid = c.id
					WHERE pc.productid = ".$row['id']." ORDER BY pc.categoryid DESC LIMIT 1";
				}else{
					$q = "SELECT ".$_SESSION['shoptype']."visibleprice FROM productcategory pc 
					LEFT JOIN category c ON pc.categoryid = c.id
					WHERE pc.productid = ".$row['id']." ORDER BY pc.categoryid DESC LIMIT 1";
				}*/
				
				/*	DUAL suppliers	*/
				
				$q = "SELECT c.".$_SESSION['shoptype']."visibleprice FROM category c 
						WHERE id in (
						SELECT IF(pc.categoryid IS NOT NULL, pc.categoryid, ce.categoryid) as categoryid FROM product p
						LEFT JOIN productcategory pc ON p.id = pc.productid
						LEFT JOIN productcategory_external pce ON p.id = pce.productid
						LEFT JOIN category_external ce ON pce.categoryid = ce.id
						WHERE pc.productid = ".$row['id']." OR pce.productid = ".$row['id']."
						) ORDER BY c.id DESC LIMIT 1";
						
				$prires = $mysqli->query($q);
				$prirow = $prires->fetch_assoc();
				
				$max_rebate=0;
				$productname = $row['name'];
				if($row['nametr'] != '' && $row['nametr'] != NULL){
					$productname = $row['nametr'];
				}
				$productdesc = $row['descript'];
				if($row['descripttr'] != '' && $row['descripttr'] != NULL){
					$productdesc = $row['descripttr'];
				}

				$brendname=$row['brendname'];
				if($row['brendnametr'] != '' && $row['brendnametr'] != NULL){
					$brendname = $row['brendnametr'];
				}
				$brendimage=$row['brendimage'];
				$brendhasimage=1;
				if($row['brendimage']==''){
					$brendimage=$system_conf["theme_path"][1].$theme_conf["no_img"][1];
					$brendhasimage=0;
				}
				$tax_value=0;
				if($row['value']>0){
					$tax_value=$row['value'];
				}

				if($row['value']>0){
					$tax_value=$row['value'];
				}
				$unitname = $row['unitname'];
				if($row['unitnametr'] != '' && $row['unitnametr'] != NULL){
					$unitname = $row['unitnametr'];
				}
				if($prirow[$_SESSION['shoptype']."visibleprice"] == 0) $row['pricevisible'] = 0;
				
				array_push($data[1], new ProductSmall($row['id'], $row['code'], $row['barcode'], $row['defaultimage'], $productname, '', GlobalHelper::getProductLinkFromProdId($row['id']), $row['pwprice']/$_SESSION["currencyvalue"], ($row['umnozak'] == 0)? 0:((1-$row['umnozak'])*100), $tax_value, $row['amount'],  $edcont, $row['pricevisible'], $row['pricevisibility'], $ha, $productdesc, $row['type'], $row['actionrebate'], Product::getAttributes($row['id']),Product::getProductQuantityRebate($row['id']),$row['maxrebate'],$row['brendid'],$brendname,$brendhasimage,$brendimage, $unitname,$row['unitstep'] ));					
				
			}
		}
		
		/*	empty temorary table	*/
		$q = "TRUNCATE TABLE tmptable";
		$mysqli->query($q);
		//var_dump($data);


		// //inprogress
		// $dataTemp=$data;

		// if($viewtype==3){
		// 	$prodata = self::parseCategoryProductDataForB2BView($dataTemp,$lastcatid,$minprice, $maxprice);

		// }else {
		// 	$finaldata=$dataTemp;
		// }







		return $data;
	}
	public static function parseCategoryProductDataForB2BView($prodata = array(),$lastcatid=0, $minprice = '', $maxprice = ''){ //$proddata=return from Category::getCategoryProductDetail() function
		$final_single_proddata=array();
						$final_proddata=array();
						$final_proddata[0]=$prodata[0];
						$final_proddata[1]=array();
						//var_dump($final_proddata[1]);
						//echo '<pre>';
						//var_dump($prodata[1]);
						//echo '</pre>';
						
						
						foreach($prodata[1] as $key=>$val){
							$data = array();
							$mandatory=0;	
							
							if(count($val->attr)>0){
							for($i = 0; $i < count($val->attr); $i++){
								$mandatory+=$val->attr[$i]["mandatory"];
								
								if($val->attr[$i]["mandatory"]==1 && $val->attr[$i]["categoryid"]==$lastcatid){ 
									$tmp_attr_lang_id = $val->attr[$i]["lang_id"];
									$tmp_attr_name = $val->attr[$i]["name"];
									$tmp_attr_mandatory = $val->attr[$i]["mandatory"];
								
									$tmp_attr_id = $val->attr[$i]["attrid"];
									$data[$i] = array();
								
									foreach($val->attr[$i]['value'] as $k=>$v){
										
										array_push($data[$i], array('attr_lang_id'=>$tmp_attr_lang_id,
																	'attr_name'=>$tmp_attr_name,
																	'mandatory'=>$tmp_attr_mandatory,
																	'attrid'=>$tmp_attr_id,
																	'attr_val_id'=>$v['attr_val_id'],
																	'attr_val_name'=>$v['attr_val_name'],
																	'mainimage'=>$v['mainimage'],
																	'maincolor'=>$v['maincolor']));
									}	
								}					
							}
							}
							
							if($mandatory==0){
									array_push($final_proddata[1],new ProductSmall($val->id,
								                                    $val->code,
																	$val->barcode,
																	$val->image,
																	$val->name,
																	$val->categorypath,
																	$val->productlink,
																	$val->price,
																	$val->rebate,
																	$val->tax,
																	$val->amount,
																	$val->extradetail,
																	$val->visibleprice,
																	$val->pricevisibility,
																	$val->haveattr,
																	$val->desc,
																	$val->type,
																	$val->actionrebate,
																	$val->attr,
																	Product::getProductQuantityRebate($val->id),
																	$val->maxrebate,
																	$val->brendid,
																	$val->brendname,
																	$val->brendhasimage,
																	$val->brendimage,
																	$val->unitname,
																	$val->unitstep
																	)
											);
							} else {
								 // echo '<pre>';
								 // var_dump($data);
								 // echo '</pre>';
								$final = array();
							//echo '<pre>';	
							//var_dump($data);
							//echo '</pre><br><br>';
							$final = Product::req($data);
							//echo '<pre>';	
							//var_dump($final);
							//echo '</pre>';
							if(count($final)>0){
							foreach($final as $v){
								$attr_arr_final=array();
								//$attr_value_arr_final=array();
								//echo count($v);
								//if(count($v)>0){
								//IMPORTANT PRODUCT WITH ONE MANDATORY ATTRIBUTE
								if(isset($v["attr_val_id"])){
									$attr_value_arr_final=array();
									//var_dump($vv);
									$attr_value_arr_final_one=array();
									array_push($attr_value_arr_final_one,array('attr_val_id'=>$v["attr_val_id"],
																	   'attr_val_name'=>$v["attr_val_name"],
																	   'mainimage'=>$v["mainimage"],
																	   'maincolor'=>$v["maincolor"]
																		)
								
											);
									array_push($attr_arr_final,array('lang_id'=>$v["attr_lang_id"],
																 'name'=>$v["attr_name"],
																 'mandatory'=>$v["mandatory"],
																 'attrid'=>$v["attrid"],
																 'value'=>$attr_value_arr_final_one
																)
											);
								} else {
								//IMPORTANT PRODUCT WITH MORE THEN ONE MANDATORY ATTRIBUTE 
								foreach($v as $vv){
									if(isset($vv["attr_val_id"])){
									$attr_value_arr_final=array();
									//var_dump($vv);
									array_push($attr_value_arr_final,array('attr_val_id'=>$vv["attr_val_id"],
																	   'attr_val_name'=>$vv["attr_val_name"],
																	   'mainimage'=>$vv["mainimage"],
																	   'maincolor'=>$vv["maincolor"]
																		)
								
											);
									array_push($attr_arr_final,array('lang_id'=>$vv["attr_lang_id"],
																 'name'=>$vv["attr_name"],
																 'mandatory'=>$vv["mandatory"],
																 'attrid'=>$vv["attrid"],
																 'value'=>$attr_value_arr_final
																)
											);
									}
								}
								//IMPORTANT PRODUCT WITH MORE THEN ONE MANDATORY ATTRIBUTE 
								}
								
								//}
								// echo '<pre>'; var_dump($attr_arr_final); echo '</pre>';
								array_push($final_proddata[1],new ProductSmall($val->id,
								                                    $val->code,
																	$val->barcode,
																	$val->image,
																	$val->name,
																	$val->categorypath,
																	$val->productlink,
																	$val->price,
																	$val->rebate,
																	$val->tax,
																	$val->amount,
																	$val->extradetail,
																	$val->visibleprice,
																	$val->pricevisibility,
																	$val->haveattr,
																	$val->desc,
																	$val->type,
																	$val->actionrebate,
																	$attr_arr_final,
																	Product::getProductQuantityRebate($val->id),
																	$val->maxrebate,
																	$val->brendid,
																	$val->brendname,
																	$val->brendhasimage,
																	$val->brendimage,
																	$val->unitname,
																	$val->unitstep
																	)
											);
							}
							} else {
								$attr_arr_final=array();
								array_push($final_proddata[1],new ProductSmall($val->id,
								                                    $val->code,
																	$val->barcode,
																	$val->image,
																	$val->name,
																	$val->categorypath,
																	$val->productlink,
																	$val->price,
																	$val->rebate,
																	$val->tax,
																	$val->amount,
																	$val->extradetail,
																	$val->visibleprice,
																	$val->pricevisibility,
																	$val->haveattr,
																	$val->desc,
																	$val->type,
																	$val->actionrebate,
																	$attr_arr_final,
																	Product::getProductQuantityRebate($val->id),
																	$val->maxrebate,
																	$val->brendid,
																	$val->brendname,
																	$val->brendhasimage,
																	$val->brendimage,
																	$val->unitname,
																	$val->unitstep
																	)
											);
								
							}

							}
							
							
						}
						return $final_proddata;
	}

	/**
	 * @param $catid
	 * @return array[p1][p2][p3]
	 * p1-attribut name
	 * p2-number off attribute values
	 * p3-avid, avvalue, qty
     */
	public static function getCategoryAttr($catid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		$q = "SELECT * FROM (SELECT
					a.id AS aid,
					a.name,
					atr.name AS nametr,
					av.id AS avid,
					av.value,
					avtr.value AS valuetr,
					COUNT(av.id) AS num,
					pc.productid
				FROM
					productcategory pc LEFT JOIN attrprodval apv ON pc.productid = apv.productid
				LEFT JOIN attrval av ON apv.attrvalid = av.id
				LEFT JOIN attrval_tr avtr ON av.id = avtr.attrvalid
				LEFT JOIN attr a ON av.attrid = a.id
				LEFT JOIN attr_tr atr ON a.id = atr.attrid
				LEFT JOIN productwarehouse pw ON apv.productid = pw.productid AND pw.warehouseid = 1
				WHERE pw.amount > 0 AND 
					pc.categoryid = ".$catid." AND(
						(
							atr.langid = ". $_SESSION['langid']. " OR atr.langid IS NULL
						) AND(
							avtr.langid = ". $_SESSION['langid']. " OR avtr.langid IS NULL
						)
					) AND apv.productid IS NOT NULL AND a.id IS NOT NULL
				GROUP BY
					av.id
				UNION ALL
				SELECT
					a.id AS aid,
					a.name,
					atr.name AS nametr,
					av.id AS avid,
					av.value,
					avtr.value AS valuetr,
					COUNT(av.id) AS num,
					pce.productid
				
				
				FROM attrcategory ac  
				LEFT JOIN category_external ce ON ac.categoryid = ce.categoryid
				LEFT JOIN productcategory_external pce ON ce.id = pce.categoryid
				LEFT JOIN attrprodval apv ON pce.productid = apv.productid
				LEFT JOIN attrval av ON apv.attrvalid = av.id
				LEFT JOIN attrval_tr avtr ON av.id = avtr.attrvalid
				LEFT JOIN attr a ON av.attrid = a.id
				LEFT JOIN attr_tr atr ON a.id = atr.attrid
				LEFT JOIN productwarehouse pw ON apv.productid = pw.productid AND pw.warehouseid = 1
				WHERE pw.amount > 0 AND ac.categoryid = ".$catid." AND(
						(
							atr.langid = ". $_SESSION['langid']. " OR atr.langid IS NULL
						) AND(
							avtr.langid = ". $_SESSION['langid']. " OR avtr.langid IS NULL
						)
					) AND apv.productid IS NOT NULL AND a.id IS NOT NULL
				GROUP BY
					av.id) as t1 
					ORDER BY t1.aid ";
	//echo $q;
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			$attrname = "";
			
			while($row = $res->fetch_assoc()){
				
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				
				if($name != $attrname){
					$cont[$name] = array();	
					$attrname = $name;
				}
							
				$value = $row['value'];
				if($row['valuetr'] != NULL){
					$value = $row['valuetr'];	
				}
				
				$qf = "(SELECT content, type FROM attrval_file WHERE attrvalid = ".$row['avid']." AND type = 'mc')
						UNION
					(SELECT content, type FROM attrval_file WHERE attrvalid = ".$row['avid']." AND type = 'mi')	
				";
				$resf = $mysqli->query($qf);
				$mc = '';
				$mi = '';
				while($rowf = mysqli_fetch_assoc($resf)){
					if($rowf['type'] == 'mi'){ $mi = $rowf['content']; }
					if($rowf['type'] == 'mc'){ $mc = $rowf['content']; }	
				}
				
				array_push($cont[$name], array('avid' => $row['avid'], 'avvalue' => $value, 'qty' => $row['num'], 'mi'=>$mi, 'mc'=>$mc));
			}
		}
		return $cont;
	}
	
		public static function getCategoryImages($catid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		
		$q = "SELECT * FROM category_file cf
			  WHERE cf.categoryid = ".$catid." AND cf.`type`='img' AND cf.`sort`=0 ORDER BY cf.id ASC";	
			
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			$attrname = "";
			
			while($row = $res->fetch_assoc()){
				array_push($cont, array('id' => $row['id'], 'categoryid' => $row['categoryid'], 'type' => $row['type'], 'content' => $row['content'], 'contentface' => $row['contentface'], 'sort' => $row['sort'], 'status' => $row['status']));
			}
		}
		return $cont;
	}
	
	
	
	public static function getCategorySlider($catid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		
		$q = "SELECT * FROM category_file cf
			  WHERE cf.categoryid = ".$catid." AND cf.`type`='gal' AND cf.`sort`=0 ORDER BY cf.id ASC";	
			
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			$attrname = "";
			
			while($row = $res->fetch_assoc()){
				array_push($cont, array('id' => $row['id'], 'categoryid' => $row['categoryid'], 'type' => $row['type'], 'galleryid' => $row['content'], 'sort' => $row['sort'], 'status' => $row['status']));
			}
		}
		return $cont;
	}
	
	public static function getCategoryPath($catid){
		$data = ShopHelper::getCategoryTreeUp($catid);
		$string = '';
		$data = array_reverse($data);
		foreach($data as $k=>$v){
			$string .= rawurlencode($v['name']).DIRECTORY_SEPARATOR;
		}
		return substr($string, 0, -1);
	}

	public static function getRebate($catid, $partnerid){
		//	vraca partnerski popoust po kategoriji - ako nema child trazi kroz parents
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
			
		if($catid == 0){
			return 0;
		}
		else{
			$q = "SELECT * FROM partnercategory WHERE categoryid =".$catid." AND partnerid=".$partnerid;	
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				$row = $res->fetch_assoc();
				return $row['rebatepercent'];
			}
			else{
				$q = "SELECT * FROM category c WHERE id = ".$catid;
				$res = $mysqli->query($q);
				$id = 0;
				if($res->num_rows > 0){
					$row = $res->fetch_assoc();
					$id = $row['parentid'];	
					return Category::getRebate($id, $partnerid);
				}
				
			}	
		}
	}
	
	public static function attrFormatFromUrl(){
		// vraca strukturu za getCategoryProduct() funkciju
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cont = array();
		
		if(isset($_GET['at'])){
			
			$q = "SELECT av.id, a.name FROM attrval av 
					LEFT JOIN attr a ON av.attrid = a.id
					WHERE av.id IN (".implode(',', $_GET['at']).")
					ORDER BY a.id";
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				$attrnme = '';
				while($row = $res->fetch_assoc()){
					if($attrnme != $row['name']){
						$cont[$row['name']] = array();
						$attrnme = $row['name'];
					}
					
					array_push($cont[$row['name']], $row['id']);
				}
			}
		}
				
		return $cont;
	}
	
	public static function getExtradetail(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cont = array();
		
		$q = "SELECT ed.id, ed.name, edtr.name as nametr FROM extradetail ed 
				LEFT JOIN extradetail_tr edtr ON ed.id = edtr.extradetailid
				WHERE ed.status = 'v' AND ed.showinwebshop='y'
				AND (edtr.langid = ". $_SESSION['langid']. " OR edtr.langid IS NULL)";
				
		$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					$name = $row['name'];
					if($row['nametr'] != NULL){
						$name = $row['nametr'];
					}
					
					array_push($cont, array("id"=>$row['id'], "name"=>$name));
				}
			}
		
		return $cont;	
	}

	public static function getExtradetailWelcomePage(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cont = array();
		
		$q = "SELECT ed.id, ed.name, edtr.name as nametr , ed.banerid FROM extradetail ed 
				LEFT JOIN extradetail_tr edtr ON ed.id = edtr.extradetailid
				WHERE ed.status = 'v' AND ed.showinwelcomepage='y'
				AND (edtr.langid = ". $_SESSION['langid']. " OR edtr.langid IS NULL)";

		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];
				}
				
				array_push($cont, array("id"=>$row['id'], 
										"name"=>$name, 
										"productdata"=>self::getProductDataByExtradetailIdWelcomePage($row['id']) ,
										"banerdata"=>self::getExtradetailBanerWelcomePage($row['banerid'])
									)
							);
			}
		}
		
		return $cont;	
	}

	public static function getProductDataByExtradetailIdWelcomePage($id){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$edd_products = array();
		
		//$edd_data = array();
		//$edd_data['edddata']=array();
		//$edd_data['productdata'] = array();

		$edd_prodids = array();

		$q="SELECT p.id FROM product p
		LEFT JOIN productextradetail ped ON p.id = ped.productid
		WHERE ped.extradetailid = ".$id." " ;


		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				array_push($edd_prodids, $row['id']);
			}
		}

		$edd_products = self::getCategoryProductDetail($edd_prodids,1,12,'','ASC','random', false, 0, 0, 1);
		//var_dump($edd_products);


		
		
		return $edd_products;	
	}


	public static function getExtradetailBanerWelcomePage($banerid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$banerdata = array();
		
		if($banerid>0){
			$q="SELECT b.*, btr.value as valuetr FROM banner b
			LEFT JOIN banner_tr btr ON b.id = btr.bannerid
			WHERE b.id = ".$banerid." AND status = 'v' AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid is null) 
			ORDER BY sort ASC";
			
	
	
				$res = $mysqli->query($q);
				if($res && $res->num_rows > 0){
					while($row = $res->fetch_assoc()){
						array_push($banerdata, array("banerid"=>$row['id'],"banervalue"=>$row['valuetr']));
					}
			}	

		}

			
		
		return $banerdata;	
	}




	public static function getBrends(){
		global $user_conf,$system_conf,$theme_conf;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cont = array();
		
		$q = "SELECT b.id, b.name, btr.name as nametr, b.image AS `brendimage` FROM brend b 
				LEFT JOIN brend_tr btr ON b.id = btr.brendid
				WHERE b.status = 'v' 
				AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid IS NULL) ORDER BY b.sort ASC";
		$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					$name = $row['name'];
					if($row['nametr'] != NULL){
						$name = $row['nametr'];
					}
					$brendimage=$row['brendimage'];
					$brendhasimage=1;
					if($row['brendimage']==''){
						$brendimage=$system_conf["theme_path"][1].$theme_conf["no_img"][1];
						$brendhasimage=0;
					}
					
					array_push($cont, array("id"=>$row['id'], "name"=>$name, "hasimage"=>$brendimage, "image"=>$brendimage));
				}
			}
		
		return $cont;	
	}


	public static function getBrendsByProducIds($prolist = array(), $viewtype = 0){
		global $user_conf,$system_conf,$theme_conf;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cont = array();

		$productlist = $prolist;

		switch ($viewtype) {
    	case 0:
        	$alowed_type = " AND p.type IN ('vpi-r','vpi-q') ";
       		break;
    	case 1:
        	$alowed_type = " AND (( p.type IN ('r','q','vp') )) ";
        	break;
        case 2:
        	$alowed_type = " AND (( p.type IN ('r','q','vp') )) ";
        	break;
    	case 3:
        	$alowed_type = " AND (( p.type IN ('r','q','vpi-r','vpi-q') )) ";
        	break;
    	default:
       		$alowed_type = " AND p.type IN ('vpi-r','vpi-q') ";
       	}
		
		$q = "SELECT DISTINCT b.id, b.name, btr.name as nametr, b.image AS `brendimage` FROM brend b 
				LEFT JOIN brend_tr btr ON b.id = btr.brendid
				LEFT JOIN product as p ON b.id=p.brendid
				WHERE b.status = 'v' AND p.id IN (".implode(',', $productlist).") AND p.active = 'y'  ".$alowed_type."
				AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid IS NULL) ORDER BY b.name ASC";
		//echo $q;
		$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					$name = $row['name'];
					if($row['nametr'] != NULL){
						$name = $row['nametr'];
					}
					$brendimage=$row['brendimage'];
					$brendhasimage=1;
					if($row['brendimage']==''){
						$brendimage=$system_conf["theme_path"][1].$theme_conf["no_img"][1];
						$brendhasimage=0;
					}
					
					array_push($cont, array("id"=>$row['id'], "name"=>$name, "hasimage"=>$brendimage, "image"=>$brendimage));
				}
			}
		
		return $cont;	
	}

	/**
	 * @param $catid
	 * @return array of object Category
	 */
	public static function getChildCats($catid){
		$chieldCats = ShopHelper::getCategoryChild($catid);
		$cats = array();
		foreach ($chieldCats as $cat) {
			array_push($cats, Category::getCategoryData($cat['id']));
		}
		return $cats;

	}

	public static function getAllCatsId(){
		$cont = array();
		
		$catdata = ShopHelper::getCategoryChild(0);
		foreach($catdata as $key=>$val){
			array_push($cont, $val['id']);
			$chieldCats = ShopHelper::getCategoryTreeIdDown($val['id']);
			$cont = array_merge($cont, $chieldCats);
		}
		return $cont;
	}

}


?>