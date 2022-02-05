<?php

$class_version["person"] = array('module', '1.0.0.0.1', 'Nema opisa');

class Person
{
    public $id;
    public $name;
    public $description;
    public $shopid;
    public $phone;
    public $title;
    public $picture;
    public $email;
	public $haveSocialNetworks;
	public $socialnetworksdata;

    public function __construct($id, $name, $description, $shopid, $phone, $title, $pitcture, $email, $haveSocialNetworks, $socialnetworksdata){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->shopid = $shopid;
        $this->phone = $phone;
        $this->title = $title;
        $this->picture = $pitcture;
        $this->email = $email;
		$this->haveSocialNetworks = Person::haveSocialNetworks($id);
		$this->socialnetworksdata = Person::getSocialNetworks($id);
    }
	
	public static function haveSocialNetworks($personid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select count(id) as num from socialnetworkitem where foreigntable='person' AND foreignkey = ".$personid;

		if($res=$mysqli->query($query)){
			if($res->num_rows > 0){
				$r = $res->fetch_assoc();
				$r = $r['num'];
				if($r > 0){
					return true;
				}
			}
		}
		return false;
	}	

	public static function getSocialNetworks($personid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$data = array();

		
		$query = "SELECT sni.id AS `socialnetworkitemid`, sni.socialnetworkid,sni.foreigntable,sni.foreignkey,sni.link,
					sni.`status` AS `snistatus`,sni.sort AS `snisort`,sn.name,sn.icon,
					sn.`status` AS `snstatus` ,sn.sort AS `snsort`
					FROM socialnetworkitem AS sni 
				  LEFT JOIN socialnetwork AS sn ON sni.socialnetworkid=sn.id
				  WHERE sni.foreigntable='person'
					AND sni.foreignkey=".$personid."
					AND sni.`status`='v'
				  ORDER BY sni.sort ASC";
				  
		$res = $mysqli->query($query);
		
		if($res && $res->num_rows > 0)
		{
			while($datarow=$res->fetch_assoc())
			{
				$sndata = array('socialnetworkitemid' => $datarow['socialnetworkitemid'],
                 				'socialnetworkid' => $datarow['socialnetworkid'],
								'foreigntable' => $datarow['foreigntable'],
								'foreignkey' => $datarow['foreignkey'],
								'link' => $datarow['link'],
								'snistatus' => $datarow['snistatus'],
								'snisort' => $datarow['snisort'],
								'name' => $datarow['name'],
								'icon' => $datarow['icon'],
								'snstatus' => $datarow['snstatus'],
								'snsort' => $datarow['snsort'],
								);
				
				if($sndata['icon'] == '' || $sndata['icon'] == NULL){
					$sndata['icon'] = 'fajlovi/noimg.jpg';
				}
				$data[]=$sndata;
			}

		}
		return $data;
	}

    public static function getAllPersons($page = 1, $limit = 0){
        
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		global $user_conf;
		
        $persons = array();		
		$querylimit = '';
		if($limit !=0 ){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = "LIMIT ".$start.", ".$end;
        }

        $query = "select id from person WHERE status = 'v' ORDER BY sort ASC ".$querylimit;
		//echo $query;
        $res = $mysqli->query($query);
		
		$sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundpersons = $aRe[0];

        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                array_push($persons, self::getPersonById($row['id']));
            }
            //return $persons;
        }
		//var_dump($persons);
		return array($foundpersons, $persons);
    }
	
    public static function getPersonsByShops(){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $personsbyshop = array();
        $shops = Shop::getList();
        foreach ($shops[1] as $shop) {
            $query = "select id from person where shopid = ".$shop->id;
            $res = $mysqli->query($query);
            $shoppersons = array();
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                     array_push($shoppersons, self::getPersonById($row['id']));
                }
            }
            array_push($personsbyshop, array('shop' => $shop->name, 'persons' => $shoppersons));
        }
        return $personsbyshop;

    }

    private static function getPersonById($id){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $query = "select p.id, p.name, p.description , ptr.description as descriptiontr, p.shopid, p.phone, p.title, p.picture, p.email 
				 FROM person as p
                 LEFT JOIN person_tr as ptr ON p.id = ptr.personid				 
				 WHERE p.id = '".$id."' AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL)";
        $res = $mysqli->query($query);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            if(!file_exists($row['picture'])){
                $row['picture'] = 'fajlovi/person.png';
            }
			$desc = $row['description'];
			if($row['descriptiontr'] != '' && $row['descriptiontr'] != NULL){
				$desc = $row['descriptiontr'];
			}
            return new Person($row['id'], $row['name'], $desc, $row['shopid'], $row['phone'], $row['title'], $row['picture'], $row['email'], self::haveSocialNetworks($row['id']), self::getSocialNetworks($row['id']));
        }
        else{
            return -1;
        }

    }
}