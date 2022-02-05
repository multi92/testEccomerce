<?php
$module_version["document"] = array('module', '1.0.0.0.1', 'Nema opisa');


class DocumentB2C{

	public $id;
	public $documentid;
	public $number;
	public $documenttype;
	public $documentcurrency;
	public $valutedate;
	public $admitiondocumentdate;
	public $comment;
	public $description;
	public $partnerid;
	public $partneraddressid;
	public $status;
	public $docreturn;
	public $direction;
	public $warehouseid;
	public $payment;
	public $bankstatus;
	public $couponid;
	public $usedcouponid;
	public $deliverycode;
	public $origin;
	public $b2c_reservationid;
	public $b2c_webreservationid;
	public $b2c_relateddocumentid;
	public $timerstart;
	public $userid;
	public $lastmodified_userid;
	public $ts;
	public $documentdetail;
	public $documentitem;
	
	public function __construct($id, $documentid, $number, $documenttype, $documentcurrency, $valutedate, $admitiondocumentdate, $comment, $description, 
								$partnerid, $partneraddressid, $status, $docreturn, $direction, $warehouseid, $payment, $bankstatus, $couponid, $usedcouponid, $deliverycode, $origin, $b2c_reservationid, $b2c_webreservationid, $b2c_relateddocumentid, $timerstart, $userid, $lastmodified_userid, $ts, $documentdetail,  $documentitem){
			$this->id = $id;
			$this->documentid = $documentid;
			$this->number = $number;
			$this->documenttype = $documenttype;
			$this->documentcurrency = $documentcurrency;
			$this->valutedate = $valutedate;
			$this->admitiondocumentdate = $admitiondocumentdate;
			$this->comment = $comment;
			$this->description = $description;
			$this->partnerid = $partnerid;
			$this->partneraddressid = $partneraddressid;
			$this->status = $status;
			$this->docreturn = $docreturn;
			$this->direction = $direction;
			$this->warehouseid = $warehouseid;
			$this->payment = $payment;
			$this->bankstatus = $bankstatus;
			$this->couponid = $couponid;
			$this->usedcouponid = $usedcouponid;
			$this->deliverycode = $deliverycode;
			$this->origin = $origin;
			$this->b2c_reservationid = $b2c_reservationid;
			$this->b2c_webreservationid = $b2c_webreservationid;
			$this->b2c_relateddocumentid = $b2c_relateddocumentid;
			$this->timerstart = $timerstart;
			$this->userid = $userid;
			$this->lastmodified_userid = $lastmodified_userid;
			$this->ts = $ts;
			$this->documentdetail = $documentdetail;
			$this->documentitem = $documentitem;
		
	}

	public static function GetB2C_DocumentByDocumentNumber($DocumentNumber){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $system_conf, $user_conf, $theme_conf;

        $sqlSelectDocument = "SELECT d.*
								FROM b2c_document as d
								LEFT JOIN b2c_documentdetail as dd ON d.ID = dd.b2c_documentid
				  				WHERE d.number = '".$DocumentNumber."'";
		//echo $sqlSelectDocument;
		$result=$mysqli->query($sqlSelectDocument);
		$row = 0;
		$DocumentData = (object)array();
        if($result->num_rows >0) {
            $row = $result->fetch_assoc();  

            $DocumentData = new DocumentB2C($row['id'],
										$row['documentid'],
										$row['number'],
										$row['documenttype'],
										$row['documentcurrency'],
										$row['valutedate'],
										$row['admitiondocumentdate'],
										$row['comment'],
										$row['description'],
										$row['partnerid'],
										$row['partneraddressid'],
										$row['status'],
										$row['docreturn'],
										$row['direction'],
										$row['warehouseid'],
										$row['payment'],
										$row['bankstatus'],
										$row['couponid'],
										$row['usedcouponid'],
										$row['deliverycode'],
										$row['origin'],
										$row['b2c_reservationid'],
										$row['b2c_webreservationid'],
										$row['b2c_relateddocumentid'],
										$row['timerstart'],
										$row['userid'],
										$row['lastmodified_userid'],
										$row['ts'],
										self::GetB2C_DocumentDetailByDocumentId($row['id']),
										self::GetB2C_DocumentItemByDocumentId($row['id'])
									);

        }
		return $DocumentData;
	}

	public static function GetB2C_DocumentDetailByDocumentId($DocumentId){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");


		global $system_conf, $user_conf, $theme_conf;

        $sqlSelectDocumentDetail = "SELECT dd.*
								FROM b2c_documentdetail as dd
				  				WHERE dd.b2c_documentid = '".$DocumentId."'";
		  				
		$result=$mysqli->query($sqlSelectDocumentDetail);
		$row = 0;
		$DocumentDetailData=array();
		if($result->num_rows >0) {
			 $row = $result->fetch_assoc();  
			 	$DocumentDetailData=$row;
			 	$DocumentDetailData['deliveryshopdata']=array();
			 	$DocumentDetailData['deliveryservicedata']=array();
			 	if($DocumentDetailData['deliveryshopid']>0){
			 		include_once("app/class/Shop.php");
			 		$DocumentDetailData['deliveryshopdata'] = Shop::getShopDataByShopId($DocumentDetailData['deliveryshopid']);
			 	}
			 	if($DocumentDetailData['deliveryserviceid']>0){
			 		include_once("app/class/DeliveryService.php");
            		$DocumentDetailData['deliveryservicedata'] = DeliveryService::getDeliveryServiceAssocById($DocumentDetailData['deliveryserviceid']);
			 	}
			 }
		return $DocumentDetailData;
	
	}

	public static function GetB2C_DocumentItemByDocumentId($DocumentId){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");


		global $system_conf, $user_conf, $theme_conf;

        $sqlSelectDocumentItem = "SELECT di.*, atr.quantity AS `atrquantity`, atr.attrvalue
								FROM b2c_documentitem as di
								LEFT JOIN b2c_documentitemattr as atr ON di.id=b2c_documentitemid
				  				WHERE di.b2c_documentid = '".$DocumentId."' ORDER BY di.sort ASC";
		//echo $sqlSelectDocumentItem;
		$result=$mysqli->query($sqlSelectDocumentItem);

		$DocumentItemData=array();
		if($result->num_rows >0) {
			while($row = $result->fetch_assoc()){
				$rowDocumentItem = array();
				$rowDocumentItem['id'] = $row['productid'];
				//echo 'prodid = '.$rowDocumentItem['id'];
				$rowDocumentItem['name'] = $row['productname'];
				$rowDocumentItem['price'] = $row['price'];
				$rowDocumentItem['rebate'] = $row['rebate'];
				$rowDocumentItem['tax'] = $row['taxvalue'];
				$rowDocumentItem['pic'] = '';
				$rowDocumentItem['qty'] = $row['atrquantity'];

				$tmpav = array();
				if($row['attrvalue']!='' && strlen($row['attrvalue'])>0){
                $q = "SELECT a.name, av.value, a.id AS attrid, av.id AS attrvalid FROM attr a
                        LEFT JOIN attrval av ON a.id = av.attrid
                        WHERE av.id IN (".$row['attrvalue'].")";
                        //echo $q;
                $ares = $mysqli->query($q);
                if($ares->num_rows > 0){
                    while($arow=$ares->fetch_assoc())
                    {
                    	array_push($tmpav, array($arow['attrid'],$arow['attrvalid']));
                        //$attr_data .= $arow['name']." : ".$arow['value']." <br />";
                    }
                }

                }
				//var_dump( json_encode($tmpav));
				$rowDocumentItem['attr'] = json_encode($tmpav);
				//var_dump($rowDocumentItem['attr']);
				$rowDocumentItem['unitname'] = '';
				$rowDocumentItem['unitstep'] = '';
				array_push($DocumentItemData, $rowDocumentItem);
			}
			}
		return $DocumentItemData;
	}

}





class DocumentB2B{

	public $id;
	public $documentid;
	public $number;
	public $documenttype;
	public $documentcurrency;
	public $valutedate;
	public $admitiondocumentdate;
	public $comment;
	public $description;
	public $partnerid;
	public $partneraddressid;
	public $status;
	public $docreturn;
	public $direction;
	public $warehouseid;
	public $payment;
	public $bankstatus;
	public $couponid;
	public $usedcouponid;
	public $deliverycode;
	public $origin;
	public $b2b_reservationid;
	public $b2b_webreservationid;
	public $b2b_relateddocumentid;
	public $timerstart;
	public $userid;
	public $lastmodified_userid;
	public $ts;
	public $documentdetail;
	public $documentitem;
	
	public function __construct($id, $documentid, $number, $documenttype, $documentcurrency, $valutedate, $admitiondocumentdate, $comment, $description, 
								$partnerid, $partneraddressid, $status, $docreturn, $direction, $warehouseid, $payment, $bankstatus, $couponid, $usedcouponid, $deliverycode, $origin, $b2b_reservationid, $b2b_webreservationid, $b2b_relateddocumentid, $timerstart, $userid, $lastmodified_userid, $ts, $documentdetail, $documentitem){
			$this->id = $id;
			$this->documentid = $documentid;
			$this->number = $number;
			$this->documenttype = $documenttype;
			$this->documentcurrency = $documentcurrency;
			$this->valutedate = $valutedate;
			$this->admitiondocumentdate = $admitiondocumentdate;
			$this->comment = $comment;
			$this->description = $description;
			$this->partnerid = $partnerid;
			$this->partneraddressid = $partneraddressid;
			$this->status = $status;
			$this->docreturn = $docreturn;
			$this->direction = $direction;
			$this->warehouseid = $warehouseid;
			$this->payment = $payment;
			$this->bankstatus = $bankstatus;
			$this->couponid = $couponid;
			$this->usedcouponid = $usedcouponid;
			$this->deliverycode = $deliverycode;
			$this->origin = $origin;
			$this->b2b_reservationid = $b2b_reservationid;
			$this->b2b_webreservationid = $b2b_webreservationid;
			$this->b2b_relateddocumentid = $b2b_relateddocumentid;
			$this->timerstart = $timerstart;
			$this->userid = $userid;
			$this->lastmodified_userid = $lastmodified_userid;
			$this->ts = $ts;
			$this->documentdetail = $documentdetail;
			$this->documentitem = $documentitem;
		
	}

	public static function GetB2B_DocumentByDocumentNumber($DocumentNumber, $DocumentType){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $system_conf, $user_conf, $theme_conf;

        

        $sqlSelectDocument = "SELECT d.*
								FROM b2b_document as d
				  				WHERE d.number = '".$DocumentNumber."' AND d.documenttype='".$DocumentType."' ";

		$result=$mysqli->query($sqlSelectDocument);
		$row = 0;
		$DocumentData = (object)array();
        if($result->num_rows >0) {
            $row = $result->fetch_assoc();  

            $DocumentData = new DocumentB2B($row['id'],
										$row['documentid'],
										$row['number'],
										$row['documenttype'],
										$row['documentcurrency'],
										$row['valutedate'],
										$row['admitiondocumentdate'],
										$row['comment'],
										$row['description'],
										$row['partnerid'],
										$row['partneraddressid'],
										$row['status'],
										$row['docreturn'],
										$row['direction'],
										$row['warehouseid'],
										$row['payment'],
										$row['bankstatus'],
										$row['couponid'],
										$row['usedcouponid'],
										$row['deliverycode'],
										$row['origin'],
										$row['b2b_reservationid'],
										$row['b2b_webreservationid'],
										$row['b2b_relateddocumentid'],
										$row['timerstart'],
										$row['userid'],
										$row['lastmodified_userid'],
										$row['ts'],
										self::GetB2B_DocumentDetailByDocumentId($row['id']),
										self::GetB2B_DocumentItemByDocumentId($row['id'])
									);

        }
		return $DocumentData;
	}

	public static function GetB2B_DocumentDetailByDocumentId($B2BDocumentId){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");


		global $system_conf, $user_conf, $theme_conf;

        $sqlSelectDocumentDetail = "SELECT dd.*
								FROM b2b_documentdetail as dd
				  				WHERE dd.b2b_documentid = '".$B2BDocumentId."'";

		$result=$mysqli->query($sqlSelectDocumentDetail);
		$row = 0;
		$DocumentDetailData=array();
		if($result->num_rows >0) {
			 $row = $result->fetch_assoc();  
			 	$DocumentDetailData=$row;
			 	$DocumentDetailData['deliveryshopdata']=array();
			 	$DocumentDetailData['deliveryservicedata']=array();
			 	if($DocumentDetailData['deliveryshopid']>0){
			 		include_once("app/class/Shop.php");
			 		$DocumentDetailData['deliveryshopdata'] = Shop::getShopDataByShopId($DocumentDetailData['deliveryshopid']);
			 	}
			 	if($DocumentDetailData['deliveryserviceid']>0){
			 		include_once("app/class/DeliveryService.php");
            		$DocumentDetailData['deliveryservicedata'] = DeliveryService::getDeliveryServiceAssocById($DocumentDetailData['deliveryserviceid']);
			 	}
			 }
		return $DocumentDetailData;
	
	}	

	public static function GetB2B_DocumentItemByDocumentId($DocumentId){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");


		global $system_conf, $user_conf, $theme_conf;

        $sqlSelectDocumentItem = "SELECT di.*, atr.quantity AS `atrquantity`, atr.attrvalue
								FROM b2b_documentitem as di
								LEFT JOIN b2b_documentitemattr as atr ON di.id=b2b_documentitemid
				  				WHERE di.b2b_documentid = '".$DocumentId."'";

		$result=$mysqli->query($sqlSelectDocumentItem);
		
		$DocumentItemData=array();
		if($result->num_rows >0) {
			while($row = $result->fetch_assoc()){
				$rowDocumentItem = array();
				$rowDocumentItem['id'] = $row['productid'];
				$rowDocumentItem['name'] = $row['productname'];
				$rowDocumentItem['price'] = $row['price'];
				$rowDocumentItem['rebate'] = $row['rebate'];
				$rowDocumentItem['tax'] = $row['taxvalue'];
				$rowDocumentItem['pic'] = '';
				$rowDocumentItem['qty'] = $row['atrquantity'];
				$tmpav = array();
				if(isset($row['attrvalue'])&& strlen($row['attrvalue'])>0 && $row['attrvalue']!=''){

						$q = "SELECT a.name, av.value, a.id AS attrid, av.id AS attrvalid FROM attr a
                        LEFT JOIN attrval av ON a.id = av.attrid
                        WHERE av.id IN (".$row['attrvalue'].")";
                		//echo $q;
                		$ares = $mysqli->query($q);
                		if($ares->num_rows > 0){
                		    while($arow=$ares->fetch_assoc())
                		    {
                		    	array_push($tmpav, array($arow['attrid'],$arow['attrvalid']));
                		        //$attr_data .= $arow['name']." : ".$arow['value']." <br />";
                		    }
                		}

				}
                


				//var_dump( json_encode($tmpav));
				$rowDocumentItem['attr'] = json_encode($tmpav);
				$rowDocumentItem['unitname'] = '';
				$rowDocumentItem['unitstep'] = '';
				array_push($DocumentItemData, $rowDocumentItem);
			}
			}
		return $DocumentItemData;
	}

}
?>