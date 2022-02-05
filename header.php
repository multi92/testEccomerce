
<?php include('app/controller/controller_categoryMobileMenu.php');?>
<?php if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged" && isset($_SESSION["type"]) && $_SESSION["type"]=="commerc"){?>
<?php 	include('app/controller/core/controller_header_commercialist_bar.php');?>
<?php } else { ?>
<?php //	include('app/controller/controller_newsbar.php');?>
<?php } ?>

<div class="contact-header ">
	<div class="container ">
		<div class="row">
			<div class="col-sm-8">
				<ul class="phone-list hidden-xs left">
					<li class="items"><span class="static">Fizička lica:</span><a class="links" href="tel:0184511085">+381 18 4151477</a></li>
					<li class="items"><span class="static">Pravna lica:</span> <a class="links" href="tel:0604511085">+381 18 552222</a></li>
					<li class="items">
						<img src="/fajlovi/logo/viber.png" alt="viber" title="Viber" loading="lazy" class="img-responsive image viber">
						 <img src="/fajlovi/logo/whatsapp.png" alt="WhatsApp" title="WhatsApp" loading="lazy" class="img-responsive image">
				 
									
						<a class="links" href="tel:062800-7713">+381605609764</a>
					</li>
				</ul>
			</div>
			<div class="col-sm-4">
				<ul class="social-ul-head">
					<li><a href="#" target="_blank" title="Facebook"><img src="/fajlovi/socialnetworks/128x128/small/facebook-logo-png-2343.png" alt="social softart" loading="lazy" title="Facebook" class="img-responsive"></a></li>
					<!-- <li><a href="#" target="_blank" title="Youtube"><img src="content/themes/saMagneto/img/icons/youtube.png" alt="social softart" class="img-responsive"></a></li> -->
						<li><a href="#" target="_blank" title="Instagram"><img src="/fajlovi/socialnetworks/128x128/small/instagram-logo-png-41285.png" alt="social softart" loading="lazy" title="Instagram" class="img-responsive"></a></li>
					<!-- <li><a href="#" target="_blank" title="Twitter"><img src="content/themes/saMagneto/img/icons/twitter.png" alt="social softart" class="img-responsive"></a></li> -->
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- <div class="p-3 mb-2 bg-danger text-white contact-header " >
	<div class="container ">
		<div class="row">
			<div class="bg-danger col-sm-8">
				<ul class="phone-list hidden-xs left">
					<li class="items">
						<span class="static">Fizicka lica</span>
						<a class="links" href="tel:063334866">+381 18 4151477</a>
					</li>
					<li class="items">
					<span class="static">Pravna lica:</span>
					<a class="links" href="tel:0604511085">+381 18 552222</a>
					</li>
					<li class=" items">
					<img src="fajlovi/logosHome/small/viber.png" alt="viber" title="Viber" loading="lazy" class="img-responsive image viber">
					<img src="fajlovi/logosHome/small/whatsapp.png" alt="WhatsApp" title="WhatsApp" loading="lazy" class="img-responsive image">
					<a class="links" href="tel:062800-7713">+381605609764</a>
					</li>
				</ul>
			</div>
			<div class="d-inline col-sm-4">
				<ul class="social-ul-head">
					<li><a href="#" target="_blank" title="Facebook"><img src="content/themes/saMagneto/img/icons/facebook.svg" alt="social softart" loading="lazy" title="Facebook" class="img-responsive"></a></li>
					<li><a href="#" target="_blank" title="Youtube"><img src="content/themes/saMagneto/img/icons/youtube.png" alt="social softart" class="img-responsive"></a></li>
						<li><a href="#" target="_blank" title="Instagram"><img src="content/themes/saMagneto/img/icons/instagram.svg" alt="social softart" loading="lazy" title="Instagram" class="img-responsive"></a></li>
					<li><a href="#" target="_blank" title="Twitter"><img src="content/themes/saMagneto/img/icons/twitter.png" alt="social softart" class="img-responsive"></a></li>
				</ul>
			</div>
		</div>
	</div>
</div> -->


	<div class="container header-container hide">
		<div class="top-menu ">
		<div class="row">
			<div class="col-sm-8 col-xs-5 top-menu-col ">
				<?php if((!isset($_SESSION["loginstatus"]) || $_SESSION["loginstatus"]!="logged") && ($system_conf["system_b2b"][1]=='1')){?>
				<ul class="top-menu-left-ul  hidden-xs" >
					<a class=" sa-button" style="background-color: #000;    color: #333;" href="b2blogin" itemprop="url">B2B</a>	
				</ul>
				<?php }?>
				<ul class="top-menu-left-ul -user-part" >
					<!-- HARDKODIRAN ELEMENT -->
					<?php if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged"){?>

						<?php if(isset($_SESSION["type"]) && $_SESSION["type"]=="commerc"){?>
							<!-- <li ><a href="commercialist_select_partner"  ><i class="material-icons" style="font-size: 18px;vertical-align: middle; padding-left:3px;">group</i></a></li> -->
						<?php } ?>
						<li ><a href="userpanel"  title="<?php  echo $language["header"][1];?>" > <span><?php  echo $language["header"][2];?>, <?php echo $_SESSION['ime']." ".$_SESSION['prezime'] ?></span> </a></li>
						<!-- <li ><a  id="signOutMenu" title="<?php  echo $language["header"][3];?>" > <?php  echo $language["header"][3];?> </a></li> -->

					<?php } else { ?>
						<li>
							<a data-toggle="modal" data-target=".bs-example-modal-sm"><?php  echo $language["header"][4]; //Prijavi se?></a>
						</li>
						<li>
							<a href="register" itemprop="url"><?php  echo $language["header"][5]; //Registrujte se?></a>
						</li>	
						<!-- END HARDKODIRAN ELEMENT -->
					<?php }?>
				</ul>
				<ul class="top-menu-left-ul  hidden-xs" >

					<?php foreach($headermenudata AS $hval){ ?>
						<?php if($hval['menutype']=='s'){ ?>
							<li>
								<a href="<?php echo $hval['link'];?>" itemprop="url"><?php echo $hval['value'];?></a>
							</li>
						<?php } ?>
					<?php } ?>
				</ul>
				<ul class="list hidden-sm hidden-xs hide">
					<li class="items"><span class="static"><?php  echo $language["header"][6]; //Telefon?>:</span> <span class="dinamic"><?php echo $user_conf["phone"][1];?></span></li>
					<li class="items"><span class="static"><?php  echo $language["header"][7]; //Email?>:</span> <span class="dinamic"><?php echo $user_conf["contact_address"][1];?></span></li>
				</ul>
			</div>
			<div class="col-sm-4 col-xs-7 top-menu-col">
				<select name="changeLanguage"  class="go-right mil-lang cms_selectLanguage">
					<?php 
					$db = Database::getInstance();
					$mysqli = $db->getConnection();
					$mysqli->set_charset("utf8");

					$q = "SELECT * FROM languages ORDER BY `default` ASC";
					$res = $mysqli->query($q);
					if($res->num_rows > 0){
						while($row = $res->fetch_assoc())
						{
							$selected='';
							if($_SESSION["langid"]==$row['id']){
								$selected='selected';
							}

							echo '<option  value="'.$row['id'].'" langid="'.$row['id'].'" '.$selected.'>'.ucfirst($row["name"]).'</option>';

						}
					}
					?> 
				</select>
				
				<ul class="top-menu-right-ul go-right">
					<li>
						<a class="search">
							<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["search"][1]; ?>" alt="<?php echo $language["global"][2]; //Pretrazi ?>" class="img-responsive visible-xs">
						</a>
					</li>

					



					</ul>

				</div>
			</div>
		</div>
	</div>






<div class="left-mil">
    <a href="#"></a>
</div>
<div class="right-mil">
    <a href="#"></a>
</div>
