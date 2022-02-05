
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
				
				$(".positionSelect").val(a.position);
				$(".pageBanner").val(a.page);
				$(".titleBanner").val(a.name);
				for(var i = 0; i < (a.lang).length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a.lang[i].default).attr('langid', a.lang[i].langid);
					$(clone).find("h3.langname").html(a.lang[i].langname);
					$(clone).find(".ckcont").attr('id', 'ckeditor'+a.lang[i].langid);
					
					$(clone).appendTo($(".addChangeLangCont"));	
					CKEDITOR.replace( 'ckeditor'+a.lang[i].langid );
					CKEDITOR.instances['ckeditor'+a.lang[i].langid].setData(a.lang[i].value);
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
				
				$(".positionSelect").val('');
				$(".titleBanner").val('');
				$(".pageBanner").val('');
				for(var i = 0; i < a.length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].id);
					$(clone).find("h3.langname").html(a[i].name);
					$(clone).find(".ckcont").attr('id', 'ckeditor'+a[i].id);
					
					$(clone).appendTo($(".addChangeLangCont"));	
					CKEDITOR.replace( 'ckeditor'+a[i].id );
					
				}
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});	
	}
}

function saveAddChange(){
	var bannerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		bannerid = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;
	if($(".titleBanner").val() == "")
	{
		$('.titleBanner').parent().addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ alert('Popunite obavezna polja'); $(".loadingIcon").addClass("hide");	}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					bannerid: bannerid,
					position : $(".positionSelect").val(),
					name : $('.titleBanner').val(),
					values : [] 
					};
					
		$(".langGroupCont:not(.langGroupContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				'value' : CKEDITOR.instances[$(this).find('.ckcont').attr('id')].getData()
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
					window.location.href = 'banner';
				}
			}
		});
	}		
}