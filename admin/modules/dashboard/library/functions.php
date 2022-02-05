<?php

include("../../../config/db_config.php");
include("../../../config/config.php");
session_start();
mb_internal_encoding("UTF-8");
if (isset($_POST['action']) && $_POST['action'] != "") {
    switch ($_POST['action']) {
        case "addmodule" : addmodule(); break;
		case "checkupdates" : check_updates(); break;
		case "updatesystem" : updateSystem(); break;
    }
}

function addmodule()
{
	global $conn;
	
	if(!file_exists("../../".strtolower($_POST['name']))){
		$pathroot = "../../";
		$moduleroot = $pathroot.strtolower($_POST['name']);
		
		mkdir($pathroot.strtolower($_POST['name']), 0700);
		
		mkdir($moduleroot.'/css', 0700);
		mkdir($moduleroot.'/js', 0700);
		mkdir($moduleroot.'/library', 0700);
		mkdir($moduleroot.'/view', 0700);
		
		/*	ROOT	*/
		
		$f = fopen($moduleroot.'/config.php', 'w');
		fwrite($f, '<?php '.PHP_EOL.'	$javascript = array(\'config.js\', \'functions.js\', \'script.js\');'.PHP_EOL.'	$javascriptplugins = array();'.PHP_EOL.'	$css = array(\'style.css\');'.PHP_EOL.'	$cssplugins = array();'.PHP_EOL."?>");
		fclose($f);
		
		$f = fopen($moduleroot.'/index.php', 'w');
		fwrite($f, '<?php '.PHP_EOL.'	include(\'view/home.php\');'.PHP_EOL."include('view/templates.php');".PHP_EOL."?>");
		fclose($f);
		
		/*	CSS		*/
		
		$f = fopen($moduleroot.'/css/style.css', 'w');
		fclose($f);
		
		/*	JS	*/
		
		$f = fopen($moduleroot.'/js/config.js', 'w');
		fwrite($f, 'var moduleName = "'.$_POST['name'].'";');
		fclose($f);
		
		$f = fopen($moduleroot.'/js/functions.js', 'w');
		fclose($f);
		
		$f = fopen($moduleroot.'/js/script.js', 'w');
		$data = '';
		
		
		$data .= 'function resetForm(){'.PHP_EOL.PHP_EOL;
		$data .= '}'.PHP_EOL;
		$data .= 'function showLoadingIcon(){'.PHP_EOL;
		$data .= '	$(".loadingIcon").removeClass("hide");	'.PHP_EOL;
		$data .= '}'.PHP_EOL;
		$data .= 'function hideLoadingIcon(){'.PHP_EOL;
		$data .= '	$(".loadingIcon").addClass("hide");	'.PHP_EOL;
		$data .= '}'.PHP_EOL;
		$data .= '$(document).ready(function (e) {'.PHP_EOL;
		$data .= '});'.PHP_EOL;
		
		fwrite($f, $data);
		fclose($f);
		
		/*	LIBRARY		*/
		
		$f = fopen($moduleroot.'/library/functions.php', 'w');
		$data = '';
		
		$data .= '<?php'.PHP_EOL;
		$data .= '	include("../../../config/db_config.php");'.PHP_EOL;
		$data .= '	include("../../../config/config.php");'.PHP_EOL;
		$data .= '	include("../../userlog.php");'.PHP_EOL;
		$data .= '	session_start();'.PHP_EOL;
		$data .= '	mb_internal_encoding("UTF-8");'.PHP_EOL;
		$data .= '	if (isset($_POST[\'action\']) && $_POST[\'action\'] != "") {'.PHP_EOL;
		$data .= '		switch ($_POST[\'action\']) {'.PHP_EOL;
		$data .= '			// case "demo" : demo(); break;'.PHP_EOL;
		$data .= '		}'.PHP_EOL;
		$data .= '	}'.PHP_EOL;
		$data .= '?>';
		
		fwrite($f, $data);
		fclose($f);
		
		/*	VIEW	*/
		
		$f = fopen($moduleroot.'/view/home.php', 'w');
		$data = '';
		
		$data .= '<div class="content-wrapper">'.PHP_EOL;
		$data .= '	<section class="content-header">'.PHP_EOL;
		$data .= '		<h1>'.PHP_EOL;
		$data .= '			'.ucfirst($_POST['showname']).''.PHP_EOL;
		$data .= '		</h1>'.PHP_EOL;
		$data .= '		<ol class="breadcrumb">'.PHP_EOL;
		$data .= '			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>'.PHP_EOL;
		$data .= '			<li class="active"> '.ucfirst($_POST['showname']).'</li>'.PHP_EOL;
		$data .= '		</ol>'.PHP_EOL;
		$data .= '	</section>'.PHP_EOL;
		$data .= '	<!-- Main content -->'.PHP_EOL;
		$data .= '	<section class="content">'.PHP_EOL;
		$data .= ''.PHP_EOL;
		$data .= '		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>'.PHP_EOL.PHP_EOL;
		$data .= '	</section>'.PHP_EOL;
		$data .= '	<!-- /.content -->'.PHP_EOL;
		$data .= '</div>'.PHP_EOL;
		fwrite($f, $data);
		fclose($f);
		
		$f = fopen($moduleroot.'/view/templates.php', 'w');
		fclose($f);
		
		$query = "INSERT INTO `adminmoduls`(`id`, `name`, `showname`, `menivisible`, `pagevisible`, `icon`, `ts`) VALUES ('', '".$_POST['name']."', '".$_POST['showname']."', ".$_POST['menivisible'].", ".$_POST['pagevisible'].", '".$_POST['icon']."', CURRENT_TIMESTAMP) ";	
		mysqli_query($conn, $query);
				
		echo '0';	
	}
	else{
		echo '1';	
	}
}



function check_updates(){

	


global $conn;

	$has_new_version=0;
	//GET ALL CLASS INFO
	$vq = "SELECT * FROM system_version WHERE type='class' ";
	//echo $vq;
	$vres = mysqli_query($conn, $vq);
	//echo 'update';
	while($vrow = mysqli_fetch_assoc($vres))
	{
		//var_dump($key);
		global $master_conn;
		$q = "SELECT version FROM system_version WHERE type='class' AND name='".$vrow["name"]."' ";
		//echo $q;
		$res = mysqli_query($master_conn, $q);
		$row = mysqli_fetch_assoc($res);
		//echo($row['version']."=".$val[1]."------------------------");
		if($vrow["version"]!=$row['version']){
			$has_new_version++;
			//echo($key."----->>>>>>".$row['version']."=".$val[1]."------------------------");
		}
	}
	//echo $has_new_version;
	//var_dump($class_version);
	if($has_new_version==0){
		echo '1';
	} else {
		echo '0';
	}
	
	//return 1;
	/*global $conn;
	
	$q = "SELECT name FROM adminmoduls WHERE id =".$_POST['id'];
	$res = mysqli_query($conn, $q);
	$row = mysqli_fetch_assoc($res);
	
	delTree('../../'.$row['name']);
	
	$q = "DELETE FROM adminmoduls WHERE id = ".$_POST['id'];
	mysqli_query($conn, $q);*/
}

function updateSystem(){

	$systemUpdated=0;

	//Update Database
	//Update Config
	//Update Class
	$systemUpdated=$systemUpdated+updateSystemClass();
	//Update Controller
	//Update Modules
	
	if($systemUpdated==0){
		echo '1';
	} else {
		echo '0';
	}
	
}

function updateSystemClass(){
	//echo 'test';
	//$rollback_dir="_ROLLBACK";
	////CALL SERVICE//////////////////////////////////////////////////////////////
	//echo getcwd() . "\n";
	require_once('../../../services/servicesMaster.php');
	//echo 'test1';
	//////////////////////////////////////////////////////////////////////////////
	////LOAD INFO INTO $class_version/////////////////////////////////////////////
	/*require_once('../../../../app/class/core/Database.php');
	require_once('../../../../app/class/core/EmailTemplate.php');
	require_once('../../../../app/class/core/GlobalHelper.php');
	require_once('../../../../app/class/core/Log.php');
	require_once('../../../../app/class/core/OrderingHelper.php');
	require_once('../../../../app/class/core/PostRequestHandler.php');
	require_once('../../../../app/class/core/Router.php');
	require_once('../../../../app/class/core/User.php');
	require_once('../../../../app/class/Brend.php');
	require_once('../../../../app/class/Category.php');
	require_once('../../../../app/class/DeliveryService.php');
	require_once('../../../../app/class/Documents.php');
	require_once('../../../../app/class/Gallery.php');
	require_once('../../../../app/class/GalleryItem.php');
	require_once('../../../../app/class/Invoice.php');
	require_once('../../../../app/class/Javne.php');
	require_once('../../../../app/class/Konkursi.php');
	require_once('../../../../app/class/News.php');
	require_once('../../../../app/class/NewsCategory.php');
	require_once('../../../../app/class/Partner.php');
	require_once('../../../../app/class/Person.php');
	require_once('../../../../app/class/Product.php');
	require_once('../../../../app/class/Search.php');
	require_once('../../../../app/class/Shop.php');
	require_once('../../../../app/class/ShopHelper.php');
	require_once('../../../../app/class/Slider.php');
	require_once('../../../../app/class/SliderItem.php');*/
	////END LOAD INFO INTO $class_version/////////////////////////////////////////
	////LOAD INFO FROM DATABASE 
	//echo 'funkcija';
	global $conn;

	$has_new_version=0;
	//GET ALL CLASS INFO
	$vq = "SELECT * FROM system_version WHERE type='class' ";
	//echo $vq;
	$vres = mysqli_query($conn, $vq);
	//echo 'update';
	while($vrow = mysqli_fetch_assoc($vres))
	{
		$rollback_dir="";
		global $master_conn;
		$q = "SELECT name, version FROM system_version WHERE type='class' AND name='".$vrow["name"]."' ";
		//echo $q;
		$res = mysqli_query($master_conn, $q);
		$row = mysqli_fetch_assoc($res);
		if($vrow["version"]!=$row['version']){
			$has_new_version++;
			$filename=$row['name'];
			$result= GetFileDataForUpdateResult($filename,'class');
			//echo $result;
			//fileInfo = new FileInfo("../../../../".$vrow["path");
			//$rollback_path="../../../../".$vrow["path"];
			$currentFolder= dirname($_SERVER['DOCUMENT_ROOT'].'/'.$vrow["path"]);
			//var_dump($currentFolder);
			$rollback_dir=$currentFolder."/"."_ROLLBACK";
			
			if(!file_exists($rollback_dir)){
				mkdir($rollback_dir);

			}
			//echo $_SERVER['DOCUMENT_ROOT'].'/'.$vrow["path"];
			//echo $rollback_dir."/".$vrow['showname'].".php";
			$fileForEdit=$_SERVER['DOCUMENT_ROOT'].'/'.$vrow["path"];
			//proveriti verziju fajla i da li fajl postoji;
			//if(!file_exists($rollback_dir)){
			if(copy($fileForEdit, $rollback_dir."/".$vrow['showname']."_".$vrow['version'].".php")){
				$fileE = fopen($fileForEdit,'w'); // Open and truncate the file
				fwrite($fileE, $result);
				fclose($fileE);
				//izvrsiti update baze 
			}
			//echo "<pre>";
			//echo $result;
			//echo "</pre>";
			//}


			
		}
	}
	////END LOAD INFO FROM DATABASE
	/*$has_new_version=0;

	foreach ($class_version as $key => $val) {
		//var_dump($key);
		global $master_conn;
		$q = "SELECT name, version FROM system_version WHERE type='class' AND name='".$key."' ";
		//echo $q;
		$res = mysqli_query($master_conn, $q);
		$row = mysqli_fetch_assoc($res);
		//echo($row['version']."=".$val[1]."------------------------");
		if($val[1]!=$row['version']){
			$has_new_version++;
			$filename=$row['name'].'_'.$row['version'].'.php';
			$result= GetFileDataForUpdateResult($filename,'class');


			if (!is_dir($dir)) {
			    mkdir($dir);         
			}






			//echo($key."----->>>>>>".$row['version']."=".$val[1]."------------------------");
		}
	}*/
	//echo $has_new_version;
	//var_dump($class_version);
	if($has_new_version==0){
		echo '1';
	} else {
		echo '0';
	}
	
	return 0;
	/*global $conn;
	
	$q = "SELECT name FROM adminmoduls WHERE id =".$_POST['id'];
	$res = mysqli_query($conn, $q);
	$row = mysqli_fetch_assoc($res);
	
	delTree('../../'.$row['name']);
	
	$q = "DELETE FROM adminmoduls WHERE id = ".$_POST['id'];
	mysqli_query($conn, $q);*/
}


?>