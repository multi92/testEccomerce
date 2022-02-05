
async function showDialog(type,textstr,buttons){
	var clickEvent = 0;
	var dialogType ='';
	var modalType ='';
	var modalTitle = '';
	switch(type) {
  		case 'default':
    		dialogType='primary '; 
    		modalType='modal-primary';
    		modalTitle='Obaveštenje';
    	break;
  		case 'info':
    		dialogType='info '; 
    		modalType='modal-info';
    		modalTitle='Info';
    	break;
    	case 'warning':
    		dialogType='warning '; 
    		modalType='modal-warning';
    		modalTitle='Upozorenje';
    	break;
    	case 'error':
    		dialogType='error ';
    		modalType='modal-danger'; 
    		modalTitle='Greška';
    	break;
    	case 'success':
    		dialogType='success ';
    		modalType='modal-success';
    		modalTitle=''; 
    	break;
  		default:
   		 	dialogType='primary ';
   		 	modalType='modal-primary'; 
   		 	modalTitle='Obaveštenje';
		}
	switch(buttons) {
		case 'mrOK':
    		$("#dialogModal").find('.dialogModalOkBTN').removeClass('hide');
    		
    	break;
  		case 'mrYesNo':
    		$("#dialogModal").find('.dialogModalNoBTN').removeClass('hide');
    		$("#dialogModal").find('.dialogModalYesBTN').removeClass('hide');
    	break;
    	case 'mrSave':
    		$("#dialogModal").find('.dialogModalDismisBTN').removeClass('hide');
    		$("#dialogModal").find('.dialogModalSaveBTN').removeClass('hide');
    	break;
 
    	
		}
	
	$("#dialogModal").addClass(modalType);
	$("#dialogModal").find('.modal-title').text(modalTitle);
	$("#dialogModal").find('.modalText').text(textstr);

	


	//$("#dialogModal").modal('show');
	var response='';

	const modal =  new Promise(function(resolve, reject){
    
    	$('#dialogModal').modal('show');
    
    	$('#dialogModal .dialogModalOkBTN').click(function(){
    		resolve('true');
    	});
    	$('#dialogModal .dialogModalYesBTN').click(function(){
    		resolve('true');
    	});
    	$('#dialogModal .dialogModalNoBTN').click(function(){
    		reject('false');
     	});
    }).then(function(val){
            		//val is your returned value. argument called with resolve.
                //alert(val);
                
               
                response=val;
                $('#dialogModal').modal('hide');
                return response;


    }).catch(function(err){
            	//alert(val);
            	response = 'false';
            	 $('#dialogModal').modal('hide');
                return response;
           		console.log("user clicked cancel", err);
           		//$('#dialogModal').modal('hide');

    });

   
    







	// $('.dialogModalOkBTN').on('click', function (e) {
 //    	  $("#dialogModal").attr('returnValue',1);
 //  		  $("#dialogModal").modal('hide');
 //  		  $(this).addClass('modal-result');
 //  		  return $("#dialogModal").attr('returnValue');
	// });

	

}

$(document).ready(function(e) {
	
	// $('.dialogModalDismisBTN').on('click', function (e) {
 //    	  $("#dialogModal").attr('returnValue',0);
 //  		  $("#dialogModal").modal('hide');
 //  		  $(this).addClass('modal-result');
 //  		  return $("#dialogModal").attr('returnValue');
	// });

	// $('.dialogModalSaveBTN').on('click', function (e) {
 //    	  $("#dialogModal").attr('returnValue',1);
 //  		  $("#dialogModal").modal('hide');
 //  		  $(this).addClass('modal-result');
 //  		  return $("#dialogModal").attr('returnValue');
	// });

	$('#dialogModal').on('hidden', function (e) {
    	var value = $('#dialogModal').attr('returnValue');
    	var result = $(this).find('.modal-result');
    	return result;
	});
	
	
});