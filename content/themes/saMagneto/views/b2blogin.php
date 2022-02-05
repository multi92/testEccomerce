
<?php if((!isset($_SESSION["loginstatus"]) || $_SESSION["loginstatus"]!="logged") || (!isset($_SESSION["type"]) || $_SESSION["type"]!="partner" )){ ?>
<section style="background-color: #eee;">

<div class="b2b-login-page">
    <div class="container " style="padding-top: 30px;">


        <div class="row">
            <!-- log in -->
            <div class="col-md-6  marginBottom30">
                    <div class="log-index-holder">
                    <div class="registration-holder2">
                    <h2 class="marginBottom30"><?php echo $language["login"][1]; //Prijavi se ?></h2>
                    <form id="login-form_page" action="" method="POST" role="form" class="registration-form" >
                        <div class="row">
                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" class="log-in-input log-name-input" id="login_form_username_page" name="login_form_username" tabindex="1"  placeholder="<?php echo $language["login"][2]; // Korisničko ime ?>" value="">
                                <?php 
                                $chk='';
                                if(isset($_COOKIE['username']) && $_COOKIE['username']!='' && isset($_COOKIE['h264']) && $_COOKIE['h264']!=''){
                                    $chk='checked';
                                }
                                ?>
                                <small class="remember_txt" ><?php echo $language["loginModal"][4]; // Lozinka ?></small>
                                <input type="checkbox" tabindex="3" class="login_remember"  id="login_form_rememberme_page" name="login_form_rememberme" <?php echo $chk;?>>
                            </div>
                            <div class="col-md-6 reg-input reg-right">
                                <input type="password" class="log-in-input pass-name-input" id="login_form_password_page" name="login_form_password" tabindex="2" placeholder="<?php echo $language["login"][3]; // Lozinka?>">
                                <input type="submit"  id="login_btn_page" name="login_btn_main" tabindex="4" class="btn myBtn reg-btn prijava-button" value="<?php echo $language["loginModal"][5]; //Uloguj se ?>">
                            </div>
                            <div class="col-md-12">
                                <a href="register" class="zab-ll" style="font-size: 1.6rem;"><?php echo $language["loginModal"][6];?></a>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            <div class="col-md-6  marginBottom30">
                    <div class="log-index-holder">
                    <div class="registration-holder2">
                    <h2 class="marginBottom30">Postanite naš partner</h2>
                   
                        <div class="row">
                            <div class="col-md-12 reg-input reg-left">
                            	</br>
                                <small class="remember_txt" style="font-size: 1.6rem;">Da bi ste postali naš partner potrebno je da popunite zahtev za otvaranje naloga</small>
                               </br>
                               </br>
                            </div>
                            
                            <div class="col-md-12">
                                <a href="b2bregister" class="btn myBtn" style="font-size: 1.6rem;">Popunite zahtev</a>
                                </br>
                                </br>
                            </div>
                            
                           
                        </div>
                    
                </div>
                </div>
            </div>
            <!-- <div class="col-md-6 marginBottom30">
                <div class="log-index-holder">
                  <div class="registration-holder2" style="height: 260px;">
                    <h2 class="marginBottom30"><?php echo $language["forgotpassModal"][1]; // Zaboravili ste lozinku??></h2> 
                    <p class="zab-text-term"><?php echo $language["forgotpassModal"][2]; //... ?></p>
                    <form action="" id="lost-form" class="zab_form registration-form">
                        <div class="row">
                            <div class="col-md-6 reg-input reg-left">
                                <input id="lost_email" type="email" name="email" placeholder="<?php echo $language["forgotpassModal"][3]; //Va&scaron;a email adresa ?>">
                            </div>
                            <div class="col-md-6 reg-input reg-right">
                                <input id="reset_btn" type="submit" value="<?php echo $language["forgotpassModal"][4]; // Po&scaron;alji?>" class="btn myBtn reg-btn zab_button">
                            </div>
                        </div>
                    </form>
                    
                  </div>
                </div>
            </div> -->
                <!-- log in end -->
        </div>
    </div>
</div>
</section>
<?php }?>
<section>
    <!-- INFO PANEL -->
    <div class="info-baner-holder hidden-sm hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-6 info-baner col-seter">
                    <a href="<?php echo $theme_conf["hero_menu_link_1"][1]; // hero menu link 1?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_1"][1], 'small'); // hero menu image 1 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][1]; // Besplatna dostava ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 col-xs-6 info-baner col-seter">
                    <a href="<?php echo $theme_conf["hero_menu_link_2"][1]; // hero menu link 2?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_2"][1], 'small'); // hero menu image 2 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][2]; // kako kupiti ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 col-xs-6 info-baner col-seter hide">
                    <a href="<?php echo $theme_conf["hero_menu_link_3"][1]; // hero menu link 3?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_3"][1], 'small'); // hero menu image 3 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][3]; // Kolicinski popust ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 col-xs-6 info-baner col-seter">
                    <a href="<?php echo $theme_conf["hero_menu_link_4"][1]; // hero menu link 4?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_4"][1], 'small'); // hero menu image 4 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][4]; // Bezbedna kupovina ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div> 
            </div>
        </div>
    </div>              
    <!-- INFO PANEL END -->
</section>

