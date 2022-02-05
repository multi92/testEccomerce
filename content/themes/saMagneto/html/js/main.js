$(document).ready(function() {
    var smallImg = $('.table-row .table-items .image');
    var smallImgAttr;

    smallImg.on('click', function() {
        smallImgAttr = $(this).attr('src');

        $('.image-modal .image-holder').html('<img src="' + smallImgAttr + '" alt="" class="img-responsive image">');
        $('.image-modal').fadeIn('fast');
        $('.body-filter').fadeIn('fast');
    });

    $('.image-modal .icons').on('click', function() {
        $(this).parent('.image-modal').fadeOut(300);
        $('.body-filter').fadeOut(10);
        $('.image-modal .image-holder').empty();
    });

    $('.body-filter').on('click',function(){
    	$('.image-modal').fadeOut(300);
    	$(this).fadeOut(10);
        $('.image-modal .image-holder').empty();
    });

    
});