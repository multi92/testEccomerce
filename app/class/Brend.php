<?php
$module_version["brend"] = array('module', '1.0.0.0.1', 'Nema opisa');
class Brend{

	public $id;
	public $name;
	public $hasimage;
	public $image;
	public $status;
	public $sort;
	public $link;
	public $linktarget;

	public function __construct($id,$name,$hasimage,$image,$status,$sort,$link,$linktarget){
		$this->id = $id;
		//$data = self::getData();
		//$this->id = $data['id'];
		$this->name = $name;
		$this->hasimage = $hasimage;
		$this->image = $image;
		$this->status = $status;
		$this->sort = $sort;
		$this->link = $link;
		$this->linktarget = $linktarget;
		
	}

   public static function GetBrendList(){
        /**
         * $position - pozicija galerija
         * $page - stranica lista galerije, stranica pocinje od 1
         * $limit - broj galerije na stranici, 0 - no limit
         *
         * return - niz 0-broj ukupnih elemenata bez ogranicenja, 1-niz objekta tipa Gallery
        */
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $system_conf, $user_conf, $theme_conf;

        $Brends = array();
        $querylimit = '';
        


        $query = "SELECT SQL_CALC_FOUND_ROWS b.id, b.name, b.image, b.status, b.sort, b.link, b.link_target
					FROM brend as b
				  ORDER BY b.sort asc ";
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundBrends = $aRe[0];

        while($row = $res->fetch_assoc()){
        	$hasImage=1;
            $iimg = $row['image'];
			if($iimg == '' || $iimg == NULL){
				$iimg = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
				$hasImage=0;
			}
            array_push($Brends, new Brend($row['id'], 
											  $row['name'], 
											  $hasImage,
											  $iimg, 
											  $row['status'], 
											  $row['sort'],
											  $row['link'],
											  $row['link_target']
											)
					  );

        }
        return array($foundBrends, $Brends);

    }


    public static function GetBrendCategories($brendlist=array()){
        /**
         * $position - pozicija galerija
         * $page - stranica lista galerije, stranica pocinje od 1
         * $limit - broj galerije na stranici, 0 - no limit
         *
         * return - niz 0-broj ukupnih elemenata bez ogranicenja, 1-niz objekta tipa Gallery
        */
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $system_conf, $user_conf, $theme_conf;

        $categories = array();
        $querylimit = '';
        


        $query = "SELECT getCategoryRootId(pc.categoryid) AS `cat`
					FROM product AS p
					LEFT JOIN productcategory AS pc ON p.id=pc.productid 
					LEFT JOIN category AS cat ON pc.categoryid=cat.id
					WHERE pc.productid IS NOT NULL AND  p.brendid>0 AND pc.categoryid IS NOT NULL AND p.brendid IN (".implode(',', $brendlist).") 
					AND cat.".$_SESSION["shoptype"]."visible=1 
					GROUP BY `cat`";
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundCategories = $aRe[0];

        while($row = $res->fetch_assoc()){
        	
            array_push($categories, array('catid'=>$row['cat'])
					  );

        }
        return array($foundCategories, $categories);

    }

}


?>