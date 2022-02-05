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

				$(".pricelistNameInput").val(a.name);
				$(".pricelistDescriptionTextarea").val(a.description);
				
				/*	table start	*/
				$("#pricelistItemsTable").DataTable({
					stateSave: true,
					"processing": true,
					"serverSide": true,
					"ajax":{
							url :"modules/"+moduleName+"/library/getpricelistdata.php", // json datasource
							data: {
								"pricelistid": $(".content-wrapper").attr('currentid')
							},
							type: "post",  // method  , by default get
							error: function(){  // error handling
								$(".employee-grid-error").html("");
								$("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema vesti u bazi</th></tr></tbody>');
								$("#employee-grid_processing").css("display","none");
							},
							dataSrc: function(d){
								//console.log(d);
								
								for(var i = 0; i < d.aaData.length;i++)
								{
									var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
									var bd = "";
									if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
									{
										bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
									}
									d.aaData[i][4] = bd;
									
									var s = '<input type="number" min="0" class="jq_rebateInput" value="'+d.aaData[i][3]+'" id="' + d.aaData[i][99] + '" style="width:60px;" />';
									d.aaData[i][3] = s;				
								}
								return d.aaData;
							}
						},
					"language": {
							"emptyTable":     "No data available in table",
							"info":           "Prikaz _START_ do _END_ od _TOTAL_ cenovnika",
							"infoEmpty":      "Prikaz 0 do 0 od 0 cenovnika",
							"infoFiltered":   "(filtrirano od _MAX_ cenovnika)",
							"infoPostFix":    "",
							"thousands":      ",",
							"lengthMenu":     "Prikazi _MENU_ cenovnika",
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
					}).on('click', '.deleteButton', function () {
							deletePricelistItem_handler($('.content-wrapper').attr('currentid'), $(this).attr('id'));
						});
				/*	table end	*/
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');			
			}
		});
	}
	else{
		$(".pricelistNameInput").val('');
		$(".pricelistDescriptionTextarea").val('');
		
		$(".loadingIcon").addClass("hide");	
		$(".addChangeCont").removeClass('hide');
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
					name: $(".pricelistNameInput").val(),
					description: $(".pricelistDescriptionTextarea").val()
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
					window.location.href = 'pricelist'; 
				}
			}
		});
	}		
}

function addNewPricelistItem(){
	var no_error = true;
	if($('.jq_pricelistAddNewItemInput').val() == ''){
		$('.jq_pricelistAddNewItemInput').parent().addClass('has-error').removeClass('has-success');
		no_error = false;
	}else{
		$('.jq_pricelistAddNewItemInput').parent().removeClass('has-error').addClass('has-success');
	}
	
	if(no_error){
		/*	objecty to pass	 */
		var passdata = {action: "addpricelistitem",
					id: $('.content-wrapper').attr('currentid'),
					code: $(".jq_pricelistAddNewItemInput").val()
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
				if(a['status'] == 'success'){
					$('#pricelistItemsTable').DataTable().ajax.reload(); 
					$('.jq_pricelistAddNewItemInput').val('');
				}
				else if(a['status'] == 'warning' && a['status_code'] == 1){
					alert(a['msg']);
					$("#pricelistItemsTable_filter").find('input[type="search"]').val($(".jq_pricelistAddNewItemInput").val()).trigger('keyup');
					//$('#pricelistItemsTable').DataTable().ajax.reload(); 
					$('.jq_pricelistAddNewItemInput').val('');
				}
				else{
					alert(a['msg']);
				}
				
			}
		});
	}	
}

function savePricelistItemRebate(pricelistid, productid, value){
	/*	objecty to pass	 */
	var passdata = {action: "savepricelistitemrebate",
				pricelistid: pricelistid,
				productid: productid,
				rebate: value
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
			if(a['status'] == 'success'){
				/*	refresh table	*/	
				
				$('#pricelistItemsTable').DataTable().ajax.reload(); 
				$('.jq_pricelistAddNewItemInput').val('');
			}
			else if(a['status'] == 'warning' && a['status_code'] == 1){
				/*	add code to table search and refresh	*/
				$('.jq_pricelistAddNewItemInput').val('');
			}
			else{
				alert(a['msg']);
			}
			
		}
	});
}	

function deletePricelistItem_handler(pricelistid, productid){
	var a = confirm("Da li ste sigurni da zelite da obisete zapis?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "deletepricelistitem", 
		  			pricelistid: pricelistid,
					productid: productid }
		}).done(function(result){
			alert("Uspesno obrisano!");
			$('#pricelistItemsTable').DataTable().ajax.reload(); 
		});		
	}	
}