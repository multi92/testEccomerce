$(document).ready(function (e) {
   
   var listtable = $("#globalconfigLanguageListTable").DataTable({
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
						/*	language icon	*/
						
						d.aaData[i][4] = '<img style="max-width:50px;" src="../'+d.aaData[i][4]+'" />'; 
						
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
						d.aaData[i][5] = bd;
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ jezika",
				"infoEmpty":      "Prikaz 0 do 0 od 0 jezika",
				"infoFiltered":   "(filtrirano od _MAX_ jezika)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ jezika",
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
	$('#globalconfigLanguageListTable tbody').on('click', '.deleteButton',  function () {
      	var $this = $(this);
		var a = confirm("Da li ste sigurni da zelite da obisete jezik?");
		if(a)
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "deletelanguage", id: $this.attr("id") }
			}).done(function(result){
				alert("Uspesno obrisano!");
				listtable.ajax.reload();
				//document.location.reload();
			});		
		}
    });
   
   $('.searchInput').on('keyup', function(){
		if($(this).val() != ""){
			
			var searchval = ($(this).val()).toLowerCase();
			
			var sectionkey = "";
			var hide = false;
	
			$('.groupItemRow').each(function(){
				
				if(sectionkey != $(this).parents('.boxGroup').attr('key')){
					
					if(hide){
						$(this).parents('.boxGroup').addClass('hide');
					}else{
						$(this).parents('.boxGroup').removeClass('hide');	
					}
					sectionkey = $(this).parents('.boxGroup').attr('key');
					hide = true;
				}
				
				var p = $(this).find('p').html();
				var val = $(this).find('.valueInput').val();
				var com = $(this).find('.commentInput').val();
				
				if(((val+' '+p+' '+com+' '+sectionkey).toLowerCase()).indexOf(searchval) > -1){
					$(this).removeClass('hide');	
					hide = false;
				}else{
					$(this).addClass('hide');	
				}
			});
				
		}else{
			$('.groupItemRow').each(function(){
				$(this).removeClass('hide');	
			});
		}
		
	});
   
   $(window).keypress(function(event) {
		if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
		
		event.preventDefault();
		$('.saveUserConf').trigger('click');
		return false;
	});
	$('.saveUserConf').on("click", function(){
		var cont = {};
		
		$(".groupItemRow").each(function(){
			var key = $(this).parents(".boxGroup").attr("key");
			cont[$(this).attr("key")] = [key, $(this).find('.valueInput').val(), $(this).find('.commentInput').val()];
			
		});	
		
		console.log(cont);
		
		data = {
			action: 'saveUserConf',
			itemdata: JSON.stringify(cont)
		}
		
		console.log(JSON.stringify(cont));
		
		$.ajax({
			url: "modules/" + moduleName + "/library/functions.php",
			type: "POST",
			data: data,
			success: function (response) {
				if(response == 1){
					window.location.reload();	
				}
			}
		});
		console.log(cont);
	});
	
	/*	add language	*/
	
	$('.jq_newLanguageAddButton').on('click', function(){
		var error = false;
		if($('.jq_newLanguageCodeInput').val() == ''){
			$('.jq_newLanguageCodeInput').parent().addClass('has-error');	
			error = true;
		}
		if($('.jq_newLanguageNameInput').val() == ''){
			$('.jq_newLanguageNameInput').parent().addClass('has-error');	
			error = true;
		}
		if($('.jq_newLanguageShortnameInput').val() == ''){
			$('.jq_newLanguageShortnameInput').parent().addClass('has-error');	
			error = true;
		}
		
		if(!error){
			addlanguage($(this));
		   	//	listtable.ajax.reload();
			
		}else{
			alert('Popunite obavezna polja!');	
		}
	});
	
	$('.jq_newLanguageCodeInput').on('keyup blur', function(){
		if($(this).val() != ''){
			if($(this).val().length > 2){
				checkLanguageCode($(this));
			}else{
				$(this).parent().addClass('has-error');	
			}
		}
		else{
			$(this).parent().removeClass('has-error has-success');
		}
	});
	
	$('.jq_newLanguageNameInput, .jq_newLanguageShortnameInput').on('keyup blur', function(){
		if($(this).val() != ''){
			if($(this).val().length > 2){
				$(this).parent().removeClass('has-error').addClass('has-success');
				checkAddButton();
			}else{
				$(this).parent().addClass('has-error').removeClass('has-success');
				checkAddButton();	
			}
		}
		else{
			$(this).parent().removeClass('has-error has-success');
		}
	});
   
});