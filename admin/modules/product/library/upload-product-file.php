<?php
require_once "resize-image.php";
require_once("../../../config/db_config.php");
require_once("../../../config/config.php");

if(isset($_FILES["productFile"]["type"]))
{

	$imagenameparts = explode(".",$_FILES["productFile"]["name"]);
	
	$files1 = glob($_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/".$imagenameparts[0].".".$imagenameparts[1]);
	$files2 = glob($_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/".$imagenameparts[0]."(*).".$imagenameparts[1]);
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
	
	
	$validextensions = array( "doc", "DOC", "docx", "DOCX", "pdf", "PDF", "xls", "XLS", "xlsx", "XLSX");
	$temporary = explode(".", $_FILES["productFile"]["name"]);
	$file_extension = "pdf";
	if ((  ($_FILES["productFile"]["type"] == "application/msword") || 
		   ($_FILES["productFile"]["type"] == "application/pdf") || 
		   ($_FILES["productFile"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) && in_array($file_extension, $validextensions)) 
	{
		
		if ($_FILES["productFile"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["productFile"]["error"] . "<br/><br/>";
		}
		else
		{
			if($nextimagesort == 0){
				$newname = $temporary[0].".".$file_extension;
			}
			else{
				$newname = $temporary[0]."(".$nextimagesort.").".$file_extension;	
			}
			
			$sourcePath = $_FILES['productFile']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/".$newname; // Target path where file is to be stored
						
			$ret = move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
			/*if($_POST['selectFileType']=='ico'){
				smart_resize_image($targetPath , null, 240, 135 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/thumb/".$newname , false , false ,100 );
				smart_resize_image($targetPath , null, 480, 270 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/small/".$newname , false , false ,100 );
				smart_resize_image($targetPath , null, 960, 540 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/medium/".$newname , false , false ,100 );
				smart_resize_image($targetPath , null, 1920, 1080 , true , $_SERVER['DOCUMENT_ROOT'].$subdirname."/fajlovi/product/files/big/".$newname , false , false ,100 );
			}	*/		
			
			
			$q = "SELECT MAX(sort)+1 as sortnum FROM product_file WHERE productid = ".$_POST['proid']." AND type = '".$_POST['selectFileType']."' ";
			$res = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($res);
			$nextsort = $row['sortnum'];
			
			$q = "INSERT INTO `product_file`(`id`, `productid`, `type`, `content`, `contentface`, `attrvalid`, `status`, `sort`, `ts`) VALUES ('', ".$_POST['proid'].", '".$_POST['selectFileType']."', '".$newname."', '".$_POST['productFileName']."', 0, 'v', ".$nextimagesort.", CURRENT_TIMESTAMP)";
		
			$res = mysqli_query($conn, $q);
			
			$lastid = mysqli_insert_id($conn);
			
			echo json_encode(array(0, "../fajlovi/product/files/".$newname, "../fajlovi/product/files/".$newname, $lastid));

		}
	}
	else
	{
		echo "<span id='invalid'>***Invalid file Size or Type***<span>";
	}
}
?>