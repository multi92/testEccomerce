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
	<div class="row">
        <div class="col-xs-12">
            <div class="tabs">
                <ul class="nav nav-tabs nav-justified order-tabs" role="tablist" style="margin: 30px 0; ">
				    <li role="presentation" class="active"><a href="#tabpro" aria-controls="tabpro" role="tab" data-toggle="tab" style="border-left: 1px solid #ccc;"><?php echo $language['pretraga'][3]; ?></a></li>
					<li role="presentation"><a href="#tabdoc" aria-controls="tabdoc" role="tab" data-toggle="tab"><?php echo $language['pretraga'][4]; ?></a></li>
                    <li role="presentation"><a href="#tabnews" aria-controls="tabnews" role="tab" data-toggle="tab"><?php echo 'Novosti'; ?></a></li>
					<!--<li role="presentation"><a href="#tabpage" aria-controls="tabpage" role="tab" data-toggle="tab">Stranice</a></li> -->
                    </li>
                </ul>
                
                <div class="tab-content ">
                    <div role="tabpanel" class="tab-pane active" id="tabpro">
                        <div class="row" style="padding: 20px;">
							<?php
							$hasdata = false;
							for($i = $prolimitstart; $i< $prolimitend; $i++){
								if(!isset($prodata[$i])) continue;
								$hasdata = true;
                                $val=$prodata[$i];
									echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">';
									include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");
									echo '</div>';
							}
							if(!$hasdata) echo '<div class="col-sm-12"><h3>'.$language['pretraga'][5].'</h3></div>';
                            ?>
                          </div>
                    </div>
                    <!-- /.tab -->
                    <div role="tabpanel" class="tab-pane" id="tabnews">
                        <div class="row news-section" style="padding: 20px;">
							<?php
							$hasdata = false;
							for($i = $newslimitstart; $i< $newslimitend; $i++){
								if(!isset($newsdata[$i])) continue;
								$hasdata = true;
                                $val=$newsdata[$i];
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
							}
							if(!$hasdata) echo '<div class="col-sm-12"><h3>'.$language['pretraga'][5].'</h3></div>';
                            ?>
                          </div>
                    </div>
                    <!-- /.tab -->
                    

                    <div class="tab-pane" id="tabdoc" style="padding: 20px;">
							<?php
								$hasdata = false;
                                for($i = $doclimitstart; $i< $doclimitend; $i++){
                                    if(!isset($docdata[$i])) continue;
									$hasdata = true;
                            ?>
                                <div class="row doc-holder">
								<ol class="breadcrumb ">
									<li >
									<?php
                                        $url = "";
										foreach($docdata[$i]['paths'] as $k=>$v){
											echo '<a  href="'.$v['url'].'">'.$v['name'].'</a> /';
										}
                                    ?>
                                        
									</li>
								</ol>
                                <a href="<?php echo $docdata[$i]['filepath']; ?>" class="btn myBtn add2cart cart-button"><?php echo $docdata[$i]['name']; ?>&nbsp;<i class="fa fa-download" aria-hidden="true"></i></a>    								
								</div>
                            <?php }
							if(!$hasdata) echo '<div class="col-sm-12"><h3>'.$language['pretraga'][5].'</h3></div>';?>    
							</div>
                    <!-- /.tab -->
                    
                    <!--<div class="tab-pane" id="tabpage" style="padding: 20px;">
						   
                    </div>-->
                    <!-- /.tab -->
                </div>
                <div class="row text-center">
					<nav aria-label="Page navigation ">
					<ul class="pagination">
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
					</nav>
				</div>
                
            </div>
            <!-- /.tabs -->
        </div>
    </div>
</div>
</section>