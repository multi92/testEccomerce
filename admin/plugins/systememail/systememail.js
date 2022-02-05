function send_email_system(){
	var passdata = {action: "sendemail",
					to: $('#modal-systememail').find('.jq_emailBoxToInput').val(),
					subject: $('#modal-systememail').find('.jq_emailBoxSubjectInput').val(),
					message: $('#modal-systememail').find('.jq_emailBoxTexteditorDiv').val()
					};
	$.ajax({
			type:"POST",
			url:"plugins/systememail/systememail.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				if(response == 0){
					alert('Uspešno poslato.');
					$('#modal-systememail').modal('hide');
				}else{
					alert('Greška prilikom slanja poruke.');	
				}
			}
		});
}

$(document).ready(function(e) {
	$(document).on('click', '.jq_openEmailBox', function(){
		$('.jq_emailBoxTexteditorCont').html('');
		$(document.createElement('textarea')).addClass('jq_emailBoxTexteditorDiv').appendTo($('.jq_emailBoxTexteditorCont'));
		$('#modal-systememail').find('.jq_emailBoxTexteditorDiv').wysihtml5();
		$('#modal-systememail').find('.jq_emailBoxToInput').val($(this).html());
		$('#modal-systememail').find('.jq_emailBoxSubjectInput').val('');
		$('#modal-systememail').modal('show');
	});
	
	$(document).on('click', '.jq_emailBoxSendEmailButton', function(){
		
		send_email_system();
	});
});