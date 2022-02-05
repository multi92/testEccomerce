function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete vest?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "delete", id: $this.attr("id") }
		}).done(function(result){
			alert("Uspesno obrisano!");
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
		function round2Fixed(value) {
		  value = +value;
		
		  if (isNaN(value))
			return NaN;
		
		  // Shift
		  value = value.toString().split('e');
		  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + 2) : 2)));
		
		  // Shift back
		  value = value.toString().split('e');
		  return (+(value[0] + 'e' + (value[1] ? (+value[1] - 2) : -2))).toFixed(2);
		}
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getitem',
					id : $(".content-wrapper").attr('currentid')}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");  
			  console.log(textStatus);                          
			},
			success:function(response){
				var a = JSON.parse(response);
								
				$('.jq_ordname').html(a['document']['customername']+" "+a['document']['customerlastname']);
				$('.jq_ordaddress').html(a['document']['customeraddress']+", "+a['document']['customerzip']+" "+a['document']['customercity']);
				$('.jq_ordphone').html(a['document']['customerphone']);
				$('.jq_ordemail').html('<a class="jq_openEmailBox">'+a['document']['customeremail']+'</a>');
				
				$('.jq_delname').html(a['document']['recipientname']+" "+a['document']['recipientlastname']);
				$('.jq_deladdress').html(a['document']['recipientaddress']+", "+a['document']['recipientzip']+" "+a['document']['recipientcity']);
				$('.jq_delphone').html(a['document']['recipientphone']);
				$('.jq_delemail').html('<a class="jq_openEmailBox">'+a['document']['customeremail']+'</a>');
				
				$('.jq_orderDate').html(a['document']['documentdate']);
				$('.jq_orderNumber').html(a['document']['number']);
				$('.jq_orderComment').html(a['document']['comment']);
				$('.jq_orderInternalcomment').html(a['document']['additionalcomment']);
				
				$('.jq_paymentTitle').html((a['document']['payment'] == 'kar')? 'Karticom':'Pouzećem');
				
				if(a['document']['payment'] != 'k')
				{
					$('.bankCommandCont').addClass('hide');
					$('.jq_bankstatus').addClass('hide');
				}
				
				var bankstatus = 'Preauthorization';
				if(a['document']['bankstatus'] == 'post') bankstatus = 'Postauthorization';
				if(a['document']['bankstatus'] == 'fail') bankstatus = 'Odbijena';
				if(a['document']['bankstatus'] == 'void') bankstatus = 'Otkazana';
				$('.jq_bankstatus').html(bankstatus);
				
				if(a['document']['couponcode'] != '0')
				{
					$('.jq_orderCouponCont').removeClass('hide');
					$('.jq_orderCouponAmount').html(a['document']['couponamount']);
					$('.jq_orderCouponCode').html(a['document']['couponcode']);
				}
				
				$(".jq_orderItemsCont").html('');
				
				var total_no_pdv = 0;
				var total_value = 0;				
				
				for(var i = 0; i < (a.items).length; i++){
					var clone = $(".orderItemRowContTemplate").clone(true).removeClass('hide').removeClass('orderItemRowContTemplate').attr('documentitemattrid', a.items[i].documentitemattrid);
					$(clone).find(".jq_orderItemProductName").html(a.items[i].name);
					$(clone).find(".jq_orderItemProductCode").html(a.items[i].code);
					$(clone).find(".jq_orderItemProductBarcode").html(a.items[i].barcode);
					$(clone).find(".jq_orderItemProductRebate").html(round2Fixed((1-a.items[i].rebate)*100));
					
					var attrcont = '';
					var av = JSON.parse(a.items[i]['attrvalue']);
					
					for(var j = 0; j < (av).length; j++){
						attrcont = attrcont + av[j][0] + ": "+av[j][1]+"</b><br />";	
					}
					
					//if ("boja" in a.items[i].attrvalue) {
					//	attrcont = attrcont + "boja: "+a.items[i].attrvalue['boja']+" / <b>"+a.items[i].colornumber+"</b><br />";	
					//}
					//if ("veličina" in a.items[i].attrvalue) {
					//	attrcont = attrcont + "veličina: "+a.items[i].attrvalue['veličina']+"<br />";	
					//}
					$(clone).find(".jq_orderItemProductAttr").html(attrcont);
					
					$(clone).find(".jq_orderItemProductAmountInput").val(a.items[i].quantity);
					$(clone).find(".jq_orderItemProductPrice").html(round2Fixed(a.items[i].price * a.items[i].rebate * a.items[i].taxvalue ));
					$(clone).find(".jq_orderItemProductValue").html(round2Fixed(a.items[i].price * a.items[i].rebate * a.items[i].taxvalue * a.items[i].quantity));
					
					$(clone).find(".jq_orderItemProductDeleteButton").attr('documentitemattrid', a.items[i].documentitemattrid);
					
					if(a.items[i].rowstatus == 'd'){
						$(clone).find(".jq_orderItemProductDeleteButton").addClass('hide');
						$(clone).find(".jq_orderItemProductAmountInput").attr('disabled', 'disabled').css('background-color', 'gray');
						$(clone).find('.jq_orderItemProductSaveButton').addClass('hide');
						$(clone).css('background-color', 'gray');
					}
					
					$(clone).appendTo($(".jq_orderItemsCont"));	
					
					if(a.items[i].rowstatus == 'a'){
						// calculate if row is active	
						total_no_pdv = total_no_pdv + (a.items[i].price * a.items[i].rebate * a.items[i].quantity);
						total_value = total_value + (a.items[i].price * a.items[i].rebate * a.items[i].taxvalue * a.items[i].quantity);						
					}
				}				
				
				var delivery = parseFloat(a['document']['deliverycost']);
				
				$('.jq_orderCurrency').html(a['document']['documentcurrency']);
				$('.jq_orderTotalNoPdv').html(round2Fixed(total_no_pdv));
				$('.jq_orderDeliveryCost').html(delivery);
				$('.jq_orderTotalPdv').html(round2Fixed(total_value-total_no_pdv));
				$('.jq_orderTotal').html(round2Fixed(total_value+delivery-parseFloat(a['document']['couponamount'])));
					
				/*	BANKA START	*/	
				
				$('.bankCommandCont').attr('orderid', a['document']['id']).attr('ordernumber', a['document']['number']).attr('ordertotal', round2Fixed(total_value+delivery))
				
				/*	BANKA END	*/
				
				if(a['document']['status'] == 'o'){
					$('.jq_acceptOrderButton').removeClass('hide');
					$('.jq_declineOrderButton').removeClass('hide');	
				}
				
				$(".loadingIcon").addClass("hide");	
				$('.jq_pagecover').addClass('hide');
				$(".addChangeCont").removeClass('hide');
				
			}
		});
	}
	
}

function saveAddChange(){
	var docid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		docid = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;
	if($('.documentNameCont[defaultlang="y"]').find(".documentName").val() == "")
	{
		$('.documentNameCont[defaultlang="y"]').addClass("has-error");
		noerror = false;
	}
	
	if($('.documentPath').val() == "")
	{
		$('.documentPath').parent().addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ 
		alert('Popunite obavezna polja');
		$(".loadingIcon").addClass("hide");	
	}
		
	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					docid: docid,
					link : $(".documentPath").val(),
					showname : $(".documentName").val(),
					image : $(".documentImage").val(),
					delovodni : $(".documentDelovodni").val(),
					date : $(".documentDate").val(),
					values : []
				};
				
		$(".documentNameCont:not(.documentNameContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				showname : $(this).find('.documentName').val()
			});
		});
		
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
					window.location.href = 'document';
				}
			}
		});
	}		
}


function updateOrderAmount(elem){
	var id = "";
	if($(elem).attr('documentitemattrid') != "")
	{
		id = $(elem).attr('documentitemattrid');
	}
	
	var noerror = true;
	if($(elem).find('.jq_orderItemProductAmountInput').val() == "")
	{
		$(elem).find('.jq_orderItemProductAmountInput').parent().addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ 
		alert('Popunite obavezna polja');
		$(".loadingIcon").addClass("hide");	
	}
		
	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "updateitemamount",
			id: id,
			amount : $(elem).find('.jq_orderItemProductAmountInput').val()
		};
				
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				document.location.reload();
				
			}
		});
		
	}	
}

function deleteOrderItem(elem){
	var id = "";
	if($(elem).attr('documentitemattrid') != "")
	{
		id = $(elem).attr('documentitemattrid');
	}
	
	var noerror = true;
	
	if(!noerror){ 
		alert('Popunite obavezna polja');
		$(".loadingIcon").addClass("hide");	
	}
		
	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "deleteorderitem",
			id: id
		};
				
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				document.location.reload();
				
			}
		});
		
	}		
}

function acceptorder(){
	/*	objecty to pass	 */
	var passdata = {action: "acceptorder",
		id: $('.content-wrapper').attr('currentid')
	};
			
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			document.location.reload();
		}
	});	
}

function declineorder(){
	var passdata = {action: "declineorder",
		id: $('.content-wrapper').attr('currentid')
	};
			
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			window.location.reload();
			
		}
	});	
}

function bankcommand(elem){
	
	var passdata = {action: "bankcommand",
		type: $(elem).attr('value'),
		oid: $(".bankCommandCont").attr('ordernumber'),
		total: $(".bankCommandCont").attr('ordertotal')
	};
	
	$.ajax({
		type : 'POST',
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),		
		success : function(data){
			var a = JSON.parse(data);
			console.log(a);
			if(a['Response'] == 'Error'){
				alert('Greska! Nije moguce izvrsiti!');	
			}else if(a['Response'] == 'Approved'){
				alert('Uspesno izvrseno');
				window.location.reload();
			}
		},
		error : function(){	
			alert("error");
		}
	});	
}