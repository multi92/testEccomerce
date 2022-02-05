
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3><?php echo $language["update_personal_info"][1]; //Odaberite tip naloga ?></h3>
				<p><?php echo $language["update_personal_info"][2]; //Obavezna polja su označena ?> *</p>
				<div>
					
  					<!-- Nav tabs -->
  					<ul class="nav nav-tabs prireg" role="tablist">
  					<?php if($system_conf["system_b2c"][1]==1){?>
  					  <li role="presentation" class="active"><a href="#fizicko" aria-controls="home" role="tab" data-toggle="tab"><?php echo $language["update_personal_info"][3]; //Fizičko lice ?></a></li>
  					<?php } ?>
  					<?php if($system_conf["system_b2b"][1]==1 || $system_conf["system_commerc"][1]==1){?>
  					  <li role="presentation" class="<?php if($system_conf["system_b2c"][1]==0){ echo 'active';} ?>"><a href="#pravno" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $language["update_personal_info"][4]; //Pravno lice ?></a></li>
  					<?php } ?>
  					</ul>

  					<!-- Tab panes -->
  					<div class="tab-content">
  					<?php if($system_conf["system_b2c"][1]==1){?>
  					  <div role="tabpanel" class="tab-pane active" id="fizicko">
						<form class="jq_user_updatedata_form" id="user_updatedata_form" name="user_updatedata_form" novalidate method="POST">
  					  	<div class="row">
  					  		<br>
  					  		<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][5]; //Ime ?> *</label>
								<input type="text" name="userName" id="userName" class="prireg-input" value="<?php echo $userdata["name"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][6]; //Prezime ?> *</label>
								<input type="text" name="userSurname" id="userSurname" class="prireg-input" value="<?php echo $userdata["surname"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][25]; //Datum rodjenja ?> *</label>
								<input type="text" name="userBirthday" id="userBirthday"  class="prireg-input" value="<?php echo date('d.m.Y',strtotime($userdata["birthday"])); ?>" disabled>
							</div>
							
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][7]; //Email ?> *</label>
								<input type="text" name="userEmail" id="userEmail" class="prireg-input" value="<?php echo $userdata["email"]; ?>">
							</div>
							
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][8]; //Telefon ?> *</label>
								<input type="text" name="userPhone" id="userPhone" class="prireg-input" value="<?php echo $userdata["phone"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][9]; //Mobilni ?> </label>
								<input type="text" name="userCellPhone" id="userCellPhone" class="prireg-input" value="<?php echo $userdata["mobile"]; ?>">
							</div>
							<br>

							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][10]; //Adresa ?> *</label>
								<input type="text" name="userAddress" id="userAddress" class="prireg-input" value="<?php echo $userdata["address"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][11]; //Grad ?> *</label>
								<input type="text" name="userCity" id="userCity" class="prireg-input" value="<?php echo $userdata["city"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][12]; //Poštanski broj ?> *</label>
								<input type="text" name="userZip" id="userZip" class="prireg-input" value="<?php echo $userdata["zip"]; ?>">
							</div>
							<br>

							
  					  	

							<div class="col-md-12">
								<input type="submit" name="userSubmit" class="sa-button - rounded -success marginTop30" value="<?php echo $language["update_personal_info"][13]; //Azuriraj podatke ?>">
								
							</div>
  					  	</div>
						</form>
  					  </div>
  					  <?php } ?>
  					  <?php if($system_conf["system_b2b"][1]==1 || $system_conf["system_commerc"][1]==1){?>
  					  <div role="tabpanel" class="tab-pane <?php if($system_conf["system_b2c"][1]==0){ echo 'active';} ?>" id="pravno">
						<form class="jq_partner_updatedata_form" id="partner_updatedata_form" name="partner_updatedata_form" novalidate method="POST">
  					  	<div class="row">
  					  		<br>
						    <div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][5]; //Ime ?> *</label>
								<input type="text" name="partnerUserName" id="partnerUserName" class="prireg-input" value="<?php echo $userdata["name"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][6]; //Prezime ?> *</label>
								<input type="text" name="partnerUserSurname" id="partnerUserSurname" class="prireg-input" value="<?php echo $userdata["surname"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][25]; //Datum rodjenja ?> *</label>
								<input type="text" name="partnerUserBirthday" id="partnerUserBirthday" class="prireg-input" value="<?php echo date('d.m.Y',strtotime($userdata["birthday"])); ?>" disabled>
							</div>
							
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][7]; //Email ?> *</label>
								<input type="text" name="partnerUserEmail" id="partnerUserEmail" class="prireg-input" value="<?php echo $userdata["email"]; ?>">
							</div>
							
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][8]; //Telefon ?> *</label>
								<input type="text" name="partnerUserPhone" id="partnerUserPhone" class="prireg-input" value="<?php echo $userdata["phone"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][9]; //Mobilni ?> </label>
								<input type="text" name="partnerUserCellPhone" id="partnerUserCellPhone" class="prireg-input" value="<?php echo $userdata["mobile"]; ?>">
							</div>
							<br>

							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][10]; //Adresa ?> *</label>
								<input type="text" name="partnerUserAddress" id="partnerUserAddress" class="prireg-input" value="<?php echo $userdata["address"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][11]; //Grad ?> *</label>
								<input type="text" name="partnerUserCity" id="partnerUserCity" class="prireg-input" value="<?php echo $userdata["city"]; ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][12]; //Poštanski broj ?> *</label>
								<input type="text" name="partnerUserZip" id="partnerUserZip" class="prireg-input" value="<?php echo $userdata["zip"]; ?>">
							</div>
							<br>
						</div>
						<div class="row">
							<hr>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][14]; //Naziv firme ?> *</label>
								<input type="text" name="partnerName" id="partnerName" class="prireg-input" value="<?php if(isset($partnerdata["name"])){ echo $partnerdata["name"];} ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][15]; //PIB ?> *</label>
								<input type="text" name="partnerNumber" id="partnerNumber" class="prireg-input" value="<?php if(isset($partnerdata["number"])){ echo $partnerdata["number"];} ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][16]; //Maticni broj ?> *</label>
								<input type="text" name="partnerCode" id="partnerCode" class="prireg-input" value="<?php if(isset($partnerdata["code"])){ echo $partnerdata["code"];} ?>">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][17]; //Kontakt osoba ?> *</label>
								<input type="text" name="partnerContactPerson" id="partnerContactPerson" class="prireg-input" value="<?php if(isset($partnerdata["contactperson"])){ echo $partnerdata["contactperson"];} ?>">
							</div>
							
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][18]; //Telefon firme ?> *</label>
								<input type="text" name="partnerPhone" id="partnerPhone" class="prireg-input" value="<?php if(isset($partnerdata["phone"])){ echo $partnerdata["phone"];} ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][19]; //FAX firme ?></label>
								<input type="text" name="partnerFax" id="partnerFax" class="prireg-input" value="<?php if(isset($partnerdata["fax"])){ echo $partnerdata["fax"];} ?>">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][20]; //Email firme ?> *</label>
								<input type="text" name="partnerEmail" id="partnerEmail" class="prireg-input" value="<?php if(isset($partnerdata["email"])){ echo $partnerdata["email"];} ?>">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][21]; //Vebsajt firme ?></label>
								<input type="text" name="partnerWebsite" id="partnerWebsite" class="prireg-input" value="<?php if(isset($partnerdata["website"])){ echo $partnerdata["website"];} ?>">
							</div>
							<div class="col-sm-6 marginB15">
								<label for=""><?php echo $language["update_personal_info"][22]; //Adresa firme ?> *</label>
								<input type="text" name="partnerAddress" id="partnerAddress" class="prireg-input" value="<?php if(isset($partnerdata["address"])){ echo $partnerdata["address"];} ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][23]; //Grad ?> *</label>
								<input type="text" name="partnerCity" id="partnerCity" class="prireg-input" value="<?php if(isset($partnerdata["city"])){ echo $partnerdata["city"];} ?>">
							</div>
							<div class="col-sm-3 marginB15">
								<label for=""><?php echo $language["update_personal_info"][24]; //Postanski broj ?> *</label>
								<input type="text" name="partnerZip" id="partnerZip" class="prireg-input" value="<?php if(isset($partnerdata["zip"])){ echo $partnerdata["zip"];} ?>">
							</div>
  					  	<div class="col-md-12">
								<input type="submit" name="partnerSubmit" class="sa-button - rounded -success marginTop30" value="<?php echo $language["update_personal_info"][13]; //Azuriraj podatke ?>">
								
						</div>
  					  	</div>
						</form>
  					  </div>
  					  <?php } ?>
  			
  					</div>

				</div>
			</div>
		</div>
	</div>
</section>