<?php //DEVELOPER MODE
$controller_version["header_commercialist_bar"] = array('controller', '1.0.0.0.1', 'SYSTEM THEME CONTROLLER','app/controller/core/controller_header_commercialist_bar.php');
?>
<?php
	include_once("app/class/Partner.php");	
	$commercialistpartnerinfo=array();
	$commercialistpartneraddressinfo=array();
	$commercialistpartnerinfo=Partner::getPartnerData($_SESSION['partnerid']);

	if(isset($_SESSION['partneraddressid']) && $_SESSION['partneraddressid']>0 ){
		$commercialistpartneraddressinfo=Partner::getPartnerAddressByPartnerAadressId($_SESSION['partnerid'],$_SESSION['partneraddressid']);
	}//var_dump($commercialistpartnerinfo['name']);

	include($system_conf["theme_path"][1]."views/includes/header_commercialist_bar.php");
?>