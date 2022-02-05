<?php
    include_once("app/class/core/User.php");
	include_once("app/class/Partner.php");
	
	$userdata=User::getUserData($_SESSION['id']);
	
	$partnerdata=Partner::getPartnerData($userdata["partnerid"]);
	
	include($system_conf["theme_path"][1]."views/update_personal_info.php");
?>