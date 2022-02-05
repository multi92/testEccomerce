<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
  					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
  							<span itemprop="name"><?php echo $language["global"][3]; ?></span>
  						</a>
						
  					</li>
					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="news" itemprop="item">
  							<span itemprop="name"><?php echo $language["news"][1]; //Vesti ?></span>
  						</a>
						
  					</li>
  					
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $news['main']->title; //Vest ?></span>
  					</li>
				</ol>

</div>
<section>
	<div class="container">
		<div class="content-page">
			<div class="row _unmargin">
			<div class="col-md-9 col-sm-8 col-xs-7 col-xs">
				<div class="single-news-holder" itemscope itemtype="http://schema.org/Article">
					<div class="single-news-pic">
						<!-- PREPORUKA ZA ODNOS SLIKE 2:1 -->
						<img src="<?php echo GlobalHelper::getImage($news['main']->thumb, 'big'); ?>" alt="news" class="img-responsive" itemprop="image">
					</div>
					<div class="single-news-body">
						<h3 itemprop="name"><?php echo $news['main']->title; //Vest ?></h3>
						<small>Autor: <span itemprop="author"><?php echo $user_conf["company"][1];?></span></small>
						<span class="timeSpan">
							<time datetime="<?php echo $news['main']->date; ?>" itemprop="datePublished"><?php echo $news['main']->date; ?></time>
						</span>
						<br>
						<br>
						<br>
						<span itemprop="articleBody">
						<?php echo str_replace('<iframe ', '<iframe allowfullscreen ',$news['main']->body); ?>
						</span>
						
					</div>
<!-- NEWS GALLERY-->
					<div class="view-gallery">
						<ul class="gallery-ul">
						
							<?php 
								foreach($news['main']->galleryitems[1] as $k=>$v){
									
									echo '<li class="gallery-li">
												<a href="'.GlobalHelper::getImage($v->item, 'big').'" data-fancybox="gallery" data-caption="Neki opis">
													<img src="'.GlobalHelper::getImage($v->item, 'small').'" class="img-responsive" alt="" />
												</a>
											</li>';	
								}
							?>
														
						</ul>
					</div>
<!-- NEWS GALLERY END-->
<!-- TWITTER TWEET BUTTON-->
					<div class="row marginTop30">
						<ul class="contact-social-ul">
                	    <?php if($socialnet_conf["twitter_share"][1]==1){?>
                	    	<li><?php echo $socialnet_conf["twitter_share_btn"][1];?></li>
                	    <?php } ?>
                		</ul>
					</div>
<!-- TWITTER TWEET BUTTON END-->
<!-- FACEBOOK LIKE SHARE -->
			    	<div class="fb-share-button" 
			    	  data-href="<?php echo $_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];?>" 
			    	  data-layout="button_count" >
			    	</div>
			    	<div class="fb-like" data-href="<?php echo $_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
<!-- FACEBOOK LIKE SHARE END-->
					
				</div>
				<div class="row _unmargin">
			<div class="col-md-9  marginTop30">
				<?php if(isset($news['pre'])) { ?>
					<a href="news/<?php echo $news['pre']->id; ?>" class="go-left"><i class="fa fa-angle-left" aria-hidden="true"></i> Prethodna vest</a>
				<?php } ?>
				<?php if(isset($news['next'])) { ?>
					<a href="news/<?php echo $news['next']->id; ?>" class="go-right">Sledeća vest <i class="fa fa-angle-right" aria-hidden="true"></i></a>
				<?php } ?>
			</div>
		</div>
			</div>
			<!--Right Panel-->
			<div class="col-md-3 col-sm-4 col-xs-5 col-xs">
				<?php include ("app/controller/controller_rightcolumn.php") ; ?>
				<div class="news-banners">
					<?php include_once("app/controller/controller_banner_right.php");?>
					<!-- <div class="banners">
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
		
		</div>
		
	</div>
</section>