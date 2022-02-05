<?php

ini_set('display_errors', true);
error_reporting(E_ALL);


//echo getcwd() . "\n";
//var_dump($_SERVER['DOCUMENT_ROOT']. "\n");
require_once($_SERVER['DOCUMENT_ROOT'].'/admin/lib/nusoap.php');
//require_once('../lib/nusoap.php');
$errorSOAP  = '';

function GetFileDataForUpdateResult($file_name){
	$errorSOAP  = '';
	$result = '';
	
	//$wsdl = "http://localhost:8888/php-webservices/webservice-server.php?wsdl";
	$wsdl = "http://mastersystem.softart.rs/services/masterserver.php?wsdl";
	$filename = trim($file_name);
	if(!$filename){
		$errorSOAP = 'FILENAME cannot be left blank.';
	}

	if(!$errorSOAP){
			//create client object
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			$errorSOAP = '<h2>Constructor error</h2>' . $err;
				// At this point, you know the call that follows will fail
			exit();
		}
		try {
			$result = $client->call('getFileDataForUpdate', array($filename));
				//$result = json_decode($result);
		}catch (Exception $e) {
			$errorSOAP = 'Caught exception: '.  $e->getMessage(). "\n";
		}
	}
	return base64_decode(json_decode($result));
}




?>
