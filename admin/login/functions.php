<?php
function check_for_username($username)
{
	$query = "SELECT COUNT(username) AS user_n FROM users WHERE username='".$username."'";
	$r = mysql_query($query);
	if(mysql_result($r, 0, 0) == 1) return true;
	else return false;
}

function check_for_email($email)  
{
	$query = "SELECT COUNT(email) AS email_n FROM users WHERE email='".$email."'";
	$r = mysql_query($query);
	if(mysql_result($r, 0) == 1) return true;
	else return false;
}

function check_password($username, $password)
{
	$query = "SELECT * FROM user WHERE password='".$password."' AND username='".$username."' LIMIT 1";
	$r = mysql_query($query);
	if(mysql_result($r, 0))
	{
		$res = mysql_fetch_row($r);  
		return $res;
	}
	else return false;
}

function log_in($username, $password)
{
	
}

?>