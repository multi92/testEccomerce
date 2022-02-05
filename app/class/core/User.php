<?php

$class_version["user"] = array('module', '1.0.0.0.1', 'Nema opisa');

class User{
	public $id;
    public $partnerid;
    public $username;
    public $password;
    public $email;
    public $type;
    public $name;
    public $surname;
    public $address;
    public $city;
    public $zip;
    public $phone;

    public function __construct($id=0,$partnerID=0,$username='',$type='',$email='', $ime='', $prezime='',
                                $adresa='', $mesto='', $post_br='', $telefon='')
    {
        $this->id = $id;
        $this->partnerid = $partnerID;
        $this->username = $username;
        $this->email = $email;
        $this->type = $type;
        $this->name = $ime;
        $this->surname = $prezime;
        $this->address = $adresa;
        $this->city = $mesto;
        $this->zip = $post_br;
        $this->phone = $telefon;
    }
	
	public static function login($username, $userpass, $autologin = false)
    {
		global $command, $get, $user_conf;

         $db = Database::getInstance();
         $mysqli = $db->getConnection();
         $mysqli->set_charset("utf8");

        /*$mysqli = self::$mysqli;*/

        $loged = false;
        if ($username != NULL && $userpass != NULL) {
            $userpass= $mysqli->real_escape_string($userpass);
            $un = stripcslashes($username);
            $pw = stripcslashes($userpass);

            $query = "SELECT * FROM user WHERE email='" . $mysqli->real_escape_string($username) . "'";
            //var_dump($query);
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['status'] > 1) {
                    if ($un == $row['email']) {
						if($autologin){
							//echo $row['password'];
							//getUserDocumentsecho md5(sha1($row['email'].$row['password'])).'='.$userpass;
							//die();
							if(md5(sha1($row['email'].$row['password'])) == $userpass){ 
								$pe = $row['password'];
							}
							else $pe = self::pass_enc($pw);
						}else{
                        	$pe = self::pass_enc($pw);
						}
                        if ($pe == $row['password']) {
							
							$typedefault = '';
							$shoptype = '';
							$warehouseid = '';
							$buyertype = '';
							//var_dump($row);
							switch($row['type']){
								case 'user' : {
									$typedefault = 'ud'; 
									$buyertype ='user';
									$shoptype = "b2c";
									$warehouseid = $user_conf["b2cwh"][1];
									}break;
								case 'partner' : {
									$typedefault = 'pd'; 
									$buyertype ='partner';
									$shoptype = "b2b";
									$warehouseid = $user_conf["b2bwh"][1];
									}break;
								case 'commerc' : {
									$typedefault = 'cd'; 
									$buyertype ='commerc';
									$shoptype = "b2b";
									$warehouseid = $user_conf["b2bwh"][1];
									}break;
								default: {
									$typedefault = 'ud'; 
									$buyertype ='user';
									$shoptype = "b2c";
									$warehouseid = $user_conf["b2cwh"][1];
								}
							}
							
							$_SESSION['privilages'] = array();
							$query = "SELECT pl.value as listname, pgl.value FROM privilages_usergroup pug
LEFT JOIN privilages_group pg ON pug.groupid = pg.id
LEFT JOIN privilages_grouplist pgl ON pg.id = pgl.groupid
LEFT JOIN privilages_list pl ON pgl.listid = pl.id
WHERE pug.userid = ".$row["id"];
							$repriv = $mysqli->query($query);
							
							$privilages = false;
							if($repriv->num_rows > 0){
								$privilages = true;
							}
							else{
								$query = "SELECT pl.value as listname, pgl.value FROM privilages_usergroup pug
								LEFT JOIN privilages_group pg ON pug.groupid = pg.id
								LEFT JOIN privilages_grouplist pgl ON pg.id = pgl.groupid
								LEFT JOIN privilages_list pl ON pgl.listid = pl.id
								WHERE pg.type = '".$typedefault."'";	
								$repriv = $mysqli->query($query);
								if($repriv->num_rows > 0){
									$privilages = true;
								}
							}
							
							if($privilages){
							
								while($rowp = $repriv->fetch_assoc()){
									$_SESSION['privilages'][$rowp['listname']] = $rowp['value'];
								}
								
								$_SESSION["loginstatus"] = "logged";
                                $_SESSION["langid"] = $row["default_langid"];
                                $_SESSION['langcode'] = GlobalHelper::getLangCode($_SESSION["langid"]);
                                setcookie("lang", $_SESSION["langid"]);
                                setcookie("langcode", $_SESSION['langcode']);
								$_SESSION["type"] = $buyertype;
								//var_dump($_SESSION["type"]);
								$_SESSION["shoptype"] = $shoptype;
								//var_dump($_SESSION["shoptype"]);
								$_SESSION['warehouseid'] = $warehouseid;
								$_SESSION["id"] = $row["id"];
								$_SESSION["partnerid"] = $row["partnerid"];
								$_SESSION["partneraddressid"] = 0;
								$_SESSION["adresa"] = $row["address"];
								$_SESSION["mesto"] = $row["city"];
								$_SESSION["postbr"] = $row["zip"];
								$_SESSION["telefon"] = $row["phone"];
								$_SESSION["mobile"] = $row["mobile"];
								$_SESSION["ime"] = $row["name"];
								$_SESSION["prezime"] = $row["surname"];
								$_SESSION["email"] = $row["email"];
								$_SESSION["rebate"] = $row["rebate"];
								$_SESSION["status"] = $row["status"];
								$_SESSION["updated"] = $row["updated"];
								if($user_conf["log_shopchart_items"][1]==1){
									$logeddocumentitem=array();
									//$logeddocumentitem=Shop::getLoggedDocumentItems($row["id"]);
									
									//get loggeddocumentitem

								}
								
								$query = "UPDATE user SET LAST_LOGGED = NOW() WHERE id = " . $row['id'];
								$mysqli->query($query);
								$query1 = "UPDATE userlogdata SET login_count=login_count+1 WHERE userid=". $row['id'];
								$mysqli->query($query1);
								$msg = "success loging";
//								echo json_encode($msg);
								$loged = true;
								if(!$autologin) {
								$_SESSION['success_notifications'][] = 'Dobrodošli!';
								}
								//if($autologin) {return 999;} else {return 1;}
								
									return 1;
								
							}	// end $privilages
							else{
//								$_SESSION['error_notifications'][] = 'Nedovoljne privilegije ili nepostojece!';
                    			return 4;
							}
							
                        }
                    }
                } else {
//                    $_SESSION['error_notifications'][] = 'Vasa email adresa nije potvrdjena!';
                    return 2;
                }
            }
            if (!$loged) {
//                $_SESSION['error_notifications'][] = 'Neuspela prijava';
                return 0;
            }
        } else {
            if (!$loged) {

//                $_SESSION['error_notifications'][] = 'empty username or pass';
                return 3;
            }
        }
    }
	
	public static function logout(){
		session_unset(); 
		session_destroy();
		setcookie("PHPSESSID","",1);
		//unset($_COOKIE['username']);
		//unset($_COOKIE['password']);
		setcookie('username', '',time() - 3600);
		setcookie('h264', '',time() - 3600);
//		header("Location: ");
        return 1;
	}

    public static function forgotPass($email){

        if(self::emailExist($email)){
            global $user_conf;
            $requiredstring = self::pass_enc($email);
            $requiredstring = self::generateRandomString(10).$requiredstring.self::generateRandomString(10);

            $requiredstring = BASE_URL."?passreq=".$requiredstring;
            GlobalHelper::sendEmail($email, $user_conf["autoemail"][1], '', $requiredstring, 'resPass');
            return 1;
        }
        else{
            return 0;//nepostojeci email
        }
    }
	
    public static function changePassConf($code){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $user_conf;
        $requiredstring = substr($code, 10, -10);

        $query = "select email from user";
        $res = $mysqli->query($query);
        while($row = $res->fetch_assoc()){
            if ($requiredstring == self::pass_enc($row['email'])){
                $pass = self::generateRandomString();
                GlobalHelper::sendEmail($row['email'], $user_conf["autoemail"][1], '', $pass, 'newPass');

                var_dump('pass-change', self::changePass($row['email'], $pass));
                return 1;
            }
        }
        return 0;
    }

    public static function changePass($email, $pass){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $email = $mysqli->real_escape_string($email);

        $pass = self::pass_enc($pass);

        $query = "update user set password = '".$pass."' where email = '".$email."'";
        if($mysqli->query($query)){
            return 1;
        }
        else{
            return 0;
        }
    }
	
	public static function checkPassword($password){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$q = "SELECT * FROM user WHERE email = '".$_SESSION['email']."' AND password = '".self::pass_enc($password)."'";
		$res = $mysqli->query($q);	
		if($res->num_rows > 0){
			return true;	
		}else{
			return false;	
		}
	}

    private static function emailExist($email){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $email = $mysqli->real_escape_string($email);
        $query = "select id from user WHERE email = '".$email."'";
        if($res = $mysqli->query($query)){
            if($res->num_rows > 0){
                return true;
            }
        }
        return false;
    }
	
	private static function pass_enc($pass)
    {
        return md5($pass);
    }
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public static function register($email, $password, $password_r, $ime, $prezime, $adresa, $mesto, $post_br, $telefon, $b2b=0, $defaultlang,$birthday)
    {
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if(!self::emailExist($mysqli->real_escape_string($email))) {
            if ($password == $password_r) {
            	if($b2b>0){
            		$query = "INSERT INTO `user` (`ID`, `username`, `password`, `email`, `type`, `last_logged`, `name`, `surname`, `address`, `city`, `zip`, `birthday`, `phone`, `rebate`, `email_notif`, `status`, `default_langid`)
                    VALUES (NULL, '',
                     '" . self::pass_enc($password) . "',
                      '" . $mysqli->real_escape_string($email) . "',
                       'user',
                        NOW(),
                         '" . $mysqli->real_escape_string($ime) . "',
                        '" . $mysqli->real_escape_string($prezime) . "',
                         '" . $mysqli->real_escape_string($adresa) . "',
                          '" . $mysqli->real_escape_string($mesto) . "',
                           '" . $mysqli->real_escape_string($post_br) . "',
                           '" . $mysqli->real_escape_string(date("Y-m-d", strtotime($birthday))) . "',
                            '" . $mysqli->real_escape_string($telefon) . "',
                             '0',
                              '0',
                               '0',
                               " . $mysqli->real_escape_string($defaultlang) . "
                           )";

                    if ($mysqli->query($query)) {
							$lastid = $mysqli->insert_id;
							
							$query = "INSERT INTO `privilages_usergroup` (`groupid`, `userid`, `default`, `status`, `ts`) VALUES ('1', '".$lastid."', '0', 'v', CURRENT_TIMESTAMP)";
							$mysqli->query($query);
							 return 1;
                	}
                	else {
                	    //return "greska-> Query Fail";
//              	      $_SESSION['error_notifications'][] = 'greska-> Query Fail';
                	    return 3;
                	}

            	} else {

            		$query = "INSERT INTO `user` (`ID`, `username`, `password`, `email`, `type`, `last_logged`, `name`, `surname`, `address`, `city`, `zip`, `birthday`, `phone`, `rebate`, `email_notif`, `status`, `default_langid`)
                    VALUES (NULL, '',
                     '" . self::pass_enc($password) . "',
                      '" . $mysqli->real_escape_string($email) . "',
                       'user',
                        NOW(),
                         '" . $mysqli->real_escape_string($ime) . "',
                        '" . $mysqli->real_escape_string($prezime) . "',
                         '" . $mysqli->real_escape_string($adresa) . "',
                          '" . $mysqli->real_escape_string($mesto) . "',
                           '" . $mysqli->real_escape_string($post_br) . "',
                           '" . $mysqli->real_escape_string(date("Y-m-d", strtotime($birthday))) . "',
                            '" . $mysqli->real_escape_string($telefon) . "',
                             '0',
                              '1',
                               '1',
                               " . $mysqli->real_escape_string($defaultlang) . "
                           )";


                	if ($mysqli->query($query)) {
							$lastid = $mysqli->insert_id;
							
							$query = "INSERT INTO `privilages_usergroup` (`groupid`, `userid`, `default`, `status`, `ts`) VALUES ('1', '".$lastid."', '0', 'v', CURRENT_TIMESTAMP)";
							$mysqli->query($query);
							
	                	    global $user_conf;
	                	    $requiredstring = self::pass_enc($email);
	                	    $requiredstring = self::generateRandomString(10).$requiredstring.self::generateRandomString(10);
	
	                	    $requiredstring = BASE_URL."?mailconf=".$requiredstring;
	
                	    if (GlobalHelper::sendEmail($mysqli->real_escape_string($email), $user_conf["autoemail"][1], '', $requiredstring, 'potvrdaEmaila')) {
//              	          header("Location: " . BASE_URL);
                	            $_SESSION['success_notifications'][] = 'Registracija ušpesna, molimo Vas da potvrdite Vaš mail.';
                	        return 1;
                	    }
                	}
                	else {
                	    //return "greska-> Query Fail";
//              	      $_SESSION['error_notifications'][] = 'greska-> Query Fail';
                	    return 3;
                	}

            	}
                

               
            }
            else {
//                $_SESSION['error_notifications'][] = 'sifre se ne poklapaju';
                return 2;
            }
        }
        else {
//            $_SESSION['error_notifications'][] = 'e-mail adresa postoji';
            return 0;
        }
    }

    /**
     * potvrda mail-a uz pomoc koda koji se dobija mailom, mail moze da se prebaci u stanje 'active' samo ako je bio 'unconf'
     * @param $code - automacki generisan kod koji se dobija klikom na url za potvrdu email-a
     * @return int vraca 1 ako je uspesno aktiviran email
     */
    public static function emailConfirmByCode($code){
        global $command, $get, $user_conf;

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

 
        $requiredstring = substr($code, 10, -10);

        $query = "select email from user";
        $res = $mysqli->query($query);
        while($row = $res->fetch_assoc()){
            if ($requiredstring == self::pass_enc($row['email'])){
                $query = "UPDATE `user` SET `status`='3',`updated`='1' WHERE email = '".$row['email']."' and `status` = '1'";

                $queryUser = "SELECT `id`,`email` FROM `user` WHERE email = '".$row['email']."' " ;
                $res1 = $mysqli->query($queryUser);
                while ($row1 = $res1->fetch_assoc()) {
                   if(!(self::generateWelcomeVoucher($row1['id']))){
                       $_SESSION['success_notifications'][] = 'Greska.';
                       return 0;
                    } else {
                        if($mysqli->query($query)){
                            $_SESSION['success_notifications'][] = 'Vaš mail je uspešno potvrđen.';
                             return 1;
                        } else { return 0; }
                    }
                }
                
            }
        }
        return 0;
    }

    function generateRandomCode(){
        $chars ="abcdefghijklmnopqrstuwxzy0123456789*/-#";
        
        $charsLen = strlen($chars);
        $randomString ='';

        for($i=0;$i<15;$i++){
            $randomString.=$chars[rand(0,$charsLen-1)];
        }

        return $randomString;

    }

    function welcomeMail(){
        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>Dobrodo&scaron;li</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1" />
                    </head>
                    <body data-gr-c-s-loaded="true" style="font-family: Verdana; background-color:#;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="color:rgb(51, 51, 51); font-family: Verdana; font-size:13px;line-height:20.8px; width:600px;margin:0 auto;">
                            <tbody>
                                <tr style="">
                                    <td>
                                        <div style="width: 600px; height: 40px; ">&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="width: 600px; float:left; text-align: left!important;">
                                            <p style="text-align: center;">
                                                <span style="font-family: Verdana;font-size:13px;color: #000;text-decoration: none; text-align: left;">
                                                    <img src="'.BASE_URL.$user_conf["voucherwelcomemail_picture"][1].'" style="width: 600px; height: 600px;" />
                                                </span>
                                            </p>
                                            <p style="text-align: center;">
                                                <span style="font-family: Verdana;font-size:13px;color: #000;text-decoration: none; text-align: left;">
                                                Uspe&scaron;no ste se registrovali na Breze.rs online shop.</span>
                                            </p>
                                            <p style="text-align: center;"><span style="font-family: Verdana;font-size: 13px;color: #000;text-decoration: none; text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                Kao poklon dobrodo&scaron;lice dodeljujemo vam vaučer u iznosu od 1.000 dinara koji možete iskoristiti za narednu porudžbinu veću od 1.000 dinara.&nbsp;Popust važi na nesnižene artikle.
                                                Vaučer važi samo za jednu kupovinu.</span>
                                            </p>
                                            <p style="text-align: center;"><span style="font-family: Verdana;font-size: 13px;color: #000;text-decoration: none; text-align: left;">
                                                Vaučer se ne može unovčiti. Može se iskoristiti samo u celosti, i ne može se refundirati novac. Popust ostvaren po ovom osnovu se ne može kombinovati sa drugim vidovima popusta. Vaučer se može iskoristiti samo za porudžbine u Online shop-u.</span>
                                            </p>
                                            <p style="text-align: center;"><span style="font-family: Verdana;font-size: 13px;color: #000;text-decoration: none; text-align: left;">
                                            *tiket se upisuje na korpi prilikom poručivanja.</span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div><a
                href="'.BASE_URL.'"
                style="font-family: Verdana;margin: 0px 10px;font-weight: light; font-size:
                14px; color: #; text-decoration:none;" target="_blank" title="MDJ Shop">Web shop
                </a></div>
                                    </td>
                                </tr>
                                <tr style=" border: 0 solid #FFF">
                                    <td>
                                        <div style="width: 600px; height: 40px;">&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style=" min-height: 80px; height: auto; width: 240px; margin:
                0px 9px; color: #; "><span style="font-family: Verdana;font-size: 12px;color:
                #;width: 100%; display: block; text-decoration: none; text-transform:
                none;">Breze </span> <span style="font-family: Verdana;font-size:
                12px;color: #;width: 100%; display: block; text-decoration: none;
                text-transform: none;"> Nade Tomić 5, 18400 Prokuplje </span>
                <span style="font-family: Verdana;font-size: 12px;color: #;width: 100%; clear:
                both; text-decoration: none; text-transform: none;"> 060/5560973 </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </body>
                </html>';
        return $body;
    }


    public static function generateWelcomeVoucher($userid){
        global $command, $get, $user_conf;
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $voucherCode = self::generateRandomCode();

        $query = "INSERT  INTO user_voucher (`userid`,`voucherid`, `vouchercode`,`status`, `createddate`,`warehouseid`) VALUES (".$userid.",".$user_conf["defaultwelcomevoucherid"][1].",'".$voucherCode."','a', CURRENT_TIMESTAMP, 1)";
        //var_dump($query);
        $mysqli->query($query);

        $query = "SELECT * FROM voucher WHERE vouchertype='w' AND status='y' AND id=".$user_conf["defaultwelcomevoucherid"][1];
        $res = $mysqli->query($query);
        $row = $res->fetch_assoc();
        
            
        $body = "Postovani/a <br  /><br />";
        $body.="Dobro došli na naš sajt, ovaj vaučer možete iskoristiti do ".$row['expirationdate']." Kod vaučer ".$voucherCode."  <br /> Vas Breze";

        $message = self::welcomeMail();

        $headers = 'MIME-Version: 1.0'."\n";
        $headers .= "Content-Type: text/html; charset=UTF-8"."\n";
        $headers .= "From: marko.djordjevic@softart.rs";

        if(mail("marko.djordjevic@softart.rs", $subject, $message, $headers)){
            return true;
        }
        else{
            return false;
        }

        //return true;
    }

	public static function getUserData($id){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		
		$q = "SELECT u.*, p.name as pname , IFNULL(u.birthday,CURRENT_DATE) AS `birthdaysys`  FROM user u 
			LEFT JOIN partner p ON u.partnerid = p.id
			WHERE u.id = ".$id;
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$data['id'] = $row['id'];
				$data['partnerid'] = $row['partnerid'];
				$data['name'] = $row['name'];
				$data['surname'] = $row['surname'];
				$data['email'] = $row['email'];
				$data['type'] = $row['type'];
				$data['address'] = $row['address'];
				$data['city'] = $row['city'];
				$data['zip'] = $row['zip'];
                $data['birthday'] = $row['birthdaysys'];
				$data['phone'] = $row['phone'];
				$data['mobile'] = $row['mobile'];
				$data['partner'] = $row['pname'];
			}
		}
		
		return $data;
	}

	public static function getUserIdByEmail($email){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$userid = 0;
		
		$q = "SELECT u.id FROM user u 
			WHERE u.email = '".$email."'";
		$res = $mysqli->query($q);
		//echo $q;
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$userid = $row['id'];
		}
		
		return $userid;
	}
	
	public static function getCurrentPartnerData(){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		
		$q = "SELECT * FROM partner 
			WHERE id = ".$_SESSION['partnerid'];
		$res = $mysqli->query($q);
		
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$data['id'] = $row['id'];
			$data['name'] = $row['name'];
			$data['email'] = $row['email'];
			$data['type'] = $row['partnertype'];
			$data['address'] = $row['address'];
			$data['city'] = $row['city'];
			$data['zip'] = $row['zip'];
            $data['birthday'] = $row['birthday'];
			$data['phone'] = $row['phone'];
			$data['pib'] = $row['code'];
			
		}
			
		return $data;
	}
	
	public static function setUserData($id, $name, $surname, $address, $city, $zip, $phone){
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		
		$q = "UPDATE `user` SET `name`='".$mysqli->real_escape_string($name)."',
		 `surname`='".$mysqli->real_escape_string($surname)."',
		 `address`='".$mysqli->real_escape_string($address)."',
		 `city`='".$mysqli->real_escape_string($city)."',
		 `zip`='".$mysqli->real_escape_string($zip)."',
		 `phone`='".$mysqli->real_escape_string($phone)."' WHERE id = ".$id;
		if($mysqli->query($q)){
			return 1;	
		}else{
			return 0;	
		}
	}
	
	public static function updateUserData($id, $name, $surname, $email, $address, $city, $zip, $phone, $cellphone,$partnerid,$type,$updated,$birthday){
		

		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$data = array();
		
		$q = "UPDATE `user` SET `name`='".$mysqli->real_escape_string($name)."',
		 `surname`='".$mysqli->real_escape_string($surname)."',
		 `email`='".$mysqli->real_escape_string($email)."',
		 `address`='".$mysqli->real_escape_string($address)."',
		 `city`='".$mysqli->real_escape_string($city)."',
		 `zip`='".$mysqli->real_escape_string($zip)."',
		 `phone`='".$mysqli->real_escape_string($phone)."',
		 `mobile`='".$mysqli->real_escape_string($cellphone)."',
		 `partnerid`='".$mysqli->real_escape_string($partnerid)."',
		 `type`='".$mysqli->real_escape_string($type)."',		 
		`updated`=".$mysqli->real_escape_string($updated)."',
        `birthday`=".$mysqli->real_escape_string(date("Y-m-d", strtotime($birthday)))."' WHERE id = ".$id;
		if($mysqli->query($q)){
			$_SESSION['updated']=$updated;
			return 1;	
		}else{
			return 0;	
		}
	}
	
	public static function updateUserPassword($old, $new1, $new2, $email){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$q = "SELECT * FROM user WHERE email = '".$mysqli->real_escape_string($email)."' AND password = '".md5($old)."'" ;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			
			if(md5($new1) === md5($new2)){
				User::changePass($email, $new1);
			}
			else{
				return 0;	
			}
		}
		else{
			return 0;
		}	
	}

    public static function getUserDocuments($useremail, $type, $page = 1, $itemsperpage = 1, $sort = "DESC", $sortby = "documentdate", $search = "" ){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");   
        
        $start = ($page-1) * $itemsperpage;
        $end = $itemsperpage;
        
        $data = array();
        $data[0] = 0;
        $data[1] = array();
        
        $q = "SELECT SQL_CALC_FOUND_ROWS *, getB2CDocumentValue(d.documentid) as totalvalue FROM b2c_document d LEFT JOIN b2c_documentdetail AS dd ON d.id=dd.b2c_documentid WHERE d.documenttype = '".$type."' AND dd.customeremail = ".$useremail." ORDER BY ".$sortby. " ".$sort." LIMIT " . $start . "," . $end; 
        $res = $mysqli->query($q);
        
        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $data[0] = $aRe[0];
        
        if($res->num_rows > 0){     
            while($row = $res->fetch_assoc())
            {
                array_push($data[1], array("ID" => $row['ID'], "documentid" => $row['documentid'], "number" => $row['number'], "status" => $row['status'], "createdate" => $row['documentdate'], "totalvalues" => $row['totalvalue'] ));
            }
        }
        
        return $data;
    }
	
	public static function getPartnerDocuments($partnerid, $type, $page = 1, $itemsperpage = 1, $sort = "DESC", $sortby = "documentdate", $search = "" ){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$start = ($page-1) * $itemsperpage;
        $end = $itemsperpage;
		
		$data = array();
		$data[0] = 0;
		$data[1] = array();
		
		$q = "SELECT SQL_CALC_FOUND_ROWS *, getB2BDocumentValue(d.documentid) as totalvalue FROM b2b_document d WHERE documenttype = '".$type."' AND partnerid = ".$partnerid." ORDER BY ".$sortby. " ".$sort." LIMIT " . $start . "," . $end;	
		$res = $mysqli->query($q);
		
		$sQuery = "SELECT FOUND_ROWS()";
		$sRe = $mysqli->query($sQuery);
		$aRe = $sRe->fetch_array();
		$data[0] = $aRe[0];
		
		if($res->num_rows > 0){		
			while($row = $res->fetch_assoc())
			{
				array_push($data[1], array("ID" => $row['ID'], "documentid" => $row['documentid'], "number" => $row['number'], "status" => $row['status'], "createdate" => $row['documentdate'], "totalvalues" => $row['totalvalue'] ));
			}
		}
		
		return $data;
	}

    public static function getUserBillForReservation($resid){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
        
        $data = array();
        $totalvalue = 0;
        
        $q = "SELECT *, getB2CDocumentValue(d.b2c_documentid) as totalvalue FROM b2c_document d WHERE d.b2c_reservationid = ".$resid;
        $res = $mysqli->query($q);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc())
            {
                array_push($data, array("ID" => $row['ID'], "documentid" => $row['documentid'], "number" => $row['number'], "totalvalues" => $row['totalvalue'] ));
            }   
        }
        
        return $data;
    }

    public static function getPartnerBillForReservation($resid){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
        
        $data = array();
        $totalvalue = 0;
        
        $q = "SELECT *, getB2BDocumentValue(d.b2b_documentid) as totalvalue FROM b2b_document d WHERE d.b2b_reservationid = ".$resid;
        $res = $mysqli->query($q);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc())
            {
                array_push($data, array("ID" => $row['ID'], "documentid" => $row['documentid'], "number" => $row['number'], "totalvalues" => $row['totalvalue'] ));
            }   
        }
        
        return $data;
    }
	
	public static function getBillForReservation($resid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		$totalvalue = 0;
		
		$q = "SELECT *, getDocumentValue(d.documentid) as totalvalue FROM document d WHERE d.reservationid = ".$resid;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc())
			{
				array_push($data, array("ID" => $row['ID'], "documentid" => $row['documentid'], "number" => $row['number'], "totalvalues" => $row['totalvalue'] ));
			}	
		}
		
		return $data;
	}
	
	public static function getBankForBill($billid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT bsi.*, bs.statementdate FROM bankstatementitem bsi
				LEFT JOIN bankstatement bs ON bsi.bankstatementid = bs.id 
				WHERE bsi.documentid = ".$billid;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc())
			{
				array_push($data, array("id" => $row['id'], "credit" => $row['credit'], "debit" => $row['debit'], "statementdate" => $row['statementdate'] ));
			}	
		}

		return $data;	
	}
	
	public static function getDocumentItems($docid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT * FROM ".$_SESSION['shoptype']."_documentitem WHERE ".$_SESSION['shoptype']."_documentid = ".$docid;
       // echo $q;
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			$totalval = 0;
			while($row = $res->fetch_assoc()){
				$totalval += $row['itemvalue'];
				
				array_push($data, array('productid' => $row['productid'], 'productname' => $row['productname'], 'quantity' => $row['quantity'], 'price' => number_format($row['price'], 2), 'taxvalue' => $row['taxvalue'], 'rebate' => $row['rebate']));
			}	
		}	
		
		return array($totalval, $data);		
	}


    public static function getUserCard($useremail, $type, $page = 1, $itemsperpage = 1, $sort = "DESC", $sortby = "documentdate", $search = ""){
        $globalcont = array();
        $retdata = User::getUserDocuments($useremail, 'E', $page, $itemsperpage, $sort , $sortby , $search); 
        foreach($retdata[1] as $key=>$val){
            $tmp = array();
            $tmp['reservationdata'] = array();
            $tmp['reservationdata'] = $val;
            
            $tmp['racuni'] = array();
            
            
            $a = User::getUserBillForReservation($val['documentid']);

            for($i = 0; $i < count($a); $i++){
                
                $a[$i]['bills'] = array();
                $b = User::getBankForBill($a[$i]['documentid']);    
                foreach($b as $k=>$v){
                    array_push($a[$i]['bills'], $v);    
                }
                array_push($tmp['racuni'], $a[$i]);         
            }
            
            array_push($globalcont, $tmp);
            
        }
        
        return $globalcont;
    }









	
	public static function getPartnerCard($partnerid, $type, $page = 1, $itemsperpage = 1, $sort = "DESC", $sortby = "documentdate", $search = ""){
		$globalcont = array();
		$retdata = User::getPartnerDocuments($partnerid, 'E', $page, $itemsperpage, $sort , $sortby , $search);	
		foreach($retdata[1] as $key=>$val){
			$tmp = array();
			$tmp['reservationdata'] = array();
			$tmp['reservationdata'] = $val;
			
			$tmp['racuni'] = array();
			
			
			$a = User::getPartnerBillForReservation($val['documentid']);

			for($i = 0; $i < count($a); $i++){
				
				$a[$i]['bills'] = array();
				$b = User::getBankForBill($a[$i]['documentid']);	
				foreach($b as $k=>$v){
					array_push($a[$i]['bills'], $v);	
				}
				array_push($tmp['racuni'], $a[$i]);			
			}
			
			array_push($globalcont, $tmp);
			
		}
		
		return $globalcont;
	}

    public static function isPartnerNotEmptyCart($username, $pass){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $type = '';

        $query = "select type from user where email = '".$username."' and password = '".self::pass_enc($pass)."'"; 
        $res = $mysqli->query($query);
        if($res->num_rows >0){
            $row = $res->fetch_assoc();
            $type = $row['type'];
        }
        if($type == 'partner' && isset($_SESSION['shopcart']) && !empty($_SESSION['shopcart'])){
            return true;
        }
        else{
            return false;
        }
    }
	
	public static function getUserpanelData(){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

		$aColumns = array(  'ID', 'documentid', 'number', 'documentdate', 'valutedate', 'status', 'reservationid', 'documenttype' );
		$sIndexColumn = "ID";
		
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$sLimit = "LIMIT ".$mysqli->real_escape_string($_POST['start'] ).", ".
				$mysqli->real_escape_string($_POST['length'] );
		}
		
		
		/*
		 * Ordering
		 */
		/*if ( isset( $_POST['order'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i< sizeof($_POST['order']) ; $i++ )
			{
				if ( $_POST['columns'][$i]['orderable'] == "true" )
				{
					$sOrder .= $aColumns[$i]." ".$mysqli->real_escape_string($_POST['order'][$i]['dir'] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}else{*/
			$sOrder = "ORDER BY d.id DESC";	
		/*}*/
		
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		 //var_dump($_POST['search']['value']);
			/*$sWhere = "";
			if ( $_POST['search']['value'] != "" )
			{
				$sWhere = "WHERE (";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere .= "n.".$aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_POST['search']['value'] )."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
			}*/
		
			$sWhere = "";
			if($_SESSION['shoptype'] == 'b2b'){
				$sWhere = " WHERE d.partnerid = ".$_SESSION['partnerid']." ";	
			}
			else{
				$sWhere = " WHERE dd.customeremail = '".$_SESSION['email']."' ";	
			}
		/*	DATE Filtering	*/
		
		
		$sWhereDate = ' AND  d.documenttype = "'.$_POST['doctype'].'"';
		if($_POST['startdate'] != ''){
			$sWhereDate .= " AND d.documentdate >= '".$_POST['startdate']."' ";	
		}
		if($_POST['enddate'] != ''){
			$sWhereDate .= " AND d.documentdate <= '".$_POST['enddate']."' ";	
		}
				
		$sValute = "";
		if ( isset( $_POST['invalute'] ) && $_POST['invalute'] != '' )
		{
			if($_POST['invalute'] == 'y'){
				$sValute = " AND d.valutedate >= '".date("Y-m-d")."'";	
			}
			if($_POST['invalute'] == 'n'){
				$sValute = " AND d.valutedate < '".date("Y-m-d")."'";	
			}
		}
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		  
		 if($_POST['doctype'] == 'e' || $_POST['doctype'] == 'p' || $_POST['doctype'] == 'k' || $_POST['doctype'] == 'z'){
			$sQuery = "	
				SELECT SQL_CALC_FOUND_ROWS d.`ID`, d.`documentid`, d.`number`, d.`documentdate`, d.`status`, d.`".$_SESSION['shoptype']."_reservationid`, d.`documenttype`
				FROM  ".$_SESSION['shoptype']."_document d LEFT JOIN ".$_SESSION['shoptype']."_documentdetail AS dd ON d.id=dd.".$_SESSION['shoptype']."_documentid 
				$sWhere
				$sWhereDate
				$sOrder
				$sLimit
			";
		 }
		 if($_POST['doctype'] == 'r'){
			 
			$select = " 
				(CASE
					WHEN d.".$_SESSION['shoptype']."_reservationid > '' THEN d2.number 
					ELSE ''
				 END) ";
			$join = " LEFT JOIN ".$_SESSION['shoptype']."_document d2 ON d.".$_SESSION['shoptype']."_reservationid = d2.id ";		
		 
			$sQuery = "	
				SELECT SQL_CALC_FOUND_ROWS d.`ID`, d.`documentid`, d.`number`, d.`documentdate`, d.`valutedate`, d.`status`, d.`".$_SESSION['shoptype']."_reservationid`, d.`documenttype`, ".$select." as reservationnumber, getDocumentValue( CASE
  															 	WHEN d.documentid > '' THEN d.documentid 
																ELSE d.ID
																 END) as totalvalue
				FROM  ".$_SESSION['shoptype']."_document d
				$join 
				$sWhereDate
				$sValute
				$sOrder
				$sLimit
			";
		 }
		 
		 
		//echo $sQuery;
		$rResult = $mysqli->query($sQuery) or die();
		
		/* Data set length after filtering */
		$sQuery = "
			SELECT FOUND_ROWS()
		";
		$rResultFilterTotal = $mysqli->query( $sQuery ) or die($mysqli->error($conn));
		$aResultFilterTotal = $rResultFilterTotal->fetch_array();
		$iFilteredTotal = $aResultFilterTotal[0];
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.")
			FROM  ".$_SESSION['shoptype']."_document
		";
		$rResultTotal = $mysqli->query( $sQuery ) or die(mysqli_error($conn));
		$aResultTotal = $rResultTotal->fetch_array();
		$iTotal = $aResultTotal[0];
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		$i = $_POST['start']+1;
		while ( $aRow = $rResult->fetch_assoc() )
		{
			$row = array();
	
			if($_POST['doctype'] == 'e'){	
				//$a = User::getBillForReservation($aRow['documentid']);
				$row[0] = 'rezervacija';		// tip dokmenta
				$row[1] = $aRow['number'];		//	broj dokumenta
				$row[2] = date("d.m.Y", strtotime($aRow['documentdate']));		//	datum
				$row[3] = ($aRow['status'] == 'p')? 'proknjizen':'neproknjizen';		//	status
				$row[4] = '';		//	racuni
				$row[99] = $aRow['ID'];
			}
			if($_POST['doctype'] == 'p'){	
				$row[0] = 'povrat robe';		// tip dokmenta
				$row[1] = $aRow['number'];		//	broj dokumenta
				$row[2] = $aRow['documentdate'];		//	datum
				$row[3] = ($aRow['status'] == 'p')? 'proknjizen':'neproknjizen';		//	status
				$row[99] = $aRow['ID'];
			}
			if($_POST['doctype'] == 'r'){
				
				$valutediff = time() - strtotime($aRow['valutedate']);
				
				$row[0] = 'racun';		// tip dokmenta
				$row[1] = $aRow['number'];		//	broj dokumenta
				$row[2] = $aRow['documentdate'];		//	datum
				$row[3] = $aRow['totalvalue'];		//	vrednost	
				
				$inout = floor($valutediff / (60 * 60 * 24))*(-1);
				$inoutclass = 'red';
				if($inout > 0) $inoutclass = 'green';
				
				$row[4] = $aRow['valutedate']." ( <b class='".$inoutclass."'>".$inout."</b> ) ";		//	valuta				
				$row[5] = $aRow['reservationnumber'];		//	rezervacija
				
				$row[99] = $aRow['documentid'];
			}
			if($_POST['doctype'] == 'k'){	
				$row[0] = 'povrat robe';		// tip dokmenta
				$row[1] = $aRow['number'];		//	broj dokumenta
				$row[2] = $aRow['documentdate'];		//	datum
				$row[3] = ($aRow['status'] == 'p')? 'proknjizen':'neproknjizen';		//	status
				$row[99] = $aRow['documentid'];
			}
			if($_POST['doctype'] == 'z'){	
				$row[0] = 'povrat robe';		// tip dokmenta
				$row[1] = $aRow['number'];		//	broj dokumenta
				$row[2] = $aRow['documentdate'];		//	datum
				$row[3] = ($aRow['status'] == 'p')? 'proknjizen':'neproknjizen';		//	status
				$row[99] = $aRow['documentid'];
			}
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );	
		
	}

	public static function updateUserLogData($userid){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		$q = "INSERT INTO `userlogdata`(`userid`, `login_count`, `ts`) VALUES (".$userid.", 1, CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `ts` = CURRENT_TIMESTAMP";
		$mysqli->query($q);

		return 1;		
	}	
		
}

?>