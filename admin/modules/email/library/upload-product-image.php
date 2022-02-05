<?php
include "resize-image.php";

$files = glob($_SERVER['DOCUMENT_ROOT']."aswo/fajlovi/product/".$_POST['proid']."*.jpg");
$values = array();
if(!empty($files))
{
	foreach($files as $file)
	{
		$tmp = substr_replace(basename($file),"",0,1);	
		$tmp = substr($tmp,0,-4);	
		$tmp = str_replace("(", "", $tmp);
		$tmp = str_replace(")", "", $tmp);
		if($tmp == ""){
			array_push($values, 0);
		}
		else{
			array_push($values, $tmp);	
		}
	}
	$nextimagesort = max($values)+1;
}
else{
	$nextimagesort = 0;	
}

if(isset($_FILES["file"]["type"]))
{
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
				$newname = $_POST['proid'].".".$file_extension;
			}
			else{
				$newname = $_POST['proid']."(".$nextimagesort.").".$file_extension;	
			}
			$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = $_SERVER['DOCUMENT_ROOT']."aswo/fajlovi/product/".$newname; // Target path where file is to be stored
			move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
			
			smart_resize_image($targetPath , null, 160, 160 , true , $_SERVER['DOCUMENT_ROOT']."aswo/fajlovi/product/thumbnail/".$newname , false , false ,100 );
			
			echo json_encode(array(0, "../fajlovi/product/thumbnail/".$newname, "../fajlovi/product/".$newname));

		}
	}
	else
	{
		echo "<span id='invalid'>***Invalid file Size or Type***<span>";
	}
}
?>