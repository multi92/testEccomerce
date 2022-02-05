function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete javnu nabavku?");
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
				$(".addChangeLangCont").html('');
				
				$(".mainimage").val(a.thumb);
				$(".expiredate").val(a.expiredate);
				for(var i = 0; i < (a.langheader).length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a.langheader[i].default).attr('langid', a.langheader[i].langid);
					$(clone).find("h3.langname").html(a.langheader[i].langname);
					$(clone).find(".numberJavne").val(a.langheader[i].number);
					$(clone).find(".predmetJavne").val(a.langheader[i].predmet);
					$(clone).find(".vrstaJavne").val(a.langheader[i].vrsta);

							
					for(var j = 0; j < (a.langheader[i].data).length; j++){ 
						
						
						var tr = $(document.createElement("tr")).attr('javneitemid', a.langheader[i].data[j].id).attr("fullurl", a.langheader[i].data[j].value);
						var td = $(document.createElement("td"));
						
						$(td).clone(true).addClass("docname").html(a.langheader[i].data[j].docname).appendTo($(tr));
						
						var select = $(document.createElement('select')).addClass('form-control').addClass('selectJavneItemStatus');
						var option = $(document.createElement('option'));
						
						$(option).clone(true).val(0).html('Stari').appendTo($(select));
						$(option).clone(true).val(1).html('Novi').appendTo($(select));
						
						$(select).appendTo($(tr));

						$(select).find("option[value='"+a.langheader[i].data[j].active+"']").attr('selected', 'selected');
						
						$(td).clone(true).addClass("adddatecolum").html(a.langheader[i].data[j].adddate).appendTo($(tr));
						
						$($(document.createElement('button')).addClass('btn').addClass('btn-danger').addClass('deleteJavneItem').html('obrisi').appendTo($(td).clone(true))).appendTo($(tr))
						
						
						$(tr).appendTo($(clone).find(".position_"+a.langheader[i].data[j].position).find('tbody'));
					}
					
					$(clone).appendTo($(".addChangeLangCont"));	
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
				
				$(".addChangeLangCont").html('');
				
				$(".mainimage").val('');
				for(var i = 0; i < a.length; i++){
					
					var clone = $(".langGroupContAddTemplate").clone(true).removeClass('hide').removeClass('langGroupContAddTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].id);
										
					$(clone).appendTo($(".addChangeLangCont"));	
				}
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});	
	}
		
}

function deletejavne_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete stavku?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deletejavneitem", 
		  			id: $(elem).parent("tr").attr("javneitemid"),
					langid: $(elem).parents(".langGroupCont").attr('langid')
				}
		}).done(function(result){
			if(result == 1){
				alert("Uspesno obrisano!");
				$(elem).parent("tr").remove();
			}
		});		
	}
}

function addjavnedocument_handler(elem){
	if($(elem).parent().find(".urlJavne").val() != ""){
		
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "addjavneitem", 
		  			id: $(elem).parent("tr").attr("javneitemid"),
					langid: $(elem).parents(".langGroupCont").attr('langid'),
					path : $(elem).parent().find(".urlJavne").val(),
					position : $(elem).parent().find(".positionJavneSelect").val(),
					javneid : $(".content-wrapper").attr("currentid")
				}
		}).done(function(result){
			window.location.reload();
		});		
		
	}	
}

function changeitemstatus_handler(elem){
	$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "changejavneitemstatus", 
		  			value: $(elem).val(),
					id: $(elem).parent("tr").attr("javneitemid") 
				}
		}).done(function(result){
			
		});		
}

function saveAddChange(){
	
	var noerror = true;
	if($('.langGroupCont[defaultlang="y"]').find(".numberJavnes").val() == "")
	{
		$('.numberJavne').addClass("has-error");
		noerror = false;
	}
	
	/*
	if($('.langGroupCont[defaultlang="y"]').find(".predmetJavne").val() == "")
	{
		$('.predmetJavne').addClass("has-error");
		noerror = false;
	}
	*/
	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					javneid : $('.jq_javneid').attr('javneid'),
					expiredate : $('.expiredate').val(),
					values : [] 
					};
					
		$(".langGroupCont:not(.langGroupContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				number : $(this).find('.numberJavne').val(),
				predmet : $(this).find('.predmetJavne').val(),
				vrsta : $(this).find('.vrstaJavne').val()
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
				document.location.href = 'javne/change/'+response;
			}
		});
	}		
}