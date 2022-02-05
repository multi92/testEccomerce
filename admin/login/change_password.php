<?php

if($_POST['oldpass'] != NULL || $_POST['newpass'] != NULL)
{
	include("../config/db_config.php");
	session_start();
	
	$query = "UPDATE user SET password = '".md5($_POST['newpass'])."' WHERE id= ".$_SESSION['id']." AND password = '".md5($_POST['oldpass'])."'";
	$re = mysqli_query($conn, $query);
	if(mysqli_affected_rows($conn) > 0)
	{
		echo 1;	
	}
	else{
		echo 0;	
	}
}
?>
