<?php //DEVELOPER MODE
if($system_conf["developer_mode"][1]==1){
	echo '<!--COMMENT-->';
	echo '<!--SEGMENT PERSON BOX-->';
	echo '<!--THEME PATH views/includes/personbox/personBox.php-->';	
}?>
<div class="team-holder transition" itemscope="" itemtype="http://schema.org/Person">
					<div class="team-pic">
						<!-- ODNOS SLIKE POZELJNO 1:1 -->
						<img src="<?php echo GlobalHelper::getImage($val->picture, 'big');?>" alt="nas tim" class="img-responsive" itemprop="image">
						<div class="team-name transition">
							<h4 itemprop="name"><?php echo $val->name;?></h4>
						</div>
					</div>
					<div class="team-body">
						<h4 itemprop="jobTitle"><?php echo $val->title;?></h4>
						<p><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["smartphone"][1]; ?>" alt="<?php echo $val->name;?>"> <span itemprop="telephone" ><?php echo $val->phone;?></span></p>
						<p><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["mail"][1]; ?>" alt="<?php echo $val->name;?>"> <span itemprop="email"><a href="mailto:<?php echo $val->email;?>"><?php echo $val->email;?></a></span></p>
						<p>
						<?php if($theme_conf["show_team_members_social_networks"][1]==1) { ?>
							<span>
							<?php if(count($val->socialnetworksdata)>0) { ?>
								<?php foreach($val->socialnetworksdata as $scval) { ?>
								<a href="<?php echo $scval["link"]; ?>" itemprop="url" target="_blank"><img src="<?php echo $scval["icon"]; ?>" alt="<?php echo $scval["name"]; ?>" title="<?php echo $scval["name"]; ?>"></a>
								<?php } ?>
							<?php } ?>
							</span>
						<?php } ?>
						</p>
						<!-- <button type="button" class="btn myBtn team-modal-btn" data-toggle="modal" data-target="#myModal">Više informacija</button> -->
					</div>
</div>
<?php //DEVELOPER MODE
if($system_conf["developer_mode"][1]==1){
	echo '<!--SEGMENT PERSON BOX END-->';	
}?>


<!-- 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Petar Petrovic</h4>
			</div>
			<div class="modal-body clearfix" >
				<div class="team-modal-body" >
					<h5>Pozicija</h5>
					<p>Direktor</p>
					<h5>Telefon</h5>
					<p>+381 64 1234 -123</p>
					<h5>Email adresa</h5>
					<p>vasa.email@adresa.com</p>
					
				</div>
				<div class="team-modal-pic">
					<img src="img/person.jpg" alt="tim" class="img-responsive">
				</div>
				
				<div class="team-modal-txt">
					<hr>
					<h5>Opis</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum velit blanditiis, quod officia pariatur praesentium eveniet ad et aliquid, sapiente reiciendis ducimus fuga totam ullam voluptatum consequatur nisi nesciunt, ex esse, suscipit modi iure harum maxime. Corporis reiciendis, officia aliquam in possimus ea necessitatibus autem. Aperiam ratione unde velit aspernatur obcaecati adipisci facilis tenetur sint, commodi cupiditate nemo rem quia corporis corrupti, consequatur! Asperiores eligendi nisi, adipisci.</p>
				</div>
					
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
				
			</div>
		</div>
	</div>
</div> -->