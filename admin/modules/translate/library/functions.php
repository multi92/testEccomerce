<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "savefile" : save_file(); break;
		}
	}
	
	
	function save_file(){
		
		global $conn;
		$q = "SELECT * FROM languages";
		$res = mysqli_query($conn, $q);
		while($val = mysqli_fetch_assoc($res))
		{
			include("../../../../app/configuration/system.configuration.php");
			
			$handle = "../../../../".$system_conf["theme_path"][1]."lang/".$val['shortname'].".php";
			$f = fopen($handle, 'w');
			
			$out = '<?php '. PHP_EOL;
			$out .= '$language = array();'.PHP_EOL;
			
			$data = json_decode($_POST[$val['shortname']]);
			//----------------
			
			foreach($data as $key=>$value)
			{
				$out .= '$language["'.$value[0].'"]['.$value[1].'] = "'.htmlentities(nl2br($value[2])).'";'.PHP_EOL;	
			}
			
			//--------------------
			
			$out .= '?>';
				//var_dump($out);
			
			if(fwrite($f, $out)){
				echo 1;	
			}
			fclose($f);
			
		}


	
	}
	
?>