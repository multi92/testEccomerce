<?php


function parseCenovnikExcel($file, $type)
{
	require_once($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/app/class/core/Database.php");
	$db = Database::getInstance();
	$mysqli = $db->getConnection();
	$mysqli->set_charset("utf8");
	
	if($type == 'kimtec')
	{		
		error_reporting(E_ALL ^ E_NOTICE);
		/** Include path **/
		set_include_path($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'cdn/excel/Classes/');
 
		/** PHPExcel_IOFactory */
		require_once 'PHPExcel/IOFactory.php';
	   
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
			   
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		
		$sheetData = $objPHPExcel->setActiveSheetIndexByName('KIM TEC cenovnik')->toArray(null, true, false, true);
		
		preg_match("/EUR: ([0-9]*,[0-9]{1,3})/m",$sheetData[2]['L'], $exchangerate);
		$exchangerate = floatval(str_replace(",", ".", $exchangerate[1]));

		$values = array();
		foreach($sheetData as $key=>$val){
			if($key < 6 || $val['A'] == NULL) continue;
			array_push($values, '("'.$mysqli->real_escape_string($val['A']).'", "'.$mysqli->real_escape_string($val['F']).'", "'.$mysqli->real_escape_string(number_format($val['K']*$exchangerate, 2, ".",'')).'", "4", "'.(($val['L'] == 'M' || $val['L'] == 'L')? 1:0).'")');
		}
	}
	
	if($type == 'ewe')
	{		
		error_reporting(E_ALL ^ E_NOTICE);
		/** Include path **/
		set_include_path($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'cdn/excel/Classes/');
 
		/** PHPExcel_IOFactory */
		require_once 'PHPExcel/IOFactory.php';
	   
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
			   
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		
		$sheetData = $objPHPExcel->setActiveSheetIndexByName('ewe')->toArray(null, true, false, true);
		
		
		$values = array();
		foreach($sheetData as $key=>$val){
			if($val['C'] == NULL || $val['C'] == '' || $val['C'] == 'Ident')  continue;
			array_push($values, '("'.$mysqli->real_escape_string($val['C']).'", "'.$mysqli->real_escape_string($val['E']).'", "'.$mysqli->real_escape_string(str_replace(',', '.',str_replace('.', '',$val['F']))).'", "3", "'.$mysqli->real_escape_string($val['G']).'")');
		}
	}
	
	if($type == 'cometrade')
	{		
		error_reporting(E_ALL ^ E_NOTICE);
		/** Include path **/
		set_include_path($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'cdn/excel/Classes/');
 
		/** PHPExcel_IOFactory */
		require_once 'PHPExcel/IOFactory.php';
	   
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
			   
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		
		$sheetData = $objPHPExcel->setActiveSheetIndexByName('cenovnik')->toArray(null, true, false, true);
	
		$values = array();
		foreach($sheetData as $key=>$val){
			if($key < 2 || $val['D'] == NULL || $val['G'] == '') continue;
			array_push($values, '("'.$mysqli->real_escape_string($val['D']).'", "'.$mysqli->real_escape_string($val['E']).'", "'.$mysqli->real_escape_string(str_replace(",",".", $val['G'])).'", "2", 0)');
		}
	}
	
	$q = "INSERT INTO `product_external`(`code`, `name`, `price`, `pricelist`, `amount`) VALUES ".implode(',', $values)." ON DUPLICATE KEY UPDATE name = VALUES(name), price = VALUES(price), amount = VALUES(amount)";
	if($mysqli->query($q)) return true;
	else return false;
}


$err = 0;
$validextensions = array("xls", "XLS", "xlsx", "XLSX");
$temporary = explode(".", $_FILES["importfilepricelist"]["name"]);
$file_extension = $temporary[count($temporary)-1];
if(isset($_FILES["importfilepricelist"]["type"]) && in_array($file_extension, $validextensions) )
{
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfile"]["name"])) unlink($_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfile"]["name"]);
	if(parseCenovnikExcel($sourcePath = $_FILES['importfilepricelist']['tmp_name'], $_POST['importfilepricelist_type']))
	{
		// success backup file
		$sourcePath = $_FILES['importfilepricelist']['tmp_name']; 
		$data = explode('.', $_FILES['importfilepricelist']['name']);
		$targetPath = $_SERVER['DOCUMENT_ROOT']."/cenovnici/archive/".$_POST['importfilepricelist_type']."_".date("d-m-Y_H-i-s").".".$data[count($data)-1]; 
		$ret = move_uploaded_file($sourcePath,$targetPath);
	}	
}
else{
	echo "Nevalidan format fajla!";	
}
?>