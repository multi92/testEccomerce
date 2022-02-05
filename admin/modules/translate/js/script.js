$(document).ready(function(e) {
	
	$('.searchInput').on('keyup', function(){
		if($(this).val() != ""){
			var searchval = ($(this).val()).toLowerCase();
			
			var sectiongroup = "";
			var hide = false;
			$('input[type="text"]').each(function(){
				
				if(sectiongroup != $(this).attr('section')){
					
					if(hide){
						$('h4:contains("'+sectiongroup+'")').addClass('hide');
					}else{
						$('h4:contains("'+sectiongroup+'")').removeClass('hide');	
					}
					sectiongroup = $(this).attr('section');
					hide = true;
				}
				
				var val = $(this).val();
				var section = $(this).attr('section');
				if(((val+' '+section).toLowerCase()).indexOf(searchval) > -1){
					$(this).removeClass('hide');	
					hide = false;
				}else{
					$(this).addClass('hide');	
				}
			});	
		}else{
			$('input[type="text"]').each(function(){
				$(this).removeClass('hide');	
			});
		}
		
	});
	
	$(window).keypress(function(event) {
		if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
		
		event.preventDefault();
		$('.saveTranslate').trigger('click');
		return false;
	});
	
	
	$(".saveTranslate").on("click", function(){
		
		var passobject = {action: "savefile"}
		
		$(".langCont").each(function(){
			var text = [];
			$(this).find('input[type="text"]').each(function(){
				text.push([$(this).attr("section"),
							$(this).attr("key"),
							$(this).val()]); 	
			});
			//text = JSON.stringify(text);
			passobject[$(this).attr('lang')] = JSON.stringify(text);
		});
		/*
		for(var i = 0; i < lang.length ; i++)
		{
			var text = [];
			$("."+lang[i][0]).find("input").each(function(){
				text.push([$(this).attr("section"),
							$(this).attr("key"),
							$(this).val()]); 
			});	
			text = JSON.stringify(text);
			
			passobject[lang[i][0]] = text;	
		}
		*/
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passobject),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				console.log(response);
				/*
				if(pagesid == "") alert("Uspesno dodata stranica");
				else alert("Uspesno snimljena stranica");*/
				document.location.reload();
			}
		});

		
	});
});

