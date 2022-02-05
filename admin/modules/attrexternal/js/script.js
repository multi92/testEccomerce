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
						if(localStorage.getItem('Datetable_fiter_coneccted') != null) $('.jq_connectedAttrSearchCont').val(localStorage.getItem('Datetable_fiter_coneccted'));
						d.connected = $('.jq_connectedAttrSearchCont').val();
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
							var bc = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
							if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
							{
								var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
							}
							var bd = "";
							/*if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
							{
								bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
							}*/
							var badd = '<button class="btn btn-warning addLocalAttrButton" id="'+d.aaData[i][99]+'">Dodaj atribut u lokalne</button> '
							d.aaData[i][3] = bc + bd + badd;
							
							
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
					"info":           "Prikaz _START_ do _END_ od _TOTAL_ učitani atributi",
					"infoEmpty":      "Prikaz 0 do 0 od 0 Učitanih atributa",
					"infoFiltered":   "(filtrirano od _MAX_ Učitanih atributa)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "Prikazi _MENU_ Učitanih atributa",
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
			window.location.href = 'attrexternal';
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
		
		$(document).on("change", ".jq_localAttrSelect", function(){
			updateLocalAttr($(this));			
		});
		
		/*	all local atribute	*/	
		
		$(document).on('click', ".addLocalAttrButton", function(){
			if(confirm("Da li ste sigurni?")){
				addLocalAttr($(this));	
			}
		});
		
		/*	change local attrval */
		
		$(document).on("change", ".jq_localAttrvalSelect", function(){
			updateLocalAttrval($(this));			
		});
		
		/*	all local atribute val	*/	
		
		$(document).on('click', ".addLocalAttrvalButton", function(){
			if(confirm("Da li ste sigurni?")){
				addLocalAttrval($(this));	
			}
		});
		
		/*	SEARCH	*/
		
		$(".jq_connectedAttrSearchCont").on("change", function(){		
			if($('#listtable').hasClass('initialized'))
			{
				localStorage.setItem('Datetable_fiter_coneccted', $('.jq_connectedAttrSearchCont').val());
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
		
		$(document).on('mouseover','.jq_localAttrSelect', function(){
			$(this).select2();
		});
		
		$(document).on('mouseover','.jq_localAttrvalSelect', function(){
			$(this).select2();
		});
		
		
});