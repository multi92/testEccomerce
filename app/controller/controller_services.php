<?php
	if(isset($command[1]) && $command[1] != ""){
		$service = array();
		$q = "SELECT s.*, str.name as nametr, str.description as descriptiontr  FROM service AS s
			LEFT JOIN service_tr as str ON s.id = str.serviceid				 
		  WHERE s.id = '".$command[1]."' AND (str.langid = ".$_SESSION['langid']." OR str.langid IS NULL)";
		  
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
				
					$name = $row['name'];
					if($row['nametr'] != '' && $row['nametr'] != NULL){
						$name = $row['nametr'];
					}
				
					$desc = $row['description'];
					if($row['descriptiontr'] != '' && $row['descriptiontr'] != NULL){
						$desc = $row['descriptiontr'];
					}
				
					$image = $user_conf["no_img"][1];
					if($row['image'] != '' && $row['image'] != NULL){
						$image = $row['image'];
					}
				
					array_push($service, array('id'=>$row['id'],'name'=>$name,'description'=>$desc, 'image'=>$image));
			
			
				}
			
			
				//if($user_conf["show_all_services_list"][1] != 1){//ako je u user conf podeseno da ne prikazuje sve galerije
				//	$pagination = GlobalHelper::paging($page, $services, $user_conf["services_per_page"][1]);
				//}
		
			}
			$service=$service[0];
		include($system_conf["theme_path"][1]."views/service.php");
        
	}
	else {
		$page = 1;
		if(isset($_GET['p']) && $_GET['p'] != ""){
			$page = $_GET['p'];
		}
		
		$services = array(); 
			$q = "SELECT s.*, str.name as nametr, str.description as descriptiontr  FROM service AS s
					LEFT JOIN service_tr as str ON s.id = str.serviceid				 
					WHERE s.status='v' AND (str.langid = ".$_SESSION['langid']." OR str.langid IS NULL)";
		
			$res = $mysqli->query($q);
			if($res->num_rows > 0){
				while($row = $res->fetch_assoc()){
				
					$name = $row['name'];
					if($row['nametr'] != '' && $row['nametr'] != NULL){
						$name = $row['nametr'];
					}
				
					$desc = $row['description'];
					if($row['descriptiontr'] != '' && $row['descriptiontr'] != NULL){
						$desc = $row['descriptiontr'];
					}
				
					$image = $user_conf["no_img"][1];
					if($row['image'] != '' && $row['image'] != NULL){
						$image = $row['image'];
					}
				
					array_push($services, array('id'=>$row['id'],'name'=>$name,'description'=>$desc, 'image'=>$image));
			
			
				}
			
			
				//if($user_conf["show_all_services_list"][1] != 1){//ako je u user conf podeseno da ne prikazuje sve galerije
				//	$pagination = GlobalHelper::paging($page, $services, $user_conf["services_per_page"][1]);
				//}
		
			}
		include($system_conf["theme_path"][1]."views/services.php");	
			
		}			
?>
