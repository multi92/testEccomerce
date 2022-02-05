<?php
	include("../../../config/db_config.php");
	
	/*  API	*/

	$d = file_get_contents('http://api.softart.rs/?action=checkdb&tables='.json_encode(array('product','productdetail','productwarehouse','product_tr','productdetail_tr' )));
	$data = json_decode($d, true);
	
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	
	foreach($data as $key=>$val){
		$res = mysqli_query($conn, 'DESCRIBE '.$key);
		if(mysqli_num_rows($res) == $val){
			echo $key." OK <br />";
		}else{
			echo $key." ERROR <br />";
		}
	}

?>