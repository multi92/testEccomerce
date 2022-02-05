<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope
					itemtype="http://schema.org/ListItem">
					<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
						<span itemprop="name"><?php echo $language["global"][3]; ?></span>
					</a>

				</li>

				<li class="active" itemprop="itemListElement" itemscope
				itemtype="http://schema.org/ListItem">
				<span itemprop="name"><?php echo $language["news"][1]; //Vesti ?></span>
			</li>
		</ol>

</div>
<section class="pos">
	<div class="gallerys-bckg cms-galleries-bottom-bckg" ></div>
	<div class="container">
		<div class="content-page">
			<div class="row _unmargin">
				<div class="section-title">
					<h4 class="title"><?php echo $language["news"][2]; //Najnovije vesti i obaveštenja ?></h4>
				</div>
			</div>
			<div class="row _unmargin">
				<div class="col-md-9 col-sm-8 col-xs-12 col-xs col-seter">
					<!-- kat vesti -->
					<div class="row _unmargin">
						<div class="col-md-12 col-seter">
							<ul class="cat-news-ul">
								<?php foreach($maincats AS $k=>$val){?>
								<li class="cat-news-li" ><a href="<?php echo $val['cat']->path;?>"><?php echo $val['cat']->name;?></a></li>
								
								<?php } ?>

							</ul>
						</div>
					</div>
					<!-- .kat vesti -->
					<div class="row _unmargin">
						<?php $cnt=0; 
						foreach($news[1] as $val) { 
							$cnt++;
							if($theme_conf["news_type"][1]==0 && $cnt==1 && $page==1) { 
								include($system_conf["theme_path"][1]."views/includes/newsbox/newsBoxBig.php");
							} else { 
								include($system_conf["theme_path"][1]."views/includes/newsbox/newsBox.php");
							}
						} 
						?>
					</div>
				</div>
				<!--Right Panel-->
				<div class="col-md-3 col-sm-4 col-xs-12 col-xs">
					<?php include("app/controller/controller_rightcolumn.php") ; ?>
					<div class="news-banners">
						<?php include_once("app/controller/controller_banner_right.php");?>
					<!-- 	<div class="banners">
                    		<ul class="list">
                        		<li class="items">
                            		<a href="" class="links">
                                		<img src="fajlovi/theme/banner1.jpg" alt="" class="img-responsive image">
                            		</a>
                        		</li>
                        		<li class="items">
                            		<a href="" class="links">
                                		<img src="fajlovi/theme/banner3.jpg" alt="" class="img-responsive image">
                            		</a>
                        		</li>
                        		<li class="items">
                            		<a href="" class="links">
                                		<img src="fajlovi/theme/banner5.jpg" alt="" class="img-responsive image">
                            		</a>
                        		</li>
                        		<li class="items">
                            		<a href="" class="links">
                                		<img src="fajlovi/theme/banner2.jpg" alt="" class="img-responsive image">
                            		</a>
                        		</li>
                        		<li class="items">
                            		<a href="" class="links">
                                		<img src="fajlovi/theme/banner4.jpg" alt="" class="img-responsive image">
                            		</a>
                        		</li>   
                    		</ul>
                		</div> -->
					</div>
					
				</div>
				<!--Right End-->
			</div>
			<div class="row _unmargin">
				<div class="col-md-12 marginTop30">
					<nav aria-label="Page navigation">
						<ul class="pagination">
							<?php 	
							if($pagination[0] != '') echo '<li><a href="news?p='.$pagination[0].'" aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
							if($pagination[1] != '') echo '<li><a href="news?p='.$pagination[1].'">&lsaquo;</a></li>';
							if($pagination[2] != '') echo '<li><a href="news?p='.$pagination[2].'">'.$pagination[2].'</a></li>';
							if($pagination[3] != '') echo '<li><a href="news?p='.$pagination[3].'">'.$pagination[3].'</a></li>';
							if($pagination[4] != '') echo '<li class="active"><a href="news?p='.$pagination[4].'">'.$pagination[4].'</a></li>';
							if($pagination[5] != '') echo '<li><a href="news?p='.$pagination[5].'">'.$pagination[5].'</a></li>';
							if($pagination[6] != '') echo '<li><a href="news?p='.$pagination[6].'">'.$pagination[6].'</a></li>';
							if($pagination[7] != '') echo '<li><a href="news?p='.$pagination[7].'">&rsaquo;</a></li>';
							if($pagination[8] != '') echo '<li><a href="news?p='.$pagination[8].'" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
							?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		
	</div>
</section>
