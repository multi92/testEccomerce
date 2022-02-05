<?php
$class_version["newscategory"] = array('module', '1.0.0.0.1', 'Nema opisa');

class NewsCategory{
	public $id;
	public $parentid;
	public $name;
	public $description;
	public $image;
	public $path;
	public $color;
	public $icon;
	
	public function __construct($id, $parentid, $name, $description, $image, $path, $color, $icon){
		$this->id=$id;
		$this->parentid=$parentid;
		$this->name=$name;
		$this->description=$description;
		$this->image=$image;
		$this->path=$path;
		$this->color=$color;
		$this->icon=$icon;
	}

	/**
	 * @param $catid
	 * @return Category object ili '0' if category with this id not exist
     */
	public static function getNewsCategoryData($newscatid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		global $user_conf, $system_conf, $theme_conf;
		$query = "SELECT c.id, 
		                 c.parentid, 
						 c.name, 
						 c.description, 
						 ctr.name as name_tr, 
						 ctr.description as description_tr, 
						 c.icon,
						 c.color,
						 c.visible,
						 c.sort,
						 cf.content as img 
				  FROM newscategory as c
					LEFT JOIN newscategory_tr as ctr ON c.id = ctr.newscategoryid
					LEFT JOIN newscategory_file as cf ON c.id = cf.newscategoryid
				  WHERE c.id = ".$newscatid." AND (ctr.langid = ". $_SESSION['langid']. " OR ctr.langid is null) AND (cf.type = 'img' OR cf.type is NULL)";
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
			if($row['img'] == NULL){
				$row['img'] = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
			}

			return new NewsCategory($row['id'], $row['parentid'], $name, $description, $row['img'], self::getNewsCategoryPath($row['id']), $row['color'], $row['icon']);
		}
		return 0;
	}
	
	public static function getAllNews($extradetail = array()){
	
		/**
		*	$extradetail array of extradetailid
		*/
		
		global $user_conf, $theme_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		//	$categorylist id kategorija u kojima se sve trazi proizvod
		
		$categorylist = array();
		$q = "SELECT id FROM newscategory WHERE parentid = 0";
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				array_push($categorylist, $row['id']);	
				array_merge($categorylist, ShopHelper::getNewsCategoryTreeIdDown($row['id']));
			}
		}
		
		$q = "SELECT pc.newsid FROM newscategorynews pc ";
			$q .= "WHERE pc.newscategoryid IN (".implode(',', $categorylist).") GROUP BY pc.newsid";
			
		$res = $mysqli->query($q);

		$newslist = array();
		while($row = $res->fetch_assoc()){
			array_push($newslist, $row['newsid']);
		}	
		
		
		return $newslist;
	}
	
	
	public static function getCategoryNews($catid, $sub = true ){

		global $user_conf, $system_conf,$theme_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
				
		$categorylist = array();		
				
		// $sub if true = get all subcat products, false = get only child products
		
		//	$categorylist id kategorija u kojima se sve trazi proizvod
		if($sub){
			
			$categorylisttemp = ShopHelper::getNewsCategoryTreeIdDown($catid);
			
			if($system_conf["news_category_type"][1] == 1){
				$q = "SELECT id FROM newscategory_external WHERE newscategoryid IN (".implode(',',$categorylisttemp).")";
				$catres = $mysqli->query($q);
				while($catrow = $catres->fetch_assoc()){
					array_push($categorylist, $catrow['id']);	
				}
				
			}else{
				$categorylist = ShopHelper::getNewsCategoryTreeIdDown($catid);
			}
		}else{
			if($system_conf["news_category_type"][1] == 1){
				$q = "SELECT id FROM newscategory_external WHERE newscategoryid = ".$catid;
				$catres = $mysqli->query($q);
				while($catrow = $catres->fetch_assoc()){
					array_push($categorylist, $catrow['id']);
				}
			}else{
				$categorylist = array($catid);
			}
		}
		
		$where = "";
		
		$q = "SELECT pc.newsid FROM newscategorynews pc";
		$q .= " WHERE pc.newscategoryid IN (".implode(',', $categorylist).") GROUP BY pc.newsid";
		
		//echo $q;
		$res = $mysqli->query($q);
        
		$newslist = array();
		if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			array_push($newslist, $row['newsid']);
		}
		}

		return $newslist;
	}
	
	public static function getNewsCategoryNewsDetail($newslist = array(), $page = 1, $itemsperpage = 1 , $search = '', $sort = "DESC", $sortby = "adddate",  $action = false ){
		
		/*
		*	$extradetail array of extradetailid
		*/
		
		global $user_conf,$system_conf,$theme_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		$data = array();
		$data[0] = 0;
		$data[1] = array();

		$productlist = $newslist;

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
									WHEN ptr.title > '' THEN ptr.title
									ELSE p.title
							   END like '%".$v."%'
							   OR
							   CASE
									WHEN ptr.searchwords > '' THEN ptr.searchwords
									ELSE p.searchwords
							   END like '%".$v."%'
						   ) OR ";
			}
			$wheresearch = " AND (".substr($wheresearchtmp, 0, -3).")";
		}

		$having = '';
		
		$sortstring = '';
			if($sortby == 'adddate'){
				$sortstring = ' adddate ';	
			}elseif($sortby == 'random'){
				$sortstring = ' RAND() ';
				$sort = '';
			}else{
				$sortstring = ' p.name ';
			}
			
			$start = ($page-1) * $itemsperpage;
        	$end = $itemsperpage;
		
		$q = "CREATE TEMPORARY TABLE tmptable(
				id INT DEFAULT NULL,
				`title` VARCHAR(256) NOT NULL COLLATE 'utf8_unicode_ci',
				`titletr` VARCHAR(256) NOT NULL COLLATE 'utf8_unicode_ci',
				`body` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`bodytr` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`shortnews` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`shortnewstr` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`thumb` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`searchwords` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`searchwordstr` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
				`adddate` DATETIME NOT NULL,
				`changedate` DATETIME NOT NULL,
				`sort` INT(11) NOT NULL,
				`status` VARCHAR(16) NOT NULL COLLATE 'utf8_unicode_ci',
				`ownerid` INT(11) NOT NULL,
				`ownerfirstname` VARCHAR(256) NOT NULL COLLATE 'utf8_unicode_ci',
				`ownerlastname` VARCHAR(256) NOT NULL COLLATE 'utf8_unicode_ci'
		)";
		$res = $mysqli->query($q);

			$q = "INSERT INTO tmptable (id, title, titletr, body, bodytr, shortnews, shortnewstr, thumb, searchwords, searchwordstr, adddate, changedate, sort, status, ownerid, ownerfirstname,ownerlastname) 
				SELECT p.id, 
				p.title, 
				ptr.title AS titletr, 
				p.body, 
				ptr.body as bodytr, 
				p.shortnews, 
				ptr.shortnews as shortnewstr,
				p.thumb ,
				p.searchwords,
				ptr.searchwords AS searchwordstr,
				p.adddate,
				p.changedate,
				p.sort,
				p.status,
				p.ownerid,
				u.name AS `ownerfirstname`,
				u.surname AS `ownerlastname`
			FROM news p
			LEFT JOIN news_tr ptr ON p.id = ptr.newsid		
			LEFT JOIN newscategorynews pc ON p.id = pc.newsid
			LEFT JOIN user u ON p.ownerid = u.id
			WHERE  p.id IN (".implode(',', $newslist).") AND p.`status` = 'v' 
			
			AND ((ptr.langid = ". $_SESSION['langid']. " OR ptr.langid IS NULL OR ptr.langid = 1) )
			
			".$wheresearch."
			GROUP BY p.id
			
			ORDER BY ".$sortstring." ".$sort." ";
		
		$mysqli->query($q);
		
		$q = "SELECT SQL_CALC_FOUND_ROWS * FROM tmptable ".$having." LIMIT " . $start . "," . $end;

		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			$sQuery = "SELECT FOUND_ROWS()";
			$sRe = $mysqli->query($sQuery);
			$aRe = $sRe->fetch_array();
			$data[0] = $aRe[0];
			
			while($row = $res->fetch_assoc()){
	/*			if($theme_conf["category_type"][1]==1){
					
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
					$newscategory=array();
					$newscategory= News::getNewsCategory($row['id']);
					array_push($data[1], new News($row['id'], $row['title'], $row['shortnews'], $row['body'], $row['thumb'], $row['adddate'], $row['ownerfirstname']." ".$row['ownerlastname'],$newscategory));					
			}
		}
		
		/*	empty temorary table	*/
		$q = "TRUNCATE TABLE tmptable";
		$mysqli->query($q);
		
		return $data;
	}
	
	public static function getNewsCategoryImages($newscatid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$cont = array();
		
		$q = "SELECT * FROM newscategory_file AS ncf
			  WHERE ncf.newscategoryid = ".$newscatid." AND ncf.`type`='img' AND ncf.`sort`=0 ORDER BY ncf.id ASC";	
			
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			$attrname = "";
			
			while($row = $res->fetch_assoc()){
				array_push($cont, array('id' => $row['id'], 'newscategoryid' => $row['newscategoryid'], 'type' => $row['type'], 'content' => $row['content'], 'contentface' => $row['contentface'], 'sort' => $row['sort'], 'status' => $row['status']));
			}
		}
		return $cont;
	}
	
	
	public static function getNewsCategoryPath($catid){
		$data = ShopHelper::getNewsCategoryTreeUp($catid);
		$string = '';
		$data = array_reverse($data);
		foreach($data as $k=>$v){
			$string .= rawurlencode($v['name']).DIRECTORY_SEPARATOR;
		}
		return substr($string, 0, -1);
	}

	


	/**
	 * @param $catid
	 * @return array of object Category
	 */
	public static function getNewsChildCats($catid){
		$chieldCats = ShopHelper::getNewsCategoryChild($catid);
		$cats = array();
		foreach ($chieldCats as $cat) {
			array_push($cats, NewsCategory::getNewsCategoryData($cat['id']));
		}
		return $cats;

	}

	public static function getNewsAllCatsId(){
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