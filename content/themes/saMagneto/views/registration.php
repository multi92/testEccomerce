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
  						<span itemprop="name"><?php echo $language["registration"][1]; //Registracija ?></span>
  					</li>
				</ol>

</div>
<section>
    <div class="container">
       
        <div class="content-page">
            <div class="row">
                <?php if(isset($system_conf["system_b2c"][1]) && $system_conf["system_b2c"][1]==1){ ?>
                <div class="col-sm-8 marginBottom30">
                <div class="registration-holder">
                    <h4 class="marginBottom30"><?php echo $language["register_person"][1]; //Formular za registraciju fizičkog lica ?></h4>
                    <form id="registration-form" class="registration-form"  action="" method="POST" role="form">
                        <div class="row">
                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][2]; //Ime ?>
                                <input type="text" name="first_name" placeholder="<?php echo $language["register_person"][2]; //Ime ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-right">
                                <?php echo $language["register_person"][3]; //Prezime ?>
                                <input type="text" name="last_name" placeholder="<?php echo $language["register_person"][3]; //Prezime ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][4]; //Email ?>
                                <input type="email" name="email" placeholder="<?php echo $language["register_person"][4]; //Email ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][5]; //Lozinka ?>
                                <input type="password" name="password" placeholder="<?php echo $language["register_person"][5]; //Lozinka ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][6]; //Potvrdi lozinku ?>
                                <input type="password" name="password_confirmation" placeholder="<?php echo $language["register_person"][6]; //Potvrdi lozinku ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][8]; //Adresa ?>
                                <input type="text" name="adresa" placeholder="<?php echo $language["register_person"][8]; //Adresa ?>">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][10]; //Poštanski broj ?>
                                <input type="text" name="postanskibr" placeholder="<?php echo $language["register_person"][10]; //Poštanski broj ?>">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][9]; //Mesto ?>
                                <input type="text" name="mesto" placeholder="<?php echo $language["register_person"][9]; //Mesto ?>">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][7]; //Telefon ?>
                                <input type="text" name="telefon" placeholder="<?php echo $language["register_person"][7]; //Telefon ?>" required="required">
                            </div>
                            <div class="col-md-6 reg-input reg-left">
                                <?php echo $language["register_person"][13]; //Datum ?>
                                <input type="date" name="birthday" placeholder="<?php echo $language["register_person"][13]; //Datum ?>">
                            </div>
                            <?php $langdisabled=''; $hidden=''; if(count($lang_data)==1){ $langdisabled='disabled="disabled"'; $hidden='hide'; }?>
                            <div class="col-md-6 reg-input reg-left <?php echo $hidden; ?>">
                                <?php echo $language["register_person"][12]; //Primarni jezik ?>
                                
                                <select class="form-control usersDefaultLang "  name="usersDefaultLang" <?php echo $langdisabled;?> >
                                    <option value="0" class="hide">---Nije izabrano---</option>
                                <?php 
                                    foreach($lang_data as $lang)
                                    {   
                                        $selected='';
                                        if($_SESSION['langid']==$lang['langid']){
                                            $selected='selected="selected"';
                                        }
                                        echo '<option value="'.$lang['langid'].'" '.$selected.'>'.$lang['langname'].'</option>';
                                    }
                                ?>
                            </select>
                               <!--  <input type="text" name="defaultlang" placeholder="<?php //echo $language["register_person"][11]; //Telefon ?>" required="required"> -->
                            </div>

                            <div class="col-md-12 reg-input reg-left">
                                <p><b><?php echo $language["register_description"][1]; // ?><a href="mailto:<?php echo $user_conf["contact_address"][1];?>"><?php echo $user_conf["contact_address"][1];?></a></b></p>
                                
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <br>
                                <input type="submit" name="register_btn" id="register_btn" value="<?php echo $language["register_person"][11]; //Registruj se ?>" class="sa-button reg-btn btnPosalji">
                            </div>

                        </div>
                    </form>
                </div>
                </div>
                <?php } ?>
                <?php if(isset($system_conf["system_b2b"][1]) && $system_conf["system_b2b"][1]==1){ ?>
                <div class="col-sm-6 marginBottom30 hide">
                <div class="registration-holder">
                    <h4 class="marginBottom30"><?php echo $language["register_company"][1]; //Formular za registraciju pravnog lica ?></h4>
                    <form id="registration-company-form" class="registration-form"  action="" method="POST" role="form">
                        <div class="row">

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="first_name" placeholder="<?php echo $language["register_company"][2]; //Ime ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-right">
                                <input type="text" name="last_name" placeholder="<?php echo $language["register_company"][3]; //Prezime ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="company_name" placeholder="<?php echo $language["register_company"][4]; //Ime firme ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="pib" placeholder="<?php echo $language["register_company"][10]; //PIB ?>" required="required">
                            </div>


                            <div class="col-md-6 reg-input reg-left">
                                <input type="email" name="email" placeholder="<?php echo $language["register_company"][11]; //Email ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">    
                                <input type="password" name="password" placeholder="<?php echo $language["register_company"][12]; //Lozinka ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">    
                                <input type="password" name="password_confirmation" placeholder="<?php echo $language["register_company"][13]; //Potvrdi lozinku ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="mesto" placeholder="<?php echo $language["register_company"][6]; //Mesto ?>">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="adresa" placeholder="<?php echo $language["register_company"][5]; //Adresa ?>" required="required">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="postanskibr" placeholder="<?php echo $language["register_company"][9]; //Poštanski broj ?>">
                            </div>

                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="telefon" placeholder="<?php echo $language["register_company"][8]; //Telefon ?>" required="required">
                            </div>
                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" name="datum" placeholder="<?php echo $language["register_company"][15]; //Datum ?>">
                            </div>
                            
                            <div class="col-md-6 reg-input reg-left">    
                                <input type="text" name="fax" placeholder="<?php echo $language["register_company"][7]; //Fax ?>">
                            </div>


                            <div class="col-md-6 reg-input reg-left">
                                <input type="submit" name="register_btn" id="register_company_btn" value="<?php echo $language["register_company"][14]; //Registruj se ?>" class="btn myBtn reg-btn btnPosalji">
                            </div>

                        </div>
                    </form>
                </div>
                </div>
                <?php } ?>
                <?php if(isset($system_conf["system_b2c"][1]) && $system_conf["system_b2c"][1]==1 && isset($system_conf["system_b2b"][1]) && $system_conf["system_b2b"][1]==0){ ?>
                <div class="col-sm-6 marginBottom30 hide">
                <div class="registration-holder2 marginBottom30">
                    <h4 class="marginBottom30"><?php echo $language["login"][1]; //Prijavi se ?></h4>
                    <form id="login-form-page" action="" method="POST" role="form" class="registration-form" >
                        <div class="row">
                            <div class="col-md-6 reg-input reg-left">
                                <input type="text" class="log-in-input log-name-input" id="login_form_username_page" name="login_form_username" tabindex="1"  placeholder="<?php echo $language["login"][2]; // Korisničko ime ?>" value="">
                                <?php 
                                $chk='';
                                if(isset($_COOKIE['username']) && $_COOKIE['username']!='' && isset($_COOKIE['h264']) && $_COOKIE['h264']!=''){
                                    $chk='checked';
                                }
                                ?>
                                <small class="remember_txt"><?php echo $language["loginModal"][4]; // Lozinka ?></small>
                                <input type="checkbox" tabindex="3" class="login_remember"  id="login_form_rememberme_page" name="login_form_rememberme" <?php echo $chk;?>>
                            </div>
                            <div class="col-md-6 reg-input reg-right">
                                <input type="password" class="log-in-input pass-name-input" id="login_form_password_page" name="login_form_password" tabindex="2" placeholder="<?php echo $language["login"][3]; // Lozinka?>">
                                <input type="submit"  id="login_btn_page" name="login_btn_main" tabindex="4" class="btn myBtn reg-btn prijava-button" value="<?php echo $language["loginModal"][5]; //Uloguj se ?>">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="registration-holder2">
                    <h4 class="marginBottom30"><?php echo $language["forgotpassModal"][1]; // Zaboravili ste lozinku??></h4>
                    <p><?php echo $language["forgotpassModal"][2]; //... ?></p>
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
                <?php } ?>
            
            <!-- </div> -->
            <?php if(isset($system_conf["system_b2b"][1]) && $system_conf["system_b2b"][1]==1){ ?>
            <!-- <div class="row"> -->
                <div class="col-sm-4 marginBottom30">
                    <div class="registration-holder2">
                        <h4 class="marginBottom30"><?php echo $language["loginModal"][1]; //Prijavi se ?></h4>
                        <form id="login-form_page" action="" method="POST" role="form" class="registration-form" >
                            <div class="row _unmargin">
                                <div class="col-md-6 reg-input reg-left col-seter">
                                    <input type="text" class="log-in-input log-name-input" id="login_form_username_page" name="login_form_username" tabindex="1"  placeholder="<?php echo $language["login"][2]; // Korisničko ime ?>" value="">
                                <?php 
                                $chk='';
                                if(isset($_COOKIE['username']) && $_COOKIE['username']!='' && isset($_COOKIE['h264']) && $_COOKIE['h264']!=''){
                                    $chk='checked';
                                }
                                ?>
                                    <small class="remember_txt"><?php echo $language["loginModal"][4]; // Lozinka ?></small>
                                    <input type="checkbox" tabindex="3" class="login_remember" id="login_form_rememberme_page" name="login_form_rememberme"  <?php echo $chk;?>>
                                </div>
                                <div class="col-md-6 reg-input reg-right col-seter">
                                    <input type="password" class="log-in-input pass-name-input" id="login_form_password_page" name="login_form_password" tabindex="2" placeholder="<?php echo $language["login"][3]; // Lozinka?>">
                                    <input type="submit"  id="login_btn_page" name="login_btn" tabindex="4" class="btn sa-button reg-btn prijava-button" value="<?php echo $language["loginModal"][5]; //Uloguj se ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4 marginBottom30">
                    <div class="registration-holder2">
                        <h4 class="marginBottom30"><?php echo $language["forgotpassModal"][1]; // Zaboravili ste lozinku??></h4>
                        <p><?php echo $language["forgotpassModal"][2]; //... ?></p>
                        <form action="" id="lost-form" class="zab_form registration-form">
                            <div class="row _unmargin">
                                <div class="col-md-8 reg-input reg-left col-seter">
                                    <input id="lost_email" type="email" name="email" placeholder="<?php echo $language["forgotpassModal"][3]; //Va&scaron;a email adresa ?>">
                                </div>
                                <div class="col-md-4 reg-input reg-right col-seter">
                                    <input id="reset_btn" type="submit" value="<?php echo $language["forgotpassModal"][4]; // Po&scaron;alji?>" class="btn sa-button  reg-btn zab_button">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>  