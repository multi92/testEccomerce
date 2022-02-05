<div class="col-sm-4 langGroupCont hide langGroupContTemplate" langid='' defaultlang='' >
	<h3 class="langname"></h3>

	<div class="ckcont" id=""></div>
</div>

<div class="col-sm-12 reportCont hide reportContTemplate"  >
	<div class="form-group">
		<label>Kod izveštaja</label>
		<textarea class="form-control reportText" rows="25"></textarea>
		<!-- <div class="ckcont" id=""></div> -->
	</div>
</div>

<div class="form-group reportInput stringInputCont  hide stringInputContTemplate" report-input-type="string" report-input-name="" report-input-mask="" report-input-value="">
	<div class="row">
		<div class="col-sm-2"><label class="stringInputName">String</label></div>
		<div class="col-sm-8"><input type="text" class="form-control stringInputValue" placeholder="Unestite reč" ></div>
	</div>
</div>
<div class="form-group reportInput partnerInputCont hide partnerInputContTemplate" report-input-type="partner" report-input-name="" report-input-mask="" report-input-value="">
	<div class="row">
		<div class="col-sm-2"><label class="partnerInputName">Partner</label></div>
		<div class="col-sm-8"><input type="text" class="form-control partnerInputValue" placeholder="Odaberite partnera" selectedPartnerId="" disabled="disabled"></div>
		<div class="col-sm-2"><button class="btn btn-primary selectPartnerButton" data-toggle="modal" data-target="">...</button></div>

	</div>

<div class="form-group reportInput productInputCont hide productInputContTemplate" report-input-type="product" report-input-name="" report-input-mask="" report-input-value="">
	<div class="row">
		<div class="col-sm-2"><label class="productInputName">Proizvod</label></div>
		<div class="col-sm-8"><input type="text" class="form-control productInputValue" placeholder="Odaberite proizvod" ></div>
		<div class="col-sm-2"><button class="btn btn-primary selectProduct">...</button></div>
	</div>
</div>