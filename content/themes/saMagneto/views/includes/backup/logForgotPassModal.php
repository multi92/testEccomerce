
<!-- zaboravili ste lozinku modal -->
    <div id="forget_password" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="padding: 12px; border-radius: 0;">
                <h6><?php echo $language["lost_pass"][1];?></h6>
				 <span id="reset_fail" class="response_error" style="display: none;"></span>
                <form action="" id="lost-form" class="zab_form ">
                    <label for="lost_email"><?php echo $language["lost_pass"][2];?></label>
                    <br>
                    <input id="lost_email" type="email" name="email" placeholder="<?php echo $language["lost_pass"][3];?>">
                    <input id="reset_btn" type="submit" value="<?php echo $language["lost_pass"][4];?>" class="btn myBtn zab_button">
                </form>
            </div>
        </div>
    </div>
<!-- .zaboravili ste lozinku modal -->

    <!-- zaboravili ste lozinku modal -->
