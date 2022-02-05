<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header">
		<h1>
			Dokument
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
			<li class="active"> Dokumenti</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
		
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista dokumenata</button>
            </div>
        </div>
        
        <div class="box box-primary box-body addChangeCont hide" >
       		<div class="loaded" id=''></div>
        	<div class="row">
            	<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Tip dokumenta</label>
								<input type="text" class="form-control documentType" readonly/>
							</div>
					    </div>
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Broj dokumenta</label>
								<input type="text" class="form-control documentNumber" readonly/>
							</div>
					    </div>
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Datum dokumenta</label>
								<input type="text" class="form-control documentDate" readonly/>
							</div>
					    </div>						
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Datum valute</label>
								<input type="text" class="form-control documentValuteDate" readonly/>
							</div>
					    </div>		
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Magacin</label>
								<input type="text" class="form-control documentWarehouse" readonly/>
							</div>
					    </div>						
						
                   </div>
				   	<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Tip kupca</label>
								<input type="text" class="form-control documentUserType" readonly/>
							</div>
					    </div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label" >Kupac</label>
								<input type="text" class="form-control documentPartnerUser" readonly/>
							</div>
					    </div>										
                   </div>
				   	<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Povraćaj</label>
								<input type="text" class="form-control documentDocReturn" readonly/>
							</div>
					    </div>
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Sinhronizovan</label>
								<input type="text" class="form-control documentSyncStatus" readonly/>
							</div>
					    </div>	
						<div class="col-sm-2">
							<div class="form-group">
								<label class="control-label" >Status</label>
								<input type="text" class="form-control documentStatus" readonly/>
							</div>
					    </div>						
                   </div>
				   <div class="row">
						<div class="col-sm-12">
						<label class="control-label" >Stavke dokumenta</label>
						<table  class="table table-bordered table-striped" role="grid">
							<thead>
								  <tr>
									<th>R.b.</th>
									<th>Proizvod</th>
                                    <th>Kolicina</th>
									<th>Cena</th>
									<th>Popust</th>
									<th>Vrednost</th>
									<th>PDV</th>
									<th>Vrednost sa PDV-om</th>
								  </tr>
							</thead>
							<tbody class="documentItem">
							</tbody>
						</table>
						</div>						
                   </div>
				   <div class="row">
						<div class="col-sm-3 pull-right" >
							<div class="form-group">
								<label class="control-label" style="width:100%; padding-right:10px;">Vrednost: <span class="documentDocTotal pull-right">0.00</span></label>
							</div>
							<div class="form-group">
								<label class="control-label" style="width:100%; padding-right:10px;">Popust: <span class="documentDocRebateTotal pull-right">0.00</span></label>
							</div>
							<div class="form-group">
								<label class="control-label" style="width:100%; padding-right:10px;">Vrednost sa popustom: <span class="documentDocItemValueTotal pull-right">0.00</span></label>
							</div>
							<div class="form-group">
								<label class="control-label" style="width:100%; padding-right:10px;">PDV: <span class="documentDocVatTotal pull-right">0.00</span></label>
							</div>
							<hr>
							<div class="form-group">
								<label class="control-label" style="width:100%; padding-right:10px;">Vrednost sa PDV-om: <span class="documentDocItemValueVatTotal pull-right">0.00</span></label>
							</div>
							<hr>
					    </div>
				   </div>
                </div>
            </div>
            <!-- <button class="btn btn-primary generatePDF">Eksportuj u PDF</button>-->
        </div>
	</section>
	<!-- /.content -->
</div>
