<?php

	$tmp_array = array();
	$user_conf_edit = array();
	foreach($user_conf as $k=>$v){
		if(!isset($tmp_array[$v[0]])){
			$tmp_array[$v[0]] = array();	
		}
		
		array_push($tmp_array[$v[0]], array($k, $v[1], $v[2]));
	}
		
	$user_conf_edit = $tmp_array;

	$tmp_array = array();
	$theme_conf_edit = array();
	foreach($theme_conf as $k=>$v){
		if(!isset($tmp_array[$v[0]])){
			$tmp_array[$v[0]] = array();	
		}
		
		array_push($tmp_array[$v[0]], array($k, $v[1], $v[2]));
	}
		
	$theme_conf_edit = $tmp_array;
		
	include('view/home.php');
	include('view/templates.php');
?>