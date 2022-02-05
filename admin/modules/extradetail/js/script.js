function resetForm(){
		
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	$('input').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue',
		increaseArea: '20%' // optional
	  });
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
						var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						var bd = "";
						if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obriši</button> ';
						}
						d.aaData[i][3] = bc + bd;
						
						
						if($("body").attr("user") == "admin")
						{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-'+d.aaData[i][2]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][2]);
							$(clone).find("option[value='"+d.aaData[i][2]+"']").attr('selected', 'selected');
							
							d.aaData[i][2] = $(clone).wrap('<div>').parent().html();
						}else{
							d.aaData[i][2] = "";
						}	
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "Nema podataka u bazi",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ podataka",
				"loadingRecords": "Ucitavanje...",
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
		
		$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
		
		$("#listButton").on("click", function(){
			window.location.href = 'extradetail';
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