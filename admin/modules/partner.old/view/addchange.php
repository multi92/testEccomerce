<?php $viewtype=''; if($currentview=='change'){ $viewtype=''; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-users"></i> Partner <span class="partnerInfoName"><?php echo $viewtype;?></span>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li><a href="dashboard"><i class="fa fa-users"></i> Lista partnera</a></li>
            <li class="active"> Partner</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-sm-12 verticalMargin10">

            <button class="btn btn-primary" id="listButton">Lista partnera</button>

        </div>
    </div>

    <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 


    <div class="box box-primary box-body addChangeCont hide" >
     <div class="loaded" id=''></div>
     <div class="row">
        <div class="col-sm-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="partnerInformationsTab active"><a href="#partnerInformations" data-toggle="tab" aria-expanded="true"><i class="fa fa-info" style="font-size: 18px;"></i> Opšte informacije</a></li>
              <li class="partnerAddressTab"><a href="#partnerAddress" data-toggle="tab" aria-expanded="false"><i class="fa fa-map-marker" style="font-size: 18px;"></i> Adrese isporuke</a></li>
              <li class="partnerContactTab"><a href="#partnerContact" data-toggle="tab" aria-expanded="false"><i class="fa fa-phone" style="font-size: 18px;"></i> Kontakti</a></li>
              <li class="partnerDocumentsTab"><a href="#partnerDocuments" data-toggle="tab" aria-expanded="false"><i class="fa fa-files-o" style="font-size: 18px;"></i> Dokumenti</a></li>
              <li class="partnerTransactionsTab"><a href="#partnerTransactions" data-toggle="tab" aria-expanded="false"><i class="fa fa-exchange"></i> Transakcije</a></li>
			  <li class="partnerCategoryRebateTab"><a href="#partnerCategoryRebate" data-toggle="tab" aria-expanded="false"><i class="fa fa-star"></i> Rabati po kategoriji</a></li>
              <li class="partnerPricelistTab"><a href="#partnerPricelist" data-toggle="tab" aria-expanded="false"><i class="fa fa-star"></i> Cenovnik partnera</a></li>
              <li class="pull-right "><a href="#partnerSettings" class="text-muted" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="partnerInformations">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Naziv partnera</label>
                                <input type="text" class="form-control partnerName" placeholder="Naziv partnera">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Tip partnera</label>
                                <input type="text" class="form-control partnerType" placeholder="Tip partnera">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control partnerActive">
                                    <option value='n'>Neaktivan</option>
                                    <option value='y'>Aktivan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Sort</label>
                                <input type="text" class="form-control partnerSort" placeholder="Sort">
                            </div>
                        </div>
                         <div class="col-sm-1">
                            <div class="form-group">
                                <label>Ident.</label>
                                <input type="text" class="form-control partnerIdent" placeholder="" disabled="disabled">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>PIB</label>
                                <input type="text" class="form-control partnerCode" placeholder="PIB">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Matični broj</label>
                                <input type="text" class="form-control partnerNumber" placeholder="Matični broj">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control partnerEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Telefon</label>
                                <input type="text" class="form-control partnerPhone" placeholder="Telefon">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control partnerFax" placeholder="Fax">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Websajt</label>
                                <input type="text" class="form-control partnerWebsite" placeholder="Websajt">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Adresa</label>
                                <input type="text" class="form-control partnerAddress" placeholder="Adresa">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Grad</label>
                                <input type="text" class="form-control partnerCity" placeholder="Grad">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Poštanski broj</label>
                                <input type="text" class="form-control partnerZip" placeholder="Poštanski broj">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Slika</label>
                                <input type="text" class="form-control partnerImage" placeholder="Slika">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Kontakt osoba</label>
                                <input type="text" class="form-control partnerContactPerson" placeholder="Slika">
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Opis</label>
                                <textarea type="text" class="form-control partnerDescription" placeholder="Opis"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Rabat (%)</label>
                                <input type="number" class="form-control partnerRebatePercent" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Broj dana valute</label>
                                <input type="number" class="form-control partnerValuteDays" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Kreditni limit</label>
                                <input type="number" class="form-control partnerCreditLimit" min="0" value="0">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="partnerCreditDebitInfo">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Duguje</label>
                                <input type="number" class="form-control partnerDebit" min="0" value="0" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Potražuje</label>
                                <input type="number" class="form-control partnerCredit" min="0" value="0" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Saldo</label>
                                <input type="number" class="form-control partnerSaldo" min="0" value="0" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group hide">
                                <label>&nbsp;</label>
                                <a class="btn btn-primary excerptOfOpenItemsBTN" style="display:block;">Otvorene stavke</a> 
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        </div>
                        <div class="partnerLastEditInfo">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Poslednju promenu izvršio</label>
                                <input type="text" class="form-control partnerUser" placeholder="" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Datum i vreme poslednje promene</label>
                                <input type="text" class="form-control partnerTimestamp" placeholder="" disabled="disabled">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        </div>
                    </div><!-- ./row -->
                    <a class="btn btn-primary savePartnerInfo">Snimi</a> 
              </div><!-- ./end tab-->
              <div class="tab-pane" id="partnerAddress">
                <a class="btn btn-primary addPartnerAddressBTN" >Dodaj novu adresu isporuke</a>
        
                <div class="row addPartnerAddressCont hide" style="background-color:#d9d9d9;" partneraddressid="">
                        <hr style="margin: 6px 0;">
                        <div class="col-xs-11">
                            <div class="form-group">
                                <label  class="partneraddressAddChangeLabel" style="color:black; font-size: 18px;">Novi unos</label>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="form-group" style="text-align: right;">
                                <a class="closePartnerAddressCont"><i class="fa fa-close" style="color:black; font-size: 18px; cursor: pointer; "></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Naziv objekta</label>
                                <input type="text" class="form-control partnerAddressObjectName" placeholder="Naziv objekta">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Tip objekta</label>
                                <input type="text" class="form-control partnerAddressObjectType" placeholder="Tip objekta">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Adresa</label>
                                <input type="text" class="form-control partnerAddressAddress" placeholder="Adresa">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Grad</label>
                                <input type="text" class="form-control partnerAddressCity" placeholder="Grad">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Poštanski broj</label>
                                <input type="text" class="form-control partnerAddressZip" placeholder="Poštanski broj">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Region</label>
                                <input type="text" class="form-control partnerAddressRegion" placeholder="Region">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Kod isporuke</label>
                                <input type="text" class="form-control partnerAddressDeliveryCode" placeholder="Kod isporuke">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Izvor prodaje</label>
                                <input type="text" class="form-control partnerAddressSalesSource" placeholder="Izvor prodaje">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <a class="btn btn-primary savePartnerAddressBTN">Snimi</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 6px 0;">
                </div>
                <div class="table-responsive" style="margin-top:10px;">
                    <table id="partnerAddressTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Naziv objekta</th>
                                <th>Adresa</th>
                                <th>Grad</th>
                                <th>Poštanski broj</th>
                                <th>Region</th>
                                <th>Kod isporuke</th>
                                <th>Izvor prodaje</th>
                                <th>Tip objekta</th>
                                <th>Poslednji izmenio</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                  
              </div>
              <div class="tab-pane" id="partnerContact">
                <a class="btn btn-primary addPartnerContactBTN" >Dodaj nove kontakt podatke</a>
        
                <div class="row addPartnerContactCont hide" style="background-color:#d9d9d9;" partnercontactid="">
                        <hr style="margin: 6px 0;">
                        <div class="col-xs-11">
                            <div class="form-group">
                                <label  class="partnercontactAddChangeLabel" style="color:black; font-size: 18px;">Novi unos</label>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="form-group" style="text-align: right;">
                                <a class="closePartnerContactCont"><i class="fa fa-close" style="color:black; font-size: 18px; cursor: pointer; "></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Pozicija</label>
                                <input type="text" class="form-control partnerContactPosition" placeholder="Pozicija">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Ime</label>
                                <input type="text" class="form-control partnerContactFirstName" placeholder="Ime">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Prezime</label>
                                <input type="text" class="form-control partnerContactLastName" placeholder="Prezime">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Telefon</label>
                                <input type="text" class="form-control partnerContactPhone" placeholder="Telefon">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control partnerContactEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Napomena</label>
                                <textarea type="text" class="form-control partnerContactNote" placeholder="Napomena"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <a class="btn btn-primary savePartnerContactBTN">Snimi</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 6px 0;">
                </div>
                <div class="table-responsive" style="margin-top:10px;">
                    <table id="partnerContactTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Pozicija</th>
                                <th>Ime</th>
                                <th>Prezime</th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Napomena</th>
                                <th>Poslednji izmenio</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div> 
              </div>
              <div class="tab-pane" id="partnerDocuments">
              	<div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Od datuma</label>
                                
                                <input type="date" class="form-control partnerDocumentsFromDate" placeholder="Od datuma" value="<?php echo date("Y")."-01-01";?>" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Do datuma</label>
                                <input type="date" class="form-control partnerDocumentsToDate" placeholder="Do datuma" value="<?php echo date("Y-m-d");?>" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <a class="btn btn-primary partnerDocumentsFilterBTN" style="display:block;">Prikaži</a> 
                            </div>
                        </div>
                </div>
                <div class="table-responsive" style="margin-top:10px;">
                    <table id="partnerDocumentsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Tip</th>
                                <th>Broj</th>
                                <th>Magacin</th>
                                <th>Vrednost</th>
                                <th>Komentar</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
              <div class="tab-pane" id="partnerTransactions">
                <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Od datuma</label>
                                
                                <input type="date" class="form-control partnerTransactionsFromDate" placeholder="Od datuma" value="<?php echo date("Y")."-01-01";?>" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Do datuma</label>
                                <input type="date" class="form-control partnerTransactionsToDate" placeholder="Do datuma" value="<?php echo date("Y-m-d");?>" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <a class="btn btn-primary partnerTransactionsFilterBTN" style="display:block;">Prikaži</a> 
                            </div>
                        </div>
                </div>
                <div class="table-responsive" style="margin-top:10px;">
                    <table id="partnerTransactionsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Broj</th>
                                <th>Opis</th>
                                <th>Duguje</th>
                                <th>Potražuje</th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
			  <div class="tab-pane" id="partnerCategoryRebate">
                <a class="btn btn-primary addPartnerCategoryRebateBTN" >Dodaj rabat za kategoriju</a>
        
                <div class="row addPartnerCategoryRebateCont hide" style="background-color:#d9d9d9;" categoryrebateid="">
                        <hr style="margin: 6px 0;">
                        <div class="col-xs-11">
                            <div class="form-group">
                                <label  class="partneraddressAddChangeLabel" style="color:black; font-size: 18px;">Novi unos</label>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="form-group" style="text-align: right;">
                                <a class="closePartnerCategoryRebateCont"><i class="fa fa-close" style="color:black; font-size: 18px; cursor: pointer; "></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Kategorija</label>
                                <select class="form-control partnerCategoryRebateCategorySelect" style="width: 100%;" tabindex="-1" aria-hidden="true" productcategoryid="" required>
									<option value="0">-- izaberite kategoriju --</option>
									<?php
										function get_all_deepest_cat($parid, $string)
										{
											global $conn;
											$tmpstring = $string;
											$query = "SELECT * FROM category WHERE id = ".$parid;
											
											$r = mysqli_query($conn,$query);
											if(mysqli_num_rows($r) > 0)
											{
												$row = mysqli_fetch_assoc($r);
												if($row['parentid'] == 0)
												{
													$tmpstring .= ">>".$row['name'];
													return $tmpstring;
												}
												else
												{		
													return ">>".$row['name'].get_all_deepest_cat($row["parentid"],$tmpstring);		
												}
											}	
										}
										
										function all_cat_php()
										{
											global $conn;
											$query = "SELECT * FROM category ";
											$result = mysqli_query($conn, $query);
											$i = 1;
											$bdata = array();
											while($ar = mysqli_fetch_assoc($result))
											{
												if($ar["parentid"] == 0)
												{
													$data = array();
													array_push($data, $ar["id"]);
													array_push($data, $ar["name"]);
													array_push($bdata, $data);
												}
												else
												{
													$data = explode(">>", get_all_deepest_cat($ar["parentid"],""));
													unset($data[0]);
													array_push($data,$ar["id"]); 
													$data = array_reverse($data);		
													array_push($data, $ar["name"]);
													array_push($bdata, $data);
												}
											}
											return $bdata;	
										}
										foreach(all_cat_php() as $key=>$val)
										{
											$id = $val[0];
											unset($val[0]);
											echo '<option value="'.$id.'">'.implode(" >> ", $val).'</option>';	
											
										}
										
									?>
									
								</select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Rabat (%)</label>
                                <input type="number" max="100" class="form-control partnerCategoryRebate" placeholder="Rabat (%)">
                            </div>
                        </div>
                        
                        <hr>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <a class="btn btn-primary savePartnerCategoryRebateBTN">Snimi</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 6px 0;">
                </div>
				
                <div class="table-responsive" style="margin-top:10px;">
                    <table id="partnerCategoryRebateTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kategorija</th>
                                <th>Rabat</th>
                                <th>Poslednji izmenio</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                  
              </div>
              
              <div class="tab-pane" id="partnerPricelist">
                
                <div class="row addPartnerCategoryRebateCont " style="background-color:#d9d9d9;" categoryrebateid="">
                        <hr style="margin: 6px 0;">
                        <div class="col-xs-11">
                            <div class="form-group">
                                <label  class="" style="color:black; font-size: 18px;">Izaberite cenovnik</label>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="form-group" style="text-align: right;">
                                <a class="closePartnerCategoryRebateCont"><i class="fa fa-close" style="color:black; font-size: 18px; cursor: pointer; "></i></a>
                            </div>
                        </div>
                        <div class="col-xs-11">
                        	<?php 
								$q = "SELECT pl.name FROM partnerpricelist ppl 
										LEFT JOIN pricelist pl ON ppl.pricelistid = pl.id
									WHERE ppl.partnerid = ".$command[2];
									
								$res = mysqli_query($conn, $q);
								if(mysqli_num_rows($res) > 0){
									$row = mysqli_fetch_assoc($res);	
								}
							?>
                        	<h3>Aktivan cenovnik:  
                            	<b><span class="jq_partnerPricelistSelectedName"><?php echo (isset($row['name']))? $row['name']:''; ?></span></b> 
                                <a class="jq_partnerPricelistRemoveButton btn btn-danger btn-sm <?php echo (isset($row['name']))? '':'hide'; ?>" ><i class="fa fa-close" style="color:white; font-size: 18px; cursor: pointer; "></i></a>
                            </h3>
                        </div>
                        
                        
                        <div class="clearfix"></div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Cenovnik</label>
                                <select class="form-control partnerPricelistSelect jq_partnerPricelistSelect" style="width: 100%;" tabindex="-1" aria-hidden="true" pricelistid="" required>
									<option value="0">-- izaberite cenovnik --</option>
									<?php
										$q = "SELECT * FROM pricelist WHERE status = 'v' ORDER BY sort ASC, name ASC";
										$res = mysqli_query($conn, $q);
										if(mysqli_num_rows($res) > 0){
											while($row = mysqli_fetch_assoc($res)){
												echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
										}
									?>
									
								</select>
                            </div>
                        </div>
                        
                        
                        <hr>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <a class="btn btn-primary savePartnerPricelistBTN">Snimi</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 6px 0;">
                </div>
				
                
                  
              </div>
              
              <div class="tab-pane" id="partnerSettings">
              </div>
            </div>
          </div>
        </div>
     </div>
    </div>

</section>
<!-- /.content -->
</div>
