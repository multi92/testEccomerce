function resetForm(){
	$(".documentPath").val('').parent().removeClass("has-error").removeClass("has-success");
	$(".documentName").val('');
	$(".documentDelovodni").val('');
	$(".documentDate").val('');
	$(".loaded").attr('id', '');
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
function verifypath(elem){
	if($(elem).val() != "")
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "verifypath", 
				path: $(elem).val() 
			}
		}).done(function(result){
			if(result == 0)
			{
				$(elem).parent().removeClass("has-success").addClass("has-error");
				$(".saveAddChange").prop("disabled", true);	
			}
			else{
				$(elem).parent().removeClass("has-error").addClass("has-success");
				$(".saveAddChange").prop("disabled", false);
			}	
		});		
	}
}
$(document).ready(function(e) {
	
	$('.documentDate').datepicker({
		format: 'yyyy-mm-dd'
		});
	
	$("#example1").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					var img = $(document.createElement('img')).attr('height', '30px');
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						var bd = "";
						if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
						}
						d.aaData[i][8] = bc + bd;
						
						if(d.aaData[i][3] != ''){
							var image = '<img src="../'+d.aaData[i][3]+'" height="50px" />';
							d.aaData[i][3] = image;
						}
						
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ dokumenta",
				"infoEmpty":      "Prikaz 0 do 0 od 0 dokumenta",
				"infoFiltered":   "(filtrirano od _MAX_ dokumenta)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ dokumenta",
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
	
	$('#example1 tbody').on('click', '.deleteButton', function () {
      	var $this = $(this);
		var a = confirm("Da li ste sigurni da zelite da obisete dokument?");
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
    });
	

	$("#addButton").on("click", function(){
		window.location.href = window.location.pathname+'/add';
	});
	
	$("#listButton").on("click", function(){
		window.location.href = 'document';
	});

	$(".documentType").on("change", function(){
		$(".documentType").attr('currentDocumentType',this.value);
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

	
	$(".documentPath").on("blur change", function(){
		verifypath($(this));
	});
	$(".documentImage").on("blur change", function(){
		verifypath($(this));
	});
});