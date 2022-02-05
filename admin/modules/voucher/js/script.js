function resetForm(){
		
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	

	$(".jq_newVoucherExpirationDate").datepicker({ format: "dd.mm.yyyy"});
	$(".voucherExipratinDateInput").datepicker({ format: "dd.mm.yyyy"});
	$(".newCategoryId").select2();

	
	$(".newUserId").select2();


	$(".newProductId").select2({
		

					/*ajax:{
						url:"modules/"+moduleName+"/library/functions.php",
						data : "action=getproduct&searchval="+$(".newProductId").val(),
						processResults: function (data) {
    					  // Transforms the top-level key of the response object from 'items' to 'results'
    					  return {
    					    results: data.items
    					  };
    					}
					}*/
					ajax: { 
					   url: "modules/"+moduleName+"/library/searchproducts.php",
					   type: "post",
					   dataType: 'json',
					   delay: 250,
					   data: function (params) {
					    return {
					      searchTerm: params.term // search term
					    };
					   },
					   processResults: function (response) {
					     return {
					        results: response
					     };
					   },
					   cache: true
					  }
					

	});


	hideLoadingIcon();
	$("#listtable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".listtable-grid-error").html("");
                    $("#listtable").append('<tbody class="listtable-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
                    $("#listtable-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
						{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-'+d.aaData[i][6]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][6]);
							$(clone).find("option[value='"+d.aaData[i][6]+"']").attr('selected', 'selected');
						}else{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').attr('disabled', 'disabled');
							$(clone).find("option[value='"+d.aaData[i][6]+"']").attr('selected', 'selected');
						}	
						d.aaData[i][6] = $(clone).wrap('<div>').parent().html();
						
						
						var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						var bd = "";
						if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
						{   
							if(d.aaData[i][8]==1){
								bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obriši</button> ';
							}
						}
						d.aaData[i][8] =  bc + bd;
						
						
						
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ podataka",
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
		
		$('#listtable tbody').on('click', '.deleteButton', function () {
			deleteItem_handler($(this));
		}).on('change', '.selectStatus', function () {
			showLoadingIcon();
			changestatus_handler($(this));
		}).on('click', '.changeViewButton', function () {
			window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
		});
		
		/*$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});*/

		$("#listvouchertable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getUserVoucher.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".listvouchertable-grid-error").html("");
                    $("#listvouchertable").append('<tbody class="listvouchertable-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
                    $("#listvouchertable-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					//console.log(d.aaData);

					for(var i = 0; i < d.aaData.length;i++)
					{
						
						//var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						//var bd = "";
						//if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
						//{   
						//	if(d.aaData[i][6]==1){
						//		bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obriši</button> ';
						//	}
						//}
						//d.aaData[i][6] =  bc + bd;
						if(d.aaData[i][97]=="0"){
							d.aaData[i][5] = "Nije iskorišćen";
						}
						
						
						
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ podataka",
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
		
		$("#listButton").on("click", function(){
			window.location.href = 'voucher';
		});
		

		if($(".content-wrapper").attr('currentview') == 'change'){
			createAddChangeForm();	
			
			$(".saveAddChange").on('click', function(){
					showLoadingIcon();
					saveAddChange();
			});
			
			$(".addButton").on("click", function(){
				window.location.href = window.location.pathname+'/add';
			});
		}
		
		if($(".content-wrapper").attr('currentview') == 'add'){
			createAddChangeForm();	
			
			$(".saveAddChange").on('click', function(){
				showLoadingIcon();
				saveAddChange();
			});
		}
	
		$('.jq_addNewVoucherButton').on('click', function(){
			addNewVoucherCode();
		});

		$('.jq_addNewUserVoucherButton').on('click', function(){
			addNewUserVoucher();
		});


		$('.addCategory').on('click', function(){
			var currentid =$(".content-wrapper").attr('currentid');
			if(currentid>0){
				var categoryid = $('.newCategoryId').val();
				var value = $('.newCategoryValue').val();
				var valuetype = $('.jq_newVoucherTypeDiscountCategory').val();
				if(categoryid>0 && value>0){
					var passdata = {action: "addVoucherCategory",
					voucherid: currentid,
					categoryid: categoryid,
					value: value,
					valuetype: valuetype		
					};

					$.ajax({
						type:"POST",
						url:"modules/"+moduleName+"/library/functions.php",
						data: (passdata),
						error:function(XMLHttpRequest, textStatus, errorThrown){
						  alert("ERROR");                            
						},
						success:function(response){
							$("#tableVoucherCategory").DataTable().ajax.reload();					
						}
					});

				}
			}
			
		});

		$('.addProduct').on('click', function(){
			var currentid =$(".content-wrapper").attr('currentid');
			if(currentid>0){
				var productid = $('.newProductId').val();
				var value = $('.newProductValue').val();
				var valuetype = $('.jq_newVoucherTypeDiscountProduct').val();
				if(productid>0 && value>0){
					var passdata = {action: "addVoucherProduct",
					voucherid: currentid,
					productid: productid,
					value: value,
					valuetype: valuetype	
					};

					$.ajax({
						type:"POST",
						url:"modules/"+moduleName+"/library/functions.php",
						data: (passdata),
						error:function(XMLHttpRequest, textStatus, errorThrown){
						  alert("ERROR");                            
						},
						success:function(response){
							$("#tableVoucherProduct").DataTable().ajax.reload();					
						}
					});
					
				}
			}
		});


		if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			/*TABLE PROMO CODE CATEGORY*/
			$("#tableVoucherCategory").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getVoucherCategory', voucherid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableVoucherCategory-grid-error").html("");
        		            $("#tableVoucherCategory").append('<tbody class="tableVoucherCategory-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableVoucherCategory-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								
								/*if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectProductFileStatusTemplate").clone(true).removeClass('hide').removeClass('selectProductFileStatusTemplate').addClass('background-status-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]);
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectProductFileStatusTemplate").clone(true).removeClass('hide').removeClass('.selectProductFileStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][4] = $(clone).wrap('<div>').parent().html();	
*/
								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deletevouchercategory" voucherid="'+d.aaData[i][99]+'" categoryid="'+d.aaData[i][98]+'" style="width:80px;">Obriši</button> ';
								}
								d.aaData[i][5] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);
			/*TABLE PROMO CODE CATEGORY END*/
			/*TABLE PROMO CODE PRODUCT*/
			$("#tableVoucherProduct").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getVoucherProduct', voucherid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableVoucherProduct-grid-error").html("");
        		            $("#tableVoucherProduct").append('<tbody class="tableVoucherProduct-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableVoucherProduct-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							console.log(d.aaData);
							for(var i = 0; i < d.aaData.length;i++)
							{
								
								/*if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectProductFileStatusTemplate").clone(true).removeClass('hide').removeClass('selectProductFileStatusTemplate').addClass('background-status-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]);
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectProductFileStatusTemplate").clone(true).removeClass('hide').removeClass('.selectProductFileStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][4] = $(clone).wrap('<div>').parent().html();	
*/
								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deletevoucherproduct" voucherid="'+d.aaData[i][99]+'" productid="'+d.aaData[i][98]+'" style="width:80px;">Obriši</button> ';
								}
								console.log(d.aaData[i][8]);
								d.aaData[i][8] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);
			/*TABLE PROMO CODE PRODUCT END*/



		}
		}

		$('#tableVoucherCategory tbody').on('click', '.deletevouchercategory', function () {
			deleteVoucherCategory_handler($(this));
    	});

    	$('#tableVoucherProduct tbody').on('click', '.deletevoucherproduct', function () {
			deleteVoucherProduct_handler($(this));
    	});
		
		
});