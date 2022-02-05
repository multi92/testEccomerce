function showLoadingIcon() {
    $(".loadingIcon").removeClass("hide");
}

function hideLoadingIcon() {
    $(".loadingIcon").addClass("hide");
}
$(document).ready(function (e) {
   var globalHash = location.hash;
   if(globalHash.length>0){
   	var glclass= globalHash.replace("#", "")+'Tab';
   	
   	$("."+glclass).find("a").trigger('click');
   }
   

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
   var currencytable = $("#globalconfigCurrencyTable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getcurrencydata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".globalconfigCurrencyTable-grid-error").html("");
                    $("#globalconfigCurrencyTable").append('<tbody class="globalconfigCurrencyTable-grid-error"><tr><th colspan="3">Nema podatak za prikaz</th></tr></tbody>');
                    $("#globalconfigCurrencyTable-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{						
						/*VALUE*/
						if($("body").attr("user") == "admin" && d.aaData[i][1]!='RSD')
						{
							var currencyvalue = '<input type="number" min="0" step="0.000001" class="currencyvalueinput " value="'+d.aaData[i][3]+'" id="' + d.aaData[i][99] + '" style="width:100px;" />';
							d.aaData[i][3]=currencyvalue;
						} 
						/*VALUE END*/
						/*STATUS*/
						if($("body").attr("user") == "admin")
						{
							var clone = $(".selectCurrencyStatusTemplate").clone(true).removeClass('hide').removeClass('selectCurrencyStatusTemplate').addClass('background-currency-status-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]);
							$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
							
							d.aaData[i][4] = $(clone).wrap('<div>').parent().html();
						}else{
							if(d.aaData[i][4] == "a"){
								d.aaData[i][4]="Aktivna";
							} else {
								d.aaData[i][4]="Neaktivna";
							}
						}	
						/*STATUS END*/
						var bd = "";
						if(d.aaData[i][5] != "y"){
							if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1') )
							{
								bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obriši</button> ';
							}
						}
						/*PRIMARY*/
						if($("body").attr("user") == "admin")
						{
							var clone = $(".selectCurrencyPrimaryTemplate").clone(true).removeClass('hide').removeClass('selectCurrencyPrimaryTemplate').addClass('background-currency-primary-'+d.aaData[i][5]).attr('id', d.aaData[i][99]).attr('currentPrimary', d.aaData[i][5]);
							$(clone).find("option[value='"+d.aaData[i][5]+"']").attr('selected', 'selected');
							
							d.aaData[i][5] = $(clone).wrap('<div>').parent().html();
						}else{
							if(d.aaData[i][5] == "y"){
								d.aaData[i][5]="Da";
							} else {
								d.aaData[i][5]="Ne";
							}
						}	
						/*PRIMARY END*/
						/*SORT*/
						if($("body").attr("user") == "admin")
						{
							var sort = '<input type="number" min="0" class="currencysortinput " value="'+d.aaData[i][6]+'" id="' + d.aaData[i][99] + '" style="width:60px;" />';
							d.aaData[i][6]=sort;
						} 
						/*SORT END*/





						
						/*DELETE*/
						d.aaData[i][7] = bd;
						/*DELETE END*/
										
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
				"lengthMenu":     "Prikaži _MENU_ podataka",
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
	$('#globalconfigCurrencyTable tbody').on('click', '.deleteButton',  function () {
      	var $this = $(this);
		var a = confirm("Da li ste sigurni da zelite da obisete podatak?");
		if(a)
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "deletecurrency", id: $this.attr("id") }
			}).done(function(result){
				alert("Uspesno obrisano!");
				currencytable.ajax.reload();
				//document.location.reload();
			});		
		}
    }).on('click', '.changeViewButton', function () {
		window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
    }).on('change', '.selectCurrencyStatus', function () {
        showLoadingIcon();
        $this = $(this);
        
        if ($(this).attr("currentStatus") != $(this).val()) {
            $.ajax({
                method: "POST",
                url: "modules/"+moduleName+"/library/functions.php",
                data: {action: "changecurrencystatus", id: $this.attr("id"), status: $(this).val()}
            }).done(function (result) {
                $this.removeClass("background-currency-status-" + $this.attr("currentStatus")).addClass("background-currency-status-" + $this.val()).attr("currentStatus", $this.val());
                hideLoadingIcon();
                currencytable.ajax.reload();
                alert("Uspešno ste promenili status valute.");
                
            });

        }
    }).on('change', '.selectCurrencyPrimary', function () {
        showLoadingIcon();
        $this = $(this);
        
        if ($(this).attr("currentPrimary") != $(this).val() && $(this).val()=='y') {
            $.ajax({
                method: "POST",
                url: "modules/"+moduleName+"/library/functions.php",
                data: {action: "changecurrencyprimary", id: $this.attr("id"), primary: $(this).val()}
            }).done(function (result) {
                $this.removeClass("background-currency-primary-" + $this.attr("currentPrimary")).addClass("background-currency-primary-" + $this.val()).attr("currentPrimary", $this.val());
                hideLoadingIcon();
                currencytable.ajax.reload();
                alert("Uspešno ste promenili primarnu valutu.");
                
                

            });

        } else {
        	alert("Jedna od valuta mora uvek biti primarna.");
            hideLoadingIcon();
        }
    }).on('change', '.currencyvalueinput', function () {
        showLoadingIcon();
        $this = $(this);
		$.ajax({
			method: "POST",
			url: "modules/"+moduleName+"/library/functions.php",
			data: {action: "updatecurrencyvalue", 
				id: $($this).attr("id"), 
				value: $($this).val()}
		}).done(function (result) {
			currencytable.ajax.reload();
			hideLoadingIcon();
			alert("Uspešno ste promenili vrednost.");
			
		});

       
    }).on('change', '.currencysortinput', function () {
        showLoadingIcon();
        $this = $(this);
		$.ajax({
			method: "POST",
			url: "modules/"+moduleName+"/library/functions.php",
			data: {action: "updatecurrencysort", 
				id: $($this).attr("id"), 
				value: $($this).val()}
		}).done(function (result) {
			currencytable.ajax.reload();
			hideLoadingIcon();
			alert("Uspešno ste promenili sort.");
			
		});

       
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

   $('.searchThemeConfigInput').on('keyup', function(){
		if($(this).val() != ""){
			
			var searchval = ($(this).val()).toLowerCase();
			
			var sectionkey = "";
			var hide = false;
	
			$('.groupItemThemeRow').each(function(){
				
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
			$('.groupItemThemeRow').each(function(){
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
	$('.saveThemeConf').on("click", function(){
		var cont = {};
		
		$(".groupItemThemeRow").each(function(){
			var key = $(this).parents(".boxGroup").attr("key");
			cont[$(this).attr("key")] = [key, $(this).find('.valueInput').val(), $(this).find('.commentInput').val()];
			
		});	
		
		console.log(cont);
		
		data = {
			action: 'saveThemeConf',
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
	$('.saveTawkToCode').on("click", function(){
		var cont = '';
		cont = $(this).parent().find('.tawkToCode').val();
			
		
		console.log(cont);
		
		data = {
			action: 'saveTawkToConf',
			config: JSON.stringify(cont)
		}
		
		console.log(JSON.stringify(cont));
		
		$.ajax({
			url: "modules/" + moduleName + "/library/functions.php",
			type: "POST",
			data: data,
			success: function (response) {
				if(response == 1){
					//window.location.reload();	
					alert('Kod za učitavanje Tawk.To plugina je uspešno snimljen.');
				}
			}
		});
		console.log(cont);
	});
	
	$('.saveGoogleAnalytics').on("click", function(){
		var cont = '';
		cont = $(this).parent().find('.googleAnalyticsToCode').val();
			
		
		console.log(cont);
		
		data = {
			action: 'saveGoogleAnalyticsConf',
			config: JSON.stringify(cont)
		}
		
		console.log(JSON.stringify(cont));
		
		$.ajax({
			url: "modules/" + moduleName + "/library/functions.php",
			type: "POST",
			data: data,
			success: function (response) {
				if(response == 1){
					//window.location.reload();
					alert('Kod za Google analitiku je uspešno snimljen.');	
				}
			}
		});
		console.log(cont);
	});

	$('.saveFacebookPixel').on("click", function(){
		var cont = '';
		cont = $(this).parent().find('.facebookPixelToCode').val();
			
		
		console.log(cont);
		
		data = {
			action: 'saveFacebookPixelConf',
			config: JSON.stringify(cont)
		}
		
		console.log(JSON.stringify(cont));
		
		$.ajax({
			url: "modules/" + moduleName + "/library/functions.php",
			type: "POST",
			data: data,
			success: function (response) {
				if(response == 1){
					//window.location.reload();
					alert('Kod za Facebook Pixel je uspešno snimljen.');	
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