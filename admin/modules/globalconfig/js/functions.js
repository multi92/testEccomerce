function checkAddButton(){
	var err = false;
	$('.jq_required').each(function(){
		if($(this).hasClass('has-error') || !$(this).hasClass('has-success')){
			err = true;	
		}
	});
	if(err) $('.jq_newLanguageAddButton').attr('disabled','disabled');
	else $('.jq_newLanguageAddButton').attr('disabled',false);	
}

function checkLanguageCode(elem){
	data = {
		action: 'checklanguagecode',
		code: $(elem).val()
	}
	
	$.ajax({
		url: "modules/" + moduleName + "/library/functions.php",
		type: "POST",
		data: data,
		success: function (response) {
			var a = JSON.parse(response);
			if(a[0] == 1){
				$(elem).parent().removeClass('has-success').addClass('has-error');
				checkAddButton();
			}else{
				$(elem).parent().removeClass('has-error').addClass('has-success');
				checkAddButton();
			}
		}
	});
}

function addlanguage(elem){
	data = {
		action: 'addlanguage',
		code: $('.jq_newLanguageCodeInput').val(),
		name: $('.jq_newLanguageNameInput').val(),
		shortname: $('.jq_newLanguageShortnameInput').val(),
		flag: $('.jq_newLanguageFlagInput').val(),
		values: $('.jq_newLanguageDefaultvaluesSelect').val()
	}
	
	$.ajax({
		url: "modules/" + moduleName + "/library/functions.php",
		type: "POST",
		data: data,
		success: function (response) {
			var a = JSON.parse(response);
			if(a[0] == 'success'){
				alert('Uspešno dodato');
				$('.jq_newLanguageCodeInput').val('');
				$('.jq_newLanguageNameInput').val('');
				$('.jq_newLanguageShortnameInput').val('');
				$('.jq_newLanguageFlagInput').val('');
				$('.jq_newLanguageDefaultvaluesSelect').val(0);
				
			}
			
			
		}
	})
}