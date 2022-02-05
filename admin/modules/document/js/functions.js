function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete vest?");
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
								
				$(".documentPath").val(a.link);
				$(".documentImage").val(a.image);
				$(".documentDelovodni").val(a.delovodni);
				
				var date = (a.zavodjenjedatum).split(' ');
				$(".documentDate").val(date[0]);
				$(".documentType").attr('currentDocumentType',a.type);
				$(".documentType").find("option[value='"+a.type+"']").attr('selected', 'selected');
				$(".addChangeLangCont").html('');
				
				for(var i = 0; i < (a.lang).length; i++){
					
					var clone = $(".documentNameContTemplate").clone(true).removeClass('hide').removeClass('documentNameContTemplate').attr('defaultlang', a.lang[i].default).attr('langid', a.lang[i].langid);
					$(clone).find("span").html(a.lang[i].langname);
					$(clone).find(".documentName").val(a.lang[i].showname);

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
				
				$(".documentPath").val('');
				$(".documentImage").val('');
				$(".documentDelovodni").val('');
				$(".documentDate").val('');
				$(".documentType").attr('currentDocumentType','file');
				$(".documentType").find("option[value='"+'file'+"']").attr('selected', 'selected');
				$(".addChangeLangCont").html('');
				for(var i = 0; i < a.length; i++){
					
					var clone = $(".documentNameContTemplate").clone(true).removeClass('hide').removeClass('documentNameContTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].id);
					$(clone).find("span").html(a[i].name);
					$(clone).find(".documentName").val('');
					
					$(clone).appendTo($(".addChangeLangCont"));	
				}
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});	
	}
}

function saveAddChange(){
	var docid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		docid = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;
	if($('.documentNameCont[defaultlang="y"]').find(".documentName").val() == "")
	{
		$('.documentNameCont[defaultlang="y"]').addClass("has-error");
		noerror = false;
	}
	
	if($('.documentPath').val() == "")
	{
		$('.documentPath').parent().addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ 
		alert('Popunite obavezna polja');
		$(".loadingIcon").addClass("hide");	
	}
		
	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					docid: docid,
					link : $(".documentPath").val(),
					showname : $(".documentName").val(),
					image : $(".documentImage").val(),
					delovodni : $(".documentDelovodni").val(),
					date : $(".documentDate").val(),
					type : $(".documentType").attr("currentDocumentType"),
					values : []
				};
				
		$(".documentNameCont:not(.documentNameContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				showname : $(this).find('.documentName').val()
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
					window.location.href = 'document';
				}
			}
		});
	}		
}