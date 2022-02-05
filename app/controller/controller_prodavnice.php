<?php
	require_once("app/class/Shop.php");

	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];
	}
	
	if(isset($command[1]) && $command[1] != ""){
		//var_dump(new Shop($command[1]));
	}
	else {
		//echo 'all shops <br>';
		$shops = Shop::getList($page, $user_conf['shops_per_page'][1]);
		//var_dump($shops['1']);
		if($user_conf["show_all_shops_list"][1] != 1){//ako je u user conf podeseno da ne prikazuje sve shopove u listi
			$pagination=(GlobalHelper::paging($page, $shops[0], $user_conf["shops_per_page"][1]));
		}
	
		//echo '<br> shops with city id 1';
		//$shops = Shop::getList($page, $user_conf['shops_per_page'][1], 1);
		//var_dump($shops['1']);
		//echo '<br> shops with tip "m"';
		//$shops = Shop::getList($page, $user_conf['shops_per_page'][1], false, 'm');
		//var_dump($shops['1']);
	}

	include($system_conf["theme_path"][1]."views/prodavnice.php");
?>