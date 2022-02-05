            <div class="modal partner-modal-css fade selectPartnerModal" id="selectPartnerModal" tabindex="-1" role="dialog" initTableDefault="0" selectedPartnerId="0" selectedPartnerName="">
                  <div class="modal-dialog modal-lg partner-modal-css" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h1 class="modal-title" style="margin: 0!important;"><b>Izaberite partnera</b></h1>
                            <?//if(isset($_SESSION["filterPartnerModal"])){var_dump($_SESSION["filterPartnerModal"])}?>
                        </div>
                        <div class="modal-body" style="padding: 0 15px 0 15px;">
                            <div class="row">
                                <div class="col-lg-3" style="background-color: #eee; ">
                                    <form class="form-horizontal filterPartner"  name="filterPartner" novalidate="" method="POST">
                                    <div class="form" style="border-right: : 1px solid #ccc; padding-bottom: 10px;">
                                        <label class="my-label">
                                            <p class="field-name">Naziv</p> 
                                            <input type="text" name="filterPartnerName"  class="field filterPartnerName" <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerName'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterPartnerName'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">PIB</p> 
                                            <input type="text" name="filterPartnerCode"  class="field filterPartnerCode" <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerCode'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterPartnerCode'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Tip</p> 
                                            <!-- <input type="text" name="filterPartnerType"  class="field filterPartnerType"> -->
                                            <select class="select field filterPartnerType" name="filterPartnerType" >
                                                
                                            </select>    
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Matični broj</p> 
                                            <input type="text" name="filterPartnerNumber"  class="field filterPartnerNumber" <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerNumber'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterPartnerNumber'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Grad</p> 
                                            <input type="text" name="filterPartnerCity"  class="field filterPartnerCity" <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerCity'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterPartnerCity'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Poštanski broj</p> 
                                            <input type="text" name="filterPartnerZip"  class="field filterPartnerZip" <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerZip'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterPartnerZip'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Aktivan</p>
                                            <select class="select field filterPartnerActive" name="filterPartnerActive" >
                                                <?php $selected=""; 
                                                 if(isset($_SESSION["filterPartnerModal"]['filterPartnerActive']) && $_SESSION["filterPartnerModal"]['filterPartnerActive']=="---"){ $selected='selected="selected"'; ?> 
                                                    <option  class="option" value="---" <?php echo $selected;?>>---</option>
                                                <?php } else { ?>
                                                    <option  class="option" value="---">---</option>
                                                <?php }  ?>
                                                <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerActive']) && $_SESSION["filterPartnerModal"]['filterPartnerActive']=="y"){ $selected='selected="selected"'; ?> 
                                                    <option  class="option" value="y" <?php echo $selected;?>>Aktivan</option>
                                                <?php } else { ?>
                                                    <option  class="option" value="y">Aktivan</option>
                                                <?php }  ?>
                                                <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerActive']) && $_SESSION["filterPartnerModal"]['filterPartnerActive']=="n"){ $selected='selected="selected"'; ?> 
                                                    <option  class="option" value="n" <?php echo $selected;?>>Neaktivan</option>
                                                <?php } else { ?>
                                                    <option  class="option" value="n">Neaktivan</option>
                                                <?php }  ?>                        
                                            </select>
                                        </label>
                                         <label class="my-label">
                                            <p class="field-name">Ime odg. osobe</p> 
                                            <input type="text" name="filterResponsiblePersonName"  class="field filterResponsiblePersonName" <?php if(isset($_SESSION["filterPartnerModal"]['filterResponsiblePersonName'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterResponsiblePersonName'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Prezime odg. osobe</p> 
                                            <input type="text" name="filterResponsiblePersonLastName"  class="field filterResponsiblePersonLastName" <?php if(isset($_SESSION["filterPartnerModal"]['filterResponsiblePersonLastName'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterResponsiblePersonLastName'].'"' ;}?>>
                                        </label>  
                                        <label class="my-label">
                                            <p class="field-name">Ident.</p> 
                                            <input type="text" name="filterIdent"  class="field filterIdent" <?php if(isset($_SESSION["filterPartnerModal"]['filterIdent'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterIdent'].'"' ;}?>>
                                        </label>
                                        <label class="my-label">
                                            <p class="field-name">Opis delatnosti</p> 
                                            <input type="text" name="filterPartnerDescription"  class="field filterPartnerDescription" <?php if(isset($_SESSION["filterPartnerModal"]['filterPartnerDescription'])){ echo 'value="'.$_SESSION["filterPartnerModal"]['filterPartnerDescription'].'"' ;}?>>
                                        </label> 
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-lg-6">
                                                <button type="button" class="btn btn-primary clearFilterPartnerButton" style="width:100%;">Očisti</button>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-lg-6">
                                                <button type="button" class="btn btn-primary filterPartnerButton" style="width:100%;">Pronađi</button> 
                                            </div>
                                        </div>    
                                        
                                       
                                    </div>
                                </div>
                                <div class="col-lg-9" style="padding-left: 0;">
                                    <div class="table-responsive partner-product-table table-responsive">
                                        <table id="modalSelectPartnerDataTable" class="table table-bordered table-striped" class="display" style="width:100%; ">
                                            <!-- min-height: 484px; -->
                                        <thead>    
                                            <tr>
                                                <th>Ident.</th>
                                                <th>Naziv</th>
                                                <th>PIB</th>
                                                <th>Tip</th>
                                                <th>Matični broj</th>
                                                <th>Adresa</th>
                                                <th>Grad</th>
                                                <th>Telefon</th>
                                                <th>Email</th>
                                                <th>Kontakt osoba</th>
                                                <th>Opis</th>
                                                <th>Odgovorna osoba</th>
                                            </tr>
                                        </thead>

                                           
                                        </table>
                                    </div>
                                </div>
                            </div>





                         </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary modalPartnerSelectedButton">Uredu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Otkaži</button>
                        </div>

                    </div>
                  </div>
                </div>
</div>