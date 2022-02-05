<?php
$class_version["deliveryservice"] = array('module', '1.0.0.0.1', 'Nema opisa');

class DeliveryService{

	public $id;
	public $active;
	public $code;
	public $name;
	public $phone;
	public $email;
	public $address;
	public $city;
	public $zip;
	public $description;
	public $website;
	public $deliverytracklink;
	public $img;
	public $sort;

	
	public function __construct($id,$active,$code,$name,$phone,$email,$address,$city,$zip,$description,$website,$deliverytracklink,$img,$sort){
		$this->id = $id;
		$this->active = $active;
		$this->code = $code;
		$this->name = $name;
		$this->phone = $phone;
		$this->email = $email;
		$this->address = $address;
		$this->city = $city;
		$this->zip = $zip;
		$this->description = $description;
		$this->website = $website;
		$this->deliverytracklink = $deliverytracklink;
		$this->img = $img;
		$this->sort = $sort;
		
	}

   public static function getDeliveryService(){

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $user_conf;

        $DeliveryServices = array();
        $querylimit = '';
        


        $query = "SELECT SQL_CALC_FOUND_ROWS ds.* , dstr.name AS nametr, dstr.description AS descriptiontr
					FROM deliveryservice as ds
					LEFT JOIN deliveryservice_tr AS dstr ON ds.id = dstr.deliveryserviceid
				  WHERE (dstr.langid = ". $_SESSION['langid']. " OR dstr.langid IS NULL) AND ds.status = 'v'
				  ORDER BY ds.sort ASC ";
				  
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundDeliveryServices = $aRe[0];

        while($row = $res->fetch_assoc()){
            $name = $row['name'];
			if($row['nametr'] != NULL){
				$name = $row['nametr'];
			}
			$description = $row['description'];
			if($row['descriptiontr'] == '' || $row['descriptiontr'] == NULL){
				$description = $row['descriptiontr'];
			}
            array_push($DeliveryServices, new DeliveryService($row['id'],
												$row['active'],
												$row['code'],
												$name,
												$row['phone'],
												$row['email'],
												$row['address'],
												$row['city'],
												$row['zip'],
												$description,
												$row['website'],
												$row['deliverytracklink'],
												$row['img'],
												$row['sort']											
					  ));

        }
		
        return array($foundDeliveryServices, $DeliveryServices);

    }



   public static function getDeliveryServiceById($deliveryserviceid){

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $user_conf;

        $DeliveryServices = array();
        $querylimit = '';
        


        $query = "SELECT SQL_CALC_FOUND_ROWS ds.* , dstr.name AS nametr, dstr.description AS descriptiontr
					FROM deliveryservice as ds
					LEFT JOIN deliveryservice_tr AS dstr ON ds.id = dstr.deliveryserviceid
				  WHERE ds.id=".$deliveryserviceid." AND (dstr.langid = ". $_SESSION['langid']. " OR dstr.langid IS NULL)
				  ORDER BY ds.sort ASC ";
				
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundDeliveryServices = $aRe[0];

        while($row = $res->fetch_assoc()){
            $name = $row['name'];
			if($row['nametr'] == '' || $row['nametr'] == NULL){
				$name = $row['nametr'];
			}
			$description = $row['description'];
			if($row['descriptiontr'] == '' || $row['descriptiontr'] == NULL){
				$description = $row['descriptiontr'];
			}
            array_push($DeliveryServices, new DeliveryService($row['id'],
												$row['active'],
												$row['code'],
												$name,
												$row['phone'],
												$row['email'],
												$row['address'],
												$row['city'],
												$row['zip'],
												$description,
												$row['website'],
												$row['deliverytracklink'],
												$row['img'],
												$row['sort']											
					  ));

        }
		
        return array($foundDeliveryServices, $DeliveryServices);

    }

    public static function getDeliveryServiceAssocById($deliveryserviceid){

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $user_conf;

        $DeliveryServices = array();
        $querylimit = '';
        


        $query = "SELECT ds.* , dstr.name AS nametr, dstr.description AS descriptiontr
					FROM deliveryservice as ds
					LEFT JOIN deliveryservice_tr AS dstr ON ds.id = dstr.deliveryserviceid
				  WHERE ds.id=".$deliveryserviceid." AND (dstr.langid = ". $_SESSION['langid']. " OR dstr.langid IS NULL)
				  ORDER BY ds.sort ASC ";
				
				  
        $result=$mysqli->query($query);

       	$row = 0;
        if($result->num_rows >0) {
            $row = $result->fetch_assoc();

			if($row['nametr'] != '' || $row['nametr'] != NULL){
				$row['name'] = $row['nametr'];
			}
			if($row['descriptiontr'] != '' || $row['descriptiontr'] != NULL){
				$row['description'] = $row['descriptiontr'];
			}
            
        }

        return $row;
    }

}


?>