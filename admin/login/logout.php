<?php
session_start();

session_unset(); 
	session_destroy();
	setcookie("PHPSESSID","",1);
	header( "Location: ../" ); 
/*
if($_SESSION["status"]="logged")
{
	session_unset(); 
	session_destroy();
	setcookie("PHPSESSID","",1);
	exit();
} 
else
{ 
	if ($_SESSION["status"]="not logged")
	{
	//the session variable isn't registered, the user shouldn't even be on this page 
		header( "Location:../index.php" ); 
		exit();
	}
}
*/
?>
