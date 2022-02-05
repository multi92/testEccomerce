function resetForm(){
	$(".documentPath").val('').parent().removeClass("has-error").removeClass("has-success");
	$(".documentName").val('');
	$(".documentDelovodni").val('');
	$(".documentDate").val('');
	$(".loaded").attr('id', '');
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
function verifypath(elem){
	if($(elem).val() != "")
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "verifypath", 
				path: $(elem).val() 
			}
		}).done(function(result){
			if(result == 0)
			{
				$(elem).parent().removeClass("has-success").addClass("has-error");
				$(".saveAddChange").prop("disabled", true);	
			}
			else{
				$(elem).parent().removeClass("has-error").addClass("has-success");
				$(".saveAddChange").prop("disabled", false);
			}	
		});		
	}
}
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
$(document).ready(function(e) {
	
	
	
	var maintable = $("#listtable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
		"pageLength": 50,
		"ordering": true,
		"columns": [
				{ 'className': "maxwidth30" },
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				{ 'className': "paddingHorizontal0" }
			],
		"rowCallback": function (row, data) {
			var regex = /currentstatus="n"/g;
			var found = data[7].match(regex);
			
			if(found != null){
				$(row).addClass('highlight');
			//	console.log(data[5]);
			}
		},
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");    
                },
				"data": function ( d ) {
					d.filterstatus = ($('.jq_statusSelect').val() == '')? localStorage.getItem('Datetable_fiter_status'):$('.jq_statusSelect').val();
					d.filterpayment = $('.jq_paymentSelect').val();
					d.filtertype = $('.jq_typeSelect').val();
					d.filtercountry = $('.jq_countrySelect').val();
				},
				dataSrc: function(d){
					//console.log(d);
					$('.jq_totalSentValue').html(d.totalvalue);
					$('.jq_statusSelect').val(localStorage.getItem('Datetable_fiter_status'));
					$('.jq_paymentSelect').val(localStorage.getItem('Datetable_fiter_payment'));
					$('.jq_typeSelect').val(localStorage.getItem('Datetable_fiter_type'));
					$('.jq_countrySelect').val(localStorage.getItem('Datetable_fiter_country'));
					for(var i = 0; i < d.aaData.length;i++)
					{
						d.aaData[i][5] = '<a class="jq_openEmailBox">'+d.aaData[i][5]+'</a>';
						
						var status = d.aaData[i][8];
						var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-'+d.aaData[i][8]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][8]);
						$(clone).find("option[value='"+d.aaData[i][8]+"']").attr('selected', 'selected');
						d.aaData[i][8] = $(clone).wrap('<div>').parent().html();
						
						var bd = "";
						bc = '<a class="btn btn-primary btn-xs changeViewButton pull-left" style="width:auto;" id="'+d.aaData[i][99]+'">Pogledaj</a> ';
						d.aaData[i][9]= bc;

						if(status == "f" || status == "w" || (d.aaData[i][11] == 'kar' && status == 'p' && d.aaData[i][12] == 'post' && d.aaData[i][10] == '')){
							d.aaData[i][10] = '';
							if(status == "w" && d.aaData[i][13] != null){
								d.aaData[i][10] += "<span>Preostalo vreme: "+d.aaData[i][13]+"</span><br />";
							}
						d.aaData[i][10] += '<input type="text" class="max-width100" /><a class="btn btn-primary btn-xs jq_sendDeliveryEmailButton" orderid="'+d.aaData[i][99]+'" ordernumber="'+d.aaData[i][1]+'"><span class="glyphicon glyphicon-send"></span></a>';
						}else if(status == "s"){
							d.aaData[i][10] = d.aaData[i][10] + ' <a class="btn btn-primary btn-xs jq_confirmPaymentButton" orderid="'+d.aaData[i][99]+'" ordernumber="'+d.aaData[i][1]+'">Plaćeno<span class="glyphicon glyphicon-usd"></span></a>';
						}
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ porudžbina",
				"infoEmpty":      "Prikaz 0 do 0 od 0 porudžbina",
				"infoFiltered":   "(filtrirano od _MAX_ porudžbina)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ porudžbina",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Zadnja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
		
		$('#listtable tbody').on('click', '.deleteButton', function () {
			deleteItem_handler($(this));
		}).on('click', '.jq_sendDeliveryEmailButton', function () {
			if($(this).parent('td').find('input').val() != "")
			{
				$this = $(this);			
				$.ajax({
					method: "POST",
					url : 'modules/'+moduleName+'/library/functions.php',
					data: { action: "sendDeliveryCodeEmail", 
							code: $this.parent('td').find('input').val(), 
							orderid:$($this).attr('orderid') ,
							number: $($this).attr('ordernumber') },
					success : function(data){
						  
						if(data == 1 || data == '1'){
							$this.parent('td').html($this.parent('td').find('input').val());
							window.location.reload();
						}else{
							alert('Nije moguce poslati email!');	
						}
					}
				});
			}else{
				alert('Unesite kod za praćenje!');	
			}
		}).on('click', '.jq_confirmPaymentButton', function () {
			if(confirm('Plaćeno?'))
			{
				$this = $(this);			
				$.ajax({
					method: "POST",
					url : 'modules/'+moduleName+'/library/functions.php',
					data: { action: "confirmPaymentButton",orderid:$($this).attr('orderid') , number: $($this).attr('ordernumber') },
					success : function(data){
						if(data == 1){
							$($this).remove();
							window.location.reload();
						}
					}
				});
			}
		}).on('click', '.changeButton', function () {
			$this = $(this);			
			$.ajax({
				method: "POST",
				url : 'functions.php',
				data: { action: "getorderB2C", id: $this.attr("id") },
				success : function(data){
					var a = JSON.parse(data);
					
					
					$('#jq_documentItemsModalCont').find('.jq_documentItemsModalDocNumber').attr('docid', a['document']['ID']).html(a['document']['number']);
					$('#jq_documentItemsModalCont').find('.jq_modalName').val(a['document']['name']);
					$('#jq_documentItemsModalCont').find('.jq_modalSurname').val(a['document']['surname']);
					$('#jq_documentItemsModalCont').find('.jq_modalAddress').val(a['document']['address']);
					$('#jq_documentItemsModalCont').find('.jq_modalCity').val(a['document']['city']);
					$('#jq_documentItemsModalCont').find('.jq_modalZip').val(a['document']['zip']);
					$('#jq_documentItemsModalCont').find('.jq_modalEmail').val(a['document']['email']);
					$('#jq_documentItemsModalCont').find('.jq_modalPhone').val(a['document']['phone']);
					$('#jq_documentItemsModalCont').find('.jq_modalPayment').val(a['document']['payment']);
					
					$('.jq_documentItemsModalTbody').html('');
					
					/*	create items rows	*/
					var totalvalue = 0;
					for(var i=0; i < (a.items).length; i++){
						var tr = $(document.createElement('tr')).attr('documentitemattrid', a.items[i].documentitemattrid).attr('documentitemid', a.items[i].documentitemid);
						$(tr).attr('price', a.items[i].price);
						$(tr).attr('tax', a.items[i].tax);
						$(tr).attr('rebate', a.items[i].rebate);
						$(tr).attr('quantity', a.items[i].quantity);
						$(document.createElement('td')).html(a.items[i].name).appendTo($(tr));
						$(document.createElement('td')).html(a.items[i].code).appendTo($(tr));
						$(document.createElement('td')).html(100-(100*(a.items[i].rebate))+"%").appendTo($(tr));
						
						var td = $(document.createElement('td'));
						
						$(document.createElement('span')).html('mass : <b>'+a.items[i].attrvalue.mass+'</b><br />').appendTo($(td));
						$(document.createElement('span')).html('boja : <b>'+a.items[i].attrvalue.boja+'</b><br />').appendTo($(td));
						$(document.createElement('span')).html('velicina : <b>'+a.items[i].attrvalue.veličina+'</b><br />').appendTo($(td));
												
						$(td).appendTo($(tr));
						$(document.createElement('td')).html(a.items[i].quantity).appendTo($(tr));
						$(document.createElement('td')).html((Math.round(parseFloat(a.items[i].price)*parseFloat(a.items[i].taxvalue)*parseFloat(a.items[i].rebate))).toFixed(2)).appendTo($(tr));
						$(document.createElement('td')).html((Math.round(parseFloat(a.items[i].price)*parseFloat(a.items[i].taxvalue)*parseFloat(a.items[i].quantity)*parseFloat(a.items[i].rebate))).toFixed(2)).appendTo($(tr));
						$(document.createElement('td')).html("<a class='btn btn-danger btn-xs jq_deleteOrderItemButton'>X</a>").appendTo($(tr));
						
						totalvalue = totalvalue + Math.round(parseFloat(a.items[i].price)*parseFloat(a.items[i].taxvalue)*parseFloat(a.items[i].quantity)*parseFloat(a.items[i].rebate));
						$('.jq_documentTotalValue').html(totalvalue.toFixed(2)+" DIN");
						$(tr).appendTo($('.jq_documentItemsModalTbody'));
					}
					
					$('#jq_documentItemsModalCont').attr('invoker',$($this).attr('id')).modal('show');	
				},
				error : function(){}
			});
		})
		

	
	$('#listtable tbody').on('click', '.deleteButton', function () {
      	var $this = $(this);
		var a = confirm("Da li ste sigurni da zelite da obisete dokument?");
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
    }).on('click', '.changeViewButton', function () {
      	window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
    }).on('change', '.selectStatus', function () {
			showLoadingIcon();
			changestatus_handler($(this));
			maintable.ajax.reload();
		});
	

	$("#addButton").on("click", function(){
		window.location.href = window.location.pathname+'/add';
	});
	
	$("#listButton").on("click", function(){
		window.location.href = 'order';
	});
	
	if($(".content-wrapper").attr('currentview') == 'change'){
		createAddChangeForm();	
		
		$(".saveAddChange").on('click', function(){
			showLoadingIcon();
			saveAddChange();
		});
		
		$(".addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
	}
	
	if($(".content-wrapper").attr('currentview') == 'add'){
		createAddChangeForm();	
		
		$(".saveAddChange").on('click', function(){
			showLoadingIcon();
			saveAddChange();
		});
	}

	
	$(".documentPath").on("blur change", function(){
		verifypath($(this));
	});
	$(".documentImage").on("blur change", function(){
		verifypath($(this));
	});
	

	
	$(document).on('click', ".jq_orderItemProductSaveButton", function(){
		$this = $(this);
		$(this).find('.jq_saveSppiner').removeClass('hide');
		updateOrderAmount($(this).parents('tr'));
	});
	
	$(document).on('click', '.jq_orderItemProductDeleteButton', function(){
		if(confirm('Da li ste sigurni?')){
			deleteOrderItem($(this).parents('tr'));
		}
	});
	
	
	/*	ADD ITEM IN ORDER START	*/
		
	$(document).on('click', '.documentNewItemInputCodeButton', function(){
		$.ajax({
			method: "POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: { action: "getorderB2Cproduct", 
					code: $('.documentNewItemInputCodeHolder').val(),
					docid: $(".content-wrapper").attr('currentid') },
			success : function(data){
				var a = JSON.parse(data);
				$('.documentNewItemInputName').html(a['name']);
				$('.documentNewItemInputRebate').html(a['rebate']+"%");
				
				var price = parseFloat(a['price'])*(1-(parseFloat(a['rebate'])*0.01))*(1+(parseFloat(a['tax'])*0.01));
				
				$('.documentNewItemPrice').html(round2Fixed(price));
				$('.documentNewItemInputCodeHolder').attr('prodid', a['productid']);
				$('.documentNewItemSelectNewColor').html('');
				$(document.createElement('option')).val('').html('---').appendTo($('.documentNewItemSelectNewColor'))
				for(var i = 0; i < a['color'].length; i++){
					var option = $(document.createElement('option'));
					$(option).val(a['color'][i]).html(a['color'][i]).appendTo($('.documentNewItemSelectNewColor'));	
				}
				
			},
			error : function(){}
		});
	});
	
		
	$(document).on('change', '.documentNewItemSelectNewColor', function(){
		$.ajax({
			method: "POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: { action: "getorderB2Cproductsizes", productid: $('.documentNewItemInputCodeHolder').attr('prodid'), color: $('.documentNewItemSelectNewColor').val()},
			success : function(data){
				var a = JSON.parse(data);
				$('.documentNewItemInputName').html(a['name']);
				
				$('.documentNewItemSelectNewSize').html('');
				$(document.createElement('option')).val('').html(' --- ').appendTo($('.documentNewItemSelectNewSize'));
				for(var i = 0; i < a.length; i++){
					var option = $(document.createElement('option'));
					$(option).val(a[i]).html(a[i]).appendTo($('.documentNewItemSelectNewSize'));
				}
				
			},
			error : function(){}
		});
	});
	
	
	$('.jq_addNewItemToOrder').on('click', function(){
		if($('.documentNewItemInputCodeHolder').val() != '' && 
			$('.documentNewItemSelectNewColor').val() != '' && 
			$('.documentNewItemSelectNewSize').val() != '' &&
			$('.documentNewItemInputAmount').val() > 0)
		{	
			$.ajax({
				method: "POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: { action: "addNewItemToOrder", 
						productid: $('.documentNewItemInputCodeHolder').attr('prodid'), 
						code: $('.documentNewItemInputCodeHolder').val(), 
						color: $('.documentNewItemSelectNewColor').val(),
						size: $('.documentNewItemSelectNewSize').val(),
						amount: $('.documentNewItemInputAmount').val(),
						docid: $(".content-wrapper").attr('currentid')
					 },
				success : function(data){
					var a = JSON.parse(data);
					if(a[0] == 1){
						document.location.reload();	
					}else{
						alert('Greska prilikom dodavanja proizvoda!');	
					}
					/*
					$('.documentNewItemInputName').html('');
					$('.documentNewItemInputCodeHolder').val('');
					
					$('.documentNewItemSelectNewColor').html('');
					$(document.createElement('option')).val('').html('---').appendTo($('.documentNewItemSelectNewColor'));
					
					$('.documentNewItemSelectNewSize').html('');
					$(document.createElement('option')).val('').html(' --- ').appendTo($('.documentNewItemSelectNewSize'));
					$('#'+$('#jq_documentItemsModalCont').attr('invoker')).trigger('click');
					*/
				},
				error : function(){}
			});
		}else{
			alert('Sva polja su obavezna!');	
		}
	});

	
	/*	ADD ITEM IN ORDER END	*/
	
	
	/*	ORDER FINISH START	*/
		
	$('.jq_acceptOrderButton').on("click", function(){
		if(confirm('Da li ste sigurni?'))
		{
			acceptorder();
		}
	});
	
	$('.jq_declineOrderButton').on("click", function(){
		if(confirm('Da li ste sigurni?'))
		{
			declineorder();
		}
	});
	
	/*	ORDER FINISH END	*/
	
	/*	PRINT BUTTON START	*/
	$(".jq_printOrderB2CButton").on('click', function(){
		var data = [];
		data['name'] = $(".jq_modalName").val();
		data['surname'] = $(".jq_modalSurname").val();
		data['address'] = $(".jq_modalAddress").val();
		data['city'] = $(".jq_modalCity").val();
		data['zip'] = $(".jq_modalZip").val();
		data['phone'] = $(".jq_modalPhone").val();
		data['email'] = $(".jq_modalEmail").val();
		data['payment'] = $(".jq_modalPayment").val();
		
		window.open("modules/"+moduleName+"/library/print.php?docid="+$('.content-wrapper').attr('currentid'), '', 'left=0,top=0,width=1200,height=800,toolbar=0,scrollbars=0,status =0,');	
	});
	
	/*	PRINT BUTTON END	*/
	
	/*	bank b2c	*/
	
	$(".bankcommand").on("click", function(){
		var a = confirm("Potvrdite akciju!");
		if(a)
		{
			bankcommand($(this));
		}
	});	
	
	/*	prodavnica data	*/
	
	$(document).on("click", '.jq_itemProdavnicaButton', function(){
		$this = $(this);
 		$.ajax({
			method: "POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: { action: "getprodavnicadata", 
					productid: $(this).attr('productid'), 
					boja: $(this).attr('boja'), 
					velicina: $(this).attr('velicina')
				},
			success : function(data){
				var a = JSON.parse(data);
				
				$('.jq_prodavnicaModalAttrHolder').html($($this).parent().parent().find('.jq_orderItemProductAttr').html());
				$('.prodavnicaTableTbody').html('');
				for(var i=0; i < a.length; i++)
				{
					var tr = $(document.createElement('tr'));
					var showname = a[i]['showname'];
					if(a[i]['showname'] == '') showname = "Magacin";
					var td = $(document.createElement('td')).addClass('shopname').addClass('shopname_color_'+(i%2)).html(showname);
					$(td).appendTo($(tr));
					
					var bckcolor = '';
					if(a[i]['amount'] == '0') bckcolor = 'red';
					var td = $(document.createElement('td')).addClass('field').css('background-color', bckcolor).html(a[i]['amount']);
					$(td).appendTo($(tr));
					
					$(tr).appendTo($('.prodavnicaTableTbody'));
				}
				$('#prodavnicaAmountModal').modal('show');
			},
			error : function(){}
		});
	});
	
	/*	search filter	*/
	
	$('.jq_statusSelect').on('change', function(){
		localStorage.setItem('Datetable_fiter_status', $('.jq_statusSelect').val());
		maintable.ajax.reload();
	});
	$('.jq_paymentSelect').on('change', function(){
		localStorage.setItem('Datetable_fiter_payment', $('.jq_paymentSelect').val());
		maintable.ajax.reload();
	});
	
	$('.jq_countrySelect').on('change', function(){
		localStorage.setItem('Datetable_fiter_country', $('.jq_countrySelect').val());
		maintable.ajax.reload();
	});
	
	$('.jq_typeSelect').on('change', function(){
		localStorage.setItem('Datetable_fiter_type', $('.jq_typeSelect').val());
		maintable.ajax.reload();
	});
	
	/*	ADD/UPDATE INTERNAL COMMENT	*/
	$('.jq_orderInternalcommentButton').on('click', function(){
		$.ajax({
			method: "POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: { action: "addinternalcomment", orderid: $('.content-wrapper').attr('currentid'), value: $('.jq_orderInternalcomment').val()},
			success : function(data){
				if(data == 1){
					alert('Greška prilikom snimanja!');
				}
			},
			error : function(){}
		});	
	});
	
});