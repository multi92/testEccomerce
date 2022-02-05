<?php

include("../../../config/db_config.php");
include("../../../config/config.php");
include("../../../../app/configuration/system.configuration.php");
include("../../../../".$system_conf["theme_path"][1]."config/user.configuration.php");


$err = 0;
$validextensions = array("csv", "CSV");
$temporary = explode(".", $_FILES["importfile"]["name"]);
$file_extension = $temporary[count($temporary)-1];
if(isset($_FILES["importfile"]["type"]) && in_array($file_extension, $validextensions) )
{
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfile"]["name"])) unlink($_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfile"]["name"]);
	$sourcePath = $_FILES['importfile']['tmp_name']; // Storing source path of the file in a variable
	$targetPath = $_SERVER['DOCUMENT_ROOT']."/admin/modules/product/import/".$_FILES["importfile"]["name"]; // Target path where file is to be stored
	
	$ret = move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
	
	
	$query_product_temp = "CREATE TEMPORARY TABLE IF NOT EXISTS `importfiletemp` (
	  `code` varchar(20) NULL DEFAULT NULL,
	  `active` enum('y','n') NOT NULL DEFAULT 'y',
	  `barcode` varchar(20) NULL DEFAULT NULL,
	  `manufcode` varchar(100) DEFAULT NULL,
	  `manufname` varchar(100) DEFAULT NULL,
	  `name` varchar(100) NOT NULL DEFAULT '',
	  `taxvalue` decimal(10,0) NOT NULL DEFAULT '0',
	  `unitname` varchar(15) DEFAULT NULL,
	  `actionrebate` double NOT NULL DEFAULT '0',
	  `B2Bprice` decimal(25,6) NOT NULL DEFAULT '0.000000',
	  `B2Cprice` decimal(25,6) NOT NULL DEFAULT '0.000000',
	  `amount` double NOT NULL DEFAULT '0',
	  `characteristics` varchar(255) NOT NULL DEFAULT '',
	  `description` varchar(255) NOT NULL DEFAULT '',
	  `model` varchar(255) NOT NULL DEFAULT '',
	  `specification` varchar(255) NOT NULL DEFAULT '',
	  `maxrebate` double NOT NULL DEFAULT '0',
	  `maxretailrebate` double NOT NULL DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	if(mysqli_query($conn, $query_product_temp)){} else {echo mysqli_error($conn);};
	
	mysqli_query($conn, "TRUNCATE importfiletemp");
	
	$query = "LOAD DATA LOCAL INFILE '".$targetPath."'
				INTO TABLE importfiletemp
				FIELDS TERMINATED BY ',' 
				ENCLOSED BY '\"' 
				ESCAPED BY '\\\\'
				LINES TERMINATED BY '\\r\\n' ";
		if(mysqli_query($conn, $query))
		{			
			$q = 'INSERT INTO `product`(`active`, `barcode`, `code`, `manufcode`, `manufname`, `name`, `taxid`, `unitname`, `webrebate`) 
					SELECT `active`, `barcode`, `code`, `manufcode`, `manufname`, `name`, (SELECT id FROM tax WHERE value = t2.taxvalue  LIMIT 1), `unitname`, `actionrebate` FROM importfiletemp as t2 ON DUPLICATE KEY UPDATE 
					active = t2.active,
					barcode = t2.barcode,
					manufcode = t2.manufcode,
					manufname = t2.manufname,
					unitname = t2.unitname,
					webrebate = t2.actionrebate';
			if(mysqli_query($conn, $q))
			{
				$err = 0;				
			}else{
				$err = '';					
			}
			
			/*	B2C	*/
			$q = 'INSERT INTO `productwarehouse`(`productid`, `warehouseid`, `amount`, `price`) 
					SELECT p.id, '.$user_conf["b2cwh"][1].', ip.amount, ip.B2Cprice FROM importfiletemp ip LEFT JOIN product p ON ip.code = p.code ON DUPLICATE KEY UPDATE 
					amount = ip.amount,
					price = ip.B2Cprice';
			if(mysqli_query($conn, $q))
			{
				$err = 0;				
			}else{
				$err = '';					
			}
			
			/*	B2B	*/
			$q = 'INSERT INTO `productwarehouse`(`productid`, `warehouseid`, `amount`, `price`) 
					SELECT p.id, '.$user_conf["b2bwh"][1].', ip.amount, ip.B2Cprice FROM importfiletemp ip LEFT JOIN product p ON ip.code = p.code ON DUPLICATE KEY UPDATE 
					amount = ip.amount,
					price = ip.B2Bprice';
			if(mysqli_query($conn, $q))
			{
				$err = 0;				
			}else{
				$err = '';					
			}
			
			if($err == 0){
				unlink($targetPath);	
			}
		}
		else
		{
			$err = 'neuspelo učitavanje fajla!';
		}
	
}
else{
	echo "Nevalidan format fajla!";	
}
?>