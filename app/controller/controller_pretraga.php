<?php
	include_once("app/class/Product.php");
	include_once("app/class/Category.php");
	include_once("app/class/Partner.php");
	include_once("app/class/Search.php");
	$data = array();
	$itemperpage = 1;
	$totalitems = 1;
	$pagingparams = '';
	$searchcatid = 0;
	$page = 1;
	if(isset($_GET['p']) && $_GET['p'] != ""){
		$page = $_GET['p'];	
	}
	if(isset($_GET['cat']) && $_GET['cat'] != ""){
		$searchcatid = $_GET['cat'];	
	}
	if(isset($_GET['q']) && $_GET['q'] != ''){
		if(isset($_GET['t']) && $_GET['t'] != ''){
			$pagingparams = 'q='.$_GET['q']."&t=".$_GET['t'];
			// pretraga za odredjeni tip
			if($_GET['t'] == 'doc'){
				// pretraga dokumenta	
				$type = 'doc';
				$itemperpage = $theme_conf["search_documents_per_page"][1];
				$tmpdata = Search::documentsSearch($_GET['q']); 
				$totalitems = $tmpdata[0];
				
				foreach($tmpdata[1] as $key=>$val){
					$pi = pathinfo($val[0]);
						$docpathdata = globalHelper::stringToUrls($pi['dirname'], DIRECTORY_SEPARATOR, array(0,1), "dokumenta");
						array_push($data, array('name'=>$val[1], 'filepath'=>$val[0], 'paths'=>$docpathdata));	
				}
				$limitstart = ($_GET['p']-1)*intval($theme_conf["search_documents_per_page"][1]);
				$limitend = $_GET['p'] * intval($theme_conf["search_documents_per_page"][1]);
			}
			elseif($_GET['t'] == 'pro'){
				// product
				$type = 'prod';	
				
				$itemperpage = $theme_conf["search_product_per_page"][1];
				
				$tmpdata = Search::productSearch($_GET['q'], $page, $itemperpage); 

				

				
				$datadetail = Category::getCategoryProductDetail($tmpdata, $page, $itemperpage , '', "ASC", "code",  false, '', '', 1);
				//$prolist = array(), $page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "code",  $action = false, $minprice = '', $maxprice = '', $viewtype = 0
				//$totalitems = $datadetail[0];
				
				$data = $datadetail[1];
				$totalitems = count($data);
				
				$limitstart = 0;
				$limitend = count($data);
				
			}
			elseif($_GET['t'] == 'news'){
				// news
				$type = 'news';
				$itemperpage = $theme_conf["search_news_per_page"][1];

				$tmpdata = Search::newsSearch($_GET['q'], $page, $itemperpage);
				if(isset($tmpdata[0])) $totalitems = $tmpdata[0];
				
				foreach($tmpdata[1] as $key=>$val){
					array_push($data, array('id'=>$val[0], 'name'=>$val[1], 'body'=>substr($val[2],0,200), 'shortnews'=>substr($val[3],0,200), 'owner'=>$val[4],'adddate'=>$val[5],'thumb'=>$val[6] ));	
				}
				
				$limitstart = 0;
				$limitend = count($data);
			}
			elseif($_GET['t'] == 'page'){
				// pages	
				$type = 'page';
			}
			
			$pagingparams = 'q='.$_GET['q']."&t=".$_GET['t'];
			
			$pagination = GlobalHelper::paging($page, $totalitems, $itemperpage);
			

			include($system_conf["theme_path"][1]."views/pretragasingletype.php");
			
		}
		else{

			$pagingparams = 'q='.$_GET['q'];
			// pretraga kroz sve tipove	
			$prodata = array();
			$newsdata = array();
			$docdata = array();
			$pagedata = array();
			$partnerdata = array();
			
			$itemperpage = $theme_conf["search_all_items_per_page"][1];
			$totalitems = 0;

			/*	news	*/
			
			$tmpdatanews = Search::newsSearch($_GET['q'], $page, $itemperpage); 
			
			if(isset($tmpdatanews[0])) $totalitems = $tmpdatanews[0];

			foreach($tmpdatanews[1] as $key=>$val){
				array_push($newsdata, array('id'=>$val[0], 'name'=>$val[1], 'body'=>substr($val[2],0,200), 'shortnews'=>substr($val[3],0,200), 'owner'=>$val[4],'adddate'=>$val[5],'thumb'=>$val[6] ));	
			}
			
			$newslimitstart = 0;
			$newslimitend = count($newsdata);
			
			/*	news end*/			
			/*	partners	*/
			
			//$tmpdatapartners = Search::partnerSearch($_GET['q'], $page, $itemperpage); 
			
			//if(isset($tmpdatapartners[0])) $totalitems = $tmpdatapartners[0];

			//foreach($tmpdatapartners[1] as $key=>$val){
			//	array_push($partnerdata, array('id'=>$val[0], 'name'=>$val[1], 'partnertype'=>substr($val[2],0,200) ));	
			//}
			
			//$partnerlimitstart = 0;
			//$partnerlimitend = count($partnerdata);				
			/*	partners end*/
			/*	documents	*/
			
			$tmpdatadoc = Search::documentsSearch($_GET['q']);
			
			if($totalitems < $tmpdatadoc[0]) $totalitems = $tmpdatadoc[0];
			
			foreach($tmpdatadoc[1] as $key=>$val){
				$pi = pathinfo($val[0]);
					$docpathdata = globalHelper::stringToUrls($pi['dirname'], DIRECTORY_SEPARATOR, array(0,1), "dokumenta");
					array_push($docdata, array('name'=>$val[1], 'filepath'=>$val[0], 'paths'=>$docpathdata));	
			}
			$doclimitstart = ($page-1)*intval($theme_conf["search_all_items_per_page"][1]);
			$doclimitend = $page * intval($theme_conf["search_all_items_per_page"][1]);
			/*	documents end*/
			/*	products */
			
			$tmpdatapro = Search::productSearch($_GET['q'], $page, $itemperpage);    
			if($searchcatid>0){
				$catdetail = Category::getCategoryProduct($searchcatid);
			
				$tmpdataprointersect = array_intersect($tmpdatapro,$catdetail);
			} else {
				$tmpdataprointersect = $tmpdatapro; 
			}
			if($totalitems < count($tmpdataprointersect)) $totalitems = count($tmpdataprointersect);
			$datadetail = Category::getCategoryProductDetail($tmpdataprointersect, $page, $itemperpage, '', implode(",", $tmpdataprointersect), 'pattern', false, '', '',1);
			//$datadetail = Category::getCategoryProductDetail($tmpdataprointersect, $page, $itemperpage, '', 'ASC', 'pattern', false, '', '',1);
			//($prolist = array(), $page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "code",  $action = false, $minprice = '', $maxprice = '', $viewtype = 0 )
			//$prolist = array(), $page = 1, $itemsperpage = 1 , $search = '', $sort = "ASC", $sortby = "code",  $action = false, $minprice = '', $maxprice = '', $viewtype = 0
			
			$prodata = $datadetail[1];

			$prolimitstart = 0;
			$prolimitend = count($prodata);
			
			/*	products end */
			$pagination = GlobalHelper::paging($page, $totalitems, $itemperpage);
			include($system_conf["theme_path"][1]."views/pretragaalltype.php");
		}
	}
	else{
		//include("views/pretragaalltype.php");
		include($system_conf["theme_path"][1]."views/pretragaempty.php");
	}
	
	
	
	
	

	
?>