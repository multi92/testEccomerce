function saveCategoryMainColor_handler(elem){
	$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action: "saveCategoryMainColor",
					id: $(".detailCategoryCont").attr("catid"),
					value : $(elem).val()
					}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				
			}
		});	
}