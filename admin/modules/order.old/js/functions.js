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
			},
			success:function(response){
				var a = JSON.parse(response);
				$(".documentType").val(a.documenttype);				
				$(".documentNumber").val(a.number);
				$(".documentDate").val(a.documentdate);
				$(".documentValuteDate").val(a.valutedate);
				$(".documentWarehouse").val(a.warehousename);
				$(".documentUserType").val(a.usertype);
				$(".documentPartnerUser").val(a.partneruser);	
				$(".documentDocReturn").val(a.docreturn);				
				$(".documentSyncStatus").val(a.syncstatus);
				$(".documentStatus").val(a.status);	

				$(".documentDocTotal").html('');				
				$(".documentDocTotal").html(round2Fixed(a.total_value));	
				$(".documentDocRebateTotal").html('');				
				$(".documentDocRebateTotal").html(round2Fixed(a.total_rebate));	
				$(".documentDocItemValueTotal").html('');				
				$(".documentDocItemValueTotal").html(round2Fixed(a.total_value_rebate));	
				$(".documentDocVatTotal").html('');				
				$(".documentDocVatTotal").html(round2Fixed(a.total_vat));	
				$(".documentDocItemValueVatTotal").html('');				
				$(".documentDocItemValueVatTotal").html(round2Fixed(a.total_value_vat));					
				
				$(".documentItem").html('');
				
				for(var i = 0; i < (a.documentitem).length; i++){

					var clone = $(".documentItemRowContTemplate").clone(true).removeClass('hide').removeClass('documentItemRowContTemplate').attr('documentitemid', a.documentitem[i].documentitemid).attr('productid', a.documentitem[i].productid);
					
					$(clone).find(".documentItemProductSort").html(i+1);
					$(clone).find(".documentItemProductName").html(a.documentitem[i].productname);
					$(clone).find(".documentItemProductQuantity").html(round2Fixed(a.documentitem[i].quantity));
					$(clone).find(".documentItemProductPrice").html(round2Fixed(a.documentitem[i].price));
					$(clone).find(".documentItemProductRebateValue").html(round2Fixed(a.documentitem[i].rebatevalue));
					$(clone).find(".documentItemProductItemvalue").html(round2Fixed(a.documentitem[i].itemvalue));
					$(clone).find(".documentItemProductTaxValue").html(round2Fixed(a.documentitem[i].itemvalue * ((a.documentitem[i].taxvalue)/100)));
					$(clone).find(".documentItemItemValueVat").html(round2Fixed(a.documentitem[i].itemvalue * (1+(a.documentitem[i].taxvalue)/100)));


					$(clone).appendTo($(".documentItem"));	
				}				
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});
	}
	else{
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getlanguageslist'}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				
				$(".documentType").val('');
				$(".documentNumber").val('');
				$(".documentDate").val('');
				$(".documentValuteDate").val('');
				$(".documentWarehouse").val('');
				$(".documentUserType").val('');
				$(".documentPartnerUser").val('');
				$(".documentDocReturn").val('');
				$(".documentSyncStatus").val('');
				$(".documentStatus").val('');
				
				$(".documentItem").html('');
				$(".documentDocTotal").html('');				
				$(".documentDocRebateTotal").html('');				
				$(".documentDocItemValueTotal").html('');				
				$(".documentDocVatTotal").html('');				
				$(".documentDocItemValueVatTotal").html('');				
				/*for(var i = 0; i < a.length; i++){
					
					var clone = $(".documentNameContTemplate").clone(true).removeClass('hide').removeClass('documentNameContTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].langid);
					$(clone).find("span").html(a[i].name);
					$(clone).find(".documentName").val('');
					
					$(clone).appendTo($(".documentItem"));	
				}*/
				
				$(".loadingIcon").addClass("hide");	
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