function resetForm(){
		
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	
	if($( "#listtable" ).length > 0)
	{
		var searcDT = $("#listtable").not('.initialized').addClass('initialized').DataTable({
			stateSave: true,
			"processing": true,
			"serverSide": true,
			"ajax":{
					url :"modules/"+moduleName+"/library/getdata.php", // json datasource
					type: "post",  // method  , by default get
					"data"   : function( d ) {
						if(localStorage.getItem('Datetable_fiter_coneccted') != null) $('.jq_connectedBrendSearchCont').val(localStorage.getItem('Datetable_fiter_coneccted'));
						d.connected = $('.jq_connectedBrendSearchCont').val();
						if(localStorage.getItem('Datetable_fiter_supplier') != null) $('.jq_supplierSearchCont').val(localStorage.getItem('Datetable_fiter_supplier'));
						d.supplier = $('.jq_supplierSearchCont').val();
					},
					error: function(){  // error handling
						$(".employee-grid-error").html("");
						$("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema vesti u bazi</th></tr></tbody>');
						$("#employee-grid_processing").css("display","none");
					},
					dataSrc: function(d){
						//console.log(d);
						if(localStorage.getItem('Datetable_fiter_coneccted') != null){
							$('.jq_connectedAttrSearchCont').val(localStorage.getItem('Datetable_fiter_coneccted'));
						}
						if(localStorage.getItem('Datetable_fiter_supplier') != null){
							$('.jq_supplierSearchCont').val(localStorage.getItem('Datetable_fiter_supplier'));
						}
						
						for(var i = 0; i < d.aaData.length;i++)
						{ 
							
							var bd = "";
							/*if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
							{
								bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
							}*/
							var badd = '<button class="btn btn-warning addLocalBrendButton" id="'+d.aaData[i][99]+'">Dodaj brend u lokalne</button> '
							d.aaData[i][3] =  bd + badd;
							
							
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
					"info":           "Prikaz _START_ do _END_ od _TOTAL_ učitanih brendova",
					"infoEmpty":      "Prikaz 0 do 0 od 0 Učitanih brendova",
					"infoFiltered":   "(filtrirano od _MAX_ Učitanih brendova)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "Prikazi _MENU_ Učitanih brendova",
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
	}
		$('#listtable tbody').on('click', '.deleteButton', function () {
			deleteItem_handler($(this));
		}).on('change', '.selectStatus', function () {
			showLoadingIcon();
			changestatus_handler($(this));
		}).on('click', '.changeViewButton', function () {
			window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
		});
		
		
		$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
		
		$("#listButton").on("click", function(){
			window.location.href = 'brendexternal';
		});

		if($(".content-wrapper").attr('currentview') == 'change'){
			createAddChangeForm_Attrval();	
			
			/*
			$(".saveAddChange").on('click', function(){
					showLoadingIcon();
					saveAddChange();
			});
			*/
			
			$(".addButton").on("click", function(){
				window.location.href = window.location.pathname+'/add';
			});
		}
		
		if($(".content-wrapper").attr('currentview') == 'add'){
			createAddChangeForm_Attrval();	
			
			$(".saveAddChange").on('click', function(){
				showLoadingIcon();
				saveAddChange();
			});
		}
		
		/*	change local attr */
		
		$(document).on("change", ".jq_localBrendSelect", function(){
			updateLocalBrend($(this));			
		});
		
		/*	all local atribute	*/	
		
		$(document).on('click', ".addLocalBrendButton", function(){
			if(confirm("Da li ste sigurni?")){
				addLocalBrend($(this));	
			}
		});
		
		
		/*	SEARCH	*/
		
		$(".jq_connectedBrendSearchCont").on("change", function(){		
			if($('#listtable').hasClass('initialized'))
			{
				localStorage.setItem('Datetable_fiter_coneccted', $('.jq_connectedBrendSearchCont').val());
				searcDT.ajax.reload()
			}
		});
		
		$(".jq_supplierSearchCont").on("change", function(){		
			if($('#listtable').hasClass('initialized'))
			{
				localStorage.setItem('Datetable_fiter_supplier', $('.jq_supplierSearchCont').val());
				searcDT.ajax.reload()
			}
		});
		
		$(document).on('mouseover','.jq_localBrendSelect', function(){
			$(this).select2();
		});
		
});