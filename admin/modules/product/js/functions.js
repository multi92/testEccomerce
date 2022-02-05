
 function changeProductFileStatus_handler(elem){
 	$this = $(elem);
		if($(elem).attr("currentStatus") != $(elem).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changeProductFileStatus", id: $this.attr("id"), status:$(elem).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				$('#tableProductFiles').DataTable().ajax.reload();
			});
		}
 }

function deleteProductFile_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da obrišete fajl proizvoda?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteProductFile", productid:$this.attr("productid") ,id: $this.attr("id") }
		}).done(function(result){
			alert("Podaci su uspešno obrisani!");
			$('#tableProductFiles').DataTable().ajax.reload();
		});		
	}	
}

function addProductDownload_handler(productid,type,content,contentface){
	$.ajax({
	  method: "POST",
	  url: "modules/"+moduleName+"/library/functions.php",
	  data: { action: "addProductDownload", productid:productid ,type: type, content: content,contentface:contentface }
	}).done(function(result){
		alert("Podaci su uspešno dodati!");
		$('#tableProductApplication').DataTable().ajax.reload();
	});	
}



 function changeProductDownloadStatus_handler(elem){
 	$this = $(elem);
		if($(elem).attr("currentStatus") != $(elem).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changeProductDownloadStatus", id: $this.attr("id"), status:$(elem).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				$('#tableProductDownload').DataTable().ajax.reload();
			});
		}
 }

function deleteProductDownload_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da obrišete prilog proizvoda?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteProductDownload", productid:$this.attr("productid") ,id: $this.attr("id") }
		}).done(function(result){
			alert("Podaci su uspešno obrisani!");
			$('#tableProductDownload').DataTable().ajax.reload();
		});		
	}	
}


function addProductApplication_handler(productid,newtype,newLink){
	$.ajax({
	  method: "POST",
	  url: "modules/"+moduleName+"/library/functions.php",
	  data: { action: "addProductApplication", productid:productid ,type: newtype, link: newLink }
	}).done(function(result){
		alert("Podaci su uspešno dodati!");
		$('#tableProductApplication').DataTable().ajax.reload();
	});	
}

function deleteProductApplication_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da obrišete podatke o Store Linku proizvoda?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteProductApplication", productid:$this.attr("productid") ,id: $this.attr("id") }
		}).done(function(result){
			alert("Podaci su uspešno obrisani!");
			$('#tableProductApplication').DataTable().ajax.reload();
		});		
	}	
}

function changeProductApplicationStatus_handler(elem){
	$this = $(elem);
		if($(elem).attr("currentStatus") != $(elem).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changeProductApplicationStatus", id: $this.attr("id"), status:$(elem).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				$('#tableProductApplication').DataTable().ajax.reload();
			});
		}
			
}

function updateProductWarehousePrice_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da promenite cenu?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "updateProductWarehousePrice", productid:$this.attr("productid") ,warehouseid: $this.attr("warehouseid"), newprice:$this.val() }
		}).done(function(result){
			alert("Cena je uspešno promenjena!");
			$('#tableProductWarehouse').DataTable().ajax.reload();
		});		
	} else {
		$('#tableProductWarehouse').DataTable().ajax.reload();
	}		
}

function updateProductWarehouseAmount_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da promenite količinu proizvoda?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "updateProductWarehouseAmount", productid:$this.attr("productid") ,warehouseid: $this.attr("warehouseid"), newamount:$this.val() }
		}).done(function(result){
			alert("Količina je uspešno promenjena!");
			$('#tableProductWarehouse').DataTable().ajax.reload();
		});		
	} else {
		$('#tableProductWarehouse').DataTable().ajax.reload();
	}	
}

function addProductWarehouse_handler(productid,warehouseid,newAmount,newPrice){
	$.ajax({
	  method: "POST",
	  url: "modules/"+moduleName+"/library/functions.php",
	  data: { action: "addProductWarehouse", productid:productid ,warehouseid: warehouseid, newAmount:newAmount, newPrice:newPrice }
	}).done(function(result){
		alert("Podaci su uspešno dodati!");
		$('#tableProductWarehouse').DataTable().ajax.reload();
	});	
}

function deleteProductWarehouse_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da obrišete podatke o magacinu?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteProductWarehouse", productid:$this.attr("productid") ,warehouseid: $this.attr("warehouseid") }
		}).done(function(result){
			alert("Podaci su uspešno obrisani!");
			$('#tableProductWarehouse').DataTable().ajax.reload();
		});		
	}	
}

function addProductCategory_handler(productid,categoryid){
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "addProductCategory", productid:productid ,categoryid: categoryid }
		}).done(function(result){
			//alert("Uspesno obrisano!");
			$('#tableProductCategorys').DataTable().ajax.reload();
		});		
	
}

function deleteProductCategory_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da želite da obisete kategoriju?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deleteProductCategory", productid:$this.attr("productid") ,categoryid: $this.attr("categoryid") }
		}).done(function(result){
			alert("Uspesno obrisano!");
			$('#tableProductCategorys').DataTable().ajax.reload();
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
				$(".loadingIcon").removeClass("hide");

				$(".productNameHeader").html(a.code+" | "+a.name);//viewcount
				var headerCat= '';
				if(a.categorys.length > 0){
					for(var cat in a.categorys){
						if(typeof(a.categorys[cat]['categoryname']) != 'undefined'){
							headerCat=headerCat+a.categorys[cat]['categoryname']+"("+a.categorys[cat]['categorypath']+")<br>"; 
						} else {
							headerCat="<span style='background-color:#FF0000;'>&nbsp;KATEGORIJA NIJE DEFINISANA!!!&nbsp;</span><br>";
						}
						
					}
				}
				/*HEADER*/
				$(".productCategoryHeader").html(headerCat);
				$(".productVisitCount").html(a.viewcount);
				
				if(a.mainimage != ''){
					$(".productImageHeader").attr("src","../../fajlovi/product/small/"+a.mainimage);
				} else {
					$(".productImageHeader").attr("src","cdn/img/noimg.png");
				}
				

				$(".productActiveHeader").html(a.activestring);
				$(".productTypeHeader").html(a.typestring);
				
				

				if(a.quantity==null){
					$(".productAmountHeader").html('Količina nije definisana!!!');
					$(".productAmountHeader").parent().parent().addClass('hide');
				} else {
					$(".productAmountHeader").html(a.quantity);
				}


				if(a.taxvalue==null){
					$(".productTaxValueHeader").html('Poreska stopa nije definisana!!!');
					$(".productTaxValueHeader").parent().parent().addClass('hide');
				} else {
					$(".productTaxValueHeader").html(a.taxvalue+" %");
				}

				if(a.priceb2c==null){
					$(".productB2CPriceHeader").html("B2C Cena nije definisana!!!");
					$(".productB2CPriceHeader").parent().parent().addClass('hide');
				} else {
					$(".productB2CPriceHeader").html(a.priceb2c+" RSD");
				}
				
				$(".productB2CPriceWithVatHeader").html(a.priceb2cvat+" RSD");

				if(a.priceb2b==null){
					$(".productB2BPriceHeader").html("B2B Cena nije definisana!!!");
					$(".productB2BPriceHeader").parent().parent().addClass('hide');
				} else {
					$(".productB2BPriceHeader").html(a.priceb2b+" RSD");
				}

				$(".productB2BPriceWithVatHeader").html(a.priceb2bvat+" RSD");
				/*HEADER END*/
				$(".productCode").val(a.code);
				$(".productBarcode").val(a.barcode);
				$(".productActive").val(a.active).trigger("change");
				$(".productType").val(a.type).trigger("change");
				$(".productRebate").val(a.rebate);
				$(".productTax").val(a.taxid).trigger("change");
				$(".productBrend").val(a.brendid).trigger("change");
				$(".productCollection").val('0').trigger("change");
				$(".productPriceVisibility").val(a.pricevisibility).trigger("change");
				$(".productDeveloperLink").val(a.developerlink);
				$(".productNumberOfDownloads").val(a.numberofdownloads);
                

				
				
				for(var i = 0; i < (a.lang).length; i++){
						var clone = $('.productNameHolderTemplate').clone(true).removeClass('productNameHolderTemplate').removeClass('hide').addClass('productNameHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productName').val(a.lang[i].name);
						$(clone).find('label').html("Naziv proizvoda - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productNameCont"));

						var clone = $('.productAlterNameHolderTemplate').clone(true).removeClass('productAlterNameHolderTemplate').removeClass('hide').addClass('productAlterNameHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productAlterName').val(a.lang[i].altername);
						$(clone).find('label').html("Alternativni naziv proizvoda - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productAlterNameCont"));

						var clone = $('.productUnitNameHolderTemplate').clone(true).removeClass('productUnitNameHolderTemplate').removeClass('hide').addClass('productUnitNameHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productUnitName').val(a.lang[i].unitname);
						$(clone).find('label').html("Jedinica mere - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productUnitNameCont"));

						var clone = $('.productManufnameHolderTemplate').clone(true).removeClass('productManufnameHolderTemplate').removeClass('hide').addClass('productManufnameHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productManufname').val(a.lang[i].manufname);
						$(clone).find('label').html("Proizvođač - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productManufnameCont"));
						
						var clone = $('.productSearchwordsHolderTemplate').clone(true).removeClass('productSearchwordsHolderTemplate').removeClass('hide').addClass('productSearchwordsHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productSearchwords').val(a.lang[i].searchwords);
						$(clone).find('label').html("Reči za pretragu - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productSearchwordsCont"));

						var clone = $('.productDeveloperHolderTemplate').clone(true).removeClass('productDeveloperHolderTemplate').removeClass('hide').addClass('productDeveloperHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productDeveloper').val(a.lang[i].developer);
						$(clone).find('label').html("Developer - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productDeveloperCont"));

						var clone = $('.productCharacteristicsHolderTemplate').clone(true).removeClass('productCharacteristicsHolderTemplate').removeClass('hide').addClass('productCharacteristicsHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productCharacteristics').val(a.lang[i].characteristics);
						$(clone).find('label').html("Karakteristike - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productCharacteristicsCont"));
						
						var clone = $('.productDescriptionHolderTemplate').clone(true).removeClass('productDescriptionHolderTemplate').removeClass('hide').addClass('productDescriptionHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productDescription').val(a.lang[i].description);
						$(clone).find('label').html("Opis - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productDescriptionCont"));
						
						var clone = $('.productModelHolderTemplate').clone(true).removeClass('productModelHolderTemplate').removeClass('hide').addClass('productModelHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productModel').val(a.lang[i].model);
						$(clone).find('label').html("Model - "+a.lang[i].langname).prependTo($(clone));
						$(clone).appendTo($(".productModelCont"));
						
						var clone = $('.productSpecificationHolderTemplate').clone(true).removeClass('productSpecificationHolderTemplate').removeClass('hide').addClass('productSpecificationHolder').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
						$(clone).find('.productSpecification').val(a.lang[i].specification);
						$(clone).find('label').html("Specifikacija - "+a.lang[i].langname).prependTo($(clone));
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



				/*SET PRODUCT IMAGES*/
				if(a.images[0] != null)
				{
					for(var img in a.images){
						var li = $(document.createElement("li")).addClass("list-group-item").attr('imageid', a.images[img].id);
						$(document.createElement("img")).attr("src", a.images[img].thumb+"?"+new Date().getTime()).attr("data-featherlight", a.images[img].big+"?"+new Date().getTime()).addClass("img-responsive").addClass("verticalMargin10").appendTo($(li));
						$(document.createElement("button")).attr('type','button').addClass("btn").addClass("btn-warning").addClass("btn-xs").addClass("attrProductImageButton").attr('attrvalid',a.images[img].attrvalid ).attr('attrid',a.images[img].attrid ).html("Attr").appendTo($(li));	
						$(document.createElement("button")).attr('type','button').addClass("btn").addClass("btn-danger").addClass("btn-xs").addClass("deleteProductImageButton").html("X").appendTo($(li));
						$(li).appendTo($("#image_preview").children("ul"));
					}
				}
				/*SET PRODUCT IMAGES END*/


				/* SET PRODUCT EXTRADETAILS*/
				for(var ed in a.extradetail)
				{
					if(a.extradetail[ed][2] != null) { $("."+a.extradetail[ed][0]+"_productExtraDetailItem").iCheck('check'); }
					else{ $("."+a.extradetail[ed][0]+"_productExtraDetailItem").iCheck('uncheck'); }
	
				}
				/* SET PRODUCT EXTRADETAILS END*/
				/* SET PRODUCT ATTRIBUTES*/
				if(a.attributes.length > 0){
					$(".attrProdCont").html("");
					$(".imgAttrModalSelect").html("");

					var option = $(document.createElement("option"));
					$(option).clone(true).attr("value", "").appendTo($(".imgAttrModalSelect"));


					for(var at in a.attributes){

						$(option).clone(true).attr("value", a.attributes[at][0]).html(a.attributes[at][1]).appendTo($(".imgAttrModalSelect"));


						var divCatAttrHolder = $(document.createElement("div")).addClass("col-sm-12").attr('style',"background: rgb(248, 255, 208);");
						var br = $(document.createElement("br"));
						$(br).appendTo($(divCatAttrHolder));

						var attrName = $(document.createElement("b")).html(a.attributes[at][1]+" - <span style='font-weight:300;'>"+a.attributes[at][3]+"</span>");
						var attrNameHolder=$(document.createElement("h4"));
						$(attrName).appendTo($(attrNameHolder));
						$(attrNameHolder).appendTo($(divCatAttrHolder));
						var attrrow = $(document.createElement("div")).addClass("row");	

						for(var atval in a.attributes[at][2]){
							var ch = false;
							var chk = 'uncheck';
							if(a.attributes[at][2][atval][2] != null && a.attributes[at][2][atval][2] != "" ){
								ch = true;	
								var chk = 'check';
							}

							var clone = $(".productAtributeValueICheckHolderTemplate").clone(true).removeClass('productAtributeValueICheckHolderTemplate').removeClass('hide').addClass('productAtributeValueICheckHolder').removeClass('_productAttributeValue').addClass(a.attributes[at][2][atval][0]+'_productAttributeValue').attr('attrprodval', a.attributes[at][2][atval][0]);
							$(clone).find('.icheckboxname').text(a.attributes[at][2][atval][1]);
							$(clone).find(".attributeValue").val(a.attributes[at][2][atval][0]).addClass('attrprodval').attr('attrprodvalid',a.attributes[at][2][atval][0]).attr("checked", ch);
							//
							$(clone).iCheck({checkboxClass: 'icheckbox_line-green',radioClass: 'iradio_line-green', insert: '<div class="icheck_line-icon"></div><label class="icheckboxname" style="margin-bottom: 0;">' + a.attributes[at][2][atval][1]+'</label>'});
							$(clone).iCheck(chk).iCheck('update');
							$(clone).appendTo($(attrrow));
				
						}
					
						$(attrrow).appendTo($(divCatAttrHolder));
						$(divCatAttrHolder).appendTo($(".attrProdCont"));
					}
				}
		
				/* SET PRODUCT ATTRIBUTES END*/
      			
				
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
				$(".loadingIcon").removeClass("hide");

   				$(".productHeader").addClass('hide');
				$("#productWarehouseSection").addClass('hide');
				$("#productImagesSection").addClass('hide');
				$("#productCategorySection").addClass('hide');
				$("#productExtraDetailSection").addClass('hide');
				$("#productAttributeSection").addClass('hide');
				$("#productFilesSection").addClass('hide');
				$("#productAppSection").addClass('hide');
				
				$(".productCode").val('');
				$(".productBarcode").val('');
				$(".productActive").val('n').trigger("change");
				$(".productType").val('r').trigger("change");
				$(".productRebate").val('0');
				$(".productTax").val('0').trigger("change");
				$(".productBrend").val('0').trigger("change");
				$(".productCollection").val('0').trigger("change");
				$(".productPriceVisibility").val('a').trigger("change");
				$(".productDeveloperLink").val('');
				$(".productNumberOfDownloads").val('');


				for(var i = 0; i < (a).length; i++){
						var clone = $('.productNameHolderTemplate').clone(true).removeClass('productNameHolderTemplate').removeClass('hide').addClass('productNameHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productName').val('');
						$(clone).find('label').html("Naziv proizvoda - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productNameCont"));

						var clone = $('.productAlterNameHolderTemplate').clone(true).removeClass('productAlterNameHolderTemplate').removeClass('hide').addClass('productAlterNameHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productAlterName').val('');
						$(clone).find('label').html("Alternativni naziv proizvoda - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productAlterNameCont"));

						var clone = $('.productUnitNameHolderTemplate').clone(true).removeClass('productUnitNameHolderTemplate').removeClass('hide').addClass('productUnitNameHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productUnitName').val('');
						$(clone).find('label').html("Jedinica mere - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productUnitNameCont"));

						var clone = $('.productManufnameHolderTemplate').clone(true).removeClass('productManufnameHolderTemplate').removeClass('hide').addClass('productManufnameHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productManufname').val('');
						$(clone).find('label').html("Proizvođač - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productManufnameCont"));
						
						var clone = $('.productSearchwordsHolderTemplate').clone(true).removeClass('productSearchwordsHolderTemplate').removeClass('hide').addClass('productSearchwordsHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productSearchwords').val('');
						$(clone).find('label').html("Reči za pretragu - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productSearchwordsCont"));

						var clone = $('.productDeveloperHolderTemplate').clone(true).removeClass('productDeveloperHolderTemplate').removeClass('hide').addClass('productDeveloperHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productDeveloper').val('');
						$(clone).find('label').html("Developer - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productDeveloperCont"));

						var clone = $('.productCharacteristicsHolderTemplate').clone(true).removeClass('productCharacteristicsHolderTemplate').removeClass('hide').addClass('productCharacteristicsHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productCharacteristics').val('');
						$(clone).find('label').html("Karakteristike - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productCharacteristicsCont"));
						
						var clone = $('.productDescriptionHolderTemplate').clone(true).removeClass('productDescriptionHolderTemplate').removeClass('hide').addClass('productDescriptionHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productDescription').val('');
						$(clone).find('label').html("Opis - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productDescriptionCont"));
						
						var clone = $('.productModelHolderTemplate').clone(true).removeClass('productModelHolderTemplate').removeClass('hide').addClass('productModelHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productModel').val('');
						$(clone).find('label').html("Model - "+a[i].name).prependTo($(clone));
						$(clone).appendTo($(".productModelCont"));
						
						var clone = $('.productSpecificationHolderTemplate').clone(true).removeClass('productSpecificationHolderTemplate').removeClass('hide').addClass('productSpecificationHolder').attr('langid', a[i].id).attr('defaultlang', a[i].default);
						$(clone).find('.productSpecification').val('');
						$(clone).find('label').html("Specifikacija - "+a[i].name).prependTo($(clone));
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


				

				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');

			}
		});	
	}
}


function dataSearch(){
	
	var active = $(".searchProductActiveSelect").val();
	var type = $(".searchProductTypeSelect").val();
	var code = $(".searchProductCode").val();
	var barcode = $(".searchProductBarcode").val();
	var name = $(".searchProductName").val();
	var manufcode = $(".searchProductManufcode").val();
	var manufname = $(".searchProductManufname").val();
	var b2cpricefrom = $(".searchProductB2CPriceFrom").val();
	var b2cpriceto = $(".searchProductB2CPriceTo").val();
	var b2bpricefrom = $(".searchProductB2BPriceFrom").val();
	var b2bpriceto = $(".searchProductB2BPriceTo").val();
	var amountfrom = $(".searchProductAmountFrom").val();
	var amountto = $(".searchProductAmountTo").val();
	var withimage = $(".searchProductWithImageSelect").val();
	var withcategory = $(".searchProductWithCategorySelect").val();
	var withextcategory = $(".searchProductWithExtCategorySelect").val();
	
	var noerror = true;

	/*VALIDATION OF REQUIRED FIELDS*/
	/*VALIDATION OF REQUIRED FIELDS END*/


	if((active=='0' || active=='') 
	&& (type=='0' || type=='') 
	&& (withimage=='0' || withimage=='') 
	&& (withcategory=='0' || withcategory=='') 
	&& (withextcategory=='0' || withextcategory=='') 
	&& code=='' 
	&& barcode=='' 
	&& name==''
	&& manufcode==''
	&& manufname==''
	&& b2cpricefrom==''
	&& b2cpriceto==''
	&& b2bpricefrom==''
	&& b2bpriceto==''
	&& amountfrom==''
	&& amountto==''
	){
		noerror=false;
	}

	if(!noerror){ alert('Morate uneti bar jedan parametar pretrage.');}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {
						action: "setSearchData",
						active: active,
						type: type,
						code: code,
						barcode: barcode,
						name: name,
						manufcode: manufcode,
						manufname: manufname,
						b2cpricefrom: b2cpricefrom,
						b2cpriceto: b2cpriceto,
						b2bpricefrom: b2bpricefrom,
						b2bpriceto: b2bpriceto,
						amountfrom: amountfrom,
						amountto: amountto,
						withimage: withimage,
						withcategory: withcategory,
						withextcategory: withextcategory	
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
				/*if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					window.location.href = 'member';
				}*/
			}
		});
	}



}

function clearSearch(){
	var a = confirm("Da li ste sigurni da želite da očistite pretragu?");
	if(a)
	{
	var passdata = {
						action: "clearSearchData"	
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

function saveAddChange(){
	var productid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		productid = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;

	/*VALIDATION OF REQUIRED FIELDS*/
	/*VALIDATION OF REQUIRED FIELDS END*/

	/*

	if($('.galleryDataCont[defaultlang="y"]').find(".newsTitleInput").val() == "")
	{
		$('.newsTitleCont').addClass("has-error");
		noerror = false;
	}
	var catid= $(".categorySelectHolder").first().find(".newscategorycont").val();
	var prevcatid= $(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat');
	if(catid == "0")
	{
		$(".categorySelectHolder").addClass("has-error");
		noerror = false;
	}
	
	if($('.langGroupCont[defaultlang="y"]').find(".shortNewsInput").val() == "")
	{
		$('.shortNewsCont').addClass("has-error");
		noerror = false;
	}
	*/

	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {
						action: "saveaddchange",
						productid: productid,
						code: $(".productCode").val(),
						barcode: $(".productBarcode").val(),
						active: $(".productActive").val(),
						type: $(".productType").val(),
						webrebate: 0,
						rebate: $(".productRebate").val(),
      					taxid: $(".productTax").val(),
      					brendid: $(".productBrend").val(),
      					collectionid: $(".productCollection").val(),
      					pricevisibility: $(".productPriceVisibility").val(),
      					manufcode: $(".productManufcode").val(),
      					unitstep: $(".productUnitstep").val(),
      					developerlink: $(".productDeveloperLink").val(),
      					numberofdownloads: $(".productNumberOfDownloads").val(),
						names: [],
						alternames: [],
						manufnames: [],
						unitnames: [],
						searchwords: [],
						developers: [],
						descriptions: [],
						characteristics: [],
						specifications: [],
						models: []
					   };

		$(".productNameHolder").each(function(){
			passdata['names'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				name : $(this).find('.productName').val()
			});
		});	

		$(".productAlterNameHolder").each(function(){
			passdata['alternames'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				altername : $(this).find('.productAlterName').val()
			});
		});

		$(".productManufnameHolder").each(function(){
			passdata['manufnames'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				manufname : $(this).find('.productManufname').val()
			});
		});	

		$(".productUnitNameHolder").each(function(){
			passdata['unitnames'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				unitname : $(this).find('.productUnitName').val()
			});
		});	

		$(".productSearchwordsHolder").each(function(){
			passdata['searchwords'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				searchwords : $(this).find('.productSearchwords').val()
			});
		});
		$(".productDeveloperHolder").each(function(){
			passdata['developers'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				developer : $(this).find('.productDeveloper').val()
			});
		});					
		$(".productDescriptionHolder").each(function(){
			passdata['descriptions'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				description : $(this).find('.productDescription').val()
			});
		});	
		$(".productCharacteristicsHolder").each(function(){
			passdata['characteristics'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				characteristic : $(this).find('.productCharacteristics').val()
			});
		});	
		$(".productSpecificationHolder").each(function(){
			passdata['specifications'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				specification : $(this).find('.productSpecification').val()
			});
		});	
		$(".productModelHolder").each(function(){
			passdata['models'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				model : $(this).find('.productModel').val()
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
					//window.location.href = 'product/change/'+$(".content-wrapper").attr('currentid');
					
					// if($(".content-wrapper").attr('currentid') != "")
					// {
					// 	document.location.reload();
					// } else {
					// 	window.location.href = 'product';	
					// }
				}
				else{
					$(".loadingIcon").addClass("hide");
					
					window.location.href = 'product';
				}
			}
		});
	}		
}