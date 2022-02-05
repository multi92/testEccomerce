<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
#include("plugins/action.birthday.php");
include("../app/configuration/system.configuration.php");

include("../app/class/core/Session.php");
include("../app/class/core/Database.php");
include("../app/class/core/EmailTemplate.php");
include("../app/class/core/GlobalHelper.php");
include("../app/class/core/User.php");



#function send birthtday mail -pogledati kako da se 
function sendBirthdayMail($to,$from,$name,$surname){
	$body = "Postovani/a ".$name." ".$surname." <br  /><br />";
	$body.="Srecan Vam rodjendan. Zelimo Vam puno uspeha na svim zivotnim poljima <br /> Vas Breze";
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        <title>Breze</title>
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

 #modify in picture!
function sendBirthdayVoucher($to,$from,$putanjaSlike){
	$subject = "Srećan rođendan";
	$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        <title>Breze</title>
                    </head>
                    <body> <img border="0" src='.$putanjaSlike.'
                    </body>
                     </html>';
    $headers = 'MIME-Version: 1.0' . "\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\n";
	$headers .= "From: ".$from;
    if(mail($to,$subject,$body,$headers)){
    	return true;
    }
    else{
    	return false;
    }

}


#for generating action for birthday code!
function generateRandomCode(){
    $chars ="abcdefghijklmnopqrstuwxzy0123456789*/-#";
	
	$charsLen = strlen($chars);
	$randomString ='';
	for($i=0;$i<15;$i++){
		$randomString.=$chars[rand(0,$charsLen-1)];
	}

	return $randomString;


}

function birthday(){
	$db = Database::getInstance();
	$mysqli = $db->getConnection();
	$mysqli->set_charset("utf8");
	$query = "SELECT u.* FROM user AS u WHERE u.birthday IS NOT NULL AND DAY(u.birthday)=DAY(NOW()) AND MONTH(u.birthday)=MONTH(NOW())";
	//echo $query; 
	$res =$mysqli->query($query);
	if($res->num_rows>0){
		$information =array();
		while ($row = $res->fetch_assoc()) {
			array_push($information,$row['email']."/".$row['name']."/".$row['surname']);
		}

		foreach ($information as $key=>$value) {
			$personInformation = explode("/", $value);
			$mailNew = sendBirthdayMail($personInformation[0],"marko.djordjevic@softart.rs",$personInformation[1],$personInformation[2]);
			if ($mailNew){
				echo "Poslat je mejl";
			}
			else{
				echo "Mejl nije poslat";
			}
		}
	} else {
		echo "Danas nema slavljenika.";
	}
}


birthday();


?>