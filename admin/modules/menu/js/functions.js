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

function addSave(){
	var menuid = "";
	if($(".meniDataCont").attr("id") != "")
	{
		menuid = $(".meniDataCont").attr("id");
	}
	var parentid = "";
	if($(".meniDataCont").attr('parentid') != "")
	{
		parentid = $(".meniDataCont").attr('parentid');
	}
	
	
	if($('.langValueHolder[defaultlang="y"]').find(".langValue").val() == "")
	{
		$('.langValueHolder[defaultlang="y"]').addClass("has-error");
		alert("Unesite naziv.");
	}
	else
	{
		/*	objecty to pass	 */
		var passdata = {action: "savemenu",
					menuid: menuid,
					parentid: parentid,
					linktype: $(".linkTypeMenu").val(),
					link: $(".menuLink").val(),
					status: $(".statusMenu").val(),
					menutype: $(".menuType").val(),
					sortnum: $(".sortMenuNumber").val(),
					image: $(".menuImageInput").val(),
					values : [] 
					};
					
		$(".langValueHolder:not(.langInputTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('id'),
				value : $(this).find(".langValue").val()
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
				document.location.reload();
			}
		});
	}	
}