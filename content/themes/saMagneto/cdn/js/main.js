$(document).ready(function() {


    /*	fast search	*/
	var fastSearchtimer;
	
	
	$('#mySearch-input1, #mySearch-input').on('keyup', function(){
		clearTimeout(fastSearchtimer);
		var elem = $(this);
		fastSearchtimer = setTimeout(function()
		{
			$(".qSearchCont").hide().html('');
			
			if($(elem).val().length > 2){
				$('#mySearch-input').attr('disabled', true);
				//$('.searchSpinner').show();
				//$('.searchInputHolderBlock').show(10);
				var data = {
					action : 'fastsearch',
					string: $(elem).val(),
					categoryid: $("#cat").val()
				};	
				$.ajax({
					type: "POST",
					data: data,
					url: "/",
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("ERROR:" + errorThrown);
					},
					success: function (response) {
						var a = JSON.parse(response);
						
						
						
						for(var i = 0; i < a.length; i++){
							var li = $(document.createElement('li')).addClass('qSearchItem');
							var aelem = $(document.createElement('a')).attr('href', a[i]['path']);
                            $(document.createElement('img')).attr('src',a[i]['image']).addClass('img-responsive').addClass('image').addClass('qSearchItemImage').appendTo($(aelem));
							$(document.createElement('span')).addClass('qSearchItemName').html(a[i]['name']).appendTo($(aelem));
							$(document.createElement('span')).addClass('qSearchItemCategory').html(a[i]['categoryname']).appendTo($(aelem));
							$(aelem).appendTo($(li));
							$(li).appendTo($('.qSearchCont'));
	
						}
						$(document.createElement('a')).addClass('btn').addClass('btn-primary').addClass('qSearchShowAllButton').html("Prikazi sve").attr('target','_blank').attr('href', "pretraga/?q="+$(elem).val()).appendTo($(".qSearchCont"));
						$(".qSearchCont").show();
						
						//$(".fastSearchResultButton").attr('href', "pretraga/?")
						//$('.searchSpinner').hide();
						//$('.searchInputHolderBlock').hide(10);
						$('#mySearch-input').attr('disabled', false).focus();
					}
				});
			}
		},500); 
	});
	$(document).on('click', function(){
		$(".qSearchCont").slideUp('fast');	
	});
	
   
    // fourth deep
    $('.dsn_mainCateMenuTriggerFourth').on('click',function(e){
        e.preventDefault();
        // console.log('ok');
        $(this).parents('.last-holder').find('.dsn_fourthDeepDrop').slideToggle();
    });
    // fourth deep end
    // checkout page
    $('.dn_recipient-address-trigger').on('click', function() {
        $.fn.extend({
            toggleText: function(a, b){
            return this.text(this.text() == b ? a : b);
            }
        });

        $(this).find('.icons').toggleText('check_box', 'check_box_outline_blank');

        $(this).toggleClass('-checked');

        $("#dn_checkout-form-recipient").slideToggle();

        $("#dn_checkout-form-recipient").find("input").each(function() {
            if($(this).hasClass('cms_recipient')){
               $(this).removeClass('cms_recipient').removeAttr('disabled'); 
            } else {
               $(this).addClass('cms_recipient').attr('disabled','disabled');
            }

        });
    });

    $('.dn_accept-terms').on('click', function() {
        $.fn.extend({
            toggleText: function(a, b){
            return this.text(this.text() == b ? a : b);
            }
        });
        $(this).find('.icons').toggleText('check_box', 'check_box_outline_blank');

        $(this).toggleClass('-checked');

    });

    // product image modal
     $('.dsn_thumb-prod-image-holder').on('click',function(){
        var smallProdImage = $(this).find('.dsn_thumb-prod-image').attr('src');
        $(this).parents('.product-col-holder').find('.product-image').attr('src',smallProdImage);
        $(this).parents('.product-col-holder').find('.product-image-link').attr('href',smallProdImage);
        
    })
    // product image modal end
          // scroll to top 
    $(window).scroll(function() {
        if ($(this).scrollTop() > 150) {
            $('.go-top').fadeIn(150);
			$(".qSearchCont").insertAfter("#mySearch-input");
        } else {
            $('.go-top').fadeOut(150);
			$(".qSearchCont").insertAfter("#mySearch-input1");
        }
    });

    // Animate the scroll to top
    $('.go-top').click(function(event) {
        event.preventDefault();

        $('html, body').animate({ scrollTop: 0 }, 'slow');
    })
    // .scroll to top


    // checkout page end

    // large image
    $(".trigerLarge").hover(function() {
            $(this).parents("td").find(".large-image").show()
        },
        function() {
            $(this).parents("td").find(".large-image").hide()
        });
    // .large image
    // filters modal
    $('.main-body-filter').on('click', function() {
        $('.filter-modal').fadeOut();
        $('.body-filter').hide();
        $('body').css('overflow-y', 'scroll')
    });

    $('#filterModalTrigger').on('click', function() {
        $('.filter-modal').fadeIn();
        $('.main-body-filter').show();
        $('body').css('overflow-y', 'hidden');
    });
    // filters modal end
    var smallImg = $('.table-row .table-items .image');
    var smallImgAttr;

    smallImg.on('click', function() {
        smallImgAttr = $(this).attr('imagebig');

        $('.image-modal .image-holder').html('<img src="' + smallImgAttr + '" alt="" class="img-responsive image">');
        $('.image-modal').fadeIn('fast');
        $('.body-filter').fadeIn('fast');
    });

    $('.image-modal .icons').on('click', function() {
        $(this).parent('.image-modal').fadeOut(300);
        $('.body-filter').fadeOut(10);
        $('.image-modal .image-holder').empty();
    });

    $('.body-filter').on('click', function() {
        $('.image-modal').fadeOut(300);
        $(this).fadeOut(10);
        $('.image-modal .image-holder').empty();
    });

    // slide menu


    // .slide menu

    // add to cart animated
    var addCartBtn = $('.product-info .product-cart .product-cart-btn');

    addCartBtn.on('click', function() {

        $(this).attr('disabled', 'disabled');

        $this = $(this);

        var oldImage = $(this).parents('.product-page').find('.product-image').attr('src');
        var newImage = $(document.createElement('img')).addClass('image-animated').attr('src', oldImage);

        $('.easyzoom a').append(newImage);

        var cartPos = $('.korpa-head').offset();
        var image = $(this).parents('.product-page').find('.image-animated');
        var imagePos = image.offset();
        console.log(cartPos);
        image.css('visibility', 'visible');
        image.css('transform', 'translate(' + (cartPos.left - imagePos.left) + 'px,' + (cartPos.top - imagePos.top) + 'px)');
        image.css('width', '80px');
        image.css('height', '80px');
        image.css('opacity', '0.3');

        $(image).one("webkitTransitionEnd oTransitionEnd msTransitionEnd ",
            function(e) {
                $(image).remove();
                $($this).attr('disabled', false);
            });
    });
    // .add to cart animated



    $('.menu ul li i').on('click', function() {
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
        $(this).toggleClass('fa-angle-down');
    });
    $('.side-drop-triger2').on('click', function() {
        $(this).parents('.side-kate-drop-li').find('.side-kate-drop2').slideToggle();
        $(this).toggleClass('fa-angle-down');
    });
    $('.side-drop-triger3').on('click', function() {
        $(this).parent('.side-kate-drop-li').find('.fourth-deep-shop').slideToggle();
        $(this).toggleClass('fa-angle-down');
    });
    
    // .side drop
    // navbar fixed top
    $(window).scroll(function(event) {
        var scroll = $(window).scrollTop();

        if (scroll >= 230) {

            $('.header-fixed').fadeIn();
            // $('.left-mil,.right-mil').css('margin-top','60px');
            $('.left-body-baner, .right-body-baner').addClass('posFixedBaner');
        } else {

            $('.header-fixed').fadeOut();
            // $('.left-mil,.right-mil').css('margin-top','108px');
            $('.left-body-baner, .right-body-baner').removeClass('posFixedBaner');
        }
    });
    $(window).scroll(function(event) {
        var scroll = $(window).scrollTop();

        if (scroll >= 100) {

            // $('.header-fixed').fadeIn();
            $('.left-mil,.right-mil').css('margin-top','60px');
            // $('.left-body-baner, .right-body-baner').addClass('posFixedBaner');
        } else {

            // $('.header-fixed').fadeOut();
            $('.left-mil,.right-mil').css('margin-top','108px');
            // $('.left-body-baner, .right-body-baner').removeClass('posFixedBaner');
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
            $('.burger .burger1, .burger .burger2, .burger .burger3').css('background', '#333');
            TweenMax.to($('.menu'), 0.5, { left: 0 })
            $('body').css('overflow-y', 'hidden');
            activeBurger = false;
        } else {
            TweenMax.to($('.burger2'), 0.5, { alpha: 1 })
            TweenMax.to($('.burger1'), 0.5, { top: "-=15", rotation: 0 })
            TweenMax.to($('.burger3'), 0.5, { top: "+=5", rotation: 0 })
            $('.burger .burger1, .burger .burger2, .burger .burger3').css('background', '#333');
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
                items: 2,
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
                items: 2,
            },
            395: {
                items: 3,
            },

            590: {
                items: 3,
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
        var dropHeight = $('#main-drop').outerHeight(true);
        $('.sec-drop').css('min-height', dropHeight + 'px');
        // console.log(dropHeight);
        if ($('.sec-drop').hasClass('nfixed_help9')) {
            $('.nfixed_help9').css('height', dropHeight + 'px');
            $('.nfixed_help9').css('min-height', '500px');
            $('.nfixed_help9').css('overflow-y', 'scroll');
        }

    
        $('.dsn_shop-categories-expand').on('click',function(){
            $('.shop-categories-drop').slideToggle("fast",function(){
                 dropHeightShop = $('.dsn_shop-categories-menu-holder').outerHeight(true);
                $('.sec-drop').css('min-height', dropHeightShop + 'px');
            });

        });
        



    // .drop down height

    $('.main-drop-triger').mouseenter(function() {

        if ($(this).hasClass('nfixed_help3')) {
            $('.main-body-filter').hide();
        } else {
            $(this).css('z-index', '999999');
            $('.main-body-filter').show();
        }


    });
    $('.main-drop-triger').mouseleave(function() {
        $('.main-body-filter').hide();
        $(this).css('z-index', '9');
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
    // $('.product-attr-li').on('click',function(){

    //     if($(this).hasClass('attr-onchange')){
    //         $(this).removeClass('attr-onchange');
    //     }else{
    //         $(this).parents('.product-attr-ul').find('.product-attr-li').removeClass('attr-onchange');
    //         $(this).addClass('attr-onchange');
    //     }  
    // });
    // .attr-onchange
	
	
	
});