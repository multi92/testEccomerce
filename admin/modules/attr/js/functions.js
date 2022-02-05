function deleteAttrDocument_handler(elem){
	if(confirm("Da li zelite da obrisete ovu stavku?"))
	{
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "deleteAttrDocument",
					id: $(elem).parents('tr').attr('prodownloadid')
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				$(elem).parents('tr').remove();
			}
		});
	}
}

function saveAttrValMainColor_handler(elem){
	$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "saveAttrValMainColor",
					id: $(elem).parents('.attrValItemHolder').attr('attrvalid'),
					value : $(elem).val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				
			}
		});	
}
function saveAttrValMainImage_handler(elem){
	$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "saveAttrValMainImage",
					id: $(elem).parents('.attrValItemHolder').attr('attrvalid'),
					value : $(elem).val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				
			}
		});	
}