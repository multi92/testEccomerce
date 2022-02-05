<?php

$class_version["emailtemplate"] = array('module', '1.0.0.0.1', 'Nema opisa');

class EmailTemplate
{

    public static function restartPass($data){
        $message = "Ako ste zahtevali promenu vase lozinke, kliknite na link ispod.<br /> ";
        $message .= $data."<br /><br />";
        $message .= "Ako vi niste zahtevali promenu vase lozinke, ignorisite ovaj mail.";
        return $message;
    }
    public static function newPass($data){
        $message = "Vasa lozinka je usposno promenjena..<br /> ";
        $message .= "Vasa nova lozinka je: ".$data."<br /><br />";
        return $message;
    }
    public static function potvrdaEmaila($data){
        $message = "Postovani, da bi ste zavrsili registraciju naloga potrebno je da potvrdite vas Email klikom na link ispod<br /><br /> ";
        $message .= $data."<br /><br />";
		$message .= "Ukoliko zelite da kupujete kao B2B korisnik (partner) molimo Vas da nas kontaktirate.<br />";
        return $message;
    }
    public static function contact($data){
        $msg = $data['message']."\r\n\n<br/><br/>";
        $msg .= "Poslao: ".$data['name']." \r\n\n<br/>";
        $msg .= "Mail: ".$data['mail']."\r\n\n<br/>";
		if(strlen($data['phone'])>0){
			$msg .= "Telefon: ".$data['phone']."\r\n\n<br/><br/>";
		}
        $msg .= "---User information--- \r\n <br/>"; //Title
        $msg .= "IP adresa : ".$_SERVER["REMOTE_ADDR"]."\r\n<br/>"; //Sender's IP
        $msg .= "Pretrazivac : ".$_SERVER["HTTP_USER_AGENT"]."\r\n<br/>"; //User agent

        return $msg;
    }
	public static function newRegistration($data){
        $message = "Novi korisnik se registrovao <br /><br /> ";
        $message .= $data."<br />";
        return $message;
    }
}