<?php
/*TOP SLIDER*/
	require_once("app/class/SliderItem.php");
	switch ($theme_conf["top_slider_type"][1]) {
    case 0:
        $topslider = SliderItem::GetSliderListById(1);
		
		if($theme_conf["top_slider_show_banner_or_news"][1]==0){
			//show banner
			$topslider_slidebanner = SliderItem::GetSliderListById(3);
			
			
		}
		if($theme_conf["top_slider_show_banner_or_news"][1]==1){
			//show news
			//$topslider_news = SliderItem::GetSliderListById(1);
			require_once("app/class/News.php");	
			$topslider_slidenews = News::getNewsList($page, $theme_conf["news_on_topslider"][1], false);
		}
		$topsliderbanner = GLobalHelper::getTopSliderRandomBanner();
		include($system_conf["theme_path"][1]."views/includes/slider/mainSlider.php");
        break;
    case 1:
        $topslider = SliderItem::GetSliderListById(1);
		include($system_conf["theme_path"][1]."views/includes/slider/mainSlider1.php");
        break;
     case 2:
        $topslider = SliderItem::GetSliderListById(1);
		include($system_conf["theme_path"][1]."views/includes/slider/mainSlider2.php");
        break;
	}
/*TOP SLIDER END*/
?>