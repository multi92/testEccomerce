function getMessageList(page, type, srch){
	
	if (typeof(srch)==='undefined') srch = "";
	
	$(".showMessageCont").addClass("hide");	
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: ({action: "getmessageslist",
				searchvalue : "",
				messagetype : type,
				limit : "",
				srch: srch,
				page : page
				}),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);
			if(a[1] == 0)
			{
				$(".mailbox-messages-cont").html('<div class="alert alert-warning alert-dismissable"><h4><i class="icon fa fa-warning"></i> Nema poruka za zadati kriterijum!</h4></div>');
				
			}
			else
			{
				$(".mailbox-messages-cont").html("");
				for(var i = 0; i < a[2].length; i++)
				{
					var clone = $(".messageTemplate").clone(true);
					
					$(clone).attr("messageid", a[2][i][99]);	
					
					var bold = '';
					if(a[2][i][7] == 1 || a[2][i][4] == "n") bold = 'bold';
					/*var color = "";
					if(a[2][i][4] == 'n') color = "#f56954";
					if(a[2][i][4] == 'r') color = "#00c0ef";
					if(a[2][i][4] == 'a') color = "#00a65a";
					if(a[2][i][4] == 'p') color = "#f39c12";*/
					
					
					$(clone).css("font-weight", bold);
					
					var printbtn = $(document.createElement("button")).addClass("btn").addClass("btn-primary").addClass("btn-sm").addClass("openmodal").attr("msgid", a[2][i][99]);
					$(document.createElement("i")).addClass("fa").addClass("fa-print").attr("aria-hidden", "true").appendTo($(printbtn));
					
					var printbtn2 = $(document.createElement("button")).addClass("btn").addClass("btn-warning").addClass("btn-sm").addClass("openmodal2").attr("msgid", a[2][i][99]);
					$(document.createElement("i")).addClass("fa").addClass("fa-print").attr("aria-hidden", "true").appendTo($(printbtn2));
					
					if(a[2][i][3] == "dostupnost"){
						$(clone).find(".mailbox-color").append($(printbtn));
					}
					if(a[2][i][3] == "pretraga"){
						$(clone).find(".mailbox-color").append($(printbtn2));
					}
					
					
					$(clone).find(".mailbox-name").html(a[2][i][0]);	
					$(clone).find(".mailbox-subject").html(a[2][i][2]);	
					$(clone).find(".mailbox-type").html(a[2][i][3]);	
					$(clone).find(".mailbox-email").html(a[2][i][1]);	
					$(clone).find(".mailbox-date").html(a[2][i][5]);
					$(clone).removeClass("messageTemplate").removeClass("hide");
					$(clone).appendTo($(".mailbox-messages-cont"));	
					
					$(".navButtonCont").html("");
					var btn = $(document.createElement("button")).addClass("btn").addClass("btn-default").addClass("btn-sm").addClass("navbutton");
					var maxpages = Math.ceil(a[1]/20);

					$($(btn).clone(true)).attr("pageid", 1).html('<i class="fa fa-chevron-left"></i>').appendTo($(".navButtonCont"));	
					
					var tmp = page;
					tmp = tmp - 2;
					if(tmp > 0){
						$($(btn).clone(true)).attr("pageid", tmp).html(tmp).appendTo($(".navButtonCont"));	
					}
					var tmp = page;
					tmp = tmp - 1;
					if(tmp > 0){
						$($(btn).clone(true)).attr("pageid", tmp).html(tmp).appendTo($(".navButtonCont"));	
					}
					var tmp = page;
					tmp = tmp - 0;
					if(tmp > 0){
						$($(btn).clone(true)).attr("pageid", tmp).addClass("active").html(tmp).appendTo($(".navButtonCont"));	
					}
					var tmp = page;
					tmp = tmp + 1;
					if(tmp <= maxpages){
						$($(btn).clone(true)).attr("pageid", tmp).html(tmp).appendTo($(".navButtonCont"));	
					}
					var tmp = page;
					tmp = tmp + 2;
					if(tmp <= maxpages){
						$($(btn).clone(true)).attr("pageid", tmp).html(tmp).appendTo($(".navButtonCont"));	
					}
					
					$($(btn).clone(true)).attr("pageid", maxpages).html('<i class="fa fa-chevron-right"></i>').appendTo($(".navButtonCont"));	
					
				}
			}
		}
	});	
	$(".listAllMessagesCont").removeClass("hide");	
}
function showmessagechain(msgid){
	$(".listAllMessagesCont").addClass("hide");
	
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: ({action: "getmessage",
				msgid : msgid
				}),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);

			if(a[0] == 0)
			{

				$(".showMessageItemCont").html("").attr("firstMessageId", a[1][0][99]);
				if(a[1][0][3] == "pretraga")
				{
					$(document.createElement("h4")).html("Pretraga za rec: "+a[1][0][9]).appendTo($(".showMessageItemCont"));	
				}
				for(var i = 0; i < a[1].length; i++)
				{
					var clone = $(".showMessageItemTemplate").clone(true);
					
					var stat = "";
					/*
					if(a[1][i][4] == "n") stat = "nepročitano";
					if(a[1][i][4] == "r") stat = "pročitano";
					*/
					
					$(clone).find(".showMessageTitle").html(a[1][i][2]);
					$(clone).find(".showMessageFrom").html('Od: ' + a[1][i][0] + ' (' + a[1][i][1] + ')  --  <b>' + stat + '</b> <span class="mailbox-read-time pull-right">'+a[1][i][5]+'</span>');
					$(clone).find(".mailbox-read-message").html(a[1][i][7]);
					
					$(clone).removeClass("showMessageItemTemplate").removeClass("hide").appendTo($(".showMessageItemCont"));					
				}
			}

		}
	});	
	
	$(".showMessageCont").removeClass("hide");	
}
function changestatus(){
		
}

/*	odgovori	*/
function clearOdgovoriForm(){
	$(".valueOdgovori").val("");	
	$(".dataOdgovori").attr("Odgovoriid", "");
	$(".addOdgovoriButton").removeClass("hide");
	$(".saveOdgovoriButton").addClass('hide');
}

function deleteOdgovori_handler(elem){
	if(confirm("Obrisati vrednost?"))
	{
		if($(elem).parent().parent().attr("Odgovoriid") != "")
		{
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deleteOdgovori",
						id: $(elem).parent().parent().attr("odgovoriid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(a[0]);
					if(a[0] == 0){
						alert("Uspesno obrisana vrednost");
					}
					else{
						alert("Greska prilikom brisanja");
					}	
				}
			});
		}
		$(elem).parent().parent().remove();
	}
}
function odgovoriListItem_handler(elem){
	if($(elem).attr("odgovoriid") != "")
	{
		$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "getOdgovori",
						id: $(elem).attr("odgovoriid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0){
						$(".valueOdgovori").attr("odgovoriid", a[1][0]['id']).val(a[1][0]['value']);
						$(".dataOdgovori").attr("odgovoriid", a[1][0]['id'])
						
						$(".addOdgovoriButton").addClass("hide");
						$(".saveOdgovoriButton").removeClass('hide');
					}	
				}
			});		
	}
}
$(document).ready(function(e) {
	getMessageList(1, '');
	
	
	/*	add new odgovori */
	
	$(".addOdgovoriButton").on("click", function(){
		if($(".valueOdgovori").val() != "")
		{
			var datahold = {};
			datahold['value'] = $(".valueOdgovori").val();
			
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addChangeOdgovori",
						id: "",
						data: datahold
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					console.log(a[0]);
					if(a[0] == 0){
						alert("Uspesno dodato");
						document.location.reload();	
					}
					else{
						alert("Greska prilikom dodavanja");
					}	
				}
			});	
		}
	});
	
	/*	toggle odgovori	*/
	
	$("#toggleOdgovori").on("click", function(){
		$(".odgovoriCont").slideToggle(function(){
			clearOdgovoriForm();	
		});
	});
	
	
	$(".deleteOdgovoriButton").on("click", function(){
		deleteOdgovori_handler($(this));
	});
	
	
	/*	odgovori list handlers	*/
	
	$(".odgovoriListItem").on("click", function(){
		odgovoriListItem_handler($(this));	
	});
	
	/*	save odgovori	*/
	
	$(".saveOdgovoriButton").on("click", function(){
		if($(".dataOdgovori").attr("odgovoriid") != "")
		{
			var datahold = {};
			datahold['value'] = $(".valueOdgovori").val();
			
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addChangeOdgovori",
						id: $(".dataOdgovori").attr("odgovoriid"),
						data: datahold
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					console.log(a[0]);
					if(a[0] == 0){
						alert("Uspesno izmenjeno");
						document.location.reload();	
					}
					else{
						alert("Greska prilikom dodavanja");
					}	
				}
			});	
		}
	});
	
	
	
	
	$(document).on("click", ".navbutton", function(){
		getMessageList($(this).attr("pageid"), $(".listAllMessagesCont").attr("messagetype"));
	});
	
	$(document).on("click", ".changetype", function(){
		$(".listAllMessagesCont").attr("messagetype", $(this).attr("msgtype"));
		getMessageList(1, $(this).attr("msgtype"));
	});
	
	$(document).on("click", ".messageListItem", function(){
		showmessagechain($(this).attr("messageid"));	
	});
	
	$(".messageReplayButton").on("click", function(){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "replaymessage",
					parentid : $(".showMessageItemCont").attr("firstMessageId"),
					title: $(".messageReplayInput").val(),
					msg : $(".messageTextareaInput").val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				console.log(a);

				var clone = $(".showMessageItemTemplate").clone(true);
				
				$(clone).find(".showMessageTitle").html($(".messageReplayInput").val());
				$(clone).find(".showMessageFrom").html('Od:  <span class="mailbox-read-time pull-right"></span>');
				$(clone).find(".mailbox-read-message").html($(".messageTextareaInput").val());
				
				$(clone).removeClass("showMessageItemTemplate").removeClass("hide").appendTo($(".showMessageItemCont"));	
					$(".messageReplayInput").val("");
					$(".messageTextareaInput").val("");
	
			}
		});		
	});
	
	setTimeout(function(){
		if(!$(".listAllMessagesCont").hasClass("hide"))
		{
			window.location.reload();	
		}
	}, 180000);
	
	$(".messageOdgovoriSelect").on("change", function(){
		$(".messageTextareaInput").val($(this).find("option:selected").html());	
	});
	
	/*	change status to unread (n)	*/
	
	$(".messageUnreadButton").on("click", function(){
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "changetounread",
					id : $(".showMessageItemCont").attr("firstMessageId")
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				if(a[0] == 1){
					alert("Status promenjen na neprocitano.");	
				}

			}
		});		
	});
	
	/*	print modal	*/
	
	$(document).on("click", ".openmodal", function(e){
		e.stopImmediatePropagation();
		window.open("modules/print.php?msgid="+$(this).attr("msgid"), '', 'left=0,top=0,width=800,height=800,toolbar=0,scrollbars=0,status =0,');
		
	});
	
	/*	print modal 2 - pretraga	*/
	
	$(document).on("click", ".openmodal2", function(e){
		e.stopImmediatePropagation();
		window.open("modules/print2.php?msgid="+$(this).attr("msgid"), '', 'left=0,top=0,width=800,height=800,toolbar=0,scrollbars=0,status =0,');
		
	});
	
	$(".emailSearchInput").on("keyup", function(){
		getMessageList(1, '', $(this).val());
	});
	
});

