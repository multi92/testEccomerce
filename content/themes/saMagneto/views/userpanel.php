<div class="container">
	
	<div class="row">
        <div class="col-md-9 personal-info" userid='<?php echo $userdata['id']; ?>'>
            <h3><?php echo $language["user_panel"][1]; //Podaci korisnika ?></h3>  
		</div>
	</div>
	
	<?php if($_SESSION['type'] == 'partner') { ?>
		<form class="jq_partner_updatedata_form" id="partner_updatedata_form" name="partner_updatedata_form" novalidate method="POST">
			<div class="row">
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][2]; //Ime ?> *</label>
				<input type="text" name="partnerUserName" id="partnerUserName" class="prireg-input" value="<?php echo $userdata["name"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][3]; //Prezime ?> *</label>
				<input type="text" name="partnerUserSurname" id="partnerUserSurname" class="prireg-input" value="<?php echo $userdata["surname"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][3]; //Prezime ?> *</label>
				<input type="text" name="partnerUserBirthday" id="partnerUserBirthday"  class="prireg-input" value="<?php echo date('d.m.Y',strtotime($userdata["birthday"])); ?>" readonly>
			</div>
			
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][4]; //Email ?> *</label>
				<input type="text" name="partnerUserEmail" id="partnerUserEmail" class="prireg-input" value="<?php echo $userdata["email"]; ?>">
			</div>
			
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][5]; //Telefon ?> *</label>
				<input type="text" name="partnerUserPhone" id="partnerUserPhone" class="prireg-input" value="<?php echo $userdata["phone"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][6]; //Mobilni ?> </label>
				<input type="text" name="partnerUserCellPhone" id="partnerUserCellPhone" class="prireg-input" value="<?php echo $userdata["mobile"]; ?>">
			</div>
			<br>

			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][7]; //Adresa ?> *</label>
				<input type="text" name="partnerUserAddress" id="partnerUserAddress" class="prireg-input" value="<?php echo $userdata["address"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][8]; //Grad ?> *</label>
				<input type="text" name="partnerUserCity" id="partnerUserCity" class="prireg-input" value="<?php echo $userdata["city"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][9]; //Postanski broj ?> *</label>
				<input type="text" name="partnerUserZip" id="partnerUserZip" class="prireg-input" value="<?php echo $userdata["zip"]; ?>">
			</div>
			<br>
		</div>

			<div class="row">
				<?php $edit_disabled='';?>
				<?php if($system_conf['sync'][1]==1){ ?>
				<?php 	$edit_disabled='disabled="disabled"';?>
				<?php } ?>
			<hr>
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][10]; //Naziv firme ?> *</label>
				<input type="text" name="partnerName" id="partnerName" class="prireg-input" value="<?php if(isset($partnerdata["name"])){ echo $partnerdata["name"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][11]; //PIB ?> *</label>
				<input type="text" name="partnerCode" id="partnerCode" class="prireg-input" value="<?php if(isset($partnerdata["code"])){ echo $partnerdata["code"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][12]; //Matični broj ?> *</label>
				<input type="text" name="partnerNumber" id="partnerNumber" class="prireg-input" value="<?php if(isset($partnerdata["number"])){ echo $partnerdata["number"];} ?>" <?php echo $edit_disabled; ?>>
				
			</div>
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][13]; //Kontakt osoba ?> *</label>
				<input type="text" name="partnerContactPerson" id="partnerContactPerson" class="prireg-input" value="<?php if(isset($partnerdata["contactperson"])){ echo $partnerdata["contactperson"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][14]; //Telefon firme ?> *</label>
				<input type="text" name="partnerPhone" id="partnerPhone" class="prireg-input" value="<?php if(isset($partnerdata["phone"])){ echo $partnerdata["phone"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][15]; //Fax firme ?></label>
				<input type="text" name="partnerFax" id="partnerFax" class="prireg-input" value="<?php if(isset($partnerdata["fax"])){ echo $partnerdata["fax"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][16]; //Email firme ?> *</label>
				<input type="text" name="partnerEmail" id="partnerEmail" class="prireg-input" value="<?php if(isset($partnerdata["email"])){ echo $partnerdata["email"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][17]; //Vebsajt firme ?></label>
				<input type="text" name="partnerWebsite" id="partnerWebsite" class="prireg-input" value="<?php if(isset($partnerdata["website"])){ echo $partnerdata["website"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][18]; //Adresa firme ?> *</label>
				<input type="text" name="partnerAddress" id="partnerAddress" class="prireg-input" value="<?php if(isset($partnerdata["address"])){ echo $partnerdata["address"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][19]; //Grad ?> *</label>
				<input type="text" name="partnerCity" id="partnerCity" class="prireg-input" value="<?php if(isset($partnerdata["city"])){ echo $partnerdata["city"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][20]; //Postanski broj ?> *</label>
				<input type="text" name="partnerZip" id="partnerZip" class="prireg-input" value="<?php if(isset($partnerdata["zip"])){ echo $partnerdata["zip"];} ?>" <?php echo $edit_disabled; ?>>
			</div>
		<?php if($system_conf['sync'][1]==1){ ?>
		<div class="col-sm-12">
				<br>
				<p style="color:red;"><b> <?php echo $language["update_company_info_sync"][1];?>: </b><a href="mailto:<?php echo $user_conf['contact_address'][1];?>"><b><?php echo $user_conf['contact_address'][1];?></b></a></p>
				
		</div>
		<?php } ?>
		<div class="col-sm-12">
				<br>
				<input type="submit" name="partnerSubmit" class="btn myBtn marginBottom30" value="<?php echo $language["user_panel"][21]; //Azuriraj podatke ?>">
				
		</div>
		</div>
		<div class="row">
    	 <div class="col-sm-12 verticalMargin10 _mb-20 clearfix">
        	<button class="logout signOutMenu2 sa-button -warning go-right"><?php echo $language["header"][3];?></button>
        </div>
    </div>
		</form>
	<?php } else { ?>
		<form class="jq_user_updatedata_form" id="user_updatedata_form" name="user_updatedata_form" novalidate method="POST">
			<div class="row">
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][2]; //Ime ?> *</label>
				<input type="text" name="userName" id="userName" class="prireg-input" value="<?php echo $userdata["name"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][3]; //Prezime ?> *</label>
				<input type="text" name="userSurname" id="userSurname" class="prireg-input" value="<?php echo $userdata["surname"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][44]; //Datum rodjenja ?> *</label>
				<input type="text" name="userBirthday" id="userBirthday" class="prireg-input" value="<?php echo date('d.m.Y',strtotime($userdata["birthday"])); ?>" readonly>
			</div>
			
			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][4]; //Email ?> *</label>
				<input type="text" name="userEmail" id="userEmail" class="prireg-input" value="<?php echo $userdata["email"]; ?>">
			</div>
			
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][5]; //Telefon ?> *</label>
				<input type="text" name="userPhone" id="userPhone" class="prireg-input" value="<?php echo $userdata["phone"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][6]; //Mobilni ?> </label>
				<input type="text" name="userCellPhone" id="userCellPhone" class="prireg-input" value="<?php echo $userdata["mobile"]; ?>">
			</div>
			<br>

			<div class="col-sm-6 marginB15">
				<label for=""><?php echo $language["user_panel"][7]; //Adresa ?> *</label>
				<input type="text" name="userAddress" id="userAddress" class="prireg-input" value="<?php echo $userdata["address"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][8]; //Grad ?> *</label>
				<input type="text" name="userCity" id="userCity" class="prireg-input" value="<?php echo $userdata["city"]; ?>">
			</div>
			<div class="col-sm-3 marginB15">
				<label for=""><?php echo $language["user_panel"][9]; //Postanski broj ?> *</label>
				<input type="text" name="userZip" id="userZip" class="prireg-input" value="<?php echo $userdata["zip"]; ?>">
			</div>
			<br>

			
		

			<div class="col-sm-12 _mb-20 _mt-20">
				<input type="submit" name="userSubmit" class="btn myBtn colorWhite" value="<?php echo $language["user_panel"][21]; //Azuriraj podatke ?>">
				<a class="signOutMenu btn btn-danger panel-signout" title="<?php echo $language["header"][3];?>"><?php echo $language["header"][3];?></a>
			</div>
		</div>
		</form>
	<?php } ?>

						
    
    
    <div class="row">
    	<div class="col-sm-12 verticalMargin10">
        	<a class="btn btn-warning noRound jq_userpanelSectionButton showUserOrdersButton" target="userOrdersList" doctype='e'><?php echo $language["user_panel"][22]; //Porudžbine ?></a>
            <span></span>
        </div>
        
		<div class="col-sm-12 verticalMargin10 marginTop15 jq_dateRangeInputCont hide">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group form-inline">
						<label><?php echo $language["user_panel"][23]; //Od datuma ?></label>
						<input type="text" class="form-control jq_startDateInput mil-datePic" data-provide="datepicker" value="<?php echo Date("Y-m-d");?>" />
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group form-inline">
						<label><?php echo $language["user_panel"][24]; //Do datuma ?></label>
						<input type="text" class="form-control jq_endDateInput mil-datePic" data-provide="datepicker" value="<?php echo Date("Y-m-d");?>"/>
					</div>				
				</div>
			</div>
		</div>
		<div class="col-sm-12 verticalMargin10 marginTop15">
			<div class="row">
				<div class="col-sm-2 jq_documentSpecialOption hide" doctype='r'>
					<div class="form-group form-inline">
						<label><?php echo $language["user_panel"][25]; //U valuti ?></label>
						<select class="form-control jq_inValuteSelect">
							<option value="">-------</option>
							<option value="y"><?php echo $language["user_panel"][26]; //Da ?></option>
							<option value="n"><?php echo $language["user_panel"][27]; //Ne ?></option>
						</select>
					</div>
				</div>
				<div class="col-sm-2 jq_documentSpecialOption hide" doctype='r'>
					<div class="form-group form-inline">
						<label><?php echo $language["user_panel"][28]; //Obrisani ?></label>
						<input type="checkbox" class="jq_deletedCheckbox" />
					</div>
				</div>
				
			</div>
		</div>
		
        <div class="col-sm-12 jq_userpanelSectionCont userOrdersList hide">
        	<div class="table-responsive">
        	<table class="table table-condesend table-responsive table-striped userOrdersListTable">
            	<thead>
                	<tr>
                    	<th><?php echo $language["user_panel"][29]; //Tip ?></th>
                        <th><?php echo $language["user_panel"][30]; //Broj ?></th>
                        <th><?php echo $language["user_panel"][31]; //Datum ?></th>
                        <th><?php echo $language["user_panel"][32]; //Status ?></th>
                        <th><?php echo $language["user_panel"][33]; //Račun ?></th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                	<?php
						/*if(isset($order)){
							
							foreach($order as $key=>$val)
							{
								echo '<tr>
									<td>Porudzbina</td>
									<td>'.$val['reservationdata']['number'].'</td>
									<td>';
										if(isset($val['reservationdata']['documentdate'])) echo date( 'd-m-Y H:i:s', strtotime($val['reservationdata']['documentdate'])); 
									echo'</td>
									<td>'.(($val['reservationdata']['status'] == 'n')? "neproknjizen":"proknjizen").'</td>
									<td>';
										foreach($val['racuni'] as $k=>$v){
											echo '<p racunid="'.$v['ID'].'">racun - '.$v['number'].'</p>';	
										}
										
									echo '</td>
								</tr>';	
							}
						}*/
					?>
                </tbody>
            </table>
        	</div>
        	
        </div>
        
        <div class="col-sm-12 jq_userpanelSectionCont userBillsList hide ">
        	<div class="table-responsive">
        	<table class="table table-condesend table-responsive table-striped userBillsListTable">
            	<thead>
                	<tr>
                    	<th><?php echo $language["user_panel"][29]; //Tip ?></th>
                        <th><?php echo $language["user_panel"][30]; //Broj ?></th>
                        <th><?php echo $language["user_panel"][31]; //Datum ?></th>
                        <th><?php echo $language["user_panel"][34]; //Vrednosti ?></th>     
						<th><?php echo $language["user_panel"][35]; //Valuta ?></th>                   
                        <th><?php echo $language["user_panel"][36]; //Rezervacija ?></th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                	<?php
						/*if(isset($bill)){
							foreach($bill[1] as $key=>$val)
							{
								echo '<tr>
									<td>Racun</td>
									<td>'.$val['number'].'</td>
									<td>'.$val['documentdate'].'</td>
									<td>'.$val['totalvalues'].'</td>
									<td>0</td>
									<td>'.(intval($val['totalvalues'])-0).'</td>
									<td>'.$val['reservationnumber'].'</td>
									
								</tr>';	
							}
						}*/
					?>
                </tbody>
            </table>
       		</div>
        </div>
		
		<div class="col-sm-12 jq_userpanelSectionCont userPovratnice hide ">
			<div class="table-responsive">		
        	<table class="table table-condesend table-responsive table-striped userPovratniceTable">
            	<thead>
                	<tr>
                    	<th><?php echo $language["user_panel"][29]; //Tip ?></th>
                        <th><?php echo $language["user_panel"][30]; //Broj ?></th>
                        <th><?php echo $language["user_panel"][31]; //Datum ?></th>
                        <th><?php echo $language["user_panel"][32]; //Status ?></th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                	
                </tbody>
            </table>
			</div>
        </div>
		
		<div class="col-sm-12 jq_userpanelSectionCont userKnjizna hide ">
			<div class="table-responsive">		
        	<table class="table table-condesend table-responsive table-striped userKnjiznaTable">
            	<thead>
                	<tr>
                    	<th><?php echo $language["user_panel"][29]; //Tip ?></th>
                        <th><?php echo $language["user_panel"][30]; //Broj ?></th>
                        <th><?php echo $language["user_panel"][31]; //Datum ?></th>
                        <th><?php echo $language["user_panel"][32]; //Status ?></th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                	
                </tbody>
            </table>
			</div>
        </div>
		
		<div class="col-sm-12 jq_userpanelSectionCont userZamena hide ">
			<div class="table-responsive">		
        	<table class="table table-condesend table-responsive table-striped userZamenaTable">
            	<thead>
                	<tr>
                    	<th><?php echo $language["user_panel"][29]; //Tip ?></th>
                        <th><?php echo $language["user_panel"][30]; //Broj ?></th>
                        <th><?php echo $language["user_panel"][31]; //Datum ?></th>
                        <th><?php echo $language["user_panel"][32]; //Status ?></th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                	
                </tbody>
            </table>
			</div>
        </div>
		
		<div class="col-sm-12 jq_userpanelSectionCont userUpiti hide ">
			<h2><?php echo $language["user_panel"][37]; //upiti ?></h2>
			
			<select class="form-control input-xlarge marginBottom30 jq_reportListSelect" size="4" >	
				<?php /*
					$q = "SELECT * FROM report";
					$res= $mysqli->query($q);
					if($res->num_rows > 0){
						while($row = $res->fetch_assoc()){
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
					}*/
				?>
				
			</select >
			
			<div class="row marginVertical30 jq_getReportResultFormCont hide">
				<form class="jq_getReportResultForm" >
					<div class="col-md-12 jq_searchIzvestajModalParmCont ">
					
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn myBtn go-left" ><?php echo $language["user_panel"][38]; //prikaži ?></button>
					</div>
				</form>
			</div>
			
			<div class="row marginVertical30 jq_reportResultCont hide">
				<div class="col-sm-12">
					<div class="table-responsive">
					<table class="table table-condensed table-striped jq_reportResultTable">
						<thead>
							<tr>
								
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					</div>
				</div>
			</div>		
        	
        </div>
        
    </div>
    
</div>



<!--- DOCUMENT ITEMS MODAL --->


<div class="modal fade documentItemsModalCont" id='jq_documentItemsModalCont' >
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  <h4 class="modal-title">
		  	<span class="jq_documentItemsModalDoctype"><?php echo $language["user_panel"][33]; //Račun ?></span> - <span class="jq_documentItemsModalDocNumber">RAC2017/01web</span>
		  </h4>
		</div>
		<div class="modal-body">
		  <table class="table table-striped table-condensed" id="tblGrid">
			<thead id="tblHead">
			  <tr>
				<th><?php echo $language["user_panel"][39]; //naziv ?></th>
				<th class="jq_itemsModalQty"><?php echo $language["user_panel"][40]; //Količina ?></th>
				<th><?php echo $language["user_panel"][41]; //Rabat ?></th>
				<th><?php echo $language["user_panel"][42]; //Cena PDV ?></th>
				<th><?php echo $language["user_panel"][34]; //Vrednost ?></th>
			  </tr>
			</thead>
			<tbody class="jq_documentItemsModalTbody">
			  
			</tbody>
		  </table>
		  <div class="jq_documentDescriprionModalHolder"></div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default " data-dismiss="modal"><?php echo $language["user_panel"][43]; //Zatvori ?></button>
		</div>
				
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->