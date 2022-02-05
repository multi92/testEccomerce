function clearAttrDetailsForm(){
	$("[class*='_attrName']").val("");	
}
function basename(str)
{
   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
    if(base.lastIndexOf(".") != -1)       
        base = base.substring(0, base.lastIndexOf("."));
   return base;
}

function deleteattrval_handler(elem){
	if(confirm("Obrisati vrednost?"))
	{
		if($(elem).parent().parent().attr("attrvalid") != "")
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deleteAttrVal",
						id: $(elem).parent().parent().attr("attrvalid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					console.log(response);
					if(response == 0){
						alert("Uspešno obrisana vrednost");
					}
					else{
						alert("Greška prilikom brisanja atributa");
					}	
				}
			});
		}
		$(elem).parent().parent().remove();
	}
}
$(document).ready(function(e) {

    $( "#sortable" ).sortable({
		placeholder: "ui-state-highlight"
	});
    $( "#sortable" ).disableSelection();
	
	 $( "#sortable" ).sortable({
        stop: function( ) {
			var data = [];
			$(this).find('li').each(function(){
				data.push($(this).attr('attrvalid'));
				console.log(data);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "updateSortAttrVal",
							data: data
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						
					}
				});
			})
			
        }
    });
	
	/*	add new attr */
	
	$("#addNewAttr").on("click", function(){
		var error = false;
		var data = [];
		if($(".newAttrCont").find(".newAttrNameCont[defaultlang='y']").find(".newattr").val() != '')
		{
			$(".newAttrCont").find(".newAttrNameCont").each(function(){
				var obj = {'langid': $(this).attr('langid'),
							'default' : $(this).attr('defaultlang'),
							'value' : $(this).find(".newattr").val()};	
				data.push(obj);
			});
		}
		else{
			error = true;	
			alert("Unesite naziv");
			$(".newAttrCont").find(".newAttrNameCont[defaultlang='y']").addClass('has-error');
		}
		console.log(data);
		
		if(!error){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addNewAttr",
						data: data
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						alert("Uspesno dodat atribut");
						document.location.reload();	
					}
					else{
						alert("Greska prilikom dodavanja atributa");
					}	
				}
			});
		}
	});
	
	/* list item template	*/
	
	$(".toggleListItem").on("click", function(){
		if($(this).parent().attr("state") == "close")
		{
			$(this).parent().find(".small-view").addClass('hide');
			$(this).parent().find(".big-view").removeClass('hide');	
			$(this).parent().attr("state","open");
		}
		else{
			$(this).parent().find(".small-view").removeClass('hide');
			$(this).parent().find(".big-view").addClass('hide');
			$(this).parent().attr("state","close");		
		}
	});
	
	$(".attrValImageLink").on("change", function(){
		if($(this).val() != "")
		{
			var string = $(this).val();
			var ext = string.split('.').pop();
			if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif")
			{
				
				var image = $('<img src="../"+string+" />');
				console.log(image);
				if (image.attr('width') == 0) {
				  alert("Nevalidna putanja");
				  $(this).parent().parent().find(".attrValImage").attr("src", '' );
				}else{
					$(this).parent().parent().find(".attrValImage").attr("src", '../'+$(this).val() );
					saveAttrValMainImage_handler($(this));
				}
			}
			else{
				alert("Unesite putanju do slike!");	
				$(".attrValImage").attr("src", '' );
			}
		}
	});
	
	$(".deleteAttrValButton").on("click", function(){
		deleteattrval_handler($(this));
	});
	
	/*	add new attr val */
	
	$("#addNewAttrVal").on("click", function(){
		var add = false;
		var data = [];
		
		var error = false;
		if($(".addNewAttrValCont").find(".newAttrValNameCont[defaultlang='y']").find(".newAttrValName").val() != '')
		{
			$(".addNewAttrValCont").find(".newAttrValName").each(function(){
				var obj = {'langid': $(this).parent().parent().attr('langid'),
							'default' : $(this).parent().parent().attr('defaultlang'),
							'value' : $(this).val()};	
				data.push(obj);
			});
		}
		else{
			error = true;	
			alert("Unesite naziv");
			$(".addNewAttrValCont").find(".newAttrValNameCont[defaultlang='y']").addClass('has-error');
		}
		
		if(!error)
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addNewAttrVal",
						attrid : $(".detailAttrCont").attr("attrid"),
						data: data
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var res = JSON.parse(response);
					if(res[0] == 0){
						
						var clone = $(".attrValItemHolderTemplate").clone(true).removeClass('attrValItemHolderTemplate').removeClass('hide').addClass('attrValItemHolder').attr('attrvalid', res[1]);
						$(clone).find('.attrValImageLink').val('');
						$(clone).find('.attrValImage').val('');
						$(clone).find('.attrValColorLink').val('');
						
						
						$(".addNewAttrValCont").find(".newAttrValName").each(function(){
							var clone2 = $(".attrValItemValueHolderTemplate").clone(true).removeClass('attrValItemValueHolderTemplate').removeClass('hide').addClass('attrValItemValueHolder').attr('langid', $(this).parent().parent().attr('langid')).attr('defaultlang', $(this).parent().parent().attr('defaultlang'));
							
							$(clone2).find(".attrValName").val($(this).val());
							if($(this).parent().parent().attr('defaultlang') == 'y'){
								$(clone).find('.small-view').html($(this).val());		
							}
							$(clone2).appendTo($(clone).find(".attrValItemValueCont"));
							
						});
						
						$(clone).appendTo($(".listAttrValCont"));
							
							
					}
					else{
						alert("Greska prilikom dodavanja atributa");
					}	
				}
			});		
		}
	});
	
	/*	attr list handlers	*/
	
	$(".listAttrCont").find('li').each(function(){
		var $this = $(this);
		$(this).children("a").on("click", function(){
			$(".listAttrCont").find('li').each(function(){
				$(this).removeClass("active");	
			});
			$this.addClass("active");
			$(".detailAttrCont").attr('attrid', $this.attr("attrid"));
			$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "getAttr",
							id: $this.attr("attrid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){						
						var a = JSON.parse(response);
						
						$('.detailAttrHolder').html('');
						for(var i = 0; i < (a.lang).length; i++){
							var clone = $(".attrNameInputTemplate").clone(true).removeClass('attrNameInputTemplate').removeClass('hide').addClass('attrNameInput').attr('langid', a.lang[i].langid).attr('defaultlang', a.lang[i].default);
							$(clone).find('h4').html(a.lang[i].langname);
							$(clone).find('.attrName').val(a.lang[i].name);
							
							$(clone).appendTo($('.detailAttrHolder'));
						}
						
						$('.productDownloadItemCont').html('');
						for(var i = 0; i < (a.documents).length; i++){
							var clone = $(".downloadItemRowTemplate").clone(true).removeClass('downloadItemRowTemplate').removeClass('hide').attr('prodownloadid', a.documents[i].id);
							
							var text = '';
							if(a.documents[i].type == "yt") 
							{
								text = 'youtube';
								content = '<iframe height="150" src="'+a.documents[i].content+'" frameborder="0" allowfullscreen=""></iframe>';
							}
							if(a.documents[i].type == "doc")
							{
								text = 'dokument';
								content = '<a href="'+a.documents[i].content+'">'+basename(a.documents[i].content)+'</a>';
							} 
							
							contentface = '';
							if(a.documents[i].contentface != "")
							{
								contentface = '<img src="../'+a.documents[i].contentface+'" height="50" data-featherlight="../'+a.documents[i].contentface+'">';
							}
							
							
							$(clone).find('td:nth-child(1)').html(text);
							$(clone).find('td:nth-child(2)').html(content);
							$(clone).find('td:nth-child(3)').html(contentface);
							
							$(clone).appendTo($('.productDownloadItemCont'));
						}
						
						$(".listAttrValCont").html('');
						for(var i = 0; i < (a.values).length; i++){
							var clone = $(".attrValItemHolderTemplate").clone(true).removeClass('attrValItemHolderTemplate').removeClass('hide').addClass('attrValItemHolder').attr('attrvalid', a.values[i].id);
							$(clone).find('.attrValImageLink').val(a.values[i].mi.content);
							$(clone).find('.attrValImage').attr('src', "../"+a.values[i].mi.content);
							
							$(clone).find('.attrValColorLink').val(a.values[i].mc.content);
							
							for(var j = 0; j < (a.values[i].lang).length; j++){
							
								var clone2 = $(".attrValItemValueHolderTemplate").clone(true).removeClass('attrValItemValueHolderTemplate').removeClass('hide').addClass('attrValItemValueHolder').attr('langid', a.values[i].lang[j].langid).attr('defaultlang', a.values[i].lang[j].default);
								
								$(clone2).find(".attrValName").val(a.values[i].lang[j].value);
								if(a.values[i].lang[j].default == 'y'){
									$(clone).find('.small-view').html(a.values[i].lang[j].value);		
								}
								$(clone2).appendTo($(clone).find(".attrValItemValueCont"));
							}
							
							$(clone).appendTo($(".listAttrValCont"));
						}
						$(".newAttrValCont").removeClass('hide');
						$(".attrDownloadFormCont").removeClass('hide');
						$(".attrDownloadCont").removeClass('hide');
						$("#changeAttrSave").removeClass('hide');						
					}
				});	
		});	
		$(this).find("button").on("click", function(){
			if(confirm("Obrisati atribut?"))
			{
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteAttr",
							id: $(this).parent().parent().attr("attrid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						console.log(response);
						if(response == 0){
							alert("Uspesno obrisan atribut");
							document.location.reload();	
						}
						else{
							alert("Greska prilikom brisanja atributa");
						}	
					}
				});		
			}
		});	
		
	});
	
	$("#changeAttrSave").on("click", function(){
		if($(".detailAttrCont").attr("attrid") != "")
		{
			var dataname = [];
			
			$(".detailAttrHolder").find(".attrNameInput").each(function(){
				var obj = {'langid': $(this).attr('langid'),
							'default' : $(this).attr('defaultlang'),
							'name' : $(this).find('.attrName').val()
						};
				dataname.push(obj);
			});
						
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changeAttrVal",
						attrid: $(".detailAttrCont").attr("attrid"),
						data: dataname
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					if(response == 0){
						alert("Uspesno snimljeno!");	
					}
					
				}
			});
		}
	});
	
	$(".addAttrDownload").on("click", function(){
		if($(".newAttrDownloadContent").val() != ""){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action : "addNewAttrDownload",
						attrid : $(".detailAttrCont").attr("attrid"),
						type : $(".newAttrDownloadType").val(),
						content : $(".newAttrDownloadContent").val(),
						contentface : $(".newAttrDownloadContentimg").val()
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						
						var clone = $(".downloadItemRowTemplate").clone(true).removeClass('downloadItemRowTemplate').removeClass('hide').attr('prodownloadid', a[1]);
							
						var text = '';
						if($(".newAttrDownloadType").val() == "yt") 
						{
							text = 'youtube';
							content = '<iframe height="150" src="'+$(".newAttrDownloadContent").val()+'" frameborder="0" allowfullscreen=""></iframe>';
						}
						if($(".newAttrDownloadType").val() == "doc")
						{
							text = 'dokument';
							content = '<a href="'+$(".newAttrDownloadContent").val()+'">'+basename($(".newAttrDownloadContent").val())+'</a>';
						} 
						
						contentface = '';
						if($(".newAttrDownloadContentimg").val() != "")
						{
							contentface = '<img src="../'+$(".newAttrDownloadContentimg").val()+'" height="50" data-featherlight="">';
						}
						
						
						$(clone).find('td:nth-child(1)').html(text);
						$(clone).find('td:nth-child(2)').html(content);
						$(clone).find('td:nth-child(3)').html(contentface);
						
						$(clone).appendTo($('.productDownloadItemCont'));
						
						
						$(".newAttrDownloadContent").val('');
						$(".newAttrDownloadContentimg").val('');
						$(".newAttrDownloadContent").parent().removeClass('has-error');
					}
				}
			});
		}
		else{
			alert("Unesite putanju do dokumenta");	
			$(".newAttrDownloadContent").parent().addClass('has-error');
		}
	});
	
	$(document).on("click", ".deleteAttrDownload", function(){
		deleteAttrDocument_handler($(this));
	});
	
	$(".attrValColorLink").on("change", function(){
		saveAttrValMainColor_handler($(this));
	});
	
	$('.jq_attrSearchInput').on('keyup', function(){
		var searchVal = $('.jq_attrSearchInput').val();
		if(searchVal.length > 0){
			$('.jq_attrSearchListCont').find('li.list-group-item').addClass('hide');
			$('.jq_attrSearchListCont').find('li.list-group-item[search*="'+searchVal+'"]').each(function(){
				$(this).removeClass('hide');	
			});	
		}else{
			$('.jq_attrSearchListCont').find('li.list-group-item').removeClass('hide');	
		}
	});

});

