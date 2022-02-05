<?php

	$tmp_array = array();
	foreach($user_conf as $k=>$v){
		if(!isset($tmp_array[$v[0]])){
			$tmp_array[$v[0]] = array();	
		}
		
		array_push($tmp_array[$v[0]], array($k, $v[1], $v[2]));
	}
		
	$user_conf = $tmp_array;
		
	include('view/home.php');
?>