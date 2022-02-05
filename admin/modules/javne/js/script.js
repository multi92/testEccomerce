function resetForm(){

}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
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
						d.aaData[i][8] = bc + bd;
						
						
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
						{
							var sel = '<select class="form-control selectStatus background-'+d.aaData[i][7]+'" id="'+d.aaData[i][99]+'" currentStatus="'+d.aaData[i][7]+'">';
								sel += '<option value="v" '; if(d.aaData[i][7] == "v") sel +=  " selected "; sel += '>Vidljiva</option>';	
								sel += '<option value="h" '; if(d.aaData[i][7] == "h") sel +=  " selected "; sel += '>Sakrivena</option>';	
								sel += '<option value="a" '; if(d.aaData[i][7] == "a") sel +=  " selected "; sel += '>Arhivirano</option>';	
								sel += 	'</select>';
							
						}else{
							var sel = '<select class="form-control selectStatus " disabled="disabled">';
								sel += '<option value="v" '; if(d.aaData[i][7] == "v") sel +=  " selected "; sel += '>Vidljiva</option>';	
								sel += '<option value="h" '; if(d.aaData[i][7] == "h") sel +=  " selected "; sel += '>Sakrivena</option>';	
								sel += '<option value="a" '; if(d.aaData[i][7] == "a") sel +=  " selected "; sel += '>Arhivirano</option>';	
								sel += 	'</select>';
						}	
						d.aaData[i][7] = sel;				
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ nabavki",
				"infoEmpty":      "Prikaz 0 do 0 od 0 nabavki",
				"infoFiltered":   "(filtrirano od _MAX_ nabavki)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ nabavki",
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
      	deleteItem_handler($(this));
    }).on('click', '.changeViewButton', function () {
		
		/*window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
      	showLoadingIcon();
		$this = $(this);
		$(".listCont").hide("fast","", function(){
			resetForm();
			//$(".loadednews").attr('newsid', $this.attr("newsid"));
			
			$.ajax({
			  method: "POST",
			  cache:false,
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "getsingle", id: $this.attr("id") }
			}).done(function(result){
				//console.log(result);
				var a = JSON.parse(result);
				
				for(var i = 0; i < lang.length ; i++)
				{
					$(".numberJavne"+lang[i][0]).val(a[0][lang[i][0]].number);
					$(".predmetJavne"+lang[i][0]).val(a[0][lang[i][0]].predmet);
					$(".vrstaJavne"+lang[i][0]).val(a[0][lang[i][0]].vrsta);	
				}		
				$("table.position_1").find("tbody").html("");
				$("table.position_2").find("tbody").html("");
				$("table.position_3").find("tbody").html("");				
				$("table.position_4").find("tbody").html("");
				
				$(".expiredate").val(a[0]['lat'].expiredate);
				
				$(".javnePosition").val(a[0]['lat'].position);
				
				for(var i = 0; i < a[1].length; i++)
				{
					createJavneItemRow(a[1][i].id, a[1][i].position, a[1][i].value, a[1][i].active, a[1][i].adddate);
				}
				
				$(".loaded").attr('id', $this.attr("id"));
				$(".addChangeCont").show('','',hideLoadingIcon());
				
				if($(".loaded").attr('id') != "" && $(".userpriv").data("change") == 0)
				{
					$("#saveAddChangeForm").hide();
				}
				
			});
			
		});	*/
    }).on('change', '.selectStatus', function () {
      	changestatus_handler($(this));
    }).on('click', '.changeViewButton', function () {
		window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
	});
	
	$("#addButton").on("click", function(){
		window.location.href = window.location.pathname+'/add';
	});
	
	$("#listButton").on("click", function(){
		window.location.href = 'javne';
	});
	
	$(document).on("click", ".deleteJavneItem", function(){
		deletejavne_handler($(this));
	});
	
	$(document).on("click", ".addJavneDocument", function(){
		addjavnedocument_handler($(this));
	});
	
	$(document).on("change", ".selectJavneItemStatus", function(){
		changeitemstatus_handler($(this));
	});
	
	$('.expiredate').datepicker({
		format: 'yyyy-mm-dd'
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
		
		$(".saveNewJavneButton").on('click', function(){
			showLoadingIcon();
			saveAddChange();
		});
		
		
	}
});
