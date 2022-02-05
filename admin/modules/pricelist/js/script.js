function resetForm(){
		
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	$("#listtable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
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
						d.aaData[i][5] = bc + bd;
						
						var s = '<input type="number" min="0" class="sortinput " value="'+d.aaData[i][3]+'" id="' + d.aaData[i][99] + '" style="width:60px;" />';
						d.aaData[i][3] = s;
												
						if($("body").attr("user") == "admin")
						{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]);
							$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
							
							d.aaData[i][4] = $(clone).wrap('<div>').parent().html();
						}else{
							d.aaData[i][4] = "";
						}	
										
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
		});
		
		$('#listtable tbody').on('click', '.deleteButton', function () {
			deleteItem_handler($(this));
		}).on('change', '.selectStatus', function () {
			showLoadingIcon();
			changestatus_handler($(this));
		}).on('click', '.changeViewButton', function () {
			window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
		}).on('change', '.sortinput', function () {
			showLoadingIcon();
			$this = $(this);
			$.ajax({
				method: "POST",
				url: "modules/"+moduleName+"/library/functions.php",
				data: {action: "updateshopsort", 
					id: $($this).attr("id"), 
					value: $($this).val()}
			}).done(function (result) {
				$this.removeClass("background-" + $this.attr("currentStatus")).addClass("background-" + $this.val()).attr("currentStatus", $this.val());
				alert("Uspesno izmenjeno");
				hideLoadingIcon();
			});
		});
		
		$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
		
		$("#listButton").on("click", function(){
			window.location.href = 'pricelist';
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
		
		$(".addCategoryFieldButton").on('click', function(){
			var clone = $('.categorySelectHolder').first().clone('true');
			$(clone).find(".newscategorycont").val('');
			$(clone).insertAfter($('.categoryCont').find(".categorySelectHolder").last());
		});
		
		$(".newscategorycont").on("focus", function(){
			$(this).attr('currentCat', $(this).val());
		});
		
		$('.jq_pricelistAddNewItemButton').on('click', function(){
			addNewPricelistItem();
		});
		
		$(document).on('blur', '.jq_rebateInput', function(){
			if($(this).val() != '' || $(this).val() > 0){
				savePricelistItemRebate($('.content-wrapper').attr('currentid'), $(this).attr('id'), $(this).val());
			}
		});
		
		$("#toggleImportProducts").on("click", function(){
			$(".importProductsCont").slideToggle(function(){	
			});
		});
		
		/*	import products xls	*/
		
		$("#jq_importFilePricelistForm").on("submit", function(e){
			e.preventDefault();
			if($(".jq_importPricelistFile").val() != "" && $(".jq_pricelistImportSelectCont").val() != 0)
			{
				$('.loadingIconImport').removeClass('hide');
				
				var formdata = new FormData(this);
				formdata.append("pricelistid", $(".jq_pricelistImportSelectCont").val());
				
				$.ajax({
					url:"modules/"+moduleName+"/library/import-products-xls.php",
					type: "POST",           
					data: formdata,
					contentType: false,      
					cache: false,            
					processData:false,    
					success: function(response)
					{
						if(response == 0){
							$('.jq_importFileSuccess').removeClass('hide');	
							$('.jq_importFileFail').addClass('hide');
						}else{
							$('.jq_importFileFail').find('p').html(response);
							$('.jq_importFileSuccess').addClass('hide');
							$('.jq_importFileFail').removeClass('hide');
						}
						$('.loadingIconImport').addClass('hide');
						$('.jq_importFilePricelist').val('');
					},
					statusCode:
					{
						500: function() {
							alert("Struktura fajla ne odgovara!");
							$('.loadingIconImport').addClass('hide');
						}
					}
				});
			}
			
		});
		
		
});