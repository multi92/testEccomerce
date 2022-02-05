<?php

/*ROOT DEFINE*/

	define("ADMIN_DB_HOST", "mysql531.loopia.se");
	define("ADMIN_DB_NAME", "softart_rs_db_17");
	define("ADMIN_DB_USER", "user@s59747");
	define("ADMIN_DB_PASS", "lR5WTRKrR4");
/*ROOT DEFINE END*/

$baseurl = "http://rs2101.softart.rs/admin/";
$companyname = "SoftArt Classic Theme";
$report_defailt_mail = "develop@softart.rs";
$report_defailt_logo = "podrska@softart.rs";
/*system db*/
$dbname = "softart_rs_db_17";
$servername = "mysql531.loopia.se";
$user = "user@s59747";
$password = "lR5WTRKrR4";
/*master db*/

	
/*system db connect*/
if(mysqli_connect($servername,$user,$password) == false)
{
	echo "GRESKA ==>>". mysqli_error();
}
else 
{
	$conn = mysqli_connect($servername,$user,$password);
}
if(mysqli_select_db($conn,$dbname) == false)
{
	echo "GRESKA 2 ==>>".mysqli_error();
}
else
{
	$db = mysqli_select_db($conn,$dbname);
}
mysqli_query($conn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");




?>


