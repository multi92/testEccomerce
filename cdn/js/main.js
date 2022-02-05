$(document).ready(function() {
    
	
    // add to cart animated
    var addCartBtn = $('.product-info .product-cart .product-cart-btn');

    addCartBtn.on('click', function() {

        $(this).attr('disabled','disabled');

        $this=$(this);

        var oldImage = $(this).parents('.product-page').find('.product-image').attr('src');
        var newImage = $(document.createElement('img')).addClass('image-animated').attr('src',oldImage);

        $('.easyzoom a').append(newImage);

        var cartPos = $('.korpa-head').offset();
        var image = $(this).parents('.product-page').find('.image-animated');
        var imagePos = image.offset();
        console.log(cartPos);
        image.css('visibility', 'visible');
        image.css('transform', 'translate(' + (cartPos.left - imagePos.left ) + 'px,' + (cartPos.top - imagePos.top ) + 'px)');
        image.css('width','80px');
        image.css('height','80px');
        image.css('opacity','0.3');

        $(image).one("webkitTransitionEnd oTransitionEnd msTransitionEnd ",
            function(e) {
                $(image).remove(); 
                $($this).attr('disabled',false);               
        });
    });
    // .add to cart animated



	$('.menu ul li i').on('click',function(){
        $(this).parents('li').find('.dropdown-small').slideToggle();
    });
	
    // attr image popover
    $('a[rel=popover]').popover({
        html: true,
        trigger: 'hover',
        placement: 'top',
        content: function() { return '<img src="' + $(this).data('img') + '"  style="max-width:100px;"/>'; }
    });
    // .attr image popover
    // boja ,dezen select
    //$('.filter-color-li').on('click', function() {
    //    $(this).find('i').toggleClass('show');
    //});
    // .boja ,dezen select
    // side drop
    $('.side-drop-triger').on('click', function() {
        $(this).parents('.side-kate-li').find('.side-kate-drop').slideToggle();
        $(this).toggleClass('fa-minus');
    });
    $('.side-drop-triger2').on('click', function() {
        $(this).parents('.side-kate-drop-li').find('.side-kate-drop2').slideToggle();
        $(this).toggleClass('fa-minus');
    });

    // .side drop
    // navbar fixed top
    $(window).scroll(function(event) {
        var scroll = $(window).scrollTop();

        if (scroll >= 230) {

            $('.header-fixed').fadeIn();
            $('.left-body-baner, .right-body-baner').addClass('posFixedBaner');
        } else {

            $('.header-fixed').fadeOut();
            $('.left-body-baner, .right-body-baner').removeClass('posFixedBaner');
        }
    });


    var scroll = $(window).scrollTop();

    if (scroll >= 230) {
        // $('.navigation-holder').addClass('navbar-fixed-top');
        // $('.navigation-holder').css('box-shadow','0px 0px 8px lightgrey');
        $('.header-fixed').fadeIn();
        $('.left-body-baner, .right-body-baner').addClass('posFixedBaner');
    } else {
        // $('.navigation-holder').removeClass('navbar-fixed-top');
        // $('.navigation-holder').css('box-shadow','none');
        $('.header-fixed').fadeOut();
        $('.left-body-baner, .right-body-baner').removeClass('posFixedBaner');
    }

    // .navbar fixed top

    // korpa div
    $('.korpa-head').hover(function() {
        //$('.cart-slide').slideDown();

    });
    $(".cart-slide").mouseenter(function() {
        $('body').css('position', 'fixed');
        $('body').css('overflow-y', 'scroll');
        $('body').css('width', '100%');

    });
    $(".cart-slide").mouseleave(function() {
        $('body').css('position', 'static');
        $(this).slideUp();
    });

    // .korpa div


    $('[data-toggle="popover"]').popover({
        content: $('#myPopoverContent').html(),
        html: true
    });

    // small nav
    var activeBurger = true;
    $('.burger').on('click', function() {
        if (activeBurger) {
            TweenMax.to($('.burger2'), 0.2, { alpha: 0 })
            TweenMax.to($('.burger1'), 0.5, { top: "+=15", rotation: 45 })
            TweenMax.to($('.burger3'), 0.5, { top: "-=5", rotation: -45 })

            TweenMax.to($('.menu'), 0.5, { left: 0 })
            $('body').css('overflow-y', 'hidden');
            activeBurger = false;
        } else {
            TweenMax.to($('.burger2'), 0.5, { alpha: 1 })
            TweenMax.to($('.burger1'), 0.5, { top: "-=15", rotation: 0 })
            TweenMax.to($('.burger3'), 0.5, { top: "+=5", rotation: 0 })

            TweenMax.to($('.menu'), 0.5, { left: "-100%" })
            $('body').css('overflow-y', 'scroll');
            activeBurger = true;
        }
    });
    // .small nav
 


    // owl carousel
    $(".owl1").owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'flipIn',
        items: 1,

        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplaySpeed: 4000,
        smartSpeed: 750
    });
    $(".owl2").owlCarousel({
        // animateOut: 'fadeOut',
        // animateIn: 'flipIn',
        items: 1,

        loop: true,

        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 1500
    });
    $(".owl3").owlCarousel({
        items: 4,
        loop: true,
        nav: true,
        // margin: 10,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 1500,
        responsive: {
            0: {
                items: 1,
            },
            395: {
                items: 2,
            },

            590: {
                items: 3,
            },
            992: {
                items: 4,
            },

            1200: {
                items: 5,
            }
        }
    });
    $(".owl4").owlCarousel({
        items: 5,
        loop: true,
        nav: true,
        margin: 15,
        autoplay: true,
        // autoplayHoverPause: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 500,
        responsive: {
            0: {
                items: 3,
            },
            395: {
                items: 4,
            },

            590: {
                items: 4,
            },
            992: {
                items: 5,
            },

            1200: {
                items: 5,
            }
        }
    });







    $('.owl-prev').html('<i class="fa fa-angle-left fa-3x" aria-hidden="true"></i>');
    $('.owl-next').html('<i class="fa fa-angle-right fa-3x" aria-hidden="true"></i>');


    // .owl carousel
    // drop down height
    var dropHeight = $('.main-drop').outerHeight() - 1;
    $('.sec-drop').css('min-height', dropHeight + 'px');

    if($('.sec-drop').hasClass('nfixed_help9')){
        $('.nfixed_help9').css('height', dropHeight + 'px');
        $('.nfixed_help9').css('overflow-y', 'scroll');
    }
    


  
    // .drop down height

    $('.main-drop-triger').mouseenter(function(){
        $(this).css('z-index','999999');
        $('.main-body-filter').show();
    });
    $('.main-drop-triger').mouseleave(function(){
        $('.main-body-filter').hide();
        $(this).css('z-index','9');
    });



    // nav main dropdown
    // $('.nav-li').on('click', function() {


    //     if ($('.nav-main-drop').hasClass('open')) {
    //         $('.nav-main-drop').slideUp().removeClass('open');

    //     } else {
    //         $(this).find('.nav-main-drop').slideDown().addClass('open');
    //     }
    // });
    // .nav main dropdown
    // star rating

    $(".rateYo").rateYo({
        rating: 4.1,
        readOnly: true,
        starWidth: "18px"
    });
    $(".rate-p").rateYo({
        rating: 3.4,
        readOnly: true,
        starWidth: "25px"
    });
    $(".ocenite").rateYo({
        rating: 3.4,

        halfStar: true,
        starWidth: "20px"
    });

    // .star rating


    // zoom
    var $easyzoom = $(".easyzoom").easyZoom();

    // Get the instance API
    var api = $easyzoom.data("easyZoom");

    // Add click event listeners to thumbnails
    $(".thumbnails").on("click", "a", function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api.swap($this.data("standard"), $this.attr("href"));
    });
    // .zoom
    // attr-onchange
    $('.product-attr-li').on('click',function(){
        $(this).parents('.product-attr-ul').find('.product-attr-li').removeClass('attr-onchange');
        $(this).toggleClass('attr-onchange');
    });
    // .attr-onchange
});