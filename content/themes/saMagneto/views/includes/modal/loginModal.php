<!-- PRIJAVI SE MODAL -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
		<form id="login-form" action="" method="POST" role="form" style="display: block;">
            <div class="modal-content">
                <h5><?php echo $language["loginModal"][1]; // Prijavi se ?></h5>
                <small><?php echo $language["loginModal"][2]; // Korisničko ime ?></small>
				<input type="text" class="log-in-input log-name-input" id="login_form_username" name="login_form_username" tabindex="1"  placeholder="<?php echo $language["loginModal"][2];?>" value="">
                <small><?php echo $language["loginModal"][3]; // Lozinka ?></small>
				<input type="password" class="log-in-input pass-name-input" id="login_form_password" name="login_form_password" tabindex="2" placeholder="<?php echo $language["loginModal"][3];?>">
				<?php 
					$chk='';
					if(isset($_COOKIE['username']) && $_COOKIE['username']!='' && isset($_COOKIE['h264']) && $_COOKIE['h264']!=''){
						$chk='checked';
					}
				?>
                <lable class="remember_txt" for="login_form_rememberme"><?php echo $language["loginModal"][4]; // Lozinka ?></label>
				<input type="checkbox" tabindex="3" class="login_remember help-check" name="login_form_rememberme" id="login_form_rememberme" <?php echo $chk;?>>
                 <input type="submit" name="login_btn" id="login_btn" tabindex="4" class="sa-button -rounded prijava-button" value="<?php echo $language["loginModal"][5]; //Uloguj se ?>">                            
				<a href="register" class="zab-lozinka"><?php echo $language["loginModal"][6]; //Zaboravili ste lozinku? ?></a>
                <p><?php // echo $language["loginModal"][7]; ?> <a href="register"><?php echo $language["loginModal"][8]; ?></a></p>
              <!--   <p><?php // echo $language["loginModal"][7]; ?> <a href="b2blogin"><?php //echo $language["loginModal"][9]; ?></a></p> -->
            </div>
		</form>
        </div>
    </div>
    <!-- .PRIJAVI SE MODAL -->