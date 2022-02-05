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

function createAddChangeForm_Attrval(){
	$("#listtable_attrval").DataTable({
		"stateSave": true,
		"paging":true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata_attrval.php", // json datasource
                type: "post",  // method  , by default get
				data: ({id : $(".content-wrapper").attr('currentid')}),
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{ 
						if(d.aaData[i][98] != '0')
						{
							var badd = '<button class="btn btn-warning addLocalAttrvalButton" id="'+d.aaData[i][99]+'">Dodaj vrednost atributa u lokalne</button> '
							d.aaData[i][3] =  badd;
						}else{
							d.aaData[i][2] = "";
						}	
						
						
						/*if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
						{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-'+d.aaData[i][3]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][3]);
							$(clone).find("option[value='"+d.aaData[i][3]+"']").attr('selected', 'selected');
						}else{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').attr('disabled','disabled');
							$(clone).find("option[value='"+d.aaData[i][3]+"']").attr('selected', 'selected');
						}	
						d.aaData[i][3] = $(clone).wrap('<div>').parent().html();				
						*/
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ učitani vrednosti atributi",
				"infoEmpty":      "Prikaz 0 do 0 od 0 Učitanih vrednosti atributa",
				"infoFiltered":   "(filtrirano od _MAX_ Učitanih vrednosti atributa)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ Učitanih vrednosti atributa",
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
		$(".loadingIcon").addClass("hide");	
		$(".addChangeCont").removeClass('hide');
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
	if($('.langGroupCont[defaultlang="y"]').find(".cityNameInput").val() == "")
	{
		$('.cityNameCont').addClass("has-error");
		noerror = false;
	}
	if($('.citycoordinates').val() == "")
	{
		$('.citycoordinates').parent().addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					id: id,
					coordinates : $('.citycoordinates').val(),
					values : [] 
					};
					
		$(".langGroupCont:not(.langGroupContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				name : $(this).find('.cityNameInput').val()
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
					window.location.href = 'city';
				}
			}
		});
	}		
}

function updateLocalAttr(elem){
	var localattrid = $(elem).val();
	var id = $(elem).parents('tr').find('.changeViewButton').attr('id');
	
	/*	objecty to pass	 */
	var passdata = {action: "updatelocalattr",
					id: id,
					localattrid : localattrid
					};
	
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);
				
			if(a['status'] == "success")
			{
				alert('Uspešno snimljeno!');
				
			}
			else{
				alert("Greška prilikom snimanja!");
			}
		}
	});
}

function addLocalAttr(elem){
	var id = $(elem).attr('id');
	
	/*	objecty to pass	 */
	var passdata = {action: "addlocalattr",
					id: id
					};
	
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);
			if(a['status'] == "success")
			{
				alert(a['message']);
				window.location.reload();	
			}else{
				alert(a['message']);	
			}
			
		}
	});
}

function updateLocalAttrval(elem){
	var localattrvalid = $(elem).val();
	var id = $(elem).parents('tr').find('.addLocalAttrvalButton').attr('id');
	
	/*	objecty to pass	 */
	var passdata = {action: "updatelocalattrval",
					id: id,
					localattrvalid : localattrvalid
					};
	
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);
				
			if(a['status'] == "success")
			{
				alert('Uspešno snimljeno!');
			}
			else{
				alert("Greška prilikom snimanja!");
			}
		}
	});
}

function addLocalAttrval(elem){
	var id = $(elem).attr('id');
	
	/*	objecty to pass	 */
	var passdata = {action: "addlocalattrval",
					id: id
					};
	
	$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: (passdata),
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert("ERROR");                            
		},
		success:function(response){
			var a = JSON.parse(response);
			if(a['status'] == "success")
			{
				alert(a['message']);
				window.location.reload();	
			}else{
				alert(a['message']);	
			}
			
		}
	});
}