<?php

$class_version["news"] = array('module', '1.0.0.0.1', 'Nema opisa');

class News
{
    public $id;
    public $title;
	public $shortnews;
    public $body;
    public $thumb;
    public $date;
	public $owner;
	public $category;
	public $galleryitems;

    public function __construct($id, $title, $shortnews, $body, $thumb, $date, $owner, $category, $galleryitems=array())
    {
        $this->id = $id;
        $this->title = $title;
		$this->shortnews = $shortnews;
        $this->body = $body;
        $this->thumb = $thumb;
        $this->date = $date;
		$this->owner = $owner;
		$this->category = $category;
		$this->galleryitems = $galleryitems;
    }
	
	public static function getNewsList($page, $limit, $sort=false, $searchstring = "")
    {
		/**
		*	page - trenutna strana pocinje od 1
		*	limit - broj vesti po stranici
		*	sort - nacin sortiranja - false po datumu dodavanja, true = po sort number
		*/
		global $user_conf, $theme_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $start = ($page-1) * $limit;
        $end = $limit;
        $data=array();
        $news=array();

        if($sort)
        {
            $sortingString=" ORDER BY n.`adddate` ASC limit " . $start . "," . $end;
        }else{
            $sortingString=" ORDER BY n.`adddate` DESC limit " . $start . "," . $end;
        }
		
		$lang = " and ntr.langid =". $_SESSION['langid'];
		if($theme_conf["search_all_lang"][1] == 1){
			$lang = "";	
		}
		
		$swhere = "";
		$idin = "";
		if($searchstring != ""){
			$stmp = explode(" ", $searchstring);
			$swhere = " ";
			foreach($stmp as $k=>$v){
				if($v == "") continue;
					
				$swhere .= ' ntr.title like "%'.$v.'%" OR ntr.body like "%'.$v.'%" OR ';
			}
			$swhere = substr($swhere, 0, -3);
			
			$q = "SELECT n.id FROM news n LEFT JOIN news_tr ntr ON n.id = ntr.newsid WHERE (".$swhere.") ".$lang." AND n.status = 'v' GROUP BY n.id";
			$res= $mysqli->query($q);
			if($res->num_rows > 0){
				$idin = " n.id IN (";
				$ids = array();
				while($data=$res->fetch_assoc())
				{
					array_push($ids, $data['id']);
				}
				$idin = " n.id IN (".implode(",", $ids).") AND";
			}
		}
		

        $q="SELECT SQL_CALC_FOUND_ROWS n.id, n.thumb, date_format(n.adddate, '%d-%c-%Y %T') as adddate, ntr.title, ntr.shortnews , ntr.body, u.name, u.surname FROM news n
            LEFT JOIN news_tr ntr ON n.id = ntr.newsid
			LEFT JOIN user u ON n.ownerid = u.id
            WHERE ".$idin." n.status = 'v' AND (ntr.langid =". $_SESSION['langid'] . " OR ntr.langid IS NULL)" . $sortingString;
        $res= $mysqli->query($q);
		
		$sQuery = "SELECT FOUND_ROWS()";
		$sRe = $mysqli->query($sQuery);
		$aRe = $sRe->fetch_array();
		$foundproducts = $aRe[0];

				
        if($res->num_rows > 0)
        {
          while($data=$res->fetch_assoc())
          {
			  $newscategory=array();
			  //echo $data['id'];
			  $newscategory= self::getNewsCategory($data['id']);
			  
              $news[] = new News($data['id'], $data['title'], $data['shortnews'], $data['body'], $data['thumb'], $data['adddate'], $data['name']." ".$data['surname'],$newscategory);
          }
        }

        return array($foundproducts, $news);
    }
	
	public static function getNews($id)
    {
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $news=array();
        $data=array();

			
		$q = "(
				SELECT n.id, n.thumb, ntr.shortnews, n.galleryid, date_format(n.adddate, '%d-%c-%Y %T') as adddate, ntr.title, ntr.body, u.name, u.surname
				FROM news n
				LEFT JOIN news_tr ntr ON n.id = ntr.newsid
				LEFT JOIN user u ON n.ownerid = u.id
				WHERE n.status = 'v' and n.id < ". $id ." and (ntr.langid=".$_SESSION['langid']." OR ntr.langid IS NULL) ORDER BY id DESC LIMIT 1
				)
				UNION
				(
					SELECT n.id, n.thumb, ntr.shortnews, n.galleryid, date_format(n.adddate, '%d-%c-%Y %T') as adddate, ntr.title, ntr.body, u.name, u.surname
					FROM news n
					LEFT JOIN news_tr ntr ON n.id = ntr.newsid
					LEFT JOIN user u ON n.ownerid = u.id
					WHERE n.status = 'v' and n.id = ". $id ." and (ntr.langid=".$_SESSION['langid'] ." OR ntr.langid IS NULL)
				)
				UNION
				(
					SELECT n.id, n.thumb, ntr.shortnews, n.galleryid, date_format(n.adddate, '%d-%c-%Y %T') as adddate, ntr.title, ntr.body, u.name, u.surname
					FROM news n
					LEFT JOIN news_tr ntr ON n.id = ntr.newsid
					LEFT JOIN user u ON n.ownerid = u.id
					WHERE n.status = 'v' and n.id > ". $id ." and (ntr.langid=".$_SESSION['langid']." OR ntr.langid IS NULL) ORDER BY id ASC LIMIT 1
				
				)";
				
        $res = $mysqli->query($q);

        if($res)
        {
            if($res->num_rows > 0)
            {
                while($data = $res->fetch_assoc()){
					$newscategory=array();
					$newscategory= self::getNewsCategory($data['id']);
					if($data['id'] < $id){
						$news['pre'] = new News ($data['id'], $data['title'], $data['shortnews'], $data['body'], $data['thumb'], $data['adddate'], $data['name']." ".$data['surname'],$newscategory);
					}
					if($data['id'] == $id){
						include_once('GalleryItem.php');
						$items = GalleryItem::GetGalleryItems($data['galleryid'], 1, 50);
						$news['main'] = new News ($data['id'], $data['title'], $data['shortnews'], $data['body'], $data['thumb'], $data['adddate'], $data['name']." ".$data['surname'],$newscategory, $items);
					}
					if($data['id'] > $id){
						$news['next'] = new News ($data['id'], $data['title'], $data['shortnews'], $data['body'], $data['thumb'], $data['adddate'], $data['name']." ".$data['surname'],$newscategory);
					}
				} 
            }
        }

        return $news;
    }
	
	function cmp($a, $b)
	{
		if ($a[1] == $b[1]) {
			return 0;
		}
		return ($a[1] < $b[1]) ? -1 : 1;
	}
			
	
	public static function getAllTags(){
		 $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT n.searchwords as searchwords, ntr.searchwords as searchwordstr FROM news n 
		LEFT JOIN news_tr ntr ON n.id = ntr.newsid";	
		
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$sw = $row['searchwords'];
				if($row['searchwordstr'] != NULL) $sw = $row['searchwordstr']; 
				$tmp = explode("|", $sw);
				
				foreach($tmp as $key=>$val){
					$insert = false;
					for($i = 0; $i < count($data); $i++)
					{
						if($data[$i][0] == $val){
							$data[$i][1] += 1;
							$insert = true;
						}						
					}
					
					if(!$insert){
						array_push($data, array($val, 1));	
					}
				}
			}
			
			
			usort($data,function ($a, $b){
						if ($a[1] == $b) {
							return 0;
						}
						return ($a[1] > $b[1]) ? -1 : 1;
					});
			
			return $data;
		}
	}
	
	public static function getNewsCategory($newsid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		$newscategory = array();
		
		$q = "SELECT nc.id, 
		             nc.name, 
					 nc.parentid, 
					 nc.description, 
					 nc.icon, 
					 nc.color, 
					 nc.visible, 
					 nc.sort,
					 nctr.name AS `nametr`,
					 nctr.description AS `descriptiontr`
			  FROM newscategorynews AS ncn 
			LEFT JOIN newscategory AS nc ON ncn.newscategoryid = nc.id
			LEFT JOIN newscategory_tr AS nctr ON ncn.newscategoryid = nctr.newscategoryid
			WHERE ncn.newsid=".$newsid."
			  AND nc.`visible`='v'
			  AND (nctr.langid =". $_SESSION['langid'] . " OR nctr.langid IS NULL)
			ORDER BY ncn.newscategoryid ASC";
			
		$res = $mysqli->query($q);

        if($res)
        {
            if($res->num_rows > 0)
            {
                while($data = $res->fetch_assoc()){
					$name=$data['name'];
					if($data['nametr'] != '' and $data['nametr'] != NULL){
						$name=$data['nametr'];
					}
					$description=$data['description'];
					if($data['descriptiontr'] != '' and $data['descriptiontr'] != NULL){
						$name=$data['descriptiontr'];
					}
					array_push($newscategory, array('newscategoryid'=>$data['id'],
					                                'name'=>$name,
													'parentid'=>$data['parentid'],
													'description'=>$description,
													'icon'=>$data['icon'],
													'color'=>$data['color'],
													'visible'=>$data['visible'],
													'sort'=>$data['sort']
													)
							  );
				} 
            }
        }

        return $newscategory;
		
			
	}
	
	/*public static function getNewsCategoryFile($id){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT n.searchwords as searchwords, ntr.searchwords as searchwordstr FROM news n 
		LEFT JOIN news_tr ntr ON n.id = ntr.newsid";
		
			
	}*/
	


}
?>