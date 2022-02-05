function resetUsersForm(){
		
	$(".deliveryserviceName").val('');
	$(".deliveryserviceCode").val(''); 
	$(".deliveryserviceAddress").val('');
	$(".deliveryservicePhone").val('');
	$(".deliveryserviceEmail").val('');
	$(".deliveryserviceWebsite").val('');
	$(".deliveryserviceImage").val('');	
	
	$(".deliveryserviceAddress").val('');	
	$(".deliveryserviceSort").val('');	
	$(".deliveryserviceCity").val('');	
	$("deliveryserviceZip").val('');	
	
	$(".socialHolder").html('');
saveUsers
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
function showCont(classname){
	showLoadingIcon();
	//$(".errorAddChangeUsersCont").hide('','',hideLoadingIcon());
	$(".addChangeUsersCont").hide("fast");
	$(".listUsersCont").hide("fast");
	$(".userGroupsCont").hide("fast");


	$("."+classname).show('fast','',hideLoadingIcon());

}
$(document).ready(function(e) {

	$("#userActivate").on('click', function(){
		var usersid = "";
		if($(".loadedusers").attr('usersid') != "")
		{
			usersid = $(".loadedusers").attr('usersid');
		}
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({
				action: "activateuser",
				usersid: usersid,
				status: $("#user_status").val(),

			}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
				alert("ERROR");
			},
			success:function(response){
				if(response == 1) {alert("Uspesno promenjen status korisnika"); document.location.reload();}
				else if(response == 2) {alert("Uspesno snimljena podesavanja za korisnika"); document.location.reload();}
				else alert(response);
			}
		});
	});

	$("#saveUsers").on("click", function(){

		//console.log(data1);
		var usersid = "";
		if($(".loadedusers").attr('usersid') != "")
		{
			usersid = $(".loadedusers").attr('usersid');
		}
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "saveusers",
					usersid: usersid,
					name: $(".deliveryserviceName").val(),
					code: $(".deliveryserviceCode").val(), 
					address: $(".deliveryserviceAddress").val(),
					city: $(".deliveryserviceCity").val(),
					zip: $(".deliveryserviceZip").val(),
					phone: $(".deliveryservicePhone").val(),
					email: $(".deliveryserviceEmail").val(),
					website: $(".deliveryserviceWebsite").val(),
					deliverytracklink: $(".deliveryserviceWebsiteTrackingLink").val(),
					image: $(".deliveryserviceImage").val(),
					sort: $(".deliveryserviceSort").val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				alert("Uspesno snimljeno"); 
				document.location.reload();
			}
		});
	});
	
	$("#example1").DataTable({
		stateSave: true,
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ korisnika",
				"infoEmpty":      "Prikaz 0 do 0 od 0 korisnika",
				"infoFiltered":   "(filtrirano od _MAX_ korisnika)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ korisnika",
				"loadingRecords": "Ucitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Zadnja",
					"next":       "Sledeca",
					"previous":   "Predhodna"
				}
        	}
		});
	
	$('#example1 tbody').on('click', '.deleteUsersButton', function () {
      	var $this = $(this);
		var a = confirm("Da li ste sigurni da zelite da obisete korisnika?");
		if(a)
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "deleteusers", usersid: $this.attr("usersid") }
			}).done(function(result){
				if(result == '1')
				{
					alert("Uspesno obrisano!");
					document.location.reload();
				}
				else
				{
					alert("Ne mozete da obrisete trenutno logovanog korisnika!");	
				}
			});		
		}
    }).on('change', '.selectStatus', function () {
			showLoadingIcon();
			changestatus_handler($(this));
		}).on('click', '.changeUsersButton', function () {
      	showLoadingIcon();
		//$(".errorAddChangeUsersCont").hide('','',hideLoadingIcon());
		$this = $(this);
		$(".listUsersCont").hide("fast","", function(){
			resetUsersForm();
			//$(".loadednews").attr('newsid', $this.attr("newsid"));
			
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "getusers", usersid: $this.attr("usersid") }
			}).done(function(result){
				//console.log(result);
				var a = JSON.parse(result);
	
				if(a[2] == 0 || $("body").data("user") == "moderator"){
					
					//$(".errorAddChangeUsersCont").show('','',hideLoadingIcon());	
				}
				else
				{	
					$(".deliveryserviceName").val(a[1][0]['name']);
					$(".deliveryserviceAddress").val(a[1][0]['address']);
					$(".deliveryservicePhone").val(a[1][0]['phone']);
					$(".deliveryserviceEmail").val(a[1][0]['email']);
					$(".deliveryserviceWebsite").val(a[1][0]['website']);
					$(".deliveryserviceWebsiteTrackingLink").val(a[1][0]['deliverytracklink']);
					$(".deliveryserviceImage").val(a[1][0]['img']);
					
					$(".deliveryserviceCode").val(a[1][0]['code']);
					$(".deliveryserviceZip").val(a[1][0]['zip']);
					$(".deliveryserviceCity").val(a[1][0]['city']);
					$(".deliveryserviceSort").val(a[1][0]['sort']);


					//nikola
					var statusid = 0;
					if(a[1][0]['status'] == 0) statusid = 3;
					$("#user_status").val(statusid);
					
					for(var i = 0; i < a[1][2].length; i++)
						{
							var clone = $(".socialItemContTemplate").clone(true);
							
							$(clone).find(".rednibroj").html(i+1);
							$(clone).find(".socialnetwork").html(a[1][2][i].networkname);
							$(clone).find(".socialLink").attr('href', a[1][2][i].link);
							$(clone).find(".deleteSocialItemPartner").attr('currid', a[1][2][i].foreignkey).attr('socialid', a[1][2][i].socialnetworkid);
														
							$(clone).removeClass("socialItemContTemplate").removeClass("hide").addClass("socialItemCont").appendTo($(".socialHolder"));
						}
					
					$(".addSocialItemPartner").attr('currentid', a[1][0]['id']);
					
					$(".loadedusers").attr('usersid', $this.attr("usersid"));
					$(".addChangeUsersCont").show('','',hideLoadingIcon());
				}
			});
		});	
		
    });

	$("#addUsersButton").on("click", function(){
		resetUsersForm();
		$(".selectGroupSelect").each(function(){
			$(this).val("");	
		});
		showCont("addChangeUsersCont");
	});
	
	$("#listUsersButton").on("click", function(){
		showCont("listUsersCont");	
	});
	
	$("#userGroupsButton").on("click", function(){
		showCont("userGroupsCont");	
	});
	
	/* grupe korisnika	*/
	
	$(document).on("click", ".saveGroupItem", function(){
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: {action: "addsavegroup", 
				groupid: $(this).parent().parent().parent().attr("groupid"),
				see: ($(this).parent().parent().find(".addGroupSee").prop("checked")) ? 1 : 0,
				change: ($(this).parent().parent().find(".addGroupChange").prop("checked")) ? 1 : 0,
				add: ($(this).parent().parent().find(".addGroupAdd").prop("checked")) ? 1 : 0,
				activate: ($(this).parent().parent().find(".addGroupActivate").prop("checked")) ? 1 : 0,
				'delete': ($(this).parent().parent().find(".addGroupDelete").prop("checked")) ? 1 : 0,
				name: ''
				}
		}).done(function(result){
			alert("Uspesno snimljeno");
		});			
	});
	
	$(".addNewGroupButton").on("click", function(){
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: {action: "addsavegroup", 
				groupid: '',
				name: $(".addSocialNameInput").val(),
				image: $(".addSocialImageInput").val()
				}
		}).done(function(result){
			alert("Uspesno snimljeno");
			//window.location.reload();
		});		
	});
	
	$(document).on("click", ".deleteSocialNetworkItem", function(){
		var a = confirm("obrisatai?");
		if(a)
		{
			var $this = $(this);
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: {action: "deletegroup", 
					groupid: $(this).parent().parent().parent().attr("groupid")
					}
			}).done(function(result){
				console.log(result);
				$($this).parent().parent().remove();
			});			
		}
	});
	
	$(document).on("click", ".deleteSocialItemPartner", function(){
		var a = confirm("obrisatai?");
		if(a)
		{
			var $this = $(this);
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: {action: "deletesocialitempartner", 
					id: $(this).attr("currid"),
					socialid: $(this).attr('socialid')
					}
			}).done(function(result){
				console.log(result);
				$($this).parent().parent().remove();
			});			
		}
	});
	
	$(".addSocialItemPartner").on("click", function(){
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: {action: "addSocialItemPartner", 
				id: $(this).attr('currentid'),
				socialid: $(".socialNetworkSelect").val(),
				link: $(".addSocialItemLinkPartner").val()
				}
		}).done(function(result){
			alert("Uspesno snimljeno");
			
			var clone = $(".socialItemContTemplate").clone(true);
			
			$(clone).find(".rednibroj").html($(".socialItemCont").length +1);
			$(clone).find(".socialnetwork").html($(".socialNetworkSelect :selected").html());
			$(clone).find(".socialLink").attr('href', $(".addSocialItemLinkPartner").val());
			$(clone).find(".deleteSocialItemPartner").attr('currid', $(this).attr('currentid')).attr('socialid', $(".socialNetworkSelect").val());
										
			$(clone).removeClass("socialItemContTemplate").removeClass("hide").addClass("socialItemCont").appendTo($(".socialHolder"));
			
			$(".socialNetworkSelect").val('');
			$(".addSocialItemLinkPartner").val('');
			//window.location.reload();
		});		
	});
	
});