<select class="form-control selectStatus hide selectStatusTemplate" id="" currentstatus="n" disabled>
     <option value="n">Nova</option>
     <option value="o">U obradi</option>
	 <option value="f">Za slanje</option>
	 <option value="w">Za slanje na čekanju</option>
	 <option value="s">Poslata</option>
	 <option value="p">Naplaćena</option>
	 <option value="d">Odbijena</option>
	 <option value="u">Odbijena sa razlogom</option>
	<option value="bp">Brza porudžbina</option>
	<option value="z">Prihvaćena</option>
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
	<td class="jq_orderItemProductName">ZENSKI KAPUT 'VANG'</td> 
	<td class="jq_orderItemProductCode">29527</td>
	<td class="jq_orderItemProductRebate"></td>
	<td class="jq_orderItemProductAttr">
		Boja: zelena <br />
		Veličina: XXL
	</td>
	<td>
		<input type="number" class="form-control width80 documentItemAmountInput jq_orderItemProductAmountInput" value="1" disabled="disabled"/>
		<a class="btn btn-primary btn-xs documentItemAmountSaveButton jq_orderItemProductSaveButton hide">
			<i class="fa fa-save"></i> Save <i class="fa fa-spinner fa-spin jq_saveSppiner loadingIcon hide "></i><i class="fa fa-check jq_saveCheck hide"></i>
		</a>
	</td>
	<td class="jq_orderItemProductPrice">7,500.00</td>
	<td class="jq_orderItemProductValue">22,500.00</td>
	<td><a class="btn btn-danger btn-xs jq_orderItemProductDeleteButton hide">X</a></td>
</tr>

</table>