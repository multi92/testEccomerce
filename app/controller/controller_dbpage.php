<?php

	$q="SELECT p.*, ptr.value as valuetr, ptr.showname as shownametr FROM pages p 
			LEFT JOIN pages_tr ptr ON p.id = ptr.pageid
			WHERE p.name = '".strtolower(rawurldecode($command[0]))."' AND status = 'v' AND (ptr.langid=".$_SESSION['langid']." OR ptr.langid IS NULL)";
	$res = $mysqli->query($q);

	// $res is from controller_main
	$row = $res->fetch_assoc();
	
	include('app/class/GalleryItem.php');
	$galleryitems = GalleryItem::GetGalleryItems($row['galleryid'], 1, 50);
	
	$currentPageName = $row['name'];
	$mainwidth = 12;
	
	if($row['rightcol'] == 1) {$mainwidth -= 3;}
	
	if($row['leftcol'] == 1){
		//include("app/controller/controller_leftcol.php");	
		$mainwidth -= 3;
	}
	
	$pagedata = ($row['valuetr'] != NULL)? $row['valuetr']:$row['value'];
	$pagename = ($row['shownametr'] != NULL)? $row['shownametr']:$row['showname'];
	// $pagedata - data for dbpage.php
	include($system_conf["theme_path"][1]."views/dbpage.php");
	
	if($row['rightcol'] == 1){
		//include("app/controller/controller_rightcol.php");	
	}
				
		

?>