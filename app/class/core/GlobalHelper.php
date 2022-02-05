<?php

$class_version["globalhelper"] = array('module', '1.0.0.0.1', 'Nema opisa');

class GlobalHelper
{
	public static function sendRecommendedPrice($price, $email){
		global $user_conf, $language;
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		$q = "SELECT code, name FROM product WHERE id = ".$_POST['productid'];
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
		}
		require_once('cdn/phpmailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		
		//$mail->isSMTP();    
		$mail->isMail();                                
		$mail->Host = $user_conf["autoemail_host"][1];  
		$mail->SMTPAuth = false;                              
		$mail->Username = $user_conf["autoemail"][1];                 
		$mail->Password = $user_conf["autoemail_password"][1];                         
		//$mail->SMTPSecure = 'None';   
		$mail->SMTPSecure = false;                         
		$mail->Port = 25;                                   
		
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($user_conf["autoemail"][1], $language["automail_order_title"][1]);
		
		$mail->Body = "Šifra proizvoda: ".$row['code']." <br />";
		$mail->Body .= "Naziv proizvoda: ".$row['name']." <br />";
		$mail->Body .= "Tražena cena: ".$_POST['price']." <br />";
		$mail->Body .= "Email: ".$_POST['email']." <br />";
		
		
		$mail->addAddress($language["asking_price_email"][1]);    
		$mail->Subject = $language["asking_price_email_title"][1];
		
		if($mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			//$_SESSION['error_notifications'][0]='Poruka nije poslata';
			$response = 1;
			$msg = $language["asking_price_text_success"][1]; 
		} else {
			//echo 'Message has been sent';
			//$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
			$response = 0;
			$msg = $language["asking_price_text_fail"][1];
		}
		
		
		return array($response, $msg);
	}
	public static function transliterate($source) {
	//static $cyr = array();
   	//static $cyr = ['џ','а', 'б', 'в', 'г', 'д', 'ђ', 'е','ж','з','и','ј','к','л','љ', 'м','н','њ', 'о','п','р','с','т','ћ','у','ф','х','ц','ч', 'ш' , 'Џ', 'А', 'Б', 'В', 'Г', 'Д', 'Ђ', 'Е', 'Ж', 'З', 'И', 'Ј', 'К', 'Л', 'Љ',  'М', 'Н', 'Њ',  'О', 'П', 'Р', 'С', 'Т', 'Ћ', 'У', 'Ф', 'Х', 'Ц', 'Ч',   'Ш'];
   	//static $lat = ['dž','a', 'b', 'v', 'g', 'd', 'đ', 'e','ž','z','i','j','k','l','lj','m','n','nj','o','p','r','s','t','ć','u','f','h','c','č','š' , 'DŽ','A', 'B', 'V', 'G', 'D', 'Đ', 'E', 'Ž', 'Z', 'I', 'J', 'K', 'L', 'LJ', 'M', 'N', 'NJ', 'O', 'P', 'R', 'S', 'T', 'Ć', 'U', 'F', 'H', 'C', 'Č',  'Š'];

   	//static $cyrcorrected = ['џ','Џ',];
   	//static $cyrcorrection = ['дз','Дз'];
   		return str_replace($cyrcorrection,$cyrcorrected,str_replace( $lat,$cyr, $source));
	}

	public static function setCurrency(){
		global $system_conf;
		
		
			if(isset($_COOKIE["currencyid"]) && $_COOKIE["currencyid"] != NULL){
				$_SESSION['currencyid'] = $_COOKIE["currencyid"];
				$_SESSION['currencycode'] = $_COOKIE["currencycode"];
				$_SESSION['currencyvalue'] = $_COOKIE["currencyvalue"]; 
			}	
			else{
				$defaultLang=self::getDefaultCurrency();
				
				$_SESSION["currencyid"] = $defaultLang[0]['id'];
				$_SESSION["currencycode"] = $defaultLang[0]['code'];
				$_SESSION["currencyvalue"] = $defaultLang[0]['mainvalue'];
				setcookie("currencyid", $defaultLang[0]['id']);
				setcookie("currencycode", $defaultLang[0]['code']);	
				setcookie("currencyvalue", $defaultLang[0]['mainvalue']);	
			}
		
	}



	public static function getDefaultCurrency(){
		global $system_conf;
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$mysqli->set_charset("utf8");
			$defaultlang=array();
			$query = "SELECT * FROM currency WHERE `primary` = 'y'";
			if ($res = $mysqli->query($query)) {
				if ($res->num_rows > 0) {
					$row = $res->fetch_assoc();
					array_push($defaultlang,array('id'=>$row['id'],'code'=>$row['code'],'name'=>$row['name'],'mainvalue'=>$row['mainvalue']));
				}
			}
		
			return $defaultlang;
	}

	public static function resetCurrency(){
		global $system_conf;
		
		
			$defaultCurrency=self::getDefaultCurrency();
                
            $_SESSION["currencyid"] = $defaultCurrency[0]['id'];
            $_SESSION["currencycode"] = $defaultCurrency[0]['code'];
            $_SESSION["currencyvalue"] = $defaultCurrency[0]['mainvalue'];
            setcookie("currencyid", $defaultCurrency[0]['id']);
            setcookie("currencycode", $defaultCurrency[0]['code']); 
            setcookie("currencyvalue", $defaultCurrency[0]['mainvalue']);
		
	}

	public static function getCurrencyCode($currencyid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$query = "SELECT * FROM currency WHERE id = ".$currencyid;
		if ($res = $mysqli->query($query)) {
			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();
				return $row['code'];
			}
		}
		
	}

	public static function getCurrencyValue($currencyid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$query = "SELECT * FROM currency WHERE id = ".$currencyid;
		if ($res = $mysqli->query($query)) {
			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();
				return $row['mainvalue'];
			}
		}
		
	}


	public static function setLang(){
		global $system_conf;
		
		
			if(isset($_COOKIE["lang"]) && $_COOKIE["lang"] != NULL){
				$_SESSION['langid'] = $_COOKIE["lang"];
				$_SESSION['langcode'] = $_COOKIE["langcode"]; 
			}	
			else{
				$defaultLang=self::getDefaultLang();
				
				$_SESSION["langid"] = $defaultLang[0]['id'];
				$_SESSION["langcode"] = $defaultLang[0]['code'];
				setcookie("lang", $defaultLang[0]['id']);
				setcookie("langcode", $defaultLang[0]['code']);	
			}
		
	}

	public static function getDefaultLang(){
		global $system_conf;
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$mysqli->set_charset("utf8");
			$defaultlang=array();
			$query = "SELECT * FROM languages WHERE `default` = 'y'";
			if ($res = $mysqli->query($query)) {
				if ($res->num_rows > 0) {
					$row = $res->fetch_assoc();
					array_push($defaultlang,array('id'=>$row['id'],'code'=>$row['code'],'shortname'=>$row['shortname']));
				}
			}
		
			return $defaultlang;
	}
	public static function getLangShortname(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$query = "SELECT * FROM languages WHERE id = ".$_SESSION['langid'];
		if ($res = $mysqli->query($query)) {
			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();
				return $row['shortname'];
			}
		}
		
	}
	public static function getLangCode($langid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$query = "SELECT * FROM languages WHERE id = ".$langid;
		if ($res = $mysqli->query($query)) {
			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();
				return $row['code'];
			}
		}
		
	}
	public static function setShoptype(){
		if(isset($_SESSION['shoptype']) && $_SESSION['shoptype'] != ''){

		}
		else{
			$_SESSION['shoptype'] = 'b2c';
		}
	}
	
	public static function paging($currentpage, $totalitems, $itemperpage){
		$item = array();
		$item[0] = "";	// <<
		$item[1] = "";	//	<
		$item[2] = "";	//	-2
		$item[3] = "";	//	-1
		$item[4] = "";	//	0
		$item[5] = "";	//	+1
		$item[6] = "";	//	+2
		$item[7] = "";	//	>
		$item[8] = "";	//	>>
		
		$totalpages = ceil($totalitems/$itemperpage);
				
		if($currentpage > 1){
			$item[0] = 1;
			$item[1] = $currentpage-1;
			$item[3] = $currentpage-1;	
		}
		
		if($currentpage > 2){
			$item[2] = $currentpage-2;
		}
		$item[4] = $currentpage;
		
		if($currentpage < $totalpages){
			$item[5] = $currentpage+1;
			$item[7] = $currentpage+1;
			$item[8] = $totalpages;
		}
		if(($currentpage+1) < $totalpages){
			$item[6] = $currentpage+2;
		}
		return $item;
	}
	public static function sendEmailOrder($to, $from, $subject, $messagedata,$pdfheader,$pdfdata,$pdffooter){
		global $user_conf;
		
		require_once('cdn/phpmailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		
		/*$mail->isSMTP();                                   
		$mail->Host = $user_conf["autoemail_host"][1];  
		$mail->SMTPAuth = true;                              
		$mail->Username = $user_conf["autoemail"][1];                 
		$mail->Password = $user_conf["autoemail_password"][1];                         
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                   
		*/
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($from, $user_conf["automail_order_title"][1]);
		$mail->Body = $messagedata;

		require_once("cdn/html2pdf/mpdf.php");
		//ADD ATACHEMNT
		$mpdf=new mPDF('utf-8','A4','','Arial',6,6,40,10,3,3,'P'); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;	
		$stylesheet = file_get_contents('cdn/html2pdf/mpdfstyletables.css');
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->SetHTMLHeader($pdfheader);
		$mpdf->SetHTMLFooter($pdffooter);
		$mpdf->WriteHTML($pdfdata,2);
		$file = $mpdf->Output('cdn/html2pdf/mpdf.pdf','S');	
		$mail->AddStringAttachment($file, 'Porudzbina.pdf', 'base64', 'application/pdf');
		//ADD ATACHEMNT END

		$mail2 = clone $mail;
		
		$mail->addAddress($to['client']);    
		$mail->Subject = $subject['client'];
		
		if(!isset($_SESSION['error_notifications'])) $_SESSION['error_notifications']=array();
		if(!isset($_SESSION['success_notifications'])) $_SESSION['success_notifications']=array();
		

		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			$_SESSION['error_notifications'][0]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent';
			$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
		}
		






		$mail2->addAddress($to['seller']);    
		$mail2->Subject = $subject['seller'];

		if(!$mail2->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail2->ErrorInfo;
			$_SESSION['error_notifications'][1]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent 2';
			$_SESSION['success_notifications'][1]='Poruka je uspešno poslata';
		}

	}
	public static function sendEmailOrderRequest($to, $from, $subject, $messagedata){
		global $user_conf;
		
		require_once('cdn/phpmailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		
		/*$mail->isSMTP();                                   
		$mail->Host = $user_conf["autoemail_host"][1];  
		$mail->SMTPAuth = true;                              
		$mail->Username = $user_conf["autoemail"][1];                 
		$mail->Password = $user_conf["autoemail_password"][1];                         
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                   
		*/
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($from, $user_conf["automail_order_title"][1]);
		$mail->Body = $messagedata;

		//ADD ATACHEMNT END

		$mail2 = clone $mail;
		
		$mail->addAddress($to['client']);    
		$mail->Subject = $subject['client'];
		
		if(!isset($_SESSION['error_notifications'])) $_SESSION['error_notifications']=array();
		if(!isset($_SESSION['success_notifications'])) $_SESSION['success_notifications']=array();
		

		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			$_SESSION['error_notifications'][0]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent';
			$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
		}
		
		$mail2->addAddress($to['seller']);    
		$mail2->Subject = $subject['seller'];

		if(!$mail2->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail2->ErrorInfo;
			$_SESSION['error_notifications'][1]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent 2';
			$_SESSION['success_notifications'][1]='Poruka je uspešno poslata';
		}

	}
	public static function sendEmailOffer($to, $from, $subject, $messagedata,$pdfheader,$pdfdata,$pdffooter){
		global $user_conf;
		
		require_once('cdn/phpmailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		
		/*$mail->isSMTP();                                   
		$mail->Host = $user_conf["autoemail_host"][1];  
		$mail->SMTPAuth = true;                              
		$mail->Username = $user_conf["autoemail"][1];                 
		$mail->Password = $user_conf["autoemail_password"][1];                         
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                   
		*/
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($from, $user_conf["automail_offer_title"][1]);
		$mail->Body = $messagedata;

		require_once("cdn/html2pdf/mpdf.php");
		//ADD ATACHEMNT
		$mpdf=new mPDF('utf-8','A4','','Arial',6,6,40,10,3,3,'P'); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;	
		$stylesheet = file_get_contents('cdn/html2pdf/mpdfstyletables.css');
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->SetHTMLHeader($pdfheader);
		$mpdf->SetHTMLFooter($pdffooter);
		$mpdf->WriteHTML($pdfdata,2);
		$file = $mpdf->Output('cdn/html2pdf/mpdf.pdf','S');	
		$mail->AddStringAttachment($file, 'Ponuda.pdf', 'base64', 'application/pdf');
		//ADD ATACHEMNT END

		$mail2 = clone $mail;
		
		$mail->addAddress($to['client']);    
		$mail->Subject = $subject['client'];
		
		if(!isset($_SESSION['error_notifications'])) $_SESSION['error_notifications']=array();
		if(!isset($_SESSION['success_notifications'])) $_SESSION['success_notifications']=array();
		

		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			$_SESSION['error_notifications'][0]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent';
			$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
		}
		






		$mail2->addAddress($to['seller']);    
		$mail2->Subject = $subject['seller'];

		if(!$mail2->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail2->ErrorInfo;
			$_SESSION['error_notifications'][1]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent 2';
			$_SESSION['success_notifications'][1]='Poruka je uspešno poslata';
		}

	}
	public static function sendEmailOfferRequest($to, $from, $subject, $messagedata){
		global $user_conf;
		
		require_once('cdn/phpmailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		
		/*$mail->isSMTP();                                   
		$mail->Host = $user_conf["autoemail_host"][1];  
		$mail->SMTPAuth = true;                              
		$mail->Username = $user_conf["autoemail"][1];                 
		$mail->Password = $user_conf["autoemail_password"][1];                         
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                   
		*/
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($from, $user_conf["automail_offer_title"][1]);
		$mail->Body = $messagedata;

		//ADD ATACHEMNT END

		$mail2 = clone $mail;
		
		$mail->addAddress($to['client']);    
		$mail->Subject = $subject['client'];
		
		if(!isset($_SESSION['error_notifications'])) $_SESSION['error_notifications']=array();
		if(!isset($_SESSION['success_notifications'])) $_SESSION['success_notifications']=array();
		

		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			$_SESSION['error_notifications'][0]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent';
			$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
		}
		
		$mail2->addAddress($to['seller']);    
		$mail2->Subject = $subject['seller'];

		if(!$mail2->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail2->ErrorInfo;
			$_SESSION['error_notifications'][1]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent 2';
			$_SESSION['success_notifications'][1]='Poruka je uspešno poslata';
		}

	}
	public static function sendEmailReservation($to, $from, $subject, $messagedata){
		global $user_conf;
		
		require_once('cdn/phpmailer/PHPMailerAutoload.php');

		$mail = new PHPMailer;
		
		$mail->isSMTP();                                   
		$mail->Host = $user_conf["autoemail_host"][1];  
		$mail->SMTPAuth = true;                              
		$mail->Username = $user_conf["autoemail"][1];                 
		$mail->Password = $user_conf["autoemail_password"][1];                         
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                   
		
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		
		$mail->setFrom($from, $user_conf["automail_order_title"][1]);
		
		$mail->Body    = "<style>
					body { font-family: 'Arial'; font-size:11px !important;	line-height:12px;  }
p { 	text-align: justify; margin-bottom: 0; margin-top:0pt;  }

p.headtext{
	font-size:12px;
	line-height:8px;
	font-weight:bold;	
}
.tableHeder th{
	padding:5px 2px;
	color:#000 !important;	
}
table { line-height: 1.2; 
	margin-top: 2pt; margin-bottom: 5pt;
	border-collapse: collapse; 
	width:100%;
	border-bottom: none;
	border-left: none;
	border-right: none;
	}

thead {	font-weight: bold; vertical-align: bottom; }
tfoot {	font-weight: bold; vertical-align: top; }
thead td { font-weight: bold; }
tfoot td { font-weight: bold; }

.headerrow td, .headerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
.footerrow td, .footerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }

tr{
	border-bottom:1px solid #333;
	border-left:1px solid #333;
	border-right:1px solid #333;	
}
th {	font-weight: bold; 
	vertical-align: top; 
	padding-left: 2mm; 
	padding-right: 2mm; 
	padding-top: 0.5mm; 
	padding-bottom: 0.5mm; 
	text-align:center;
 }

td {	padding-left: 1mm; 
	vertical-align: middle; 
	padding-right: 1mm; 
	padding-top: 1mm; 
	padding-bottom: 1mm;
	text-align:right;
	font-family: 'Arial'; font-size:11px !important;	line-height:12px;
	border-left:1px solid #333 !important;
	border-right:1px solid #333 !important;
 }

th p { margin:0pt;  }
td p { margin:0pt;  }

table.widecells td {
	padding-left: 5mm;
	padding-right: 5mm;
}
table.tallcells td {
	padding-top: 3mm;
	padding-bottom: 3mm; 
}

hr {	width: 70%; height: 1px; 
	text-align: center; color: #999999; 
	margin-top: 8pt; margin-bottom: 8pt; }

a {	color: #000066; font-style: normal; text-decoration: underline; 
	font-weight: normal; }

pre { font-family: 'DejaVu Sans Mono'; font-size: 9pt; margin-top: 5pt; margin-bottom: 5pt; }

h1 {	font-weight: normal; font-size: 22pt; color: #000; 
	font-family: ''; margin-top: 0; margin-bottom: 0; 
	 
	text-align: center ; page-break-after:avoid; }
	
h2 {	font-weight: bold; font-size: 12pt; color: #000000; 
	font-family: 'Arial'; margin-top: 20px; margin-bottom: 20px; border: none; 
	text-align: center;  text-transform:uppercase; page-break-after:avoid; 
	padding-top:10px; padding-bottom:10px; background-color:#FFC4C5;}
	
h3 {	font-weight: normal; font-size: 26pt; color: #000000; 
	font-family: 'DejaVu Sans Condensed'; margin-top: 0pt; margin-bottom: 6pt; 
	border-top: 0; border-bottom: 0; 
	text-align: ; page-break-after:avoid; }



.bottomMargin15{ margin-bottom:15px; }

.half{ width:50%; float:left; font-size:12px !important; line-height:14px; }
.half p {  }
.twothirds{ width:66%; float:left; font-size:12px; }
.onethirds{ width:33%; float:left; font-size:12px; }
.hrline{ width:100%; margin:20px 0; height:1px; }

.headerStyle{ padding-top:15px;}
.headerStyle p{line-height:16px; font-weight:bold;}

tr:nth-child(even){ background-color:#D2D3FF; }
tr.nobackground{ background-color:transparent; }
.summaryRow td { font-weight:bold; font-size:12px; border:none !important;}
.summaryRow { border:none !important;}
				</style>".$messagedata;
		
		require_once("cdn/html2pdf/mpdf.php");
		$mpdf=new mPDF('utf-8','A4','','Arial',6,6,40,10,3,3,'P'); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;	
		
		$stylesheet = file_get_contents('cdn/html2pdf/mpdfstyletables.css');
		$mpdf->WriteHTML($stylesheet,1);
		
		$mpdf->SetHTMLHeader('<div class="onethirds">
									<img style="margin:30px 15px 10px 0; max-height:80px; width:100%;" src="'.$user_conf["memorandum_logo"][1].'" />
								</div>
								<div class="twothirds headerStyle">
									<p>'.$user_conf["memorandum_line1"][1].'</p>
									<p>'.$user_conf["memorandum_line2"][1].'</p>
									<p>'.$user_conf["memorandum_line3"][1].'</p>
									<p>'.$user_conf["memorandum_line4"][1].'</p>
									<p>'.$user_conf["memorandum_line5"][1].'</p>
								</div>');
		$mpdf->SetHTMLFooter('<p style="width:100%; text-align:center;">{PAGENO}</p>');
		$mpdf->WriteHTML($messagedata,2);
		$file = $mpdf->Output('cdn/html2pdf/mpdf.pdf','S');
			
		$mail->AddStringAttachment($file, 'Porudzbina.pdf', 'base64', 'application/pdf');	
		
		$mail2 = clone $mail;
		
		$mail->addAddress($to['client']);    
		$mail->Subject = $subject['client'];
		
		if(!isset($_SESSION['error_notifications'])) $_SESSION['error_notifications']=array();
		if(!isset($_SESSION['success_notifications'])) $_SESSION['success_notifications']=array();
		

		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			$_SESSION['error_notifications'][0]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent';
			$_SESSION['success_notifications'][0]='Poruka je uspešno poslata';
		}
		
		$mail2->addAddress($to['seller']);    
		$mail2->Subject = $subject['seller'];

		if(!$mail2->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail2->ErrorInfo;
			$_SESSION['error_notifications'][1]='Poruka nije poslata';
		} else {
			//echo 'Message has been sent 2';
			$_SESSION['success_notifications'][1]='Poruka je uspešno poslata';
		}
				
	}
	public static function sendEmail($to, $from, $subject, $messagedata, $type=''){
		$body = '';
		switch ($type){
			case 'resPass':
				$body = EmailTemplate::restartPass($messagedata);
				if($subject == ''){
					$subject = 'Promena lozinke';
				}
				break;
			case 'newPass':
				$body = EmailTemplate::newPass($messagedata);
				if($subject == ''){
					$subject = 'Nova lozinka';
				}
				break;
			case 'potvrdaEmaila':
				$body = EmailTemplate::potvrdaEmaila($messagedata);
				if($subject == ''){
					$subject = 'Registracija: potvrda email-a';
				}
				break;
			case 'contact':
				$body = EmailTemplate::contact($messagedata);
				if($subject == ''){
					$subject = 'Prazna poruka';
				}
			break;
			default:
				$body = $messagedata;

		}

		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        <title>E-mail</title>
                    </head>
                    <body>' . $body . '</body>
                     </html>';

		$headers = 'MIME-Version: 1.0' . "\n";
		$headers .= "Content-Type: text/html; charset=UTF-8" . "\n";
		$headers .= "From: ".$from;

		if(mail($to, $subject, $message, $headers)){
			return true;
		}
		else{
			return false;
		}

	}
	public static function get_default_lang_id()
	{
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$query = "select id from `languages` where `default` = 'y'";
		if ($res = $mysqli->query($query)) {
			if ($res->num_rows > 0) {
				$id = $res->fetch_assoc();
				$id = $id['id'];
				return $id;
			} else {
				return '1';
			}
		}
	}
	public static function addToWatched($prodid){
		if (isset($_SESSION['watched'])) {
			if(is_array($_SESSION['watched']) && in_array($prodid, $_SESSION['watched'])){
				//ako je gledan staviti ga na pocetku liste
				$key = array_search($prodid, $_SESSION['watched']);
				unset($_SESSION['watched'][$key]);
				array_unshift($_SESSION['watched'], $prodid);
			}
			elseif(is_array($_SESSION['watched'])){
				array_unshift($_SESSION['watched'], $prodid);
			}
			else{
				$_SESSION['watched'] = array();
				array_unshift($_SESSION['watched'], $prodid);
			}
		}
		else{
			$_SESSION['watched'] = array();
			array_unshift($_SESSION['watched'], $prodid);
			var_dump($_SESSION['watched']);
		}
		return 1;
	}
	public static function getWatched(){
		return $_SESSION['watched'];//treba napraviti da vraca sa podacima
	}
	public static function getItemsFromShopcart(){
		$shopproducts = array();
		if(isset($_SESSION['shopcart']) && is_array($_SESSION['shopcart'])){
			foreach ($_SESSION['shopcart'] as $product) {
				$product['attr'] = json_decode($product['attr'], true);
				$attr = array();
				if(is_array($product['attr'])){
					foreach ($product['attr'] as $at) {
						array_push($attr, array('attrid' => $at[0], 'attrvalid' => $at[1], 'attrname' => GlobalHelper::getAttrName($at[0]), 'attrvalname' => GlobalHelper::getAttrValName($at[1])));
					}
				}
				$product['attr'] = $attr;
				array_push($shopproducts, $product);
			}

		}
		return $shopproducts;
	}
	public static function getAttrName($attrid, $def_lang = false){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$langid=$_SESSION['langid'];
		if($def_lang){
			$langid = GlobalHelper::get_default_lang_id();
		}
		if($def_lang == ''){
			if(isset($_SESSION['langid'])){
				$langid = $_SESSION['langid'];
			}
			else{
				$langid = GlobalHelper::get_default_lang_id();
			}
		}

		$query = "select name from `attr_tr` where `attrid`='".$attrid."' and `langid` = ".$langid;
		//echo $query;
		if($res = $mysqli->query($query)){
			if($res->num_rows>0){
				$attr_name = $res->fetch_assoc();
				$attr_name = $attr_name['name'];
				return $attr_name;
			}
			else{
				$def_lang_id = GlobalHelper::get_default_lang_id();
				if($def_lang_id == $langid){
					$query = "SELECT name FROM attr where id=".$attrid;
					$res = $mysqli->query($query);
					if($res->num_rows > 0){
						$row = $res->fetch_assoc();
						return ($row['name']);
					}
					return '';
				}
				else{
					$query = "select name from `attr_tr` where `attrid`='".$attrid."' and `langid` = ".$def_lang_id;
					if($res = $mysqli->query($query)){
						if($res->num_rows > 0){
							$attr_name = $res->fetch_assoc();
							$attr_name = $attr_name['name'];
							return $attr_name;
						}
						else{
							$query = "SELECT name FROM attr where id=".$attrid;
							$res = $mysqli->query($query);
							if($res->num_rows > 0){
								$row = $res->fetch_assoc();
								return ($row['name']);
							}
							return '';
						}
					}
				}
			}
		}
		else {
			return -1;
		}

	}

	public static function getAttrValImage($attrval_id){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		$q = "(SELECT type, content FROM attrval_file WHERE attrvalid =".$attrval_id." AND type = 'mi')
				UNION
			  (SELECT type, content FROM attrval_file WHERE attrvalid =".$attrval_id." AND type = 'mc')";
		
		$resf = $mysqli->query($q);
		$mi = '';
		$mc = '';
		while($rowf = $resf->fetch_assoc()){
			
			if($rowf['type'] == 'mi') $mi = $rowf['content'];
			if($rowf['type'] == 'mc') $mc = $rowf['content'];	
		}
		return array('mi'=>$mi, 'mc'=>$mc);
	}
	/**
	 * @param $attrval_id
	 * @param bool|false $def_lang
	 * @return array|string
	 */
	public static function getAttrValName($attrval_id, $def_lang = false){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$langid=$_SESSION['langid'];
		if($def_lang){
			$langid = GlobalHelper::get_default_lang_id();
		}
		if($def_lang == ''){
			if(isset($_SESSION['langid'])){
				$langid = $_SESSION['langid'];
			}
			else{
				$langid = GlobalHelper::get_default_lang_id();
			}
		}

		$query = "SELECT value FROM `attrval_tr` where `attrvalid` = ".$attrval_id." and `langid` = ".$langid;
//    echo $query;
		if($res = $mysqli->query($query)){
			if($res->num_rows>0){
				$attrval_name = $res->fetch_assoc();
				$attrval_name = $attrval_name['value'];
				return $attrval_name;
			}
			else{
				$def_lang_id = GlobalHelper::get_default_lang_id();
				if($def_lang_id == $langid){
					$query = "SELECT `value` FROM attrval where id = ".$attrval_id;
					$res = $mysqli->query($query);
					if($res->num_rows > 0){
						$row = $res->fetch_assoc();
						return $row['value'];
					}

					return '';
				}
				else{
					$query = "SELECT value FROM `attrval_tr` where `attrvalid` = ".$attrval_id." and `langid` = ".$def_lang_id;
					if($res = $mysqli->query($query)){
						if($res->num_rows>0){
							$attrval_name = $res->fetch_assoc();
							$attrval_name = $attrval_name['value'];
							return $attrval_name;
						}
						else{
							$query = "SELECT `value` FROM attrval where id = ".$attrval_id;
							$res = $mysqli->query($query);
							if($res->num_rows > 0){
								$row = $res->fetch_assoc();
								return $row['value'];
							}
							return '';
						}
					}
				}
			}
		}
	}
	
	public static function getDocumentitemAttr(){
			
	}
	
	public static function getCurrentUserValidCategorys(){
		// vraca array svih kategorija koje su dozvoljene trenutnom korisniku korisniku
		
		$type = 'b2c'; 
		
		if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == "logged" && $_SESSION['shoptype'] == "b2b"){
			$type = 'b2b'; 
		}
		
		$data = array();
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT id FROM category WHERE ".$type."visible = 1";
		$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc())
				{
					array_push($data, $row['id']);
				}
			}	
		return $data;
	}

	/**
	 * @param1 $imgpath
	 * @param2 string $size (thumb, small, medium, big, original) optional default = 'thumb'
	 * @return string
     */
	public static function getImage($imgpath, $size = 'thumb'){
		
		$imgpath = rawurldecode($imgpath);
		
		if(preg_match("/[a-zA-Z0-9]*\.[a-z]*/", $imgpath) == 1)
		{
			$ds = '/';
			if($size == 'thumb'){
				$imga = explode($ds, $imgpath);
				$c = count($imga);
				$imga[$c] = $imga[$c-1];
				$imga[$c-1] = $size;
				$imga = implode($ds, $imga);
				if(file_exists($imga)){
					return $imga;
				}
				else{
					$size = 'small';
				}
			}
			if($size == 'small'){
				$imga = explode($ds, $imgpath);
				$c = count($imga);
				$imga[$c] = $imga[$c-1];
				$imga[$c-1] = $size;
				$imga = implode($ds, $imga);
				if(file_exists($imga)){
					return $imga;
				}
				else{
					$size = 'medium';
				}
			}
			if($size == 'medium'){
				$imga = explode($ds, $imgpath);
				$c = count($imga);
				$imga[$c] = $imga[$c-1];
				$imga[$c-1] = $size;
				$imga = implode($ds, $imga);
				if(file_exists($imga)){
					return $imga;
				}
				else{
					$size = 'big';
				}
			}
			if($size == 'big'){
				$imga = explode($ds, $imgpath);
				$c = count($imga);
				$imga[$c] = $imga[$c-1];
				$imga[$c-1] = $size;
				$imga = implode($ds, $imga);
				if(file_exists($imga)){
					return $imga;
				}
				else{
					$size = 'original';
				}
			}
			
			if($size == 'original'){
				$imga = $imgpath;
				if(file_exists($imga)){
					return $imga;
				}
				else{
					global $user_conf, $system_conf, $theme_conf;
					return $system_conf["theme_path"][1].$theme_conf['no_img'][1];
				}
			}
		}
		else{
			global $user_conf, $system_conf, $theme_conf;
			return $system_conf["theme_path"][1].$theme_conf['no_img'][1];
		}
	}

	
	public static function stringToUrls($path, $glue = DIRECTORY_SEPARATOR, $removeindex = array(), $pathprefix = ''){
		/**	breadcrumbs
		 * converts path/to/some/thing
		
		to
		
		array(array('name'=>path, 'url'=>path),
			array('name'=>to, 'url'=>path/to),
			array('name'=>some, 'url'=>path/to/some),
			array('name'=>thing, 'url'=>path/to/some/thing))
		
		*/
		
		$data = array();
		
		$tmp = explode($glue, $path);
		
		foreach($removeindex as $k=>$v){
			unset($tmp[$v]);	
		}
		
		$url = $pathprefix."/";
		array_push($data, array('name'=>$pathprefix, 'url'=>$url));
		
		foreach($tmp as $k=>$v){
			$url .= $v;
			array_push($data, array('name'=>$v, 'url'=>$url));
			$url .= "/";
		}
		
		return $data;
	}
	public static function getProductIdFromCommand($c){
		$prodid = explode('-', end($c));
		return $prodid[0];
	}
	public static function isDBPage($command){

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$q="SELECT p.*, ptr.value as valuetr, ptr.showname as shownametr FROM pages p 
			LEFT JOIN pages_tr ptr ON p.id = ptr.pageid
			WHERE p.name = '".strtolower(rawurldecode($command[0]))."' AND status = 'v' AND (ptr.langid=".$_SESSION['langid']." OR ptr.langid IS NULL)";
		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			return true;
		}
		return false;
	}
	public static function isProduct($command){
		if($command[0]!='foto_gallery' && $command[0]!='video_gallery'){
			$prodid = explode('-', end($command));
		$prodid = $prodid[0];
		if(is_numeric($prodid)){
			if(self::hadProdWithId($prodid)){
				return true;
			}
		}
			
		}
		
		return false;
	}
	public static function hadProdWithId($prodid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select id from product where id = ".$mysqli->real_escape_string($prodid);
		if($res = $mysqli->query($query)){
			if($res->num_rows > 0){
				return true;
			}
		}
		return false;
	}
	
	public static function isNews($command){

		$newsid = explode('-', end($command));
		$newsid = $newsid[0];
		if(is_numeric($newsid) && $command[0]=='news'){
			if(self::hadNewsWithId($newsid)){
				return true;
			}
		}
		return false;
	}
	public static function hadNewsWithId($newsid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select id from news where id = ".$mysqli->real_escape_string($newsid);
		if($res = $mysqli->query($query)){
			if($res->num_rows > 0){
				return true;
			}
		}
		return false;
	}
	
	public static function addToCompare($prodid){
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		global $user_conf, $system_conf, $theme_conf;
		
		if(!isset($_SESSION['compare'])){
			$_SESSION['compare'] = array();
		}
		$img = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
		
		$match = false;
		foreach($_SESSION['compare'] as $k=>$v){
			if($v[0] == $prodid){
				$match = true;
				break;	
			}
		}
		
		if(!$match){
			$query = "SELECT content FROM product_file WHERE productid = ".$prodid." AND type = 'img' ORDER BY sort ASC LIMIT 1";
			$res = $mysqli->query($query);
			if($res->num_rows > 0){
				$row = $res->fetch_assoc();
				$img = $row['content'];
			}
			if(array_push($_SESSION['compare'], array($prodid, $img)) > 0){
				return true;
			}
			else{
				return false;	
			}
		}
		else{
			return true;	
		}
	}

	public static function removeFromCompare($proid){
		$j = '';
		foreach($_SESSION['compare'] as $key=>$val){
			if(intval($val[0]) == $proid){
				$j = $key;
				break;	
			}
		}
		unset($_SESSION['compare'][$j]);
			return $j;
	}

	public static function removeAllFromCompare(){
		unset($_SESSION['compare']);
			return 1;
	}

	public static function clearCompareProducts(){
		if(isset($_SESSION['compare']) && !empty($_SESSION['compare'])){
			unset($_SESSION['compare']);
			return 1;
		}
		return 0;

	}

	public static function getCompareProdInfo(){
		$comparedata = array();
		if(!isset($_SESSION['compare'])){
			return $comparedata;
		}
		else{
			$compareprods = $_SESSION['compare'];
			foreach ($compareprods as $compareprod) {
				
				$prod = new Product($compareprod[0]);
				array_push($comparedata, $prod);
			}
			return $comparedata;
		}
	}

	public static function addToWishList($prodid){
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		global $user_conf, $system_conf, $theme_conf;
		
		if(!isset($_SESSION['wishlist'])){
			$_SESSION['wishlist'] = array();
		}
		//$img = $system_conf["theme_path"][1].$theme_conf['no_img'][1];
		
		$match = false;
		foreach($_SESSION['wishlist'] as $k=>$v){
			if($v[0] == $prodid){
				$match = true;
				break;	
			}
		}
		
		if(!$match){
			if(array_push($_SESSION['wishlist'], array($prodid)) > 0){
				
				return true;
			}
			else{
				
				return false;	
			}
		}
		else{
			
			return true;	
		}
	}

	
	public static function removeFromWishList($proid){
		$j = '';
		foreach($_SESSION['wishlist'] as $key=>$val){
			if(intval($val[0]) == $proid){
				$j = $key;
				break;	
			}
		}
		unset($_SESSION['wishlist'][$j]);
		
		
		return $j;
	}


	public static function save_user_wishlist(){
		if(isset($_SESSION["id"]) && $_SESSION["id"]>0){
			$db = Database::getInstance();
        	$mysqli = $db->getConnection();
        	$mysqli->set_charset("utf8");
			
				
			$sqlDeleteAllUserWishlist = "DELETE FROM user_wishlist WHERE userid=".$_SESSION["id"];
			//echo $sqlDeleteAllUserWishlist;
			$mysqli->query($sqlDeleteAllUserWishlist);
			if(isset($_SESSION['wishlist']) && count($_SESSION['wishlist'])>0){
				$i=0;
				foreach($_SESSION['wishlist'] as $wproduct){
					$i++;
					$sqlInsertUserWishlistProduct = "INSERT INTO user_wishlist (`userid`,`productid`,`sort`) VALUES (".$_SESSION["id"].",".$wproduct[0].",".$i.")";
					//echo $sqlInsertUserWishlistProduct;
					$mysqli->query($sqlInsertUserWishlistProduct);
				}	
			}
		}
	}
	public static function load_user_wishlist(){

		if(isset($_SESSION["id"]) && $_SESSION["id"]>0){
			$db = Database::getInstance();
        	$mysqli = $db->getConnection();
        	$mysqli->set_charset("utf8");
			if(isset($_SESSION["id"]))
			{
				$sqlAllUserWishlist = "SELECT uw.* FROM user_wishlist AS uw LEFT JOIN product AS p ON uw.productid=p.id WHERE p.active='y' AND uw.userid=".$_SESSION["id"];
				$result = $mysqli->query($sqlAllUserWishlist);
				if($result->num_rows > 0){
					if(isset($_SESSION['wishlist']) && count($_SESSION['wishlist'])>0){
						unset($_SESSION['wishlist']);
						$_SESSION['wishlist']=array();
						while($row = $result->fetch_assoc()){
							array_push($_SESSION['wishlist'], array($row["productid"]));
						}
					} else{
						$_SESSION['wishlist']=array();
						while($row = $result->fetch_assoc()){
							array_push($_SESSION['wishlist'], array($row["productid"]));
						}
	
					}
				}
			}

		}
	}

















	public static function clearWishListProducts(){
		if(isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])){
			unset($_SESSION['wishlist']);
			return 1;
		}
		return 0;

	}

	
	public static function getWishListProdInfo($page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "code",  $action = false, $minprice = '', $maxprice = ''){
		$wishlistdata = array();
		if(!isset($_SESSION['wishlist'])){
			return $wishlistdata;
		}
		else{
			$wishlistprods = array();
			//$wishlistprods = $_SESSION['wishlist'];
			foreach ($_SESSION['wishlist'] as $wishlistprod) {
				//var_dump($wishlistprod[0]);
				array_push($wishlistprods, $wishlistprod[0]);
			}
			//var_dump($wishlistprods);
			$wishlistdata=Category::getCategoryProductDetail($wishlistprods,$page, $itemsperpage,$search,$sort, $sortby, $action, $minprice, $maxprice, 1);
			/*foreach ($wishlistprods as $wishlistprod) {
				
				$prod = new Product($wishlistprod[0]);
				array_push($wishlistdata, $prod);
			}*/
			//var_dump($wishlistdata);
			return $wishlistdata;
		}
	}
	public static function lastSeen($prodid = 0){
		if($prodid == 0){
			if(isset($_SESSION['lastSeen'])) {
				return $_SESSION['lastSeen'];
			}
			return array();
		}
		else{
			if(!isset($_SESSION['lastSeen'])){
				$ls = array();
				array_push($ls, $prodid);
				$_SESSION['lastSeen'] = $ls;
				return $ls;
			}
			else{
				$ls = $_SESSION['lastSeen'];
				if(is_array($ls) && in_array($prodid, $ls)){//ako je vec gledan
					$key = array_search($prodid, $ls);
					unset($ls[$key]);
					array_unshift($ls, $prodid);
					$_SESSION['lastSeen'] = $ls;
					return $ls;
				}
				else{//ako nije gledan dodati ga u listu
					if(is_array($ls)){
						array_unshift($ls, $prodid);
					}
					else{
						$ls = array();
						array_unshift($ls, $prodid);
					}

					$_SESSION['lastSeen'] = $ls;
					return $ls;
				}
			}
		}

	}
	
	public static function isChildExist($catname, $parentid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		$result = false;
		$q = "SELECT c.id, (SELECT id FROM category".$catsufix." WHERE parentid = c.id LIMIT 1) as child FROM category".CATEGORY_SUFIX." c WHERE c.name like '".rawurldecode($catname[0])."' AND c.parentid = ".$parentid;
		unset($catname[0]);
		$catname = array_values($catname);
		if($res = $mysqli->query($q)){
			$row = $res->fetch_assoc();
			if($res->num_rows > 0){
				if(count($catname) > 0){
					$result = self::isChildExist($catname, $row['id']);	
				}else{
					if($row['child'] == NULL){
						$result = true;
					}
				}
			}
			else{
				if($row['child'] == NULL){
					$result = true;
				}
			}
		}
		return $result;
		
	}
	public static function isCategoryLast($urlpath){
		return self::isChildExist($urlpath, 0);
	}

	public static function isNewsCategoryLast($catname){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "SELECT * FROM newscategory WHERE parentid = (SELECT id FROM newscategory WHERE name like '".$mysqli->real_escape_string(rawurldecode($catname))."')";
		if($res = $mysqli->query($query)){
			if($res->num_rows > 0){
				return false;
			}
			else{
				return true;
			}
		}
	}
	public static function getProductLinkFromProdId($prodid){
//		implode(DIRECTORY_SEPARATOR, $command).DIRECTORY_SEPARATOR.$val->id.'-'.$val->name;
		$catlist =	ShopHelper::getCategoryListFromProduct($prodid);
		//echo "<pre>";
		//var_dump($catlist);
		//echo "</pre>";
		if(isset($catlist[0]['url'])) {
			return $catlist[0]['url'].$prodid.'-'.rawurlencode(str_replace("/", "_",GlobalHelper::getProductNameFromId($prodid)));
		} else {
			return "";
		}
		
	}
	public static function getProductNameFromId($prodid, $def_name=false){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select p.name as name, ptr.name as nametr from product as p
					left join product_tr as ptr on p.id = ptr.productid
					where p.id = ".$prodid." and (langid = ".$_SESSION['langid']." or langid is NULL)";
					//echo $query;
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res ->fetch_assoc();
			if($def_name){
				return $row['name'];
			}
			else{
				if($row['nametr'] != NULL && $row['nametr'] == ''){
					return $row['nametr'];
				}
				else{return $row['name'];}
			}
		}
		return -1;
	}
	
	public static function getProductDataFromId($prodid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select * from product as p where p.id = ".$prodid;
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res ->fetch_assoc();
			return $row;
		}
		return -1;
	}

	public static function getProductDetailFromId($prodid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "SELECT pd.productid, pd.description, pdtr.description AS `descriptiontr`
				    FROM productdetail AS pd LEFT JOIN productdetail_tr AS pdtr ON pd.productid = pdtr.productid 
					WHERE pd.productid = ".$prodid." AND (pdtr.langid = ".$_SESSION['langid']." OR pdtr.langid is NULL)";
		//echo $query;
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res ->fetch_assoc();
			//echo "'".$row['descriptiontr']."'";
			//echo html_entity_decode($row['description'],ENT_COMPAT,'UTF-8');
			$description=strip_tags(html_entity_decode($row['description'],ENT_COMPAT,'UTF-8'));
			if($row['descriptiontr'] != NULL && $row['descriptiontr'] != '' && strlen($row['descriptiontr'])>0 ){
				echo 'jabadabadoo';

					$description=strip_tags(html_entity_decode($row['descriptiontr'],ENT_COMPAT,'UTF-8'));
			}
			
			//echo $description;
			//$row['description']=$description;

			/*$characteristics=$row['characteristics'];
			if($row['characteristicstr'] != NULL && $row['characteristicstr'] == '' && strlen($row['characteristicstr'])>0 ){
					$characteristics=$row['characteristicstr'];
			}
			$row['characteristics']=$characteristics;

			$specification=$row['specification'];
			if($row['specificationtr'] != NULL && $row['specificationtr'] == '' && strlen($row['specificationtr'])>0 ){
					$specification=$row['specificationtr'];
			}
			$row['specification']=$specification;
			
			$model=$row['model'];
			if($row['modeltr'] != NULL && $row['modeltr'] == '' && strlen($row['modeltr'])>0 ){
					$model=$row['modeltr'];
			}
			$row['model']=$model;
*/

		
			return $description;
		}
		return -1;
	}
	
	public static function getPartnerInfo($userid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$partner = array();

		$query = "select u.id as userid, p.id as partnerid, p.address, p.city, p.fax, p.name, p.phone, p.zip, p.email, p.code, p.number
		from user as u
		left join partner as p on u.partnerid = p.id
		where u.id = ".$userid;
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$partner = $res->fetch_assoc();
		}

		return $partner;
	}

	public static function getPartnerInfoById($partnerid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$partner = array();

		$query = "select u.id as userid, p.id as partnerid, p.address, p.city, p.fax, p.name, p.phone, p.zip, p.email, p.code, p.number
		from user as u
		left join partner as p on u.partnerid = p.id
		where u.partnerid = ".$partnerid;
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$partner = $res->fetch_assoc();
		}

		return $partner;
	}


	public static function isProductVisible($prodid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		global $system_conf;		
	
		/*if($system_conf["category_type"][1] == 1){
			// relacije aktivne
			$query = "select ".$_SESSION['shoptype']."visible as visible, prc.status as status from category as c
			LEFT JOIN category_external ce ON c.id = ce.categoryid
			left join productcategory as prc on ce.id = prc.categoryid
			where prc.productid = ".$prodid;	
		}else{
			$query = "select ".$_SESSION['shoptype']."visible as visible, prc.status as status from category as c
			left join productcategory as prc on c.id = prc.categoryid
			where prc.productid = ".$prodid;	
		}*/
		
		/*	local products	*/
		$query = "
			SELECT * FROM (
			select ".$_SESSION['shoptype']."visible as visible, prc.status as status from category as c
			left join productcategory as prc on c.id = prc.categoryid
			where prc.productid = ".$prodid;
			
		/*	Suppliers products	*/	
		$query .= " UNION 
				select b2cvisible as visible, pce.status as status FROM category as c
				LEFT JOIN category_external ce ON c.id = ce.categoryid
				left join productcategory_external as pce on ce.id = pce.categoryid
				where pce.productid = ".$prodid.") as t1  ";
		
		$ress = $mysqli->query($query);
		if($ress->num_rows > 0){
			$row = $ress->fetch_assoc();
			if($row['visible'] == 1 && $row['status'] == 'v'){
				$query = "select productid from productwarehouse where productid = ".$prodid." and warehouseid = ".$_SESSION['warehouseid'];
				$res = $mysqli->query($query);
				if($res->num_rows >0){
					return true;
				}
			}
		}
		return false;
	}
	public static function getAllMainCatsWithSubcat(){
		/** izvlaci sve glavne kategorije sa njihvoim podkategorijama */
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cats = array();
		$usertype = $_SESSION['shoptype'];

		if ($usertype == "b2b") {
			$warehousestring = " AND b2bvisible = 1";
		} else {
			$warehousestring = " AND b2cvisible = 1";
		}

		$query = "select id from category WHERE parentid = 0" . $warehousestring ." ORDER BY sort ASC";
		if($res = $mysqli->query($query)){
			while($row = $res->fetch_assoc()){
				$cats[] = array('cat'=>Category::getCategoryData($row['id']), 'subcats'=>self::getSubcatFromCatID($row['id']));
			}
		}
		return $cats;
	}
	
	public static function getAllMainNewsCatsWithSubcat(){
		/** izvlaci sve glavne kategorije sa njihvoim podkategorijama */
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cats = array();

		$query = "select id from newscategory WHERE parentid = 0 ORDER BY sort ASC";
		if($res = $mysqli->query($query)){
			while($row = $res->fetch_assoc()){
				$cats[] = array('cat'=>NewsCategory::getNewsCategoryData($row['id']), 'subcats'=>self::getSubcatFromNewsCatID($row['id']));
			}
		}
		return $cats;
	}
	
	private static function getSubcatFromCatID($catid){
		/** izvlaci kategorije prosledjene kategorije */
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cats = array();
		$usertype = $_SESSION['shoptype'];
		if ($usertype == "b2b") {
			$warehousestring = " AND b2bvisible = 1";
		} else {
			$warehousestring = " AND b2cvisible = 1";
		}

		$query = "select id from category WHERE parentid = ".$catid." " . $warehousestring . " ORDER BY sort ASC";
		if($res = $mysqli->query($query)){
			while($row = $res->fetch_assoc()){
				//$cats[] = Category::getCategoryData($row['id']);
				$cats[] = array('cat'=>Category::getCategoryData($row['id']), 'subcats'=>self::getSubcatFromCatID($row['id']));
			}
		}
		return $cats;
	}
	
	private static function getSubcatFromNewsCatID($newscatid){
		/** izvlaci kategorije prosledjene kategorije */
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$cats = array();

		$query = "select id from newscategory WHERE parentid = ".$newscatid." ORDER BY sort ASC";
		if($res = $mysqli->query($query)){
			while($row = $res->fetch_assoc()){
				//$cats[] = Category::getCategoryData($row['id']);
				$cats[] = array('cat'=>NewsCategory::getNewsCategoryData($row['id']), 'subcats'=>self::getSubcatFromNewsCatID($row['id']));
			}
		}
		return $cats;
	}
	
	public static function add_newsletter($email){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		$q = "SELECT * FROM newsletter WHERE email = '".$email."'";
		$res = $mysqli->query($q);
		if(mysqli_num_rows($res) > 0){
			return 0;
		}
		else{
			$q = "INSERT INTO `newsletter`(`id`, `email`, `ts`) VALUES ('','".$mysqli->real_escape_string($email)."',CURRENT_TIMESTAMP)";	
			$mysqli->query($q);
			return 1;
		}
		
	}
	
	public static function partnerLogShopcartData($prodid, $qty, $name, $price, $rebate){
		global $user_conf;
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$partnerid=0;
		$partneraddressid=0;
		$userid=0;
			if(isset($_SESSION['type']) && ($_SESSION['type'] == 'partner' || $_SESSION['type'] == 'commerc')){
				$sWhere = " WHERE partnerid = ".$_SESSION['partnerid']." AND partneraddressid=".$_SESSION['partneraddressid'];	
				$partnerid=$_SESSION['partnerid'];
				$partneraddressid=$_SESSION['partneraddressid'];
			}
			else{
				$sWhere = " WHERE userid = ".$_SESSION['id']." ";
				$userid=$_SESSION['id'];
			}
		
		$q = "SELECT * FROM document_partner_log ".$sWhere;
		if($res = $mysqli->query($q)){
			if($res->num_rows > 0){
				$row = $res->fetch_assoc();
				$lastid = $row['ID'];	
			}else{
				$q = "INSERT INTO `document_partner_log` (`ID`, `documentid`, `comment`, `documentcurrency`, `documentdate`, `valutedate`, `description`, `direction`, `exchangelistid`, `inputcurrency`, `number`, `partnerid`, `status`, `documenttype`, `warehouseid`, `userid`, `statement`, `inwarehouseid`, `reservationid`, `relateddocumentid`, `documentissuedate`, `partneraddressid`, `vehicleid`, `transporterrandid`, `docreturn`, `documentadmissiondate`, `documentchargetypeid`, `ts`) VALUES (NULL, '', NULL, '', '0000-00-00', '0000-00-00', NULL, '1', NULL, NULL, '', '".$partnerid."', 'n', '', NULL, '".$userid."', 'n', NULL, NULL, NULL, '0000-00-00', '".$partneraddressid."', NULL, NULL, 'n', NULL, NULL, CURRENT_TIMESTAMP);";
				$mysqli->query($q);
				
				$lastid = $mysqli->insert_id;
			}
			
			$data = array();
			foreach($_SESSION['shopcart'] as $key=>$val){
				if(array_key_exists($val['id'], $data)){ //ako postoji asocijativna vrednost sa kljucem id
					$data[$val['id']]['qty'] += intval($val['qty']);//azurira kolicinu
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
					$data[$val['id']]['unitname'] = $val['unitname'];
					$data[$val['id']]['unitstep'] = $val['unitstep'];
					$data[$val['id']]['qty'] = intval($val['qty']);
					$data[$val['id']]['attr'] = array();
					
					$attrdata = json_decode($val['attr']);
					$tmparray = array();
					if(is_array($attrdata) && count($attrdata)>0){
					foreach($attrdata as $k=>$v){
						array_push($tmparray, $v[1]);	
					} 
					}
					array_push($data[$val['id']]['attr'], array($tmparray, intval($val['qty'])));
				}
			}
			
			foreach($data as $key=>$val){
				$q = "INSERT INTO `documentitem_partner_log`( `documentitemid`, `cost`, `costtype`, `rebate`, `rebatetype`, `documentid`, `margin`, `marginetype`, `price`, `price2`, `itemvalue`, `productid`, `productname`, `quantity`, `sort`, `taxvalue`, `taxid`, `intax`, `unitname`, `unitstep`, `image`, `ts`) VALUES ( '', 0, '', ".$val['rebate'].", 'p', ".$lastid.", 0, '', ".$val['price'].", 0, ".$val['price']*((100-intval($val['rebate']))/100)*$val['qty'].", ".$key.", '".$val['name']."', ".$val['qty'].", 0, ".$val['tax'].", 0, 0, '".$val['unitname']."', '".$val['unitstep']."', '".$val['pic']."', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE quantity = (".$val['qty'].")";	
				$mysqli->query($q);
				
				$lastitemid = $mysqli->insert_id;
				foreach($val['attr'] as $k=>$v){
					$q = "INSERT INTO `documentitemattr_partner_log`( `documentitemid`, `attrvalue`, `quantity`, `ts`) VALUES ( ".$lastitemid.", '".implode(",", $v[0])."', ".$v[1].", CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE quantity = (".$v[1].")";
					$mysqli->query($q);
				}
			}
			
		}
	}
	
	public static function partnerUpdateShopcartData($shopcartPosition){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		$newamount = $_SESSION['shopcart'][$shopcartPosition]['qty'];
		$attrvals = json_decode($_SESSION['shopcart'][$shopcartPosition]['attr']);
		
		if(isset($_SESSION['type']) && ($_SESSION['type'] == 'partner' || $_SESSION['type'] == 'commerc')){
			$sWhere = " WHERE partnerid = ".$_SESSION['partnerid']." AND partneraddressid=".$_SESSION['partneraddressid'];	
		}
		else{
			$sWhere = " WHERE userid = ".$_SESSION['id']." ";
		}
		
		$tmparray = array();
		if(is_array($attrvals) && count($attrvals)>0){
			foreach($attrvals as $k=>$v){
				array_push($tmparray, $v[1]);	
			} 
		}
		
		$q = "SELECT diapl.quantity, diapl.id as diaplid, dipl.ID as diplid FROM `documentitemattr_partner_log` diapl
				LEFT JOIN `documentitem_partner_log` dipl ON diapl.documentitemid = dipl.ID
				LEFT JOIN `document_partner_log` dpl ON dipl.documentid = dpl.ID 
				".$sWhere." AND dipl.productid = ".$_SESSION['shopcart'][$shopcartPosition]['id']." AND diapl.attrvalue = '".implode(',',$tmparray)."'";
		$res = $mysqli->query($q);
		if($res->num_rows > 0){	
			$row = $res->fetch_assoc();
			$amountDiference = intval($newamount) - intval($row['quantity']);
			
			$q = 'UPDATE `documentitemattr_partner_log` SET quantity = quantity + '.$amountDiference." WHERE id = ".$row['diaplid']; 
			if($mysqli->query($q)){
				$q = 'UPDATE `documentitem_partner_log` SET quantity = quantity + '.$amountDiference." WHERE id = ".$row['diplid']; 
				if($mysqli->query($q)){
					
				}
			}
		}
	}
	
	public static function partnerDeleteShopcartData($shopcartPosition){
		if(isset($_SESSION['type']) && ($_SESSION['type'] == 'partner' || $_SESSION['type'] == 'commerc'))
		{
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$mysqli->set_charset("utf8");
			
			$removedamount = $_SESSION['shopcart'][$shopcartPosition]['qty'];
			$attrvals = json_decode($_SESSION['shopcart'][$shopcartPosition]['attr']);
			
			if(isset($_SESSION['type']) && ($_SESSION['type'] == 'partner' || $_SESSION['type'] == 'commerc')) {
				$sWhere = " WHERE partnerid = ".$_SESSION['partnerid']." AND partneraddressid=".$_SESSION['partneraddressid'];	
			}
			else{
				$sWhere = " WHERE userid = ".$_SESSION['id']." ";
			}
			$tmparray = array();
			if(is_array($attrvals) && count($attrvals)>0){
				foreach($attrvals as $k=>$v){
					array_push($tmparray, $v[1]);	
				} 
			}
			$q = "SELECT diapl.quantity, diapl.id as diaplid, dipl.ID as diplid, dpl.ID as dplid FROM  `documentitem_partner_log` dipl
					LEFT JOIN  `documentitemattr_partner_log` diapl ON  dipl.ID = diapl.documentitemid
					LEFT JOIN `document_partner_log` dpl ON dipl.documentid = dpl.ID 
					".$sWhere." AND dipl.productid = ".$_SESSION['shopcart'][$shopcartPosition]['id']." AND (diapl.attrvalue = '".implode(',',$tmparray)."' OR diapl.attrvalue IS NULL)";
			//echo $q;
			$res = $mysqli->query($q);
			if($row['diaplid']!=NULL){

			if($res->num_rows > 0){
				$row = $res->fetch_assoc();
				$q = "DELETE FROM `documentitemattr_partner_log` WHERE id = ".$row['diaplid'];
				if($mysqli->query($q)){
					$q = "SELECT * FROM `documentitemattr_partner_log` WHERE documentitemid = ".$row['diplid'];
					$res = $mysqli->query($q);
					if($res->num_rows > 0){	
						/*	remove quantiti from dipl	*/
						$q = 'UPDATE `documentitem_partner_log` SET quantity = quantity - '.$removedamount;
					}else{
						/*	Remove from dipl	*/	
						$q = "DELETE FROM documentitem_partner_log WHERE ID = ".$row['diplid'];
					}
					if($mysqli->query($q)){
						$q = "SELECT * FROM `documentitem_partner_log` WHERE documentid = ".$row['dplid'];	
						$res = $mysqli->query($q);
						if($res->num_rows == 0){	
							/*	Remove from dipl	*/	
							$q = "DELETE FROM document_partner_log WHERE ID = ".$row['dplid'];
							if($mysqli->query($q)){
								return 1;	
							}else{return 0;}
						}else{return 1;}
					}else{return 0;}
				}else{return 0;}
			}else{return 0;}
		}else{return 1;}
		} else if(isset($_SESSION['type']) && ($_SESSION['type'] == 'user')) {
			$q = "DELETE FROM documentitem_partner_log WHERE ID = ".$row['diplid'];
			if($mysqli->query($q)){
						$q = "SELECT * FROM `documentitem_partner_log` WHERE documentid = ".$row['dplid'];	
						$res = $mysqli->query($q);
						if($res->num_rows == 0){	
							/*	Remove from dipl	*/	
							$q = "DELETE FROM document_partner_log WHERE ID = ".$row['dplid'];
							if($mysqli->query($q)){
								return 1;	
							}else{return 0;}
						}else{return 1;}
					}else{return 0;}
				
		} else {
			return 1;
		}
	}
		
	public static function partnerLoadShopcartData(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$_SESSION['shopcart']=array();
		$_SESSION['shopcart_request']=array();
		
		$sWhere = '';
		
		if(isset($_SESSION['type']) && ($_SESSION['type'] == 'partner' || $_SESSION['type'] == 'commerc') && isset($_SESSION['partnerid']) && $_SESSION['partnerid']>0){
			$sWhere = " WHERE partnerid = ".$_SESSION['partnerid']." AND partneraddressid=".$_SESSION['partneraddressid'];
		}
		elseif(isset($_SESSION['id'])){
			$sWhere = " WHERE userid = ".$_SESSION['id']." ";
		}
		if($sWhere != '')
		{		
			$q = "SELECT * FROM document_partner_log ".$sWhere;
		
			if($resd = $mysqli->query($q)){
				if($resd->num_rows > 0){
					$rowd = $resd->fetch_assoc();
		
					$q = "SELECT * FROM documentitem_partner_log WHERE documentid = ".$rowd['ID'];
					if($resdi = $mysqli->query($q)){
						if($resdi->num_rows > 0){
							while($rowdi = $resdi->fetch_assoc()){
								$q = "SELECT * FROM `documentitemattr_partner_log` WHERE documentitemid = ".$rowdi['ID'];
								$resdia = $mysqli->query($q);
								if($resdia->num_rows > 0){
									while($rowdia = $resdia->fetch_assoc()){
										$attrs = '';
										if($rowdia['attrvalue'] != '')
										{
											$q = "SELECT * FROM attrval WHERE id  IN (".$rowdia['attrvalue'].")";
											$resav = $mysqli->query($q);
											if($resav->num_rows > 0){
												$attrs = array();
												while($rowav = $resav->fetch_assoc()){
													array_push($attrs, array($rowav['attrid'], $rowav['id']));
												}
												$attrs = json_encode($attrs);
											}
											
										}
										
										$prod=array('id' => $rowdi['productid'],
											'name' => $rowdi['productname'],
											'price' =>  number_format($rowdi['price'],4,'.',''),
											'rebate' =>  $rowdi['rebate'],
											'tax' =>  $rowdi['taxvalue'],
											'pic' => $rowdi['image'],
											'qty' => $rowdia['quantity'],
											'attr' => $attrs,
											'unitname' => $rowdi['unitname'],
											'unitstep' => $rowdi['unitstep'],
										);
										$_SESSION['shopcart'][] = $prod;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	public static function increaseCountData($foreigntable='',$foreignid=0){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		if(strlen($foreigntable)>0 && $foreignid>0){
		
			$q = "INSERT INTO countdata (foreign_table,foreign_id) VALUES ('".$foreigntable."',".$foreignid.")";
			//echo $q;
		
			$mysqli->query($q);
		}

	}

	public static function increaseStatistics($foreigntable='',$foreignid=0){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		if(strlen($foreigntable)>0 && $foreignid>0){
		
			$q='SET @cnt=0';
			$mysqli->query($q);
			$q="SELECT @cnt:=IFNULL( (SELECT `count` FROM statistics WHERE foreign_table='".$foreigntable."' AND foreign_id=".$foreignid."),0)+1";
			$mysqli->query($q);
			$q="INSERT INTO statistics (foreign_table,foreign_id, `count`) VALUES ('".$foreigntable."',".$foreignid.",  @cnt) ON DUPLICATE KEY UPDATE `count`=@cnt";
			$mysqli->query($q);
		}

	}

	public static function getTopSliderRandomBanner($limit=1)
	{
		$banner = array();
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$bannersright = array();
		$q="SELECT b.*, btr.value as valuetr FROM banner b
			LEFT JOIN banner_tr btr ON b.id = btr.bannerid
			WHERE b.position = 3 AND status = 'v' AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid is null) 
			ORDER BY RAND() LIMIT ".$limit;
		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			while($row = $res->fetch_assoc())
				array_push($banner, array("id"=>$row['id'], 'name'=>$row['name'], 'value'=>(($row['valuetr'] == NULL)? $row['value']:$row['valuetr']) ));
		}
		return $banner;
	}	
	
	public static function getRandomBanner($limit=1)
	{
		$banner = array();
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$bannersright = array();
		$q="SELECT b.*, btr.value as valuetr FROM banner b
			LEFT JOIN banner_tr btr ON b.id = btr.bannerid
			WHERE b.position = 2 AND status = 'v' AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid is null) 
			ORDER BY RAND() LIMIT ".$limit;
		$res = $mysqli->query($q);
		if($res && $res->num_rows > 0){
			while($row = $res->fetch_assoc())
				array_push($banner, array("id"=>$row['id'], 'name'=>$row['name'], 'value'=>(($row['valuetr'] == NULL)? $row['value']:$row['valuetr']) ));
		}
		return $banner;
	}
	
	
	public static function getCatalogs(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$catalogs = array();
		$query = "select id, showname as name, link, image from documents";

		$res = $mysqli->query($query);

		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				array_push($catalogs, $row);
			}
		}
//		$query = "select id, name, link, image from catalog where status = 'v' ORDER BY sort, id ASC ";
//		$res = $mysqli->query($query);
//		if($res->num_rows > 0){
//			while($row = $res->fetch_assoc()){
//				array_push($catalogs, $row);
//			}
//
//		}
		return $catalogs;
	}	
	
	public static function getContrastColor($hexcolor) {               
		$r = hexdec(substr($hexcolor, 0, 2));
		$g = hexdec(substr($hexcolor, 2, 2));
		$b = hexdec(substr($hexcolor, 4, 2));
		$yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
		return ($yiq >= 128) ? '#000000' : '#FFFFFF';
	} 

	public static function getExtraDetailData(){
		// retrun first level childs
		global $user_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		
		$q = "SELECT ed.id, ed.name, ed.image, ed.sort, edtr.name as nametr, edtr.image as imagetr 
			FROM extradetail ed
			LEFT JOIN extradetail_tr edtr ON ed.id = edtr.extradetailid
			WHERE ed.status='v' AND (edtr.langid =". $_SESSION['langid']. " OR edtr.langid is null)  ORDER BY ed.sort ASC";
		//echo $q;	
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$name = $row['name'];
				if($row['nametr'] != NULL){
					$name = $row['nametr'];	
				}
				$image = $row['image'];
				if($row['imagetr'] != NULL){
					$image = $row['imagetr'];	
				}
				
				array_push($data, array('id' => $row['id'],  'name' => $name, 'image'=>$image));
			}
		}
		
		return $data;
	}	
	
}