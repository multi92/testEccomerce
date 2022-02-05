<?php 
	include("../../config/db_config.php");
	include("../../config/config.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if (isset($_POST['action']) && $_POST['action'] != "") {
		switch ($_POST['action']) {
			case "sendemail": send_email(); break;
		}
	}
	
	function send_email(){
		include("../../modules/order/library/email.php");
		$message = '<div class="container-fluid logoline">
					<img src="'.$report_defailt_logo.'"  />
				</div>
				<div class="container" style="padding:30px 0 0 0;">'.$_POST['message'].'</div>'.get_b2c_footer();
		if(send_b2c_email($_POST['to'], $report_defailt_mail, $_POST['subject'], $message))
		{
			echo 0;	
		}else{
			echo 1;	
		}
			
	}

?>