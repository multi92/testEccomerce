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
  						<span itemprop="name"><?php echo $language["kontakt"][1];?></span>
  					</li>
				</ol>

</div>
<section class="pos" itemscope itemtype="http://schema.org/ContactPage">
    <div class="gallerys-bckg" ></div>
    <div class="container">
        <div class="content-page">
           <div class="row _unmargin">
            <div class="col-md-6" itemscope itemtype="http://schema.org/LocalBusiness">
                <h4 class="after marginBottom30"><?php echo $language["kontakt"][2]; //Kontakt informacije ?></h4>
                <?php foreach($shops as $sval){?>
                    <h3><strong itemprop="name"><?php echo $sval->name;  ?></strong></h3>
                    <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                        <strong><?php echo $language["kontakt"][4]; //Adresa: ?>:</strong>
                        <span itemprop="streetAddress"><?php echo  $sval->address;   //Adresa ?></span>
                        <span itemprop="addressLocality"> <?php echo $sval->cityname; //Grad ?></span>, 
                        <span itemprop="addressRegion"><?php echo $user_conf["country"][1]; //Država ?></span></p>
                <?php if(strlen($sval->phone)>0) { ?>
                <p itemprop="telephone"><strong><?php echo $language["kontakt"][5]; //Telefon: ?>:</strong> <?php echo $sval->phone; //Telefon ?> </p>
                <?php } ?>
                <?php if(strlen($sval->cellphone)>0) { ?>
                <p itemprop="telephone"><strong><?php echo $language["kontakt"][5]; //Telefon: ?>:</strong> <?php echo $sval->cellphone; //Telefon ?> </p>
                <?php } ?>
                
                <?php if(strlen($user_conf["fax"][1])>0) { ?>
                <p itemprop="faxNumber"><strong><?php echo $language["kontakt"][6]; //Fax: ?>:</strong> <?php echo $user_conf["fax"][1]; //Fax ?></p>
                <?php } ?>
                <?php if(strlen($sval->email)>0) { ?>
                <p itemprop="email"><strong><?php echo $language["kontakt"][7]; //Email: ?>:</strong> <?php echo $sval->email; //Email ?></p>
                <?php } ?>
                <?php $worktime = json_decode($sval->worktime, true); ?>
                
                <p itemprop="email"><strong><?php echo $language["kontakt"][19]; //Radno vreme: ?>:</strong> 
                     <?php echo ($worktime['mf']['from'] == "")? "": $language["shops"][2].": ".$worktime['mf']['from']." - ".$worktime['mf']['to']; ?>
                     <?php echo ($worktime['st']['from'] == "")? "": $language["shops"][3].":".$worktime['st']['from']." - ".$worktime['st']['to']; ?>
                     <?php echo ($worktime['su']['from'] == "")? $language["shops"][4].": ".$language["shops"][5]: $language["shops"][4].": ".$worktime['su']['from']." - ".$worktime['su']['to']; ?>
                </p>
                
                <?php } ?>
                <br>
                <?php if($theme_conf["show_contact_social_networks_holder"][1]==1) {?>
                <ul class="contact-social-ul">
                    <?php if(strlen($theme_conf["facebook_link"][1])>0 && strlen($theme_conf["facebook_icon"][1])>0 ) {?>
                    <li><a href="<?php echo $theme_conf["facebook_link"][1]; ?>" target="_blank" title="Facebook" itemprop="url"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["facebook_icon"][1]; ?>" alt="icons" class="img-responsive"></a></li>
                    <?php } ?>
                    <?php if(strlen($theme_conf["youtube_link"][1])>0 && strlen($theme_conf["youtube_icon"][1])>0) {?>
                    <li><a href="<?php echo $theme_conf["youtube_link"][1]; ?>" target="_blank" title="Youtube" itemprop="url"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["youtube_icon"][1]; ?>" alt="icons" class="img-responsive"></a></li>
                    <?php } ?>
                    <?php if(strlen($theme_conf["instagram_link"][1])>0 && strlen($theme_conf["instagram_icon"][1])>0) {?>
                        <li><a href="<?php echo $theme_conf["instagram_link"][1]; ?>" target="_blank" title="Instagram"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["instagram_icon"][1]; ?>" alt="social softart" class="img-responsive"></a></li>
                    <?php } ?>
                    <?php if(strlen($theme_conf["twitter_link"][1])>0 && strlen($theme_conf["twitter_icon"][1])>0) {?>
                    <li><a href="<?php echo $theme_conf["twitter_link"][1]; ?>" target="_blank" title="Twitter" itemprop="url"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["twitter_icon"][1]; ?>" alt="icons" class="img-responsive"></a></li>
                    <?php } ?>
                    <?php if(strlen($theme_conf["googleplus_link"][1])>0 && strlen($theme_conf["googleplus_icon"][1])>0) {?>
                    <li><a href="<?php echo $theme_conf["googleplus_link"][1]; ?>" target="_blank" title="Google Plus" itemprop="url"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["googleplus_icon"][1]; ?>" alt="icons" class="img-responsive"></a></li>
                    <?php } ?>
                    <?php if(strlen($theme_conf["linkedin_link"][1])>0 && strlen($theme_conf["linkedin_icon"][1])>0) {?>
                    <li><a href="<?php echo $theme_conf["linkedin_link"][1]; ?>" target="_blank" title="linkedin" itemprop="url"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["linkedin_icon"][1]; ?>" alt="icons" class="img-responsive"></a></li>
                    <?php } ?>
                    
                <?php if($socialnet_conf["social_networks"][1]==1){?>
                    
                <ul class="contact-social-ul">
                    <?php if($socialnet_conf["twitter_folowus"][1]==1){?>
                    <li><?php echo $socialnet_conf["twitter_folowus_btn"][1];?></li>
                    <?php } ?>
                </ul>
                <?php } ?>
                <?php } ?>
            </div>

            <div class="col-sm-6">
                <h4 class="after marginBottom30"><?php echo $language["kontakt"][8]; //Kontaktirajte nas ?></h4>
                <form class="form-horizontal jq_contact_form" id="contactForm" name="sentMessage" novalidate method="POST">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $language["kontakt"][7]; //Email ?></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $language["kontakt"][7]; //Email ?> *" required data-validation-required-message="<?php echo $language["kontakt"][9]; //Email ?>">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $language["kontakt"][10]; //Broj tel. ?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $language["kontakt"][11]; //Broj telefona ?>">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label"><?php echo $language["kontakt"][12]; //Ime ?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo $language["kontakt"][13]; //Vaše ime ?> *" required data-validation-required-message="<?php echo $language["kontakt"][14]; ?>">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputmessage3" class="col-sm-2 control-label"><?php echo $language["kontakt"][15]; //Tekst poruke ?></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" name="message" id="message" required data-validation-required-message="<?php echo $language["kontakt"][16]; //Unesite poruku ?>"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="sa-button _full-width"><?php echo $language["kontakt"][17]; //Pošalji ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
        </div>
        
		
    </div>
    
</section>


<?php include('views/map.php');?>