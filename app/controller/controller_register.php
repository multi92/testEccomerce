<?php 
	if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged')
	{
		include($system_conf["theme_path"][1]."views/pocetna.php");
	}
	else{

		$querylang = "SELECT * FROM languages ORDER BY id ASC";
        
        $lang_data = array();

        $rlang =  $mysqli->query($querylang);

        if($rlang && $rlang->num_rows > 0){

			while($row = $rlang->fetch_assoc()){
	
					array_push($lang_data, array('langid'=>$row['id'],'langname'=>$row['name']));
	
			}

		}

		


                                   
	
		include($system_conf["theme_path"][1]."views/registration.php");
	}
	
?>
