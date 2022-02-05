
<?php  
$cms_PageName='';
$fb_OGType='website';
$fb_OGTitle=$user_conf["sitetitle"][1];
$fb_OGDescription=$user_conf["sitedescription"][1];
$fb_OGImage=BASE_URL.$user_conf["sitelogo"][1];

	if(GlobalHelper::isDBPage($command)){
   		$cms_PageName = 'dbpage';
   		$fb_OGType='article';
   		$fb_OGTitle='';
   		$fb_OGDescription='';
   		$fb_OGImage='';
   	}

    if(GlobalHelper::isProduct($command)){

 		$cms_PageName = 'product';
 		$fb_OGType='product.item';
 		
 			$prodid = GlobalHelper::getProductIdFromCommand($command);
   			if(!GlobalHelper::isProductVisible($prodid)){
        		//var_dump('error controler proizvod no visible');
        	//die();
          //echo '111';
    		} else {
          $productGraf =new ProductOG($prodid); 

    //var_dump($product);
    $fb_OGTitle=addslashes($productGraf->name);
    $fb_OGDescription=addslashes(strip_tags($productGraf->description));
    $fb_OGImage=BASE_URL.GlobalHelper::getImage('fajlovi/product/'.$productGraf->pictures[0]['img'], 'big');
    
          
        }
    		
		
    } 
    
    //var_dump($command[0]);
   	if(GlobalHelper::isNews($command)){
   		include_once("app/class/News.php");

   		$cms_PageName = 'news';
   		$fb_OGType='website';
   		$news = News::getNews($command[1]);
   		//var_dump(GlobalHelper::isNews($command));
   		$fb_OGTitle=addslashes($news['main']->title);
   		$fb_OGDescription=substr(addslashes($news['main']->shortnews),0,201)."...";
   		$fb_OGImage=BASE_URL.GlobalHelper::getImage($news['main']->thumb, 'big');
   	}
   	//echo $cms_PageName; 
    //echo 'opengr';
?>

<meta property="og:url"           content="<?php echo $_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:type"          content="<?php echo $fb_OGType;?>" />
<meta property="og:title"         content="<?php echo $fb_OGTitle;?>" />
<meta property="og:description"   content="<?php echo $fb_OGDescription;?>" />
<meta property="og:image"         content="<?php echo $fb_OGImage; ?>" />