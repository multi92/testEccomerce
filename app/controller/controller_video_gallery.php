<?php //DEVELOPER MODE
$controller_version["video_gallery"] = array('controller', '1.0.0.0.1', 'MUST BE DEFINED "galleryitems_per_page" and "show_all_galleryitems" PARAMETER in theme.configuration file','');
?>
<?php
	include("app/class/Gallery.php");
	include("app/class/GalleryItem.php");

	if(isset($command[1]) && $command[1] != ""){
		$page = 1;
		if(isset($_GET['p']) && $_GET['p'] != ""){
			$page = $_GET['p'];
		}
		$gallery_items = GalleryItem::GetGalleryItems($command[1], $page, $theme_conf["gallery_video_items_per_page"][1]);
//		var_dump($gallery_items);
		if($theme_conf["show_all_galleryitems"][1] != 1){//ako je u theme conf podeseno da ne prikazuje sve iteme u galeriji
			$pagination = GlobalHelper::paging($page, $gallery_items[0], $theme_conf["gallery_video_items_per_page"][1]);
		}
		$galleryInfo = Gallery::getGalleryInfo($command[1]);
//		var_dump($galleryInfo);

		include($system_conf["theme_path"][1]."views/video.php");
        
	}
	else {
		$page = 1;
		if(isset($_GET['p']) && $_GET['p'] != ""){
			$page = $_GET['p'];
		}
		$gallerys = Gallery::GetGalleryListByPosition('vid', $page, $theme_conf["gallery_video_items_per_page"][1]);

//		var_dump($gallerys);
		if($theme_conf["show_all_galleries_list"][1] != 1){//ako je u theme conf podeseno da ne prikazuje sve galerije
			$pagination = GlobalHelper::paging($page, $gallerys[0], $theme_conf["gallery_video_items_per_page"][1]);
		}
		include($system_conf["theme_path"][1]."views/videos.php");
	}

?>