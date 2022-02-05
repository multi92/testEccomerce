<?php 
		include("../../../config/db_config.php");
	    session_start();

	    if(!isset($_POST['searchTerm'])){ 
		  $q="SELECT p.* FROM product AS p WHERE p.code!='' AND p.active='y'  ORDER BY code ASC LIMIT 20";
		}else{ 
		  $q="SELECT p.* FROM product AS p WHERE p.code!='' AND p.active='y' AND (p.name LIKE '".$_POST['searchTerm']."%' OR p.code LIKE '".$_POST['searchTerm']."%' OR p.barcode LIKE '".$_POST['searchTerm']."%') ORDER BY code ASC LIMIT 20";
		} 


		
		//echo $q;
		$res = mysqli_query($conn, $q);

		$pdata=array();
		while($row = mysqli_fetch_assoc($res)){
			array_push($pdata, array("id"=>$row['id'], "text"=>$row['code']." | ".$row['barcode']." | ".$row['name']));		
		}
		echo json_encode($pdata);
?>