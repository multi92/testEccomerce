<!-- Log In modal -->
    <div id="loginModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"><!--bs-example-modal-lg-->
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a class="active" id="login-form-link"><?php echo $language["login"][1];?></a>
                                </div>
                                <div class="col-xs-6">
                                    <a id="register-form-link"><?php echo $language["register"][1];?></a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" action="" method="POST" role="form" style="display: block;">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="login_form_username" name="login_form_username" tabindex="1"  placeholder="<?php echo $language["login"][2];?>" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="login_form_password" name="login_form_password" tabindex="2" placeholder="<?php echo $language["login"][3];?>">
                                        </div>
                                        <div class="form-group text-center">
											<?php 
											$chk='';
											if(isset($_COOKIE['username']) && $_COOKIE['username']!='' && isset($_COOKIE['h264']) && $_COOKIE['h264']!=''){
												$chk='checked';
											}
										    ?>
                                            <input type="checkbox" tabindex="3" class="" name="login_form_rememberme" id="login_form_rememberme" <?php echo $chk;?>>
                                            <label for="login_form_rememberme"> <?php echo $language["login"][4];?></label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login_btn" id="login_btn" tabindex="4" class="form-control btn myBtn" value="<?php echo $language["login"][5];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="" tabindex="5" class="forgot-password" data-toggle="modal" data-target=".bs-example-modal-sm"><?php echo $language["login"][6];?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="registration-form" action="" method="POST" role="form" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" name="first_name" id="first_name" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][2];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][2];?> je obavezno!</span>
                                        </div>
										<div class="form-group">
                                            <input type="text" name="last_name" id="last_name" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][3];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][3];?> je obavezno!</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][4];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][4];?> je obavezno!</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="<?php echo $language["register"][5];?>">
											<span class="help-block hide" >Polje <?php echo $language["register"][5];?> je obavezno!</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation" tabindex="2" class="form-control" placeholder="<?php echo $language["register"][6];?>">
											<span class="help-block hide" >Polje <?php echo $language["register"][6];?> je obavezno!</span>
										</div>
                                        <div class="form-group">
                                            <input type="text" name="telefon" id="telefon" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][7];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][7];?> je obavezno!</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="adresa" id="adresa" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][8];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][8];?> je obavezno!</span>
                                        </div>
										<div class="form-group">
                                            <input type="text" name="mesto" id="mesto" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][9];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][9];?> je obavezno!</span>
                                        </div>
										<div class="form-group">
                                            <input type="text" name="postanskibr" id="postanskibr" tabindex="1" class="form-control" placeholder="<?php echo $language["register"][10];?>" value="">
											<span class="help-block hide" >Polje <?php echo $language["register"][10];?> je obavezno!</span>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register_btn" id="register_btn" tabindex="4" class="form-control btn myBtn" value="<?php echo $language["register"][11];?>">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Log In modal -->