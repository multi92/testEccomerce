function productcodeListItem_handler(elem){
	if($(elem).attr("productcodeid") != "")
	{
		$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "getProductcode",
						id: $(elem).attr("productcodeid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						$(".dataProductcode").attr("productcodedataid", a[1].id);
						$('.nameProductcode').val(a[1].name);
						
						$.ajax({
							type:"POST",
							url:"modules/"+moduleName+"/library/functions.php",
							data: ({action: "getProductcodeItems",
									id: $(elem).attr("productcodeid")
									}),
							error:function(XMLHttpRequest, textStatus, errorThrown){
							  alert("ERROR");                            
							},
							success:function(response){
								var a = JSON.parse(response);
								if(a[0] == 0){
									
									$(".productcodeItemCont").html('');
									for(var j = 0; j < a[1].length; j++){
										var clone = $(".productcodeItemHolderTemplate").clone(true).removeClass("productcodeItemHolderTemplate");
										$(clone).find(".PCitemattr").attr("attrid", a[1][j].attrid).html(a[1][j].attrname);
										$(clone).find(".PCitemattrval").attr("attrvalid", a[1][j].attrvalid).html(a[1][j].valuename);
										$(clone).find(".PCitemval").val(a[1][j].value);
										
										$(clone).appendTo($(".productcodeItemCont"));
									}
								}	
							}
						});	
						
						$(".dataProductcode").removeClass('hide');
						$(".productcodeItemBigCont").removeClass('hide');
					}	
				}
			});		
	}
}

function saveProductcode_handler(){
	var error = false;
		
	if($(".nameProductcode").val() == '')
	{
		error = true;	
		alert("Unesite naziv");
		$(".nameProductcode").parent().addClass('has-error');
	}
	
	if(!error){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "addChangeProductcode",
					id: $(".dataProductcode").attr("productcodedataid"),
					name: $(".nameProductcode").val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				console.log(a[0]);
				if(a[0] == 0){
					if($(".dataProductcode").attr("productcodedataid") == ''){
						alert('Uspesno dodato');
						document.location.reload();	
					}else{
						alert("Uspesno izmenjeno");
						$(".productcodeListItem[productcodeid='"+$(".dataProductcode").attr("productcodedataid")+"']").find('a').html($(".nameProductcode").val());
					}
				}
				else{
					alert("Greska prilikom dodavanja");
				}	
			}
		});	
	}	
}

function getAttrvalList_handler(elem){	
	if($(elem).val() != ''){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "getAttrValList",
					id: $(elem).val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				if(a[0] == 0){
					var option = $(document.createElement('option'));
					$(".addProductcodeAttrvalSelect").html('');
					for(var i = 0; i < a[1].length; i++){
						var opt = $(option).clone(true);
						$(opt).val(a[1][i].id).html(a[1][i].value);
						$(opt).appendTo($(".addProductcodeAttrvalSelect"));
					}
					$(".addProductcodeAttrvalCont").removeClass('hide');
					$(".addProductcodeValueCont").removeClass('hide');
				}
				else{
					alert("Greska prilikom dodavanja");
				}	
			}
		});	
	}
	else{
		$(".addProductcodeAttrvalCont").addClass('hide');
		$(".addProductcodeValueCont").addClass('hide');	
	}
}

function addProductcodeItem_handler(elem){
	var exist = false;
	if($(".addProductcodeValueInput").val() != '')
	{
		$(".productcodeItemCont").find('tr').each(function(){
			if( $(".addProductcodeAttrvalSelect").val() == $(this).find(".PCitemattrval").attr('attrvalid') ){
				exist = true;	
				return false;
			}
			else if(($(".addProductcodeAttrvalSelect").val() == $(this).find(".PCitemattrval").attr('attrvalid')) && ($(".addProductcodeValueInput").val() == $(this).find(".PCitemval").val()))
			{
				exist = true;	
				return false;
			}
			
			else if(($(".addProductcodeAttrSelect").val() == $(this).find(".PCitemattr").attr('attrid')) && ($(".addProductcodeValueInput").val() == $(this).find(".PCitemval").val()))
			{
				exist = true;	
				return false;
			}
		});
		
		if(!exist)
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addProductcodeItems",
						productcodeid: $(".dataProductcode").attr("productcodedataid"),
						attrid : $(".addProductcodeAttrSelect").val(),
						attrvalid : $(".addProductcodeAttrvalSelect").val(),
						value : $(".addProductcodeValueInput").val()
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						var clone = $(".productcodeItemHolderTemplate").clone(true).removeClass("productcodeItemHolderTemplate");
						$(clone).find(".PCitemattr").attr("attrid", $(".addProductcodeAttrSelect").val()).html($(".addProductcodeAttrSelect option:selected").text());
						$(clone).find(".PCitemattrval").attr("attrvalid", $(".addProductcodeAttrvalSelect").val()).html($(".addProductcodeAttrvalSelect option:selected").text());
						$(clone).find(".PCitemval").val($(".addProductcodeValueInput").val());
						
						$(clone).appendTo($(".productcodeItemCont"));
						
						$(".addProductcodeAttrSelect").val('');
						$(".addProductcodeAttrvalSelect").val('');
						$(".addProductcodeValueInput").val('');
						
						$(".addProductcodeAttrvalCont").addClass('hide');
						$(".addProductcodeValueCont").addClass('hide');	
					}
				}
			});	
		}
		else{
			alert("Vrednost vec postoji");	
		}
	}
	else{
		alert('Unesite sifru');	
	}
}

function deleteProductcodeItem_handler(elem){
	if(confirm("Obrisati stavku?")){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "deleteProductcodeItems",
					productcodeid: $(".dataProductcode").attr("productcodedataid"),
					attrid : $(elem).parents('tr').find(".PCitemattr").attr('attrid'),
					attrvalid : $(elem).parents('tr').find(".PCitemattrval").attr('attrvalid')
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				if(a[0] == 0){
					$(elem).parents('tr').remove();
				}
			}
		});	
	}
}

function updateProductcodeItemValue_handler(elem){
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: ({action: "addProductcodeItems",
				productcodeid: $(".dataProductcode").attr("productcodedataid"),
				attrid : $(elem).parents('tr').find(".PCitemattr").attr('attrid'),
				attrvalid : $(elem).parents('tr').find(".PCitemattrval").attr('attrvalid'),
				value : $(elem).val()
				}),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);
			if(a[0] == 0){
			}
		}
	});		
}