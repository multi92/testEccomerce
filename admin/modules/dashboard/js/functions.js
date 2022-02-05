function checkUpdates(){
	
	data = {
		action: 'checkupdates'
	}

	$.ajax({
		url: "modules/" + moduleName + "/library/functions.php",
		type: "POST",
		data: data,
		success: function (response) {
			if(response == '0'){
				$('#checkUpdates').addClass('alert-error').addClass('alert-dismissible');
				$('#checkUpdates').find('span').text('Sistem nije ažuran!!! Molimo Vas updejtujte sistem!');
				
				var a = $(document.createElement('a'));
				$(a).addClass("btn").addClass("btn-block").addClass("btn-warning").text("Ažuriraj sistem").click(function(){
					updateSysytemClick_handler($(this));
				});
				$('#checkUpdates').append($(a)).removeClass("hide");
			}
			else if(response == '1'){
				$('#checkUpdates').addClass('alert-success').addClass('alert-dismissible');
				$('#checkUpdates').find('span').text('Sistem je ažuriran.').removeClass("hide");
			} 
		}
	});	
}


function updateSysytemClick_handler(el){
	if(confirm('Da li stesigurni da želite da ažurirate sistem?')){
			alert('Sistem se azurira!');
			data = {
				action: 'updatesystem'
			}
			$.ajax({
				url: "modules/" + moduleName + "/library/functions.php",
				type: "POST",
				data: data,
				success: function (response) {					
					//window.location.reload();	
					alert(response);
				}
			});
		}

}