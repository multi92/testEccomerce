<?php

$class_version["search"] = array('module', '1.0.0.0.1', 'Nema opisa');

class Search{
	
	public static function productSearch($searchstring,  $page = 1, $itemsperpage = 1, $brend = array(), $categoryid = array(), $attrvalid = array()){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		global $system_conf,$user_conf;
		
		$data = array();

		$start = ($page-1) * $itemsperpage;
        $end = $itemsperpage;
		
		$tmp = explode(" ", $searchstring);
		
		if(count($tmp) > 0 && $tmp[0] != "")
		{		
			$where = "";
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$nv = $mysqli->real_escape_string($v);
	
				$where .= ' (p.code like "'.$nv.'%" OR 
							p.barcode like "'.$nv.'%" OR 
							p.name like "%'.$nv.'%" OR 
							p.manufname like "%'.$nv.'%" OR 
							ptr.name like "%'.$nv.'%" OR 
							ptr.manufname like "%'.$nv.'%" OR 
							p.manufcode like "'.$nv.'%" OR 
							p.searchwords like "%'.$nv.'%" OR 
							ptr.searchwords like "%'.$nv.'%" OR 
							pd.specification like "%'.$nv.'%" OR 
							pdtr.specification like "%'.$nv.'%" OR 
							pd.model like "%'.$nv.'%" OR 
							pdtr.model like "%'.$nv.'%" OR 
							pd.characteristics like "%'.$nv.'%" OR 
							pdtr.characteristics like "%'.$nv.'%" OR 
							pd.description like "%'.$nv.'%" OR 
							pdtr.description like "%'.$nv.'%" ) AND ';
			}
			$where = substr($where, 0, -4);
			
			$where2 = '';
			$where3 = ' AND c.id IN ('.implode(",",GlobalHelper::getCurrentUserValidCategorys()).') ';
			$where4 = '';
			$wheretables4 = '';

			$alowed_type = " AND (( p.type IN ('r','q','vp') )) ";

			
			
			if(!empty($brend) && is_array($brend)){
				foreach($brend as $key=>$val){
					$where2 .= " AND p.brendid = '".$val."' "; 	
				}	
			}
			if(!empty($categoryid) && is_array($categoryid)){
				$where3 .= " AND c.id IN (".implode(',', $categoryid).") "; 		
			}
			if(!empty($attrvalid) && is_array($attrvalid)){
				$i = 1;
				foreach($attrvalid as $key => $val){
					$where4 .= " AND apv".$i.".attrvalid = ".$val;
					$wheretables4 .= ' LEFT JOIN attrprodval apv'.$i.' ON p.id = apv'.$i.'.productid ';
					$i++;
				}		
			}
				
			$has_image_flag='';
			if($user_conf["show_only_products_with_image"][1]=='1'){
				$has_image_flag.=" AND pf.type IS NOT NULL ";
			}

			$q = 'SELECT SQL_CALC_FOUND_ROWS *, count(finall.id) as pronum FROM (
			SELECT p.id, p.name, p.code,getDefaultImage(p.id) as `defaultimage` FROM `product` p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid 
			LEFT JOIN productcategory pc ON p.id = pc.productid
			LEFT JOIN productcategory_external pce ON p.id = pce.productid
			LEFT JOIN category_external ce ON pce.categoryid = ce.id
			LEFT JOIN product_file pf ON p.id = pf.productid AND pf.type = "img"
			LEFT JOIN category c ON pc.categoryid = c.id
			LEFT JOIN productwarehouse pw ON p.id = pw.productid AND pw.warehouseid='.$_SESSION['warehouseid'].'
			'.$wheretables4.'
			WHERE p.active="y" AND pw.warehouseid = '.$_SESSION['warehouseid'].' AND pw.price>0 AND (pc.categoryid IS NOT NULL OR ce.categoryid != 0) 
			    '.(($user_conf["show_product_with_stack_zero"][1] == 1)? " AND pw.amount > 0 ":"").' '.$alowed_type.' AND 
				((ptr.langid = '. $_SESSION['langid']. ' OR ptr.langid IS NULL) AND (pdtr.langid = '. $_SESSION['langid']. ' OR pdtr.langid is NULL))
					'.$has_image_flag.' 
				AND  (p.code like "'.$searchstring.'%") '.$where2.'
				 '.$where3.' '.$where4.'
			UNION ALL	 
			SELECT p.id, p.name, p.code ,getDefaultImage(p.id) as `defaultimage` FROM `product` p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid 
			LEFT JOIN productcategory pc ON p.id = pc.productid
			LEFT JOIN productcategory_external pce ON p.id = pce.productid
			LEFT JOIN category_external ce ON pce.categoryid = ce.id
			LEFT JOIN product_file pf ON p.id = pf.productid AND pf.type = "img"
			LEFT JOIN productwarehouse pw ON p.id = pw.productid AND pw.warehouseid='.$_SESSION['warehouseid'].'
			'.$wheretables4.'
			WHERE p.active="y" AND pw.warehouseid = '.$_SESSION['warehouseid'].' AND pw.price>0 AND (pc.categoryid IS NOT NULL OR ce.categoryid != 0) 
			    '.(($user_conf["show_product_with_stack_zero"][1] == 1)? " AND pw.amount > 0 ":"").' '.$alowed_type.' AND
				((ptr.langid = '. $_SESSION['langid']. ' OR ptr.langid IS NULL) AND (pdtr.langid = '. $_SESSION['langid']. ' OR pdtr.langid is NULL))
					'.$has_image_flag.' 
				AND  ('.$where.') '.$where2.' '.$where4.'
				  ) as finall GROUP BY finall.id ORDER BY id DESC';
		 	//echo $q;		
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					array_push($data, $row['id']);
				}	
			}
			
			return $data;
		}
	}
	
	public static function categorySearch($searchstring){
		/*
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
			
		$tmp = explode(" ", $searchstring);
		
		if(count($tmp) > 0 && $tmp[0] != "")
		{		
			$where = "";
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$nv = $mysqli->real_escape_string($v);
	
				$where .= ' p.code like "'.$nv.'%" OR 
							p.barcode like "'.$nv.'%" OR 
							p.name like "%'.$nv.'%" OR 
							p.manufname like "%'.$nv.'%" OR 
							ptr.name like "%'.$nv.'%" OR 
							ptr.manufname like "%'.$nv.'%" OR 
							p.manufcode like "'.$nv.'%" OR 
							p.searchwords like "%'.$nv.'%" OR 
							ptr.searchwords like "%'.$nv.'%" OR 
							pd.specification like "%'.$nv.'%" OR 
							pdtr.specification like "%'.$nv.'%" OR 
							pd.model like "%'.$nv.'%" OR 
							pdtr.model like "%'.$nv.'%" OR 
							pd.characteristics like "%'.$nv.'%" OR 
							pdtr.characteristics like "%'.$nv.'%" OR 
							pd.description like "%'.$nv.'%" OR 
							pdtr.description like "%'.$nv.'%" OR ';
			}
			$where = substr($where, 0, -3);
			
			$q = 'SELECT SQL_CALC_FOUND_ROWS p.id, p.name, p.code, count(p.id) as pronum, pd.* FROM `product` p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid 
			LEFT JOIN productcategory pc ON p.id = pc.productid
			LEFT JOIN category c ON pc.categoryid = c.id
			WHERE
				((ptr.langid = '. $_SESSION['langid']. ' OR ptr.langid IS NULL) AND (pdtr.langid = '. $_SESSION['langid']. ' OR pdtr.langid is NULL))
				AND  ('.$where.') 
				 AND c.id IN ('.implode(",",GlobalHelper::getCurrentUserValidCategorys()).') 
				 GROUP BY p.id  LIMIT ' . $start . ',' . $end;
			
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					array_push($data, $row['id']);
				}	
			}
		
			return $data;
		}
		*/
	}
	
	public static function newsSearch($searchstring, $page = 1, $itemsperpage = 1){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		$data[1] = array();
		
		$start = ($page-1) * $itemsperpage;
        $end = $itemsperpage;
		
		$tmp = explode(" ", $searchstring);
		
		if(count($tmp) > 0 && $tmp[0] != "")
		{		
			$where = "";
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$nv = $mysqli->real_escape_string($v);
	
				$where .= ' n.title like "%'.$nv.'%" OR 
							ntr.title like "%'.$nv.'%" OR 
							n.body like "%'.$nv.'%" OR 
							ntr.body like "%'.$nv.'%" OR 
							n.searchwords like "%'.$nv.'%" OR 
							ntr.searchwords like "%'.$nv.'%" OR ';
			}
			$where = substr($where, 0, -3);
			
			$q = 'SELECT SQL_CALC_FOUND_ROWS n.*, ntr.title as titletr, ntr.body as bodytr, ntr.shortnews as shortnewstr, u.name, u.surname, date_format(n.adddate, \'%d-%c-%Y %T\') as adddate, n.thumb 
			FROM `news` n
			LEFT JOIN news_tr ntr ON n.id = ntr.newsid
			LEFT JOIN user u ON n.ownerid = u.id
			WHERE n.status = "v" AND
				(ntr.langid = '. $_SESSION['langid']. ' OR ntr.langid IS NULL) 
				AND  ('.$where.') 
				GROUP BY n.id  LIMIT ' . $start . ',' . $end;
            //echo $q;
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				$sQuery = "SELECT FOUND_ROWS()";
				$sRe = $mysqli->query($sQuery);
				$aRe = $sRe->fetch_array();
				$data[0] = $aRe[0];
				
				while($row = $res->fetch_assoc()){
					$title = $row['title'];
					if($row['titletr'] != NULL){
						$title = $row['titletr'];	
					}
					$shortnews = $row['shortnews'];
					if($row['shortnewstr'] != NULL){
						$shortnews = $row['shortnewstr'];	
					}
					$body = $row['body'];
					if($row['bodytr'] != NULL){
						$body = $row['bodytr'];	
					}
					$owner=$row['name']." ".$row['surname'];
					$adddate=$row['adddate'];
					
					array_push($data[1], array($row['id'], $title, $body, $shortnews,$owner,$adddate,$row['thumb']));
				}	
			}
		
			return $data;
		}	
	}
	
	public static function partnerSearch($searchstring, $page = 1, $itemsperpage = 1){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		$data[1] = array();
		
		$start = ($page-1) * $itemsperpage;
        $end = $itemsperpage;
		
		$tmp = explode(" ", $searchstring);
		
		if(count($tmp) > 0 && $tmp[0] != "")
		{		
			$where = "";
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$nv = $mysqli->real_escape_string($v);
	
				$where .= ' p.name like "%'.$nv.'%" OR 
							pt.name like "%'.$nv.'%"';
			}
			
			
			$q = 'SELECT SQL_CALC_FOUND_ROWS p.*, pt.name as partnertype FROM `partner` p
			LEFT JOIN partnertype pt ON p.partnertype = pt.id
			WHERE p.active = "y"  
				AND  ('.$where.') 
				GROUP BY p.id  LIMIT ' . $start . ',' . $end;
            //echo $q;
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				$sQuery = "SELECT FOUND_ROWS()";
				$sRe = $mysqli->query($sQuery);
				$aRe = $sRe->fetch_array();
				$data[0] = $aRe[0];
				
				while($row = $res->fetch_assoc()){
					$name = $row['name'];
					
					$partnertype = $row['partnertype'];
					
					
					array_push($data[1], array($row['id'], $name, $partnertype));
				}	
			}
		
			return $data;
		}	
	}
	
	public static function pagesSearch($searchstring, $page = 1, $itemsperpage = 1){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();

		$start = ($page-1) * $itemsperpage;
        $end = $itemsperpage;
		
		$tmp = explode(" ", $searchstring);
		
		if(count($tmp) > 0 && $tmp[0] != "")
		{		
			$where = "";
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$nv = $mysqli->real_escape_string($v);
	
				$where .= ' p.value like "%'.$nv.'%" OR 
							ptr.value like "%'.$nv.'%" ';
			}
			$where = substr($where, 0, -3);
			
			$q = 'SELECT SQL_CALC_FOUND_ROWS p.*, ptr.value as valuetr FROM `pages` p
			LEFT JOIN pages_tr ptr ON p.id = ptr.pagesid
			WHERE
				(ptr.langid = '. $_SESSION['langid']. ' OR ptr.langid IS NULL) 
				AND  ('.$where.') 
				GROUP BY p.id  LIMIT ' . $start . ',' . $end;
			
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					$value = $row['value'];
					if($row['valuetr'] != NULL){
						$value = $row['valuetr'];	
					}
					
					array_push($data, array($row['id'], $value));
				}	
			}
		
			return $data;
		}	
	}
	
	public static function documentsSearch($searchstring){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$returndata = array();

		$tmp = explode(" ", $searchstring);

		$path = realpath('fajlovi/documents');
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
		$count = 0;
		foreach($objects as $name => $object){
			if (strpos(basename($name),$searchstring) !== false) {
				$data = explode(DIRECTORY_SEPARATOR , $name);
				$link = "";
				$add = false;
				foreach($data as $value)
				{
					if($value == "fajlovi"){
						$add = true;	
					}
					if($add){
						$link .= $value.DIRECTORY_SEPARATOR;	
					}
				}
				$count++;
				$a = explode(".", basename($name));
				$showname = $a[0];
				
				$q = "SELECT * FROM documents WHERE link LIKE '".substr($link,0,-1)."'";
				$res = $mysqli->query($q);
				if($res->num_rows > 0){
					$row = $res->fetch_assoc();
					$showname = $row['showname'];	
				}
				array_push($returndata, array(substr($link,0,-1), $showname));
			}  
		}
		return array($count,$returndata);	
	}
	
	public static function fastProductSearch($searchstring, $categoryid = 0){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		global $system_conf;
		
		$data = array();

		$tmp = explode(" ", $searchstring);
		
		if(count($tmp) > 0 && $tmp[0] != "")
		{		
			$where = "";
			foreach($tmp as $k=>$v){
				if($v == "") continue;
				$nv = $mysqli->real_escape_string($v);
	
				$where .= ' (p.code like "'.$nv.'%" OR 
							p.barcode like "'.$nv.'%" OR 
							p.name like "%'.$nv.'%" OR 
							p.manufname like "%'.$nv.'%" OR 
							ptr.name like "%'.$nv.'%" OR 
							ptr.manufname like "%'.$nv.'%" OR 
							p.manufcode like "'.$nv.'%" OR 
							p.searchwords like "%'.$nv.'%" ) AND ';
			}
			$where = substr($where, 0, -4);
			
			if($categoryid != 0){
				$categoryString = 'AND (c.id IN ('.implode(',', ShopHelper::getCategoryTreeIdDown($categoryid)).') OR ce.categoryid IN ('.implode(',', ShopHelper::getCategoryTreeIdDown($categoryid)).')) AND (pc.categoryid IS NOT NULL OR ce.categoryid != 0) ';
			}else{
				$categoryString = 'AND (c.id IN ('.implode(",",GlobalHelper::getCurrentUserValidCategorys()).') OR ce.categoryid IN ('.implode(",",GlobalHelper::getCurrentUserValidCategorys()).')) AND (pc.categoryid IS NOT NULL OR ce.categoryid != 0) ';
			}
			
			$q = 'SELECT p.id, p.name, p.code, c.name as categoryname, getDefaultImage(p.id) AS `image` FROM  `product` p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productcategory pc ON p.id = pc.productid
			LEFT JOIN productcategory_external pce ON p.id = pce.productid
			LEFT JOIN category_external ce ON pce.categoryid = ce.id
			LEFT JOIN category c1 ON ce.categoryid = c1.id
			LEFT JOIN category c ON pc.categoryid = c.id
			WHERE p.active = "y" AND (c.'.$_SESSION['shoptype'].'visible != 0 OR c1.'.$_SESSION['shoptype'].'visible) AND ('.$where.')  
				 '.$categoryString.' 
				 GROUP BY p.id LIMIT 20 ';
				//echo $q; 
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
					$image=GlobalHelper::getImage('fajlovi/product/'.$row['image'], 'small');
					$row['image']=$image;
					$row['path'] = GlobalHelper::getProductLinkFromProdId($row['id']);
					array_push($data, $row);
				}	
			}
		
			return $data;
		}
		
	}
}
?>