<?php

$class_version["slider"] = array('class', '1.0.0.0.1', 'Nema opisa');

class Slider
{
    public $id;
    public $name;
    public $img;
    public $description;
    public $position;
    public $info_position;
    public $show_info;

    public function __construct($id, $name, $img, $description, $position,$info_position,$show_info)
    {
        $this->id=$id;
        $this->name=$name;
        $this->img=$img;
        $this->description=$description;
        $this->position=$position;
        $this->info_position=$info_position;
        $this->show_info=$show_info;
    }
	public static function GetSliderListById($GalleryId){

    	$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

		global $user_conf;		
		
		$sliders = array();
		
		$query="SELECT gi.* FROM galleryitem gi 
		LEFT JOIN gallery g ON gi.galleryid = g.id
		WHERE g.id = ".$GalleryId." AND gi.type = 'img' ORDER BY gi.sort ASC";
		$res = $mysqli->query($query);
		if($res && $res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				array_push($sliders, array("item"=>$row['item'], "link"=>$row['link'], "title"=>$row['title']));
			}
		}
		return $sliders;
	}
	
    public static function GetSliderListByPosition($position, $page = 1, $limit = 0){
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

        global $theme_conf;

        $sliders = array();
        $querylimit = '';
        if($limit !=0 && $theme_conf["show_all_sliders_list"]['1'] !=1){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = "LIMIT ".$start.", ".$end;
        }


        $query = "select SQL_CALC_FOUND_ROWS g.id, gtr.name, gtr.description, g.img, g.position, g.info_position, g.show_info, (select item from galleryitem where galleryid = g.id order by rand() limit 1) as ri
        from gallery as g
        LEFT JOIN gallery_tr as gtr ON g.id = gtr.galleryid
        where g.position = '".$position."' and g.status = 'v' and gtr.langid = ". $_SESSION['langid']."
        ORDER BY g.sort asc ".$querylimit;

        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundproducts = $aRe[0];


        while($row = $res->fetch_assoc()){
            $img = $row['img'];
            if($user_conf['gallery_random_image'][1] == '1'){
                if($row['ri'] != '' && $row['ri'] != 'NULL'){
                    $img = $row['ri'];
                }
                else{
                    $img = $user_conf['no_img'][1];
                }
            }
            array_push($sliders, new Slider($row['id'], $row['name'], $img, $row['description'], $row['position'], $row['info_position'], $row['show_info']));

        }

        return array($foundproducts, $sliders);

    }

    /**
     * @param $id
     * @return array(img, name, description)
     */
    public static function getSliderInfo($id){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");


        $query = "select g.img,
                    case when gtr.name = '' or gtr.name is NULL THEN g.name ELSE gtr.name END as name,
                    case when gtr.description = '' or gtr.description is NULL THEN g.description ELSE gtr.description END as description
                  from gallery as g left join gallery_tr as gtr on g.id = gtr.galleryid
                  where g.id = ".$id." and (langid = ".$_SESSION['langid']." or langid is NULL)";

        $res = $mysqli->query($query);
        if($res){
            if($res->num_rows > 0){
                return $res->fetch_assoc();
            }
        }
        return 0;
    }
    public static function getSliderIdFromName($sliderName){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $query = "select id from gallery where name like '".$sliderName."'";
        $res = $mysqli->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            return $row['id'];
        }
        else{
            return 0;
        }
    }

}