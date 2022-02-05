function resetForm(){

}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	
	/*	toggle productcode	*/
	
	$("#toggleProductcode").on("click", function(){
		$(".productcodeCont").slideToggle(function(){
			$(".nameProductcode").val('');
		});
	});
	
	/*	extra detail list handlers	*/
	
	$(".productcodeListItem").on("click", function(){
		productcodeListItem_handler($(this));	
	});
	
	/*	save productcode	*/
	
	$(".saveProductcodeButton").on("click", function(){
		saveProductcode_handler();
	});
	
	/* 	add new productcode form	*/
	$(".addProductcodeFormButton").on("click", function(){
		$(".nameProductcode").val('');
		$(".productcodeItemBigCont").addClass("hide");
		$(".dataProductcode").attr("productcodedataid", '');
		
		$(".dataProductcode").removeClass('hide');
	});
	
	$(".addProductcodeAttrSelect").on('change', function(){
		getAttrvalList_handler($(this));	
	});
	
	$('.addProductcodeItemButton').on('click', function(e){
		addProductcodeItem_handler($(this));	
	});
	
	$(".deleteProductcodeItem").on("click", function(){
		deleteProductcodeItem_handler($(this));		
	});
	
	$(".PCitemval").on('blur', function(){
		updateProductcodeItemValue_handler($(this));	
	});
	
	

});
