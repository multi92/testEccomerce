<?php
	include_once("app/class/Partner.php");
	
	    $page = 1;
		if(isset($_GET['p']) && $_GET['p'] != ""){
			$page = $_GET['p'];
		}
		$partners = Partner::GetPartnerList( $page, $theme_conf["partners_per_page"][1]);
		
		$partnertypes = Partner::GetPartnerTypeList();
		
		$partnertypepartners = Partner::GetPartnerTypePartnerList();
 
		if($theme_conf["show_all_partners_list"][1] != 1){//ako je u user conf podeseno da ne prikazuje sve galerije
			$pagination = GlobalHelper::paging($page, $partners[0], $theme_conf["partners_per_page"][1]);
		}
	
	include($system_conf["theme_path"][1]."views/partneri.php");
	
?>