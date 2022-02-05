<?php

require_once("../../../config/db_config.php");
require_once("../../../config/config.php");

if(isset($_FILES["memberFilePath"]["type"]))
{
	$imagenameparts = explode(".",$_FILES["memberFilePath"]["name"]);
	
	$files1 = glob($_SERVER['DOCUMENT_ROOT']."/admin/fajlovi/member/".$imagenameparts[0].".".$imagenameparts[1]);
	$files2 = glob($_SERVER['DOCUMENT_ROOT']."/admin/fajlovi/member/".$imagenameparts[0]."(*).".$imagenameparts[1]);

	//var_dump($imagenameparts);
	//var_dump($files1);
	//var_dump($_SERVER['DOCUMENT_ROOT']."/admin/fajlovi/document/".$imagenameparts[0].".".$imagenameparts[1]);die();
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
	
	//var_dump($nextimagesort);
	$validextensions = array("jpeg", "jpg", "png","gif","doc","docx","xls","xlsx","pdf", "JPEG", "JPG", "PNG", "GIF","DOC","DOCX","XLS","XLSX","PDF");
	$temporary = explode(".", $_FILES["memberFilePath"]["name"]);
	$file_extension = $imagenameparts[1];
	if (( ($_FILES["memberFilePath"]["type"] == "image/png") 
		  || ($_FILES["memberFilePath"]["type"] == "image/jpg") 
		  || ($_FILES["memberFilePath"]["type"] == "image/jpeg") 
		  || ($_FILES["memberFilePath"]["type"] == "image/gif")
		  || ($_FILES["memberFilePath"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
		  || ($_FILES["memberFilePath"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		  || ($_FILES["memberFilePath"]["type"] == "application/pdf")
		) && in_array($file_extension, $validextensions)) 
	{
		
		if ($_FILES["memberFilePath"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["memberFilePath"]["error"] . "<br/><br/>";
		}
		else
		{
			if($nextimagesort == 0){
				$newname = $temporary[0].".".$file_extension;
			}
			else{
				$newname = $temporary[0]."(".$nextimagesort.").".$file_extension;	
			}
			
			$sourcePath = $_FILES['memberFilePath']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = $_SERVER['DOCUMENT_ROOT']."/admin/fajlovi/member/".$newname; // Target path where file is to be stored
						
			$ret = move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
									
			$q = "SELECT MAX(sort)+1 as sortnum FROM member_file WHERE memberid = ".$_POST['memberid']." ";

			$res = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($res);
			$nextsort = $row['sortnum'];
			
			$q = "INSERT INTO `member_file`( `memberid`, `type`,`name`, `content`, `contentface`, `status`, `sort`, `ts`) 
						VALUES ( ".$_POST['memberid'].", 'file','".$_POST['memberfilename']."', '".$newname."', '', 'v', ".$nextimagesort.", CURRENT_TIMESTAMP)";

			$res = mysqli_query($conn, $q);
			
			$lastid = mysqli_insert_id($conn);
			
			echo json_encode(array(0, "../admin/fajlovi/member/".$newname, "../admin/fajlovi/member/".$newname, $lastid));

		}
	}
	else
	{
		echo "<span id='invalid'>***NEDOZVOLJENA VELIČINA ILI TIP FAJLA***<span>";
	}
}
?>