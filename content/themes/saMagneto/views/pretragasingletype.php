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
  						<span itemprop="name"><?php echo $language["pretraga"][1]; // Pretraga ?></span>
  					</li>
				</ol>

</div>
<section>			
<div class="container">
	<div class="content-page">
		<div class="row">
    	<div class="col-sm-12">
        	<?php if($type == "doc" || $type == "news"){ ?>
        	<ul class="nav nav-pills nav-stacked">
            
            	<?php
					$hasdata = false;	
					for($i = $limitstart; $i< $limitend; $i++){
						
						if(!isset($data[$i])) continue;
						
				?>
                	<li class="bottomBorderDotted">
                            <div>
                                
                                <?php
									if($type == "doc"){
										echo '
										<a href="'.$data[$i]['filepath'].'">
											<h3 class="pull-left noTopMargin">'.$data[$i]['name'].".".pathinfo($data[$i]['filepath'], PATHINFO_EXTENSION).'</h3>
										</a>
										<p class="pull-right text-info">'.$language['pretraga'][3].'</p>
										<div class="clearfix"></div>
										<p>';
										foreach($data[$i]['paths'] as $k=>$v){
											$url .= $v.DIRECTORY_SEPARATOR;
											echo '<a href="'.$v['url'].'">'.$v['name'].'</a>/';
										}
										echo "</p>";
									}
									if($type == 'news'){
										echo '<div class="row news-section" style="padding: 20px;">';
												$hasdata = true;
												$val=$data[$i];
												//var_dump($val);
													echo '<div class="col-md-12 news-bar-holder ">
															<div class="news-pic-holder" style="background-image:url(\''.$val["thumb"].'\');">
															</div>
															<h4><a href="news/'.$val["id"].'">'.$val["name"].'</a></h4>
															<i>'.$language["pretraga"][6].' '.$val["owner"].'</i>
															<p class="kalendar "><span class="fa fa-calendar" aria-hidden="true"></span>'.$val["adddate"].'</p><br><br>
															<p class="text-left">'.$val["shortnews"].'</p>
															<a href="news/'.$val["id"].'">'.$language["pretraga"][7].'</a>
														</div>';
										echo '</div>';
											
											
										
										
									}
									
								?>
                            </div>
                    </li>
                
                <?php } ?>
                <?php if(!$hasdata) echo '<div class="col-sm-12"><h3>'.$language['pretraga'][5].'</h3></div>';?>                
              </ul>
              <?php } ?>

              <div class="row">
              <?php
			  	if($type == 'prod'){
					for($i = $limitstart; $i< $limitend; $i++){
						if(!isset($data[$i])) continue;
						echo '<div class="col-md-3 col-sm-4">
							<div class="product">
								<div class="image">
									<a href="proizvod-detalji.php">
										<img src="http://unsplash.it/190/190/?random" alt="" class="img-responsive image1">
									</a>
								</div>
								<!-- /.image -->
								<div class="text">
									<h3><a href="proizvod-detalji.php">'.$data[$i]->name.'</a></h3>
									<p class="price">'.$data[$i]->price*((100-$data[$i]->rebate)/100)*((100+$data[$i]->tax)/100).'</p>
									<p>
										<a href="" class="btn btn-template-main"><i class="fa fa-shopping-cart"></i>Dodaj u korpu</a>
									</p>
								</div>
								<!-- /.text -->
							</div>
							<!-- /.product -->
						</div>';
					}
				}
			  ?>
              </div>
              
              <ul class="pagination pull-right">
                	<?php

						if($pagination[0] != '') echo '<li><a href="pretraga/?'.$pagingparams.'&p='.$pagination[0].'#"  aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
						if($pagination[1] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[1].'#">&lsaquo;</a></li>';
						if($pagination[2] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[2].'#">'.$pagination[2].'</a></li>';
						if($pagination[3] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[3].'#">'.$pagination[3].'</a></li>';
						if($pagination[4] != '') echo '<li class="active"><a href="pretraga?'.$pagingparams.'&p='.$pagination[4].'#">'.$pagination[4].'</a></li>';
						if($pagination[5] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[5].'#">'.$pagination[5].'</a></li>';
						if($pagination[6] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[6].'#">'.$pagination[6].'</a></li>';
						if($pagination[7] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[7].'#">&rsaquo;</a></li>';
						if($pagination[8] != '') echo '<li><a href="pretraga?'.$pagingparams.'&p='.$pagination[8].'#" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
					?>
                </ul>
        </div>
    </div>
	</div>
	
</div>
</section>