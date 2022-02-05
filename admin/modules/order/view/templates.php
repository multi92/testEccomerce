<select class="form-control selectStatus hide selectStatusTemplate" id="" currentstatus="n" disabled>
     <option value="n">Nova</option>
     <option value="o">U obradi</option>
	 <option value="f">Za slanje</option>
	 <option value="w">Za slanje na čekanju</option>
	 <option value="s">Poslata</option>
	 <option value="p">Naplaćena</option>
	 <option value="d">Odbijena</option>
	 <option value="u">Odbijena sa razlogom</option>
 </select>
 
<div class="col-sm-4 documentNameCont documentNameContTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
        <label>Ime za prikazivanje porudžbina - <span></span></label>
        <input type="text" class="form-control documentName" />
    </div>
</div>
<table class="" >
<tr class="documentItemCont documentItemRowContTemplate hide" role="row" documentitemid="" productid="">
    <td class="documentItemProductSort"></td>
	<td class="documentItemProductName"></td>
	<td class="documentItemProductQuantity"></td>
	<td class="documentItemProductPrice"></td>
	<td class="documentItemProductRebateValue"></td>
	<td class="documentItemProductItemvalue"></td>
	<td class="documentItemProductTaxValue"></td>
	<td class="documentItemItemValueVat"></td>
</tr>

<tr class="orderItemRowContTemplate hide" role="row" documentitemattrid="" productid="">
	<td class="jq_orderItemProductName">Proizvod</td> 
	<td class="jq_orderItemProductCode">Sifra</td>
	<td class="jq_orderItemProductBarcode" style="font-weight: bold; color:#f46704;">Barkod</td>
	<td class="jq_orderItemProductRebate"></td>
	<td class="jq_orderItemProductAttr">
		Boja:  <br />
		Veličina: 
	</td>
	<td>
		<input type="number" class="form-control width80 documentItemAmountInput jq_orderItemProductAmountInput" value="1" />
		<a class="btn btn-primary btn-xs documentItemAmountSaveButton jq_orderItemProductSaveButton">
			<i class="fa fa-save"></i> Save <i class="fa fa-spinner fa-spin jq_saveSppiner loadingIcon hide "></i><i class="fa fa-check jq_saveCheck hide"></i>
		</a>
	</td>
	<td class="jq_orderItemProductPrice">0,000.00</td>
	<td class="jq_orderItemProductValue">0,000.00</td>
	<td><a class="btn btn-danger btn-xs jq_orderItemProductDeleteButton">X</a></td>
</tr>

</table>