<?php
	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	session_start();
	mb_internal_encoding("UTF-8");
	if (isset($_POST['action']) && $_POST['action'] != "") {
		switch ($_POST['action']) {
			case "delete" : delete(); break;
			case "changestatus" : change_status(); break;
			case "getitem" : get_item(); break;
			case "saveaddchange" : save_add_change(); break;
			case "getlanguageslist" : getLanguagesList(); break;
			
			case "addnewcoupon": add_new_coupon(); break;
		}
	}
	
	function delete(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "DELETE FROM `usercoupon` WHERE id = ".$_POST['id'];
			mysqli_query($conn, $query);
						
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "delete");
		}
	}
	
	function change_status(){
		global $conn;
		if($_POST['id'] != "")
		{
			$query = "UPDATE `usercoupon` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
			mysqli_query($conn, $query);	
			
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM usercoupon WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
        echo json_encode($row);
	}
	
	function save_add_change(){
		global $conn;
		$err = 0;
		
		$query = "INSERT INTO `shop`(`id`, `status`, `cityid`, `name`,  `address`, `thumb`, `phone`, `cellphone`, `fax`, `email`, `worktime`, `coordinates`, `type`, `description`, `warehouseid`, `gallery_id`, `ts`)  VALUES (
		'".$_POST['id']."', 
		'h',
		'".mysqli_real_escape_string($conn, $_POST['cityid'])."', 
		'".mysqli_real_escape_string($conn, $_POST['name'])."',
		'".mysqli_real_escape_string($conn, $_POST['address'])."', 
		'".mysqli_real_escape_string($conn, $_POST['image'])."', 
		'".mysqli_real_escape_string($conn, $_POST['phone'])."', 
		'".mysqli_real_escape_string($conn, $_POST['mobile'])."', 
		'".mysqli_real_escape_string($conn, $_POST['fax'])."', 
		'".mysqli_real_escape_string($conn, $_POST['email'])."',
		'".json_encode(array('mf'=>array('from'=>mysqli_real_escape_string($conn, $_POST['weekfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['weekto'])),
							'st'=>array('from'=>mysqli_real_escape_string($conn, $_POST['stfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['stto'])),
							'su'=>array('from'=>mysqli_real_escape_string($conn, $_POST['sufrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['suto']))))."',
		'".mysqli_real_escape_string($conn, $_POST['coordinates'])."',
		'".mysqli_real_escape_string($conn, $_POST['type'])."',
		'".mysqli_real_escape_string($conn, $_POST['description'])."',
		'".mysqli_real_escape_string($conn, $_POST['warehouseid'])."',
		'".mysqli_real_escape_string($conn, $_POST['galleryid'])."',		 
		CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE 
					`cityid` = '".mysqli_real_escape_string($conn, $_POST['cityid'])."' , 
					`name` = '".mysqli_real_escape_string($conn, $_POST['name'])."' , 
					`address` = '".mysqli_real_escape_string($conn, $_POST['address'])."' , 
					`thumb` = '".mysqli_real_escape_string($conn, $_POST['phone'])."' , 
					`phone` = '".mysqli_real_escape_string($conn, $_POST['phone'])."' , 
					`cellphone` = '".mysqli_real_escape_string($conn, $_POST['mobile'])."' , 
					`fax` = '".mysqli_real_escape_string($conn, $_POST['fax'])."' , 
					`email` = '".mysqli_real_escape_string($conn, $_POST['email'])."' , 
					`worktime` = '".json_encode(array('mf'=>array('from'=>mysqli_real_escape_string($conn, $_POST['weekfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['weekto'])),
							'st'=>array('from'=>mysqli_real_escape_string($conn, $_POST['stfrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['stto'])),
							'su'=>array('from'=>mysqli_real_escape_string($conn, $_POST['sufrom']), 'to'=>mysqli_real_escape_string($conn, $_POST['suto']))))."',
 					`coordinates` = '".mysqli_real_escape_string($conn, $_POST['coordinates'])."' , 
					`type` = '".mysqli_real_escape_string($conn, $_POST['type'])."' , 
					`description` = '".mysqli_real_escape_string($conn, $_POST['description'])."' , 
					`warehouseid` = '".mysqli_real_escape_string($conn, $_POST['warehouseid'])."' , 
					`gallery_id` = '".mysqli_real_escape_string($conn, $_POST['galleryid'])."' ";
						
		mysqli_query($conn, $query);
		
		echo json_encode(array($err));
	}
	
	function getLanguagesList(){
		global $conn;
		$data = array();
		
		$query = "SELECT * FROM languages";
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id"=>$row['id'], "name"=>$row['name'], "default"=>$row['default']));		
		}
		
		echo json_encode($data);
	}
	
	
	
	function generate_coupon_custom($email, $couponsid, $warehouseid){
		global $conn;
		
		$q = "INSERT INTO `usercoupon`( `email`, `couponsid`, `status`, `createddate`, `warehouseid`, `type`) VALUES ( '".mysqli_real_escape_string($conn, $email)."', ".$couponsid.", 'n', NOW(), ".$warehouseid.", 'custom')";	
		
		$re = mysqli_query($conn, $q);
		
		$lastid = mysqli_insert_id($conn);
		
		$q = "UPDATE `usercoupon` SET `couponcode`= CRC32(MD5(CONCAT('katrin',".$lastid."))) WHERE id = ".$lastid;
		$re = mysqli_query($conn, $q);
		
		$q = "SELECT id, couponcode FROM `usercoupon` WHERE id = ".$lastid;
		$re = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($re);
		
		return array($row['id'], $row['couponcode']);
	}
	
	function add_new_coupon(){
		global $conn;
		
		if($_POST['newemail'] != "" && $_POST['newvalue'] != "")
		{
			$q = "SELECT * FROM coupons WHERE value = ".intval($_POST['newvalue'])." AND warehouseid = ".intval($_POST['newcountry'])." LIMIT 1";
			$res = mysqli_query($conn, $q);
			if(mysqli_num_rows($res) > 0){
				$row = mysqli_fetch_assoc($res);
				$couponid = $row['id'];
			}else{
				$q = "INSERT INTO `coupons`( `value`, `warehouseid`, `status`) VALUES ( ".mysqli_real_escape_string($conn, intval($_POST['newvalue'])).", ".mysqli_real_escape_string($conn, intval($_POST['newcountry'])).", 'v')";

				$r = mysqli_query($conn, $q);
				
				$couponid = mysqli_insert_id($r);
			}
			
			$coupondata = generate_coupon_custom($_POST['newemail'], $couponid, $_POST['newcountry']);
			
			if(count($coupondata) > 0){
				$valute = 'RSD';
				if($_POST['newcountry'] == '90') $valute = 'KM';
				if($_POST['newcountry'] == '91') $valute = 'EUR';
				
				include("../../order/library/email.php");
				
				$message = get_b2c_header("7", array('image'=>'vaucerblank.jpg', 'couponcode'=>$coupondata[1], "couponvalue"=>intval($_POST['newvalue']), "valute"=>$valute)).get_b2c_footer();
				send_b2c_email($_POST['newemail'], 'autoemail@katrin.rs', 'Online vaučer', $message);
				
				echo 0;
			}else{
				echo 1;
			}
		}
	}	
?>