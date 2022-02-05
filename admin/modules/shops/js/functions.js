function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete prodavnicu?");
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
				//$(".addChangeLangCont").html('');
								
				$(".shopsPhoneInput").val(a.phone);
				$(".shopsMobileInput").val(a.cellphone);
				$(".shopsFaxInput").val(a.fax);
				$(".shopsEmailInput").val(a.email);
				$(".shopsCoordinatesInput").val(a.coordinates);
				$(".shopsImageInput").val(a.thumb);
				$(".shopsTypeInput").val(a.type);
				
				$(".newscitycont").val(a.cityid);
				$(".newswarehousecont").val(a.warehouseid);
				$(".newsgallerycont").val(a.gallery_id);
								
				var wt = JSON.parse(a.worktime);
							
				$(".shopsWorkTimeWeekFrom").val(wt['mf']['from']);
				$(".shopsWorkTimeWeekTo").val(wt['mf']['to']);
				$(".shopsWorkTimeSaturdayFrom").val(wt['st']['from']);
				$(".shopsWorkTimeSaturdayTo").val(wt['st']['to']);
				$(".shopsWorkTimeSundayFrom").val(wt['su']['from']);
				$(".shopsWorkTimeSundayTo").val(wt['su']['to']);
				
				$(".addChangeLangCont").html('');
				for(var i = 0; i < (a.lang).length; i++){
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a.lang[i].default).attr('langid', a.lang[i].langid);
					$(clone).find("h3.langname").html(a.lang[i].langname);
					$(clone).find(".shopNameInput").val(a.lang[i].name);
					$(clone).find(".shopAddressInput").val(a.lang[i].address);
					$(clone).find(".shopTextTextarea").html(a.lang[i].text);
					$(clone).find(".shopDescriptionTextarea").html(a.lang[i].description);
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
				
				$(".shopsNameInput").val('');
				$(".shopsAddressInput").val('');
				$(".shopsPhoneInput").val('');
				$(".shopsMobileInput").val('');
				$(".shopsFaxInput").val('');
				$(".shopsEmailInput").val('');
				$(".shopsCoordinatesInput").val('');
				$(".shopsImageInput").val('');
				$(".shopsTypeInput").val('');
				$(".shopsDescriptionTextarea").html('');
				$(".newscitycont").val('');
				$(".newswarehousecont").val('');
				$(".newsgallerycont").val('');
				
				for(var i = 0; i < a.length; i++){
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].id);
					$(clone).find("h3.langname").html(a[i].name);
					$(clone).find(".shopNameInput").val('');
					$(clone).find(".shopAddressInput").val('');
					$(clone).find(".shopTextTextarea").html('');
					$(clone).find(".shopDescriptionTextarea").html('');
					$(clone).appendTo($(".addChangeLangCont"));	
				}
				
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				
				//$(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat','0');
				$(".newscategorycont").val('0');				
				
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

	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					id: id,
					phone: $(".shopsPhoneInput").val(),
					mobile: $(".shopsMobileInput").val(),
					fax: $(".shopsFaxInput").val(),
					email: $(".shopsEmailInput").val(),
					coordinates: $(".shopsCoordinatesInput").val(),
					image: $(".shopsImageInput").val(),
					type: $(".shopsTypeInput").val(),
					cityid: $(".newscitycont").val(),
					warehouseid: $(".newswarehousecont").val(),
					galleryid: $(".newsgallerycont").val(),
					weekfrom: $(".shopsWorkTimeWeekFrom").val(),
					weekto: $(".shopsWorkTimeWeekTo").val(),
					stfrom: $(".shopsWorkTimeSaturdayFrom").val(),
					stto: $(".shopsWorkTimeSaturdayTo").val(),
					sufrom: $(".shopsWorkTimeSundayFrom").val(),
					suto: $(".shopsWorkTimeSundayTo").val(),
					values : [] 		
					};
					
		$(".langGroupCont:not(.langGroupContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				name : $(this).find('.shopNameInput').val(),
				address : $(this).find('.shopAddressInput').val(),
				text : $(this).find('.shopTextTextarea').val(),
				description: $(this).find('.shopDescriptionTextarea').val()
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
					window.location.href = 'shops'; 
				}
			}
		});
	}		
}