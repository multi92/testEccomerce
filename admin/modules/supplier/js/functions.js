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
				$(".addChangeLangCont").html('');
				
				$('.cln-name').val(a.name);
				$('.cln-code').val(a.code);
				$('.cln-idprefix').val(a.idprefix);
				$('.cln-margin').val(a.margin);
				if(a.addmargin == 'y'){
					$('.cln-addmargin').iCheck('check');
				}
				$('.cln-type').val(a.type);	
				$('.cln-sort').val(a.sort);
				
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
				$('.extradetailSortInput').val('');

				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				
				
			}
		});	
	}
}

function saveAddChange(){
	var id = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		id = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;
	if($('.langGroupCont[defaultlang="y"]').find(".extradetailNameInput").val() == "")
	{
		$(this).parent().addClass("has-error");
		noerror = false;
	}
		
	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					id: id,
					name: $('.cln-name').val(),
					code: $('.cln-code').val(),
					idprefix: $('.cln-idprefix').val(),
					margin: $('.cln-margin').val(),
					addmargin: ($('.cln-addmargin:checked').length > 0)? 'y':'n',
					type: $('.cln-type').val(),	
					sort: $('.cln-sort').val()
					};
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
					
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					window.location.href = 'supplier';
				}
			}
		});
	}		
}