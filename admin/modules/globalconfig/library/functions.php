<?php

include("../../../config/db_config.php");
include("../../../config/config.php");
include("../../userlog.php");
session_start();
mb_internal_encoding("UTF-8");
if (isset($_POST['action']) && $_POST['action'] != "") {
    switch ($_POST['action']) {
        case "saveUserConf" : saveUserConf($_POST['itemdata']); break;
        case "saveGoogleAnalyticsConf" : saveGoogleAnalyticsConf($_POST['config']); break;
        case "saveFacebookPixelConf" : saveFacebookPixelConf($_POST['config']); break;
        case "saveThemeConf" : saveThemeConf($_POST['itemdata']); break;
		case "checklanguagecode" : checkLanguageCode($_POST['code']); break;
		case "addlanguage" : add_language(); break;
		case "deletelanguage" : delete_language($_POST['id']); break;
		case "changecurrencystatus" : change_currency_status(); break;
		case "changecurrencyprimary" : change_currency_primary(); break;
		case "updatecurrencysort" : update_currency_sort(); break;
		case "updatecurrencyvalue" : update_currency_value(); break;
		case "deletecurrency" : delete_currency($_POST['id']); break;
		case "saveTawkToConf" : saveTawkToConf($_POST['config']); break;
    }
}

function addlanguagefile(){
		
}

function addlanguage($data){
	global $conn;
	include($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");
	
	if(isset($data['code']) || $data['code'] != '' || isset($data['name']) || $data['name'] != '' || isset($data['shortname']) || $data['shortname'] != '')	
	{
		$q = "INSERT INTO `languages`(`code`, `name`, `shortname`, `default`, `flag`) VALUES ('".mysqli_real_escape_string($conn, $data['code'])."',
				'".mysqli_real_escape_string($conn, $data['name'])."',
				'".mysqli_real_escape_string($conn, $data['shortname'])."','n', '".mysqli_real_escape_string($conn, $data['flag'])."')";
		$res = mysqli_query($conn, $q);
		$lastid = mysqli_insert_id($conn);		
		
		/*	Create lang files	*/
		
		
		copy($_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$rowl['code'].'.php', $_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$data['code'].'.php');
		
		$q = "SHOW TABLES LIKE '%\_tr'";
		$res = mysqli_query($conn,$q);
		if(mysqli_num_rows($res) > 0){
			while($row = $res->fetch_array()){
				if($row[0] == "attr_tr")
				{
					$q = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$row[0]."'";
					$resc = mysqli_query($conn, $q);
					
					$columns = array();
					$columns_value = array();
					$langid = $data['langid'];		
					while($rowc = mysqli_fetch_assoc($resc)){
						if($rowc['COLUMN_NAME'] == substr($row[0], 0, -3)."id") continue;
						if($rowc['COLUMN_NAME'] == 'langid') continue;
						if($rowc['COLUMN_NAME'] == 'ts') continue; 
						
						array_push($columns, '`'.$rowc['COLUMN_NAME'].'`');	
						if(!isset($data['langid']) || (isset($data['langid']) && $data['langid'] == 0)){
							/*	empty fields	*/
							array_push($columns_value, '""');
							
							/*	copy file from default lang	*/
							$qq = "SELECT id, code FROM languages WHERE `default` = 'y'";
							$resl = mysqli_query($conn, $qq);
							$rowl = mysqli_fetch_assoc($resl);
							$langid = $rowl['id'];
							copy($_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$rowl['code'].'.php', $_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$data['code'].'.php');
							$file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$data['code'].'.php');
							$file = preg_replace ('/= {0,1}"(.*?)";/i', '= "";', $file);
							file_put_contents($_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$data['code'].'.php', $file);
							
						}else{
							/*	selected lang	*/
							array_push($columns_value, '`'.$rowc['COLUMN_NAME'].'`');
							$qq = "SELECT id, code FROM languages WHERE `id` = ".$data['langid'];
							$resl = mysqli_query($conn, $qq);
							$rowl = mysqli_fetch_assoc($resl);
							
							copy($_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$rowl['code'].'.php', $_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$data['code'].'.php');
							
							$langid = $rowl['id'];
						}
					}
					
					$q = 'INSERT INTO `'.$row[0].'`(`'.substr($row[0], 0, -3)."id".'`, `langid`, '.implode(',', $columns).') SELECT `'.substr($row[0], 0, -3)."id".'`, '.$lastid.', '.implode(',', $columns_value).' FROM '.$row[0].' WHERE langid = '.$langid;
					
					if(mysqli_query($conn, $q)){
						return 'success';	
					}
				}
			}
		}
	}
	else{
		return "Error - missing minimal parametars!";	
	}
}


function delete_language($langid = ''){
		global $conn;
		include($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");
		if($langid != '')
		{
			$qq = "SELECT id, code FROM languages WHERE `id` = ".$langid;
			$resl = mysqli_query($conn, $qq);
			$rowl = mysqli_fetch_assoc($resl);
			
			$qq = 'DELETE FROM languages WHERE id = '.$langid;
			if(mysqli_query($conn, $qq)){
				/*	delete theme lang file	*/
				unlink($_SERVER['DOCUMENT_ROOT'].'/'.$system_conf["theme_path"][1].'lang/'.$rowl['code'].'.php');
				
				$q = "SHOW TABLES LIKE '%\_tr'";
				$res = mysqli_query($conn,$q);
				if(mysqli_num_rows($res) > 0){
					while($row = mysqli_fetch_array($res)){
						if($row[0] == "attr_tr")
						{						
							$q = 'DELETE FROM `'.$row[0].'` WHERE langid = '.$langid;
							if(mysqli_query($conn, $q)){
								return 'success';	
							}
						}
					}
				}	
			}
		}
	}


function change_currency_status(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			
			$query = "UPDATE `currency` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);	
			
			$t = userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "Changed Currency Status");
			
		}
	}

function change_currency_primary(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			
			$query = "UPDATE `currency` SET `primary`='n' ";
			mysqli_query($conn, $query);
			$query = "UPDATE `currency` SET `primary`='".$_POST['primary']."' WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);	
			
			$t = userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "Changed Primary Currency ");
			
		}
	}

function update_currency_sort(){
		global $conn;
		$q = "UPDATE currency SET sort = ".$_POST['value']." WHERE id =".$_POST['id'];	
		mysqli_query($conn, $q);
	}

function update_currency_value(){
		global $conn;
		$q = "UPDATE currency SET mainvalue = ".$_POST['value']." , mainvaluets = CURRENT_TIMESTAMP() WHERE id =".$_POST['id'];	
		mysqli_query($conn, $q);
	}

function delete_currency($curid = ''){
		global $conn;
		
		if($curid != '')
		{
			
			
			$qq = 'DELETE FROM currency WHERE id = '.$curid;
			$resl = mysqli_query($conn, $qq);
			$qq = 'DELETE FROM currency_tr WHERE currencyid = '.$curid;
			$resl = mysqli_query($conn, $qq);
			return 'success';	
			
		}
	}

function saveUserConf($data)
{
	include("../../../../app/configuration/system.configuration.php");

	$handle = "../../../../".$system_conf["theme_path"][1]."config/user.configuration.php";
	$f = fopen($handle, 'w');
	
	$out = '<?php '. PHP_EOL;
	$out .= '$user_conf = array();'.PHP_EOL;
	foreach(json_decode($data) as $k=>$v){
		
		$out .= '$user_conf["'.$k.'"] = array(\''.$v[0].'\', \''.$v[1].'\', \''.$v[2].'\');'. PHP_EOL;		
	}
	$out .= '?>';
	
	if(fwrite($f, $out)){
		echo 1;	
	}
    fclose($f);

}






function saveThemeConf($data)
{
	include("../../../../app/configuration/system.configuration.php");

	$handle = "../../../../".$system_conf["theme_path"][1]."config/theme.configuration.php";
	$f = fopen($handle, 'w');
	
	$out = '<?php '. PHP_EOL;
	$out .= '$theme_conf = array();'.PHP_EOL;
	foreach(json_decode($data) as $k=>$v){
		
		$out .= '$theme_conf["'.$k.'"] = array(\''.$v[0].'\', \''.$v[1].'\', \''.$v[2].'\');'. PHP_EOL;		
	}
	$out .= '?>';
	
	if(fwrite($f, $out)){
		echo 1;	
	}
    fclose($f);

}

function saveGoogleAnalyticsConf($data)
{
	include("../../../../app/configuration/system.configuration.php");

	$handle = "../../../../".$system_conf["theme_path"][1]."config/googleanalytics.configuration.php";
	$f = fopen($handle, 'w');
	
	$out = json_decode($data). PHP_EOL;
	
	if(fwrite($f, $out)){
		echo 1;	
	}
    fclose($f);

}

function saveFacebookPixelConf($data)
{
	include("../../../../app/configuration/system.configuration.php");

	$handle = "../../../../".$system_conf["theme_path"][1]."config/facebookpixel.configuration.php";
	$f = fopen($handle, 'w');
	
	$out = json_decode($data). PHP_EOL;
	
	if(fwrite($f, $out)){
		echo 1;	
	}
    fclose($f);

}

function saveTawkToConf($data)
{
	include("../../../../app/configuration/system.configuration.php");

	$handle = "../../../../".$system_conf["theme_path"][1]."config/tawkto.configuration.php";
	$f = fopen($handle, 'w');
	
	$out = json_decode($data). PHP_EOL;
	
	if(fwrite($f, $out)){
		echo 1;	
	}
    fclose($f);

}

function checkLanguageCode($code){
	global $conn;
	
	$q = "SELECT * FROM languages WHERE code like '".$code."'";
	$res = mysqli_query($conn, $q);
	if(mysqli_num_rows($res) > 0){
		echo json_encode(array('1'));
	}else{
		echo json_encode(array('0'));
	}
}

function add_language(){
	global $conn;	
	
	echo json_encode(array(addlanguage(array("code"=>$_POST['code'], "shortname"=>$_POST['shortname'], "name"=>$_POST['name'], ""=>$_POST['flag'], "langid"=>$_POST['values'])) ));
}


?>