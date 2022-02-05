<?php //DEVELOPER MODE
if($system_conf["developer_mode"][1]==1){
	echo '<!--COMMENT-->';
	echo '<!--VIEW TEAM-->';
	echo '<!--PATH views/team.php-->';	
}?>
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
  						<span itemprop="name"><?php echo $language["team"][1]; //Naš tim ?></span>
  					</li>
				</ol>

</div>
<section class="pos">
	<div class="gallerys-bckg  cms-galleries-bottom-bckg" ></div>
	<div class="container">
		<div class="row marginBottom30">
			<div class="col-md-12">
				<h4 class="after"><?php echo $language["team"][2]; //Upoznajte naš tim ?></h4>
			</div>
		</div>
		<div class="row marginBottom30">
			<div class="col-md-12">
				<!-- ODNOS 3:1 -->
				<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["team_top_background"][1]; ?>" alt="team" class="img-responsive">
			</div>
		</div>
		<div class="row">
			<?php foreach($persons[1] as $key=>$val){ ?>
			<div class="col-md-3 col-sm-4 col-xs-6 col-xs">
				<?php include($system_conf["theme_path"][1].'views/includes/personbox/personBox.php');?>
			</div>
			<?php } ?>
		</div>
		<?php if($theme_conf["show_all_team_members"][1] != 1){ ?>
		<div class="row">
			<div class="col-md-12">
				<nav aria-label="Page navigation">
  					<ul class="pagination">
					<?php 	
  					  if($pagination[0] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[0].'" aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
  					  if($pagination[1] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[1].'">&lsaquo;</a></li>';
  					  if($pagination[2] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[2].'">'.$pagination[2].'</a></li>';
  					  if($pagination[3] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[3].'">'.$pagination[3].'</a></li>';
  					  if($pagination[4] != '') echo '<li class="active"><a href="team/'.$command[1].'?p='.$pagination[4].'">'.$pagination[4].'</a></li>';
					  if($pagination[5] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[5].'">'.$pagination[5].'</a></li>';
  					  if($pagination[6] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[6].'">'.$pagination[6].'</a></li>';
  					  if($pagination[7] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[7].'">&rsaquo;</a></li>';
  					  if($pagination[8] != '') echo '<li><a href="team/'.$command[1].'?p='.$pagination[8].'" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
					?>
  					</ul>
				</nav>
			</div>
		</div>
		<?php } ?>
	</div>
</section>
<?php //DEVELOPER MODE
if($system_conf["developer_mode"][1]==1){
	echo '<!--VIEW TEAM END-->';	
}?>
