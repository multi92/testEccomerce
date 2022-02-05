

$(document).ready(function(e) {
	
    
    /* set first option active if dosent exist in left menu	*/
	
	if($(".sidebar-menu").find("li.active").length == 0)
	{
		$(".sidebar-menu").find("li:not('.header')").first().addClass("active");	
	}
	
	
});