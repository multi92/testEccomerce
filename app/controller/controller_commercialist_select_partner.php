<?php
if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged" && isset($_SESSION["shoptype"]) && $_SESSION["shoptype"]=="b2b"){ 
    include_once("app/class/core/User.php");
	include_once("app/class/Partner.php");
	
	$userdata=User::getUserData($_SESSION['id']);
	
	$partnerdata=Partner::getPartnerData($userdata["partnerid"]);
	
	include($system_conf["theme_path"][1]."views/commercialist_select_partner.php");
} else {
	include("views/pageSessionExpired.php");	
}



?>