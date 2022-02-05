<?php
	if(isset($_SESSION['loginstatus']))
	{
		require_once("app/class/core/User.php");
		
		$page = 1;
		if(isset($_GET['p']) && $_GET['p'] != ""){
			$page = $_GET['p'];	
		}
		
		$userdata = User::getUserData($_SESSION['id']);
		$partnerdata = User::getCurrentPartnerData();
		if($_SESSION['shoptype']=='b2c'){
			$order = User::getUserCard($_SESSION['email'], 'e',$page, 15);
			
			$bill = User::getUserDocuments($_SESSION['email'], 'r', $page, 15 );
		}
		if($_SESSION['shoptype']=='b2b'){
			$order = User::getPartnerCard($_SESSION['partnerid'], 'e',$page, 15);
			
			$bill = User::getPartnerDocuments($_SESSION['partnerid'], 'r', $page, 15 );	
		}
		
		
		//var_dump(User::getPartnerCard($_SESSION['partnerid'], 'e',$page, 10));
		//User::getPartnerCard($_SESSION['partnerid'], 'e',1, 40);
		
		include($system_conf["theme_path"][1]."views/userpanel.php"); 
		//include("views/userpanel.php");
	}else{
		echo "<script>
			window.location = 'pocetna';
		</script>";	
	}	

?>