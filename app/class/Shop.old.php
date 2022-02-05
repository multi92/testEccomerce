<?php

$class_version["shop"] = array('module', '1.0.0.0.1', 'Nema opisa');
	//include("app/class/Category.php");
/*-------------------------------------------------------------------------------------------------------*/
/*SHOPS FUNCTIONS*/
/*-------------------------------------------------------------------------------------------------------*/
class ShopExtra extends Shop{
    public $timeRadni;
    public $timeSubota;
    public $timeNedelja;
    public function __construct($id=0,$name=false,$thumb=false,$desc=false,$gall=false){
        parent::__construct($id,$name,$thumb,$desc,$gall);
        $times = self::getWorkTimes();
        $this->timeRadni = $times['radni'];
        $this->timeSubota = $times['subota'];
        $this->timeNedelja = $times['nedelja'];
    }
}

class Shop
{
    public $id;
    public $name;
    public $text;
    public $thumb;
    public $desc;
    public $coordinate;
    public $worktime;
    public $email;
    public $phone;
    public $cellphone;
    public $fax;
    public $address;
    public $lat;
    public $long;
    public $type;
    public $shopsid;
    public $galleryID;
    public $warehouseid;
    public $cityname;
    public $files;

    public function __construct($id=0,$name=false,$thumb=false,$desc=false,$gall=false)
    {
        $this->id=$id;
        if($name!==false && $thumb!==false && $desc!==false && $gall!==false)
        {
            $this->name=$name;
            $this->thumb=$thumb;
            $this->desc=$desc;
            $this->galleryID=$gall;
        }else{

            $data=$this->getDBdata($this->id);
			

            if($data!=0)
            {
                $this->name=$data['name'];
				$this->text=$data['text'];
                $this->thumb=$data['thumb'];
                $this->desc=$data['description'];
                $this->coordinate=$data['coordinates'];
                $this->worktime=$data['worktime'];
                $this->email=$data['email'];
                $this->phone=$data['phone'];
				$this->cellphone=$data['cellphone'];
                $this->fax=$data['fax'];
				$this->address=$data['address'];
                $coordinates = explode(',', $this->coordinate);
                if(count($coordinates) == 2){
                    $this->lat = trim($coordinates[0]);
                    $this->long = trim($coordinates[1]);
                }
                else{
                    $this->lat = '0';
                    $this->long = '0';
                }
                $this->type = 'm';
                $this->shopsid = $data['id'];

                $this->galleryID = $data['gallery_id'];
                $this->warehouseid = $data['warehouseid'];
                $this->cityname = $data['cityname'];
				$this->files=$this->getShopFiles($this->id);

            }

        }
    }


    public static function getList($page = 1, $limit = 0, $cityid = false, $type = false){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $user_conf;
        $querylimit = '';


        if($limit !=0 && $user_conf["show_all_shops_list"]['1'] !=1){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = "LIMIT ".$start.", ".$end;
        }

        $citylimit = '';
        if($cityid){
            $citylimit = " and cityid = '".$cityid."'";
        }

        $typelimit = '';
        if($type){
            $typelimit = " and type = '".$type."'";
        }



        $query = "select SQL_CALC_FOUND_ROWS id from shop where status = 'v' ".$citylimit.$typelimit." ORDER BY sort ASC ".$querylimit;
        $res = $mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundproducts = $aRe[0];

        $shops = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                array_push($shops, new Shop($row['id']));
            }
        }
        return array($foundproducts, $shops);
    }

    public static function getShopData(){

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $query = "select SQL_CALC_FOUND_ROWS id from shop where status = 'v' ";
        $res = $mysqli->query($query);


        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundproducts = $aRe[0];

        $shops = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                array_push($shops, new Shop($row['id']));
            }
        }
        return array($foundproducts, $shops);
    }

    public static function getShopDataByShopId($id){

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $q="select s.id, s.name, s.thumb, s.text, s.description, s.coordinates, s.worktime, s.email, s.phone, s.cellphone, s.fax,s.address, s.gallery_id, s.warehouseid, c.name as cityname from shop as s
              LEFT JOIN city as c on s.cityid = c.id
              where s.id=".$id;


        $result=$mysqli->query($q);

        $row = 0;
        if($result->num_rows >0) {
            $row = $result->fetch_assoc();
            if($row['thumb'] == '' or $row['thumb'] == NULL){
                $row['thumb'] = 'fajlovi/logo.jpg';
            }
        }

        return $row;
    }

    private function getDBdata($id){

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $q="select s.id, s.name, s.thumb, s.text, s.description, s.coordinates, s.worktime, s.email, s.phone, s.cellphone, s.fax,s.address, s.gallery_id, s.warehouseid, c.name as cityname from shop as s
              LEFT JOIN city as c on s.cityid = c.id
              where s.id=".$id;


        $result=$mysqli->query($q);

        $row = 0;
        if($result->num_rows >0) {
            $row = $result->fetch_assoc();
            if($row['thumb'] == '' or $row['thumb'] == NULL){
                $row['thumb'] = 'fajlovi/logo.jpg';
            }
        }

        return $row;
    }
	
    private function getShopFiles($id){

        $ShopFiles= Array();
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $q="SELECT sf.id,sf.`type`,sf.content,sf.contentface,sf.sort,sf.`status` 
			FROM shop_file AS sf 
			WHERE sf.shopid=".$id."
			AND sf.`status`='v'
			ORDER BY sf.sort ASC";

        $result=$mysqli->query($q);

        $row = 0;
		
		if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
				$content='';
                if($row['content'] != '' || $row['content'] != null){
                     
                    $content=$row['content'];
                }
				else{
					$content="fajlovi/noimg.png";
					
				}
				array_push($ShopFiles, array(
                            'id' => $row['id'],
                            'type' => $row['type'],
                            'content' => $content,
                            'contentface' => $row['contentface'],
							'sort' => $row['sort'],
							'status' => $row['status'])
                       );
            }
        }		

        return $ShopFiles;
    }	
	
	
	
    public static function getALLShopsCities(){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $query = "SELECT DISTINCT(c.name), c.id, c.coordinates FROM `shop` s LEFT JOIN city c ON s.cityid = c.id";
        $res = $mysqli->query($query);
        $cities = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                if($row['name'] != '' || $row['name'] != null){
                    $coordinates = explode(',', $row['coordinates']);
                    if(count($coordinates) == 2){
                        $lat = trim($coordinates[0]);
                        $long = trim($coordinates[1]);
                    }
                    else{
                        $lat = '43';
                        $long = '21';
                    }
                    $cities[]=array('name' => $row['name'], 'id'=>$row['id'], 'coordinates'=>$row['coordinates'], 'lat'=>$lat, 'long'=>$long);
                }
            }
        }
        return $cities;


    }
	
	public static function createReservationNumber(){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT COUNT(ID) as num FROM document";	
		$res=$mysqli->query($q);

		$number = "";
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$number = (intval($row['num'])+1)."/".date("Y")."_web"; 	
		}
		
		return $number;
	}
	
	public static function createReservationNumberB2C(){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT COUNT(ID) as num FROM documentb2c";	
		$res=$mysqli->query($q);

		$number = "";
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$number = (intval($row['num'])+1)."/".date("Y")."_web"; 	
		}
		
		return $number;
	}

    public static function createReservationB2C(){

    }
    public static function createReservationB2B(){

    }


	public static function createReservationFromSession(){
		global $user_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

		if(!empty($_SESSION['shopcart'])){
			// shopcart is no empty
			$comment='';
			if(isset($_SESSION["shopcart_comment"]) && $_SESSION["shopcart_comment"]!=''){
				$comment=$_SESSION["shopcart_comment"];
			}
            $reservation_number = Shop::createReservationNumber();
            $partnerid = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
			if($partnerid>0){
				$userid=0;
			}
			else {
				$userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
			}
            $q = "INSERT INTO `document`(`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES ('', '', 'web - ".$comment."', '', NOW(), NOW(), '', 1, 0, '', '".$reservation_number."', ".$partnerid.", 'n', 'E', ".$_SESSION['warehouseid'].", ".$userid.", 'n', 0, 0, 0, NOW(), 0, 0, 0, 'n', NOW(), 0, CURRENT_TIMESTAMP)";

			$mysqli->query($q);
			$lastid = $mysqli->insert_id;
			
			$data = array();
			// prepare item for insert
			foreach($_SESSION['shopcart'] as $key=>$val){
				if(array_key_exists($val['id'], $data)){ //ako postoji asocijativna vrednost sa kljucem id
					$data[$val['id']]['qty'] += intval($val['qty']);//provera da li je dodat 
					$attrdata = json_decode($val['attr']); //dekodiranje odabranih atributa [atr , atrvalid]
					$tmparray = array();
					foreach($attrdata as $k=>$v){
						array_push($tmparray, $v[1]);	
					}
					array_push($data[$val['id']]['attr'], array($tmparray, $val['qty']));	
				}
				else{
					
					$data[$val['id']] = array();
					$data[$val['id']]['name'] = $val['name'];
					$data[$val['id']]['price'] = $val['price'];
					$data[$val['id']]['quantityrebate'] = Product::getProductQuantityRebate($val['id']);
					$data[$val['id']]['maxrebate'] = Product::getMaxRebate($val['id']);
					//quantityrebate
					$quantityrebate = 0; 
					 if(isset($data[$val['id']]['quantityrebate']) && count($data[$val['id']]['quantityrebate'])>0) { 
					
										foreach($data[$val['id']]['quantityrebate'] as $qrval) { 
										 if( intval($val['qty'])>=intval($qrval["quantity"]) ) { 

										 $quantityrebate=$qrval["rebate"] ;
										 } 
										 } 
					 } else { 
										 $quantityrebate=0 ;
					 } 
					//quantityrebate end
					//maxrebate
					$item_rebate = 0;
					$item_rebate=($val['rebate']+((100-$val['rebate'])*($quantityrebate/100)));
					$zero_rebate=false;
					if(($item_rebate>=$data[$val['id']]['maxrebate'] || is_null($data[$val['id']]['maxrebate'])) && $user_conf["act_priority"][1]==0){
						$item_rebate=$data[$val['id']]['maxrebate'];
						$zero_rebate=true;
					}
					//maxrebate end
					$data[$val['id']]['rebate'] = $item_rebate;
					$data[$val['id']]['tax'] = $val['tax'];
					$data[$val['id']]['pic'] = $val['pic'];
					$data[$val['id']]['qty'] = intval($val['qty']);
					$data[$val['id']]['attr'] = array();
					
					$attrdata = json_decode($val['attr']);
					$tmparray = array();
					foreach($attrdata as $k=>$v){
						array_push($tmparray, $v[1]);	
					}
					array_push($data[$val['id']]['attr'], array($tmparray, intval($val['qty'])));
				}
			}
			 
			//return $data;

			foreach($data as $key=>$val){
				$q = "INSERT INTO `documentitem`(`ID`, `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `ts`) VALUES ('', '', 0, '', ".$val['rebate'].", 'p', ".$lastid.", 0, '', ".$val['price'].", 0, ".$val['price']*((100-intval($val['rebate']))/100)*$val['qty'].", ".$key.", '".$val['name']."', ".$val['qty'].", 0, ".$val['tax'].", 0, 0, CURRENT_TIMESTAMP)";	
				$mysqli->query($q);
			
				$lastitemid = $mysqli->insert_id;
				foreach($val['attr'] as $k=>$v){
					$q = "INSERT INTO `documentitemattr`(`id`, `documentitemid`, `attrvalue`, `quantity`, `ts`) VALUES ('', ".$lastitemid.", '".implode(",", $v[0])."', ".$v[1].", CURRENT_TIMESTAMP)";
					$mysqli->query($q);
				}
			}
			
            Shop::createReservationEmail($reservation_number);

			return 1;
		}
		else{
			return 0;	
		}
		
		
	}
	
	public static function createReservationFromSessionB2C(){
		global $user_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

		if(!empty($_SESSION['shopcart'])){
			// shopcart is no empty
			$comment='';
			if(isset($_SESSION["shopcart_comment"]) && $_SESSION["shopcart_comment"]!=''){
				$comment=$_SESSION["shopcart_comment"];
			}
            $reservation_number = Shop::createReservationNumberB2C();
            $partnerid = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
			if($partnerid>0){
				$userid=0;
			}
			else {
				$userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
			}
            $q = "INSERT INTO `documentb2c`(`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES ('', '', 'web - ".$comment."', '', NOW(), NOW(), '', 1, 0, '', '".$reservation_number."', ".$partnerid.", 'n', 'E', ".$_SESSION['warehouseid'].", ".$userid.", 'n', 0, 0, 0, NOW(), 0, 0, 0, 'n', NOW(), 0, CURRENT_TIMESTAMP)";

			$mysqli->query($q);
			$lastid = $mysqli->insert_id;
			
			$data = array();
			// prepare item for insert
			foreach($_SESSION['shopcart'] as $key=>$val){
				

				if(array_key_exists($val['id'], $data)){ //ako postoji asocijativna vrednost sa kljucem id

					$data[$val['id']]['qty'] += intval($val['qty']);//provera da li je dodat 
					
					$attrdata = json_decode($val['attr']); //dekodiranje odabranih atributa [atr , atrvalid]
					$tmparray = array();
					foreach($attrdata as $k=>$v){
						array_push($tmparray, $v[1]);	
					}
					array_push($data[$val['id']]['attr'], array($tmparray, $val['qty']));	
				}
				else{
					
					$data[$val['id']] = array();
					$data[$val['id']]['name'] = $val['name'];
					$data[$val['id']]['price'] = $val['price'];
					$data[$val['id']]['quantityrebate'] = Product::getProductQuantityRebate($val['id']);
					$data[$val['id']]['maxrebate'] = Product::getMaxRebate($val['id']);
					//quantityrebate
					$quantityrebate = 0; 
					 if(isset($data[$val['id']]['quantityrebate']) && count($data[$val['id']]['quantityrebate'])>0) { 
					
										foreach($data[$val['id']]['quantityrebate'] as $qrval) { 
										 if( intval($val['qty'])>=intval($qrval["quantity"]) ) { 

										 $quantityrebate=$qrval["rebate"] ;
										 } 
										 } 
					 } else { 

										 $quantityrebate=0 ;
					 } 
					//quantityrebate end
					//maxrebate
					$item_rebate = 0;
					$item_rebate=($val['rebate']+((100-$val['rebate'])*($quantityrebate/100)));
					$zero_rebate=false;
					if(($item_rebate>=$data[$val['id']]['maxrebate'] || is_null($data[$val['id']]['maxrebate'])) && $user_conf["act_priority"][1]==0){
						$item_rebate=$data[$val['id']]['maxrebate'];
						$zero_rebate=true;
					}
					//maxrebate end
					$data[$val['id']]['rebate'] = $item_rebate;
					$data[$val['id']]['tax'] = $val['tax'];
					$data[$val['id']]['pic'] = $val['pic'];
					$data[$val['id']]['qty'] = intval($val['qty']);
					$data[$val['id']]['attr'] = array();
					
					$attrdata = json_decode($val['attr']);
					$tmparray = array();
					foreach($attrdata as $k=>$v){
						array_push($tmparray, $v[1]);	
					}
					array_push($data[$val['id']]['attr'], array($tmparray, intval($val['qty'])));
				}
			}
			 
			//return $data;

			foreach($data as $key=>$val){
				$q = "INSERT INTO `documentitemb2c`(`ID`, `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `ts`) VALUES ('', '', 0, '', ".$val['rebate'].", 'p', ".$lastid.", 0, '', ".$val['price'].", 0, ".$val['price']*((100-intval($val['rebate']))/100)*$val['qty'].", ".$key.", '".$val['name']."', ".$val['qty'].", 0, ".$val['tax'].", 0, 0, CURRENT_TIMESTAMP)";	
				$mysqli->query($q);
			
				$lastitemid = $mysqli->insert_id;
				foreach($val['attr'] as $k=>$v){
					$q = "INSERT INTO `documentitemattrb2c`(`id`, `documentitemid`, `attrvalue`, `quantity`, `ts`) VALUES ('', ".$lastitemid.", '".implode(",", $v[0])."', ".$v[1].", CURRENT_TIMESTAMP)";
					$mysqli->query($q);
				}
			}
			
            Shop::createReservationEmail($reservation_number);

			return 1;
		}
		else{
			return 0;	
		}
		
		
	}
	
	public static function getLoggedDocumentItems($userid){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$logdocumentitem=array();
		
		$q="SELECT ldi.id, 
			ldi.productid,
			p.name,
			ldi.price,
			ldi.rebate,
			ldi.taxid,
			t.value as taxvalue,
			getDefaultImage(p.id) as defaultimage,
			ldi.quantity,
			ptr.name AS nametr
			FROM logdocumentitem  AS ldi
			LEFT JOIN product AS p ON ldi.productid=p.id 
			LEFT JOIN tax AS t ON p.taxid=t.id
			LEFT JOIN product_tr as ptr on p.id = ptr.productid AND (langid = ".$_SESSION['langid']." or langid is NULL)
			WHERE ldi.documentid=0 AND ldi.userid=".$userid;
			
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
			
				//treba ponovo preracunati kompletan rabat po kolicini 
				//treba izvuci atribute iz log logdocumentitemattr
				//'attrs'=>Product::getAttributes($row['productid']
				array_push($logdocumentitem, array('logdocumentitemid' => $row['id'], 
				                                   'productid'=>$row['productid'], 
												   'name' => $name, 
												   'price'=>$row['price'],
												   'rebate'=>$row['rebate'],
												   'tax'=>$row['taxvalue'],
												   'picture'=>$row['defaultimage'],
												   'quantity'=>$row['quantity'],
												   'attrs'=>''
												   )
							);
			}
			
		}
		
		
		return $logdocumentitem;
		
	}
	
	public static function getLoggedDocumentItemAttrs($logdocumentitemid){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$logdocumentitemattr=array();
		
		/*$q="SELECT ldi.id, 
			ldi.productid,
			p.name,
			ldi.price,
			ldi.rebate,
			ldi.taxid,
			getDefaultImage(p.id) as defaultimage,
			ldi.quantity
			FROM logdocumentitem  AS ldi
			LEFT JOIN product AS p ON ldi.productid=p.id 
			LEFT JOIN product_tr as ptr on p.id = ptr.productid AND (langid = ".$_SESSION['langid']." or langid is NULL)
			WHERE ldi.documentid=0 AND ldi.userid=".$userid;
			
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
			
				//treba ponovo preracunati kompletan rabat po kolicini 
				//treba izvuci atribute iz log logdocumentitemattr
				//'attrs'=>Product::getAttributes($row['productid']
				array_push($logdocumentitem, array('logdocumentitemid' => $row['id'], 
				                                   'productid'=>$row['productid'], 
												   'name' => $name, 
												   'price'=>$row['price'],
												   'rebate'=>$row['rebate'],
												   'taxid'=>$row['taxid'],
												   'picture'=>$row['defaultimage'],
												   'quantity'=>$row['quantity']
												   )
							);
			}
			
		}*/
		
		return $logdocumentitemattr;
		
	}
	
    public static function createReservationEmail($reservation_number){
        global $user_conf;
		
		include_once("app/class/DeliveryService.php");
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $ord_adr = (isset($_SESSION['email']))? $_SESSION['email']:$_SESSION['ordering_address']['email'];
        $payment = $_SESSION['ordering_address']['payment'];
		$delivery = $_SESSION['ordering_address']['delivery'];
		if(isset($_SESSION['ordering_address']['deliveryid']) && $_SESSION['ordering_address']['deliveryid']!='' && $_SESSION['ordering_address']['deliveryid']>0){
			$deliveryid = $_SESSION['ordering_address']['deliveryid'];
			$deliverydata = DeliveryService::getDeliveryServiceById($deliveryid);
        }
		$partner_info = '';
		

		$documenttypename = $user_conf["document_type_user_name"][1];
        $userdetails = "<br /> Detalji narucioca: <br />
		<br />Email:  ".$_SESSION['ordering_address']['email']."
		<br />Ime : ".$_SESSION['ordering_address']['ime']."
		<br />Prezime : ".$_SESSION['ordering_address']['prezime']."
		<br />Adresa : ".$_SESSION['ordering_address']['adresa'].", ".$_SESSION['ordering_address']['postbr']." , ".$_SESSION['ordering_address']['mesto']."
		<br />Telefon : ".$_SESSION['ordering_address']['telefon']."
		<br />Mobilni telefon : ".$_SESSION["mobile"]."
		<br /><br />";
		$userdetails .= "<br/>Placanje: ".$payment."<br/>";
	
		$memorandum_comment='';
		$partner_type=false;
        if(isset($_SESSION['type']) && $_SESSION['type'] == 'partner'){
			$partner_type=true;
			$documenttypename = $user_conf["document_type_partner_name"][1];
            $partner = GlobalHelper::getPartnerInfo($_SESSION['id']);
            $partner_info = "<br/>Detalji partnera: <br/>
                    <br />Partner : ".$partner['name']."
                    <br />PIB : ".$partner['code']."
					<br />Matični broj : ".$partner['number']."
                    <br />Adresa : ".$partner['address'].", ".$partner['zip']." , ".$partner['city']."
                    <br />Fax : ".$partner['fax']."
                    <br />Telefon : ".$partner['phone']."
					<br />Mobilni telefon : ".$_SESSION["mobile"]."
            		<br />Email:  ".$partner['email']."
					<br />";
			$memorandum_comment="<br /><b>".$user_conf["memorandum_comment_line1"][1]."</b><br />
								 <br /><b>".$user_conf["memorandum_comment_line2"][1]."</b>
					             <br /><b>".$user_conf["memorandum_comment_line3"][1]."</b>
					             <br /><b>".$user_conf["memorandum_comment_line4"][1]."</b>
					             <br /><b>".$user_conf["memorandum_comment_line5"][1]."</b>
					             <br /><br />";
			$userdetails = $partner_info;
        }
        //DELIVERY SERVICE
		$userdetails .= "<br/>Način preuzimanja: ".$delivery."<br/>";
		if(isset($deliverydata[1]) && count($deliverydata)>0){
			if($delivery == "Lično")
			{
				$newaddress = '';
				if($_SESSION['ordering_address']['deliveryid'] == "1") $newaddress = "Bulevar Nemanjića 16 lokal 11";
				if($_SESSION['ordering_address']['deliveryid'] == "2") $newaddress = "Vizantijski bulevar 9 - Izdvojeni prostor";
				
				$userdetails .= "<br />Pošiljku preuzeti u radnji: ".$newaddress."<br/>";
			}else{
				foreach($deliverydata[1] as $dsval){
						$userdetails .= "<br />Pošiljku poslati kurirskom službom: ".$dsval->name." 
										 <br />Telefon kurirske službe: ".$dsval->phone." 
										 <br />Sajt kurirske službe: ".$dsval->website."<br/>";
				}
			}
		} 
		
		//COMMENT
		$comment='';
		if(isset($_SESSION['shopcart_comment']) && $_SESSION['shopcart_comment']!=''){
			$comment=$_SESSION['shopcart_comment'];
			$userdetails .= "<br/>Komentar: ".$comment."<br/><br/>";
		}
		$userdetails .= $memorandum_comment;
		
		

        $shopcart = array();
        if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
            $shopcart = $_SESSION['shopcart'];
            foreach ($shopcart as $key => $cartprod) {
                $shopcart[$key]['cartposition'] = $key;
                $attrs = array();
                $a = json_decode($cartprod['attr'], true);
                foreach ($a as $attr) {
                    array_push($attrs,
                        array(
                            'attrid' => $attr[0],
                            'attrname' => GlobalHelper::getAttrName($attr[0]),
                            'attrvalid' => $attr[1],
                            'attrvalname' => GlobalHelper::getAttrValName($attr[1])
                        )
                    );
                }
				
				$prodData = GlobalHelper::getProductDataFromId($cartprod['id']);

				$shopcart[$key]['code'] = $prodData['code'];
				$shopcart[$key]['unitname'] = $prodData['unitname'];
				
                $shopcart[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                $shopcart[$key]['attrn'] = $attrs;
				$shopcart[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
				$shopcart[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);

            }
        }

        $total_price = 0;
        $total_price_pdv = 0;
        $shop_table_body = '';
		
		$total_rebate = 0;
		$total_rebate_pdv = 0;
		$total_price = 0;
		$total_tax = 0;
		$total_price_pdv = 0;
		$total_norebateprice = 0;
		$total_norebateprice_pdv = 0;
		
		$i = 1;
        foreach ($shopcart as $key => $cartprod) {
			//quantityrebate
			$quantityrebate = 0; 
			if(isset($cartprod['quantityrebate']) && count($cartprod['quantityrebate'])>0) { 
					
			foreach($cartprod['quantityrebate'] as $qrval) {
				if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {

					$quantityrebate=$qrval["rebate"] ;
				} 
			} 
			} else { 

				$quantityrebate=0 ;
			} 
			//quantityrebate end
			//maxrebate
			$item_rebate = 0;
			$zero_rebate=false;
			$item_rebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($quantityrebate/100)));
			if(($item_rebate>=$cartprod['maxrebate'] || is_null($cartprod['maxrebate'])) && $user_conf["act_priority"]==0){
				$item_rebate=$cartprod['maxrebate'];
				$zero_rebate=true;
			}
			//maxrebate end
			
            $attributes = '';	
			$total = 0;		
            foreach ($cartprod['attrn'] as $attr) {
                $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
            }
                    $total += $cartprod['price']  * $cartprod['qty'];
						$total_rebate += $cartprod['price']  * $cartprod['qty']*($item_rebate/100);
                        $total_rebate_pdv +=$cartprod['price']  * $cartprod['qty']*($item_rebate/100)*(1+($cartprod['tax'])/100);
						$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($item_rebate/100));
                        $article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($item_rebate/100)) * ((100+$cartprod['tax'])/100);
                        $total_price += $article_total_price;
						$total_tax +=$article_total_price * (($cartprod['tax'])/100);
                        $total_price_pdv += $article_total_price_pdv;

					
					$total_norebateprice += $cartprod['price']  * $cartprod['qty']* (1-($item_rebate/100));
					$total_norebateprice_pdv += $cartprod['price']  * $cartprod['qty']* (1-($item_rebate/100))*((100+$cartprod['tax'])/100);
					
					$prodata = GlobalHelper::getProductDataFromId($cartprod['id']);
					
			$shop_table_body .= '<tr style="border-bottom:1px solid #333;
	border-left:1px solid #333;
	border-right:1px solid #333; ">
			  <td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$i.'</td>
			  <td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$prodata['code'].'</td>
			  <td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$cartprod['name'].' <br /> '.$attributes.'</td>
			  './*<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$prodata['unitname'].'</td>*/'
			  <td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$cartprod['qty'].'</td>';
			  
			  if(isset($_SESSION['type']) && $_SESSION['type'] == 'partner')
			  {
			  	$shop_table_body .= '<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($cartprod['price'] * (1-($item_rebate/100)), 2, ",", ".").'</td>
			  <td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($cartprod['tax'], 2, ",", ".").'%</td>';
			  }
			  $shop_table_body .= '<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($cartprod['price'] * (1-($item_rebate/100)) * (1+$cartprod['tax']/100), 2, ",", ".").'</td>
			  './*<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($item_rebate, 2, ",", ".").'</td>'
			  <td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price, 2, ",", ".").'</td>*/
			  '<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price_pdv, 2, ",", ".").'</td>
			</tr>';
			$i++;
        }

//        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$coll_span_total="";
	if($partner_type){
		$coll_span_total=7;	
	} else {
		$coll_span_total=5;			
	}
//        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $msg = '';
        //$msg .= $userdetails;
            $msg .= "<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
							".$userdetails."
						</div>
						<div class='half' style=\"width:50%; float:left; font-size:12px !important; line-height:14px;\">
							<div class='twothirds bottomMargin15' style=\"width:66%; float:left; font-size:12px; margin-bottom:15px;\">
								<p>Mesto izdavanja</p>
								<p>Nis</p>
							</div>
							<div class='onethirds bottomMargin15' style=\"width:33%; float:left; font-size:12px; margin-bottom:15px;\">
								<p>Datum izdavanja</p>
								<p>".date("d.m.Y")."</p>
							</div>
							
						</div>
						<div style='clear:both;'></div>
						
						<h2 class='titlenumber' style=\"font-weight: bold; font-size: 12pt; color: #000000; 
	font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
	text-align: center;  text-transform:uppercase; page-break-after:avoid; 
	padding-top:10px; padding-bottom:10px; background-color:#FFC4C5;\">".$documenttypename." ".$reservation_number."</h2>


                        <table border='1' cellpadding='0' cellspacing='0' style='text-align:right;  line-height: 1.2; 
	margin-top: 2pt; margin-bottom: 5pt;
	border-collapse: collapse; 
	width:100%;
	border-bottom: none;
	border-left: none;
	border-right: none;
	width:100%;'>
                                                <thead>
													<tr class='tableHeder' >
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; \">R.b.</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Šifra</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Proizvod</th>
													  "./*<th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Jed. <br /> mere</th>*/"
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Količina</th>";
													  if(isset($_SESSION['type']) && $_SESSION['type'] == 'partner')
			  										  {
														 $msg .= "<th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Cena </th>
														 		<th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">PDV </th> ";
													  }
													  $msg .= "<th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Cena sa <br /> PDV </th>"
													  ./*<th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Rabat (%)</th>
													  <th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Vrednost</th>*/
													  "<th style=\"font-weight: bold; vertical-align: top; padding-left: 2mm;	padding-right: 2mm; padding-top: 0.5mm;	padding-bottom: 0.5mm;text-align:center; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;\">Vrednost <br /> sa PDV</th> 
													</tr>
                                                </thead>
                                                <tbody>".$shop_table_body."</tbody>

            <tfoot>
				<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \" >
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;' colspan='".$coll_span_total."'>Ukupno: </td>
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_norebateprice, 2)."</td>*/"
				  <td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_norebateprice_pdv, 2)."</td>
				</tr>
				"./*<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \">*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;' colspan='2'>Rabat: </td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_rebate, 2)."</td>*/"
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_rebate_pdv, 2)."</td>*/"
				"./*</tr>*/"
				"./*<tr style='' class='summaryRow nobackground' style=\"border:none; background-color:transparent; \">*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;' colspan='2'>Ukupno sa rabatom: </td>*/"
				  "./*<td style='font-weight:bold; font-size:12px; border:none !important;'></td>*/"
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_price, 2)."</td>*/"
				  "./*<td style='text-align:right; font-weight:bold; font-size:12px; border:none !important;'>".number_format($total_price_pdv, 2)."</td>*/"
				"./*</tr>*/"
            </tfoot>
            </table><br /><br />
			</body>
			</html>";

//        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       //var_dump($msg);
		//die();
		
		global $user_conf;
		
		// kupac
        GlobalHelper::sendEmailReservation(array('client'=>$ord_adr, 'seller'=>$user_conf["b2b_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina br '.$reservation_number , 'seller'=>' Nova porudzbina na sajtu '), $msg );
		
		GlobalHelper::partnerDeleteAllShopcartData();
		
		$_SESSION['shopcart'] = array();
		unset($_SESSION['shopcart_comment']);
		unset($_SESSION['ordering_address']['payment']);
		unset($_SESSION['ordering_address']['delivery']);
		unset($_SESSION['ordering_address']['deliveryid']);
        //napraviti mail za kupca i za prodavca

    }
    public function getWorkTimes(){
        $tmp_time = "";
        $data = explode("_",$this->worktime);
        $time_radni = '';
        $time_subota = '';
        $time_nedelja = '';
        foreach($data as $d=>$v)
        {
            $da = explode("-",$v);
            if($da[0] == "mf")
            {
                $time = explode(">",$da[1]);
                $tmp_time .= "ponedeljak - petak:  ".$time[0]." - ".$time[1]."h; <br>";
                $time_radni = $time[0]." - ".$time[1]."h";
            }
            if($da[0] == "st")
            {
                $time = explode(">",$da[1]);
                $tmp_time .= " subota: ".$time[0]." - ".$time[1]."h; <br>";
                $time_subota = $time[0]." - ".$time[1]."h";
            }
            if($da[0] == "su")
            {
                $time = explode(">",$da[1]);
                if (empty($time[0]) || empty($time[1])){
                    $tmp_time .= " nedelja: ne radi";
                    $time_nedelja = " ne radi";
                }
                else{
                    $tmp_time .= " nedelja: ".$time[0]." - ".$time[1]."h; <br>";
                    $time_nedelja = $time[0]." - ".$time[1]."h";
                }
            }
        }
        $time = array('radni' => $time_radni, 'subota' => $time_subota, 'nedelja' => $time_nedelja);
        return $time;
    }
	
	public static function b2b_create_reservation()
{
	//echo 'prosledjujem porudzbinu';
	
	global $b2bstr, $b2cstr, $b2barr, $b2carr, $valute, $user_conf;	
	
	//DB 
	$db = Database::getInstance();
    $mysqli = $db->getConnection();
    $mysqli->set_charset("utf8");
	//DB END
	
	//INVOICE DATA
	/*---INVOICE EMAIL---*/
	
	$ord_adr = (isset($_SESSION['email']))? $_SESSION['email']:$_SESSION['ordering_address']['email'];
	
	/*---INVOICE HEADER---*/
	
	$userdetails=Invoice::getInvoiceHeaderInformation();
	
	//INVOICE DATA END
	
	
	$sendb2cmail = false;
	$sendb2bmail = false;	
	
	$b2bproids = "";
	foreach($_SESSION['shopcartB2B'] as $p=>$d)
	{
		$data = $d['id'];//explode(":",$d);
		if($d['qty'] == 0) {continue;}
		$b2bproids .= $d['id'].",";
	}
	$b2bproids = substr($b2bproids, 0,-1);
	$query = "SELECT productid, warehouseid FROM productwarehouse WHERE productid in (".$b2bproids.") AND warehouseid in (".$b2bstr.") ORDER BY warehouseid";
	
	//echo $query;
	$cre = $mysqli->query($query);
	
	$b2bwarehouse1 = array();
	$b2bwarehouse2 = array();
		
	while($crow = $cre->fetch_assoc())
	{
		if($b2barr[0] == $crow['warehouseid'])
		{
			foreach($_SESSION['shopcartB2B'] as $p=>$d)
			{
				$data = $d['id'];
				$attr = $d['attr'];
				$qty = $d['qty'];
				if($data == $crow['productid'])
				{
					array_push($b2bwarehouse1, $crow['productid'].":".$qty.":".$attr);	
				}
			}
		}
		if($b2barr[1] == $crow['warehouseid'])
		{
			foreach($_SESSION['shopcartB2B'] as $p=>$d)
			{
				$data = $d['id'];
				$attr = $d['attr'];
				$qty = $d['qty'];
				if($data == $crow['productid'])
				{
					array_push($b2bwarehouse2, $crow['productid'].":".$qty.":".$attr);	
				}
			}
		}
	}

	//var_dump($b2bwarehouse1);
	//var_dump($b2bwarehouse2);

///////////////////////////////////
	$total_price = 0;
	$total_price_pdv = 0;
	$shop_table_body = '';

	$total_rebate = 0;
	$total_rebate_pdv = 0;
	$total_price = 0;
	$total_price_pdv = 0;
	$total_norebateprice = 0;
	$total_norebateprice_pdv = 0;
///////////////////////////////////
				
	if(!empty($b2bwarehouse1))
	{
		$reservation_number = Shop::createReservationNumber();
		$query = "INSERT INTO `document` (`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES (NULL, '0', 'web', 'RSD',  NOW(), NOW(), '', '-1', NULL, NULL, '".$reservation_number."', '".$_SESSION['partnerid']."', 'n', 'H', '".$b2barr[0]."', '1', 'n', NULL, NULL, NULL, NOW(), NULL, NULL, NULL, 'n', NULL, NULL, CURRENT_TIMESTAMP)";
		//echo $query;
		if($mysqli->query($query))
		{	
			$lastid = $mysqli->insert_id;
			$query = "UPDATE document SET number = 'vp/".$reservation_number."' WHERE `ID`=$lastid";
			//echo $query;
			if($mysqli->query($query))
			{	

				$i=0;
				foreach($b2bwarehouse1 as $p=>$d)
				{
					$i++;
					$data = explode(":",$d);
					if($data[1] == 0) {continue;}
					$sendb2bmail = true;
					$ptr = Category::getCategoryProductDetail(array($data[0]));
					
					//var_dump($ptr[1][0]);
					$ptr[1][0]->price = $ptr[1][0]->price*$valute; 
					$query = "SELECT p.name, p.code, p.unitname, t.id as taxid, t.value FROM product p LEFT JOIN tax t ON p.taxid = t.id WHERE p.id = ".$data[0];
					
					$re = $mysqli->query($query);
					
					$base = $re->fetch_assoc();
					
					$itemvalue = (((100-$ptr[1][0]->rebate)*0.01)*$ptr[1][0]->price)*$data[1];
					
					$query = "INSERT INTO `documentitem` (`ID`, `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `documentitemts`) VALUES (NULL, '0', '0', 'T', '".$ptr[1][0]->rebate."', 'P', '".$lastid."', '0', 'P', '".$ptr[1][0]->price."', '0', '".$itemvalue."', '".$data[0]."', '".$mysqli->real_escape_string(str_replace("'","",$base["name"]))."', '".$data[1]."', '0', '".$base["value"]."', '".$base["taxid"]."', '0', CURRENT_TIMESTAMP)";
					//echo $query;
					$mysqli->query($query);
					
					$a = json_decode($data[2], true);
					$attrstr='';
					foreach ($a as $attr) {
						$attrstr.=GlobalHelper::getAttrName($attr[0]).':'.GlobalHelper::getAttrValName($attr[1]).' ';
					}

					$article_total_price = $ptr[1][0]->price  * $data[1] *(1-($ptr[1][0]->rebate/100));
                    $article_total_price_pdv = $ptr[1][0]->price * ((100+$ptr[1][0]->tax)/100) * $data[1] * (1-$ptr[1][0]->rebate/100);
                    					
					$total_rebate += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100);
					$total_rebate_pdv += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100)*((100+$ptr[1][0]->tax)/100);
					$total_price += $article_total_price;
					$total_price_pdv += $article_total_price*((100+$ptr[1][0]->tax)/100);
					$total_norebateprice += $ptr[1][0]->price  * $data[1] ;
					$total_norebateprice_pdv += $ptr[1][0]->price  * $data[1] * ((100+$ptr[1][0]->tax)/100);
					
					$shop_table_body .= '<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; ">
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$i.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["code"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["name"].' <br /> '.$attrstr.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["unitname"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$data[1].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price * (1+$ptr[1][0]->tax/100), 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$ptr[1][0]->rebate.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price_pdv, 2, ",", ".").'</td>
										</tr>';
					
					
				}
			}	
			else
			{
				echo "fail update document".mysql_error();	
			}
		}
		else
		{
			echo "fail insert document".mysql_error();
		}	
	}
	
	if(!empty($b2bwarehouse2))
	{
		$reservation_number = Shop::createReservationNumber();
		$query = "INSERT INTO `document` (`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES (NULL, '0', 'web', 'RSD',  NOW(), NOW(), '', '-1', NULL, NULL, '".$reservation_number."', '".$_SESSION['partnerid']."', 'n', 'H', '".$b2barr[1]."', '1', 'n', NULL, NULL, NULL, NOW(), NULL, NULL, NULL, 'n', NULL, NULL, CURRENT_TIMESTAMP)";
		
		if($mysqli->query($query))
		{	
			$lastid = $mysqli->insert_id;
			$query = "UPDATE document SET number = 'vp/".$reservation_number."' WHERE `ID`=$lastid";
			//echo $query;
			if($mysqli->query($query))
			{	
				$i=0;
				foreach($b2bwarehouse2 as $p=>$d)
				{
					$i++;
					$data = explode(":",$d);
					if($data[1] == 0) {continue;}
					$sendb2bmail = true;
					$ptr = Category::getCategoryProductDetail(array($data[0]));
					$ptr[1][0]->price = $ptr[1][0]->price *$valute; 
					$query = "SELECT p.name, p.code, p.unitname, t.id as taxid, t.value FROM product p LEFT JOIN tax t ON p.taxid = t.id WHERE p.id = ".$data[0];
					$re = $mysqli->query($query);
					
					$base = $re->fetch_assoc();
					
					$itemvalue = (((100-$ptr[1][0]->rebate)*0.01)*$ptr[1][0]->price)*$data[1];
					
					$query = "INSERT INTO `documentitem` (`ID`, `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `documentitemts`) VALUES (NULL, '0', '0', 'T', '".$ptr[1][0]->rebate."', 'P', '".$lastid."', '0', 'P', '".$ptr[1][0]->price."', '0', '".$itemvalue."', '".$data[0]."', '".$mysqli->real_escape_string(str_replace("'","",$base["name"]))."', '".$data[1]."', '0', '".$base["value"]."', '".$base["taxid"]."', '0', CURRENT_TIMESTAMP)";
					
					$mysqli->query($query);
					
					$a = json_decode($data[2], true);
					$attrstr='';
					foreach ($a as $attr) {
						$attrstr.=GlobalHelper::getAttrName($attr[0]).':'.GlobalHelper::getAttrValName($attr[1]).' ';
					}
					
					$article_total_price = $ptr[1][0]->price  * $data[1] *(1-($ptr[1][0]->rebate/100));
                    $article_total_price_pdv = $ptr[1][0]->price * ((100+$ptr[1][0]->tax)/100) * $data[1] * (1-$ptr[1][0]->rebate/100);
                    					
					$total_rebate += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100);
					$total_rebate_pdv += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100)*((100+$ptr[1][0]->tax)/100);
					$total_price += $article_total_price;
					$total_price_pdv += $article_total_price*((100+$ptr[1][0]->tax)/100);
					$total_norebateprice += $ptr[1][0]->price  * $data[1] ;
					$total_norebateprice_pdv += $ptr[1][0]->price  * $data[1] * ((100+$ptr[1][0]->tax)/100);
					
					$shop_table_body .= '<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; ">
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$i.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["code"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["name"].' <br /> '.$attrstr.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["unitname"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$data[1].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price * (1+$ptr[1][0]->tax/100), 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$ptr[1][0]->rebate.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price_pdv, 2, ",", ".").'</td>
										</tr>';
				}
			}	
			else
			{
				echo "fail update document".mysql_error();	
			}
		}
		else
		{
			echo "fail insert document".mysql_error();
		}	
	}
	/*	mailing	*/
		$msg =Invoice::getInvoiceMsg($userdetails,$reservation_number,$shop_table_body,$total_norebateprice,$total_norebateprice_pdv,$total_rebate,$total_rebate_pdv,$total_price,$total_price_pdv,$user_conf["b2b_document_prefix"][1]);
		// kupac
        GlobalHelper::sendEmailReservation(array('client'=>$ord_adr, 'seller'=>$user_conf["b2b_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina br '.$reservation_number , 'seller'=>' Nova porudzbina na sajtu '), $msg );
	/*	mailing	*/
			
	$_SESSION['shopcartB2B'] = array();

	


	/*	mp	*/


	$b2cproids = "";
	foreach($_SESSION['shopcart'] as $p=>$d)
	{
		$data = $d['id'];
		if($d['qty'] == 0) {continue;}
		$b2cproids .= $d['id'].",";
	}
	$b2cproids = substr($b2cproids, 0,-1);
	$query = "SELECT productid, warehouseid FROM productwarehouse WHERE productid in (".$b2cproids.") AND warehouseid in (".$b2cstr.") ORDER BY warehouseid";
	$cre = $mysqli->query($query);
	
	$b2cwarehouse1 = array();
	$b2cwarehouse2 = array();
		
	while($crow = $cre->fetch_assoc())
	{
		if($b2carr[0] == $crow['warehouseid'])
		{
			foreach($_SESSION['shopcart'] as $p=>$d)
			{
				$data = $d['id'];
				$attr = $d['attr'];
				$qty = $d['qty'];
				if($data == $crow['productid'])
				{
					array_push($b2cwarehouse1, $crow['productid'].":".$qty.":".$attr);	
				}
			}
		}
		if($b2carr[1] == $crow['warehouseid'])
		{
			foreach($_SESSION['shopcart'] as $p=>$d)
			{
				$data = $d['id'];
				$attr = $d['attr'];
				$qty = $d['qty'];
				if($data == $crow['productid'])
				{
					array_push($b2cwarehouse2, $crow['productid'].":".$qty.":".$attr);	
				}
			}
		}
	}
	
///////////////////////////////////
	$total_price = 0;
	$total_price_pdv = 0;
	$shop_table_body = '';

	$total_rebate = 0;
	$total_rebate_pdv = 0;
	$total_price = 0;
	$total_price_pdv = 0;
	$total_norebateprice = 0;
	$total_norebateprice_pdv = 0;
///////////////////////////////////

	if(!empty($b2cwarehouse1))
	{
		$reservation_number = Shop::createReservationNumber();
		$query = "INSERT INTO `document` (`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES (NULL, '0', 'web', 'RSD',  NOW(), NOW(), '', '0', NULL, NULL, '".$reservation_number."', '".$_SESSION['partnerid']."', 'n', 'H', '".$b2carr[0]."', '1', 'n', NULL, NULL, NULL, NOW(), NULL, NULL, NULL, 'n', NULL, NULL, CURRENT_TIMESTAMP)";
		
		if($mysqli->query($query))
		{	
			$lastid = $mysqli->insert_id;
			$query = "UPDATE document SET number = 'mp/".$reservation_number."' WHERE `ID`=$lastid";
			if($mysqli->query($query))
			{	
				$i=0;				
				foreach($b2cwarehouse1 as $p=>$d)
				{
					$i++;
					$data = explode(":",$d);
					if($data[1] == 0) {continue;}
					$sendb2cmail = true;
					$ptr = Category::getCategoryProductDetail(array($data[0]));
					$ptr[1][0]->price = $ptr[1][0]->price*$valute; 
					$query = "SELECT p.name, p.code, p.unitname, t.id AS taxid, t.value FROM product p LEFT JOIN tax t ON p.taxid = t.id WHERE p.id = ".$data[0];
					$re = $mysqli->query($query);
					
					$base = $re->fetch_assoc();
					
					$itemvalue = (((100-$ptr[1][0]->rebate)*0.01)*$ptr[1][0]->price)*$data[1];
					
					$query = "INSERT INTO `documentitem` (`ID`, `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `documentitemts`) VALUES (NULL, '0', '0', 'T', '".$ptr[1][0]->rebate."', 'P', '".$lastid."', '0', 'P', '".$ptr[1][0]->price."', '0', '".$itemvalue."', '".$data[0]."', '".$mysqli->real_escape_string(str_replace("'","",$base["name"]))."', '".$data[1]."', '0', '".$base["value"]."', '".$base["taxid"]."', '0', CURRENT_TIMESTAMP)";
					
					$mysqli->query($query);
					
					$a = json_decode($data[2], true);
					$attrstr='';
					foreach ($a as $attr) {
						$attrstr.=GlobalHelper::getAttrName($attr[0]).':'.GlobalHelper::getAttrValName($attr[1]).' ';
					}
					
					$article_total_price = $ptr[1][0]->price  * $data[1] *(1-($ptr[1][0]->rebate/100));
                    $article_total_price_pdv = $ptr[1][0]->price * ((100+$ptr[1][0]->tax)/100) * $data[1] * (1-$ptr[1][0]->rebate/100);
                    					
					$total_rebate += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100);
					$total_rebate_pdv += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100)*((100+$ptr[1][0]->tax)/100);
					$total_price += $article_total_price;
					$total_price_pdv += $article_total_price*((100+$ptr[1][0]->tax)/100);
					$total_norebateprice += $ptr[1][0]->price  * $data[1] ;
					$total_norebateprice_pdv += $ptr[1][0]->price  * $data[1] * ((100+$ptr[1][0]->tax)/100);
					
					$shop_table_body .= '<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; ">
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$i.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["code"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["name"].' <br /> '.$attrstr.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["unitname"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$data[1].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price * (1+$ptr[1][0]->tax/100), 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$ptr[1][0]->rebate.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price_pdv, 2, ",", ".").'</td>
										</tr>';	
				}
			}	
			else
			{
				echo "fail update document".mysql_error();	
			}
		}
		else
		{
			echo "fail insert document".mysql_error();
		}	
	}
	
	if(!empty($b2cwarehouse2))
	{
		$reservation_number = Shop::createReservationNumber();
		$query = "INSERT INTO `document` (`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES (NULL, '0', 'web', 'RSD',  NOW(), NOW(), '', '-1', NULL, NULL, '".$reservation_number."', '".$_SESSION['partnerid']."', 'n', 'H', '".$b2carr[1]."', '1', 'n', NULL, NULL, NULL, NOW(), NULL, NULL, NULL, 'n', NULL, NULL, CURRENT_TIMESTAMP)";
		
		if($mysqli->query($query))
		{	
			$lastid = $mysqli->insert_id;
			$query = "UPDATE document SET number = 'mp/".$reservation_number."' WHERE `ID`=$lastid";
			if($mysqli->query($query))
			{	
				$i=0;
				foreach($b2cwarehouse2 as $p=>$d)
				{
					$i++;
					$data = explode(":",$d);
					if($data[1] == 0) {continue;}
					$sendb2cmail = true;
					$ptr = Category::getCategoryProductDetail(array($data[0]));
					$ptr[1][0]->price = $ptr[1][0]->price*$valute; 
					$query = "SELECT p.name, p.code, p.unitname, t.id AS taxid, t.value FROM product p LEFT JOIN tax t ON p.taxid = t.id WHERE p.id = ".$data[0];
					$re = $mysqli->query($query);
					
					$base = $re->fetch_assoc();
					
					$itemvalue = (((100-$ptr[1][0]->rebate)*0.01)*$ptr[1][0]->price)*$data[1];
					
					$query = "INSERT INTO `documentitem` (`ID`, `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `documentitemts`) VALUES (NULL, '0', '0', 'T', '".$ptr[1][0]->rebate."', 'P', '".$lastid."', '0', 'P', '".$ptr[1][0]->price."', '0', '".$itemvalue."', '".$data[0]."', '".$mysqli->real_escape_string(str_replace("'","",$base["name"]))."', '".$data[1]."', '0', '".$base["value"]."', '".$base["taxid"]."', '0', CURRENT_TIMESTAMP)";
					
					$mysqli->query($query);
					
					$a = json_decode($data[2], true);
					$attrstr='';
					foreach ($a as $attr) {
						$attrstr.=GlobalHelper::getAttrName($attr[0]).':'.GlobalHelper::getAttrValName($attr[1]).' ';
					}
					
					$article_total_price = $ptr[1][0]->price  * $data[1] *(1-($ptr[1][0]->rebate/100));
                    $article_total_price_pdv = $ptr[1][0]->price * ((100+$ptr[1][0]->tax)/100) * $data[1] * (1-$ptr[1][0]->rebate/100);
                    					
					$total_rebate += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100);
					$total_rebate_pdv += $ptr[1][0]->price  * $data[1] * ($ptr[1][0]->rebate/100)*((100+$ptr[1][0]->tax)/100);
					$total_price += $article_total_price;
					$total_price_pdv += $article_total_price*((100+$ptr[1][0]->tax)/100);
					$total_norebateprice += $ptr[1][0]->price  * $data[1] ;
					$total_norebateprice_pdv += $ptr[1][0]->price  * $data[1] * ((100+$ptr[1][0]->tax)/100);
					
					$shop_table_body .= '<tr style="border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333; ">
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$i.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["code"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["name"].' <br /> '.$attrstr.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$base["unitname"].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$data[1].'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($ptr[1][0]->price * (1+$ptr[1][0]->tax/100), 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.$ptr[1][0]->rebate.'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price, 2, ",", ".").'</td>
											<td style="padding-left: 1mm; vertical-align: middle; 	padding-right: 1mm; padding-top: 1mm; padding-bottom: 1mm; text-align:right; font-family: \'Arial\'; font-size:11px !important;	line-height:12px; border-left:1px solid #333 !important; border-right:1px solid #333 !important;">'.number_format($article_total_price_pdv, 2, ",", ".").'</td>
										</tr>';	
				}
			}	
			else
			{
				echo "fail update document".mysql_error();	
			}
		}
		else
		{
			echo "fail insert document".mysql_error();
		}	
	}
	
	/*	mailing	*/
	$msg =Invoice::getInvoiceMsg($userdetails,$reservation_number,$shop_table_body,$total_norebateprice,$total_norebateprice_pdv,$total_rebate,$total_rebate_pdv,$total_price,$total_price_pdv,$user_conf["b2c_document_prefix"][1]);
	// kupac
       GlobalHelper::sendEmailReservation(array('client'=>$ord_adr, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina br '.$reservation_number , 'seller'=>' Nova porudzbina na sajtu '), $msg );
	/*	mailing	*/
	$_SESSION['shopcart'] = array();
	


}
	
	

}