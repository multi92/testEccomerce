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
		else if($command[1] == 'prepare' && isset($command[2]) && is_numeric($command[2]) && $_SESSION['prepare'] == 1 && !isset($command[3])){
			
			$currentview = 'prepare';
			include('view/prepare_report.php');	
			
		}
		else if($command[1] == 'prepare' && isset($command[2]) && is_numeric($command[2]) && $_SESSION['prepare'] == 1  && $command[3] == 'run'){
			
			$currentview = 'run';
			include('view/run_report.php');	
			
		}
		else{
			$_SESSION['reportinputs']=array();
			$_SESSION['reportinputscolected']=array();
			include('view/home.php');		
		}
	}
	else{
		include('view/home.php');	
	}
	//var_dump($_SESSION['reportinputs']);

	include('view/templates.php');
		include('view/modals.php');
	
?>