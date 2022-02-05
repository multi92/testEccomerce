<?php 
	
	if(isset($command[1]) && $command[1] != ""){
		if($command[1] == 'change' && isset($command[2]) && is_numeric($command[2]) && $_SESSION['change'] == 1){
			$currentview = 'change';
			include'view/addchange.php';
		}
		else if($command[1] == 'applications'){
			$command[2] = '';
			$currentview = 'applications';
			include('view/partner_applications.php');
		}
		else if($command[1] == 'add' && $_SESSION['add'] == 1){
			$command[2] = '';
			$currentview = 'add';
			include('view/addchange.php');	
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