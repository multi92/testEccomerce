<?php

$class_version["partner"] = array('module', '1.0.0.0.1', 'Nema opisa');

class Partner{

	public $id;
	public $active;
	public $address;
	public $city;
	public $contactperson;
	public $description;
	public $fax;
	public $name;
	public $partnertype;
	public $phone;
	public $zip;
	public $code;
	public $number;
	public $email;
	public $valutedays;
	public $rebatepercent;
	public $creditlimit;
	public $userid;
	public $website;
	public $haveSocialNetworks;
	public $socialnetworksdata;
	public $img;
	public $partneraddress;
	public $partnercontact;
	
	public function __construct($id,$active,$address,$city,$contactperson,$description,$fax,$name,$partnertype,$phone,$zip,$code,$number,$email,$valutedays,$rebatepercent,$creditlimit,$userid,$website,$haveSocialNetworks,$socialnetworksdata,$img,$partneraddress,$partnercontact){
		$this->id = $id;
		//$data = self::getData();
		//$this->id = $data['id'];
		$this->active = $active;
		$this->address = $address;
		$this->city = $city;
		$this->contactperson = $contactperson;
		$this->description = $description;
		$this->fax = $fax;
		$this->name = $name;
		$this->partnertype = $partnertype;
		$this->phone = $phone;
		$this->zip = $zip;
		$this->code = $code;
		$this->number = $number;
		$this->email = $email;
		$this->valutedays = $valutedays;
		$this->rebatepercent = $rebatepercent;
		$this->creditlimit = $creditlimit;
		$this->userid = $userid;
		$this->website = $website;
		$this->haveSocialNetworks = Partner::haveSocialNetworks($id);
		$this->socialnetworksdata = Partner::getSocialNetworks($id);
		$this->img = $img;
		$this->partneraddress = Partner::getPartnerAddress($id);
		$this->partnercontact = Partner::getPartnerContact($id);
	}
	
	public static function haveSocialNetworks($partnerid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select count(id) as num from socialnetworkitem where foreigntable='partner' AND foreignkey = ".$partnerid;

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

	public static function getSocialNetworks($partnerid){

		global $system_conf, $theme_conf;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$data = array();

		
		$query = "SELECT sni.id AS `socialnetworkitemid`, sni.socialnetworkid,sni.foreigntable,sni.foreignkey,sni.link,
					sni.`status` AS `snistatus`,sni.sort AS `snisort`,sn.name,sn.icon,
					sn.`status` AS `snstatus` ,sn.sort AS `snsort`
					FROM socialnetworkitem AS sni 
				  LEFT JOIN socialnetwork AS sn ON sni.socialnetworkid=sn.id
				  WHERE sni.foreigntable='partner'
					AND sni.foreignkey=".$partnerid."
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
								'snsort' => $datarow['snsort']
								);
				
				if($sndata['icon'] == '' || $sndata['icon'] == NULL){
					$sndata['icon'] = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
				}
				$data[]=$sndata;
			}

		}
		return $data;
	}

	public static function getPartnerAddress($partnerid){

		global $system_conf, $theme_conf;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$data = array();

		
		$query = "SELECT padd.id, padd.objectname, padd.address, padd.city, padd.zip, padd.deliverycode, padd.region, padd.objecttype, padd.salessource
					FROM partneraddress AS padd 
				  WHERE padd.partnerid=".$partnerid."
				  ORDER BY padd.objectname ASC";
				  
		$res = $mysqli->query($query);
		
		if($res && $res->num_rows > 0)
		{
			while($datarow=$res->fetch_assoc())
			{
				$sndata = array('partneraddressid' => $datarow['id'],
                 				'objectname' => $datarow['objectname'],
								'address' => $datarow['address'],
								'city' => $datarow['city'],
								'zip' => $datarow['zip'],
								'deliverycode' => $datarow['deliverycode'],
								'region' => $datarow['region'],
								'objecttype' => $datarow['objecttype'],
								'salessource' => $datarow['salessource']
								);
				
				$data[]=$sndata;
			}

		}
		return $data;
	}

	public static function getPartnerAddressByPartnerAadressId($partnerid, $partneraddressid){

		global $system_conf, $theme_conf;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$data = array();

		
		$query = "SELECT padd.id, padd.objectname, padd.address, padd.city, padd.zip, padd.deliverycode, padd.region, padd.objecttype, padd.salessource
					FROM partneraddress AS padd 
				  WHERE padd.partnerid=".$partnerid." AND padd.id=".$partneraddressid."
				  ORDER BY padd.objectname ASC";
				  
		$res = $mysqli->query($query);
		
		if($res && $res->num_rows > 0)
		{
			while($datarow=$res->fetch_assoc())
			{
				$sndata = array('partneraddressid' => $datarow['id'],
                 				'objectname' => $datarow['objectname'],
								'address' => $datarow['address'],
								'city' => $datarow['city'],
								'zip' => $datarow['zip'],
								'deliverycode' => $datarow['deliverycode'],
								'region' => $datarow['region'],
								'objecttype' => $datarow['objecttype'],
								'salessource' => $datarow['salessource']
								);
				
				$data[]=$sndata;
			}

		}
		return $data[0];
	}

	public static function getPartnerContact($partnerid){

		global $system_conf, $theme_conf;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$data = array();

		
		$query = "SELECT pc.id, pc.firstname, pc.lastname, pc.position, pc.phone, pc.email, pc.note
					FROM partnercontact AS pc 
				  WHERE pc.partnerid=".$partnerid."
				  ORDER BY pc.firstname ASC, pc.lastname ASC";
				  
		$res = $mysqli->query($query);
		
		if($res && $res->num_rows > 0)
		{
			while($datarow=$res->fetch_assoc())
			{
				$sndata = array('partnercontactid' => $datarow['partnercontactid'],
                 				'firstname' => $datarow['firstname'],
								'lastname' => $datarow['lastname'],
								'position' => $datarow['position'],
								'phone' => $datarow['phone'],
								'email' => $datarow['email'],
								'note' => $datarow['note']
								);
				$data[]=$sndata;
			}

		}
		return $data;
	}

	public function getPictures(){

		global $system_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$arrayimg = array();

		$q="select content,attrvalid,sort from product_file where productid=".$this->id." AND type = 'img' ORDER BY sort ASC";
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($img=$res->fetch_assoc())
			{
				$arrayimg[]=$img['content'];
			}

		}else{
			$arrayimg[]= $system_conf["theme_path"][1].$theme_conf["no_img"][1];
		}

		return $arrayimg;
	}
	
	public static function getPartnerData($id){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		
		$q = "SELECT p.* FROM  partner p 
			WHERE p.id = ".$id;
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$data['id'] = $row['id'];
				$data['address'] = $row['address'];
				$data['city'] = $row['city'];
				$data['contactperson'] = $row['contactperson'];
				$data['fax'] = $row['fax'];
				$data['name'] = $row['name'];
				$data['phone'] = $row['phone'];
				$data['zip'] = $row['zip'];
				$data['code'] = $row['code'];
				$data['number'] = $row['number'];
				$data['email'] = $row['email'];
				$data['website'] = $row['website'];
			}
		}
		
		return $data;
	}
	
	public static function addPartnerData($userid, $address, $city, $contactperson, $fax, $name, $phone, $zip, $code,$number,$email,$website){
		

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		$q ="INSERT INTO `partner` ( 
									`active`, 
									`address`, 
									`city`, 
									`contactperson`, 
									`description`, 
									`fax`, 
									`name`, 
									`partnertype`, 
									`phone`, 
									`zip`, 
									`code`, 
									`number`, 
									`email`, 
									`valutedays`, 
									`rebatepercent`, 
									`creditlimit`, 
									`userid`, 
									`website`, 
									`img`, 
									`sort`) VALUES (
									'y', 
									'".$mysqli->real_escape_string($address)."', 
									'".$mysqli->real_escape_string($city)."',  
									'".$mysqli->real_escape_string($contactperson)."', 
									NULL,  
									'".$mysqli->real_escape_string($fax)."', 
									'".$mysqli->real_escape_string($name)."', 
									'Kupac', 
									'".$mysqli->real_escape_string($phone)."',  
									'".$mysqli->real_escape_string($zip)."',  
									'".$mysqli->real_escape_string($code)."',  
									'".$mysqli->real_escape_string($number)."',  
									'".$mysqli->real_escape_string($email)."',  
									0, 
									0, 
									0, 
									'".$mysqli->real_escape_string($userid)."',  
									'".$mysqli->real_escape_string($website)."', 
									NULL, 
									0)";
									

		if($mysqli->query($q)){
			$lastid=$mysqli->insert_id;
			return $lastid;	
		} else {
			return 0;	
		}
	}

	public static function addPartnerApplicationData($userid, $address, $city, $contactperson, $fax, $name, $phone, $zip, $code,$number,$email,$website){
		

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		$q ="INSERT INTO `partnerapplications` ( 
									`userid`, 
									`name`, 
									`code`, 
									`number`, 
									`contactperson`, 
									`phone`, 
									`fax`, 
									`email`, 
									`address`, 
									`city`, 
									`zip`, 
									`website` 
									) VALUES (
									'".$mysqli->real_escape_string($userid)."', 
									'".$mysqli->real_escape_string($name)."',  
									'".$mysqli->real_escape_string($code)."', 
									'".$mysqli->real_escape_string($number)."', 
									'".$mysqli->real_escape_string($contactperson)."', 
									'".$mysqli->real_escape_string($phone)."',  
									'".$mysqli->real_escape_string($fax)."',  
									'".$mysqli->real_escape_string($email)."',  
									'".$mysqli->real_escape_string($address)."',  
									'".$mysqli->real_escape_string($city)."',  
									'".$mysqli->real_escape_string($zip)."',  
									'".$mysqli->real_escape_string($website)."'
									)";
									
									//echo $q;

		if($mysqli->query($q)){
			$lastid=$mysqli->insert_id;
			return $lastid;	
		} else {
			return 0;	
		}
	}
	
   public static function GetPartnerList($page = 1, $limit = 0){
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

        global $system_conf, $theme_conf;

        $partners = array();
        $querylimit = '';
        if($limit !=0 && $theme_conf["show_all_partners_list"]['1'] !=1){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = "LIMIT ".$start.", ".$end;
        }


        $query = "SELECT SQL_CALC_FOUND_ROWS p.id, p.active, p.address, p.city, p.contactperson, p.description, p.fax,p.name, p.partnertype, p.phone, p.zip, 
		                 p.code, p.number, p.email, p.valutedays, p.rebatepercent, p.creditlimit, p.userid,p.website,p.img 
					FROM partner as p
				  ORDER BY p.name asc ".$querylimit;
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundpartners = $aRe[0];

        while($row = $res->fetch_assoc()){
            $iimg = $row['img'];
			if($iimg == '' || $iimg == NULL){
				$iimg = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
			}
            array_push($partners, new Partner($row['id'], 
											  $row['active'], 
											  $row['address'], 
											  $row['city'], 
											  $row['contactperson'],
											  $row['description'],
											  $row['fax'],
											  $row['name'],
											  $row['partnertype'],
											  $row['phone'],
											  $row['zip'],
											  $row['code'],
											  $row['number'],
											  $row['email'],
											  $row['valutedays'],
											  $row['rebatepercent'],
											  $row['creditlimit'],
											  $row['userid'],
											  $row['website'],  
											  Partner::haveSocialNetworks($row['id']),
											  Partner::getSocialNetworks($row['id']),
											  $iimg,
											  Partner::getPartnerAddress($row['id']),
											  Partner::getPartnerContact($row['id'])
											  )
					  );

        }
        return array($foundpartners, $partners);

    }
	public static function GetCommercialistPartnerList($page = 1, $limit = 0){


        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $system_conf, $theme_conf;

        $data = array();
		//partnerid
		$aColumns = array(  'p.id', 'p.partnername','p.partnercode' );
		$sIndexColumn = "p.id";

		/*Paging*/
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".$mysqli->real_escape_string($_POST['start']).", ".
				$mysqli->real_escape_string($_POST['length']);
		}
		/*Ordering*/
		if ( isset( $_POST['order'] ) )
		{
			$sOrder = "ORDER BY p.ID ASC ";
			for ( $i=0 ; $i< sizeof($_POST['order']) ; $i++ )
			{
				if ( $_POST['columns'][$i]['orderable'] == "true" )
				{
					$sOrder .= ", ".$aColumns[$i]." ".$mysqli->real_escape_string($_POST['order'][$i]['dir']) ;
				}
			}
			
			//$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}

		/*Filtering*/
		$sWhere = " WHERE u.ID IS NOT NULL ";
		if ( $_POST['search']['value'] != "" )
		{
			$sWhere = " WHERE u.ID IS NOT NULL "."(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$mysqli->real_escape_string($_POST['search']['value'])."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$sQuery = "	SELECT SQL_CALC_FOUND_ROWS p.id AS `id`,
					       p.name AS `partnername`,
					       p.code AS `partnercode`,
						   CONCAT(p.address,', ',p.city) AS `address`		 
					FROM partner AS p
					LEFT JOIN user AS u ON p.ID=u.partnerid
					$sWhere
		$sOrder
		$sLimit
		";
		//echo $sQuery;
		$rResult=$mysqli->query($sQuery);
		//$rResult = mysqli_query($conn, $sQuery) or die(mysqli_error($conn));
		
		/* Data set length after filtering */
		$sQuery = "
			SELECT FOUND_ROWS()
		";
		//$rResultFilterTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$rResultFilterTotal=$mysqli->query($sQuery);
		//$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
		$aResultFilterTotal = $rResultFilterTotal->fetch_array();
		$iFilteredTotal = $aResultFilterTotal[0];
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.")
			FROM partner AS p
		";
		//$rResultTotal = mysqli_query($conn, $sQuery ) or die(mysqli_error($conn));
		$rResultTotal = $mysqli->query($sQuery);
		//$aResultTotal = mysqli_fetch_array($rResultTotal);
		$aResultTotal = $rResultTotal->fetch_array();
		$iTotal = $aResultTotal[0];

		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
	
		$i = $_POST['start']+1;
		while ( $aRow = $rResult->fetch_array() )
		{
	
		
		$row = array();

		$row[0] = $aRow['partnername'];
		$row[1] = $aRow['partnercode'];
		$row[2] = $aRow['address'];
		$row[3] = Partner::getPartnerAddress($aRow['id']);
		$row[99] = $aRow['id'];	
			
		$output['aaData'][] = $row;
		}
		echo json_encode($output);



    }
	   public static function GetPartnerTypeList(){
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

        $partnertypes = array();

        $query = "SELECT SQL_CALC_FOUND_ROWS p.id, p.name ,p.sort
					FROM partnertype as p
				  ORDER BY p.name asc ";
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundpartnertypes = $aRe[0];

        while($row = $res->fetch_assoc()){
            
            array_push($partnertypes, array('partnertypeid' => $row['id'], 
											 'name' =>  $row['name'], 
											  'sort' => $row['sort']
											  )
					  );

        }
        return array($foundpartnertypes, $partnertypes);
    }
	
	   public static function GetPartnerByPartnerTypeId($partnertpeid){
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

        global $system_conf, $theme_conf;

        $partners = array();

        $query = "SELECT SQL_CALC_FOUND_ROWS p.id, p.active, p.address, p.city, p.contactperson, p.description, p.fax,p.name, p.partnertype, p.phone, p.zip, 
		                 p.code, p.number, p.email, p.valutedays, p.rebatepercent, p.creditlimit, p.userid,p.website,p.img 
					FROM partner as p
				  WHERE partnertype=".$partnertpeid."
				  ORDER BY p.name asc ";
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundpartnertypes = $aRe[0];

        while($row = $res->fetch_assoc()){
            $iimg = $row['img'];
			if($iimg == '' || $iimg == NULL){
				$iimg = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
			}
			
            array_push($partners,  new Partner($row['id'], 
											  $row['active'], 
											  $row['address'], 
											  $row['city'], 
											  $row['contactperson'],
											  $row['description'],
											  $row['fax'],
											  $row['name'],
											  $row['partnertype'],
											  $row['phone'],
											  $row['zip'],
											  $row['code'],
											  $row['number'],
											  $row['email'],
											  $row['valutedays'],
											  $row['rebatepercent'],
											  $row['creditlimit'],
											  $row['userid'],
											  $row['website'],  
											  Partner::haveSocialNetworks($row['id']),
											  Partner::getSocialNetworks($row['id']),
											  $iimg,
											  Partner::getPartnerAddress($row['id']),
											  Partner::getPartnerContact($row['id'])
											  )
					  );

        }
        return array($foundpartnertypes, $partners);
    }
	
		public static function GetPartnerTypePartnerList(){
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

        $partnertypspartners = array();
		$partners = array();
        $query = "SELECT SQL_CALC_FOUND_ROWS p.id, p.name ,p.sort
					FROM partnertype as p
				  ORDER BY p.name asc ";
				  
        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundpartnertypes = $aRe[0];

        while($row = $res->fetch_assoc()){
            $partners = Partner::GetPartnerByPartnerTypeId($row['id']);
            array_push($partnertypspartners, array('partnertypeid' => $row['id'], 
											 'name' =>  $row['name'], 
											  'sort' => $row['sort'],
											  'partners'=>$partners 
											  )
					  );

        }

        return array($foundpartnertypes, $partnertypspartners);
    }

}


?>