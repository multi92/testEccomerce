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

        $q="select s.id, s.name, s.thumb, s.text, s.description, s.coordinates, s.worktime, s.email, s.phone, s.cellphone, s.fax,s.address, s.gallery_id, s.warehouseid, c.name as cityname, str.name as nametr, str.text as texttr, str.address as addresstr, str.description as descriptiontr, ctr.name as citynametr  from shop as s
              LEFT JOIN city as c on s.cityid = c.id
			  LEFT JOIN shop_tr str ON s.id = str.shopid
			  LEFT JOIN city_tr ctr ON c.id = ctr.cityid
              where s.id=".$id." 
			  	AND (str.langid = ".$_SESSION['langid']." OR str.langid IS NULL ) 
				AND (ctr.langid = ".$_SESSION['langid']." OR ctr.langid IS NULL )";

        $result=$mysqli->query($q);

        $row = 0;
        if($result->num_rows >0) {
            $row = $result->fetch_assoc();
            if($row['thumb'] == '' or $row['thumb'] == NULL){
                $row['thumb'] = 'fajlovi/logo.jpg';
            }
			
			$row['name'] = ($row['nametr'] == NULL || $row['nametr'] == '')? $row['name']:$row['nametr'];
			$row['text'] = ($row['texttr'] == NULL || $row['texttr'] == '')? $row['text']:$row['texttr'];
			$row['address'] = ($row['addresstr'] == NULL || $row['addresstr'] == '')? $row['address']:$row['addresstr'];
			$row['description'] = ($row['descriptiontr'] == NULL || $row['descriptiontr'] == '')? $row['description']:$row['descriptiontr'];
			$row['cityname'] = ($row['citynametr'] == NULL || $row['citynametr'] == '')? $row['cityname']:$row['citynametr'];
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
	
	public static function createReservationNumberB2C($documenttype){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT COUNT(ID) as num FROM b2c_document WHERE documenttype='".$documenttype."' AND YEAR(documentdate) = YEAR(CURDATE())";	
		$res=$mysqli->query($q);

		$number = "";
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$number = (intval($row['num'])+1)."/".date("Y")."_WEB"; 	
		}
		
		return $number;
	}
	
	public static function createReservationNumberB2B($documenttype){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT COUNT(ID) as num FROM b2b_document WHERE documenttype='".$documenttype."' AND YEAR(documentdate) = YEAR(CURDATE()) ";	
		$res=$mysqli->query($q);

		$number = "";
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$number = (intval($row['num'])+1)."/".date("Y")."_WEB_B2B"; 	
		}
		
		return $number;
	}

    public static function getOrderItemDataFromSession(){
        global $user_conf;
        $data = array();
            // prepare item for insert
            foreach($_SESSION['shopcart'] as $key=>$val){
                //var_dump($productdata);
                $productdata = array();
                $productdata = Product::getProductDataById($val['id']);
                
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
                    $data[$val['id']]['taxid'] = $productdata['taxid'];
                    $tx=0;
                    if($val['tax']>0){$tx=$val['tax'];}
                    $data[$val['id']]['tax'] = $tx;
                    $data[$val['id']]['pic'] = $val['pic'];
                    $data[$val['id']]['qty'] = intval($val['qty']);
                    $data[$val['id']]['attr'] = array();
                    
                    $attrdata = json_decode($val['attr']);
                    $tmparray = array();
					if(isset($attrdata) && is_array($attrdata))
					{ 
						foreach($attrdata as $k=>$v){
							array_push($tmparray, $v[1]);   
						}
					}
                    array_push($data[$val['id']]['attr'], array($tmparray, intval($val['qty'])));
                }
            }
            
            
        return $data;
    }


    public static function getOrderItemRequestDataFromSession(){
        $data = array();
            // prepare item for insert
            foreach($_SESSION['shopcart_request'] as $key=>$val){
                
                $productdata = Product::getProductDataById($val['id']);
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
                    $data[$val['id']]['taxid'] = $productdata['taxid'];
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
        return $data;
    }
	public static function getOrderItemTotalValueFromSession(){
        global $user_conf;
        $data = array();
            // prepare item for insert
			$orderTotalValueWithVat = 0;
            foreach($_SESSION['shopcart'] as $key=>$val){
             
				$data[$val['id']] = array();
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
				
				
				$orderTotalValueWithVat += $val['price']*intval($val['qty'])*(1-($item_rebate/100))*(1+($val['tax']/100));
				
            }
        return $orderTotalValueWithVat;
    }

    public static function createReservationFromSessionB2C(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!empty($_SESSION['shopcart']) && isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) ){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = Shop::createReservationNumberB2C('E');
            $orderDocumentType = 'E';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["comment"]) && $_SESSION["order"]["comment"]!=''){
                $orderComment='WEB - '.$_SESSION["order"]["comment"];
            }
            $orderDescription = '' ; 
            $orderPartnerId = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
            $orderPartnerAddressId = (isset($_SESSION['partneraddressid']))? $_SESSION['partneraddressid'] : '0';
            $orderStatus = 'n' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = (isset($_SESSION['warehouseid']))? $_SESSION['warehouseid'] : '0';
            $orderPayment = 'n'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["paymenttype"]) && $_SESSION["order"]["paymenttype"]!=''){
                $orderPayment = $_SESSION["order"]["paymenttype"];
            }
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
			 if(isset($_SESSION["voucher"]) && isset($_SESSION["voucher"]["id"]) && $_SESSION["voucher"]["id"]!=''){
                $orderUsedCouponId = $_SESSION["voucher"]["id"];
            }
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2C_ReservationId = 0;
            $orderB2C_WebReservationId = 0;
            $orderB2C_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2C = "INSERT INTO `b2c_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`, `valutedate`,`admitiondocumentdate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2c_reservationid`, `b2c_webreservationid`, `b2c_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".$mysqli->real_escape_string($orderNumber)."',
                                                 '".$mysqli->real_escape_string($orderDocumentType)."',
                                                 '".$mysqli->real_escape_string($orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                  ".$orderAddmitionDocumentDate.",
                                                 '".$mysqli->real_escape_string($orderComment)."',
                                                 '".$mysqli->real_escape_string($orderDescription)."',
                                                  ".$mysqli->real_escape_string($orderPartnerId).",
                                                  ".$mysqli->real_escape_string($orderPartnerAddressId).",
                                                 '".$mysqli->real_escape_string($orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".$mysqli->real_escape_string($orderWarehouseId).",
                                                 '".$orderPayment."',
                                                  ".$orderCouponId.", 
                                                  ".$orderUsedCouponId.", 
                                                 '".$orderDeliveryCode."',
                                                 '".$orderOrigin."',
                                                 '".$orderBankStatus."',
                                                  ".$orderB2C_ReservationId.", 
                                                  ".$orderB2C_WebReservationId.", 
                                                  ".$orderB2C_RelatedDocumentId.", 
                                                 '".$orderTimeStart."', 
                                                  ".$orderUserId.", 
                                                  ".$orderLastModifiedUserId.", 
                                                  ".$orderTimestamp."
                                              )";

            $mysqli->query($sqlInsertDocumentB2C);
            $lastDocumentId = $mysqli->insert_id;
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2C_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = (isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0 )? $_SESSION['order']['comment'] : '';
            $orderDetail_CustomerName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['name']) && strlen($_SESSION['order']['customer']['name'])>0 )? $_SESSION['order']['customer']['name'] : '';
            $orderDetail_CustomerLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['lastname']) && strlen($_SESSION['order']['customer']['lastname'])>0 )? $_SESSION['order']['customer']['lastname'] : '';
            $orderDetail_CustomerEmail = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) && strlen($_SESSION['order']['customer']['email'])>0 )? $_SESSION['order']['customer']['email'] : '';
            $orderDetail_CustomerPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['phone']) && strlen($_SESSION['order']['customer']['phone'])>0 )? $_SESSION['order']['customer']['phone'] : '';
            $orderDetail_CustomerAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['address']) && strlen($_SESSION['order']['customer']['address'])>0 )? $_SESSION['order']['customer']['address'] : '';
            $orderDetail_CustomerCity = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['city']) && strlen($_SESSION['order']['customer']['city'])>0 )? $_SESSION['order']['customer']['city'] : '';
            $orderDetail_CustomerZip = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['zip']) && strlen($_SESSION['order']['customer']['zip'])>0 )? $_SESSION['order']['customer']['zip'] : '';
            $orderDetail_RecipientName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['name']) && strlen($_SESSION['order']['recipient']['name'])>0 )? $_SESSION['order']['recipient']['name'] : '';
            $orderDetail_RecipientLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['lastname']) && strlen($_SESSION['order']['recipient']['lastname'])>0 )? $_SESSION['order']['recipient']['lastname'] : '';
            $orderDetail_RecipientPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['phone']) && strlen($_SESSION['order']['recipient']['phone'])>0 )? $_SESSION['order']['recipient']['phone'] : '';
            $orderDetail_RecipientAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['address']) && strlen($_SESSION['order']['recipient']['address'])>0 )? $_SESSION['order']['recipient']['address'] : '';
            $orderDetail_RecipientCity = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['city']) && strlen($_SESSION['order']['recipient']['city'])>0 )? $_SESSION['order']['recipient']['city'] : '';
            $orderDetail_RecipientZip = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['zip']) && strlen($_SESSION['order']['recipient']['zip'])>0 )? $_SESSION['order']['recipient']['zip'] : '';
            $orderDetail_DeliveryType = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['type']) && strlen($_SESSION['order']['delivery']['type'])>0 )? $_SESSION['order']['delivery']['type'] : '';
            $orderDetail_DeliveryShopId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliverypersonalid']) )? $_SESSION['order']['delivery']['deliverypersonalid'] : 0;
            $orderDetail_DeliveryServiceId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliveryserviceid']) )? $_SESSION['order']['delivery']['deliveryserviceid'] : 0;
			$orderDetail_DeliveryCost = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliverycost']) )? $_SESSION['order']['delivery']['deliverycost'] : 0;
            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2C = "INSERT INTO b2c_documentdetail (`b2c_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`, `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `deliverycost`, `ts`) 
                                                                   VALUES (".$orderDetail_B2C_DocumentId.",
                                                                          '".$mysqli->real_escape_string($orderDetail_AdditionalComment)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerEmail)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
																		   ".$orderDetail_DeliveryCost.",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
																		 
            $mysqli->query($sqlInsertDocumentDetailB2C);
////////////INSERT DOCUMENT DETAIL DATA END
////////////PREPARE DOCUMENT INTEM DATA
            $orderItemdata = array();
            $orderItemdata = self::getOrderItemDataFromSession();
            $orderItemCount=0;
////////////PREPARE DOCUMENT INTEM DATA END
////////////INSERT DOCUMENT ITEM DATA
            foreach($orderItemdata as $key=>$val){
                $orderItemCount++;

                $orderItem_Id = '';
                $orderItem_DocumentItemId = '';
                $orderItem_Rebate = $val['rebate'];
                $orderItem_RebateType = 'P';
                $orderItem_B2C_DocumentId = $lastDocumentId;
                $orderItem_Price = $val['price'];
                $orderItem_Price2 = 0;
                $orderItem_ItemValue = $val['price']*((100-intval($val['rebate']))/100)*$val['qty'];
                $orderItem_ProductId = $key;
                $orderItem_ProductName = $val['name'];
                $orderItem_ProductAttrString = $val['attr'];
                $orderItem_ProductImageString = $val['pic'];
                $orderItem_Quantity = $val['qty'];
                $orderItem_Sort = $orderItemCount;
                $orderItem_TaxValue = $val['tax'];
                $orderItem_TaxId = $val['taxid'];
                $orderItem_TimeStamp = 'CURRENT_TIMESTAMP';

                $sqlInsertDocumentItemB2C = "INSERT INTO `b2c_documentitem`(`id`, `documentitemid`, `rebate`, `rebatetype`, `b2c_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `productattrstring`,`productimage`, `quantity`, 
                                                     `sort`, `taxvalue`, `taxid`, `ts`) 
                                             VALUES ('".$orderItem_Id."', 
                                                     '".$orderItem_DocumentItemId."', 
                                                      ".$orderItem_Rebate.", 
                                                     '".$orderItem_RebateType."', 
                                                      ".$orderItem_B2C_DocumentId.", 
                                                      ".$orderItem_Price.",
                                                      ".$orderItem_Price2.", 
                                                      ".$orderItem_ItemValue.", 
                                                      ".$orderItem_ProductId.",
                                                     '".$orderItem_ProductName."',
                                                     '".json_encode($orderItem_ProductAttrString)."',
                                                     '".$orderItem_ProductImageString."',
                                                      ".$orderItem_Quantity.",
                                                      ".$orderItem_Sort.",
                                                      ".$orderItem_TaxValue.",
                                                      ".$orderItem_TaxId.", 
                                                      ".$orderItem_TimeStamp."
                                                 )"; 
                //echo $sqlInsertDocumentItemB2C;  

                $mysqli->query($sqlInsertDocumentItemB2C);
            
                $lastDocumentItemId = $mysqli->insert_id;
                foreach($val['attr'] as $k=>$v){
                    $orderItemAttrId = '';
                    $orderItemAttrValue = implode(",", $v[0]);
                    $orderItemAttrQuantity = $v[1];
                    $orderItemAttrTimeStamp = 'CURRENT_TIMESTAMP';
                    $sqlInsertDocumentItemAttributeB2C = "INSERT INTO `b2c_documentitemattr`(`id`, `b2c_documentitemid`, `attrvalue`, `quantity`, `ts`) 
                                                                                     VALUES ('".$orderItemAttrId."', 
                                                                                              ".$lastDocumentItemId.", 
                                                                                             '".$orderItemAttrValue."', 
                                                                                              ".$orderItemAttrQuantity.", 
                                                                                              ".$orderItemAttrTimeStamp."
                                                                                          )";
                    $mysqli->query($sqlInsertDocumentItemAttributeB2C);
                }
            }
           
////////////INSERT DOCUMENT ITEM DATA END 
//////////// CHANGE COUPON STATUS START
			if(isset($_SESSION['voucher']) && isset($_SESSION['voucher']['id'])){
				$q = "UPDATE `usercoupon` SET status = 'u' WHERE id = ".$_SESSION['voucher']['id'];
				$mysqli->query($q);
			}
//////////// CHANGE COUPON STATUS END

			if($orderPayment == 'k'){
				
////////////////*	PAYMENT WITH CREDIT CARD START	*/
				$coupon = 0;
				if(isset($_SESSION['voucher']) && isset($_SESSION['voucher']['value'])){
					$coupon = $_SESSION['voucher']['value'];	
				}
				
				$delivery_cost = 0;
				if(isset($_SESSION['order']['delivery']['deliverycost'])){
					$delivery_cost = floatval($_SESSION['order']['delivery']['deliverycost']);
				}
				
				$totalValueVat = Shop::getOrderItemTotalValueFromSession();
				
				$orgClientId = "13IN000015"; 
				$orgOid = $orderNumber;
				$orgAmount = $delivery_cost+$totalValueVat-$coupon; 
				if($orgAmount < 0) $orgAmount = 1;
				$orgAmount = number_format($orgAmount, 2, '.','');
				$orgOkUrl = "https://".$_SERVER["SERVER_NAME"]."/checkout_finished"; 
				$orgFailUrl = "https://".$_SERVER["SERVER_NAME"]."/checkout_finished_fail"; 
				$orgTransactionType = "PreAuth"; 
				$orgInstallment = ""; 
				
				function generateRandomString($length = 20) {
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
				}
				
				$orgRnd = generateRandomString(20);
				$orgCurrency = "941";
				
				$clientId = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgClientId)); 
				$oid = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgOid)); 
				$amount = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgAmount)); 
				$okUrl = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgOkUrl)); 
				$failUrl = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgFailUrl)); 
				$transactionType = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgTransactionType)); 
				$installment = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgInstallment)); 
				$rnd = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgRnd));
				$currency = str_replace("|", "\\|", str_replace("\\", "\\\\", $orgCurrency)); 
				$storeKey = str_replace("|", "\\|", str_replace("\\", "\\\\", "P43mkw23rf9em3"));
				 
				$plainText = $clientId . "|" . $oid . "|" . $amount . "|" . $okUrl . "|" . $failUrl . "|" . $transactionType . "||" . $rnd . "||||" . $currency . "|" . $storeKey; 
				
				$hashValue = hash('sha512', $plainText); 
				$hash = base64_encode (pack('H*',$hashValue));
				
				/*
					BANCA INTESA produkcioni link
					https://bib.eway2pay.com/fim/est3Dgate
					TEST LINK https://testsecurepay.eway2pay.com/fim/est3Dgate
				*/
				$retdata = '<form method="post" action="https://testsecurepay.eway2pay.com/fim/est3Dgate" class="bankform" >
								<input type="hidden" name="clientid" value="'.$orgClientId.'">
								<input type="hidden" name="amount" value="'.$orgAmount.'">
								<input type="hidden" name="oid" value="'.$orgOid.'">
								<input type="hidden" name="okUrl" value="'.$orgOkUrl.'">
								<input type="hidden" name="failUrl" value="'.$orgFailUrl.'">
								<input type="hidden" name="trantype" value="'.$orgTransactionType.'">
								<input type="hidden" name="currency" value="'.$orgCurrency.'">
								<input type="hidden" name="rnd" value="'.$orgRnd.'">
								<input type="hidden" name="hash" value="'.$hash.'">
								<input type="hidden" name="storetype" value="3d_pay_hosting">
								<input type="hidden" name="hashAlgorithm" value="ver2">
								<input type="hidden" name="encoding" value="utf-8" />
								<input type="hidden" name="lang" value="sr">
							</form>';
							
				return array('status'=>"success", 'payment'=>'k', "form"=>$retdata);
////////////////*	PAYMENT WITH CREDIT CARD END	*/
			}
			else{
////////////////*	PAYMENT WITH NO CREDIT CARD START	*/
            	Shop::createOrderEmail($orderNumber);
				$retdata = '<form method="post" action="checkout_finished" class="bankform" >
									<input type="hidden" name="clientid" value="">
									<input type="hidden" name="amount" value="">
									<input type="hidden" name="oid" value="'.$orderNumber.'">
									<input type="hidden" name="okUrl" value="">
									<input type="hidden" name="failUrl" value="">
									<input type="hidden" name="trantype" value="">
									<input type="hidden" name="currency" value="">
									<input type="hidden" name="rnd" value="">
									<input type="hidden" name="hash" value="xxx">
									<input type="hidden" name="storetype" value="3d_pay_hosting"> 
									<input type="hidden" name="hashAlgorithm" value="ver2">
									<input type="hidden" name="encoding" value="utf-8" />
									<input type="hidden" name="lang" value="sr">
								</form>';
				return array('status'=>"success", 'payment'=>'p', "form"=>$retdata);
////////////////*	PAYMENT WITH NO CREDIT CARD END	*/
			}
            return 1;
        //SHOPCART EXISTS END
        }
        else{
            return 0;   
        }

    }

    public static function checkUserVoucher(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
        //SELECT *
        //FROM user_voucher AS uv
        //INNER JOIN voucher AS v ON uv.voucherid = v.id
        //WHERE uv.userid = 1127 AND uv.`status` = 'a' AND v.`status`='y' AND v.expirationdate > CURDATE() - INTERVAL 1 DAY;
        //$query = "select SQL_CALC_FOUND_ROWS id from shop where status = 'v' ".$citylimit.$typelimit." ORDER BY sort ASC ".$querylimit;
        $query = "SELECT * FROM user_voucher AS uv INNER JOIN voucher AS v ON uv.voucherid = v.id WHERE uv.userid=".$userID." AND uv.`status` = 'a' AND v.`status`='y' AND v.expirationdate > CURDATE() - INTERVAL 1 DAY AND uv.`vouchercode`=".$_SESSION['order']['customer']['voucher'];
        $res = $mysqli->query($query);
        if($res->num_rows>0){
            while($row = $res->fetch_assoc()){
             //Sada ako je row['voucher_type']=='hp' mi trebamo da updatujemo tabelu i da stavimo kada je datum iskoriscen, ako nije onda idemo na drugi slucaj sa update.
                if($row['voucher_type']=='hp'){
                    $updateQueryHP = "UPDATE `voucher` SET `useexpirationdate`=NOW()
                                        WHERE `id`=".$row['id']." AND `vouchertype`='hp'";
                    $res1=$mysqli->query($updateQueryHP);


                    $updateQueryHP1 = "UPDATE `user_voucher` SET `useddate`=NOW(),`status`='n'
                                        WHERE `userid`=".$row['userid']." AND `voucherid`='".$row['voucherid']."'  AND `status`='a' ";
                    $res2=$mysqli->query($updateQueryHP1);

                    return 1;
                }
                else{
                    if($row['voucher_type']=='w'){
                        $updateQueryW="UPDATE `voucher` SET `useexpirationdate`=NOW()
                                        WHERE `id`=".$row['id']." AND `vouchertype`='w'";
                        $res1 = $mysqli->query($updateQueryW);

                        $updateQueryHP2 = "UPDATE `user_voucher` SET `useddate`=NOW(),`status`='n'
                                        WHERE `userid`=".$row['userid']." AND `voucherid`='".$row['voucherid']."'  AND `status`='a' ";
                        $res2=$mysqli->query($updateQueryHP2);
                        return 1;
                    }
                    else{
                        return 0;
                    }
                }
            }
            return 1;
        }
        else{
            return 0;
        }
        

    }

    public static function createReservationRequestFromSessionB2C(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!empty($_SESSION['shopcart_request']) && isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) ){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = Shop::createReservationNumberB2C('Q');
            $orderDocumentType = 'Q';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["comment"]) && $_SESSION["order"]["comment"]!=''){
                $orderComment='WEB - '.$_SESSION["order"]["comment"];
            }
            $orderDescription = '' ; 
            $orderPartnerId = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
            $orderPartnerAddressId = (isset($_SESSION['partneraddressid']))? $_SESSION['partneraddressid'] : '0';
            $orderStatus = 'n' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = (isset($_SESSION['warehouseid']))? $_SESSION['warehouseid'] : '0';
            $orderPayment = 'n'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["paymenttype"]) && $_SESSION["order"]["paymenttype"]!=''){
                $orderPayment = $_SESSION["order"]["paymenttype"];
            }
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2C_ReservationId = 0;
            $orderB2C_WebReservationId = 0;
            $orderB2C_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
            $orderVoucher = 0;
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2C = "INSERT INTO `b2c_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`,`admitiondocumentdate`, `valutedate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2c_reservationid`, `b2c_webreservationid`, `b2c_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `voucherid` ,`ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".$mysqli->real_escape_string($orderNumber)."',
                                                 '".$mysqli->real_escape_string($orderDocumentType)."',
                                                 '".$mysqli->real_escape_string($orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
												  ".$orderAddmitionDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                 '".$mysqli->real_escape_string($orderComment)."',
                                                 '".$mysqli->real_escape_string($orderDescription)."',
                                                  ".$mysqli->real_escape_string($orderPartnerId).",
                                                  ".$mysqli->real_escape_string($orderPartnerAddressId).",
                                                 '".$mysqli->real_escape_string($orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".$mysqli->real_escape_string($orderWarehouseId).",
                                                 '".$orderPayment."',
                                                  ".$orderCouponId.", 
                                                  ".$orderUsedCouponId.", 
                                                 '".$orderDeliveryCode."',
                                                 '".$orderOrigin."',
                                                 '".$orderBankStatus."',
                                                  ".$orderB2C_ReservationId.", 
                                                  ".$orderB2C_WebReservationId.", 
                                                  ".$orderB2C_RelatedDocumentId.", 
                                                 '".$orderTimeStart."', 
                                                  ".$orderUserId.", 
                                                  ".$orderLastModifiedUserId.",
                                                  ".$orderVoucher.", 
                                                  ".$orderTimestamp."
                                              )";
			
            $mysqli->query($sqlInsertDocumentB2C);
            $lastDocumentId = $mysqli->insert_id;
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2C_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = (isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0 )? $_SESSION['order']['comment'] : '';
            $orderDetail_CustomerName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['name']) && strlen($_SESSION['order']['customer']['name'])>0 )? $_SESSION['order']['customer']['name'] : '';
            $orderDetail_CustomerLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['lastname']) && strlen($_SESSION['order']['customer']['lastname'])>0 )? $_SESSION['order']['customer']['lastname'] : '';
            $orderDetail_CustomerEmail = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) && strlen($_SESSION['order']['customer']['email'])>0 )? $_SESSION['order']['customer']['email'] : '';
            $orderDetail_CustomerPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['phone']) && strlen($_SESSION['order']['customer']['phone'])>0 )? $_SESSION['order']['customer']['phone'] : '';
            $orderDetail_CustomerAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['address']) && strlen($_SESSION['order']['customer']['address'])>0 )? $_SESSION['order']['customer']['address'] : '';
            $orderDetail_CustomerCity = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['city']) && strlen($_SESSION['order']['customer']['city'])>0 )? $_SESSION['order']['customer']['city'] : '';
            $orderDetail_CustomerZip = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['zip']) && strlen($_SESSION['order']['customer']['zip'])>0 )? $_SESSION['order']['customer']['zip'] : '';
            $orderDetail_RecipientName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['name']) && strlen($_SESSION['order']['recipient']['name'])>0 )? $_SESSION['order']['recipient']['name'] : '';
            $orderDetail_RecipientLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['lastname']) && strlen($_SESSION['order']['recipient']['lastname'])>0 )? $_SESSION['order']['recipient']['lastname'] : '';
            $orderDetail_RecipientPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['phone']) && strlen($_SESSION['order']['recipient']['phone'])>0 )? $_SESSION['order']['recipient']['phone'] : '';
            $orderDetail_RecipientAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['address']) && strlen($_SESSION['order']['recipient']['address'])>0 )? $_SESSION['order']['recipient']['address'] : '';
            $orderDetail_RecipientCity = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['city']) && strlen($_SESSION['order']['recipient']['city'])>0 )? $_SESSION['order']['recipient']['city'] : '';
            $orderDetail_RecipientZip = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['zip']) && strlen($_SESSION['order']['recipient']['zip'])>0 )? $_SESSION['order']['recipient']['zip'] : '';
            $orderDetail_DeliveryType = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['type']) && strlen($_SESSION['order']['delivery']['type'])>0 )? $_SESSION['order']['delivery']['type'] : '';
            $orderDetail_DeliveryShopId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliverypersonalid']) )? $_SESSION['order']['delivery']['deliverypersonalid'] : 0;
            $orderDetail_DeliveryServiceId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliveryserviceid']) )? $_SESSION['order']['delivery']['deliveryserviceid'] : 0;
            
            if(self::checkUserVoucher()==0){
                $orderDetail_RecipientVoucher = 0;
            }else{
                $orderDetail_RecipientVoucher = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['voucher']) && strlen($_SESSION['order']['recipient']['voucher'])>0 )? $_SESSION['order']['recipient']['voucher'] : '';
            }



            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2C = "INSERT INTO b2c_documentdetail (`b2c_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`,
                                                                           `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `voucherid`, `ts` ) 
                                                                   VALUES (".$orderDetail_B2C_DocumentId.",
                                                                          '".$mysqli->real_escape_string($orderDetail_AdditionalComment)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerEmail)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
                                                                           ".$mysqli->real_escape_string($orderDetail_RecipientVoucher).",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
            $mysqli->query($sqlInsertDocumentDetailB2C);
////////////INSERT DOCUMENT DETAIL DATA END
////////////PREPARE DOCUMENT INTEM DATA
            $orderItemdata = array();
            $orderItemdata = self::getOrderItemRequestDataFromSession();
            $orderItemCount=0;
////////////PREPARE DOCUMENT INTEM DATA END
////////////INSERT DOCUMENT ITEM DATA
            foreach($orderItemdata as $key=>$val){
                $orderItemCount++;

                $orderItem_Id = '';
                $orderItem_DocumentItemId = '';
                $orderItem_Rebate = $val['rebate'];
                $orderItem_RebateType = 'P';
                $orderItem_B2C_DocumentId = $lastDocumentId;
                $orderItem_Price = $val['price'];
                $orderItem_Price2 = 0;
                $orderItem_ItemValue = $val['price']*((100-intval($val['rebate']))/100)*$val['qty'];
                $orderItem_ProductId = $key;
                $orderItem_ProductName = $val['name'];
                $orderItem_ProductAttrString = $val['attr'];
                $orderItem_ProductImageString = $val['pic'];
                $orderItem_Quantity = $val['qty'];
                $orderItem_Sort = $orderItemCount;
                $orderItem_TaxValue = $val['tax'];
                $orderItem_TaxId = $val['taxid'];
                $orderItem_TimeStamp = 'CURRENT_TIMESTAMP';

                $sqlInsertDocumentItemB2C = "INSERT INTO `b2c_documentitem`(`id`, `documentitemid`, `rebate`, `rebatetype`, `b2c_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `productattrstring`, `productimage`, `quantity`, 
                                                     `sort`, `taxvalue`, `taxid`, `ts`) 
                                             VALUES ('".$orderItem_Id."', 
                                                     '".$orderItem_DocumentItemId."', 
                                                      ".$orderItem_Rebate.", 
                                                     '".$orderItem_RebateType."', 
                                                      ".$orderItem_B2C_DocumentId.", 
                                                      ".$orderItem_Price.",
                                                      ".$orderItem_Price2.", 
                                                      ".$orderItem_ItemValue.", 
                                                      ".$orderItem_ProductId.",
                                                     '".$orderItem_ProductName."',
                                                     '".json_encode($orderItem_ProductAttrString)."',
                                                     '".$orderItem_ProductImageString."',
                                                      ".$orderItem_Quantity.",
                                                      ".$orderItem_Sort.",
                                                      ".$orderItem_TaxValue.",
                                                      ".$orderItem_TaxId.", 
                                                      ".$orderItem_TimeStamp."
                                                 )";    
                $mysqli->query($sqlInsertDocumentItemB2C);
            
                $lastDocumentItemId = $mysqli->insert_id;
                foreach($val['attr'] as $k=>$v){
                    $orderItemAttrId = '';
                    $orderItemAttrValue = implode(",", $v[0]);
                    $orderItemAttrQuantity = $v[1];
                    $orderItemAttrTimeStamp = 'CURRENT_TIMESTAMP';
                    $sqlInsertDocumentItemAttributeB2C = "INSERT INTO `b2c_documentitemattr`(`id`, `b2c_documentitemid`, `attrvalue`, `quantity`, `ts`) 
                                                                                     VALUES ('".$orderItemAttrId."', 
                                                                                              ".$lastDocumentItemId.", 
                                                                                             '".$orderItemAttrValue."', 
                                                                                              ".$orderItemAttrQuantity.", 
                                                                                              ".$orderItemAttrTimeStamp."
                                                                                          )";
                    $mysqli->query($sqlInsertDocumentItemAttributeB2C);
                }
            }
////////////INSERT DOCUMENT ITEM DATA END 
			
			Shop::createOrderRequestEmail($orderNumber);
			return array('status'=>"success");
			
        //SHOPCART EXISTS END
        }
        else{
            return array('status'=>"error");
        }

    }


    public static function createReservationFromSessionB2B(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!empty($_SESSION['shopcart']) && isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) ){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = Shop::createReservationNumberB2B('E');
            $orderDocumentType = 'E';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["comment"]) && $_SESSION["order"]["comment"]!=''){
                $orderComment='WEB - '.$_SESSION["order"]["comment"];
            }
            $orderDescription = '' ; 
            $orderPartnerId = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
            $orderPartnerAddressId = (isset($_SESSION['partneraddressid']))? $_SESSION['partneraddressid'] : '0';
            $orderStatus = 'n' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = (isset($_SESSION['warehouseid']))? $_SESSION['warehouseid'] : '0';
            $orderPayment = 'n'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["paymenttype"]) && $_SESSION["order"]["paymenttype"]!=''){
                $orderPayment = $_SESSION["order"]["paymenttype"];
            }
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2B_ReservationId = 0;
            $orderB2B_WebReservationId = 0;
            $orderB2B_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2B = "INSERT INTO `b2b_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`, `valutedate`,`admitiondocumentdate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2b_reservationid`, `b2b_webreservationid`, `b2b_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".$mysqli->real_escape_string($orderNumber)."',
                                                 '".$mysqli->real_escape_string($orderDocumentType)."',
                                                 '".$mysqli->real_escape_string($orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                  ".$orderAddmitionDocumentDate.",
                                                 '".$mysqli->real_escape_string($orderComment)."',
                                                 '".$mysqli->real_escape_string($orderDescription)."',
                                                  ".$mysqli->real_escape_string($orderPartnerId).",
                                                  ".$mysqli->real_escape_string($orderPartnerAddressId).",
                                                 '".$mysqli->real_escape_string($orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".$mysqli->real_escape_string($orderWarehouseId).",
                                                 '".$orderPayment."',
                                                  ".$orderCouponId.", 
                                                  ".$orderUsedCouponId.", 
                                                 '".$orderDeliveryCode."',
                                                 '".$orderOrigin."',
                                                 '".$orderBankStatus."',
                                                  ".$orderB2B_ReservationId.", 
                                                  ".$orderB2B_WebReservationId.", 
                                                  ".$orderB2B_RelatedDocumentId.", 
                                                 '".$orderTimeStart."', 
                                                  ".$orderUserId.", 
                                                  ".$orderLastModifiedUserId.", 
                                                  ".$orderTimestamp."
                                              )";

            $mysqli->query($sqlInsertDocumentB2B);
            $lastDocumentId = $mysqli->insert_id;
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2B_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = (isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0 )? $_SESSION['order']['comment'] : '';
            $orderDetail_CustomerName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['name']) && strlen($_SESSION['order']['customer']['name'])>0 )? $_SESSION['order']['customer']['name'] : '';
            $orderDetail_CustomerLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['lastname']) && strlen($_SESSION['order']['customer']['lastname'])>0 )? $_SESSION['order']['customer']['lastname'] : '';
            $orderDetail_CustomerEmail = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) && strlen($_SESSION['order']['customer']['email'])>0 )? $_SESSION['order']['customer']['email'] : '';
            $orderDetail_CustomerPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['phone']) && strlen($_SESSION['order']['customer']['phone'])>0 )? $_SESSION['order']['customer']['phone'] : '';
            $orderDetail_CustomerAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['address']) && strlen($_SESSION['order']['customer']['address'])>0 )? $_SESSION['order']['customer']['address'] : '';
            $orderDetail_CustomerCity = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['city']) && strlen($_SESSION['order']['customer']['city'])>0 )? $_SESSION['order']['customer']['city'] : '';
            $orderDetail_CustomerZip = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['zip']) && strlen($_SESSION['order']['customer']['zip'])>0 )? $_SESSION['order']['customer']['zip'] : '';
            $orderDetail_RecipientName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['name']) && strlen($_SESSION['order']['recipient']['name'])>0 )? $_SESSION['order']['recipient']['name'] : '';
            $orderDetail_RecipientLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['lastname']) && strlen($_SESSION['order']['recipient']['lastname'])>0 )? $_SESSION['order']['recipient']['lastname'] : '';
            $orderDetail_RecipientPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['phone']) && strlen($_SESSION['order']['recipient']['phone'])>0 )? $_SESSION['order']['recipient']['phone'] : '';
            $orderDetail_RecipientAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['address']) && strlen($_SESSION['order']['recipient']['address'])>0 )? $_SESSION['order']['recipient']['address'] : '';
            $orderDetail_RecipientCity = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['city']) && strlen($_SESSION['order']['recipient']['city'])>0 )? $_SESSION['order']['recipient']['city'] : '';
            $orderDetail_RecipientZip = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['zip']) && strlen($_SESSION['order']['recipient']['zip'])>0 )? $_SESSION['order']['recipient']['zip'] : '';
            $orderDetail_DeliveryType = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['type']) && strlen($_SESSION['order']['delivery']['type'])>0 )? $_SESSION['order']['delivery']['type'] : '';
            $orderDetail_DeliveryShopId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliverypersonalid']) )? $_SESSION['order']['delivery']['deliverypersonalid'] : 0;
            $orderDetail_DeliveryServiceId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliveryserviceid']) )? $_SESSION['order']['delivery']['deliveryserviceid'] : 0;
            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2B = "INSERT INTO b2b_documentdetail (`b2b_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`,
                                                                           `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `ts` ) 
                                                                   VALUES (".$orderDetail_B2B_DocumentId.",
                                                                          '".$mysqli->real_escape_string($orderDetail_AdditionalComment)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerEmail)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
            $mysqli->query($sqlInsertDocumentDetailB2B);
////////////INSERT DOCUMENT DETAIL DATA END
////////////PREPARE DOCUMENT INTEM DATA
            $orderItemdata = array();
            $orderItemdata = self::getOrderItemDataFromSession();
            $orderItemCount=0;
////////////PREPARE DOCUMENT INTEM DATA END
////////////INSERT DOCUMENT ITEM DATA
            foreach($orderItemdata as $key=>$val){
                $orderItemCount++;

                $orderItem_Id = '';
                $orderItem_DocumentItemId = '';
                $orderItem_Rebate = $val['rebate'];
                $orderItem_RebateType = 'P';
                $orderItem_B2B_DocumentId = $lastDocumentId;
                $orderItem_Price = $val['price'];
                $orderItem_Price2 = 0;
                $orderItem_ItemValue = $val['price']*((100-intval($val['rebate']))/100)*$val['qty'];
                $orderItem_ProductId = $key;
                $orderItem_ProductName = $val['name'];
                $orderItem_ProductAttrString = $val['attr'];
                $orderItem_ProductImageString = $val['pic'];
                $orderItem_Quantity = $val['qty'];
                $orderItem_Sort = $orderItemCount;
                $orderItem_TaxValue = $val['tax'];
                $orderItem_TaxId = $val['taxid'];
                $orderItem_TimeStamp = 'CURRENT_TIMESTAMP';

                $sqlInsertDocumentItemB2B = "INSERT INTO `b2b_documentitem`(`id`, `documentitemid`, `rebate`, `rebatetype`, `b2b_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `productattrstring`,`productimage`, `quantity`, 
                                                     `sort`, `taxvalue`, `taxid`, `ts`) 
                                             VALUES ('".$orderItem_Id."', 
                                                     '".$orderItem_DocumentItemId."', 
                                                      ".$orderItem_Rebate.", 
                                                     '".$orderItem_RebateType."', 
                                                      ".$orderItem_B2B_DocumentId.", 
                                                      ".$orderItem_Price.",
                                                      ".$orderItem_Price2.", 
                                                      ".$orderItem_ItemValue.", 
                                                      ".$orderItem_ProductId.",
                                                     '".$orderItem_ProductName."',
                                                     '".json_encode($orderItem_ProductAttrString)."',
                                                     '".$orderItem_ProductImageString."',
                                                      ".$orderItem_Quantity.",
                                                      ".$orderItem_Sort.",
                                                      ".$orderItem_TaxValue.",
                                                      ".$orderItem_TaxId.", 
                                                      ".$orderItem_TimeStamp."
                                                 )";    
                $mysqli->query($sqlInsertDocumentItemB2B);
            
                $lastDocumentItemId = $mysqli->insert_id;
                foreach($val['attr'] as $k=>$v){
                    $orderItemAttrId = '';
                    $orderItemAttrValue = implode(",", $v[0]);
                    $orderItemAttrQuantity = $v[1];
                    $orderItemAttrTimeStamp = 'CURRENT_TIMESTAMP';
                    $sqlInsertDocumentItemAttributeB2B = "INSERT INTO `b2b_documentitemattr`(`id`, `b2b_documentitemid`, `attrvalue`, `quantity`, `ts`) 
                                                                                     VALUES ('".$orderItemAttrId."', 
                                                                                              ".$lastDocumentItemId.", 
                                                                                             '".$orderItemAttrValue."', 
                                                                                              ".$orderItemAttrQuantity.", 
                                                                                              ".$orderItemAttrTimeStamp."
                                                                                          )";
                    $mysqli->query($sqlInsertDocumentItemAttributeB2B);
                }
            }
////////////INSERT DOCUMENT ITEM DATA END 
            Shop::createOrderEmailB2B($orderNumber);
			$retdata = '<form method="post" action="checkout_finished" class="bankform" >
									<input type="hidden" name="clientid" value="">
									<input type="hidden" name="amount" value="">
									<input type="hidden" name="oid" value="'.$orderNumber.'">
									<input type="hidden" name="okUrl" value="">
									<input type="hidden" name="failUrl" value="">
									<input type="hidden" name="trantype" value="">
									<input type="hidden" name="currency" value="">
									<input type="hidden" name="rnd" value="">
									<input type="hidden" name="hash" value="xxx">
									<input type="hidden" name="storetype" value="3d_pay_hosting">
									<input type="hidden" name="hashAlgorithm" value="ver2">
									<input type="hidden" name="encoding" value="utf-8" />
									<input type="hidden" name="lang" value="sr">
								</form>';
			return array('status'=>"success", 'payment'=>'p', "form"=>$retdata);
        //SHOPCART EXISTS END
        }
        else{
            return 0;   
        }
    }

    public static function createReservationRequestFromSessionB2B(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!empty($_SESSION['shopcart_request']) && isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) && isset($_SESSION['email'])){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = Shop::createReservationNumberB2B('Q');
            $orderDocumentType = 'Q';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["comment"]) && $_SESSION["order"]["comment"]!=''){
                $orderComment='WEB - '.$_SESSION["order"]["comment"];
            }
            $orderDescription = '' ; 
            $orderPartnerId = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
            $orderPartnerAddressId = (isset($_SESSION['partneraddressid']))? $_SESSION['partneraddressid'] : '0';
            $orderStatus = 'n' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = (isset($_SESSION['warehouseid']))? $_SESSION['warehouseid'] : '0';
            $orderPayment = 'n'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["paymenttype"]) && $_SESSION["order"]["paymenttype"]!=''){
                $orderPayment = $_SESSION["order"]["paymenttype"];
            }
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2B_ReservationId = 0;
            $orderB2B_WebReservationId = 0;
            $orderB2B_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2B = "INSERT INTO `b2b_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`, `valutedate`,`admitiondocumentdate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2b_reservationid`, `b2b_webreservationid`, `b2b_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".$mysqli->real_escape_string($orderNumber)."',
                                                 '".$mysqli->real_escape_string($orderDocumentType)."',
                                                 '".$mysqli->real_escape_string($orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                  ".$orderAddmitionDocumentDate.",
                                                 '".$mysqli->real_escape_string($orderComment)."',
                                                 '".$mysqli->real_escape_string($orderDescription)."',
                                                  ".$mysqli->real_escape_string($orderPartnerId).",
                                                  ".$mysqli->real_escape_string($orderPartnerAddressId).",
                                                 '".$mysqli->real_escape_string($orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".$mysqli->real_escape_string($orderWarehouseId).",
                                                 '".$orderPayment."',
                                                  ".$orderCouponId.", 
                                                  ".$orderUsedCouponId.", 
                                                 '".$orderDeliveryCode."',
                                                 '".$orderOrigin."',
                                                 '".$orderBankStatus."',
                                                  ".$orderB2B_ReservationId.", 
                                                  ".$orderB2B_WebReservationId.", 
                                                  ".$orderB2B_RelatedDocumentId.", 
                                                 '".$orderTimeStart."', 
                                                  ".$orderUserId.", 
                                                  ".$orderLastModifiedUserId.", 
                                                  ".$orderTimestamp."
                                              )";

            $mysqli->query($sqlInsertDocumentB2B);
            $lastDocumentId = $mysqli->insert_id;
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2B_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = (isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0 )? $_SESSION['order']['comment'] : '';
            $orderDetail_CustomerName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['name']) && strlen($_SESSION['order']['customer']['name'])>0 )? $_SESSION['order']['customer']['name'] : '';
            $orderDetail_CustomerLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['lastname']) && strlen($_SESSION['order']['customer']['lastname'])>0 )? $_SESSION['order']['customer']['lastname'] : '';
            $orderDetail_CustomerEmail = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['email']) && strlen($_SESSION['order']['customer']['email'])>0 )? $_SESSION['order']['customer']['email'] : '';
            $orderDetail_CustomerPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['phone']) && strlen($_SESSION['order']['customer']['phone'])>0 )? $_SESSION['order']['customer']['phone'] : '';
            $orderDetail_CustomerAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['address']) && strlen($_SESSION['order']['customer']['address'])>0 )? $_SESSION['order']['customer']['address'] : '';
            $orderDetail_CustomerCity = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['city']) && strlen($_SESSION['order']['customer']['city'])>0 )? $_SESSION['order']['customer']['city'] : '';
            $orderDetail_CustomerZip = (isset($_SESSION['order']) && isset($_SESSION['order']['customer']) && isset($_SESSION['order']['customer']['zip']) && strlen($_SESSION['order']['customer']['zip'])>0 )? $_SESSION['order']['customer']['zip'] : '';
            $orderDetail_RecipientName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['name']) && strlen($_SESSION['order']['recipient']['name'])>0 )? $_SESSION['order']['recipient']['name'] : '';
            $orderDetail_RecipientLastName = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['lastname']) && strlen($_SESSION['order']['recipient']['lastname'])>0 )? $_SESSION['order']['recipient']['lastname'] : '';
            $orderDetail_RecipientPhone = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['phone']) && strlen($_SESSION['order']['recipient']['phone'])>0 )? $_SESSION['order']['recipient']['phone'] : '';
            $orderDetail_RecipientAddress = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['address']) && strlen($_SESSION['order']['recipient']['address'])>0 )? $_SESSION['order']['recipient']['address'] : '';
            $orderDetail_RecipientCity = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['city']) && strlen($_SESSION['order']['recipient']['city'])>0 )? $_SESSION['order']['recipient']['city'] : '';
            $orderDetail_RecipientZip = (isset($_SESSION['order']) && isset($_SESSION['order']['recipient']) && isset($_SESSION['order']['recipient']['zip']) && strlen($_SESSION['order']['recipient']['zip'])>0 )? $_SESSION['order']['recipient']['zip'] : '';
            $orderDetail_DeliveryType = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['type']) && strlen($_SESSION['order']['delivery']['type'])>0 )? $_SESSION['order']['delivery']['type'] : '';
            $orderDetail_DeliveryShopId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliverypersonalid']) )? $_SESSION['order']['delivery']['deliverypersonalid'] : 0;
            $orderDetail_DeliveryServiceId = (isset($_SESSION['order']) && isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['deliveryserviceid']) )? $_SESSION['order']['delivery']['deliveryserviceid'] : 0;
            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2B = "INSERT INTO b2b_documentdetail (`b2b_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`,
                                                                           `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `ts` ) 
                                                                   VALUES (".$orderDetail_B2B_DocumentId.",
                                                                          '".$mysqli->real_escape_string($orderDetail_AdditionalComment)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerEmail)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
            $mysqli->query($sqlInsertDocumentDetailB2B);
////////////INSERT DOCUMENT DETAIL DATA END
////////////PREPARE DOCUMENT INTEM DATA
            $orderItemdata = array();
            $orderItemdata = self::getOrderItemRequestDataFromSession();
            $orderItemCount=0;
////////////PREPARE DOCUMENT INTEM DATA END
////////////INSERT DOCUMENT ITEM DATA
            foreach($orderItemdata as $key=>$val){
                $orderItemCount++;

                $orderItem_Id = '';
                $orderItem_DocumentItemId = '';
                $orderItem_Rebate = $val['rebate'];
                $orderItem_RebateType = 'P';
                $orderItem_B2B_DocumentId = $lastDocumentId;
                $orderItem_Price = $val['price'];
                $orderItem_Price2 = 0;
                $orderItem_ItemValue = $val['price']*((100-intval($val['rebate']))/100)*$val['qty'];
                $orderItem_ProductId = $key;
                $orderItem_ProductName = $val['name'];
                $orderItem_ProductAttrString = $val['attr'];
                $orderItem_ProductImageString = $val['pic'];
                $orderItem_Quantity = $val['qty'];
                $orderItem_Sort = $orderItemCount;
                $orderItem_TaxValue = $val['tax'];
                $orderItem_TaxId = $val['taxid'];
                $orderItem_TimeStamp = 'CURRENT_TIMESTAMP';

                $sqlInsertDocumentItemB2B = "INSERT INTO `b2b_documentitem`(`id`, `documentitemid`, `rebate`, `rebatetype`, `b2b_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `productattrstring`, `productimage`, `quantity`, 
                                                     `sort`, `taxvalue`, `taxid`, `ts`) 
                                             VALUES ('".$orderItem_Id."', 
                                                     '".$orderItem_DocumentItemId."', 
                                                      ".$orderItem_Rebate.", 
                                                     '".$orderItem_RebateType."', 
                                                      ".$orderItem_B2B_DocumentId.", 
                                                      ".$orderItem_Price.",
                                                      ".$orderItem_Price2.", 
                                                      ".$orderItem_ItemValue.", 
                                                      ".$orderItem_ProductId.",
                                                     '".$orderItem_ProductName."',
                                                     '".json_encode($orderItem_ProductAttrString)."',
                                                     '".$orderItem_ProductImageString."',
                                                      ".$orderItem_Quantity.",
                                                      ".$orderItem_Sort.",
                                                      ".$orderItem_TaxValue.",
                                                      ".$orderItem_TaxId.", 
                                                      ".$orderItem_TimeStamp."
                                                 )";    
                $mysqli->query($sqlInsertDocumentItemB2B);
            
                $lastDocumentItemId = $mysqli->insert_id;
                foreach($val['attr'] as $k=>$v){
                    $orderItemAttrId = '';
                    $orderItemAttrValue = implode(",", $v[0]);
                    $orderItemAttrQuantity = $v[1];
                    $orderItemAttrTimeStamp = 'CURRENT_TIMESTAMP';
                    $sqlInsertDocumentItemAttributeB2B = "INSERT INTO `b2b_documentitemattr`(`id`, `b2b_documentitemid`, `attrvalue`, `quantity`, `ts`) 
                                                                                     VALUES ('".$orderItemAttrId."', 
                                                                                              ".$lastDocumentItemId.", 
                                                                                             '".$orderItemAttrValue."', 
                                                                                              ".$orderItemAttrQuantity.", 
                                                                                              ".$orderItemAttrTimeStamp."
                                                                                          )";
                    $mysqli->query($sqlInsertDocumentItemAttributeB2B);
                }
            }
////////////INSERT DOCUMENT ITEM DATA END 
            Shop::createOrderRequestEmailB2B($orderNumber);
            return 1;
        //SHOPCART EXISTS END
        }
        else{
            return 0;   
        }

    }


/*ORDER OFFER*/
public static function createOfferFromSessionB2C(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!empty($_SESSION['shopcart']) && isset($_SESSION['order']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['email']) ){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = Shop::createReservationNumberB2C('B');
            $orderDocumentType = 'B';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["comment"]) && $_SESSION["order"]["comment"]!=''){
                $orderComment='WEB - '.$_SESSION["order"]["comment"];
            }
            $orderDescription = '' ; 
            $orderPartnerId = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
            $orderPartnerAddressId = (isset($_SESSION['partneraddressid']))? $_SESSION['partneraddressid'] : '0';
            $orderStatus = 'n' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = (isset($_SESSION['warehouseid']))? $_SESSION['warehouseid'] : '0';
            $orderPayment = 'n'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            if(isset($_SESSION["offer"]) && isset($_SESSION["offer"]["paymenttype"]) && $_SESSION["offer"]["paymenttype"]!=''){
                $orderPayment = $_SESSION["order"]["paymenttype"];
            }
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
             if(isset($_SESSION["voucher"]) && isset($_SESSION["voucher"]["id"]) && $_SESSION["voucher"]["id"]!=''){
                $orderUsedCouponId = $_SESSION["voucher"]["id"];
            }
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2C_ReservationId = 0;
            $orderB2C_WebReservationId = 0;
            $orderB2C_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2C = "INSERT INTO `b2c_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`, `valutedate`,`admitiondocumentdate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2c_reservationid`, `b2c_webreservationid`, `b2c_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".$mysqli->real_escape_string($orderNumber)."',
                                                 '".$mysqli->real_escape_string($orderDocumentType)."',
                                                 '".$mysqli->real_escape_string($orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                  ".$orderAddmitionDocumentDate.",
                                                 '".$mysqli->real_escape_string($orderComment)."',
                                                 '".$mysqli->real_escape_string($orderDescription)."',
                                                  ".$mysqli->real_escape_string($orderPartnerId).",
                                                  ".$mysqli->real_escape_string($orderPartnerAddressId).",
                                                 '".$mysqli->real_escape_string($orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".$mysqli->real_escape_string($orderWarehouseId).",
                                                 '".$orderPayment."',
                                                  ".$orderCouponId.", 
                                                  ".$orderUsedCouponId.", 
                                                 '".$orderDeliveryCode."',
                                                 '".$orderOrigin."',
                                                 '".$orderBankStatus."',
                                                  ".$orderB2C_ReservationId.", 
                                                  ".$orderB2C_WebReservationId.", 
                                                  ".$orderB2C_RelatedDocumentId.", 
                                                 '".$orderTimeStart."', 
                                                  ".$orderUserId.", 
                                                  ".$orderLastModifiedUserId.", 
                                                  ".$orderTimestamp."
                                              )";

            $mysqli->query($sqlInsertDocumentB2C);
            $lastDocumentId = $mysqli->insert_id;
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2C_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = (isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0 )? $_SESSION['order']['comment'] : '';
            $orderDetail_CustomerName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['name']) && strlen($_SESSION['offer']['customer']['name'])>0 )? $_SESSION['offer']['customer']['name'] : '';
            $orderDetail_CustomerLastName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['lastname']) && strlen($_SESSION['offer']['customer']['lastname'])>0 )? $_SESSION['offer']['customer']['lastname'] : '';
            $orderDetail_CustomerEmail = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['email']) && strlen($_SESSION['offer']['customer']['email'])>0 )? $_SESSION['offer']['customer']['email'] : '';
            $orderDetail_CustomerPhone = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['phone']) && strlen($_SESSION['offer']['customer']['phone'])>0 )? $_SESSION['offer']['customer']['phone'] : '';
            $orderDetail_CustomerAddress = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['address']) && strlen($_SESSION['offer']['customer']['address'])>0 )? $_SESSION['offer']['customer']['address'] : '';
            $orderDetail_CustomerCity = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['city']) && strlen($_SESSION['offer']['customer']['city'])>0 )? $_SESSION['offer']['customer']['city'] : '';
            $orderDetail_CustomerZip = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['zip']) && strlen($_SESSION['offer']['customer']['zip'])>0 )? $_SESSION['offer']['customer']['zip'] : '';
            $orderDetail_RecipientName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['name']) && strlen($_SESSION['offer']['recipient']['name'])>0 )? $_SESSION['offer']['recipient']['name'] : '';
            $orderDetail_RecipientLastName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['lastname']) && strlen($_SESSION['offer']['recipient']['lastname'])>0 )? $_SESSION['offer']['recipient']['lastname'] : '';
            $orderDetail_RecipientPhone = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['phone']) && strlen($_SESSION['offer']['recipient']['phone'])>0 )? $_SESSION['offer']['recipient']['phone'] : '';
            $orderDetail_RecipientAddress = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['address']) && strlen($_SESSION['offer']['recipient']['address'])>0 )? $_SESSION['offer']['recipient']['address'] : '';
            $orderDetail_RecipientCity = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['city']) && strlen($_SESSION['offer']['recipient']['city'])>0 )? $_SESSION['offer']['recipient']['city'] : '';
            $orderDetail_RecipientZip = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['zip']) && strlen($_SESSION['offer']['recipient']['zip'])>0 )? $_SESSION['offer']['recipient']['zip'] : '';
            $orderDetail_DeliveryType = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['type']) && strlen($_SESSION['offer']['delivery']['type'])>0 )? $_SESSION['offer']['delivery']['type'] : '';
            $orderDetail_DeliveryShopId = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['deliverypersonalid']) )? $_SESSION['offer']['delivery']['deliverypersonalid'] : 0;
            $orderDetail_DeliveryServiceId = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['deliveryserviceid']) )? $_SESSION['offer']['delivery']['deliveryserviceid'] : 0;
            $orderDetail_DeliveryCost = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['deliverycost']) )? $_SESSION['offer']['delivery']['deliverycost'] : 0;
            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2C = "INSERT INTO b2c_documentdetail (`b2c_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`, `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `deliverycost`, `ts`) 
                                                                   VALUES (".$orderDetail_B2C_DocumentId.",
                                                                          '".$mysqli->real_escape_string($orderDetail_AdditionalComment)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerEmail)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
                                                                           ".$orderDetail_DeliveryCost.",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
                                                                         
            $mysqli->query($sqlInsertDocumentDetailB2C);
////////////INSERT DOCUMENT DETAIL DATA END
////////////PREPARE DOCUMENT INTEM DATA
            $orderItemdata = array();
            $orderItemdata = self::getOrderItemDataFromSession();
            $orderItemCount=0;
////////////PREPARE DOCUMENT INTEM DATA END
////////////INSERT DOCUMENT ITEM DATA
            foreach($orderItemdata as $key=>$val){
                $orderItemCount++;

                $orderItem_Id = '';
                $orderItem_DocumentItemId = '';
                $orderItem_Rebate = $val['rebate'];
                $orderItem_RebateType = 'P';
                $orderItem_B2C_DocumentId = $lastDocumentId;
                $orderItem_Price = $val['price'];
                $orderItem_Price2 = 0;
                $orderItem_ItemValue = $val['price']*((100-intval($val['rebate']))/100)*$val['qty'];
                $orderItem_ProductId = $key;
                $orderItem_ProductName = $val['name'];
                $orderItem_ProductAttrString = $val['attr'];
                $orderItem_ProductImageString = $val['pic'];
                $orderItem_Quantity = $val['qty'];
                $orderItem_Sort = $orderItemCount;
                $orderItem_TaxValue = $val['tax'];
                $orderItem_TaxId = $val['taxid'];
                $orderItem_TimeStamp = 'CURRENT_TIMESTAMP';

                $sqlInsertDocumentItemB2C = "INSERT INTO `b2c_documentitem`(`id`, `documentitemid`, `rebate`, `rebatetype`, `b2c_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `productattrstring`,`productimage`, `quantity`, 
                                                     `sort`, `taxvalue`, `taxid`, `ts`) 
                                             VALUES ('".$orderItem_Id."', 
                                                     '".$orderItem_DocumentItemId."', 
                                                      ".$orderItem_Rebate.", 
                                                     '".$orderItem_RebateType."', 
                                                      ".$orderItem_B2C_DocumentId.", 
                                                      ".$orderItem_Price.",
                                                      ".$orderItem_Price2.", 
                                                      ".$orderItem_ItemValue.", 
                                                      ".$orderItem_ProductId.",
                                                     '".$orderItem_ProductName."',
                                                     '".json_encode($orderItem_ProductAttrString)."',
                                                     '".$orderItem_ProductImageString."',
                                                      ".$orderItem_Quantity.",
                                                      ".$orderItem_Sort.",
                                                      ".$orderItem_TaxValue.",
                                                      ".$orderItem_TaxId.", 
                                                      ".$orderItem_TimeStamp."
                                                 )";    
                $mysqli->query($sqlInsertDocumentItemB2C);
            
                $lastDocumentItemId = $mysqli->insert_id;
                foreach($val['attr'] as $k=>$v){
                    $orderItemAttrId = '';
                    $orderItemAttrValue = implode(",", $v[0]);
                    $orderItemAttrQuantity = $v[1];
                    $orderItemAttrTimeStamp = 'CURRENT_TIMESTAMP';
                    $sqlInsertDocumentItemAttributeB2C = "INSERT INTO `b2c_documentitemattr`(`id`, `b2c_documentitemid`, `attrvalue`, `quantity`, `ts`) 
                                                                                     VALUES ('".$orderItemAttrId."', 
                                                                                              ".$lastDocumentItemId.", 
                                                                                             '".$orderItemAttrValue."', 
                                                                                              ".$orderItemAttrQuantity.", 
                                                                                              ".$orderItemAttrTimeStamp."
                                                                                          )";
                    $mysqli->query($sqlInsertDocumentItemAttributeB2C);
                }
            }
////////////INSERT DOCUMENT ITEM DATA END 
//////////// CHANGE COUPON STATUS START
            if(isset($_SESSION['voucher']) && isset($_SESSION['voucher']['id'])){
                $q = "UPDATE `usercoupon` SET status = 'u' WHERE id = ".$_SESSION['voucher']['id'];
                $mysqli->query($q);
            }
//////////// CHANGE COUPON STATUS END


            Shop::createOfferEmail($orderNumber);
            
             return array('status'=>"success");
        //SHOPCART EXISTS END
        }
        else{
            return array('status'=>"error"); 
        }

    }

    public static function createOfferRequestFromSessionB2C(){
        global $user_conf, $language;
        
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!empty($_SESSION['shopcart_request']) && isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['email']) ){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = Shop::createReservationNumberB2C('BQ');
            $orderDocumentType = 'BQ';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            if(isset($_SESSION["order"]) && isset($_SESSION["order"]["comment"]) && $_SESSION["order"]["comment"]!=''){
                $orderComment='WEB - '.$_SESSION["order"]["comment"];
            }
            $orderDescription = '' ; 
            $orderPartnerId = (isset($_SESSION['partnerid']))? $_SESSION['partnerid'] : '0';
            $orderPartnerAddressId = (isset($_SESSION['partneraddressid']))? $_SESSION['partneraddressid'] : '0';
            $orderStatus = 'n' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = (isset($_SESSION['warehouseid']))? $_SESSION['warehouseid'] : '0';
            $orderPayment = 'n'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            if(isset($_SESSION["offer"]) && isset($_SESSION["offer"]["paymenttype"]) && $_SESSION["offer"]["paymenttype"]!=''){
                $orderPayment = $_SESSION["offer"]["paymenttype"];
            }
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2C_ReservationId = 0;
            $orderB2C_WebReservationId = 0;
            $orderB2C_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = (isset($_SESSION['id'])) ? $_SESSION['id'] : '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2C = "INSERT INTO `b2c_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`,`admitiondocumentdate`, `valutedate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2c_reservationid`, `b2c_webreservationid`, `b2c_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".$mysqli->real_escape_string($orderNumber)."',
                                                 '".$mysqli->real_escape_string($orderDocumentType)."',
                                                 '".$mysqli->real_escape_string($orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
                                                  ".$orderAddmitionDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                 '".$mysqli->real_escape_string($orderComment)."',
                                                 '".$mysqli->real_escape_string($orderDescription)."',
                                                  ".$mysqli->real_escape_string($orderPartnerId).",
                                                  ".$mysqli->real_escape_string($orderPartnerAddressId).",
                                                 '".$mysqli->real_escape_string($orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".$mysqli->real_escape_string($orderWarehouseId).",
                                                 '".$orderPayment."',
                                                  ".$orderCouponId.", 
                                                  ".$orderUsedCouponId.", 
                                                 '".$orderDeliveryCode."',
                                                 '".$orderOrigin."',
                                                 '".$orderBankStatus."',
                                                  ".$orderB2C_ReservationId.", 
                                                  ".$orderB2C_WebReservationId.", 
                                                  ".$orderB2C_RelatedDocumentId.", 
                                                 '".$orderTimeStart."', 
                                                  ".$orderUserId.", 
                                                  ".$orderLastModifiedUserId.", 
                                                  ".$orderTimestamp."
                                              )";
            
            $mysqli->query($sqlInsertDocumentB2C);
            $lastDocumentId = $mysqli->insert_id;
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2C_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = (isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0 )? $_SESSION['order']['comment'] : '';
            $orderDetail_CustomerName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['name']) && strlen($_SESSION['offer']['customer']['name'])>0 )? $_SESSION['offer']['customer']['name'] : '';
            $orderDetail_CustomerLastName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['lastname']) && strlen($_SESSION['offer']['customer']['lastname'])>0 )? $_SESSION['offer']['customer']['lastname'] : '';
            $orderDetail_CustomerEmail = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['email']) && strlen($_SESSION['offer']['customer']['email'])>0 )? $_SESSION['offer']['customer']['email'] : '';
            $orderDetail_CustomerPhone = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['phone']) && strlen($_SESSION['offer']['customer']['phone'])>0 )? $_SESSION['offer']['customer']['phone'] : '';
            $orderDetail_CustomerAddress = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['address']) && strlen($_SESSION['offer']['customer']['address'])>0 )? $_SESSION['offer']['customer']['address'] : '';
            $orderDetail_CustomerCity = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['city']) && strlen($_SESSION['offer']['customer']['city'])>0 )? $_SESSION['offer']['customer']['city'] : '';
            $orderDetail_CustomerZip = (isset($_SESSION['offer']) && isset($_SESSION['offer']['customer']) && isset($_SESSION['offer']['customer']['zip']) && strlen($_SESSION['offer']['customer']['zip'])>0 )? $_SESSION['offer']['customer']['zip'] : '';
            $orderDetail_RecipientName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['name']) && strlen($_SESSION['offer']['recipient']['name'])>0 )? $_SESSION['offer']['recipient']['name'] : '';
            $orderDetail_RecipientLastName = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['lastname']) && strlen($_SESSION['offer']['recipient']['lastname'])>0 )? $_SESSION['offer']['recipient']['lastname'] : '';
            $orderDetail_RecipientPhone = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['phone']) && strlen($_SESSION['offer']['recipient']['phone'])>0 )? $_SESSION['offer']['recipient']['phone'] : '';
            $orderDetail_RecipientAddress = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['address']) && strlen($_SESSION['offer']['recipient']['address'])>0 )? $_SESSION['offer']['recipient']['address'] : '';
            $orderDetail_RecipientCity = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['city']) && strlen($_SESSION['offer']['recipient']['city'])>0 )? $_SESSION['offer']['recipient']['city'] : '';
            $orderDetail_RecipientZip = (isset($_SESSION['offer']) && isset($_SESSION['offer']['recipient']) && isset($_SESSION['offer']['recipient']['zip']) && strlen($_SESSION['offer']['recipient']['zip'])>0 )? $_SESSION['offer']['recipient']['zip'] : '';
            $orderDetail_DeliveryType = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['type']) && strlen($_SESSION['offer']['delivery']['type'])>0 )? $_SESSION['offer']['delivery']['type'] : '';
            $orderDetail_DeliveryShopId = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['deliverypersonalid']) )? $_SESSION['offer']['delivery']['deliverypersonalid'] : 0;
            $orderDetail_DeliveryServiceId = (isset($_SESSION['offer']) && isset($_SESSION['offer']['delivery']) && isset($_SESSION['offer']['delivery']['deliveryserviceid']) )? $_SESSION['offer']['delivery']['deliveryserviceid'] : 0;
            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2C = "INSERT INTO b2c_documentdetail (`b2c_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`,
                                                                           `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `ts` ) 
                                                                   VALUES (".$orderDetail_B2C_DocumentId.",
                                                                          '".$mysqli->real_escape_string($orderDetail_AdditionalComment)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerEmail)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_CustomerZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientLastName)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientPhone)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientAddress)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientCity)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_RecipientZip)."',
                                                                          '".$mysqli->real_escape_string($orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
            $mysqli->query($sqlInsertDocumentDetailB2C);
////////////INSERT DOCUMENT DETAIL DATA END
////////////PREPARE DOCUMENT INTEM DATA
            $orderItemdata = array();
            $orderItemdata = self::getOrderItemRequestDataFromSession();
            $orderItemCount=0;
////////////PREPARE DOCUMENT INTEM DATA END
////////////INSERT DOCUMENT ITEM DATA
            foreach($orderItemdata as $key=>$val){
                $orderItemCount++;

                $orderItem_Id = '';
                $orderItem_DocumentItemId = '';
                $orderItem_Rebate = $val['rebate'];
                $orderItem_RebateType = 'P';
                $orderItem_B2C_DocumentId = $lastDocumentId;
                $orderItem_Price = $val['price'];
                $orderItem_Price2 = 0;
                $orderItem_ItemValue = $val['price']*((100-intval($val['rebate']))/100)*$val['qty'];
                $orderItem_ProductId = $key;
                $orderItem_ProductName = $val['name'];
                $orderItem_ProductAttrString = $val['attr'];
                $orderItem_ProductImageString = $val['pic'];
                $orderItem_Quantity = $val['qty'];
                $orderItem_Sort = $orderItemCount;
                $orderItem_TaxValue = $val['tax'];
                $orderItem_TaxId = $val['taxid'];
                $orderItem_TimeStamp = 'CURRENT_TIMESTAMP';

                $sqlInsertDocumentItemB2C = "INSERT INTO `b2c_documentitem`(`id`, `documentitemid`, `rebate`, `rebatetype`, `b2c_documentid`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `productattrstring`, `productimage`, `quantity`, 
                                                     `sort`, `taxvalue`, `taxid`, `ts`) 
                                             VALUES ('".$orderItem_Id."', 
                                                     '".$orderItem_DocumentItemId."', 
                                                      ".$orderItem_Rebate.", 
                                                     '".$orderItem_RebateType."', 
                                                      ".$orderItem_B2C_DocumentId.", 
                                                      ".$orderItem_Price.",
                                                      ".$orderItem_Price2.", 
                                                      ".$orderItem_ItemValue.", 
                                                      ".$orderItem_ProductId.",
                                                     '".$orderItem_ProductName."',
                                                     '".json_encode($orderItem_ProductAttrString)."',
                                                     '".$orderItem_ProductImageString."',
                                                      ".$orderItem_Quantity.",
                                                      ".$orderItem_Sort.",
                                                      ".$orderItem_TaxValue.",
                                                      ".$orderItem_TaxId.", 
                                                      ".$orderItem_TimeStamp."
                                                 )";    
                $mysqli->query($sqlInsertDocumentItemB2C);
            
                $lastDocumentItemId = $mysqli->insert_id;
                foreach($val['attr'] as $k=>$v){
                    $orderItemAttrId = '';
                    $orderItemAttrValue = implode(",", $v[0]);
                    $orderItemAttrQuantity = $v[1];
                    $orderItemAttrTimeStamp = 'CURRENT_TIMESTAMP';
                    $sqlInsertDocumentItemAttributeB2C = "INSERT INTO `b2c_documentitemattr`(`id`, `b2c_documentitemid`, `attrvalue`, `quantity`, `ts`) 
                                                                                     VALUES ('".$orderItemAttrId."', 
                                                                                              ".$lastDocumentItemId.", 
                                                                                             '".$orderItemAttrValue."', 
                                                                                              ".$orderItemAttrQuantity.", 
                                                                                              ".$orderItemAttrTimeStamp."
                                                                                          )";
                    $mysqli->query($sqlInsertDocumentItemAttributeB2C);
                }
            }
////////////INSERT DOCUMENT ITEM DATA END 
            
            //Shop::createOrderRequestEmail($orderNumber);
            return array('status'=>"success");
            
        //SHOPCART EXISTS END
        }
        else{
            return array('status'=>"error");
        }

    }
/*ORDER OFFER END*/




    public static function createOrderEmail($order_number){
        global $system_conf,$user_conf, $language;

        $orderEmail = (isset($_SESSION['email']))? $_SESSION['email']:$_SESSION['order']['customer']['email'];
        $orderDocumentTypeName=$user_conf["document_type_name_B2C"][1]." ".$user_conf["b2c_document_prefix"][1]."-".$order_number;
        //CUSTOMER INFO

        //CUSTOMER INFO
        $emailOrderCustomerData='';
        $emailOrderRecipientData='';
        $emailOrderDeliveryData='';
        $emailOrderCommentData='';



        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$_SESSION['order']['customer']['email'];
        $orderDetailData .= "<br />Ime : ".$_SESSION['order']['customer']['name'];
        $orderDetailData .= "<br />Prezime : ".$_SESSION['order']['customer']['lastname'];
        $orderDetailData .= "<br />Telefon : ".$_SESSION['order']['customer']['phone'];
        $orderDetailData .= "<br />Adresa : ".$_SESSION['order']['customer']['address'].", ".$_SESSION['order']['customer']['zip']." , ".$_SESSION['order']['customer']['city'];
        $orderDetailData .= "<br /><br />";


        $emailOrderCustomerData  ="<br /> Detalji naručioca: <br />";
        $emailOrderCustomerData .= "<br />Email:  ".$_SESSION['order']['customer']['email'];
        $emailOrderCustomerData .= "<br />Ime : ".$_SESSION['order']['customer']['name'];
        $emailOrderCustomerData .= "<br />Prezime : ".$_SESSION['order']['customer']['lastname'];
        $emailOrderCustomerData .= "<br />Telefon : ".$_SESSION['order']['customer']['phone'];
        $emailOrderCustomerData .= "<br />Adresa : ".$_SESSION['order']['customer']['address'].", ".$_SESSION['order']['customer']['zip']." , ".$_SESSION['order']['customer']['city'];
        $emailOrderCustomerData .= "<br />";

        $emailOrderRecipientData="<br /> Podaci za dostavu: <br />";
        $emailOrderRecipientData .= "<br />Ime : ".$_SESSION['order']['recipient']['name'];
        $emailOrderRecipientData .= "<br />Prezime : ".$_SESSION['order']['recipient']['lastname'];
        $emailOrderRecipientData .= "<br />Telefon : ".$_SESSION['order']['recipient']['phone'];
        $emailOrderRecipientData .= "<br />Adresa : ".$_SESSION['order']['recipient']['address'].", ".$_SESSION['order']['recipient']['zip']." , ".$_SESSION['order']['recipient']['city'];
        $emailOrderRecipientData .= "<br /><br />";

        $emailOrderRecipientDataFlag=0;

        if( 
           $_SESSION['order']['recipient']['name']!='' && 
           $_SESSION['order']['recipient']['lastname']!='' && 
           $_SESSION['order']['recipient']['phone']!='' && 
           $_SESSION['order']['recipient']['address']!='' && 
           $_SESSION['order']['recipient']['zip']!='' &&
           $_SESSION['order']['recipient']['city']!='' ){

             $emailOrderRecipientDataFlag=1;
             

        }

        //CUSTOMER INFO END
        //PAYMENT TYPE
        $paymentData = $_SESSION['order']['paymenttype'];
        $orderPayment="";
        switch ($paymentData) {
            case "p":
                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
                break;
            case "u":
                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
                break;
            case "k":
                $orderPayment="<br/>Plaćanje: Karticom<br/>";
                break;
            case "n":
                $orderPayment="";
                break;
        }

        $orderDetailData .= $orderPayment;
        $emailOrderCustomerData .= $orderPayment;
        //PAYMENT TYPE END
        //DELIVERY SERVICE
        $deliveryType =$_SESSION['order']['delivery']['type'];
        $deliveryData='';
        switch ($deliveryType) {
            case "p":
                $deliveryData  ="<br /> Detalji isporuke: <br />";
                $deliveryData.="<br />Način preuzimanja: Lično<br/>";
                $shopId = $_SESSION['order']['delivery']['deliverypersonalid'];
                $shopData = self::getShopDataByShopId($shopId);
                $deliveryData .= "Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
                $deliveryData .= "Broj telefona prodavnice: ".$shopData['phone']."<br/>";
                $deliveryData .= "Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
                break;
            case "d":
                require_once("app/class/DeliveryService.php");
                $deliveryData  ="<br /> Detalji isporuke: <br />";
                $deliveryData.="<br />Način preuzimanja: Kurirskom službom<br/>";
                $deliveryServiceId = $_SESSION['order']['delivery']['deliveryserviceid'];
                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
                $deliveryData .= "Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
                $deliveryData .= "Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
                $deliveryData .= "Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
                break;
            case "h":
                $deliveryData="";
                break;
        }
        $orderDetailData .= $deliveryData;
        $emailOrderDeliveryData.= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment='WEB';
        if(isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && $_SESSION['order']['comment']!=''){
            $orderComment=$_SESSION['order']['comment'];
            $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
            $emailOrderCommentData.= "<br/>Komentar: ".$orderComment."<br/>";
        }
        //COMMENT END
        //PREPARE ORDER ITEMS
        $total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue = 0;
        $calc_totalValueWithRebateWithVat = 0;

        $orderItems = array();
        if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
            $orderItems = $_SESSION['shopcart'];
            foreach ($orderItems as $key => $cartprod) {
                //GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
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
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                /*$orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['pricewithrebatewithvat'] = round($cartprod['price']*(1-($calc_itemRebate/100)),2)*((100+$cartprod['tax'])/100);
                $orderItems[$key]['itemvalue'] = round($cartprod['price']  *(1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = round($cartprod['price'] * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += round($cartprod['price']  *($calc_itemRebate/100)* $cartprod['qty'],2);
                $calc_totalRebateWithVatValue +=round(round($cartprod['price']  *($calc_itemRebate/100),2)*$cartprod['qty'],2)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += round(round($cartprod['price'] * (1-($calc_itemRebate/100)),2) * $cartprod['qty'],2);
                $calc_totalValueWithRebateVatValue += round(round($cartprod['price']  * (1-($calc_itemRebate/100)),2)*$cartprod['qty'],2) *(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += round(round($cartprod['price']  * (1-($calc_itemRebate/100)),2)*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $total_price += round($calc_totalRebateValue,2);
                $total_tax +=$calc_totalValueWithRebate * (($cartprod['tax'])/100);
                $total_price_pdv += round($calc_totalValueWithRebateWithVat,2);*/
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['pricewithrebatewithvat'] = round($cartprod['price']*(1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2);
                $orderItems[$key]['itemvalue'] = round($cartprod['price'] *(1-($calc_itemRebate/100)),2) * $cartprod['qty'] ;
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = round($cartprod['price'] * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += round($cartprod['price']  *($calc_itemRebate/100),2)* $cartprod['qty'];
                $calc_totalRebateWithVatValue +=round($cartprod['price']  *($calc_itemRebate/100)*(1+($cartprod['tax'])/100),2)* $cartprod['qty'];
                $calc_totalValueWithRebate += round($cartprod['price']  * (1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $calc_totalValueWithRebateVatValue += round($cartprod['price']  * (1-($calc_itemRebate/100))*(($cartprod['tax'])/100),2)* $cartprod['qty'];
                $calc_totalValueWithRebateWithVat += round($cartprod['price']  * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                //$total_price = $calc_totalRebateValue;
               // $total_tax  = $calc_totalRebateValue * (($cartprod['tax'])/100);
               // $total_price_pdv = $calc_totalValueWithRebateWithVat;
                //CALCULATIONS END
                
                $total_rebate += round($cartprod['price']  *($calc_itemRebate/100),2)* $cartprod['qty'];
                $article_total_price =  round($cartprod['price']   * (1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $article_total_price_pdv = round($cartprod['price']  * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $total_price += $article_total_price;
                $total_tax +=$article_total_price * (($cartprod['tax'])/100);
                $total_price_pdv += $article_total_price_pdv;
            }
        }
		
		$delivery_cost=0; 
		if(floatval($total_price_pdv-floatval($_SESSION['voucher']['value']))>$user_conf["free_delivery_from"][1]){
			$delivery_cost=0;
		} else {
			$delivery_cost= $user_conf["delivery_cost"][1];
		}
		
		$voucher_value = 0;
		if(isset($_SESSION['voucher']['value'])){
			$voucher_value = $_SESSION['voucher']['value'];
		}
		
        //PREPARE ORDER ITEMS END 
        //INCLUDE CREATES $email_msg
        if($user_conf["shopcartB2Cshort"][1]==1){
            include("app/class/email/EmailOrderB2Cshort.php");
            //INCLUDE CREATES $pdf_msg
            include("app/class/pdf/PdfOrderB2Cshort.php");
        } else {
            include("app/class/email/EmailOrderB2C.php");
            //INCLUDE CREATES $pdf_msg
            include("app/class/pdf/PdfOrderB2C.php"); 
        }
        GlobalHelper::sendEmailOrder(array('client'=>$orderEmail, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina br '.$order_number , 'seller'=>' Nova porudzbina na sajtu - '.$order_number), $email_msg, $pdf_header, $pdf_msg, $pdf_footer );

        $_SESSION['shopcart'] = array();
        if(!isset($_SESSION['order']['document_number'])){
            $_SESSION['order']['document_number'] = $order_number;    
        } else {
            $_SESSION['order']['document_number'] = $order_number;
        }
    }
    public static function createOrderRequestEmail($order_number){
        global $system_conf,$user_conf, $language;

        $orderEmail = (isset($_SESSION['email']))? $_SESSION['email']:$_SESSION['order']['customer']['email'];
        $orderDocumentTypeName=$user_conf["document_type_request_name_B2C"][1]." ".$user_conf["b2c_document_prefix"][1]."-".$order_number;

        //CUSTOMER INFO
        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$_SESSION['order']['customer']['email'];
        $orderDetailData .= "<br />Ime : ".$_SESSION['order']['customer']['name'];
        $orderDetailData .= "<br />Prezime : ".$_SESSION['order']['customer']['lastname'];
        $orderDetailData .= "<br />Telefon : ".$_SESSION['order']['customer']['phone'];
        $orderDetailData .= "<br />Adresa : ".$_SESSION['order']['customer']['address'].", ".$_SESSION['order']['customer']['zip']." , ".$_SESSION['order']['customer']['city'];
        $orderDetailData .= "<br /><br />";
        //CUSTOMER INFO END
        //PAYMENT TYPE
//        $paymentData = $_SESSION['order']['paymenttype'];
//        $orderPayment="";
//        switch ($paymentData) {
//            case "p":
//                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
//                break;
//            case "u":
//                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
//                break;
//            case "k":
//                $orderPayment="<br/>Plaćanje: Karticom<br/>";
//                break;
//            case "n":
//                $orderPayment="";
//                break;
//        }
//
//        $orderDetailData .= $orderPayment;
        //PAYMENT TYPE END
        //DELIVERY SERVICE
//        $deliveryType =$_SESSION['order']['delivery']['type'];
//        $deliveryData='';
//        switch ($deliveryData) {
//            case "p":
//                $deliveryData="<br/>Način preuzimanja: Lično<br/>";
//                $shopId = $_SESSION['order']['delivery']['deliverypersonalid'];
//                $shopData = self::getShopDataByShopId($shopId);
//                $deliveryData .= "<br />Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
//                $deliveryData .= "<br />Broj telefona prodavnice: ".$shopData['phone']."<br/>";
//                $deliveryData .= "<br />Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
//                break;
//            case "d":
//                $deliveryData="<br/>Način preuzimanja: Kurirskom službom<br/>";
//                $deliveryServiceId = $_SESSION['order']['delivery']['deliveryserviceid'];
//                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
//                $deliveryData .= "<br />Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
//                $deliveryData .= "<br />Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
//                $deliveryData .= " <br />Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
//                break;
//            case "h":
//                $deliveryData="";
//                break;
//        }
//        $orderDetailData .= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment='WEB';
        if(isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && $_SESSION['order']['comment']!=''){
            $orderComment=$_SESSION['order']['comment'];
            $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
        }
        //COMMENT END
        //PREPARE ORDER ITEMS
        $total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue + 0;
        $calc_totalValueWithRebateWithVat = 0;


        
        


        $orderItems = array();
        if(isset($_SESSION['shopcart_request']) && is_array($_SESSION['shopcart_request'])){
            $orderItems = $_SESSION['shopcart_request'];
            foreach ($orderItems as $key => $cartprod) {
                //GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
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
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['itemvalue'] = $cartprod['price'] * $cartprod['qty'] *(1-($calc_itemRebate/100));
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = $cartprod['price'] * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += $cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100);
                $calc_totalRebateWithVatValue +=$cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100));
                $calc_totalValueWithRebateVatValue += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                $total_price += $calc_totalRebateValue;
                $total_tax +=$calc_totalRebateValue * (($cartprod['tax'])/100);
                $total_price_pdv += $calc_totalValueWithRebateWithVat;

                    
                
                //CALCULATIONS END
            }
        }
        //die();
        //PREPARE ORDER ITEMS END 
        //INCLUDE CREATES $email_msg
        include("app/class/email/EmailOrderRequestB2C.php");

        GlobalHelper::sendEmailOrderRequest(array('client'=>$orderEmail, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina-Upit br '.$order_number , 'seller'=>' Novi upit na sajtu '), $email_msg );

        $_SESSION['shopcart_request'] = array();
        if(!isset($_SESSION['order']['document_request_number'])){
            $_SESSION['order']['document_request_number'] = $order_number;    
        } else {
            $_SESSION['order']['document_request_number'] = $order_number;
        }

    }
	public static function createOrderEmailB2B($order_number){
        global $system_conf,$user_conf, $language;

        $orderEmail = (isset($_SESSION['email']))? $_SESSION['email']:$_SESSION['email'];
        $orderDocumentTypeName=$user_conf["document_type_name_B2B"][1]." ".$user_conf["b2b_document_prefix"][1]."-".$order_number;
        
        $orderDetailData='';

        $emailOrderCustomerData='';
        $emailOrderRecipientData='';
        $emailOrderDeliveryData='';
        $emailOrderCommentData='';
        $emailOrderMemorandumNoticeData='';
        

        //PARTNER INFO 
        $partnerData = GlobalHelper::getPartnerInfoById($_SESSION['partnerid']);

        $orderDetailData .= "<br/>Detalji partnera: <br/>";
        $orderDetailData .= "<br />Partner : ".$partnerData['name'];
        $orderDetailData .= "<br />PIB : ".$partnerData['code'];
        $orderDetailData .= "<br />Matični broj : ".$partnerData['number'];
        $orderDetailData .= "<br />Adresa : ".$partnerData['address'].", ".$partnerData['zip']." , ".$partnerData['city'];
        $orderDetailData .= "<br />Fax : ".$partnerData['fax'];
        $orderDetailData .= "<br />Telefon : ".$partnerData['phone'];
        $orderDetailData .= "<br />Email:  ".$partnerData['email'];
        $orderDetailData .= "<br />";
        $orderDetailData .= "<br/>Detalji naručioca: <br/>";
        $orderDetailData .= "<br />Ime i prezime : ".$_SESSION['ime']." ".$_SESSION['prezime'];


        $emailOrderCustomerData .= "<br/>Detalji partnera: <br/>";
        $emailOrderCustomerData .= "<br />Partner : ".$partnerData['name'];
        $emailOrderCustomerData .= "<br />PIB : ".$partnerData['code'];
        $emailOrderCustomerData .= "<br />Matični broj : ".$partnerData['number'];
        $emailOrderCustomerData .= "<br />Adresa : ".$partnerData['address'].", ".$partnerData['zip']." , ".$partnerData['city'];
        $emailOrderCustomerData .= "<br />Fax : ".$partnerData['fax'];
        $emailOrderCustomerData .= "<br />Telefon : ".$partnerData['phone'];
        $emailOrderCustomerData .= "<br />Email:  ".$partnerData['email'];
        $emailOrderCustomerData .= "<br />";
        $emailOrderCustomerData .= "<br/>Detalji naručioca: <br/>";
        $emailOrderCustomerData .= "<br />Ime i prezime : ".$_SESSION['ime']." ".$_SESSION['prezime'];


        $emailOrderRecipientData="<br /> Podaci za dostavu: <br />";
        $emailOrderRecipientData .= "<br />Ime : ".$_SESSION['order']['recipient']['name'];
        $emailOrderRecipientData .= "<br />Prezime : ".$_SESSION['order']['recipient']['lastname'];
        $emailOrderRecipientData .= "<br />Telefon : ".$_SESSION['order']['recipient']['phone'];
        $emailOrderRecipientData .= "<br />Adresa : ".$_SESSION['order']['recipient']['address'].", ".$_SESSION['order']['recipient']['zip']." , ".$_SESSION['order']['recipient']['city'];
        $emailOrderRecipientData .= "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";

        $emailOrderRecipientDataFlag=0;

        if( 
           $_SESSION['order']['recipient']['name']!='' && 
           $_SESSION['order']['recipient']['lastname']!='' && 
           $_SESSION['order']['recipient']['phone']!='' && 
           $_SESSION['order']['recipient']['address']!='' && 
           $_SESSION['order']['recipient']['zip']!='' &&
           $_SESSION['order']['recipient']['city']!='' ){

             $emailOrderRecipientDataFlag=1;
             

        }


        if(strlen($_SESSION['telefon'])>0 && $_SESSION['telefon']!=''){
            $orderDetailData .= "<br />Telefon : ".$_SESSION['telefon'];  
            $emailOrderCustomerData .= "<br />Telefon : ".$_SESSION['telefon'];  
        }
        if(strlen($_SESSION['mobile'])>0 && $_SESSION['mobile']!=''){
            $orderDetailData .= "<br />Mobilni telefon : ".$_SESSION['mobile']; 
            $emailOrderCustomerData .= "<br />Mobilni telefon : ".$_SESSION['mobile'];  
        }


        $orderDetailData .= "<br />";
        $emailOrderCustomerData .= "<br />";
        //PARTNER INFO END
        //PAYMENT TYPE
        $paymentData = $_SESSION['order']['paymenttype'];
        $orderPayment="";
        switch ($paymentData) {
            case "v":
                $orderPayment="<br/>Plaćanje: Virman<br/>";
                break;
            case "p":
                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
                break;
            case "u":
                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
                break;
            case "k":
                $orderPayment="<br/>Plaćanje: Karticom<br/>";
                break;
            case "n":
                $orderPayment="";
                break;
        }
        $orderDetailData .= $orderPayment;
        $emailOrderCustomerData .= $orderPayment;
        //PAYMENT TYPE END
        //DELIVERY SERVICE
        $deliveryType =$_SESSION['order']['delivery']['type'];
        $deliveryData='';
        switch ($deliveryType) {
            case "p":
                $deliveryData="<br/>Detalji isporuke<br/>";
                $deliveryData.="<br/>Način preuzimanja: Lično<br/>";
                $shopId = $_SESSION['order']['delivery']['deliverypersonalid'];
                $shopData = self::getShopDataByShopId($shopId);
                $deliveryData .= "Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
                $deliveryData .= "Broj telefona prodavnice: ".$shopData['phone']."<br/>";
                $deliveryData .= "Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
                $deliveryData .="<br /><br /><br /><br /><br /><br /><br /><br /><br />";
                break;
            case "d":
                require_once("app/class/DeliveryService.php");
                $deliveryData="<br/>Detalji isporuke<br/>";
                $deliveryData.="<br/>Način preuzimanja: Kurirskom službom<br/>";
                $deliveryServiceId = $_SESSION['order']['delivery']['deliveryserviceid'];
                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
                $deliveryData .= "Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
                $deliveryData .= "Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
                $deliveryData .= "Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
                $deliveryData .="<br /><br /><br /><br /><br /><br /><br /><br /><br />";
                break;
            case "h":
                $deliveryData="";
                break;
        }
        $orderDetailData .= $deliveryData;
        $emailOrderDeliveryData.= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment='WEB';
        if(isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && $_SESSION['order']['comment']!=''){
            $orderComment=$_SESSION['order']['comment'];
            $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
        }
        $emailOrderCommentData.= "<br/>Komentar: ".$orderComment."<br/>";
        //COMMENT END
        //MEMORANDUM COMMENT
        $orderMemorandumComment="";
        $orderMemorandumComment.="<br /><b>".$user_conf["memorandum_comment_line1"][1]."</b><br />";
        $orderMemorandumComment.="<br /><b>".$user_conf["memorandum_comment_line2"][1]."</b>";
        $orderMemorandumComment.="<br /><b>".$user_conf["memorandum_comment_line3"][1]."</b>";
        $orderMemorandumComment.="<br /><b>".$user_conf["memorandum_comment_line4"][1]."</b>";
        $orderMemorandumComment.="<br /><b>".$user_conf["memorandum_comment_line5"][1]."</b>";
        $orderMemorandumComment.="<br /><br />";
        //MEMORANDUM COMMENT END
        $orderDetailData .= $orderMemorandumComment;
        $emailOrderMemorandumNoticeData.= $orderMemorandumComment;
        //PREPARE ORDER ITEMS
        $total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue = 0;
        $calc_totalValueWithRebateWithVat = 0;


        $orderItems = array();
        if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
            $orderItems = $_SESSION['shopcart'];
            foreach ($orderItems as $key => $cartprod) {
                //GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
                $attrs = array();
                $a = json_decode($cartprod['attr'], true);
                if(count($a)>0){
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
                }
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['pricewithrebatewithvat'] = round($cartprod['price']*(1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2);
                $orderItems[$key]['itemvalue'] = round($cartprod['price'] *(1-($calc_itemRebate/100)),2) * $cartprod['qty'] ;
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = round($cartprod['price'] * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += round($cartprod['price']  *($calc_itemRebate/100),2)* $cartprod['qty'];
                $calc_totalRebateWithVatValue +=round($cartprod['price']  *($calc_itemRebate/100)*(1+($cartprod['tax'])/100),2)* $cartprod['qty'];
                $calc_totalValueWithRebate += round($cartprod['price']  * (1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $calc_totalValueWithRebateVatValue += round($cartprod['price']  * (1-($calc_itemRebate/100))*(($cartprod['tax'])/100),2)* $cartprod['qty'];
                $calc_totalValueWithRebateWithVat += round($cartprod['price']  * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                


                $total_rebate += round($cartprod['price']  *($calc_itemRebate/100),2)* $cartprod['qty'];
                $article_total_price =  round($cartprod['price']   * (1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $article_total_price_pdv = round($cartprod['price']  * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $total_price += $article_total_price;
                $total_tax +=$article_total_price * (($cartprod['tax'])/100);
                $total_price_pdv += $article_total_price_pdv;

                    
                
                //CALCULATIONS END
            }
        }
        //PREPARE ORDER ITEMS END 

        //INCLUDE CREATES $email_msg
        include("app/class/email/EmailOrderB2B.php");
        //INCLUDE CREATES $pdf_msg
        include("app/class/pdf/PdfOrderB2B.php");

        GlobalHelper::sendEmailOrder(array('client'=>$orderEmail, 'seller'=>$user_conf["b2b_address"][1]), $user_conf["autoemail"][1], array('client'=>'Nova B2B Porudžbina br '.$order_number , 'seller'=>' Nova B2B porudžbina na sajtu '.$order_number), $email_msg, $pdf_header, $pdf_msg, $pdf_footer );

        $_SESSION['shopcart'] = array();
        if(!isset($_SESSION['order']['document_number_b2b'])){
            $_SESSION['order']['document_number_b2b'] = $order_number;    
        } else {
            $_SESSION['order']['document_number_b2b'] = $order_number;
        }

    }

     public static function createOrderRequestEmailB2B($order_number){
        global $system_conf,$user_conf, $language;

        $orderEmail = (isset($_SESSION['email']))? $_SESSION['email']:$_SESSION['order']['customer']['email'];
        $orderDocumentTypeName=$user_conf["document_type_request_name_B2B"][1]." ".$user_conf["b2b_document_prefix"][1]."-".$order_number;

        //CUSTOMER INFO
        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$_SESSION['order']['customer']['email'];
        $orderDetailData .= "<br />Ime : ".$_SESSION['order']['customer']['name'];
        $orderDetailData .= "<br />Prezime : ".$_SESSION['order']['customer']['lastname'];
        $orderDetailData .= "<br />Telefon : ".$_SESSION['order']['customer']['phone'];
        $orderDetailData .= "<br />Adresa : ".$_SESSION['order']['customer']['address'].", ".$_SESSION['order']['customer']['zip']." , ".$_SESSION['order']['customer']['city'];
        $orderDetailData .= "<br /><br />";
        //CUSTOMER INFO END
        //PAYMENT TYPE
//        $paymentData = $_SESSION['order']['paymenttype'];
//        $orderPayment="";
//        switch ($paymentData) {
//            case "p":
//                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
//                break;
//            case "u":
//                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
//                break;
//            case "k":
//                $orderPayment="<br/>Plaćanje: Karticom<br/>";
//                break;
//            case "n":
//                $orderPayment="";
//                break;
//        }
//
//        $orderDetailData .= $orderPayment;
        //PAYMENT TYPE END
        //DELIVERY SERVICE
//        $deliveryType =$_SESSION['order']['delivery']['type'];
//        $deliveryData='';
//        switch ($deliveryData) {
//            case "p":
//                $deliveryData="<br/>Način preuzimanja: Lično<br/>";
//                $shopId = $_SESSION['order']['delivery']['deliverypersonalid'];
//                $shopData = self::getShopDataByShopId($shopId);
//                $deliveryData .= "<br />Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
//                $deliveryData .= "<br />Broj telefona prodavnice: ".$shopData['phone']."<br/>";
//                $deliveryData .= "<br />Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
//                break;
//            case "d":
//                $deliveryData="<br/>Način preuzimanja: Kurirskom službom<br/>";
//                $deliveryServiceId = $_SESSION['order']['delivery']['deliveryserviceid'];
//                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
//                $deliveryData .= "<br />Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
//                $deliveryData .= "<br />Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
//                $deliveryData .= " <br />Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
//                break;
//            case "h":
//                $deliveryData="";
//                break;
//        }
//        $orderDetailData .= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment='WEB';
        if(isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && $_SESSION['order']['comment']!=''){
            $orderComment=$_SESSION['order']['comment'];
            $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
        }
        //COMMENT END
        //PREPARE ORDER ITEMS
        $total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue + 0;
        $calc_totalValueWithRebateWithVat = 0;


        
        


        $orderItems = array();
        if(isset($_SESSION['shopcart_request']) && is_array($_SESSION['shopcart_request'])){
            $orderItems = $_SESSION['shopcart_request'];
            foreach ($orderItems as $key => $cartprod) {
                //GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
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
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['itemvalue'] = $cartprod['price'] * $cartprod['qty'] *(1-($calc_itemRebate/100));
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = $cartprod['price'] * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += $cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100);
                $calc_totalRebateWithVatValue +=$cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100));
                $calc_totalValueWithRebateVatValue += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                $total_price += $calc_totalRebateValue;
                $total_tax +=$calc_totalRebateValue * (($cartprod['tax'])/100);
                $total_price_pdv += $calc_totalValueWithRebateWithVat;

                    
                
                //CALCULATIONS END
            }
        }
        //die();
        //PREPARE ORDER ITEMS END 
        //INCLUDE CREATES $email_msg
        include("app/class/email/EmailOrderRequestB2B.php");


        GlobalHelper::sendEmailOrderRequest(array('client'=>$orderEmail, 'seller'=>$user_conf["b2b_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina-Upit br '.$order_number , 'seller'=>' Novi upit na sajtu '), $email_msg );

        $_SESSION['shopcart_request'] = array();
        if(!isset($_SESSION['order']['document_request_number_b2b'])){
            $_SESSION['order']['document_request_number_b2b'] = $order_number;    
        } else {
            $_SESSION['order']['document_request_number_b2b'] = $order_number;
        }

    }


        public static function createOfferEmail($order_number){
        global $system_conf,$user_conf, $language;

        $orderEmail = (isset($_SESSION['offer']['customer']['email']))? $_SESSION['offer']['customer']['email']:'';
        $orderDocumentTypeName=$user_conf["document_type_offer_name_B2C"][1]." ".$user_conf["b2c_document_prefix"][1]."-".$order_number;
        //CUSTOMER INFO

        $emailOrderCustomerData='';
        $emailOrderRecipientData='';
        $emailOrderDeliveryData='';
        $emailOrderCommentData='';


        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$_SESSION['order']['customer']['email'];
        $orderDetailData .= "<br />Ime : ".$_SESSION['order']['customer']['name'];
        $orderDetailData .= "<br />Prezime : ".$_SESSION['order']['customer']['lastname'];
        $orderDetailData .= "<br />Telefon : ".$_SESSION['order']['customer']['phone'];
        $orderDetailData .= "<br /><br />";


        $emailOrderCustomerData  ="<br /> Detalji naručioca: <br />";
        $emailOrderCustomerData .= "<br />Email:  ".$_SESSION['order']['customer']['email'];
        $emailOrderCustomerData .= "<br />Ime : ".$_SESSION['order']['customer']['name'];
        $emailOrderCustomerData .= "<br />Prezime : ".$_SESSION['order']['customer']['lastname'];
        $emailOrderCustomerData .= "<br />Telefon : ".$_SESSION['order']['customer']['phone'];
        $emailOrderCustomerData .= "<br />";

        $emailOrderRecipientDataFlag=0;


        //$orderDetailData .= "<br />Adresa : ".$_SESSION['offer']['customer']['address'].", ".$_SESSION['offer']['customer']['zip']." , ".$_SESSION['offer']['customer']['city'];
       
        //CUSTOMER INFO END
        //PAYMENT TYPE
        //$paymentData = $_SESSION['offer']['paymenttype'];
        $orderPayment="";
        /*switch ($paymentData) {
            case "p":
                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
                break;
            case "u":
                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
                break;
            case "k":
                $orderPayment="<br/>Plaćanje: Karticom<br/>";
                break;
            case "n":
                $orderPayment="";
                break;
        }*/

        $orderDetailData .= $orderPayment;
        //PAYMENT TYPE END
        //DELIVERY SERVICE
        //$deliveryType =$_SESSION['order']['delivery']['type'];
        $deliveryData='';
        /*switch ($deliveryType) {
            case "p":
                $deliveryData="<br/>Način preuzimanja: Lično<br/>";
                $shopId = $_SESSION['order']['delivery']['deliverypersonalid'];
                $shopData = self::getShopDataByShopId($shopId);
                $deliveryData .= "<br />Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
                $deliveryData .= "<br />Broj telefona prodavnice: ".$shopData['phone']."<br/>";
                $deliveryData .= "<br />Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
                break;
            case "d":
                require_once("app/class/DeliveryService.php");
                $deliveryData="<br/>Način preuzimanja: Kurirskom službom<br/>";
                $deliveryServiceId = $_SESSION['order']['delivery']['deliveryserviceid'];
                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
                $deliveryData .= "<br />Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
                $deliveryData .= "<br />Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
                $deliveryData .= " <br />Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
                break;
            case "h":
                $deliveryData="";
                break;
        }*/
        $orderDetailData .= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment='WEB';
        if(isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && $_SESSION['order']['comment']!=''){
            $orderComment=$_SESSION['order']['comment'];
            $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
            $emailOrderCommentData.= "<br/>Komentar: ".$orderComment."<br/>";
        }
        //COMMENT END
        //PREPARE ORDER ITEMS
        $total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue = 0;
        $calc_totalValueWithRebateWithVat = 0;

        $orderItems = array();
        if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
            $orderItems = $_SESSION['shopcart'];
            foreach ($orderItems as $key => $cartprod) {
                //GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                $productDetail='';
                $productDetail=GlobalHelper::getProductDetailFromId($cartprod['id']);
                 //PRODUCT DESCRIPTION
                //var_dump($productDetail['description'])  ;

                $orderItems[$key]['description'] = $productDetail; //
                //PRODUCT DESCRIPTION END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
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
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                /*$orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['pricewithrebatewithvat'] = round($cartprod['price']*(1-($calc_itemRebate/100)),2)*((100+$cartprod['tax'])/100);
                $orderItems[$key]['itemvalue'] = round($cartprod['price']  *(1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = round($cartprod['price'] * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += round($cartprod['price']  *($calc_itemRebate/100)* $cartprod['qty'],2);
                $calc_totalRebateWithVatValue +=round(round($cartprod['price']  *($calc_itemRebate/100),2)*$cartprod['qty'],2)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += round(round($cartprod['price'] * (1-($calc_itemRebate/100)),2) * $cartprod['qty'],2);
                $calc_totalValueWithRebateVatValue += round(round($cartprod['price']  * (1-($calc_itemRebate/100)),2)*$cartprod['qty'],2) *(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += round(round($cartprod['price']  * (1-($calc_itemRebate/100)),2)*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $total_price += round($calc_totalRebateValue,2);
                $total_tax +=$calc_totalValueWithRebate * (($cartprod['tax'])/100);
                $total_price_pdv += round($calc_totalValueWithRebateWithVat,2);*/
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['pricewithrebatewithvat'] = round($cartprod['price']*(1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2);
                $orderItems[$key]['itemvalue'] = round($cartprod['price'] *(1-($calc_itemRebate/100)),2) * $cartprod['qty'] ;
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = round($cartprod['price'] * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += round($cartprod['price']  *($calc_itemRebate/100),2)* $cartprod['qty'];
                $calc_totalRebateWithVatValue +=round($cartprod['price']  *($calc_itemRebate/100)*(1+($cartprod['tax'])/100),2)* $cartprod['qty'];
                $calc_totalValueWithRebate += round($cartprod['price']  * (1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $calc_totalValueWithRebateVatValue += round($cartprod['price']  * (1-($calc_itemRebate/100))*(($cartprod['tax'])/100),2)* $cartprod['qty'];
                $calc_totalValueWithRebateWithVat += round($cartprod['price']  * (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                //$total_price = $calc_totalRebateValue;
               // $total_tax  = $calc_totalRebateValue * (($cartprod['tax'])/100);
               // $total_price_pdv = $calc_totalValueWithRebateWithVat;
                //CALCULATIONS END
                
                $total_rebate += round($cartprod['price']  *($calc_itemRebate/100),2)* $cartprod['qty'];
                $article_total_price =  round($cartprod['price']   * (1-($calc_itemRebate/100)),2)* $cartprod['qty'];
                $article_total_price_pdv = round($cartprod['price']  * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100),2)* $cartprod['qty'];
                
                $total_price += $article_total_price;
                $total_tax +=$article_total_price * (($cartprod['tax'])/100);
                $total_price_pdv += $article_total_price_pdv;
                //CALCULATIONS END
            }
        }
         
        $delivery_cost=0; 
        if(floatval($total_price_pdv-floatval($_SESSION['voucher']['value']))>$user_conf["free_delivery_from"][1]){
            $delivery_cost=0;
        } else {
            $delivery_cost= $user_conf["delivery_cost"][1];
        }
        
        $voucher_value = 0;
        if(isset($_SESSION['voucher']['value'])){
            $voucher_value = $_SESSION['voucher']['value'];
        }
        
        //PREPARE ORDER ITEMS END 
        //INCLUDE CREATES $email_msg
        if($user_conf["shopcartB2Cshort"][1]==1){
            include("app/class/email/EmailOfferB2Cshort.php");
            //INCLUDE CREATES $pdf_msg
            include("app/class/pdf/PdfOfferB2Cshort.php");
        } else {
            include("app/class/email/EmailOfferB2C.php");
            //INCLUDE CREATES $pdf_msg
            include("app/class/pdf/PdfOfferB2C.php"); 
        }
        GlobalHelper::sendEmailOffer(array('client'=>$orderEmail, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Ponuda br '.$order_number , 'seller'=>' Nova ponuda na sajtu - '.$order_number), $email_msg, $pdf_header, $pdf_msg, $pdf_footer );

        $_SESSION['shopcart'] = array();
        if(!isset($_SESSION['offer']['document_number'])){
            $_SESSION['offer']['document_number'] = $order_number;    
        } else {
            $_SESSION['offer']['document_number'] = $order_number;
        }
    }
    public static function createOfferRequestEmail($order_number){
        global $system_conf,$user_conf, $language;

        
        $orderEmail = (isset($_SESSION['offer']['customer']['email']))? $_SESSION['offer']['customer']['email']:'';
        $orderDocumentTypeName=$user_conf["document_type_offer_request_name_B2C"][1]." ".$user_conf["b2c_document_prefix"][1]."-".$order_number;

        //CUSTOMER INFO
        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$_SESSION['offer']['customer']['email'];
        $orderDetailData .= "<br />Ime : ".$_SESSION['offer']['customer']['name'];
        $orderDetailData .= "<br />Prezime : ".$_SESSION['offer']['customer']['lastname'];
        $orderDetailData .= "<br />Telefon : ".$_SESSION['offer']['customer']['phone'];
        //$orderDetailData .= "<br />Adresa : ".$_SESSION['offer']['customer']['address'].", ".$_SESSION['offer']['customer']['zip']." , ".$_SESSION['offer']['customer']['city'];
        $orderDetailData .= "<br /><br />";
        //CUSTOMER INFO END
        //PAYMENT TYPE
//        $paymentData = $_SESSION['order']['paymenttype'];
//        $orderPayment="";
//        switch ($paymentData) {
//            case "p":
//                $orderPayment="<br/>Plaćanje: Pouzećem<br/>";
//                break;
//            case "u":
//                $orderPayment="<br/>Plaćanje: Uplatnicom<br/>";
//                break;
//            case "k":
//                $orderPayment="<br/>Plaćanje: Karticom<br/>";
//                break;
//            case "n":
//                $orderPayment="";
//                break;
//        }
//
//        $orderDetailData .= $orderPayment;
        //PAYMENT TYPE END
        //DELIVERY SERVICE
//        $deliveryType =$_SESSION['order']['delivery']['type'];
//        $deliveryData='';
//        switch ($deliveryData) {
//            case "p":
//                $deliveryData="<br/>Način preuzimanja: Lično<br/>";
//                $shopId = $_SESSION['order']['delivery']['deliverypersonalid'];
//                $shopData = self::getShopDataByShopId($shopId);
//                $deliveryData .= "<br />Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
//                $deliveryData .= "<br />Broj telefona prodavnice: ".$shopData['phone']."<br/>";
//                $deliveryData .= "<br />Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
//                break;
//            case "d":
//                $deliveryData="<br/>Način preuzimanja: Kurirskom službom<br/>";
//                $deliveryServiceId = $_SESSION['order']['delivery']['deliveryserviceid'];
//                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
//                $deliveryData .= "<br />Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
//                $deliveryData .= "<br />Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
//                $deliveryData .= " <br />Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
//                break;
//            case "h":
//                $deliveryData="";
//                break;
//        }
//        $orderDetailData .= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment='WEB';
        if(isset($_SESSION['order']) && isset($_SESSION['order']['comment']) && $_SESSION['order']['comment']!=''){
            $orderComment=$_SESSION['order']['comment'];
            $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
        }
        //COMMENT END
        //PREPARE ORDER ITEMS
        $total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue + 0;
        $calc_totalValueWithRebateWithVat = 0;


        
        


        $orderItems = array();
        if(isset($_SESSION['shopcart_request']) && is_array($_SESSION['shopcart_request'])){
            $orderItems = $_SESSION['shopcart_request'];
            foreach ($orderItems as $key => $cartprod) {
                //GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
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
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['itemvalue'] = $cartprod['price'] * $cartprod['qty'] *(1-($calc_itemRebate/100));
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = $cartprod['price'] * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += $cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100);
                $calc_totalRebateWithVatValue +=$cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100));
                $calc_totalValueWithRebateVatValue += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                $total_price += $calc_totalRebateValue;
                $total_tax +=$calc_totalRebateValue * (($cartprod['tax'])/100);
                $total_price_pdv += $calc_totalValueWithRebateWithVat;

                    
                
                //CALCULATIONS END
            }
        }
        //die();
        //PREPARE ORDER ITEMS END 
        //INCLUDE CREATES $email_msg
        include("app/class/email/EmailOfferRequestB2C.php");

        GlobalHelper::sendEmailOrderRequest(array('client'=>$orderEmail, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Ponuda-Upit br '.$order_number , 'seller'=>' Nova ponuda-upit na sajtu '), $email_msg );

        $_SESSION['shopcart_request'] = array();
        if(!isset($_SESSION['offer']['document_request_number'])){
            $_SESSION['offer']['document_request_number'] = $order_number;    
        } else {
            $_SESSION['offer']['document_request_number'] = $order_number;
        }

    }
	
	public static function createCreditCardOrderEmail($orderid){
		
		global $user_conf, $system_conf, $language, $conn;

		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT d.* , dd.*, c.value as `couponvalue`
				FROM b2c_document AS d
				LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
				LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
				LEFT JOIN coupons c ON uc.couponsid = c.id
				WHERE d.id = ".$orderid;
				//echo $q;
		$dres = $mysqli->query($q);
		$drow = $dres->fetch_assoc();
		$order_number = $drow['number'];
		$orderDocumentStatus= $drow['status'];
		$orderDocumentStatusData='';

		$orderDocumentStatusData = '<div class="container">
					<p class="autoemail">Ova poruka je bila poslata automatski. Na ovaj mail molimo da ne odgovarate. U slučaju dodatnih informacija pišite nam na '.$user_conf["b2c_address"][1].' ili na telefon naveden na sajtu.</p>
				</div>
				<div class="container-fluid logoline">
					<img src="'.$system_conf["theme_path"][1]."/".$user_conf["sitelogo"][1].'"  />
				</div>
				
				<div class="container">
					<h3 class="bigmessage">VAŠA PORUDŽBINA JE U FAZI OBRADE!</h3>
					<p class="infoemail_text">Poštovani '.$drow['customername'].', </p>
							<p class="infoemail_text">NAKON FINALNE PROVERE PROIZVODA KOJE STE PORUČILI <br >
DOBIĆETE KONAČNU POTVRDU DA LI JE VAŠA PORUDŽBINA <br >
PRIHVAĆENA I POSLATA , KAO I BROJ ZA PRAĆENJE VAŠE PORUDŽBINE UKOLIKO STE PRILIKOM PORUČIVANJA ODABRALI KURIRSKU SLUŽBU.</p> 
					</p>	
						
				</div>';

		
		$orderEmail = $drow['customeremail'];
        $orderDocumentTypeName=$user_conf["document_type_name_B2C"][1]." ".$user_conf["b2c_document_prefix"][1]."-".$order_number;

        //CUSTOMER INFO
        $orderDetailData  ="<br /> Detalji naručioca: <br />";
        $orderDetailData .= "<br />Email:  ".$drow['customeremail'];
        $orderDetailData .= "<br />Ime : ".$drow['customername'];
        $orderDetailData .= "<br />Prezime : ".$drow['customerlastname'];
        $orderDetailData .= "<br />Telefon : ".$drow['customerphone'];
        $orderDetailData .= "<br />Adresa : ".$drow['customeraddress'].", ".$drow['customerzip']." , ".$drow['customercity'];
        $orderDetailData .= "<br /><br />";
        //CUSTOMER INFO END
        //PAYMENT TYPE
        $paymentData = $drow['payment'];
        $orderPayment="";
        
		$orderPayment="<br/>Plaćanje: Karticom<br/>";
		
        $orderDetailData .= $orderPayment;
        //PAYMENT TYPE END

        //DELIVERY SERVICE
        $deliveryType = $drow['deliverytype'];
        $deliveryData='';
        switch ($deliveryType) {
            case "p":
                $deliveryData="<br/>Način preuzimanja: Lično<br/>";
                $shopId = $drow['deliveryshopid'];
                require_once('app/class/Shop.php');
                $shopData = Shop::getShopDataByShopId($shopId);
                $deliveryData .= "<br />Pošiljku preuzeti u prodavnici: ".$shopData['name']."<br/>";
                $deliveryData .= "<br />Broj telefona prodavnice: ".$shopData['phone']."<br/>";
                $deliveryData .= "<br />Adresa prodavnice: ".$shopData['address'].", ".$shopData['cityname']."<br/>";
                break;
            case "d":
                require_once("app/class/DeliveryService.php");
                $deliveryData="<br/>Način preuzimanja: Kurirskom službom<br/>";
                $deliveryServiceId = $drow['deliveryserviceid'];
                $deliveryServiceData = DeliveryService::getDeliveryServiceAssocById($deliveryServiceId);
                $deliveryData .= "<br />Pošiljku poslati kurirskom službom: ".$deliveryServiceData['name']."<br/>"; 
                $deliveryData .= "<br />Telefon kurirske službe: ".$deliveryServiceData['phone']."<br/>";
                $deliveryData .= " <br />Sajt kurirske službe: ".$deliveryServiceData['website']."<br/>";
                if(strlen($deliveryServiceData['deliverytracklink'])>0 && strlen($drow['deliverycode'])>0){
                	$deliveryData .= " <br /><b>Pošiljku možete pratiti na sledećem linku: ".$deliveryServiceData['deliverytracklink']."</b><br/>";
                	$deliveryData .= " <br /><b>Vaš kod za praćenje pošiljke je: ".$drow['deliverycode']."</b><br/>";	
                }
                break;
            case "h":
                $deliveryData="";
                break;
        }
        $orderDetailData .= $deliveryData;
        //DELIVERY SERVICE END
        //COMMENT
        $orderComment = $drow['comment'];
        $orderDetailData .= "<br/>Komentar: ".$orderComment."<br/><br/>";
        //COMMENT END

        //PREPARE ORDER ITEMS
        /*$qItems = "SELECT di.rebate, di.price, di.taxvalue AS `tax`, p.name AS `productname`, p.code, p.unitname,dia.quantity, dia.attrvalue, d.*, c.value as couponvalue, dd.customeremail AS email, di.productattrstring  
							FROM b2c_documentitemattr dia
								LEFT JOIN b2c_documentitem di ON dia.b2c_documentitemid = di.id
								LEFT JOIN b2c_document d ON di.b2c_documentid = d.id
								LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid
								LEFT JOIN product p ON di.productid = p.id
								LEFT JOIN usercoupon uc ON d.usedcouponid = uc.id
								LEFT JOIN coupons c ON uc.couponsid = c.id
								WHERE dia.status != 'd' AND di.b2c_documentid = ".$orderid;

		$resItems = mysqli_query($conn, $qItems);
							
		$dataItems = array();
		if(mysqli_num_rows($resItems) > 0){
			while($rowItem = mysqli_fetch_assoc($resItems)){
				array_push($dataItems, $rowItem);
			}
		}*/


		$dataItems = array();
		include_once('app/class/Document.php');
		$dataItems = DocumentB2C::GetB2C_DocumentItemByDocumentId($orderid);


		$total_price = 0;
        $total_price_pdv = 0;
        $total_tax = 0;

        $calc_totalValue = 0;
        $calc_totalRebateValue =0;
        $calc_totalRebateWithVatValue =0;
        $calc_totalValueWithRebate = 0;
        $calc_totalValueWithRebateVatValue = 0;
        $calc_totalValueWithRebateWithVat = 0;

        $orderItems = array();

        if(isset($dataItems) && is_array($dataItems) && count($dataItems)>0){
        	$orderItems = $dataItems;
        	
        	include_once('app/class/Product.php');
        	foreach ($orderItems as $key => $cartprod) {
        		//GET PRODUCT DATA
                $prodData = GlobalHelper::getProductDataFromId($cartprod['id']);
                //GET PRODUCT DATA END
                //SORT
                $orderItems[$key]['sort'] = $key+1;
                //SORT END
                //PRODUCT CODE
                $orderItems[$key]['code'] = $prodData['code'];
                //PRODUCT CODE END
                //PRODUCT NAME
                $orderItems[$key]['name'] = $prodData['name'];
                //PRODUCT NAME END
                //PRODUCT UNIT NAME 
                $orderItems[$key]['unitname'] = $prodData['unitname']; 
                //PRODUCT UNIT NAME END
                //PRODUCT LINK
                $orderItems[$key]['link'] = GlobalHelper::getProductLinkFromProdId($cartprod['id']);
                //PRODUCT LINK END
                //PRODUCT QUANTITY
                $orderItems[$key]['quantity'] = $cartprod['qty'];
                //PRODUCT QUANTITY END
                //PRODUCT PRICE
                $orderItems[$key]['price'] = $cartprod['price'];
                //PRODUCT PRICE END
                //PRODUCT IMAGE
                $orderItems[$key]['picture'] = $cartprod['pic'];
                //PRODUCT IMAGE END
                //ATRIBUTES
                $attrs = array();
                
                $a = json_decode($cartprod['attr'], true);
                
                if(count($a)>0){
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
                
                }
                $orderItems[$key]['attrn'] = $attrs;
                $attributes = '';   
                foreach ($attrs as $attr) {
                    $attributes .= $attr['attrname'] .": ". $attr['attrvalname']." | ";
                }
                $orderItems[$key]['attributes']=$attributes;
                //atributes end
                //ATRIBUTES END
                //PRODUCT MAX REBATE
                $orderItems[$key]['maxrebate'] = Product::getMaxRebate($cartprod['id']);
                $calc_maxRebate = $orderItems[$key]['maxrebate'];
                //PRODUCT MAX REBATE END
                //PRDUCT QUANTITY REBATE
                $orderItems[$key]['quantityrebate'] = Product::getProductQuantityRebate($cartprod['id']);
                $quantityRebate=$orderItems[$key]['quantityrebate'];

                $calc_quantityRebate = 0; 
                if(isset($quantityRebate) && count($quantityRebate)>0) { 
                    
                    foreach($quantityRebate as $qrval) {
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) {
                            $calc_quantityRebate=$qrval["rebate"] ;
                        } 
                    } 
                } else { 
                    $calc_quantityRebate=0 ;
                } 
                $orderItems[$key]['quantityrebatevalue'] = $calc_quantityRebate;
                //PRDUCT QUANTITY REBATE END
                //maxrebate
                $calc_itemRebate = 0;
                $calc_zeroRebate=false;
                
                $calc_itemRebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($calc_quantityRebate/100)));
                if(($calc_itemRebate>=$calc_maxRebate || is_null($calc_maxRebate)) && $user_conf["act_priority"]==0){
                    $calc_itemRebate=$calc_maxRebate;
                    $calc_zeroRebate=true;
                }
                $orderItems[$key]['item_rebate'] = $calc_itemRebate;
                $orderItems[$key]['pricewithrebate'] = $cartprod['price']*(1-($calc_itemRebate/100));
                $orderItems[$key]['itemvalue'] = $cartprod['price'] * $cartprod['qty'] *(1-($calc_itemRebate/100));
                $orderItems[$key]['taxvalue'] = $cartprod['tax'];
                $orderItems[$key]['itemvaluewithvat'] = $cartprod['price'] * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //maxrebate end
               
                //CALCULATIONS
                //TOTAL
                $calc_totalValue += $cartprod['price']  * $cartprod['qty'];
                $calc_totalRebateValue += $cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100);
                $calc_totalRebateWithVatValue +=$cartprod['price']  * $cartprod['qty']*($calc_itemRebate/100)*(1+($cartprod['tax'])/100);
                $calc_totalValueWithRebate += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100));
                $calc_totalValueWithRebateVatValue += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*(($cartprod['tax'])/100);
                $calc_totalValueWithRebateWithVat += $cartprod['price']  * $cartprod['qty']* (1-($calc_itemRebate/100))*((100+$cartprod['tax'])/100);
                //TOTAL
                //$article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($calc_itemRebate/100));
                //$article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($calc_itemRebate/100)) * ((100+$cartprod['tax'])/100);
                $total_price += $calc_totalRebateValue;
                $total_tax +=$calc_totalRebateValue * (($cartprod['tax'])/100);
                $total_price_pdv += $calc_totalValueWithRebateWithVat;
                //CALCULATIONS END
        	}
        }

        $delivery_cost=0; 
		if(floatval($total_price_pdv-floatval($drow['couponvalue']))>$user_conf["free_delivery_from"][1]){
			$delivery_cost=0;
		} else {
			$delivery_cost= $user_conf["delivery_cost"][1];
		}
		
		$voucher_value = 0;
		$voucher_value = $drow['couponvalue'];
        //PREPARE ORDER ITEMS END 
        if($user_conf["shopcartB2Cshort"][1]==1){
           include("app/class/email/EmailOrderB2Cshort.php");
            //INCLUDE CREATES $pdf_msg
           // include("app/class/pdf/PdfOrderB2Cshort.php");
        } else {
            include("app/class/email/EmailOrderB2C.php");
            //INCLUDE CREATES $pdf_msg
            //include("app/class/pdf/PdfOrderB2C.php"); 
        }
		
        return $email_msg;
        //GlobalHelper::sendEmailOrder(array('client'=>$orderEmail, 'seller'=>$user_conf["b2c_address"][1]), $user_conf["autoemail"][1], array('client'=>'Porudzbina br '.$order_number , 'seller'=>' Nova porudzbina na sajtu - '.$order_number), $email_msg, $pdf_header, $pdf_msg, $pdf_footer );
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
		
	
	
	
}