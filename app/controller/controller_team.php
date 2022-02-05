<?php
	include("app/class/Person.php");
	
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];
	}

	$persons=Person::getAllPersons($page, $theme_conf["team_members_per_page"][1]);
	
	if($theme_conf["show_all_team_members"][1] != 1){//ako je u user conf podeseno da ne prikazuje sve galerije
			$pagination = GlobalHelper::paging($page, $persons[0], $theme_conf["team_members_per_page"][1]);
	}

    include($system_conf["theme_path"][1]."views/team.php");
?>