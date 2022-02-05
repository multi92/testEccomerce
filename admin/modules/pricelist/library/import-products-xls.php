<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('max_execution_time', 0); 
ini_set('memory_limit', '-1');

function parseCenovnikExcel($file, $pricelistid, $type=0)
{
	require_once($_SERVER['DOCUMENT_ROOT']."/app/configuration/system.configuration.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/app/class/core/Database.php");
	$db = Database::getInstance();
	$mysqli = $db->getConnection();
	$mysqli->set_charset("utf8");
	
	
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
	
	if($objPHPExcel->getSheetByName('cenovnik') != NULL)
	{
		//$q = "DELETE FROM `pricelistitem` WHERE pricelistid = '".$pricelistid."'";
		//$mysqli->query($q);	
		
		$sheetData = $objPHPExcel->setActiveSheetIndexByName('cenovnik')->toArray(null, true, false, true);
		if($sheetData[1]['A'] == 'sifra' && $sheetData[1]['B'] == 'barkod' && $sheetData[1]['C'] == 'rebate')
		{
			$values = array();
			foreach($sheetData as $key=>$val){
				if($key<2) continue;
				//*	code check	*/
				$q = "SELECT id FROM product WHERE code = '".$val['A']."'";
				$res = $mysqli->query($q);
				if($res->num_rows > 0){
					$row = $res->fetch_assoc();
					array_push($values, '("'.$mysqli->real_escape_string($pricelistid).'", "'.$mysqli->real_escape_string($row['id']).'", "'.$mysqli->real_escape_string($val['C']).'")');	
				}else{
					//*	barcode check	*/
					$q = "SELECT id FROM product WHERE barcode = '".$val['B']."'";
					$res = $mysqli->query($q);	
					if($res->num_rows > 0){
						$row = $res->fetch_assoc();
						array_push($values, '("'.$mysqli->real_escape_string($pricelistid).'", "'.$mysqli->real_escape_string($row['id']).'", "'.$mysqli->real_escape_string($val['C']).'")');	
					}
				}
				if($val['C'] == NULL || $val['C'] == '')  continue;
			}
				
			$q = "INSERT INTO `pricelistitem`(`pricelistid`, `productid`, `rebate` ) VALUES ".implode(',', $values)." ON DUPLICATE KEY UPDATE rebate = VALUES(rebate)";		
			if($mysqli->query($q)){
				return true;
			}
			else return false;
			
		}
		else{
			echo "Nevalidna zaglavlja!";
			return false;	
		}
	}
	
	
	
}
$err = 0;
$validextensions = array("xlsx", "XLSX");
$temporary = explode(".", $_FILES["importfilepricelist"]["name"]);
$file_extension = $temporary[count($temporary)-1];
if(isset($_FILES["importfilepricelist"]["type"]) && in_array($file_extension, $validextensions) )
{
	//if(file_exists($_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfilepricelist"]["name"])) unlink($_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfilepricelist"]["name"]);
	if(parseCenovnikExcel($sourcePath = $_FILES['importfilepricelist']['tmp_name'], $_POST['pricelistid']))
	{
		// success backup file
		/*
		$sourcePath = $_FILES['importfilepricelist']['tmp_name']; 
		$data = explode('.', $_FILES['importfilepricelist']['name']);
		$targetPath = $_SERVER['DOCUMENT_ROOT']."/cenovnici/archive/".$_POST['importfilepricelist_type']."_".date("d-m-Y_H-i-s").".".$data[count($data)-1]; 
		$ret = move_uploaded_file($sourcePath,$targetPath);
		*/
	}	
}
else{
	echo "Nevalidan format fajla!";	
}
?>