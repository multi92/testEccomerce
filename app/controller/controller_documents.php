<?php //DEVELOPER MODE
$controller_version["documents"] = array('controller', '1.0.0.0.1', 'MUST BE DEFINED "documents_root_folder" PARAMETER in user.configuration file');
?>
<?php
	include("app/class/Documents.php");

	$command[0] = $user_conf["documents_root_folder"][1];
	$path = "".implode('/' ,$command);	
	
	if(Documents::isDirectoryValid(rawurldecode($path)))
	{
			
		$doc = Documents::getDirectory($path);
		
		$folders = $doc[0];
		$files = $doc[1];
		include($system_conf["theme_path"][1]."views/documents.php");		
	}
	/*else{
		//echo "404";	
	}*/
?>