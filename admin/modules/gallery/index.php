<?php 
	
	if(isset($command[1]) && $command[1] != ""){
		if($command[1] == 'change' && isset($command[2]) && is_numeric($command[2]) && $_SESSION['change'] == 1){
			$currentview = 'change';
			include'view/addchange.php';
		}
		else if($command[1] == 'add' && $_SESSION['add'] == 1){
			$command[2] = '';
			$currentview = 'add';
			include('view/addchange.php');	
		}
		else if($command[1] == 'config' ){
			$command[2] = '';
			$currentview = 'config';
			include('view/settings.php');	
		}
		else{
			include('view/home.php');		
		}
	}
	else{
		include('view/home.php');	
	}

	include('view/templates.php');
	
?>