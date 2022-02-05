<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include_once("../../../config/db_config.php"); 
	include("../../../config/config.php");
	include("../../userlog.php");
	
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "createreservationquick" : createReservationQuick(); break;
			
		}
	}

	function createReservationNumberB2C($documenttype){
		global $conn;
		
		$q = "SELECT COUNT(ID) as num FROM b2c_document WHERE documenttype='".$documenttype."' AND YEAR(documentdate) = YEAR(CURDATE())";	
		$res=mysqli_query($conn, $q);

		$number = "";
		if(mysqli_num_rows($res) > 0){
			$row = mysqli_fetch_assoc($res);
			$number = (intval($row['num'])+1)."/".date("Y")."_WEB"; 	
		}
		
		return $number;
	}

	function createReservationQuick(){
		
        global $user_conf, $language, $conn;
		include_once($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");
		include_once($_SERVER['DOCUMENT_ROOT']."/".$system_conf["theme_path"][1].'config/user.configuration.php');
		
		$continue = false;
		$q = "SELECT * FROM languages WHERE `default` = 'y'";
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) > 0){
			$row = mysqli_fetch_assoc($res);
			include_once($_SERVER['DOCUMENT_ROOT']."/".$system_conf["theme_path"][1].'lang/'.$row['code'].'.php');
			$continue = true;
		}
        
        if($continue){
        //SHOPCART EXISTS
////////////PREPARE DOCUMENT DATA
            $orderId='';
            $orderDocumentId='';
            $orderNumber = createReservationNumberB2C('E');
            $orderDocumentType = 'E';
            $orderDocumentCurrency = $language["moneta"][1]; //RSD 
            $orderDocumentDate = 'NOW()';
            $orderDocumentValuteDate = 'NOW()';
            $orderAddmitionDocumentDate = 'NULL';
            $orderComment='WEB';
            
            $orderDescription = '' ; 
            $orderPartnerId = '0';
            $orderPartnerAddressId = '0';
            $orderStatus = 'bp' ; 
            $orderDocReturn = 'n' ;
            $orderDirection = 0 ;
            $orderWarehouseId = $user_conf["b2cwh"][1];
            $orderPayment = 'p'; //"p-pouzecem" || "u-uplatnicom" || "k-karticom" || "n-nije definisano"
            
            $orderCouponId = 0;
            $orderUsedCouponId = 0;
			
            $orderDeliveryCode = '';
            $orderOrigin = 'WEB';
            $orderBankStatus = 'pre';
            $orderB2C_ReservationId = 0;
            $orderB2C_WebReservationId = 0;
            $orderB2C_RelatedDocumentId = 0;
            $orderTimeStart = '0000-00-00 00:00:00';
            $orderUserId = '0';
            $orderLastModifiedUserId = 0;
            $orderTimestamp='CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DATA END
////////////INSERT DOCUMENT DATA
            $sqlInsertDocumentB2C = "INSERT INTO `b2c_document`(`id`, `documentid`, `number`, `documenttype`, `documentcurrency`, `documentdate`, `valutedate`,`admitiondocumentdate`, `comment`, `description`, 
                                                                `partnerid`, `partneraddressid`, `status`, `docreturn`, `direction`, `warehouseid`, `payment`, `couponid`, `usedcouponid`, `deliverycode`, `origin`, `bankstatus`, 
                                                                `b2c_reservationid`, `b2c_webreservationid`, `b2c_relateddocumentid`, `timerstart`, `userid`, `lastmodified_userid`, `ts`) 
                                         VALUES ('".$orderId."',  
                                                 '".$orderDocumentId."',
                                                 '".mysqli_real_escape_string($conn, $orderNumber)."',
                                                 '".mysqli_real_escape_string($conn, $orderDocumentType)."',
                                                 '".mysqli_real_escape_string($conn, $orderDocumentCurrency)."',
                                                  ".$orderDocumentDate.",
                                                  ".$orderDocumentValuteDate.",
                                                  ".$orderAddmitionDocumentDate.",
                                                 '".mysqli_real_escape_string($conn, $orderComment)."',
                                                 '".mysqli_real_escape_string($conn, $orderDescription)."',
                                                  ".mysqli_real_escape_string($conn, $orderPartnerId).",
                                                  ".mysqli_real_escape_string($conn, $orderPartnerAddressId).",
                                                 '".mysqli_real_escape_string($conn, $orderStatus)."',
                                                 '".$orderDocReturn."',
                                                  ".$orderDirection.",
                                                  ".mysqli_real_escape_string($conn, $orderWarehouseId).",
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

            mysqli_query($conn, $sqlInsertDocumentB2C);
            $lastDocumentId = mysqli_insert_id($conn);
////////////INSERT DOCUMENT DATA END
////////////PREPARE DOCUMENT DETAIL DATA
            $orderDetail_B2C_DocumentId = $lastDocumentId;
            $orderDetail_AdditionalComment = '';
            $orderDetail_CustomerName =  '';
            $orderDetail_CustomerLastName = '';
            $orderDetail_CustomerEmail = '';
            $orderDetail_CustomerPhone = '';
            $orderDetail_CustomerAddress = '';
            $orderDetail_CustomerCity = '';
            $orderDetail_CustomerZip = '';
            $orderDetail_RecipientName = '';
            $orderDetail_RecipientLastName = '';
            $orderDetail_RecipientPhone = '';
            $orderDetail_RecipientAddress = '';
            $orderDetail_RecipientCity = '';
            $orderDetail_RecipientZip = '';
            $orderDetail_DeliveryType = 'p';
            $orderDetail_DeliveryShopId = 0;
            $orderDetail_DeliveryServiceId = 0;
			$orderDetail_DeliveryCost = 0;
            $orderDetail_TimeStamp = 'CURRENT_TIMESTAMP';
////////////PREPARE DOCUMENT DETAIL DATA END
////////////INSERT DOCUMENT DETAIL DATA
            $sqlInsertDocumentDetailB2C = "INSERT INTO b2c_documentdetail (`b2c_documentid`, `additionalcomment`, `customername`, `customerlastname`, `customeremail`, `customerphone`, `customeraddress`, `customercity`, `customerzip`, `recipientname`, `recipientlastname`, `recipientphone`, `recipientaddress`, `recipientcity`, `recipientzip`, `deliverytype`, `deliveryshopid`, `deliveryserviceid`, `deliverycost`, `ts`) 
                                                                   VALUES (".$orderDetail_B2C_DocumentId.",
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_AdditionalComment)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerName)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerLastName)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerEmail)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerPhone)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerAddress)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerCity)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_CustomerZip)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_RecipientName)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_RecipientLastName)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_RecipientPhone)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_RecipientAddress)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_RecipientCity)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_RecipientZip)."',
                                                                          '".mysqli_real_escape_string($conn, $orderDetail_DeliveryType)."',
                                                                           ".$orderDetail_DeliveryShopId.",
                                                                           ".$orderDetail_DeliveryServiceId.",
																		   ".$orderDetail_DeliveryCost.",
                                                                           ".$orderDetail_TimeStamp." 
                                                                          )";
																		 
            mysqli_query($conn,$sqlInsertDocumentDetailB2C);
////////////INSERT DOCUMENT DETAIL DATA END

            echo $lastDocumentId;
        //SHOPCART EXISTS END
        }
        else{
            echo 0;   
        }

    }

?>