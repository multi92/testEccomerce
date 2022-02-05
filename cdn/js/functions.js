//funckicje koje ne komuniciraju van sajta
function showNotification(msg, tip) {
    switch (tip) {
        case 'alert':
            alertify.alert(msg);
            break;
        case 'success':
            alertify.success(msg);
            break;
        case 'error':
            alertify.error(msg);
            break;
    }
}

function createCompareSmallBox(proid, img){	
	var div = $(document.createElement('div')).addClass('pull-left').addClass('uporedi-box').addClass('compareItemCont').addClass('jq_compareItemCont').attr('productid', proid);
	$(div).css("background-image", "url('"+img+"')");
	//$(document.createElement('img')).attr('src', img).addClass('jq_compareImage').appendTo($(div));
	$(document.createElement('i')).addClass('fa').addClass('fa-times').addClass('jq_removeFromCompareButton').appendTo($(div));
	
	$(div).appendTo(".jq_toolboxCompareCont");
}
function remove_compare_prod(prodid){
    removeFromCompare(prodid);
    location.reload();
}


