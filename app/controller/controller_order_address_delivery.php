<?php

if(isset($_SESSION['shopcart']) && !empty($_SESSION['shopcart'])){
	$logged = false;
	if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged'){
		$logged = true;
	}
	include($system_conf["theme_path"][1]."views/order_address_delivery.php");
}
else{
	echo "<script>window.location = 'pocetna'; </script>";
}
	
?>