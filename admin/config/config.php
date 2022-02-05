<?php
$subdirname = ''; // "ime"
$subdirnameB = '/'.$subdirname; // "/ime"
$subdirnameA = $subdirname.'/'; // "ime/";
$subdirnameBA = '/'.$subdirname.'/'; // "/ime/";

$domain_name = 'develop.softart.rs';
$auto_email = 'develop@softart.rs';
$contact_admin_email = 'podrska@softart.rs';

	$langfull = array();
	$lang = array();

	$query = "SELECT * FROM languages";
	$re = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($re))
	{
		array_push($langfull, $row);
		array_push($lang, $row['shortname']);
		if($row['default'] == 'y') $default_lang = $row['shortname'];
	}
	/*
	$lang = array('lat','cir','eng');	//	jezici
	
	$langfull = array(array('lat', 'latinica'),
				array('cir', 'cirilica'),
				array('eng', 'engleski'));	//	jezici sa opisom
				
	$default_lang = 'lat';
	*/
?>