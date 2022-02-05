function clearExtraDetailForm(){
	$(".nameExtraDetail").val("");	
	$(".imageExtraDetail").val("");	
	
	$(".dataExtraDetail").attr("extradetaildataid", "");
	$(".addExtraDetailButton").removeClass("hide");
	$(".saveExtraDetailButton").addClass('hide');
}
function clearProductForm(){
	//$(".saveExtraDetailButton").addClass('hide');
	$(".productDownloadItemCont").html("");
	$("#file").val("");
	$("#image_preview").children("ul").html("");
}

function deleteExtraDetail_handler(elem){
	if(confirm("Obrisati vrednost?"))
	{
		if($(elem).parent().parent().attr("extraDetailid") != "")
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deleteExtradetail",
						id: $(elem).parent().parent().attr("extraDetailid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						alert("Uspesno obrisana vrednost");
						document.location.reload();
					}
					else{
						alert("Greska prilikom brisanja");
					}	
				}
			});
		}
		$(elem).parent().parent().remove();
	}
}
function extraDetailListItem_handler(elem){
	if($(elem).attr("extraDetailid") != "")
	{
		$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "getExtradetail",
						id: $(elem).attr("extraDetailid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						
						$(".extradetailNameCont").html('');
						for(var i = 0; i < (a[1].lang).length; i++){
							$(".dataExtraDetail").attr("extradetaildataid", a[1].lang[i].id);
							$(".statusExtraDetail").val(a[1].lang[i].status);
							$(".showInWelcomepageExtraDetail").val(a[1].lang[i].showinwelcomepage);
							$(".showInWebShopExtraDetail").val(a[1].lang[i].showinwebshop);
							$(".banerExtraDetail").val(a[1].lang[i].banerid);
							
							var clone = $(".extradetailNameHolderTemplate").clone(true).removeClass("extradetailNameHolderTemplate").removeClass('hide').addClass('extradetailNameHolder').attr('langid', a[1].lang[i].langid).attr('defaultlang', a[1].lang[i].default);	
							$(clone).find('h4').html(a[1].lang[i].langname);
							$(clone).find('.nameExtraDetail').val(a[1].lang[i].name);
							$(clone).find('.imageExtraDetail').val(a[1].lang[i].image);
							
							
							$(clone).appendTo($(".extradetailNameCont"));	
						}
						
						$(".saveExtraDetailButton").removeClass('hide');
						$(".statusExtraDetailCont").removeClass('hide');
						$(".showInWelcomepageExtraDetailCont").removeClass('hide');
						$(".showInWebShopExtraDetailCont").removeClass('hide');
						$(".banerExtraDetailCont").removeClass('hide');
					}	
				}
			});		
	}
}

function relationsListItem_handler(elem){
	if($(elem).attr("relationsid") != "")
	{
		$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "getRelations",
						id: $(elem).attr("relationsid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						
						$(".relationsNameCont").html('');
						for(var i = 0; i < (a[1].lang).length; i++){
							$(".dataRelations").attr("relationsdataid", a[1].lang[i].id);
							$(".statusRelations").val(a[1].lang[i].status);
							
							var clone = $(".relationsNameHolderTemplate").clone(true).removeClass("relationsNameHolderTemplate").removeClass('hide').addClass('relationsNameHolder').attr('langid', a[1].lang[i].langid).attr('defaultlang', a[1].lang[i].default);	
							$(clone).find('h4').html(a[1].lang[i].langname);
							$(clone).find('.nameRelations').val(a[1].lang[i].name);
							
							$(clone).appendTo($(".relationsNameCont"));	
						}
						
						$(".saveRelationsButton").removeClass('hide');
						$(".statusRelationsCont").removeClass('hide');
					}	
				}
			});		
	}
}