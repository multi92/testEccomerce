<?php //include("../../../../app/configuration/system.configuration.php");?>
<?php //include("../../../../".$system_conf["theme_path"][1]."config/user.configuration.php");?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header">
		<h1>
			Porudžbina
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
			<li class="active"> Porudžbine</li>
		</ol>
	</section>
	
    <section class="content-header">
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista porudžbina</button>
            </div>
        </div>
    </section>
    
    <section class="invoice">
		<div class="pagecover jq_pagecover">
			<i class="fa fa-refresh fa-5x fa-spin" aria-hidden="true"></i>
			
		</div>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
          	<i class="fa fa-book"></i> Porudžbina <span class="jq_orderNumber"></span>
            <small class="pull-right">Datum: <span class="jq_orderDate"></span></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info orderinfocont">
        <div class="col-sm-6 invoice-col">
            <b>Partner</b>
          <address>
            <strong class="jq_ordpartner"></strong><br>
             <strong>PIB:</strong><strong class="jq_ordpartnercode"></strong><br>
             <strong>Email:</strong><strong class="jq_ordpartneremail"></strong><br>
             <strong>Adresa:</strong><strong class="jq_ordpartneraddress"></strong><br>
          </address>
        </div>
        <div class="col-sm-6 invoice-col invoicepartneraddress">
           <b>Adresa partnera</b>
          <address>
            <strong class="jq_ordpartneraddressobjectname"></strong><br>
            <strong class="jq_ordpartneraddressaddress"></strong><br>
          </address>
        </div>  
      </div>
      <div class="row invoice-info orderinfocont">

        <div class="col-sm-4 invoice-col">
          <b>Prodavac</b>
          <address>
            <strong><?php echo $user_conf["memorandum_line1"][1];?></strong><br>
            <?php echo $user_conf["memorandum_line2"][1];?><br>
            <?php echo $user_conf["memorandum_line3"][1];?><br>
            <?php echo $user_conf["memorandum_line4"][1];?><br>
            <?php echo $user_conf["memorandum_line5"][1];?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Kupac</b>
          <address>
            <strong class="jq_ordname"></strong><br>
            <span class="jq_ordaddress"></span><br>
            Telefon: <span class="jq_ordphone"></span><br>
            Email: <span class="jq_ordemail"></span>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
         <b> Dostava</b>
          <address>
            <strong class="jq_delname"></strong><br>
            <span class="jq_deladdress"></span><br>
            Telefon: <span class="jq_delphone"></span><br>
            Email: <span class="jq_delemail"></span>
          </address>
        </div>
        <!-- /.col -->
        
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
                       
            <tr>
              <th>Proizvod</th>
              <th>Šifra</th>
              <th>Rabat</th>
              <th>Atributi</th>
              <th>Količina</th>
              <th>Cena</th>
              <th>Vrednost</th>
              <th></th>
            </tr>
            
            </thead>
            <tbody class="jq_orderItemsCont">
                      
            </tbody>
			<tfoot class="orderNewItemContFoot hide">
				<tr>
					<td class="documentNewItemInputName"></td>
					<td class="documentNewItemInputCode">
						<div class="form-group">
							<label>Šifra proizvoda</label>
							<input type="text" class="documentNewItemInputCodeHolder width80 form-control">
							<button class="documentNewItemInputCodeButton btn btn-primary btn-xs">Učitaj</button>
						</div>
					</td>
					<td class="documentNewItemInputRebate"></td>
					<td class="documentNewItemInputAttr">
						<div class="form-group">
							<label>Boja</label>
							<select class="documentNewItemSelectNewColor form-control">
								<option value=""> --- </option>
							</select>
						</div>
						<div class="form-group">
							<label>Veličine</label>
							<select class="documentNewItemSelectNewSize form-control"></select>
						</div>
					</td>
					<td>
						<label>Količina: </label>
						<input type="number" class="documentNewItemInputAmount width80 form-control" value="1">
					</td>
					<td class="documentNewItemPrice"></td>
					<td><a class="btn btn-success jq_addNewItemToOrder"><span class="glyphicon glyphicon-plus"></span>Dodaj</a></td>
					<td></td>
					
				</tr>
            </tfoot>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Način plaćanja: <span class="jq_paymentTitle"></span></p>
          <p class="lead">Status banke: <span class="jq_bankstatus"></span></p>
          <div class="bankCommandCont" orderid="" ordernumber="" ordertotal="">
          	<a class="btn btn-primary bankcommand" value="postauthOrder">Postauthorization </a>
            <a class="btn btn-warning bankcommand" value="refundOrder">Povracaj sredstva</a>
            <a class="btn btn-danger bankcommand" value="cancelOrder">Otkazi placanje (void)</a>
          </div>
          
          <p class="" style="margin-top: 30px;">Komentar kupca:</p>
          <p class="text-muted well well-sm no-shadow jq_orderComment" style="margin-top: 10px;">
            
          </p>
		  
		  <p class="" style="margin-top: 30px;">Interni komentar:</p>
          <p class="text-muted well well-sm no-shadow jq_orderInternalcommentCont" style="margin-top: 10px;">
          		<textarea class="form-control jq_orderInternalcomment" rows="3"></textarea>
				<a class="btn btn-primary jq_orderInternalcommentButton"><i class="fa fa-save"></i> Snimi</a>
          </p>
          
          
          <div class="row">
          	<div class="col-sm-6">
           			
            </div>
          </div>
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%">Ukupno bez PDV-a:</th>
                <td>
					<span class="jq_orderTotalNoPdv"></span> 
					<span class="jq_orderCurrency"></span>
				</td>
              </tr>
              <tr>
                <th>PDV (20%)</th>
                <td>
					<span class="jq_orderTotalPdv"></span> 
					<span class="jq_orderCurrency"></span>
				</td>
              </tr>
              <tr class="hide">
                <th>Troškovi dostave:</th>
                <td>
					<span class="jq_orderDeliveryCost"></span> 
					<span class="jq_orderCurrency"></span>
				</td>
              </tr>
			  <tr class="jq_orderCouponCont hide">
                <th>Kupon:</th>
                <td>
					-<span class="jq_orderCouponAmount"></span>  
					 ( <span class="jq_orderCouponCode"></span> )
				</td>
              </tr>
              <tr>
                <th>Ukupno sa PDV-om:</th>
                <td>
					<b><span class="jq_orderTotal"></span> 
					<span class="jq_orderCurrency"></span></b>
				</td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12 verticalMargin10 hide">
          <a  target="_blank" class="btn btn-default jq_printOrderB2CButton" ><i class="fa fa-print"></i> Štampaj</a>
          
          <button type="button" class="btn btn-success horizontalMargin10 pull-right jq_acceptOrderButton hide"><i class="fa fa-check"></i> Prihvati porudžbinu </button>
		  <button type="button" class="btn btn-danger horizontalMargin10 pull-right  jq_declineOrderButton hide"><i class="fa fa-times-circle"></i> Obijanje porudžbine </button>
		  
          <!--
		  <button type="button" class="btn btn-primary pull-left" style="margin-right: 5px;" disabled="disabled">
            <i class="fa fa-download"></i> Izvezi PDF
          </button>
		  -->
        </div>
      </div>
    </section>
    
</div>



<div class="modal fade" id="prodavnicaAmountModal" role="dialog">
	<div class="modal-dialog modal-sm">
	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Stanje u prodavnicama <br /> <b><span class="jq_prodavnicaModalAttrHolder"></span></b></h4>
		</div>
		<div class="modal-body">
			<table class="table table-bordered table-condensed table-striped table-hover dataTablecrna newpage showalltables prodavnicaTable"  style="display: block;">
				<tbody class="prodavnicaTableTbody">
						
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
		</div>
	  </div>
	  
	</div>
</div>
