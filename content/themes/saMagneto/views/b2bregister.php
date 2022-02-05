<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

<form class="jq_partner_application_form" id="partner_updatedata_form" name="partner_updatedata_form" novalidate method="POST">
  					  	<div class="row">
  					  		<br>
						    <div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][5]; //Ime ?> *</label>
								<input type="text" name="partnerUserName" id="partnerUserName" class="prireg-input" value="" required>
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][6]; //Prezime ?> *</label>
								<input type="text" name="partnerUserSurname" id="partnerUserSurname" class="prireg-input" value="" required>
							</div>
							
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][7]; //Email ?> *</label>
								<input type="text" name="partnerUserEmail" id="partnerUserEmail" class="prireg-input" value="" required>
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo 'Lozinka';//$language["update_personal_info"][5]; //Ime ?> *</label>
								<input type="password" name="partnerUserPassword" id="partnerUserPassword" class="prireg-input" value="" required>
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo  'Ponovite lozinku';//$language["update_personal_info"][6]; //Prezime ?> *</label>
								<input type="password" name="partnerUserRPassword" id="partnerUserRPassword" class="prireg-input" value="" required>
							</div>
							
							<div class="col-sm-6 marginB15">
								
							</div>
							
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][8]; //Telefon ?> *</label>
								<input type="text" name="partnerUserPhone" id="partnerUserPhone" class="prireg-input" value="" required>
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][9]; //Mobilni ?> </label>
								<input type="text" name="partnerUserCellPhone" id="partnerUserCellPhone" class="prireg-input" value="" required>
							</div>
							<br>

							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][10]; //Adresa ?> *</label>
								<input type="text" name="partnerUserAddress" id="partnerUserAddress" class="prireg-input" value="" required>
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][11]; //Grad ?> *</label>
								<input type="text" name="partnerUserCity" id="partnerUserCity" class="prireg-input" value="" required>
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][12]; //Poštanski broj ?> *</label>
								<input type="text" name="partnerUserZip" id="partnerUserZip" class="prireg-input" value="" required>
							</div>
							<br>
							<?php $langdisabled=''; $hidden=''; if(count($lang_data)==1){ $langdisabled='disabled="disabled"'; $hidden='hide'; }?>
                            <div class="col-sm-3 marginB15 <?php echo $hidden; ?>">
                            	<label for=""><?php echo $language["register_person"][12]; //Primarni jezik ?> *</label>                                
                                <select class="form-control partnerUserDefaultLang "  id="partnerUserDefaultLang" name="partnerUserDefaultLang" <?php echo $langdisabled;?> >
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
                            </div>
							<br>
						</div>
						<div class="row">
							<hr>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][14]; //Naziv firme ?> *</label>
								<input type="text" name="partnerName" id="partnerName" class="prireg-input" value="">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][15]; //PIB ?> *</label>
								<input type="text" name="partnerNumber" id="partnerNumber" class="prireg-input" value="">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][16]; //Maticni broj ?> *</label>
								<input type="text" name="partnerCode" id="partnerCode" class="prireg-input" value="">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][17]; //Kontakt osoba ?> *</label>
								<input type="text" name="partnerContactPerson" id="partnerContactPerson" class="prireg-input" value="">
							</div>
							
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][18]; //Telefon firme ?> *</label>
								<input type="text" name="partnerPhone" id="partnerPhone" class="prireg-input" value="">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][19]; //FAX firme ?></label>
								<input type="text" name="partnerFax" id="partnerFax" class="prireg-input" value="">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][20]; //Email firme ?> *</label>
								<input type="text" name="partnerEmail" id="partnerEmail" class="prireg-input" value="">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][21]; //Vebsajt firme ?></label>
								<input type="text" name="partnerWebsite" id="partnerWebsite" class="prireg-input" value="">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][22]; //Adresa firme ?> *</label>
								<input type="text" name="partnerAddress" id="partnerAddress" class="prireg-input" value="">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][23]; //Grad ?> *</label>
								<input type="text" name="partnerCity" id="partnerCity" class="prireg-input" value="">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][24]; //Postanski broj ?> *</label>
								<input type="text" name="partnerZip" id="partnerZip" class="prireg-input" value="">
							</div>
							<div class="col-md-12 marginB15">
								<br>
                                <p><b><?php echo $language["b2b_register_description"][1]; // ?><!-- <a href="mailto:<?php //echo $user_conf["contact_address"][1];?>"><?php //echo $user_conf["contact_address"][1];?></a> --></b></p>
                                
                            </div>
  					  	<div class="col-md-12">
								<input type="submit" name="partnerSubmit" class="sa-button - rounded -success marginTop30" value="Prosledi zahtev">
								
						</div>
  					  	</div>
						</form>

			</div>
		</div>
	</div>
</section>