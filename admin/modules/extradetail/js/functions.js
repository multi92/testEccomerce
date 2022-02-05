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
				$('.extradetailSortInput').val(a.sort);
				$(".showInWelcomepageExtraDetail").val(a.showinwelcomepage);
				$(".showInWebShopExtraDetail").val(a.showinwebshop);
				$(".banerExtraDetail").val(a.banerid);
				
				for(var i = 0; i < (a.lang).length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a.lang[i].default).attr('langid', a.lang[i].langid);
					$(clone).find("h3.langname").html(a.lang[i].langname);
					$(clone).find(".extradetailNameInput").val(a.lang[i].name);
					$(clone).find(".extradetailImageInput").val(a.lang[i].image);
					//$(clone).find(".showInWelcomepageExtraDetail").val(a[1].lang[i].showinwelcomepage);
					//$(clone).find(".showInWebShopExtraDetail").val(a[1].lang[i].showinwebshop);
					//$(clone).find(".banerExtraDetail").val(a[1].lang[i].banerid);
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

				$('.extradetailSortInput').val('');

				for(var i = 0; i < a.length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].id);
					$(clone).find("h3.langname").html(a[i].name);
					$(clone).find(".extradetailNameInput").val('');
					$(clone).find(".extradetailImageInput").html('');
										
					$(clone).appendTo($(".addChangeLangCont"));	
				}
				$(".showInWelcomepageExtraDetail").val('n');
				$(".showInWebShopExtraDetail").val('y');
				$(".banerExtraDetail").val('0');
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
					sort: $('.extradetailSortInput').val(),
					showinwelcomepage: $('.showInWelcomepageExtraDetail').val(),
					showinwebshop: $('.showInWebShopExtraDetail').val(),
					banerid: $('.banerExtraDetail').val(),
					values : [] 
					};
					
		$(".langGroupCont:not(.langGroupContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				name : $(this).find('.extradetailNameInput').val(),
				image : $(this).find('.extradetailImageInput').val()
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
				var a = JSON.parse(response);
					
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					window.location.href = 'extradetail';
				}
			}
		});
	}		
}