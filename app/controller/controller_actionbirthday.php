<?php 
$controller_version["actionBirthday"] = array('controller', '1.0.0.0.1', 'actionBirthday','app/controller/controller_actionbirthday.php');
?>

<?php
#include("app/class/core/Database.php");
#Global Helper.php
 function sendBirthdayMail($to,$from,$name,$surname){
	$body = "Postovani ".$name." ".$surname." <br  />";
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

$db = Database::getInstance();
$mysqli = $db->getConnection();
$mysqli->set_charset("utf8");

$query = "select * from user where birthday IS NOT NULL AND DAY(birthday)=DAY(NOW()) AND MONTH(user.birthday)=MONTH(NOW())";
$res =$mysqli->query($query);
$information =array();
while ($row = $res->fetch_assoc()) {
	array_push($information,$row['email']."/".$row['name']."/".$row['surname']);
}

#var_dump($email);
foreach ($information as $key=>$value) {
	var_dump($value);
	$personInformation = explode("/", $value);
	$sent ='0';
	#if($sent =='0'){
	#	$mailNew = sendBirthdayMail($personInformation[0],"marko.djordjevic@softart.rs",$personInformation[1],$personInformation[2]);
	#		if($mailNew){
	#			var_dump("Poslat je mail");
	#	
	#		}
	#		else{
	#			var_dump("Mejl nije ispravno poslat");
	#		}
	#	}
	#	$sent=1;
	}

?>