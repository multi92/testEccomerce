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
						var bc = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						}
						var bd = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
						}
						d.aaData[i][7] = bc + bd;
						
						
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
						{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-'+d.aaData[i][6]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][6]);
							$(clone).find("option[value='"+d.aaData[i][6]+"']").attr('selected', 'selected');
						}else{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').attr('disabled', 'disabled');
							$(clone).find("option[value='"+d.aaData[i][6]+"']").attr('selected', 'selected');
						}	
						d.aaData[i][6] = $(clone).wrap('<div>').parent().html();
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ vesti",
				"infoEmpty":      "Prikaz 0 do 0 od 0 vesti",
				"infoFiltered":   "(filtrirano od _MAX_ vesti)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ vesti",
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
		});
		
		/*	top buittons	*/
		$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
		$("#listButton").on("click", function(){
			window.location.href = 'pages';
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
		
		
});
