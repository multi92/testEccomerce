<?php
	define("BASE_URL", "http://rs2101.softart.rs/");
	define("BASE_PATH", $_SERVER['DOCUMENT_ROOT']);
	define("BASE_SUBPATH", "");
	define("HOME_PAGE", "pocetna");
	
	
	define("DB_HOST", "mysql531.loopia.se");
	define("DB_NAME", "softart_rs_db_17");
	define("DB_USER", "user@s59747");
	define("DB_PASS", "lR5WTRKrR4");
	
	
	$system_conf = array();
	//SYNHRONIZER
	$system_conf["sync"] = array('Synchronization', '0', '1 - ON , 0 - OFF'); //DEFINISANO
	/*THEME PATH*/
	$system_conf["theme_path"] = array('Theme', 'content/themes/saMagneto/', 'Putanja do aktivne teme.'); //DEFINISANO
	/*DEFAULT SYSTEM LANGUAGE*/
	$system_conf["default_lang"] = array('DEFAULT LANGUAGE', '1', 'default language');//DEFINISANO
	
	/*SYSTEM*/
	$system_conf["site_in_progress"] = array('SYSTEM', '0', 'System in test mode , 0 - false, 1 - true'); //DEFINISANO
	$system_conf["developer_mode"] = array('SYSTEM', '0', 'System in developer mode , 0 - false, 1 - true'); //DEFINISANO
	$system_conf["system_b2c"] = array('SYSTEM', '1', 'System b2c flag, 0 - b2c=false, 1 - b2c=true');//DEFINISANO
	$system_conf["system_b2b"] = array('SYSTEM', '1', 'System b2b flag, 0 - b2b=false, 1 - b2b=true');//DEFINISANO
	$system_conf["system_commerc"] = array('SYSTEM', '1', 'System commerc flag, 0 - commerc=false, 1 - commerc=true');//DEFINISANO
	


	/*CONTACT MAP*/
	$system_conf["show_map"] = array('Contact map', '1', 'Map settings show=1, hide=0'); //REDEFINISATI U THEME CONFIG
	$system_conf["map_external_link"] = array('Contact map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDAh8ErsrnyWl1uwDutvLWJd4JSRjaY5po', 'Map external link'); //REDEFINISATI U THEME CONFIG
	$system_conf["map_zoom"] = array('Contact map', '14', 'ZOOM'); //REDEFINISATI U THEME CONFIG
	$system_conf["map_latitude"] = array('Contact map', '43.32387', 'Map latitude'); //REDEFINISATI U THEME CONFIG  43.32387,21.8902859
	$system_conf["map_longitude"] = array('Contact map', '21.8902859', 'Map longitude'); //REDEFINISATI U THEME CONFIG
	$system_conf["pointer_latitude"] = array('Contact map', '43.32387', 'Pointer latitude');//REDEFINISATI U THEME CONFIG
	$system_conf["pointer_longitude"] = array('Contact map', '21.8902859', 'Pointer longitude');//REDEFINISATI U THEME CONFIG
	
	$todo["map.php"] = array('System config', 'Uzeti u obzir vrednosti novih parametara $system_conf["show_map"]  i  $system_conf["map_zoom"]'); //TODO
	
	$system_conf["category_type"] = array('cat', '0', '0 - bez relacija, 1 - sa relacijama');    //DEFINISANO 
	
	$system_conf["news_category_type"] = array('cat', '0', '0 - bez relacija, 1 - sa relacijama'); //DEFINISANO

	
	//$b2bstr = "4,5";
	//$b2cstr = "4,5";

	//$b2barr = array(4,5);
	//$b2carr = array(4,5);


?>