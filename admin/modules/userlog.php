<?php

	function userlog($moduleid, $contenttype, $contentid, $userid, $action){
		global $conn;
		
		$query = "INSERT INTO `userlogadmin`(`id`, `moduleid`, `contenttype`, `contentid`, `userid`, `changedate`, `action`, `ts`) VALUES ('', ".mysqli_real_escape_string($conn, $moduleid).", '".mysqli_real_escape_string($conn, $contenttype)."', ".mysqli_real_escape_string($conn, $contentid).", ".mysqli_real_escape_string($conn, $userid).", NOW(), '".mysqli_real_escape_string($conn, $action)."', CURRENT_TIMESTAMP)";
		if(mysqli_query($conn, $query))
		{
			return 1;	
		}
		else{
			return 0;	
		}
	}
?>