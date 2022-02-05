<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
  					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
  							<span itemprop="name"><?php echo $language["global"][3]; ?></span>
  						</a>
  					</li>
					<?php
						$cnt=count($command);
						$path = '';
						for($i=0;$i<$cnt;$i++){
							$path .= $command[$i].'/';
							if($i==0 && $cnt==1){
								?>
								<li class="active" itemprop="itemListElement" itemscope
									itemtype="http://schema.org/ListItem">
										<span itemprop="name"><?php echo $language["documents"][1]; ?></span>
								</li>
								<?php
							} else if($i==0 && $cnt>1){
								?>
								<li itemprop="itemListElement" itemscope
									itemtype="http://schema.org/ListItem">
										
									<a href="<?php  echo $path ;?>" itemprop="item">
										<span itemprop="name"><?php echo $language["documents"][1]; ?></span>
									</a>
								</li>
								<?php
							} else if($i==$cnt-1){
								?>
								<li class="active" itemprop="itemListElement" itemscope
									itemtype="http://schema.org/ListItem">
									<span itemprop="name"><?php echo rawurldecode($command[$i]);?></span>
								</li>
								<?php
							} else {
								?>
								<li itemprop="itemListElement" itemscope
									itemtype="http://schema.org/ListItem">
									<a href="<?php  echo $path ;?>" itemprop="item">
										<span itemprop="name"><?php echo rawurldecode($command[$i]); ?></span>
									</a>
								</li>
								<?php
							}
						}
					?>
				</ol>

</div>
<section class="pos">
    <div class="gallerys-bckg" style="background-image: url(<?php echo $system_conf["theme_path"][1];?>'img/bckg1.png');"></div>
    <div class="container">
    	<div class="content-page">
    		<div class="row _unmargin">
			<?php
			foreach($folders as $k=>$v){ 
				include($system_conf["theme_path"][1]."views/includes/documentbox/folderBox.php");
			}
			?>
            <?php
			foreach($files as $k=>$v){
				$name = ucfirst($v[0]->name).'.'.$v[0]->ext;
				if($v[0]->showname != ''){
					$name = ucfirst($v[0]->showname);	
				}
					
				$ext='';
				if($v[0]->ext=='pdf'){
					$ext=$system_conf["theme_path"][1].$theme_conf["pdf"][1];
				} else if($v[0]->ext=='txt'){
					$ext=$system_conf["theme_path"][1].$theme_conf["txt"][1];
				} else if($v[0]->ext=='doc'){
					$ext=$system_conf["theme_path"][1].$theme_conf["doc"][1];
				} else if($v[0]->ext=='xls'){
					$ext=$system_conf["theme_path"][1].$theme_conf["xls"][1];
				} else if($v[0]->ext=='xlsx'){
					$ext=$system_conf["theme_path"][1].$theme_conf["xlsx"][1];
				} else {
					$ext=$system_conf["theme_path"][1].$theme_conf["file"][1];
				}
				if(isset($v[0]->showimage) && $v[0]->showimage!=$system_conf["theme_path"][1].$theme_conf["no_img"][1]){
					$ext=$v[0]->showimage;
				}

				include($system_conf["theme_path"][1]."views/includes/documentbox/fileBox.php");
			}
			?>                           
        </div>
    	</div>
        
    </div>
</section>