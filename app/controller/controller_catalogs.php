<?php //DEVELOPER MODE
$controller_version["catalogs"] = array('controller', '1.0.0.0.1', 'MUST BE DEFINED "catalogs_root_folder" PARAMETER in system.configuration file');
?>
<?php
	include("app/class/Documents.php");

	$command[0] = $user_conf["catalogs_root_folder"][1];
	$path = "".implode('/' ,$command);	
	
	if(Documents::isDirectoryValid(rawurldecode($path)))
	{
			
		$doc = Documents::getDirectory($path);
		
		$folders = $doc[0];
		$catalogs = $doc[1];
		include($system_conf["theme_path"][1]."views/catalogs.php");
	}
	/*else{
		//echo "404";	
	}*/
?>
