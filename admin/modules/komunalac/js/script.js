function resetPagesForm(){
	$(".addChangePagesCont").find("input").each(function(){
		$(this).val("");
		$(".loadedpages").attr('pagesid', "");
		for(var i in CKEDITOR.instances)
		{
			CKEDITOR.instances[i].setData('')
		}	
	});	
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function(e) {
	$(".open_email").on("click", function(){
		$.ajax({
			type:"POST",
			url:"modules/komunalac/library/functions.php",
			data: ({action: "getmessage",
					messageid: $(this).attr("emailid")
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				showLoadingIcon();
				$(".list_email").hide("fast","", function(){
					$('.message_files').html('');
					var a = JSON.parse(response);
					$(".message_title").html(a.title);
					$(".message_email").html('Od: ' + a.email + ' <span class="mailbox-read-time pull-right">'+ a.added+'</span>');
					$(".message_object").html('Pijaca: ' + a.name);
					$(".message_message").html(a.message);
					for(var i = 0; i < a.files.length; i++){
						
						var li = $(document.createElement('li'));
						$(document.createElement('a')).attr('target','_blank').attr('href', "../fajlovi/prijave/"+a.files[i].link ).html(a.files[i].name).appendTo($(li))
						$(li).appendTo($('.message_files'));
					}
					$(".maplink").attr('href', "https://maps.google.com/maps?q=loc:"+a.cordinate);
					$(".show_email").show('normal','',hideLoadingIcon());
				});
			}
		});
	});


	$("#addPagesButton").on("click", function(){
		showLoadingIcon();
		$(".listPagesCont").hide("fast","", function(){
				resetPagesForm();
				$(".addChangePagesCont").show('normal','',hideLoadingIcon());
			});	
	});
	
	$("#listMessageButton").on("click", function(){
		showLoadingIcon();
		$(".show_email").hide("fast","", function(){
			$(".list_email").show('','',hideLoadingIcon());
		});		
	});
	
});