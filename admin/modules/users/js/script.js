function resetUsersForm(){
	$(".usersName").val('');
	$(".usersSurname").val('');
	$(".usersUsername").val('');
	$(".usersEmail").val('');
	$(".usersPicture").val('');
	$(".loadedusers").attr('usersid','');
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
function showCont(classname){
	showLoadingIcon();
	$(".errorAddChangeUsersCont").hide('','',hideLoadingIcon());
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
		
		var data = [];
		$(".privilagesCont").find(".privilagesModuleItem").each(function(){
			var $this = $(this);
			data.push({
					modulid: $($this).attr("moduleid"),
					groupid: $($this).find(".selectGroupSelect").val()
				})
		});
		var smp = $(".usersSelectDefaultLang").val();
		if($(".usersSelectDefaultLang").val()!='' && $(".usersSelectDefaultLang").val()!=0 && $(".usersSelectDefaultLang").val()!='0'){
			$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "saveusers",
					usersid: usersid,
					name: $(".usersName").val(),
					surname: $(".usersSurname").val(),
					username: $(".usersUsername").val(),
					email: $(".usersEmail").val(),
					address: $(".usersAddress").val(),
					city: $(".usersCity").val(),
					zip: $(".usersZip").val(),
					phone: $(".usersPhone").val(),
					mobile: $(".usersMobile").val(),
					picture: $(".usersPicture").val(),
					birthday: $(".usersBirthday").val(),
					type: $(".usersType").val(),
					partnerid: $(".partnerSelect").val(),
					default_langid: $(".usersSelectDefaultLang").val(),
					up: data
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				if(response == 1) {alert("Uspesno dodat korisnik"); document.location.reload();}
				else if(response == 2) {alert("Uspesno snimljena podesavanja za korisnika"); document.location.reload(); }
				else alert(response);
			}
		});

		} else {
			alert('Niste odabrali primarni jezik.')
		}
		
	});
	
	$("#example1").DataTable({
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
    }).on('click', '.changeUsersButton', function () {
      	showLoadingIcon();
		$(".errorAddChangeUsersCont").hide('','',hideLoadingIcon());
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
					
					$(".errorAddChangeUsersCont").show('','',hideLoadingIcon());	
				}
				else
				{	
					$(".usersName").val(a[1][0]['name']);
					$(".usersSurname").val(a[1][0]['surname']);
					$(".usersUsername").val(a[1][0]['username']);
					$(".usersEmail").val(a[1][0]['email']);
					$(".usersPicture").val(a[1][0]['picture']);
					if((a[1][0]['picture']).length > 0) {
						$(".usersHeaderUsersPicture").attr('src','../../'+a[1][0]['picture']);
					} else {
						$(".usersHeaderUsersPicture").attr('src','../../fajlovi/noimg.png');
					}
					$(".usersHeaderUsersName").text(a[1][0]['name'] + ' '+ a[1][0]['surname']);
					$(".usersAddress").val(a[1][0]['address']);
					$(".usersCity").val(a[1][0]['city']);
					$(".usersZip").val(a[1][0]['zip']);
					$(".usersPhone").val(a[1][0]['phone']);
					$(".usersMobile").val(a[1][0]['mobile']);
					$(".usersType").val(a[1][0]['type']);
					//alert(a[1][0]['birthday']);
					$(".usersBirthday").val(a[1][0]['birthday']).datepicker({ format: "dd.mm.yyyy"});
					//console.log(new Date((new Date(a[1][0]['birthday']).toShortFormat())));
					//$(".usersBirthday").val(new Date(a[1][0]['birthday']));
					$(".partnerSelect").val(a[1][0]['partnerid']);
					$(".usersSelectDefaultLang").val(a[1][0]['default_langid']);

					//nikola
					var statusid = 0;
					if(a[1][0]['status'] == 0) statusid = 3;
					$("#user_status").val(statusid);
					
					if(a[1][0]['status'] < 3){
						$("#userActivate").html('Aktiviraj korisnika');
					}else{
						$("#userActivate").html('Deaktiviraj korisnika');
					}
					//nikola

					$(".privilagesCont").html('');
					if($("body").attr("user") == "admin")
					{
						for(var i = 0; i < a[1][1].length; i++)
						{
							var clone = $(".privilagesModuleTemplate").clone(true);
							
							$(clone).find(".selectGroupSelect").val(a[1][1][i].groupid);
														
							$(clone).attr("moduleid", a[1][1][i].mid).find(".moduleLabel").html(a[1][1][i].showname);
							$(clone).removeClass("privilagesModuleTemplate").removeClass("hide").addClass("privilagesModuleItem").appendTo($(".privilagesCont"));
						}
					}
					
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
				see: ($(this).parent().parent().find(".addGroupSee").prop("checked")) ? 1 : 0,
				change: ($(this).parent().parent().find(".addChange").prop("checked")) ? 1 : 0,
				add: ($(this).parent().parent().find(".addGroupAdd").prop("checked")) ? 1 : 0,
				activate: ($(this).parent().parent().find(".addGroupActivate").prop("checked")) ? 1 : 0,
				'delete': ($(this).parent().parent().find(".addGroupDelete").prop("checked")) ? 1 : 0,
				name: $(".addGroupNameInput").val()
				}
		}).done(function(result){
			alert("Uspesno snimljeno");
			window.location.reload();
		});		
	});
	
	$(document).on("click", ".deleteGroupItem", function(){
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
	
	$(document).on('click', ".jq_userSendNewPasswordButton", function(){
		$('.jq_userSendNewPasswordButton').attr('disabled', true).find('i').removeClass('hide');	
		var a = confirm("Da li ste sigurni?");
		if(a)
		{
			var $this = $(this);
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: {action: "sendnewpassword", 
						id : $(".loadedusers").attr('usersid')
					}
			}).success(function(result){
				var a = JSON.parse(result);
				if(a['status'] == "success"){
					alert(a['msg']);	
					$('.jq_userSendNewPasswordButton').attr('disabled', false).find('i').addClass('hide');	
				}else{
					alert(a['msg']);		
					$('.jq_userSendNewPasswordButton').attr('disabled', false).find('i').addClass('hide');	
				}
				
			});			
		}
	});

	$(document).on('click', ".jq_userChangePasswordButton", function(){
		$('.jq_userChangePasswordButton').attr('disabled', true);
		var userid = $(".loadedusers").attr('usersid')
		$('.changUsersPasswordCont').removeClass('hide').attr('userid',userid);
	});

	$(document).on('click', ".closeUsersChangePasswordCont", function(){
		$('.jq_userChangePasswordButton').attr('disabled', false);
		$('.changUsersPasswordCont').addClass('hide').attr('userid','0');
		$('.usersNewPassword').val('');
		$('.usersRepeatNewPassword').val('');
	});

	$(document).on('click', ".saveUsersChangePasswordBTN", function(){
		var userid = $(".changUsersPasswordCont").attr('userid');
		var newpass = $('.usersNewPassword').val();
		var newrepeatpass = $('.usersRepeatNewPassword').val();

		if(newpass.length>=8 && newrepeatpass.length>=8 && newpass==newrepeatpass && userid>0){
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: {action: "changepassword", 
						userid :userid,
						newpass:newpass,
						newrepeatpass:newrepeatpass
					}
			}).success(function(result){
				var a = JSON.parse(result);
				if(a['status'] == "success"){
					alert(a['msg']);	
					//$('.jq_userSendNewPasswordButton').attr('disabled', false).find('i').addClass('hide');	
				}else{
					alert(a['msg']);		
					//$('.jq_userSendNewPasswordButton').attr('disabled', false).find('i').addClass('hide');	
				}
				
			});		
		} else {
			if(newpass.length<8 && newrepeatpass.length<8){
				alert('Šifra treba da sadrži minimum 8 karaktera!');
			} else if(newpass!=newrepeatpass){
				alert('Uneta šifra nije ista u unetim poljima!');
			} else {
				alert('Došlo je do greške.');
			}
		}
	});
	
});