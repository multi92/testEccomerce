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
				//$(".addChangeLangCont").html('');
				
				$(".shopsNameInput").val(a.name);
				$(".shopsAddressInput").val(a.address);
				$(".shopsPhoneInput").val(a.phone);
				$(".shopsMobileInput").val(a.cellphone);
				$(".shopsFaxInput").val(a.fax);
				$(".shopsEmailInput").val(a.email);
				$(".shopsCoordinatesInput").val(a.coordinates);
				$(".shopsImageInput").val(a.thumb);
				$(".shopsTypeInput").val(a.type);
				$(".shopsDescriptionTextarea").html(a.description);
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
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				
				//$(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat','0');
				$(".newscategorycont").val('0');				
				//$(".categorySelectHolder").first().find(".newscategorycont").val('0');
				//for(var k = 1; k < (a.categoryid).length; k++){
				//	var clone = $(".categorySelectHolder").first().clone(true);	
					//alert(a.categoryid[k]);	
				//	$(clone).find(".newscategorycont").val('0');
				//	$(clone).insertAfter($(".categorySelectHolder").last());
				//}
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
					name: $(".shopsNameInput").val(),
					address: $(".shopsAddressInput").val(),
					phone: $(".shopsPhoneInput").val(),
					mobile: $(".shopsMobileInput").val(),
					fax: $(".shopsFaxInput").val(),
					email: $(".shopsEmailInput").val(),
					coordinates: $(".shopsCoordinatesInput").val(),
					image: $(".shopsImageInput").val(),
					type: $(".shopsTypeInput").val(),
					description: $(".shopsDescriptionTextarea").html(),
					cityid: $(".newscitycont").val(),
					warehouseid: $(".newswarehousecont").val(),
					galleryid: $(".newsgallerycont").val(),
					weekfrom: $(".shopsWorkTimeWeekFrom").val(),
					weekto: $(".shopsWorkTimeWeekTo").val(),
					stfrom: $(".shopsWorkTimeSaturdayFrom").val(),
					stto: $(".shopsWorkTimeSaturdayTo").val(),
					sufrom: $(".shopsWorkTimeSundayFrom").val(),
					suto: $(".shopsWorkTimeSundayTo").val()
							
					};

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

function addCoupon(){
	var gonext = false;
	if($(".jq_newCouponEmail").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}
	
	if($(".jq_newCouponValue").val() == ''){
		$(this).parent('form-group').addClass('has-error');	
		gonext = false;
	}else{
		$(this).parent('form-group').removeClass('has-error');	
		gonext = true;
	}
	
	if(gonext){
		$.ajax({
			type : 'POST',
			url:"modules/"+moduleName+"/library/functions.php",
			data : "action=addnewcoupon&newemail="+$(".jq_newCouponEmail").val()+"&newvalue="+$(".jq_newCouponValue").val()+"&newcountry="+$('.jq_newCouponCountry').val(),
			
			success : function(data){
				console.log(data);
				if(data == 0){
					alert('Uspešno kreirano!');	
					$(".jq_newCouponEmail").val('');
					$(".jq_newCouponValue").val('');
				}else{
					alert('Neuspelo kreiranje vaučera!');	
				}
			},
			error : function(){	
				alert("error");
			}
		});	
	}	
}