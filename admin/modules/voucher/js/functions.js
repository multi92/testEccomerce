function deleteVoucherCategory_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete podatak?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteVoucherCategory", voucherid: $this.attr("voucherid"), categoryid: $this.attr("categoryid")}
		}).done(function(result){
			//$('#tablePromoCodeCategory').DataTable().ajax.reload();
			document.location.reload();
		});		
	}	
}

function deleteVoucherProduct_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete podatak?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteVoucherProduct", voucherid: $this.attr("voucherid"),productid: $this.attr("productid") }
		}).done(function(result){
			//$('#tablePromoCodeProduct').DataTable().ajax.reload();
			document.location.reload();
		});		
	}	
}

function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete podatak?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "delete", id: $this.attr("id") }
		}).done(function(result){
			alert("Uspešno obrisano!");
			document.location.reload();
		});		
	}	
}

function changestatus_handler(elem){
	$this = $(elem);
		if($(elem).attr("currentStatus") != $(elem).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changestatus", id: $this.attr("id"), status:$(elem).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				hideLoadingIcon();
			});
			
		}	
}

function createAddChangeForm(){
	if($(".content-wrapper").attr('currentid') != '')
	{
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getitem',
					id : $(".content-wrapper").attr('currentid')}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				//$(".addChangeLangCont").html('');
				
				$(".voucherNameInput").val(a.name);
				$(".voucherInput").val(a.voucher);
				$(".voucherExipratinDateInput").val(a.expirationdate);
				$(".voucherValueInput").val(a.value);
				if(a.vouchertype=="w"){
					$(".voucherTypeDiscountInput").val("Welcome vaucer")
				}
				//$(".voucherTypeDiscountInput").val(a.vouchertype);
				if(a.vouchertype=="hp"){
					$(".voucherTypeDiscountInput").val("HappyBirthady vaucer")
				}
				if(a.vouchertype=="s"){
					$(".voucherTypeDiscountInput").val("Standardni vaucer")
				}
				/*if(a.valuetype == "T"){
					$(".voucherTypeDiscount").val("Totalni popust");
				}

				if(a.valuetype == "P"){
					$(".voucherTypeDiscount").val("Popust izrazen u procentima");
				}

				if(a.valuetype == "I"){
					$(".voucherTypeDiscount").val("Individualni popust");
				}*/
				//$(".voucherType").val(a.valuetype);
				$(".voucherTypeDiscountS").val(a.valuetype);
				$(".voucherTypeInput").val(a.type);
				//$(".voucherTypeDiscount").val(a.type);
				$(".voucherWarehouseIdInput").val(a.warehouseid);
				$(".voucherApplyOnProductWithRebateInput").val(a.applyonproductwithrebate);
				

				if(a.type=='a'){

				}

				if(a.type=='c'){
					
					$(".voucherValue").addClass('hide');
					$(".voucherTypeDiscountCont").addClass('hide');
					$(".voucherValueInput").addClass('hide');
					$(".voucher_category").removeClass('hide');
					$(".voucher_users").removeClass('hide');
				}

				if(a.type=='p'){
					$(".voucherTypeDiscountCont").addClass('hide');
					$(".voucherValue").addClass('hide');
					$(".voucherValueInput").addClass('hide');
					$(".voucher_product").removeClass('hide');
				}
				
				/*var wt = JSON.parse(a.worktime);
							
				$(".shopsWorkTimeWeekFrom").val(wt['mf']['from']);
				$(".shopsWorkTimeWeekTo").val(wt['mf']['to']);
				$(".shopsWorkTimeSaturdayFrom").val(wt['st']['from']);
				$(".shopsWorkTimeSaturdayTo").val(wt['st']['to']);
				$(".shopsWorkTimeSundayFrom").val(wt['su']['from']);
				$(".shopsWorkTimeSundayTo").val(wt['su']['to']);
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');*/			
			}
		});
	}
	else{
		alert('Došlo je do greške.');
		/*$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getlanguageslist'}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				
				$(".shopsNameInput").val('');
				$(".shopsAddressInput").val('');
				$(".shopsPhoneInput").val('');
				$(".shopsMobileInput").val('');
				$(".shopsFaxInput").val('');
				$(".shopsEmailInput").val('');
				$(".shopsCoordinatesInput").val('');
				$(".shopsImageInput").val('');
				$(".shopsTypeInput").val('');
				$(".shopsDescriptionTextarea").html('');
				$(".newscitycont").val('');
				$(".newswarehousecont").val('');
				$(".newsgallerycont").val('');
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				
				//$(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat','0');
				$(".newscategorycont").val('0');				
				//$(".categorySelectHolder").first().find(".newscategorycont").val('0');
				//for(var k = 1; k < (a.categoryid).length; k++){
				//	var clone = $(".categorySelectHolder").first().clone(true);	
					//alert(a.categoryid[k]);	
				//	$(clone).find(".newscategorycont").val('0');
				//	$(clone).insertAfter($(".categorySelectHolder").last());
				//}
			}
		});	*/
	}
}

function saveAddChange(){
	var id = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		id = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;

	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					id: id,
					name: $(".voucherNameInput").val(),
					voucher: $(".voucherInput").val(),
					expirationdate: $(".voucherExipratinDateInput").val(),
					image: '',
					value: $(".voucherValueInput").val(),
					type: $(".voucherTypeInput").val(),
					warehouse: $(".voucherWarehouseIdInput").val(),
					newvouchertypediscount: $(".voucherTypeDiscountS").val() 		
					};

		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
								
				
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					window.location.reload(); 
				}
			}
		});
	}		
}

function addNewUserVoucher(){
	//alert("Proba");
	var gonext = false;
	if($(".newUserId").val() == 0){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}

	if($(".newVoucherId").val() == 0){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}
	if(gonext){
		var passdata = {action: "checkUservoucher",
					userid: $(".newUserId").val(),
					voucherid : $(".newVoucherId").val()		
					};
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a=response;				
				console.log(a);
				if(a > 0)
				{					
					alert('Korisniku je vec dodeljen vaucer tog tipa, izaberite drugi vaucer');
				}
				else{
					$.ajax({
						type : 'POST',
						url:"modules/"+moduleName+"/library/functions.php",
						data : "action=addUserVoucher&userid="+$(".newUserId").val()+"&voucherid="+$(".newVoucherId").val(),
						
						success : function(data){
							if(data ==1){
								alert("Uspešno kreirano!");
								window.location.reload();

							}
							else {
								alert('Neuspelo kreiranje vaucera!');
							}
						},
						error : function(){	
							alert("Korisnik ima vec dodeljen vaucer");
						}
					});	
				}
			}
		});
	}
	else{
		alert("Izaberite potrebne podatke za vaucer");
	}
}

function addNewVoucherCode(){

	var gonext = false;
	//Voucher name
	if($(".jq_voucherName").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}
	//ovde stoji vaucer ali ne znam da li treba da se koristi
	if($(".jq_voucher").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}


	//Voucher type => type
	if($(".jq_newVoucherType").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}

	//VoucherQuantityDiscount -> vouchertype
	if($(".jq_newVoucherQuantityDiscount").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}

	//newVoucherQuantityDiscount => vouchertype
	if($(".jq_newVoucherTypeDiscount").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}

	//newVoucherApplyOnProductWithRebate => applyonproductwithrebate
	if($(".jq_newVoucherApplyOnProductWithRebate").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}

	//warehouseid
	if($(".jq_newCouponWarehouseId").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}

	//expirationdate 
	if($(".jq_newVoucherExpirationDate").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}



	/*	objecty to pass	 */
	if(gonext){
		var passdata = {action: "checkvoucher",
					voucher: $(".jq_voucherName").val()		
					};

		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a=response;				
				
				if(a > 0)
				{
					
					alert('Vaucer '+$(".jq_voucherName").val()+' već postoji.');
				}
				else{
					$.ajax({
						type : 'POST',
						url:"modules/"+moduleName+"/library/functions.php",
						data : "action=addnewvoucher&newname="+$(".jq_voucherName").val()+"&newtype="+$(".jq_newVoucherType").val()+"&newvoucherquantitydiscount="+$(".jq_newVoucherQuantityDiscount").val()+"&newvouchertypediscount="+$(".jq_newVoucherTypeDiscount").val()+"&newapplyonproductwithrebate="+$(".jq_newVoucherApplyOnProductWithRebate").val()+"&newwarehouseid="+$(".jq_newCouponWarehouseId").val()+"&newexpirationdate="+$(".jq_newVoucherExpirationDate").val(),
						
						success : function(data){
							console.log(data);
							if(data == 1){
								alert('Uspešno kreirano!');	
								$(".jq_voucherName").val('');
								$(".jq_newVoucherType").val('a');
								$(".jq_newVoucherQuantityDiscount").val('s');
								$(".jq_newVoucherTypeDiscount").val('I');
								$(".jq_newVoucherApplyOnProductWithRebate").val('n');
								$(".jq_newCouponWarehouseId").val('0');
								//$(".jq_newPromoCodeExpirationDate").val('--.--.----');
								window.location.reload();
							}else{
								alert('Neuspelo kreiranje promo koda!');	
							}
						},
						error : function(){	
							alert("error");
						}
					});	
				}

				
			}
		});
	} else {
		alert('Sva polja su obavezna!');
	}
	
}

