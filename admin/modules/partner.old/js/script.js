function resetForm(){
	$(".addChangeCont").find("input").each(function(){
		$(this).val("");
		$(".loaded").attr('id', "");
		for(var i in CKEDITOR.instances)
		{
			CKEDITOR.instances[i].setData('')
		}
		$('input[name=bannerside]:checked').prop('checked', false)	
	});	
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
function populatePartnerTypeInput(){
	$.ajax({
			type:"POST",
			async: false,
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getpartnertype' }),
			error:function(XMLHttpRequest, textStatus, errorThrown){
				alert("Došlo je do greške!!! PAType_GET_001!!!");                           
			},
			success:function(response){
				var a = JSON.parse(response);
				var availablePartnerTypes = [];
				for(var i = 0; i < a.length; i++){
					//alert(a[i].partnertype);
					availablePartnerTypes.push(a[i].partnertype);
				}
				$(".partnerType").autocomplete({
					source: availablePartnerTypes
				});
			
		}
	});	
}

function populatePartnerCityInput(){
	$.ajax({
						type:"POST",
						async: false,
						url:"modules/"+moduleName+"/library/functions.php",
						data: ({action : 'getpartnercity' }),
						error:function(XMLHttpRequest, textStatus, errorThrown){
							alert("Došlo je do greške!!! PACity_GET_001!!!");                           
						},
						success:function(response){
							var a = JSON.parse(response);
							var availablePartnerCitys = [];
							for(var i = 0; i < a.length; i++){
								//alert(a[i].partnertype);
								availablePartnerCitys.push(a[i].partnercity);
							}
							$(".partnerCity").autocomplete({
   		 						source: availablePartnerCitys
  							});
						
					}
				});	
}



$(document).ready(function(e) {
	
	populatePartnerTypeInput();
	populatePartnerCityInput();

	$("#partnerListTable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#partnerListTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" ))
						{
							var inp = '<div class="input-group">';
							inp += '<input type="number" class="form-control sort" min="0" id="'+d.aaData[i][99]+'" value="'+d.aaData[i][6]+'" >';
							inp += '</div>';
							
							d.aaData[i][6] = inp;
							
							if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
							{
								var sel = '<select class="form-control selectStatus background-'+d.aaData[i][7]+'" id="'+d.aaData[i][99]+'" currentStatus="'+d.aaData[i][7]+'">';
								sel += '<option value="y" '; if(d.aaData[i][7] == "y") sel +=  " selected "; sel += '>Aktivan</option>';	
								sel += '<option value="n" '; if(d.aaData[i][7] == "n") sel +=  " selected "; sel += '>Neaktivan</option>';	
								sel += 	'</select>';	
							}else{
								var sel = '<select class="form-control selectStatus" disabled="disabled">';
								sel += '<option value="y" '; if(d.aaData[i][7] == "y") sel +=  " selected "; sel += '>Aktivan</option>';	
								sel += '<option value="n" '; if(d.aaData[i][7] == "n") sel +=  " selected "; sel += '>Neaktivan</option>';	
								sel += 	'</select>';	
							}
							
							d.aaData[i][7] = sel;
						}else{
							d.aaData[i][6] = "";
							d.aaData[i][7] = "";
						}	
						
						var bc = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						}
						var bd = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obriši</button> ';
						}
						d.aaData[i][8] = bc + bd;
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ partnera",
				"infoEmpty":      "Prikaz 0 do 0 od 0 partnera",
				"infoFiltered":   "(filtrirano od _MAX_ partnera)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ partnera",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
	
	$('#partnerListTable tbody').on('click', '.deleteButton',  function () {
      	var $this = $(this);
      	//var a = await showDialog('warning','Da li ste sigurni da zelite da obisete partnera?','mrYesNo');
		var a = confirm("Da li ste sigurni da zelite da obisete partnera?");
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
    }).on('click', '.changeViewButton', function () {
      	window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
		
    }).on('change', '.selectStatus', function () {
      	showLoadingIcon();
		$this = $(this);
		if($(this).attr("currentStatus") != $(this).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changestatus", id: $this.attr("id"), status:$(this).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				
				hideLoadingIcon();
			});
			
		}
    }).on('change', '.sort', function () {
      	showLoadingIcon();
		$this = $(this);
		if($(this).attr("currentSort") != $(this).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changesort", id: $this.attr("id"), sort:$(this).val() }
			}).done(function(result){
				hideLoadingIcon();
			});
			
		}
    });

	
	$("#addButton").on("click", function(){
		window.location.href = window.location.pathname+'/add';
	});

	
	
	$("#listButton").on("click",  function(){
		//var i =  showDialog('info','TEst PRIMER','mrYesNo');
		//alert(i);

		window.location.href = 'partner';		
	});
	
	
	if($(".content-wrapper").attr('currentview') == 'change'){
		createAddChangeForm();	
		
		$(".savePartnerInfo").on('click', function(){
			showLoadingIcon();
			savePartnerInfo();
		});
		
		$(".addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
	}

	
	if($(".content-wrapper").attr('currentview') == 'add'){
		createAddChangeForm();	
		
		$(".savePartnerInfo").on('click', function(){
			showLoadingIcon();
			savePartnerInfo();
		});
	}
	//PARTNER APPLICATIONS ##############################################################################################################
	$("#partnerApplicationsButton").on("click", function(){
		window.location.href = window.location.pathname+'/applications';
	});
	if($(".content-wrapper").attr('currentview') == 'applications'){
		createPartnerApplicationsForm();
	}
	//PARTNER APPLICATIONS END ##########################################################################################################
	//PARTNER ADDRESS ###################################################################################################################
	$(".addPartnerAddressBTN").on("click", function(){
		
		$(".partneraddressAddChangeLabel").text('Novi unos');
		$(".addPartnerAddressBTN").addClass('hide');
		$(".addPartnerAddressCont").removeClass('hide');	
	});


	$(".savePartnerAddressBTN").on("click", function(){
		savePartnerAddress();
		
		
	});


	$(".closePartnerAddressCont").on("click", function(){
		clearAddChangePartnerAddress();
		$(".addPartnerAddressCont").attr('partneraddressid','');
		$(".addPartnerAddressCont").addClass('hide');
		//Clear add inputs
		$(".addPartnerAddressBTN").removeClass('hide');	
	});

	//PARTNER ADDRESS END ###############################################################################################################
	//PARTNER CONTACT ###################################################################################################################
	$(".addPartnerContactBTN").on("click", function(){
		
		$(".partnercontactAddChangeLabel").text('Novi unos');
		$(".addPartnerContactBTN").addClass('hide');
		$(".addPartnerContactCont").removeClass('hide');	
	});


	$(".savePartnerContactBTN").on("click", function(){
		savePartnerContact();
	});


	$(".closePartnerContactCont").on("click", function(){
		clearAddChangePartnerContact();
		$(".addPartnerContactCont").attr('partnercontactid','');
		$(".addPartnerContactCont").addClass('hide');
		//Clear add inputs
		$(".addPartnerContactBTN").removeClass('hide');	
	});

	//PARTNER CONTACT END ###############################################################################################################
	//PARTNER DOCUMENTS #################################################################################################################
	$(".partnerDocumentsFilterBTN").on("click", function(){

		filterPartnerDocuments();
		//savePartnerContact();
	});
	
	//PARTNER DOCUMENTS END #############################################################################################################
	//PARTNER TRANSACTIONS ##############################################################################################################
	$(".partnerTransactionsFilterBTN").on("click", function(){

		filterPartnerTransactions();
		//savePartnerContact();
	});
	
	//PARTNER TRANSACTIONS END ##########################################################################################################
	//PARTNER CATEGORY REBATE ###################################################################################################################
	$(".addPartnerCategoryRebateBTN").on("click", function(){
		
		$(".partnercategoryrebateAddChangeLabel").text('Novi unos');
		$(".addPartnerCategoryRebateBTN").addClass('hide');
		$(".addPartnerCategoryRebateCont").removeClass('hide');	
	});


	$(".savePartnerCategoryRebateBTN").on("click", function(){
		savePartnerCategoryRebate();		
	});

	$(".closePartnerCategoryRebateCont").on("click", function(){
		//clearAddChangePartnerCategoryRebate();
		$(".addPartnerCategoryRebateCont").attr('partnercategoryrebateid','');
		$(".addPartnerCategoryRebateCont").addClass('hide');
		//Clear add inputs
		$(".addPartnerCategoryRebateBTN").removeClass('hide');	
	});
	$('.partnerCategoryRebate').on('blur', function(){
		if($(this).val() > 100){
			$(this).val(100);	
		}
		if($(this).val() < 0){
			$(this).val(0);	
		}
	});

	//PARTNER CATEGORY REBATE END ###############################################################################################################
	//PARTNER PRICELIST ###################################################################################################################
	
	$('.savePartnerPricelistBTN').on('click', function(){
		savePartnerPricelist();
	});
	
	$('.jq_partnerPricelistRemoveButton').on('click', function(){
		partnerPricelistRemove();
	});
	
	//PARTNER PRICELIST END ###################################################################################################################
});