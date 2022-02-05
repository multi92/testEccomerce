$(document).ready(function(e) {
	
	$('.brendselect2').select2();
	
	$(document).keydown(function (e) {
	  if ( !e.metaKey && e.altKey ) {
		e.preventDefault();
	  }
	  	/*	search	*/
		if(e.altKey && e.keyCode == 70 ) { 
			$('.serachProductInput').focus();
		}
		
		/*		*/
		if(e.altKey && e.keyCode == 78 ) { 
			$('.serachProductInput').blur();
			if($('.newProductCont').css('display') != 'block'){
				$('#toggleNewProduct').trigger('click');
			}
			$('.newProductCode').focus();
		}
		
		if(e.altKey && e.keyCode == 83 ) {
			if(!$('.productDataCont').hasClass('hide')){
				$('.saveProductButton').trigger('click');	
			}
		}
		
		if(e.keyCode == 13 && $('.serachProductInput').is(":focus")) {
			$('.searchProductButton').trigger('click');	
		}
	});
	
	
	$('input').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue',
		increaseArea: '20%' // optional
	  });

	$( "#sortable" ).sortable({
		placeholder: "ui-state-highlight",
		stop: function( event, ui ) {
			var data = [];
			$("#image_preview").children("ul").find("li").each(function(){
				data.push($(this).attr('imageid'))	
			});
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "updateimagesort",
						items: data,
						proid: $(".productDataCont").attr("productid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					//var a = JSON.parse(response);	
				}
			});		
			
		}
	});
    $( "#sortable" ).disableSelection();
		
	/*	add new extradetail */
	
	$(".addExtraDetailButton").on("click", function(){
		if($(".nameExtraDetail").val() != "")
		{
			var datahold = {};
			datahold['name'] = $(".nameExtraDetail").val();
			datahold['image'] = $(".imageExtraDetail").val();
			datahold['status'] = $(".statusExtraDetail").val();
			datahold['showinwelcomepage'] = $(".showInWelcomepageExtraDetail").val();
			datahold['showinwebshop'] = $(".showInWebShopExtraDetail").val();
			datahold['banerid'] = $(".banerExtraDetail").val();
			
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addChangeExtradetail",
						id: "",
						data: datahold
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					console.log(a[0]);
					if(a[0] == 0){
						alert("Uspesno dodato");
						document.location.reload();	
					}
					else{
						alert("Greska prilikom dodavanja");
					}	
				}
			});	
		}
	});
	
	/*	toggle extra detail	*/
	
	$("#toggleExtraDetail").on("click", function(){
		$(".relationsCont").slideUp();
		$(".newProductCont").slideUp();
		$(".importProductsCont").slideUp();
		$(".extraDetailCont").slideToggle(function(){
			clearExtraDetailForm();	
		});
	});
	$("#toggleRealtions").on("click", function(){
		$(".extraDetailCont").slideUp();
		$(".newProductCont").slideUp();
		$(".importProductsCont").slideUp();
		$(".relationsCont").slideToggle(function(){	
		});
	});
	$("#toggleNewProduct").on("click", function(){
		$(".extraDetailCont").slideUp();
		$(".relationsCont").slideUp();
		$(".importProductsCont").slideUp();
		$(".newProductCont").slideToggle(function(){	
		});
	});
	
	$("#toggleImportProducts").on("click", function(){
		$(".extraDetailCont").slideUp();
		$(".relationsCont").slideUp();
		$(".newProductCont").slideUp();	
		$(".importProductsCont").slideToggle(function(){	
		});
	});
	
	
	$(".deleteExtraDetailButton").on("click", function(){
		deleteExtraDetail_handler($(this));
	});
	
	
	/*	extra detail list handlers	*/
	
	$(".extraDetailListItem").on("click", function(){
		extraDetailListItem_handler($(this));	
	});
	
	/*	save extra detail	*/
	
	$(".saveExtraDetailButton").on("click", function(){
		var error = false;
		var data = [];
		if($(".extradetailNameCont").find(".extradetailNameHolder[defaultlang='y']").find(".nameExtraDetail").val() != '')
		{
			$(".extradetailNameCont").find(".extradetailNameHolder").each(function(){
				var obj = {'langid': $(this).attr('langid'),
							'default' : $(this).attr('defaultlang'),
							'name' : $(this).find(".nameExtraDetail").val(),
							'image' : $(this).find(".imageExtraDetail").val(),
							'status' : $(".statusExtraDetail").val(),
							'showinwelcomepage' : $(".showInWelcomepageExtraDetail").val(),
							'showinwebshop' : $(".showInWebShopExtraDetail").val(),
							'banerid' : $(".banerExtraDetail").val()
							};	
				data.push(obj);
			});
		}
		else{
			error = true;	
			alert("Unesite naziv");
			$(".extradetailNameCont").find(".extradetailNameHolder[defaultlang='y']").addClass('has-error');
		}
		console.log(data);
		
		if(!error){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addChangeExtradetail",
						id: $(".dataExtraDetail").attr("extradetaildataid"),
						data: data
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					console.log(a[0]);
					if(a[0] == 0){
						if($(".dataExtraDetail").attr("extradetaildataid") == ''){
							alert('Uspesno dodato');
							document.location.reload();	
						}else{
							alert("Uspesno izmenjeno");
						}
					}
					else{
						alert("Greska prilikom dodavanja");
					}	
				}
			});	
		}
	});
	
	$(".addExtradetailFormButton").on("click", function(){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "getlanguageslist"}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				
				$(".extradetailNameCont").html('');
				for(var i = 0; i < a.length; i++){
					$(".dataExtraDetail").attr("extradetaildataid", '');
					
					var clone = $(".extradetailNameHolderTemplate").clone(true).removeClass("extradetailNameHolderTemplate").removeClass('hide').addClass('extradetailNameHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
					$(clone).find('h4').html(a[i].name);	
					$(clone).find('.nameExtraDetail').val('');
					$(clone).find('.imageExtraDetail').val('');
					
					$(clone).appendTo($(".extradetailNameCont"));	
				}
				
				$(".saveExtraDetailButton").removeClass('hide');
				$(".statusExtraDetailCont").removeClass('hide');
				$(".showInWelcomepageExtraDetailCont").removeClass('hide');
				$(".showInWebShopExtraDetailCont").removeClass('hide');
				$(".banerExtraDetailCont").removeClass('hide');
			}
		});		
	});
	
	
	$(".newProductAddButton").on('click', function(){
		if($(".newProductCode").val() != '' && $(".newProductName").val() != ''){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addnewproduct",
						code: $(".newProductCode").val(),
						name: $(".newProductName").val()
					}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a > 0){
						alert('Dodat proizvod.');
						clearProductForm();
						$(".serachProductInput").val($(".newProductCode").val());
						$(".searchProductButton").trigger('click');
						$(".newProductCode").val('');
						$(".newProductName").val('');
						$(".newProductCont").slideUp();
					}
				}
			});		
		}
		else{
			alert('Sva polja su obavezna!');	
		}
	});
	
	/*	relations list handlers	*/
	
	$(".relationsListItem").on("click", function(){
		relationsListItem_handler($(this));	
	});
	
	/*	save extra detail	*/
	
	$(".saveRelationsButton").on("click", function(){
		var error = false;
		var data = [];
		if($(".relationsNameCont").find(".relationsNameHolder[defaultlang='y']").find(".nameRelations").val() != '')
		{
			$(".relationsNameCont").find(".relationsNameHolder").each(function(){
				var obj = {'langid': $(this).attr('langid'),
							'default' : $(this).attr('defaultlang'),
							'name' : $(this).find(".nameRelations").val(),
							'status' : $(".statusRelations").val()
							};	
				data.push(obj);
			});
		}
		else{
			error = true;	
			alert("Unesite naziv");
			$(".relationsNameCont").find(".relationsNameHolder[defaultlang='y']").addClass('has-error');
		}
		console.log(data);
		
		if(!error){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addChangeRelations",
						id: $(".dataRelations").attr("relationsdataid"),
						data: data
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					console.log(a[0]);
					if(a[0] == 0){
						if($(".dataRelations").attr("relationsdataid") == ''){
							alert('Uspesno dodato');
							document.location.reload();	
						}else{
							alert("Uspesno izmenjeno");
						}
					}
					else{
						alert("Greska prilikom dodavanja");
					}	
				}
			});	
		}
	});
	
	
	/*	import product file	*/
	
	/*	add product image	*/
		
		$("#jq_importFileForm").on("submit", function(e){
			
			e.preventDefault();
			if($(".jq_importFile").val() != "")
			{
				$.ajax({
					url:"modules/"+moduleName+"/library/import-products.php",
					type: "POST",           
					data: new FormData(this),
					contentType: false,      
					cache: false,            
					processData:false,    
					success: function(response)
					{
						if(response == 0){
							$('.jq_importFileSuccess').removeClass('hide');	
							$('.jq_importFileFail').addClass('hide');	
						}else{
							$('.jq_importFileFail').find('p').html(response);
							$('.jq_importFileSuccess').addClass('hide');	
							$('.jq_importFileFail').removeClass('hide');	
						}
						$('.jq_importFile').val('');
					}
				});
			}
			
		});
	

		var searcDT = $("#example1").not('.initialized').addClass('initialized').DataTable({
			stateSave: true,
			"processing": true,
			"serverSide": true,
			"ajax":{
					url :"modules/"+moduleName+"/library/getdata.php", // json datasource
					type: "post",  // method  , by default get
					"data"   : function( d ) {
						d.prosearch= $(".serachProductInput").val();
						d.imagey = ($('.jq_imageY').parent('[class*="icheckbox"]').hasClass("checked"))? 1:0;
						d.imagen = ($('.jq_imageN').parent('[class*="icheckbox"]').hasClass("checked"))? 1:0;
						d.activey = ($('.jq_activeY').parent('[class*="icheckbox"]').hasClass("checked"))? 1:0;
						d.activen = ($('.jq_activeN').parent('[class*="icheckbox"]').hasClass("checked"))? 1:0;
						d.type = $('.jq_typeSearchCont').val();
					}, 
					error: function(){  // error handling
						$(".employee-grid-error").html("");
						$("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
						$("#employee-grid_processing").css("display","none");
					},
					dataSrc: function(d){
						//console.log(d);
						
						for(var i = 0; i < d.aaData.length;i++)
						{
							var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
							var bd = '<button class="btn btn-danger deleteProductButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
							d.aaData[i][8] = bc + bd;
							
							var clone = $(".productcodeContTemplate").clone(true).removeClass('productcodeContTemplate').removeClass('hide').addClass('productcodeCont');
							$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
							d.aaData[i][7] = $(clone).prop('outerHTML');
							
							var num = '<div class="input-group"><input type="number" class="form-control sortProductInput" placeholder="sort" value="'+d.aaData[i][6]+'"><span class="input-group-addon"><i class="fa fa-sort-numeric-desc"></i></span></div>';
							d.aaData[i][6] = num;
							
							/*
							var sel = '<select class="form-control selectStatus background-'+d.aaData[i][5]+'" id="'+d.aaData[i][99]+'" currentStatus="'+d.aaData[i][5]+'">';
								sel += '<option value="v" '; if(d.aaData[i][5] == "v") sel +=  " selected "; sel += '>Vidljiva</option>';	
								sel += '<option value="h" '; if(d.aaData[i][5] == "h") sel +=  " selected "; sel += '>Sakrivena</option>';	
								sel += '<option value="a" '; if(d.aaData[i][5] == "a") sel +=  " selected "; sel += '>Arhivirano</option>';	
								sel += 	'</select>';
								
							d.aaData[i][5] = sel;		
							
							*/				
						}
						
						
						return d.aaData;
					}
				},
			"language": {
					"emptyTable":     "No data available in table",
					"info":           "Prikaz _START_ do _END_ od _TOTAL_ proizvoda",
					"infoEmpty":      "Prikaz 0 do 0 od 0 proizvoda",
					"infoFiltered":   "(filtrirano od _MAX_ proizvoda)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "Prikazi _MENU_ proizvoda",
					"loadingRecords": "Ucitavanje...",
					"processing":     "Obrada...",
					"search":         "Pretraga:",
					"zeroRecords":    "Nema rezultata za zadati kriterijum",
					"paginate": {
						"first":      "Prva",
						"last":       "Zadnja",
						"next":       "Sledeca",
						"previous":   "Predhodna"
					}
				}
			});	
		$(".searchProductButton").on("click", function(){
			$(".productDataCont").addClass("hide");			
			if($('#example1').hasClass('initialized'))
			{
				searcDT.ajax.reload()
			}
		});
		
		/*	delete product button	*/
		
		$(document).on("click", ".deleteProductButton", function(){
			if(confirm("Potvrdi brisanje proizvoda!"))
			{
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteProduct",
							proid: $($this).attr("id")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						if(response == 0){
							$($this).parents('tr').remove();
						}else{
							alert('Greska prilikom brisanja!');	
						}
					}
				});
			}
		});
		
		
		/*	get product data	*/
		
		$(document).on("click", ".changeViewButton", function(){
			clearProductForm();
			var $this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "getproduct",
						id: $($this).attr("id")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					
					var d = JSON.parse(response);
					console.log(d);
					$(".productDataCont").attr("productid", d.id);
					
					$("#proidimage").val(d.id);
					
					/*	product base data	*/
					
					if(d.active == 'y') { $(".productActive").iCheck('check'); }
					else{ $(".productActive").iCheck('uncheck'); }
					if(d.extendwarrnity == 1) { $(".productExtendWarrnity").iCheck('check'); }
					else{ $(".productExtendWarrnity").iCheck('uncheck'); }
					$(".productCode").val(d.code);
					$(".productbarcode").val(d.barcode);
					$(".productManufcode").val(d.manufcode);
					//$(".productUnitName").val(d.unitname);
					$(".productTax").val(d.taxid);
					$(".productType").val(d.type);

					$(".productPriceB2C").val(d.priceb2c);
					$(".productPriceB2CWithVat").val(d.priceb2cwithvat);
					$(".productPriceB2B").val(d.priceb2b);
					$(".productPriceB2BWithVat").val(d.priceb2bwithvat);
					
					$(".productRebate").val(d.rebate);
					$(".productQuantity").val(d.quantity);
					$(".productUnitStep").val(d.unitstep);
					if(d.productlink.length>0){
						$(".showProductButton").attr("href", d.productlink).removeClass('hide');
					}
					
					$('.productBrend').val(d.brendid).trigger('change');
					
					$(".productNameCont").html('');
					$(".productUnitNameCont").html('');
					$(".productSearchwordsCont").html('');
					$(".productUnitNameCont").html('');
					$(".productManufnameCont").html('');
					$(".productCharacteristicsCont").html('');
					$(".productDescriptionCont").html('');
					$(".productModelCont").html('');
					$(".productSpecificationCont").html('');
					
					$(".jq_BarometarDateInput").datepicker({ format: "dd.mm.yyyy"});
					
					for(var i = 0; i < (d.lang).length; i++){
						var clone = $('.productNameHolderTemplate').clone(true).removeClass('productNameHolderTemplate').removeClass('hide').addClass('productNameHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productName').val(d.lang[i].name);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productNameCont"));
						
						var clone = $('.productUnitNameHolderTemplate').clone(true).removeClass('productUnitNameHolderTemplate').removeClass('hide').addClass('productUnitNameHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productUnitName').val(d.lang[i].unitname);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productUnitNameCont"));

						var clone = $('.productManufnameHolderTemplate').clone(true).removeClass('productManufnameHolderTemplate').removeClass('hide').addClass('productManufnameHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productManufname').val(d.lang[i].manufname);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productManufnameCont"));
						
						var clone = $('.productSearchwordsHolderTemplate').clone(true).removeClass('productSearchwordsHolderTemplate').removeClass('hide').addClass('productSearchwordsHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productSearchwords').val(d.lang[i].searchwords);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productSearchwordsCont"));

						var clone = $('.productCharacteristicsHolderTemplate').clone(true).removeClass('productCharacteristicsHolderTemplate').removeClass('hide').addClass('productCharacteristicsHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productCharacteristics').val(d.lang[i].characteristics);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productCharacteristicsCont"));
						
						var clone = $('.productDescriptionHolderTemplate').clone(true).removeClass('productDescriptionHolderTemplate').removeClass('hide').addClass('productDescriptionHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productDescription').val(d.lang[i].description);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productDescriptionCont"));
						
						var clone = $('.productModelHolderTemplate').clone(true).removeClass('productModelHolderTemplate').removeClass('hide').addClass('productModelHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productModel').val(d.lang[i].model);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productModelCont"));
						
						var clone = $('.productSpecificationHolderTemplate').clone(true).removeClass('productSpecificationHolderTemplate').removeClass('hide').addClass('productSpecificationHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default);
						$(clone).find('.productSpecification').val(d.lang[i].specification);
						$(document.createElement('label')).html(d.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productSpecificationCont"));
						
					}
					
					
					var content = $('.productCharacteristics');
					var contentPar = content.parent()
					contentPar.find('.wysihtml5-toolbar').remove()
					contentPar.find('iframe').remove()
					contentPar.find('input[name*="wysihtml5"]').remove()
					content.show()
					
					var content = $('.productDescription');
					var contentPar = content.parent()
					contentPar.find('.wysihtml5-toolbar').remove()
					contentPar.find('iframe').remove()
					contentPar.find('input[name*="wysihtml5"]').remove()
					content.show()
					
					var content = $('.productModel');
					var contentPar = content.parent()
					contentPar.find('.wysihtml5-toolbar').remove()
					contentPar.find('iframe').remove()
					contentPar.find('input[name*="wysihtml5"]').remove()
					content.show()
					
					var content = $('.productSpecification');
					var contentPar = content.parent()
					contentPar.find('.wysihtml5-toolbar').remove()
					contentPar.find('iframe').remove()
					contentPar.find('input[name*="wysihtml5"]').remove()
					content.show()

					
					$(".productCharacteristics").wysihtml5({});
					$(".productDescription").wysihtml5({});
					$(".productModel").wysihtml5({});
					$(".productSpecification").wysihtml5({});
					
					
					/*	product extra detail	*/
					
					for(var ed in d.extradetail)
					{
						if(d.extradetail[ed][2] != null) { $("."+d.extradetail[ed][0]+"_productExtraDetailItem").iCheck('check'); }
						else{ $("."+d.extradetail[ed][0]+"_productExtraDetailItem").iCheck('uncheck'); }
		
					}
					
					/*	product category	*/
					
					$('.categorySelectHolder').not(':first').remove();
					$(".categorySelectHolder").first().find(".productcategorycont").val(d.categoryid[0]);
					for(var k = 1; k < (d.categoryid).length; k++){
						var clone = $(".categorySelectHolder").first().clone(true);	
						$(clone).find(".productcategorycont").val(d.categoryid[k]);
						$(clone).insertAfter($(".categorySelectHolder").last());
					}
					
					/*	product images	*/ 
					
					if(d.images[0] != null)
					{
						for(var img in d.images){
							var li = $(document.createElement("li")).addClass("list-group-item").attr('imageid', d.images[img].id);
							$(document.createElement("img")).attr("src", d.images[img].thumb+"?"+new Date().getTime()).attr("data-featherlight", d.images[img].big+"?"+new Date().getTime()).addClass("img-responsive").addClass("verticalMargin10").appendTo($(li));
							$(document.createElement("button")).addClass("btn").addClass("btn-warning").addClass("btn-xs").addClass("attrProductImageButton").attr('attrvalid',d.images[img].attrvalid ).attr('attrid',d.images[img].attrid ).html("attr").appendTo($(li));	
							$(document.createElement("button")).addClass("btn").addClass("btn-danger").addClass("btn-xs").addClass("deleteProductImageButton").html("X").appendTo($(li));
							$(li).appendTo($("#image_preview").children("ul"));
						}
					}
					
					/*	product relations	*/
					
					$(".navTabsCont").html('');
					$(".relationsTabCont").html('');
					
					for (var j = 0; j < (d.relations).length; j++){
						var act = '';
						if(j == 0) act = 'active';
						
						var clone = $(".relationsTabHolderTemplate").clone(true).removeClass('relationsTabHolderTemplate').removeClass('hide').addClass('relationsTabHolder').attr('relationsid', d.relations[j].id);
						$(clone).attr('id', 'itm'+d.relations[j].id).addClass(act);
						var clonenav = $('.navTabsItemTemplate').clone(true).removeClass('navTabsItemTemplate').removeClass('hide').addClass('navTabsItem').addClass(act);
						$(clonenav).find('a').attr('href','#itm'+d.relations[j].id).html(d.relations[j].name);
						$(clonenav).appendTo($(".navTabsCont"));
						
						for (var k = 0; k < (d.relations[j].data).length; k++){
							var cloneitem = $(".relationsTabItemTemplate").clone(true).removeClass('relationsTabItemTemplate').removeClass('hide').addClass('relationsTabItem').attr('relatedproid', d.relations[j].data[k].relatedid);
							$(cloneitem).find('.relationsProductName').html(d.relations[j].data[k].name);
							$(cloneitem).find('.relationsProductCode').html(d.relations[j].data[k].code);
							$(cloneitem).appendTo($(clone).find(".relationsTabItemCont"));
						}
						$(clone).appendTo($(".relationsTabCont"));
					}
					
					
					/* product download	*/
					for (var prop in d.detail) {
						if(prop != "img" && d.detail[prop].length > 0)
						{
							for(var j = 0; j < d.detail[prop].length; j++ )
							{
								var clone = $(".productDownloadItemTemplate").clone(true);
								
								$(clone).attr("prodownloadid",d.detail[prop][j][3] );
								
								if(prop == "doc"){
									$(clone).children('td').eq(0).html("Dokument");
								
									var file = d.detail[prop][j][0].split("/");
									$(clone).children('td').eq(1).html("<a href='../"+d.detail[prop][j][0]+"'>"+file[file.length-1]+"</a>");
									
									var img = "";
									if(d.detail[prop][j][1] != "")
									img = $(document.createElement("img")).attr("height", "50").attr("src", "../"+d.detail[prop][j][1]).attr("data-featherlight", "../"+d.detail[prop][j][1]);
									$(clone).children('td').eq(2).html(img);
								}
								
								if(prop == "yt"){
									$(clone).children('td').eq(0).html("Youtube");
								
									$(clone).children('td').eq(1).html('<iframe height="150" src="'+d.detail[prop][j][0]+'" frameborder="0" allowfullscreen></iframe>');
									$(clone).children('td').eq(2).html("");		
								}
								
								if(prop == "ext"){
									$(clone).children('td').eq(0).html("Externi");

									$(clone).children('td').eq(1).html("<a target='_blank' href='../"+d.detail[prop][j][0]+"'>"+d.detail[prop][j][0]+"</a>");
									$(clone).children('td').eq(2).html("");		
								}
								
								$(clone).removeClass("hide").removeClass("productDownloadItemTemplate").appendTo(".productDownloadItemCont");			
							}
							
						}
					}
					
					/*	product atributes	*/
					
					if(d.atributes.length > 0)
						{
						$(".attrProdCont").html("");
						
						/*	image modal	*/
						$(".imgAttrModalSelect").html("");
						var option = $(document.createElement("option"));
						$(option).clone(true).attr("value", "").appendTo($(".imgAttrModalSelect"));
						
						for(var at in d.atributes){
							
							$(option).clone(true).attr("value", d.atributes[at][0]).html(d.atributes[at][1]).appendTo($(".imgAttrModalSelect"));
							
							var col = $(document.createElement("div")).addClass("col-sm-2");
							$(document.createElement("h3")).html(d.atributes[at][1]).appendTo($(col));
							for(var atval in d.atributes[at][2])
							{
								var div = $(document.createElement("div"));
								var ch = false;
								if(d.atributes[at][2][atval][2] != null && d.atributes[at][2][atval][2] != "" ){
									ch = true;	
								}
								$(document.createElement("input")).addClass("attrprodval").attr("type", "checkbox").attr("checked", ch).val(d.atributes[at][2][atval][0]).appendTo($(div))
								$(document.createElement("span")).html(d.atributes[at][2][atval][1]).appendTo($(div));
								$(div).appendTo($(col));
							}
							
							$(col).appendTo($(".attrProdCont"));
						}
					}
					
					/*	QUANTITY REBATE	*/
						
					$('.jq_productQuantityRebateCont').find('tbody').html('');	
						
					for(var i = 0; i < (d.qtyrebate).length; i++){
						var clone = $(".jq_productQuantityRebateTemplate").clone(true).removeClass('hide').removeClass('jq_productQuantityRebateTemplate').attr('itemid', d.qtyrebate[i]['id']);
						$(clone).find('.jq_productQuantityHolder').html(d.qtyrebate[i]['quantity']);
						$(clone).find('.jq_productRebateHolder').html(d.qtyrebate[i]['rebate']);
						$(clone).find('.jq_productStatusHolder').val(d.qtyrebate[i]['status']);
						
						$(clone).appendTo($('.jq_productQuantityRebateCont').find('tbody'));
					}
					
					
					/*	BAROMETAR	*/
						
					$('.jq_productBarometarCont').find('tbody').html('');	
						
					/*for(var i = 0; i < (d.barometar).length; i++){
						var clone = $(".jq_productBarometarTemplate").clone(true).removeClass('hide').removeClass('jq_productBarometarTemplate').attr('itemid', d.barometar[i]['id']);
						$(clone).find('.jq_productBarometarMinHolder').html(d.barometar[i]['min']);
						$(clone).find('.jq_productBarometarMaxHolder').html(d.barometar[i]['max']);
						$(clone).find('.jq_productBarometarObjectHolder').html(d.barometar[i]['name']);
						
						$(clone).appendTo($('.jq_productBarometarCont').find('tbody'));
					}
					*/
					
					$(".productDataCont").removeClass("hide");		
				}
			});	
		})
		
		/*	add new product download 	*/
		
		$(".addProductDownload").on("click", function(){
			if($(".newProductDownloadContent").val() != "")
			{
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addnewprodownload",
							type: $(".newProductDownloadType").val(),
							proid: $(".productDataCont").attr("productid"),
							cont: $(".newProductDownloadContent").val(),
							contimg: $(".newProductDownloadContentimg").val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						console.log(response);
						var a = JSON.parse(response);
						if(a[0] == 0){
							
							var prop = $(".newProductDownloadType").val();
							var clone = $(".productDownloadItemTemplate").clone(true);
							
							$(clone).attr("prodownloadid",a[1] );
							
							if(prop == "doc"){
								$(clone).children('td').eq(0).html("Dokument");
							
								var file = $(".newProductDownloadContent").val().split("/");
								$(clone).children('td').eq(1).html("<a href='../"+$(".newProductDownloadContent").val()+"'>"+file[file.length-1]+"</a>");
								
								var img = "";
								if($(".newProductDownloadContentimg").val() != "")
								img = $(document.createElement("img")).attr("height", "50").attr("src", "../"+$(".newProductDownloadContentimg").val()).attr("data-featherlight", "../"+$(".newProductDownloadContentimg").val());
								$(clone).children('td').eq(2).html(img);
							}
							
							if(prop == "yt"){
								$(clone).children('td').eq(0).html("Youtube");
							
								$(clone).children('td').eq(1).html('<iframe height="150" src="'+$(".newProductDownloadContent").val()+'" frameborder="0" allowfullscreen></iframe>');
								$(clone).children('td').eq(2).html("");		
							}
							
							if(prop == "ext"){
								$(clone).children('td').eq(0).html("Externi");
	
								$(clone).children('td').eq(1).html("<a target='_blank' href='"+$(".newProductDownloadContent").val()+"'>"+$(".newProductDownloadContent").val()+"</a>");
								$(clone).children('td').eq(2).html("");		
							}
							
							$(clone).removeClass("hide").removeClass("productDownloadItemTemplate").appendTo(".productDownloadItemCont");	
							
							$(".newProductDownloadContent").val("");
							$(".newProductDownloadContentimg").val("");
						}
						else{
							alert("Greska prilikom dodavanja");
						}	
					}
				});		
			}
		});
		
		/*	delete product download */
		
		$(document).on("click", ".deleteProductDownload", function(){
			var a = confirm("Da li sigurno zelite da obrisete stavku?");
			if(a){
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteprodownload",
							id: $(this).parent().parent().attr("prodownloadid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							$($this).parent().parent().remove();
						}
						
					}
				});
						
			}
		});	
		
		$(".productcategorycont").on("focus", function(){
			$(this).attr('currentCat', $(this).val());
		});
		
		/*	change category */
		
		$(".productcategorycont").on("change", function(){
			var $this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "updatecategory",
						proid: $(".productDataCont").attr("productid"),
						catid: $(this).val(),
						prevcatid : $(this).attr('currentCat')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						if($($this).val() == 0){
							if($(".categorySelectHolder").length > 1){ $($this).parent().remove();	}
							else{
								$($this).val('0');	
							}
						}else{
							alert("Sacuvano.");
						}
					}
					else{
						alert('Greska.');	
					}
					
				}
			});	
		});
		
		/*	add product image	*/
		
		$("#uploadimage").on("submit", function(e){
			
			e.preventDefault();
			if($("#proidimage").val() != "")
			{
				$.ajax({
					url:"modules/"+moduleName+"/library/upload-product-image.php",
					type: "POST",           
					data: new FormData(this),
					contentType: false,      
					cache: false,            
					processData:false,    
					success: function(response)
					{
						var a = JSON.parse(response);
						if(a[0] == 0){
							var li = $(document.createElement("li")).addClass("list-group-item").attr('imageid', a[3]);
							$(document.createElement("img")).attr("src", a[1]+"?"+new Date().getTime()).attr("data-featherlight", a[2]+"?"+new Date().getTime()).addClass("img-responsive").addClass("verticalMargin10").appendTo($(li));
							$(document.createElement("buttom")).addClass("btn").addClass("btn-danger").addClass("btn-xs").addClass("deleteProductImageButton").html("X").appendTo($(li));	
							$(li).appendTo($("#image_preview").children("ul"));
							
							$("#file").val("");
						}
					}
				});
			}
			
		});
		
		$(document).on("click", ".deleteProductImageButton", function(){
			if(confirm("Obrisati sliku?"))
			{
				$this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteimage",
							id: $($this).parents('.list-group-item').attr('imageid')
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						//var a = JSON.parse(response);
						$($this).parent().remove();
					}
				});	
			}
		});
		
		/*	image modal	*/
		$(document).on("click", ".attrProductImageButton", function(){
			
			$("#imgAttrModal").attr("imageid", $(this).parents("li").attr("imageid")).modal();
			var attrid = $(this).attr('attrid');
			if (typeof attrid !== typeof undefined && attrid !== false) {
				$(".imgAttrModalSelect").val(attrid);
				$(".imgAttrModalSelect").attr('attrvalid',  $(this).attr('attrvalid')).trigger('change');
			}else{
				$(".imgAttrModalSelect").val('');
				$(".imgAttrValueModalSelect").hide();	
			}
			
		});
		
		$(".imgAttrModalSelect").on("change", function(){
			$(".imgAttrValueModalSelect").html("").hide();	
						
			if($(this).val() != ""){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "getattrvalues",
							attrid: $(this).val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						
						var option = $(document.createElement("option"));
						
						for(var i = 0; i < a.length; i++)
						{
							$(option).clone(true).attr("value", a[i]['attrvalid']).val(a[i]['id']).html(a[i]['value']).appendTo($(".imgAttrValueModalSelect"));	
						}
						
						var attrvalid = $(".imgAttrValueModalSelect").parents(".modal-body").find('.imgAttrModalSelect').attr('attrvalid');
						if (typeof attrvalid !== typeof undefined && attrvalid !== false) {
							//alert(attrid)
							$(".imgAttrValueModalSelect").val(attrvalid);
						}
						
						$(".imgAttrValueModalSelect").show();
					}
				});
			}		
		});
		
		$(".saveImgAttrValueButton").on("click", function(){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "saveimgattrvalue",
						attrvalid: $(".imgAttrValueModalSelect").val(),
						imageid : $("#imgAttrModal").attr("imageid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					$("#imgAttrModal").modal("hide");
					$(".imgAttrValueModalSelect").html("").hide();	
					$(".imgAttrModalSelect").val("");
				}
			});	
		});
		
		$(".saveProductButton").on("click", function(){
			
			var error = false;
			if($('.productUnitStep').val() <= 0 || $('.productUnitStep').val() == null){
				$('.productUnitStep').parent().addClass('has-error');	
				error = true;
				$(".productUnitStep").get(0).scrollIntoView();
			}else{
				$('.productUnitStep').parent().removeClass('has-error');	
			}
			if($('.productTax').val() == '' || $('.productTax').val() == null){
				$('.productTax').parent().addClass('has-error');	
				error = true;
				$(".productTax").get(0).scrollIntoView();
			}else{
				$('.productTax').parent().removeClass('has-error');	
			}
			
			$(".productNameCont").find(".productNameHolder").each(function(){
				if($(".productUnitNameHolder[langid='"+$(this).attr('langid')+"']").find(".productUnitName").val() == ''){
					$(".productUnitNameHolder[langid='"+$(this).attr('langid')+"']").find(".productUnitName").parent().addClass('has-error');	
					error = true;
					$(this).get(0).scrollIntoView();
				}else{
					$(this).parent().removeClass('has-error');	
				}
			});	
			
			if(!error)
			{
				var data = {};
				data['lang'] = [];
				$(".productNameCont").find(".productNameHolder").each(function(){
					var obj = {'langid': $(this).attr('langid'),
								'default' : $(this).attr('defaultlang'),
								'name' : $(this).find(".productName").val(),
								'manufname' : $(".productManufnameHolder[langid='"+$(this).attr('langid')+"']").find(".productManufname").val(),
								'unitname' : $(".productUnitNameHolder[langid='"+$(this).attr('langid')+"']").find(".productUnitName").val(),
								'searchwords' : $(".productSearchwordsHolder[langid='"+$(this).attr('langid')+"']").find(".productSearchwords").val(),
								'characteristics' : $(".productCharacteristicsHolder[langid='"+$(this).attr('langid')+"']").find(".productCharacteristics").val(),
								'description' : $(".productDescriptionHolder[langid='"+$(this).attr('langid')+"']").find(".productDescription").val(),
								'model' : $(".productModelHolder[langid='"+$(this).attr('langid')+"']").find(".productModel").val(),
								'specification' : $(".productSpecificationHolder[langid='"+$(this).attr('langid')+"']").find(".productSpecification").val()
								};	
					data['lang'].push(obj);	
				});
				
				
				data['id'] = $(".productDataCont").attr("productid"); 	
				data['active'] = ($('.productActive').iCheck('update')[0].checked)? 'y':'n';
				data['extendwarrnity'] = ($('.productExtendWarrnity').iCheck('update')[0].checked)? 1:0;
				data['code'] = $(".productCode").val();
				data['barcode'] = $(".productbarcode").val();
				data['manufcode'] = $(".productManufcode").val();
				data['brendid'] = $(".productBrend").val();
				data['unitstep'] = $(".productUnitStep").val();
				
				data['taxid'] = $(".productTax").val();
				data['type'] = $(".productType").val();
				
				data['priceb2c'] = $(".productPriceB2C").val();
				data['priceb2b'] = $(".productPriceB2B").val();
				data['quantity'] = $(".productQuantity").val();
				data['rebate'] = $(".productRebate").val();
				
				$.ajax({
							type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "updateProduct",
							data: data
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							alert("Sacuvano");
						}
						
					}
				});
			}else{
				alert("Popunite obavezna polja!");	
			}
		});
		
		
		/* extra detail change	*/
		
		$("div[class$='_productExtraDetailItem']").each(function(){
			var edid = ($(this).attr("class").replace("col-sm-2 ","")).split("_");
			
			$this = $(this);
			$(this).on('ifClicked', function(event){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "updateProductExtraDetail",
							proid: $(".productDataCont").attr("productid"),
							edid: edid[0],
							status: ($(this).find('.icheckbox_minimal-blue').hasClass("checked"))? 0:1
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						
					}
				});	
			});
			
		});
	
	
	/*	add replacment product	*/
	/*
	$(".addProReplacmentButton").on("click", function(){
		if($(".replaceProCode").val() != "")		
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addreplacment",
						code: $(".replaceProCode").val(),
						id : $(".productDataCont").attr("productid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						
						var li = $(document.createElement("li")).addClass('list-group-item').attr('replaceid', a[1][0][0]);

						$(document.createElement("a")).addClass('btn').addClass('btn-danger').addClass('btn-xs').addClass('pull-right').addClass('deleteReplacment').html("X").appendTo($(li));
						
						$(document.createElement("h4")).addClass('pull-left').html(a[1][0][2]).appendTo($(li));
						$(document.createElement("div")).addClass('clearfix').appendTo($(li));
						
						$(document.createElement("p")).addClass('pull-left').html(a[1][0][1]).appendTo($(li));
						$(document.createElement("div")).addClass('clearfix').appendTo($(li));
						
						$(li).appendTo($(".replacmentCont"));
					}
				}
			});
		}
	});
	*/
	/*	delete replacment product	*/
/*	$(document).on("click", ".deleteReplacment", function(){
		if(confirm("Obrisati zamenski proizvod?"))
		{
			$this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deletereplacment",
						replaceid: $($this).parent().attr("replaceid"),
						proid: $(".productDataCont").attr("productid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						$($this).parent().remove();
					}
				}
			});	
		}		
	});*/
	
	$(document).on('click', '.addProRelationsButton', function(){
		$this = $(this);
		if($(this).parents('.relationsTabHolder').find('.relationsProCodeInput').val() != '')
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addrelations",
						code: $(this).parents('.relationsTabHolder').find('.relationsProCodeInput').val(),
						proid: $(".productDataCont").attr("productid"),
						relationid : $(this).parents('.relationsTabHolder').attr('relationsid')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						var cloneitem = $(".relationsTabItemTemplate").clone(true).removeClass('relationsTabItemTemplate').removeClass('hide').addClass('relationsTabItem').attr('relatedproid', a[1][0].id);
						$(cloneitem).find('.relationsProductName').html(a[1][0].name);
						$(cloneitem).find('.relationsProductCode').html(a[1][0].code);
						$(cloneitem).appendTo($($this).parents('.relationsTabHolder').find(".relationsTabItemCont"));
						$(this).parents('.relationsTabHolder').find('.relationsProCodeInput').val('');
					}
					else{
						alert('Proizvod sa sifrom '+ $(this).parents('.row').find('.relationsProCodeInput').val() +' je vec u relaciji ' + $('.navTabsItem.active').find('a').html());	
					}
				}
			});	
		}
	});
	
	$(document).on('click', '.relationsTabItemDeleteButton', function(){
		$this = $(this);
		if(confirm('Da li ste sigurni za zelite da obrisete?')){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deleteprodrelations",
						relatedid: $(this).parents('.relationsTabItem').attr('relatedproid'),
						proid: $(".productDataCont").attr("productid"),
						relationid : $(this).parents('.relationsTabHolder').attr('relationsid')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						$($this).parents('.relationsTabItem').remove();
					}
					else{
						alert('Greska prilikom brisanja.');	
					}
				}
			});		
		}
	});
	
	$(document).on('keypress change ', ".relationsProCodeInput", function(){
		if($(this).val() != '')
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "relationsGetProductByCode",
						code: $(this).val()
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					
				}
			});
		}
	});
	/*	relation search result close	*/
	
	$('.relationsCloseButton').on('click', function(){
		$(this).parent().slideUp();
	});
	
	/* update product attr value	*/
		
	$(document).on("click", ".attrprodval", function(){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "updateProductAttrValue",
					proid: $(".productDataCont").attr("productid"),
					attrvalid: $(this).val(),
					status: ($(this).is(":checked")) ? 1 : 0
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				
			}
		});
	});
	
	/*	add new category field	*/
	
	$(".addCategoryFieldButton").on('click', function(){
		var clone = $('.categorySelectHolder').first().clone('true');
		$(clone).find(".productcategorycont").val('');
		$(clone).insertAfter($('.categoryCont').find(".categorySelectHolder").last());
	});
	
	/*	change sifrarnik	*/
	
	$(document).on('change', '.productcodeCont', function(){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "changeProductcode",
					proid: $(this).parents('tr').find('.changeViewButton').attr('id'),
					productcodeid: $(this).parents('tr').find('.productcodeCont').val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				
			}
		});
	});
	
	/*	fast Sort	*/
	
	$(document).on('change', '.sortProductInput', function(){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "changeProductSort",
					proid: $(this).parents('tr').find('.changeViewButton').attr('id'),
					newsort: $(this).val()
				}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
				alert("ERROR");                            
			},
			success:function(response){
				
			}
		});
	});
	
	/*	QUANTITY REBATE	*/
		
		$('.jq_productNewRebateInput').on('change keyup ', function(){
			if($('.productPriceB2C').val() != '' && $('.productTax').val() != '')
			{
				if($('.jq_productNewRebateInput').val() >= 0 && $('.jq_productNewRebateInput').val() <= 100)
				{
					if($('.productTax').val() == 4) var tax = 20; 
					var newprice = parseFloat($('.productPriceB2C').val())*((100+parseInt(tax))*0.01)*((100-parseInt($('.jq_productNewRebateInput').val()))*0.01);
					$('.jq_productNewRebatePriceInput').val(newprice);
				}
				else{ 
					$('.jq_productNewRebateInput').val('');
					$('.jq_productNewRebatePriceInput').val('');
					alert('Nedozvoljen rabat!');
				}
			}
		});
		
		$('.jq_productNewRebatePriceInput').on('change blur', function(){
			if($('.productPriceB2C').val() != '' && $('.productPriceB2C').val() != 0 && $('.productTax').val() != '')
			{
				if($('.productTax').val() == 4) var tax = 1.2; 
				var oldprice = parseFloat(parseFloat($('.productPriceB2C').val())*tax);
				if($('.jq_productNewRebatePriceInput').val() > 0 && $('.jq_productNewRebatePriceInput').val() <= oldprice)
				{				
					var newrebate = (1-($('.jq_productNewRebatePriceInput').val()/oldprice))*100;
					$('.jq_productNewRebateInput').val(newrebate);
				}else{
					alert('Nedozvoljena cena!');
					$('.jq_productNewRebatePriceInput').val('');
					$('.jq_productNewRebateInput').val('');	
				}
			}
		});
		
		$('.jq_addProductQuantityReabateButton').on('click', function(){
			if($(".jq_productNewQuantityInput").val() != '' && $(".jq_productNewRebateInput").val() != ''){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addNewProductQuantity",
							proid: $(".productDataCont").attr("productid"),
							quantity: $(".jq_productNewQuantityInput").val(),
							rebate: $(".jq_productNewRebateInput").val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						if(response > 0)
						{
							if($('.jq_productQuantityRebateCont').find('tbody').find('tr[itemid="'+response+'"]').length == 0)
							{
								var clone = $(".jq_productQuantityRebateTemplate").clone(true).removeClass('hide').removeClass('jq_productQuantityRebateTemplate').attr('itemid', response);
								$(clone).find('.jq_productQuantityHolder').html($(".jq_productNewQuantityInput").val());
								$(clone).find('.jq_productRebateHolder').html($(".jq_productNewRebateInput").val());
								$(clone).find('.jq_productStatusHolder').val('h');
								
								$(clone).appendTo($('.jq_productQuantityRebateCont').find('tbody'));
								
								$(".jq_productNewQuantityInput").val('');
								$(".jq_productNewRebateInput").val(''); 
								$(".jq_productNewRebatePriceInput").val(''); 
							}else{
								$('.jq_productQuantityRebateCont').find('tbody').find('tr[itemid="'+response+'"]').find('.jq_productRebateHolder').html($(".jq_productNewRebateInput").val());
								$(".jq_productNewQuantityInput").val('');
								$(".jq_productNewRebateInput").val(''); 
								$(".jq_productNewRebatePriceInput").val('');
							}
						}
					}
				});	
			}else{
				alert("Sva polja su obavezna");	
			}
		});
		
		$(".jq_productStatusHolder").on('change', function(){
			$this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changeproductquantitystatus",
						status: $(this).val(),
						id: $(this).parents('tr').attr('itemid')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					console.log(response);
				}
			});	
		});
		
		$(".deleteProductQuantityRebateItem").on("click", function(){
			var a = confirm("Da li sigurno zelite da obrisete stavku?");
			if(a){
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteprorebate",
							id: $(this).parents('tr').attr("itemid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							$($this).parent().parent().remove();
						}
						
					}
				});
						
			}
		});
	
	/*	BAROMETAR	*/
		
		
		$('.jq_addProductBarometarButton').on('click', function(){
			if($(".jq_productNewBarometarMinInput").val() != '' && $(".jq_productNewBarometarMaxInput").val() != '' && $(".jq_productNewBarometarObjectSelect").val() != '0'){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addNewProductBarometar",
							proid: $(".productDataCont").attr("productid"),
							'min': $(".jq_productNewBarometarMinInput").val(),
							'max': $(".jq_productNewBarometarMaxInput").val(),
							'object': $(".jq_productNewBarometarObjectSelect").val(),
							'date': $(".jq_BarometarDateInput").val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						if(response > 0)
						{
							if($('.jq_productBarometarCont').find('tbody').find('tr[itemid="'+response+'"]').length == 0)
							{
								var clone = $(".jq_productBarometarTemplate").clone(true).removeClass('hide').removeClass('jq_productBarometarTemplate').attr('itemid', response);
								$(clone).find('.jq_productBarometarMinHolder').html($(".jq_productNewBarometarMinInput").val()+".00");
								$(clone).find('.jq_productBarometarMaxHolder').html($(".jq_productNewBarometarMaxInput").val()+".00");
								$(clone).find('.jq_productBarometarObjectHolder').html($(".jq_productNewBarometarObjectSelect").find('option:selected').html());
								
								$(clone).appendTo($('.jq_productBarometarCont').find('tbody'));
								
								$(".jq_productNewBarometarMinInput").val('');
								$(".jq_productNewBarometarMaxInput").val(''); 
								$(".jq_productNewBarometarObjectSelect").val('0'); 
							}else{
								$('.jq_productBarometarCont').find('tbody').find('tr[itemid="'+response+'"]').find('.jq_productBarometarObjectHolder').html($(".jq_productNewBarometarObjectSelect").find('option:selected').html());
								
								$('.jq_productBarometarCont').find('tbody').find('tr[itemid="'+response+'"]').find('.jq_productBarometarMinHolder').html($(".jq_productNewBarometarMinInput").val()+".00");
								$('.jq_productBarometarCont').find('tbody').find('tr[itemid="'+response+'"]').find('.jq_productBarometarMaxHolder').html($(".jq_productNewBarometarMaxInput").val()+".00");
								$('.jq_productBarometarCont').find('tbody').find('tr[itemid="'+response+'"]').find('.jq_productBarometarObjectHolder').html($(".jq_productNewBarometarObjectSelect option:selected").html());
								
								
								$(".jq_productNewBarometarMinInput").val('');
								$(".jq_productNewBarometarMaxInput").val(''); 
								$(".jq_productNewBarometarObjectSelect").val('0'); 
							}
						}
					}
				});	
			}else{
				alert("Sva polja su obavezna");	
			}
		});
		
		
		$(".deleteProductBarometarItem").on("click", function(){
			var a = confirm("Da li sigurno zelite da obrisete stavku?");
			if(a){
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteproBarometar", 
							id: $(this).parents('tr').attr("itemid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							$($this).parent().parent().remove();
						}	
					}
				});			
			}
		});
		
		$(".jq_BarometarDateInput").on('change', function(){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "getBarometarDate", 
						id: $(".productDataCont").attr("productid"),
						date: $(this).val()
					}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					
					/*	BAROMETAR	*/
						
					$('.jq_productBarometarCont').find('tbody').html('');	
						
					for(var i = 0; i < a.length; i++){
						var clone = $(".jq_productBarometarTemplate").clone(true).removeClass('hide').removeClass('jq_productBarometarTemplate').attr('itemid', a[i]['id']);
						$(clone).find('.jq_productBarometarMinHolder').html(a[i]['min']);
						$(clone).find('.jq_productBarometarMaxHolder').html(a[i]['max']);
						$(clone).find('.jq_productBarometarObjectHolder').html(a[i]['name']);
						
						$(clone).appendTo($('.jq_productBarometarCont').find('tbody'));
					}
						
				}
			});	
		});
		
		$('#copy_barometar').on('click', function(){
			if(confirm('Da li želite da kopirate zadnji uneti barometar?'))
			{
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "copyBarometar"
						}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a == 1){
							alert('Uspesno kopirano!');	
						}
					}
				});	
			}
		});
});

