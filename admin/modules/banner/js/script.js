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
$(document).ready(function(e) {
	
	
	
	$("#example1").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".example1-grid-error").html("");
                    $("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema podataka za prikaz.</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						if($("body").attr("user") == "admin")
						{
							var str = "";
							if(d.aaData[i][7] == "l") str = "Levo";
							if(d.aaData[i][7] == "c") str = "Centralno";
							if(d.aaData[i][7] == "r") str = "Desno";
							var inp = '<div class="input-group">';
							inp += '<span class="input-group-addon">'+str+'</span>';
							inp += '<input type="number" class="form-control sort" min="0" id="'+d.aaData[i][99]+'" value="'+d.aaData[i][8]+'" >';
							inp += '</div>';
							
							d.aaData[i][7] = inp;
							
							var sel = '<select class="form-control selectStatus background-'+d.aaData[i][6]+'" id="'+d.aaData[i][99]+'" currentStatus="'+d.aaData[i][6]+'">';
								sel += '<option value="v" '; if(d.aaData[i][6] == "v") sel +=  " selected "; sel += '>Vidljiva</option>';	
								sel += '<option value="h" '; if(d.aaData[i][6] == "h") sel +=  " selected "; sel += '>Sakrivena</option>';	
								sel += '<option value="a" '; if(d.aaData[i][6] == "a") sel +=  " selected "; sel += '>Arhivirano</option>';	
								sel += 	'</select>';
							d.aaData[i][6] = sel;
						}else{
							d.aaData[i][6] = "";
							d.aaData[i][7] = d.aaData[i][7]+" _ "+d.aaData[i][8];
						}	
						
						var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						var bd = "";
						if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
						}
						d.aaData[i][8] = bc + bd;
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ stranica",
				"infoEmpty":      "Prikaz 0 do 0 od 0 stranica",
				"infoFiltered":   "(filtrirano od _MAX_ vesti)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ stranica",
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
		var a = confirm("Da li ste sigurni da zelite da obisete baner?");
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
	
	$("#listButton").on("click", function(){
		window.location.href = 'banner';		
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