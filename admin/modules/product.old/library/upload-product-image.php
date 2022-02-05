<?php
include "resize-image.php";
include("../../../config/db_config.php");
include("../../../config/config.php");

if(isset($_FILES["file"]["type"]))
{
	$imagenameparts = explode(".",$_FILES["file"]["name"]);
	
	$files1 = glob($_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/".$imagenameparts[0].".".$imagenameparts[1]);
	$files2 = glob($_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/".$imagenameparts[0]."(*).".$imagenameparts[1]);
	if(!is_array($files1)) $files1 = array();
	if(!is_array($files2)) $files2 = array();
	$files = array_merge($files1, $files2);
	$values = array();
	
	$nextimagesort = 0;	
	if(!empty($files))
	{
		foreach($files as $file)
		{
			$pos = strpos(basename($file), '(');
			if(strpos(basename($file), '(')){
				$tmp = substr(basename($file), $pos+1);
				$pos = strpos($tmp, ')');
				$tmp = substr($tmp, 0, $pos);
				if($tmp == ""){
				array_push($values, 0);
				}
				else{
					array_push($values, intval($tmp));	
				}
			}
			
		}
		if(!empty($values)){
			$nextimagesort = max($values)+1;
		}else{
			$nextimagesort = 1;
		}	
	}
	
	
	$validextensions = array("jpeg", "jpg", "png","gif", "JPEG", "JPG", "PNG", "GIF");
	$temporary = explode(".", $_FILES["file"]["name"]);
	$file_extension = "jpg";
	if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/gif")) && in_array($file_extension, $validextensions)) 
	{
		
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
		}
		else
		{
			if($nextimagesort == 0){
				$newname = $temporary[0].".".$file_extension;
			}
			else{
				$newname = $temporary[0]."(".$nextimagesort.").".$file_extension;	
			}
			
			$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/".$newname; // Target path where file is to be stored
						
			$ret = move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
						
			smart_resize_image($targetPath , null, 240, 135 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/thumb/".$newname , false , false ,100 );
			smart_resize_image($targetPath , null, 480, 270 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/small/".$newname , false , false ,100 );
			smart_resize_image($targetPath , null, 960, 540 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/medium/".$newname , false , false ,100 );
			smart_resize_image($targetPath , null, 1920, 1080 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/big/".$newname , false , false ,100 );
			
			$q = "SELECT MAX(sort)+1 as sortnum FROM product_file WHERE productid = ".$_POST['proid']." AND type = 'img'";
			$res = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($res);
			$nextsort = $row['sortnum'];
			
			$q = "INSERT INTO `product_file`(`id`, `productid`, `type`, `content`, `contentface`, `attrvalid`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['proid'].", 'img', '".$newname."', '', 0, 'v', ".$nextimagesort.", CURRENT_TIMESTAMP)";
			$res = mysqli_query($conn, $q);
			
			$lastid = mysqli_insert_id($conn);
			
			echo json_encode(array(0, "../fajlovi/product/thumb/".$newname, "../fajlovi/product/big/".$newname, $lastid));

		}
	}
	else
	{
		echo "<span id='invalid'>***Invalid file Size or Type***<span>";
	}
}
?>