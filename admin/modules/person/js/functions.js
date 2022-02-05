
function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete stranicu?");
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
								
				$(".namePerson").val(a.name);
				$(".phonePerson").val(a.phone);
				$(".titlePerson").val(a.title);
				$(".picturePerson").val(a.picture);
				$(".emailPerson").val(a.email);
				$(".sortPerson").val(a.sort);
				
				var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').addClass('langGroupCont');
				
				$(clone).find(".ckdescriptioncont").attr('id', 'ckeditorDesc'+a.id);
				
				$(clone).appendTo($(".addChangeLangCont"));	
				
				CKEDITOR.replace( 'ckeditorDesc'+a.id );
				CKEDITOR.instances['ckeditorDesc'+a.id].setData(a.description);
					
				
				
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
				
				$(".namePerson").val('');
				$(".phonePerson").val('');
				$(".titlePerson").val('');
				$(".picturePerson").val('');
				$(".emailPerson").val('');
				$(".sortPerson").val('');
				
				for(var i = 0; i < a.length; i++){
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').addClass('langGroupCont').attr('defaultlang', a[i].default).attr('langid', a[i].id);
					
					$(clone).find(".ckdescriptioncont").attr('id', 'ckeditorDesc'+a[i].langid);
					
					$(clone).appendTo($(".addChangeLangCont"));	
					
					CKEDITOR.replace( 'ckeditorDesc'+a[i].langid );			
				}
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});	
	}
}

function saveAddChange(){
	var cenovnikid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		cenovnikid = $(".content-wrapper").attr('currentid');
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
					id: cenovnikid,
					name : $('.namePerson').val(),
					description : CKEDITOR.instances[$(".langGroupCont:not(.langGroupContTemplate)").find('.ckdescriptioncont').attr('id')].getData(),
					phone : $('.phonePerson').val(),
					title : $('.titlePerson').val(),
					picture : $('.picturePerson').val(),
					email : $('.emailPerson').val(),
					sort : $('.sortPerson').val()
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
					window.location.href = 'person';
				}
			}
		});
	}		
}