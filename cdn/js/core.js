function round(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function formatDate(date) {
    if (date !== undefined && date !== "") {
      var myDate = new Date(date);
      var month = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ][myDate.getMonth()];
      var str = myDate.getDate() + " " + month + " " + myDate.getFullYear();
      return str;
    }
    return "";
}

$(document).ready(function() {

    $('.add-to-chart-close').on("click", function(){
       $(".addToChartModal").css('display','none');
   });

    $('.addToChartContinueShoping').on("click", function(){
       $(".addToChartModal").css('display','none');
   });
    /*  ASKING PRICE  */
    
    //$('#userBirthday').datepicker({ format: "dd-mmm-yyyy"});
    $('#userBirthday').datepicker({ format: "dd.mm.yyyy"});
    $('#partnerUserBirthday').datepicker({ format: "dd.mm.yyyy"});
    
    
    $('.cms_sendRecommendedPriceButton').on('click', function(e){
        askingPrice($(this));
    });
    /*  ASKING PRICE END  */
    $('.cms_acceptCookiesBTN').on("click", function(){
        acceptCookies();
    });

	$('.cms_splashscreenValidationBTN').on("click", function(){
        var validationcode = $('.cms_splashscreenValidation').val();
        splashscreenValidation(validationcode);
    });
	/*	VAUCHER HANDLERS START	*/
	$('.cms_couponButton').on("click", function(){
		checkCoupon();
	});
	$('.cms_couponRemove').on("click", function(){
        if (confirm('Ukloniti vaučer?')) {
			removeCoupon();
		}
	});

	/*	VAUCHER HANDLERS END	*/
	
	//Log User Data
	userLogDataInsertUpdate();
    // product attr
    // $('.product-attr-triger').on('click', function() {
    //     $('.product-attr-li').find('i').css('display', 'none');
    //     $(this).find('i').css('display', 'block');
    // });
    // .product attr
    //ORDER CREATE RESERVATION
    $('.cms_order-to-reservation').on('click', function(e){
        $this = $(this);
        e.preventDefault(); 
        e.stopImmediatePropagation();   
        var data = {
            action : 'create_reservation',
			grr: $(".g-recaptcha-response").val()
        };
        $.ajax({
            type: "POST",
            data: data,
            url: "index.php",
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function (response) {
				var a = JSON.parse(response);
				if(a['status'] == 'success')
				{
					$('.bankform').remove();
					$('body').append(a['form']);
					if($(".bankform").length > 0){
						$(".bankform").submit();
					}
                	//window.location = $($this).attr('href');
				}else{
					alertify.error(a['message']);	
				}
            }
        });     
    });
    $('.cms_order-to-reservationB2B').on('click', function(e){
        $this = $(this);
        e.preventDefault(); 
        e.stopImmediatePropagation();   
        var data = {
            action : 'create_reservationB2B'
        };
        $.ajax({
            type: "POST",
            data: data,
            url: "index.php",
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function (response) {
				var a = JSON.parse(response);
				if(a['status'] == 'success')
				{
					$('.bankform').remove();
					$('body').append(a['form']);
					if($(".bankform").length > 0){
						$(".bankform").submit();
					}
				}else{
					alertify.error(a['message']);	
				}
				//window.location = $($this).attr('href');
            }
        });     
    });
    //ORDER TO CHECKOUT
    $('.cms_order-to-checkout').on('click', function(e){ 
        $this = $(this);
        //dodato
        var shopcartTotal=$this.attr('shopcart_total');
        var shopcartTotalItems=$this.attr('shopcart_total_items');
        //dodato END
        e.preventDefault(); 
        e.stopImmediatePropagation();   
        var data = {
            action : 'updateshopcartcomment',
            comment: $('.cms_shopcartComment').val()
        };
        $.ajax({
            type: "POST",
            data: data,
            url: "index.php",
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function (response) {
                //dodato
                /*fbq('track', 'InitiateCheckout', { 
                    value: shopcartTotal,
                    currency: 'RSD',
                    content_name: 'InitiateCheckout',
                    content_category: 'Checkout',
                    content_ids: 'Breze.rs',
                    num_ids: shopcartTotalItems
                    });*/
                window.location = $($this).attr('href');
            }
        });     
    });
    //ORDER TO CHECKOUT OFFER
    $('.cms_order-to-checkout-offer').on('click', function(e){ 
        $this = $(this);
        e.preventDefault(); 
        e.stopImmediatePropagation();   
        var data = {
            action : 'updateshopcartcomment',
            comment: $('.cms_shopcartComment').val()
        };
        $.ajax({
            type: "POST",
            data: data,
            url: "index.php",
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function (response) {
                window.location = $($this).attr('href');
            }
        });     
    });
    //ORDER FINISH
    //DODATO
    //SELECT PAYMENT
    $(".jq_payment-option").on('click', function() {
        var $this = $(this);
        $(".jq_payment-option").each(function(){
            if($($this).attr('value') != $(this).attr('value')){
                $(this).find('.icons').text('check_box_outline_blank');
                $(this).removeClass('-checked');
            }
        });
        $.fn.extend({
            toggleText: function(a, b){
            return this.text(this.text() == b ? a : b);
            }
        });
        $($this).find('.icons').toggleText('check_box', 'check_box_outline_blank');

        $($this).toggleClass('-checked');
    });
    //SELECT PAYMENT END
    //save data from shopcart 
    $('.jq_saveCustomerData').on('click', function(e){
        e.preventDefault();
        e.stopImmediatePropagation(); 
        
        $this = $(this);
         var langid = $(this).attr('lang');
        var currentLangCode = $(this).attr('langcode');
        var orderData = {};
        var orderComment=$('.cms_shopcartComment').val();

        var shopcartTotal=0;//$('#cms_order-customer-form').attr('shopcart_total');
        $.each($('#cms_order-customer-form').serializeArray(), function(i, field) {
                        orderData[field.name] = field.value;
                        //alert(field.name);
                    });
                    var customerName = $("input[name='customerName']" ).val();
                    var customerLastName = $("input[name='customerLastName']" ).val();
                    var customerEmail = $("input[name='customerEmail']" ).val();
                    var customerPhone = $("input[name='customerPhone']" ).val();
                    var customerAddress = $("input[name='customerAddress']" ).val();
                    var customerCity = $("input[name='customerCity']" ).val();
                    var customerZipCode = $("input[name='customerZipCode']" ).val();
                    //var customerPaymentType = $("select[name='customerPaymentMethod'] :selected" ).val();
                    var customerPaymentType = $('.jq_payment-option.-checked').attr("value");
    
                    if($('.dn_recipient-address-trigger').hasClass('-checked')){
                        var recipientName = $("input[name='recipientName']" ).val();
                        var recipientLastName = $("input[name='recipientLastName']" ).val();
                        var recipientPhone = $("input[name='recipientPhone']" ).val();
                        var recipientAddress = $("input[name='recipientAddress']" ).val();
                        var recipientCity = $("input[name='recipientCity']" ).val();
                        var recipientZipCode = $("input[name='recipientZipCode']" ).val();
    
                    } else {
                        var recipientName = '';
                        var recipientLastName = '';
                        var recipientPhone = '';
                        var recipientAddress = '';
                        var recipientCity = '';
                        var recipientZipCode = '';
                    }
                    
    
                var deliveryType = $('.cms_delivery_metod').attr('deliverymetod');
                var deliveryPersonalId = 0;
                var deliveryServiceId = 0; 
                switch (deliveryType) {
                     case 'h':
                         deliveryPersonalId = 0;
                         deliveryServiceId = 0; 
                         break;
                     case 'p':
                         deliveryPersonalId = parseInt($("input[type='radio'][name='deliveryPersonal']:checked" ).val());
                         deliveryServiceId = 0; 
                         break;
                     case 'd':
                         deliveryPersonalId = 0;
                         deliveryServiceId = parseInt($("input[type='radio'][name='deliveryService']:checked" ).val());
                         break;
                      default:
                         deliveryPersonalId = 0;
                         deliveryServiceId = 0; 
                 }
                 saveReservationData(customerName, customerLastName, customerEmail, customerPhone, customerAddress, customerCity, customerZipCode, customerPaymentType, recipientName, recipientLastName, recipientPhone, recipientAddress, recipientCity, recipientZipCode, deliveryType, deliveryPersonalId, deliveryServiceId,shopcartTotal,orderComment);


    });
    //Save data from shopcart end

    //ORDER FINISH ONE STEP

    $('.cms_order-onestep-to-finish').on('click', function(e){ 
        e.preventDefault();
        e.stopImmediatePropagation(); 
        
        $this = $(this);
        //var shopcartTotal=$this.attr('shopcart_total');
        //var shopcartTotalItems=$this.attr('shopcart_total_items');
       
        var langid = $(this).attr('lang');
        var currentLangCode = $(this).attr('langcode');
        var orderData = {};
        var orderComment=$('.cms_shopcartComment').val();
        var grr= $(".g-recaptcha-response").val();
        var haserror = false;


        var newsletterdata='';
        //newsletterdata='u='+$('.mu').val()+'&id='+$('.mid').val()+'&EMAIL='+$('.memail').val();
        
        

        if(eval($('.jq_captcha').text()) == $('.jq_captcha-input').val())
        {
        /*   
            $.ajax({
              type: "GET", // GET & url for json slightly different
              url: "https://mnk.us10.list-manage.com/subscribe/post-json?c=?",
              data: newsletterdata,
              dataType    : 'json',
              contentType: "application/json; charset=utf-8",
              error       : function(err) { alert("Nije moguće povezati se sa serverom."); },
              success     : function(data) {
                  if (data.result != "success") {
                      // Something went wrong, parse data.msg string and display message
                      //alertify.error('Došlo je do greške');
                     // alertify.error('Mail adresa već postoji u našoj mailing listi.');
                      //alertify.error(data.msg);
                  } else {
                      // It worked, so hide form and display thank-you message.
                      //alertify.success('Uspešno ste se prijavili na našu mailing listu.');
                      
                  }
            }
        });*/


           $('#cms_order-customer-form').find("input").each(function() {
            //alert($(this).val());
            if(!$(this).hasClass('cms_recipient') && $(this).attr('name')!='deliveryPersonal' && $(this).attr('name')!='deliveryService' ){
                //alert($(this).attr('name'));
                if ($(this).val() == '') {
                    $(this).parent(".my-label").addClass("has-error");
                    $(this).next(".help-block").removeClass("hide");
                    haserror = true;
                    //alert($(this).attr('name'));
                } else {
                    $(this).parent(".my-label").removeClass("has-error");
                    $(this).next(".help-block").addClass("hide");
    
                    }
                } 
            });
             //Provera nacina plaćanja
            //if($('.cms_customerPaymentMethod').val() == 'n'){
            if($('.jq_payment-option.-checked').length == 0){
                    $(this).parent(".my-label").addClass("has-error");
                    $(this).next(".help-block").removeClass("hide");
                    haserror = true;
                    msg = '';
                    switch (currentLangCode) {
                        case 'lat':
                            msg = 'Niste odabrali način plaćanja.';
                            break;
                        case 'eng':
                            msg = 'You have not selected a payment method.';
                            break;
                        case 'cir':
                            msg = 'Нисте одабрали начин плаћања.';
                            break;
                         default:
                            msg = 'Niste odabrali način plaćanja.';
                    }
                    alertify.error(msg);
                };
                //Provera nacina dostave
                var deliveryMetod = $('.cms_delivery_metod').attr('deliverymetod');
    
            if(deliveryMetod!='h'){
                var selected = false;
                if(deliveryMetod=='p'){
                    
                     $('.cms_delivery_personal_input').each(function() {
                        if($(this).attr('checked')=='checked'){
                            selected=true;
                        }
                     });
                }
                if(deliveryMetod=='d'){
                    $('.cms_delivery_service_input').each(function() {
                        if($(this).attr('checked')=='checked'){
                            selected=true;
                        }
                     });
                } 
                if(!selected){
                    haserror = true;
                    if(deliveryMetod=='p'){
                        msg = '';
                        switch (currentLangCode) {
                            case 'lat':
                                msg = 'Niste odabrali prodavnicu u kojoj želite da preuzmete porudžbinu.';
                                break;
                            case 'eng':
                                msg = 'You have not chosen the store where you want to pickup the order.';
                                break;
                            case 'cir':
                                msg = 'Нисте одабрали продавницу у којој желите да преузмете поруџбину.';
                                break;
                             default:
                                msg = 'Niste odabrali prodavnicu u kojoj želite da preuzmete porudžbinu.';
                        }
                        alertify.error(msg);
                    }
                    if(deliveryMetod=='d'){
                        msg = '';
                        switch (currentLangCode) {
                            case 'lat':
                                msg = 'Niste odabrali način dostave.';
                                break;
                            case 'eng':
                                msg = 'You have not selected a delivery method.';
                                break;
                            case 'cir':
                                msg = 'Нисте одабрали начин доставе.';
                                break;
                             default:
                                msg = 'Niste odabrali način dostave.';
                        }
                        alertify.error(msg);
                    }
                }           
            }
            //Provera saglasnosti uslova kupovine
            if(!$('.cms_accept-terms').hasClass('-checked')){
                haserror = true;
                 msg = '';
                 switch (currentLangCode) {
                     case 'lat':
                         msg = 'Niste prihvatili uslove kupovine.';
                         break;
                     case 'eng':
                         msg = 'You did not accept the terms and contitions.';
                         break;
                     case 'cir':
                         msg = 'Нисте прихватили услове куповине.';
                         break;
                      default:
                         msg = 'Niste prihvatili uslove kupovine.';
                 }
                 alertify.error(msg);
            }

            if (!haserror) {
                var shopcartTotal=0;//$('#cms_order-customer-form').attr('shopcart_total');
                    $.each($('#cms_order-customer-form').serializeArray(), function(i, field) {
                        orderData[field.name] = field.value;
                        //alert(field.name);
                    });
                    var customerName = $("input[name='customerName']" ).val();
                    var customerLastName = $("input[name='customerLastName']" ).val();
                    var customerEmail = $("input[name='customerEmail']" ).val();
                    var customerPhone = $("input[name='customerPhone']" ).val();
                    var customerAddress = $("input[name='customerAddress']" ).val();
                    var customerCity = $("input[name='customerCity']" ).val();
                    var customerZipCode = $("input[name='customerZipCode']" ).val();
                    //var customerPaymentType = $("select[name='customerPaymentMethod'] :selected" ).val();
                    var customerPaymentType = $('.jq_payment-option.-checked').attr("value");
    
                    if($('.dn_recipient-address-trigger').hasClass('-checked')){
                        var recipientName = $("input[name='recipientName']" ).val();
                        var recipientLastName = $("input[name='recipientLastName']" ).val();
                        var recipientPhone = $("input[name='recipientPhone']" ).val();
                        var recipientAddress = $("input[name='recipientAddress']" ).val();
                        var recipientCity = $("input[name='recipientCity']" ).val();
                        var recipientZipCode = $("input[name='recipientZipCode']" ).val();
    
                    } else {
                        var recipientName = '';
                        var recipientLastName = '';
                        var recipientPhone = '';
                        var recipientAddress = '';
                        var recipientCity = '';
                        var recipientZipCode = '';
                    }
                    
    
                var deliveryType = $('.cms_delivery_metod').attr('deliverymetod');
                var deliveryPersonalId = 0;
                var deliveryServiceId = 0; 
                switch (deliveryType) {
                     case 'h':
                         deliveryPersonalId = 0;
                         deliveryServiceId = 0; 
                         break;
                     case 'p':
                         deliveryPersonalId = parseInt($("input[type='radio'][name='deliveryPersonal']:checked" ).val());
                         deliveryServiceId = 0; 
                         break;
                     case 'd':
                         deliveryPersonalId = 0;
                         deliveryServiceId = parseInt($("input[type='radio'][name='deliveryService']:checked" ).val());
                         break;
                      default:
                         deliveryPersonalId = 0;
                         deliveryServiceId = 0; 
                 }
                
                createFastReservation(customerName, customerLastName, customerEmail, customerPhone, customerAddress, customerCity, customerZipCode, customerPaymentType, recipientName, recipientLastName, recipientPhone, recipientAddress, recipientCity, recipientZipCode, deliveryType, deliveryPersonalId, deliveryServiceId,shopcartTotal,orderComment,grr);
               
                
            } else {
                //alertify.error('Sva polja su obavezna!');
                 msg = '';
                 switch (currentLangCode) {
                     case 'lat':
                         msg = 'Sva polja su obavezna!';
                         break;
                     case 'eng':
                         msg = 'All fields are required!';
                         break;
                     case 'cir':
                         msg = 'Сва поља су обавезна!';
                         break;
                      default:
                         msg = 'Sva polja su obavezna!';
                 }
                 alertify.error(msg);
            }










        } else {
            alertify.error("Nevalidan rezultat "); 
        }
    });




    //ORDER FINISH ONE STEP END 
    //cms_finish_order
    $('.cms_delivery_choise-trigger').on('click', function() {
        
        
        	if($(this).val()=='p'){
        		$('.cms_delivery_choise-trigger').removeClass('-checked');
        		$(this).addClass('-checked');
        		$('.cms_delivery_service').removeAttr('checked');
        		$(this).attr('checked','checked');
        		if($(this).hasClass('-checked')){
        			$(".cms_delivery_pickup_checkout-choise").show();
        			$(".cms_delivery_service_checkout-choise").hide();
        			$(".cms_delivery_metod").attr('deliverymetod','p');
        		}	
        	}
            if($(this).val()=='d'){
            	$('.cms_delivery_choise-trigger').removeClass('-checked');
            	$(this).addClass('-checked');
            	$('.cms_delivery_personal').removeAttr('checked');
            	$(this).attr('checked','checked');
        		if($(this).hasClass('-checked')){
            		$(".cms_delivery_pickup_checkout-choise").hide();
        			$(".cms_delivery_service_checkout-choise").show();
        			$(".cms_delivery_metod").attr('deliverymetod','d');
        		}	
        	}
        
    });
    $('.cms_delivery_personal_input').on('click', function() {
    	var id=$(this).val();
    	$('.cms_delivery_personal_input').each(function(){
      		if($(this).val() !== id){
       		 	$(this).removeAttr("checked");
      		}
    	});
    	$(this).attr( "checked", 'checked' );
    });
    $('.cms_delivery_service_input').on('click', function() {
    	var id=$(this).val();
    	$('.cms_delivery_service_input').each(function(){
      		if($(this).val() !== id){
       		 	$(this).removeAttr("checked");
      		}
    	});
    	$(this).attr( "checked", 'checked' );
    });
    $("#cms_order-customer-form").on("submit", function(event) {
    	event.preventDefault();
    	var langid = $(this).attr('lang');
    	var currentLangCode = $(this).attr('langcode');
        var orderData = {};
        //var orderRecipientData = {};
        var haserror = false;

        
        $('#cms_order-customer-form').find("input").each(function() {
        	//alert($(this).val());
        if(!$(this).hasClass('cms_recipient') && $(this).attr('name')!='deliveryPersonal' && $(this).attr('name')!='deliveryService' ){
        	//alert($(this).attr('name'));
            if ($(this).val() == '') {
                $(this).parent(".my-label").addClass("has-error");
                $(this).next(".help-block").removeClass("hide");
                haserror = true;
                //alert($(this).attr('name'));
            } else {
                $(this).parent(".my-label").removeClass("has-error");
                $(this).next(".help-block").addClass("hide");

            }
        } 
        });
        //Provera nacina plaćanja
        if($('.cms_customerPaymentMethod').val() == 'n'){
        	$(this).parent(".my-label").addClass("has-error");
            $(this).next(".help-block").removeClass("hide");
            haserror = true;
            msg = '';
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Niste odabrali način plaćanja.';
                    break;
                case 'eng':
                    msg = 'You have not selected a payment method.';
                    break;
                case 'cir':
                    msg = 'Нисте одабрали начин плаћања.';
                    break;
                 default:
                    msg = 'Niste odabrali način plaćanja.';
            }
            alertify.error(msg);
        };
        //Provera nacina dostave
        var deliveryMetod = $('.cms_delivery_metod').attr('deliverymetod');

        if(deliveryMetod!='h'){
        	var selected = false;
			if(deliveryMetod=='p'){
				
				 $('.cms_delivery_personal_input').each(function() {
				 	if($(this).attr('checked')=='checked'){
				 		selected=true;
				 	}
				 });
        	}
        	if(deliveryMetod=='d'){
        		$('.cms_delivery_service_input').each(function() {
				 	if($(this).attr('checked')=='checked'){
				 		selected=true;
				 	}
				 });
        	} 
        	if(!selected){
        		haserror = true;
        		if(deliveryMetod=='p'){
                    msg = '';
                    switch (currentLangCode) {
                        case 'lat':
                            msg = 'Niste odabrali prodavnicu u kojoj želite da preuzmete porudžbinu.';
                            break;
                        case 'eng':
                            msg = 'You have not chosen the store where you want to pickup the order.';
                            break;
                        case 'cir':
                            msg = 'Нисте одабрали продавницу у којој желите да преузмете поруџбину.';
                            break;
                         default:
                            msg = 'Niste odabrali prodavnicu u kojoj želite da preuzmete porudžbinu.';
                    }
                    alertify.error(msg);
        		}
        		if(deliveryMetod=='d'){
                    msg = '';
                    switch (currentLangCode) {
                        case 'lat':
                            msg = 'Niste odabrali način dostave.';
                            break;
                        case 'eng':
                            msg = 'You have not selected a delivery method.';
                            break;
                        case 'cir':
                            msg = 'Нисте одабрали начин доставе.';
                            break;
                         default:
                            msg = 'Niste odabrali način dostave.';
                    }
                    alertify.error(msg);
        		}
        	}       	
        }
        //Provera saglasnosti uslova kupovine
        if(!$('.cms_accept-terms').hasClass('-checked')){
            haserror = true;
             msg = '';
             switch (currentLangCode) {
                 case 'lat':
                     msg = 'Niste prihvatili uslove kupovine.';
                     break;
                 case 'eng':
                     msg = 'You did not accept the terms and contitions.';
                     break;
                 case 'cir':
                     msg = 'Нисте прихватили услове куповине.';
                     break;
                  default:
                     msg = 'Niste prihvatili uslove kupovine.';
             }
             alertify.error(msg);
        }




        
        //console.log(values);
        if (!haserror) {
        	$.each($('#cms_order-customer-form').serializeArray(), function(i, field) {
            	orderData[field.name] = field.value;
                //alert(field.name);
        	});
            var customerName = $("input[name='customerName']" ).val();
            var customerLastName = $("input[name='customerLastName']" ).val();
            var customerEmail = $("input[name='customerEmail']" ).val();
            var customerPhone = $("input[name='customerPhone']" ).val();
            var customerAddress = $("input[name='customerAddress']" ).val();
            var customerCity = $("input[name='customerCity']" ).val();
            var customerZipCode = $("input[name='customerZipCode']" ).val();
            var customerVoucher = $("input[name='customerVoucher']" ).val();
            var customerPaymentType = $("select[name='customerPaymentMethod'] :selected" ).val();

            if($('.dn_recipient-address-trigger').hasClass('-checked')){
                var recipientName = $("input[name='recipientName']" ).val();
                var recipientLastName = $("input[name='recipientLastName']" ).val();
                var recipientPhone = $("input[name='recipientPhone']" ).val();
                var recipientAddress = $("input[name='recipientAddress']" ).val();
                var recipientCity = $("input[name='recipientCity']" ).val();
                var recipientZipCode = $("input[name='recipientZipCode']" ).val();

            } else {
                var recipientName = '';
                var recipientLastName = '';
                var recipientPhone = '';
                var recipientAddress = '';
                var recipientCity = '';
                var recipientZipCode = '';
            }
            

            var deliveryType = $('.cms_delivery_metod').attr('deliverymetod');
            var deliveryPersonalId = 0;
            var deliveryServiceId = 0; 
            switch (deliveryType) {
                 case 'h':
                     deliveryPersonalId = 0;
                     deliveryServiceId = 0; 
                     break;
                 case 'p':
                     deliveryPersonalId = parseInt($("input[type='radio'][name='deliveryPersonal']:checked" ).val());
                     deliveryServiceId = 0; 
                     break;
                 case 'd':
                     deliveryPersonalId = 0;
                     deliveryServiceId = parseInt($("input[type='radio'][name='deliveryService']:checked" ).val());
                     break;
                  default:
                     deliveryPersonalId = 0;
                     deliveryServiceId = 0; 
             }
            
            orderSetInfoData(customerName, customerLastName, customerEmail, customerPhone, customerAddress, customerCity, customerZipCode, customerVoucher ,customerPaymentType, recipientName, recipientLastName, recipientPhone, recipientAddress, recipientCity, recipientZipCode, deliveryType, deliveryPersonalId, deliveryServiceId);
            //alert('Saljem podatke');//orderData.customerName
            
        } else {
            //alertify.error('Sva polja su obavezna!');
             msg = '';
             switch (currentLangCode) {
                 case 'lat':
                     msg = 'Sva polja su obavezna!';
                     break;
                 case 'eng':
                     msg = 'All fields are required!';
                     break;
                 case 'cir':
                     msg = 'Сва поља су обавезна!';
                     break;
                  default:
                     msg = 'Sva polja su obavezna!';
             }
             alertify.error(msg);
        }
    });    
    //ORDER FINISH END

    //ORDER OFFER
    $("#cms_order-offer-form").on("submit", function(event) {
        event.preventDefault();
        var langid = $(this).attr('lang');
        var currentLangCode = $(this).attr('langcode');
        var orderData = {};
        //var orderRecipientData = {};
        var haserror = false;

        
        $('#cms_order-offer-form').find("input").each(function() {
            //alert($(this).val());
        if($(this).attr('name')=='customerEmail' && $(this).val()=='' ){
            //alert($(this).attr('name'));
            if ($(this).val() == '') {
                $(this).parent(".my-label").addClass("has-error");
                $(this).next(".help-block").removeClass("hide");
                haserror = true;
                //alert($(this).attr('name'));
            } else {
                $(this).parent(".my-label").removeClass("has-error");
                $(this).next(".help-block").addClass("hide");

            }
        } 
        
        if($(this).attr('name')=='customerPhone' && $(this).val()=='' ){
            //alert($(this).attr('name'));
            if ($(this).val() == '') {
                $(this).parent(".my-label").addClass("has-error");
                $(this).next(".help-block").removeClass("hide");
                haserror = true;
                //alert($(this).attr('name'));
            } else {
                $(this).parent(".my-label").removeClass("has-error");
                $(this).next(".help-block").addClass("hide");

            }
        } 
        });
        
        

        
        //Provera saglasnosti uslova kupovine
        /*if(!$('.cms_accept-terms').hasClass('-checked')){
            haserror = true;
             msg = '';
             switch (currentLangCode) {
                 case 'lat':
                     msg = 'Niste prihvatili uslove kupovine.';
                     break;
                 case 'eng':
                     msg = 'You did not accept the terms and contitions.';
                     break;
                 case 'cir':
                     msg = 'Нисте прихватили услове куповине.';
                     break;
                  default:
                     msg = 'Niste prihvatili uslove kupovine.';
             }
             alertify.error(msg);
        }*/




        
        //console.log(values);
        if (!haserror) {
            $.each($('#cms_order-offer-form').serializeArray(), function(i, field) {
                orderData[field.name] = field.value;
                //alert(field.name);
            });
            var customerName = $("input[name='customerName']" ).val();
            var customerLastName = $("input[name='customerLastName']" ).val();
            var customerEmail = $("input[name='customerEmail']" ).val();
            var customerPhone = $("input[name='customerPhone']" ).val();
           
            
            orderOfferSetInfoData(customerName, customerLastName, customerEmail, customerPhone);
            //alert('Saljem podatke');//orderData.customerName
            
        } else {
            //alertify.error('Sva polja su obavezna!');
             msg = '';
             switch (currentLangCode) {
                 case 'lat':
                     msg = 'Polja Email i Broj telefona su obavezna!';
                     break;
                 case 'eng':
                     msg = 'Fields Email and Phone are required!';
                     break;
                 case 'cir':
                     msg = 'Поља Емаил и Број телефона су обавезна!';
                     break;
                  default:
                     msg = 'Polja Email i Broj telefona su obavezna!';
             }
             alertify.error(msg);
        }
    });    
    //ORDER OFFER END

    //COMMERCIALIST
    $(".commercialist_remove_select_partnerBTN").on("click", function() {
    	commercialist_remove_select_partner();
    });
    
    //COMMERCIALIST END


	if($('.container_commercilalist_partner').attr('partnerid')>=0){
		get_commercialist_partners();
	}
	$('#cms_select_map').on("change", function() {
		var coordinates = $(this).val().split(',');
		var sort =$(this).find(':selected').attr("sortid");

		newlat = 1*coordinates[0],
		newlng = 1*coordinates[1];
		//map.setZoom(newzoom);
		map.setCenter({lat:newlat, lng:newlng});
		//Clear all infoWindows if opened
  		for (var i = 0; i < infowindows.length; i++) {
  			infowindows[i].close();
  			//var data = markers[i];
  			//data.infowindow.close(map, markers[i]);
  		}
  		//Simulate click on selected marker witch belongs to equivalent select option
		google.maps.event.trigger(markers[sort], 'click');

	});	
	
	$('#order_payment').submit(function(event) {
        event.preventDefault();
        if(	$('.cms_payment.active').length > 0){
			setOrderingPayment($('.order-paymant.active').attr('paymenttype'));
		}

    });
	
	 $(".core_rebYesSelectValueCheckbox").on("click", function() {

        var currpath = window.location.pathname + window.location.search;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            var reg = "&reb=" + $(this).val();
            var currpath1 = currpath.replace(reg, '');
            var currpath1 = currpath1.replace("&&", '&');

            if (currpath[currpath1.length - 1] == '?') {
                currpath1 = currpath1.slice(0, -1);
            }

            window.location = currpath1;

        } else {
            $(this).addClass('selected');

            var str = window.location.pathname;
            var lastChar = currpath.indexOf('?');

            var char = '';
            if (lastChar == -1) { char = '?' }

            window.location = window.location + char + "&reb=" + $(this).val();

        }
    }); 
	
	
    $(".core_extraDetailSelectValueCheckbox").on("click", function() {

        var currpath = window.location.pathname + window.location.search;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            var reg = "&ed[]=" + $(this).attr('extradetailid');
            var currpath1 = currpath.replace(reg, '');
            var currpath1 = currpath1.replace("&&", '&');

            if (currpath[currpath1.length - 1] == '?') {
                currpath1 = currpath1.slice(0, -1);
            }

            window.location = currpath1;

        } else {
            $(this).addClass('selected');

            var str = window.location.pathname;
            var lastChar = currpath.indexOf('?');

            var char = '';
            if (lastChar == -1) { char = '?' }

            window.location = window.location + char + "&ed[]=" + $(this).attr('extradetailid');

        }
    });	

    $(".core_brendsSelectValueCheckbox").on("click", function() {

        var currpath = window.location.pathname + window.location.search;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            var reg = "&bd[]=" + $(this).attr('brendid');
            var currpath1 = currpath.replace(reg, '');
            var currpath1 = currpath1.replace("&&", '&');

            if (currpath[currpath1.length - 1] == '?') {
                currpath1 = currpath1.slice(0, -1);
            }

            window.location = currpath1;

        } else {
            $(this).addClass('selected');

            var str = window.location.pathname;
            var lastChar = currpath.indexOf('?');

            var char = '';
            if (lastChar == -1) { char = '?' }

            window.location = window.location + char + "&bd[]=" + $(this).attr('brendid');

        }
    });	
	
	//*********************************--------------------------------------------*************************************************
	
	
	$('.cms_productMinMax').on("submit", function(e){
		e.preventDefault();
		minVal = parseInt($(this).find('.cms_minProductValue').val());
		maxVal = parseInt($(this).find('.cms_maxProductValue').val());
		//alert(minVal);
		
		//var values = Myslider.bootstrapSlider('getValue');
        var currpath = window.location.pathname + window.location.search;
        var questionmark = '';
        if (currpath.search(/\?/g) == -1) { questionmark = '?'; }

		if(minVal>=0 && minVal!=""){
			if (currpath.search(/&min=[0-9]*\.?[0-9]*/g) > -1) {
				currpath = currpath.replace(/&min=[0-9]*\.?[0-9]*/g, '&min=' + minVal);
			} else {
				currpath = currpath + questionmark + '&min=' + minVal;
			}
		} else {
			currpath = currpath.replace(/&min=[0-9]*\.?[0-9]*/g, '' );
		}
		if(maxVal>0 && maxVal!=""){
			if (currpath.search(/&max=[0-9]*\.?[0-9]*/g) > -1) {
				currpath = currpath.replace(/&max=[0-9]*\.?[0-9]*/g, '&max=' + maxVal);
			} else {
				currpath = currpath + questionmark + '&max=' + maxVal;
			}
		}	else {
			currpath = currpath.replace(/&max=[0-9]*\.?[0-9]*/g, '' );
		}

        window.location = currpath;
		
		
		
		
	});	
	
	
	
	
	
	// 	+/- product
	/*	Product dec button	*/
	
	$(document).on('click', '.cms_productInputDecButton', function(){
		var currentLangCode = $(this).parents('.cms_productInputDecIncCont').attr('langcode');
		var step = parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').attr('step'));
		var oldquantity =parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').val());
		var newuantity = Math.round((oldquantity-step)*100)/100  ;

		
		if(newuantity>=step){
			$(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').val(newuantity);
		}else {
			msg = '';
			switch (currentLangCode) {
                case 'lat':
                    msg = 'Minimalna dozvoljena količina je '+step;
                    break;
                case 'eng':
                    msg = 'Minimal alowed quantity is '+step;
                    break;
                case 'cir':
                    msg = 'Минимална дозвољена количина је'+step;
                    break;
                 default:
                 	msg = 'Minimalna dozvoljena količina je '+step;
            }
			//alert(msg);
			alertify.alert(msg);

			$(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').val(step);
		}
	});

        $(document).on('click', '.cms_productInputDecButtonRequest', function(){
        var currentLangCode = $(this).parents('.cms_productInputDecIncCont').attr('langcode');
        var step = parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').attr('step'));
        var oldquantity =parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').val());
        var newuantity = Math.round((oldquantity-step)*100)/100  ;

        
        if(newuantity>=step){
            $(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').val(newuantity);
        }else {
            msg = '';
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Minimalna dozvoljena količina je '+step;
                    break;
                case 'eng':
                    msg = 'Minimal alowed quantity is '+step;
                    break;
                case 'cir':
                    msg = 'Минимална дозвољена количина је'+step;
                    break;
                 default:
                    msg = 'Minimalna dozvoljena količina je '+step;
            }
            //alert(msg);
            alertify.alert(msg);

            $(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').val(step);
        }
    });
	
	/*	Product inc button	*/
	
	$(document).on('focus', '.cms_productQtyInput', function(){
		var theValue = $(this).val();
        $(this).data("value", theValue);
	});
	$(document).on('change', '.cms_productQtyInput', function(){
		var previousValue = $(this).data("value");
		var currentLangCode = $(this).parents('.cms_productInputDecIncCont').attr('langcode');
		var step = parseFloat($(this).attr('step'));
		var max = parseFloat($(this).attr('max'));
		var quantity =parseFloat($(this).val());
		var reminder = quantity % step;
		var finished = 0;
		msg = '';
		if($(this).val()==''){
			finished = 1;
			switch (currentLangCode) {
                case 'lat':
                    msg = 'Uneta vrednost nije validna.';
                    break;
                case 'eng':
                    msg = 'Entered value is not valid.';
                    break;
                case 'cir':
                    msg = 'Унета вредност није валидна.';
                    break;
                 default:
                 	msg = 'Uneta vrednost nije validna.';
            }
			$(this).val(step);
			//alert(msg);
			alertify.alert(msg);
		}
		if(reminder>0  && finished ==0){
			switch (currentLangCode) {
                case 'lat':
                    msg = 'Uneta vrednost nije validna.\nUneta vrednost mora biti deljiva sa '+step;
                    break;
                case 'eng':
                    msg = 'Entered value is not valid.\nThe enetered value must be divisible with '+step;
                    break;
                case 'cir':
                    msg = 'Унета вредност није валидна.\nУнета вредност мора бити делјива са '+step;
                    break;
                 default:
                 	msg = 'Uneta vrednost nije validna.\nUneta vrednost mora biti deljiva sa '+step;
            }
			$(this).val(previousValue);
			//alert(msg);
			alertify.alert(msg);
		}
		

		if(quantity<step && quantity<=max && finished ==0 ){
			switch (currentLangCode) {
                case 'lat':
                    msg = 'Minimalna dozvoljena količina je '+step;
                    break;
                case 'eng':
                    msg = 'Minimal alowed quantity is '+step;
                    break;
                case 'cir':
                    msg = 'Минимална дозвољена количина је'+step;
                    break;
                 default:
                 	msg = 'Minimalna dozvoljena količina je '+step;
            }
			$(this).val(step);
			//alert(msg);
			alertify.alert(msg);
		}
		if(quantity>max && finished ==0){
			
			switch (currentLangCode) {
                case 'lat':
                    msg = 'Uneta količina je veća od raspoložive.';
                    break;
                case 'eng':
                    msg = 'Selected quantity is unavailable.';
                    break;
                case 'cir':
                    msg = 'Унета количина је већа од расположиве.';
                    break;
                 default:
                 	msg = 'Uneta količina je veća od raspoložive.';
            }
			$(this).val(max);
			//alert(msg);
			alertify.alert(msg);
		}
		

	});


    $(document).on('change', '.cms_productQtyInputRequest', function(){
        var previousValue = $(this).data("value");
        var currentLangCode = $(this).parents('.cms_productInputDecIncCont').attr('langcode');
        var step = parseFloat($(this).attr('step'));
        var quantity =parseFloat($(this).val());
        var reminder = quantity % step;
        var finished = 0;
        msg = '';
        if($(this).val()==''){
            finished = 1;
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Uneta vrednost nije validna.';
                    break;
                case 'eng':
                    msg = 'Entered value is not valid.';
                    break;
                case 'cir':
                    msg = 'Унета вредност није валидна.';
                    break;
                 default:
                    msg = 'Uneta vrednost nije validna.';
            }
            $(this).val(step);
            //alert(msg);
            alertify.alert(msg);
        }
        if(reminder>0  && finished ==0){
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Uneta vrednost nije validna.\nUneta vrednost mora biti deljiva sa '+step;
                    break;
                case 'eng':
                    msg = 'Entered value is not valid.\nThe enetered value must be divisible with '+step;
                    break;
                case 'cir':
                    msg = 'Унета вредност није валидна.\nУнета вредност мора бити делјива са '+step;
                    break;
                 default:
                    msg = 'Uneta vrednost nije validna.\nUneta vrednost mora biti deljiva sa '+step;
            }
            $(this).val(previousValue);
            //alert(msg);
            alertify.alert(msg);
        }
        if(quantity<step && finished ==0 ){
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Minimalna dozvoljena količina je '+step;
                    break;
                case 'eng':
                    msg = 'Minimal alowed quantity is '+step;
                    break;
                case 'cir':
                    msg = 'Минимална дозвољена количина је'+step;
                    break;
                 default:
                    msg = 'Minimalna dozvoljena količina je '+step;
            }
            $(this).val(step);
            //alert(msg);
            alertify.alert(msg);
        }

    });
	

	$(document).on('click', '.cms_productInputIncButton', function(){
		var currentLangCode = $(this).parents('.cms_productInputDecIncCont').attr('langcode');
		var step = parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').attr('step'));
		var max = parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').attr('max'));
		var oldquantity =parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').val());
		var newuantity = Math.round((oldquantity+step)*100)/100  ;

		
		msg = '';
		if(newuantity>max){
			switch (currentLangCode) {
                case 'lat':
                    msg = 'Кoličina '+newuantity+' je veća od raspoložive.';
                    break;
                case 'eng':
                    msg = 'Quantity '+newuantity+' is unavailable.';
                    break;
                case 'cir':
                    msg = 'Количина '+newuantity+' је већа од расположиве.';
                    break;
                 default:
                 	msg = 'Кoličina '+newuantity+' je veća od raspoložive.';
            }
			$(this).val( Math.round((max)*100)/100 );
			//alert(msg);
			alertify.alert(msg);
		} else {
			$(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInput').val(newuantity);
		}


	});

    $(document).on('click', '.cms_productInputIncButtonRequest', function(){
        var currentLangCode = $(this).parents('.cms_productInputDecIncCont').attr('langcode');
        var step = parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').attr('step'));
        var oldquantity =parseFloat($(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').val());
        var newuantity = Math.round((oldquantity+step)*100)/100  ;
        
        msg = '';
        
        $(this).parents('.cms_productInputDecIncCont').find('.cms_productQtyInputRequest').val(newuantity);
        


    });
	
	$('#product_qty').on('blur', function(){
		if($(this).val() < 0 || isNaN($(this).val()) ){
			$(this).val(1);
		}
	});

    $('#product_request_qty').on('blur', function(){
        if($(this).val() < 0 || isNaN($(this).val()) ){
            $(this).val(1);
        }
    });

    // .+/- product
	
    // gallerys
    $("[gallery]").fancybox({
        hash:false
    });
	$.fancybox.defaults.hash = false;

    // .gallerys
    // order
    $('.order-paymant-check').on('click',function(){
    	if($(this).hasClass('trigger-collapse')){
    		$('#collapseUpl').slideDown('fast');
    	}else{
    		$('#collapseUpl').slideUp('fast');
    	}
    	if($(this).hasClass('trigger-collapse2')){
    		$('#collapseDelivery2').slideDown('fast');
    	}else{
    		$('#collapseDelivery2').slideUp('fast');
    	}
    	if($(this).hasClass('trigger-collapse3')){
    		$('#collapseDelivery3').slideDown('fast');
    	}else{
    		$('#collapseDelivery3').slideUp('fast');
    	}

      	$('.order-paymant-check').removeClass('active');
      	$('.order-paymant-check').parents('.chose-paymant').find('input').removeAttr('checked');
        
      	$(this).parents('.chose-paymant').find('input').attr('checked',true);
      	$(this).parents('.chose-paymant').find('input').click();
		$(this).addClass('active');
		

    });
    
    // $('.chose-paymant').on('click',function(){


    //     orderA = $('.chose-paymant').attr('aria-controls');
    //     orderId = $('.collapse').attr('id');
    //     $('.collapse').removeClass('in');

    //     if(orderA == orderId){
    //         $('.collapseParent').find('collapse').addClass('in');
    //     }
        
    // });


    $('.cms_newDataButton').on('click',function(){
		$(this).parents('form').find('.disabledInput').removeClass('disabledInput').addClass('enabledInput');
        
    });
    

    // .order
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	

	$('#delivery1, #delivery2').on('click', function(){
		$('.delivery_service_cont').find('input[type="radio"]').each(function(){
			$(this).prop('checked', false);		
		});	
		$(this).next('input[type="radio"]').prop('checked', true);
	});
	

	/*	USER PANEL	*/
	
	$(".changeUserDataButton").on('click', function(){
		$(".userDataName, .userDataLastname").removeAttr('disabled');
		$(this).addClass('hide');
		$(".saveUserDataButton").removeClass('hide');
		$(".cancelUserDataButton").removeClass('hide');
	});
	
	$(".cancelUserDataButton").on('click', function(){
		$(".userDataName").val($(".userDataName").attr('olddata')).attr('disabled', true);
		$(".userDataLastname").val($(".userDataLastname").attr('olddata')).attr('disabled', true);
		
		$(this).addClass('hide');
		$(".saveUserDataButton").addClass('hide');
		$(".changeUserDataButton").removeClass('hide');
	});
	
	
	$(".saveUserDataButton").on('click', function(){
		if($(".userDataName").val() != '' || $(".userDataLastname").val() != ''){
			var data = {
				action : 'saveuserdata',
				userid: $(".personal-info").attr('userid'),
				name: $(".userDataName").val(),
				lastname: $(".userDataLastname").val()
			};
			
			$.ajax({
				type: "POST",
				data: data,
				url: "index.php",
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("ERROR:" + errorThrown);
				},
				success: function (response) {
					if(response == 1){
						alertify.success('Uspesno snimljeno!');	
						
						$(".userDataName").attr('olddata', $(".userDataName").val()).attr('disabled', true);
						$(".userDataLastname").attr('olddata', $(".userDataLastname").val()).attr('disabled', true);
						
						$(".saveUserDataButton").addClass('hide');
						$(".cancelUserDataButton").addClass('hide');
						$(".changeUserDataButton").removeClass('hide');	
					}
					else{
						alertify.error('Greska prilikom snimanja!');		
					}
					
				}
			});		
		}
		else{
			$(".userDataName").parents('.form-group').addClass('has-error');
			$(".userDataLastname").parents('.form-group').addClass('has-error');
			alertify.error('Popunite obavezna polja!');	
		}
	});
	
	$('.jq_startDateInput').datepicker({
		format: "yyyy-mm-dd"
	});
	$('.jq_endDateInput').datepicker({
		format: "yyyy-mm-dd"
	});
	
	$('.jq_startDateInput, .jq_endDateInput, .jq_inValuteSelect, .jq_deletedCheckbox').on("change", function() {
		if ( $.fn.DataTable.isDataTable( $("."+$(".jq_userpanelSectionButton.active").attr('target')+"Table") ) ) {
			var table = $("."+$(".jq_userpanelSectionButton.active").attr('target')+"Table").DataTable();
			table.draw();
		  
		 // $("."+$(".jq_userpanelSectionButton.active").attr('target')+"Table")
		}
	});
	
	/*	userpanel open document items modal	*/
	
	$(document).on('click', '.jq_openDocumentItemsButton', function(){
		getDocumentItems($(this));	
	});
	
	$(document).on('click', ".jq_userpanelSectionButton",  function(){
		var $this = $(this);
		$(".jq_userpanelSectionButton").removeClass('active');
		$('.jq_userpanelSectionCont').addClass('hide');
		$(this).addClass('active');
		$("."+$(this).attr('target')).removeClass('hide');
		$('.jq_documentSpecialOption').addClass('hide');
		$('.jq_documentSpecialOption[doctype="'+$(this).attr('doctype')+'"]').removeClass('hide');
		$('.jq_dateRangeInputCont').removeClass('hide');
		if($(this).attr('doctype') == 'upit'){
			$('.jq_dateRangeInputCont').addClass('hide');
		}
		
		
		if ( $.fn.DataTable.isDataTable( $("."+$(this).attr('target')+"Table") ) ) {
			var table = $("."+$(this).attr('target')+"Table").DataTable();
			table.draw();
		}
		else{
			$("."+$(this).attr('target')+"Table").dataTable({
				stateSave: true,
				"processing": true,
				"serverSide": true,
				"searching": false,
				"ajax":{
						url :"index.php", // json datasource
						"data"   : function( d ) {
							d.action= 'getpovratnice',
							d.startdate = $('.jq_startDateInput').val(),
							d.enddate = $('.jq_endDateInput').val(),
							d.doctype = $($this).attr('doctype'),
							d.invalute = $('.jq_inValuteSelect').val(),
							d.deleted = $('.jq_deletedCheckbox').prop('checked');
						},
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema vesti u bazi</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
						},
						dataSrc: function(d){
							//console.log(d);
							
							for(var i = 0; i < d.aaData.length;i++)
							{
								if($($this).attr('doctype') == 'e')
								{
									/*	rezervacije	*/
									var arr = '';
									for(var j = 0; j < d.aaData[i][4].length;j++)
									{
										var bc = '<p>'+d.aaData[i][4][j]['number']+' <button class="btn btn-primary btn-sm changeViewButton jq_openDocumentItemsButton" id="'+d.aaData[i][4][j]['documentid']+'" docnumber="'+d.aaData[i][4][j]['number']+'" doctype="r">Otvori</button></p>';
										arr+=bc;
									}
									d.aaData[i][4] = arr;	
									d.aaData[i][5] = '<button class="btn btn-default btn-sm changeViewButton jq_openDocumentItemsButton" id="'+d.aaData[i][99]+'" docnumber="'+d.aaData[i][1]+'" doctype="'+$('.jq_userpanelSectionButton.active').attr('doctype')+'">Otvori</button>';				
								}
								if($($this).attr('doctype') == 'r')
								{
									/*	fakture	*/
									d.aaData[i][6] = '<button class="btn btn-default btn-sm changeViewButton jq_openDocumentItemsButton" id="'+d.aaData[i][99]+'" docnumber="'+d.aaData[i][1]+'" doctype="'+$('.jq_userpanelSectionButton.active').attr('doctype')+'">Otvori</button>';	
								}
								if($($this).attr('doctype') == 'p')
								{
									/*	povrat	*/
									d.aaData[i][4] = '<button class="btn btn-default btn-sm changeViewButton jq_openDocumentItemsButton" id="'+d.aaData[i][99]+'" docnumber="'+d.aaData[i][1]+'" doctype="'+$('.jq_userpanelSectionButton.active').attr('doctype')+'">Otvori</button>';	
								}
								if($($this).attr('doctype') == 'k')
								{
									/*	knjizna	*/
									d.aaData[i][4] = '<button class="btn btn-default btn-sm changeViewButton jq_openDocumentItemsButton" id="'+d.aaData[i][99]+'" docnumber="'+d.aaData[i][1]+'" doctype="'+$('.jq_userpanelSectionButton.active').attr('doctype')+'">Otvori</button>';	
								}
								if($($this).attr('doctype') == 'z')
								{
									/*	zamena	*/
									d.aaData[i][4] = '<button class="btn btn-default btn-sm changeViewButton jq_openDocumentItemsButton" id="'+d.aaData[i][99]+'" docnumber="'+d.aaData[i][1]+'" doctype="'+$('.jq_userpanelSectionButton.active').attr('doctype')+'">Otvori</button>';	
								}
								
							}
							
							return d.aaData;
						}
						
					},
				"language": {
						"emptyTable":     "No data available in table",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ dokumenta",
						"infoEmpty":      "Prikaz 0 do 0 od 0 vesti",
						"infoFiltered":   "(filtrirano od _MAX_ dokumenta)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ dokumenta",
						"loadingRecords": "Ucitavanje...",
						"processing":     "Obrada...",
						"search":         "Pretraga:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Zadnja",
							"next":       "Sledeca",
							"previous":   "Predhodna"
						}
					}
				});	
			}
	});
	
	/*	USERPANEL END	*/

    setTimeout(function() {
    	newsL = true;
    	if(newsL){
    		$('.newsletter-holder').css('right','0');
    		var newsL = false;
    	}else{
    		$('.newsletter-holder').css('right','-370px');
    	}
       	
       	
    }, 3000);
    $('#close-news').on('click',function(){
    	$('.newsletter-holder').css('right','-370px');
    });
    /*	add new newsletter email	*/

    $('.addNewsletterButton').on('click', function(e) {
        e.preventDefault();
        if ($('.newsletterInput').val() != '') {
            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if (pattern.test($('.newsletterInput').val())) {
                addNewsletter($('.newsletterInput').val());
            } else {
                alertify.alert("Uneta email adresa nije validna! Unesite validnu email adresu.");
            }
        } else {
            alertify.alert("Unesite email adresu!");
        }
    });
	
    $('.addNewsletterButton1').on('click', function(e) {
        e.preventDefault();
        if ($('.newsletterInput1').val() != '') {
            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if (pattern.test($('.newsletterInput1').val())) {
                addNewsletter($('.newsletterInput1').val());
            } else {
                alertify.alert("Uneta email adresa nije validna! Unesite validnu email adresu.");
            }
        } else {
            alertify.alert("Unesite email adresu!");
        }
    });

    $('#order_address').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#order_address').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        console.log(values);

        setOrderingAddress(values.ime, values.prezime, values.adresa, values.telefon, values.mesto, values.postbr, values.email);


    });
	
    $('#order_address_delivery').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#order_address_delivery').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        console.log(values);

        setOrderingAddressDelivery(values.ime, values.prezime, values.adresa, values.telefon, values.mesto, values.postbr, values.email);


    });

    
    //dodaj u korpu
    $(".product_add_to_shopcart").on('click', function() {
        $(this).attr('disabled',true);
        var productID = $(this).attr('prodid');
        var productName = $(this).attr('prodname');
        var productPic = $(this).attr('prodpic');

        var productPrice = $(this).attr('prodprice');
        var prodtax = $(this).attr('prodtax');
        var prodrebate = $(this).attr('prodrebate');
        var currentLang = $(this).attr('lang');
        var currentLangCode = $(this).attr('langcode');
        var productQty = $(this).parent().find('#product_qty').val();
        var attr = $(this).attr('attr');
        var unitname = $(this).attr('unitname');
        var unitstep = $(this).attr('unitstep');


        var attrsid = $.map($(".attr-val-select"), function(n) {
            return n.id;
        });
        var atr = [];
        var atrval = "-1";

        var flag = 1;
        var i = 0;
        var finalattr = '';

        
        if($(this).hasClass('productBoxLine')) { //PRODUCT BOX LINE
            finalattr = attr;
            //alert('y');
        } else { //PRODUCT PAGE
        	//alert('n');
            $(".cms_proDetAttrCont[mandatory='1']").each(function() {
                var items = $(this).find('.cms_proDetAttrItem.selected').length;

                if (items > 0) {
                    atr[i] = [$(this).attr('attrid'), $(this).find('.cms_proDetAttrItem.selected').attr('attrvalid')];
                } else {
                    atr[i] = [$(this).attr('attrid'), -1];
                    flag = 0;
                }
                i++;
                finalattr = JSON.stringify(atr);
            });
        }




        if (flag == 0) {
            var msg = "";
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Izaberite atribute proizvoda.';
                    break;
                case 'eng':
                    msg = 'Choose products attributes.';
                    break;
                case 'cir':
                    msg = 'Изаберите атрибуте производа.';
                    break;
                 default:
                 	msg = 'Izaberite atribute proizvoda.';
            }
            alertify.error(msg);
            //showNotification(msg, 'error');
        } else {

           
            var max= 0;
             $( ".cms_productInputDecIncCont" ).each(function() {
                if( ($( this ).attr('prodid')==productID) && ($( this ).attr('attr')==attr)){
                    max =  parseFloat($( this ).find('.cms_productQtyInput').attr('max'));  
                }
            });
            if(max>0){
                 addToShopcart(productID, productName, productPrice, prodrebate, prodtax, productPic, productQty, finalattr, currentLang, currentLangCode, unitname, unitstep);
            } else {
                var msg="";
                switch (currentLangCode) {
                case 'lat':
                    msg = 'Nema raspolozivih kolicina';
                    break;
                case 'eng':
                    msg = 'Nema raspolozivih kolicina';
                    break;
                case 'cir':
                    msg = 'Nema raspolozivih kolicina';
                    break;
                 default:
                    msg = 'Nema raspolozivih kolicina';
                 }
                 alertify.error(msg);
            }

        }
        $(this).removeAttr('disabled');
    });
    

    $(".product_add_to_shopcart_request").on('click', function() {
        $(this).attr('disabled',true);
        var productID = $(this).attr('prodid');
        var productName = $(this).attr('prodname');
        var productPic = $(this).attr('prodpic');
        var productPrice = $(this).attr('prodprice');
        var prodtax = $(this).attr('prodtax');
        var prodrebate = $(this).attr('prodrebate');
        var currentLang = $(this).attr('lang');
        var currentLangCode = $(this).attr('langcode');
        var productQty = $(this).parent().find('#product_request_qty').val();
        var attr = $(this).attr('attr');
        var unitname = $(this).attr('unitname');
        var unitstep = $(this).attr('unitstep');

        var attrsid = $.map($(".attr-val-select"), function(n) {
            return n.id;
        });
        var atr = [];
        var atrval = "-1";

        var flag = 1;
        var i = 0;
        var finalattr = '';

        if ($(this).hasClass('productBoxLine')) { //PRODUCT BOX LINE
            finalattr = attr;
        } else { //PRODUCT PAGE
            $(".cms_proDetAttrCont[mandatory='1']").each(function() {
                var items = $(this).find('.cms_proDetAttrItem.selected').length;

                if (items > 0) {
                    atr[i] = [$(this).attr('attrid'), $(this).find('.cms_proDetAttrItem.selected').attr('attrvalid')];
                } else {
                    atr[i] = [$(this).attr('attrid'), -1];
                    flag = 0;
                }
                i++;
                finalattr = JSON.stringify(atr);
            });
        }




        if (flag == 0) {
            var msg = "";
            switch (currentLangCode) {
                case 'lat':
                    msg = 'Izaberite atribute proizvoda.';
                    break;
                case 'eng':
                    msg = 'Choose products attributes.';
                    break;
                case 'cir':
                    msg = 'Изаберите атрибуте производа.';
                    break;
                 default:
                 	msg = 'Izaberite atribute proizvoda.';
            }
            alertify.error(msg);
            //showNotification(msg, 'error');
        } else {

            addToShopcartRequest(productID, productName, productPrice, prodrebate, prodtax, productPic, productQty, finalattr, currentLang, currentLangCode , unitname, unitstep);
        }
        $(this).removeAttr('disabled');
    });
    //ADD TO B2B CHART
    $(".product_add_to_shopcartB2B").on('click', function() {
        $(this).attr('disabled',true);
    	//alert(unitstep);
        $this = $(this);
         var infoQty = $(this).parent('td').find('.cms_product_with_attribut_quantity_in_chart');

        $($this).parent('td').find('span.jq_productLineSpinner').removeClass('hide');
        $.ajax({
            type: "POST",
            data: { action: 'isloged' },
            url: "index.php",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function(res) {
                if (res == 1) {
                    var productID = $($this).attr('prodid');
                    var productName = $($this).attr('prodname');
                    var productPic = $($this).attr('prodpic');
                    var productPrice = $($this).attr('prodprice');
                    var prodtax = $($this).attr('prodtax');
                    var prodrebate = $($this).attr('prodrebate');
                    var currentLang = $($this).attr('lang');
                    var currentLangCode = $($this).attr('langcode');
                    var productQty = $($this).parent().parent().find('#product_qty').val();
                    var attr = $($this).attr('attr');
                    var unitname = $($this).attr('unitname');
                    var unitstep = $($this).attr('unitstep');
                    var flag = 1;
                    var atr = [];
                    var i = 0;
                    var finalattr = '';

                    if ($($this).hasClass('b2baddtocart')) {
                        finalattr = attr;
                    } else {
                        $(".cms_proDetAttrCont[mandatory='1']").each(function() {
                            var items = $(this).find('.cms_proDetAttrItem.selected').length;

                            if (items > 0) {
                                atr[i] = [$(this).attr('attrid'), $(this).find('.cms_proDetAttrItem.selected').attr('attrvalid')];
                            } else {
                                atr[i] = [$(this).attr('attrid'), -1];
                                flag = 0;
                            }
                            i++;
                            finalattr = JSON.stringify(atr);
                        });
                    }
                    if (flag == 0) {
                        var msg = "";
                        switch (currentLangCode) {
                            case 'lat':
                                msg = 'Izaberite atribute proizvoda.';
                                break;
                            case 'eng':
                                msg = 'Choose products attributes.';
                                break;
                            case 'cir':
                                msg = 'Изаберите атрибуте производа.';
                                break;
                             default:
                             	msg = 'Izaberite atribute proizvoda.';
                        }
                        //alertify.error(msg);
                        showNotification(msg, 'error');
                    } else {
                        if ($($this).hasClass('b2baddtocart')) {
                            setTimeout(function() {
                                $($this).parent('td').find('span.jq_productLineSpinner').addClass('hide');
                                $($this).parent('td').find('span.jq_productLineOK').removeClass('hide');
                            }, 300);

                        }
                        var max= 0;
                         $( ".cms_productInputDecIncCont" ).each(function() {
                            if( ($( this ).attr('prodid')==productID) && ($( this ).attr('attr')==attr)){
                                max =  parseFloat($( this ).find('.cms_productQtyInput').attr('max'));
                                

                            }
                            
                        });
                        if(max>0){
                        	addToShopcartB2B(productID, productName, productPrice, prodrebate, prodtax, productPic, productQty, finalattr, currentLang, currentLangCode, unitname, unitstep);
                        } else {
                        	var msg="";
                			switch (currentLangCode) {
                            case 'lat':
                                msg = 'Nema raspolozivih kolicina';
                                break;
                            case 'eng':
                                msg = 'Nema raspolozivih kolicina';
                                break;
                            case 'cir':
                                msg = 'Nema raspolozivih kolicina';
                                break;
                             default:
                             	msg = 'Nema raspolozivih kolicina';
                       		 }
                       		 alertify.error(msg);
                        }
                        
                        
                    }
                } else {
                	var msg="";
                	switch (currentLangCode) {
                            case 'lat':
                                msg = 'Morate se ulogovati kako bi dodali proizvod u korpu.';
                                break;
                            case 'eng':
                                msg = 'You must login to add product to shopcart.';
                                break;
                            case 'cir':
                                msg = 'Морате се улоговати како би додали производ у корпу.';
                                break;
                             default:
                             	msg = 'Morate se logovati kako bi dodali proizvod u korpu.';
                        }
                    alertify.error(msg);
                }
            }
        });

    $(this).removeAttr('disabled');

    });
    //ADD TO B2B CHART END //
    //ADD TO REQUEST B2B CHART //
    $(".product_add_to_shopcart_requestB2B").on('click', function() {
        $(this).attr('disabled',true);
        $this = $(this);
         var infoQty = $(this).parent('td').find('.cms_product_with_attribut_quantity_in_chart');

        $($this).parent('td').find('span.jq_productLineSpinner').removeClass('hide');
        $.ajax({
            type: "POST",
            data: { action: 'isloged' },
            url: "index.php",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function(res) {
                if (res == 1) {
                    var productID = $($this).attr('prodid');
                    var productName = $($this).attr('prodname');
                    var productPic = $($this).attr('prodpic');
                    var productPrice = $($this).attr('prodprice');
                    var prodtax = $($this).attr('prodtax');
                    var prodrebate = $($this).attr('prodrebate');
                    var currentLang = $($this).attr('lang');
                    var currentLangCode = $($this).attr('langcode');
                    var productQty = $($this).parent().parent().find('#product_request_qty').val();
                    var attr = $($this).attr('attr');
                    var unitname = $($this).attr('unitname');
                    var unitstep = $($this).attr('unitstep');
                    var flag = 1;
                    var atr = [];
                    var i = 0;
                    var finalattr = '';

                    if ($($this).hasClass('b2baddtocart')) {
                        finalattr = attr;
                    } else {
                        $(".cms_proDetAttrCont[mandatory='1']").each(function() {
                            var items = $(this).find('.cms_proDetAttrItem.selected').length;

                            if (items > 0) {
                                atr[i] = [$(this).attr('attrid'), $(this).find('.cms_proDetAttrItem.selected').attr('attrvalid')];
                            } else {
                                atr[i] = [$(this).attr('attrid'), -1];
                                flag = 0;
                            }
                            i++;
                            finalattr = JSON.stringify(atr);
                        });
                    }
                    if (flag == 0) {
                        var msg = "";
                        switch (currentLangCode) {
                            case 'lat':
                                msg = 'Izaberite atribute proizvoda.';
                                break;
                            case 'eng':
                                msg = 'Choose products attributes.';
                                break;
                            case 'cir':
                                msg = 'Изаберите атрибуте производа.';
                                break;
                             default:
                             	msg = 'Izaberite atribute proizvoda.';
                        }
                        //alertify.error(msg);
                        showNotification(msg, 'error');
                    } else {
                        if ($($this).hasClass('b2baddtocart')) {
                            setTimeout(function() {
                                $($this).parent('td').find('span.jq_productLineSpinner').addClass('hide');
                                $($this).parent('td').find('span.jq_productLineOK').removeClass('hide');
                            }, 300);

                        }
                        addToShopcartRequestB2B(productID, productName, productPrice, prodrebate, prodtax, productPic, productQty, finalattr, currentLang, currentLangCode, unitname, unitstep);
                    }
                } else {
                	var msg="";
                	switch (currentLangCode) {
                            case 'lat':
                                msg = 'Morate se ulogovati kako bi dodali proizvod u upit.';
                                break;
                            case 'eng':
                                msg = 'You must login to add product to request.';
                                break;
                            case 'cir':
                                msg = 'Морате се улоговати како би додали производ у упит.';
                                break;
                             default:
                             	msg = 'Morate se ulogovati kako bi dodali proizvod u upit.';
                        }
                    alertify.error(msg);
                }
            }
        });

    $(this).removeAttr('disabled');

    });
    //ADD TO REQUEST B2B CHART END//


    $('.cms_proDetAttrItem').on("click", function() {
        $(this).parents('.cms_proDetAttrCont').find('.cms_proDetAttrItem').each(function() {
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');

        // if($(this).hasClass('attr-onchange')){
        //     $(this).removeClass('attr-onchange');
        // }else{
            $(this).parents('.product-attr-ul').find('.product-attr-li').removeClass('attr-onchange');
            $(this).addClass('attr-onchange');
        // } 
    });

    $(".core_attrSelectValueCheckbox").on("click", function() {

        var currpath = window.location.pathname + window.location.search;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            var reg = "&at[]=" + $(this).attr('attrvalid');
            var currpath1 = currpath.replace(reg, '');
            var currpath1 = currpath1.replace("&&", '&');

            if (currpath[currpath1.length - 1] == '?') {
                currpath1 = currpath1.slice(0, -1);
            }

            window.location = currpath1;

        } else {
            $(this).addClass('selected');

            var str = window.location.pathname;
            var lastChar = currpath.indexOf('?');

            var char = '';
            if (lastChar == -1) { char = '?' }

            window.location = window.location + char + "&at[]=" + $(this).attr('attrvalid');

        }
    });

    //toolbox product sort
    $('.cms_CategorySortFilter').on('change', function() {
		
		//var currpath = window.location.pathname + window.location.search;
        //var questionmark = '';
        //if (currpath.search(/\?/g) == -1) { questionmark = '?'; }
		
        var currpath = window.location.search;
        var havequest = currpath.indexOf('?');
        var type = $(this).val();

        if (havequest > -1) {
            // ima ?

            if (type != '') {
                var spos = currpath.indexOf('sort');
                if (spos > -1) {
                    // ima sort	
                    var currpath1 = currpath.replace(/sort=[a-zA-Z0-9]*/g, 'sort=' + $(this).val());
                } else {
                    var currpath1 = currpath + '&sort=' + $(this).val();
                }
            } else {
                var currpath2 = currpath.replace(/sort=[a-zA-Z0-9]*/g, '');
                var currpath1 = currpath2.replace('?&', '?');
            }

        } else {
            var currpath1 = currpath + '?&sort=' + $(this).val();
        }
        window.location = window.location.pathname + currpath1;
    });
    //toolbox product limit
    $('.cms_CategoryLimitFilter').on('change', function() {
        var currpath = window.location.search;
        var havequest = currpath.indexOf('?');
        var type = $(this).val();
		if($(this).val()>=20) {
        if (havequest > -1 ) {
            // ima ?

            if (type != '') {
                var spos = currpath.indexOf('limit');
                if (spos > -1) {
                    // ima limit	
                    var currpath1 = currpath.replace(/limit=[a-zA-Z0-9]*/g, 'limit=' + $(this).val());
                } else {
                    var currpath1 = currpath + '&limit=' + $(this).val();
                }
            } else {
                var currpath2 = currpath.replace(/limit=[a-zA-Z0-9]*/g, '');
                var currpath1 = currpath2.replace('?&', '');
            }

        } else {
            var currpath1 = currpath + '?&limit=' + $(this).val();
        }
		} else {
                var currpath2 = currpath.replace(/limit=[a-zA-Z0-9]*/g, '');
                var currpath1 = currpath2.replace('?&', '?');			
		}
        window.location = window.location.pathname + currpath1;
    });
	//toolbox download category pricelist
	$('.cms_exportCategoryPriceListBTN').on('click', function() {
		alert('Export cenovnika.');
	});
	//toolbox end

    /*cart*/
    $('.cart_refresh').on('click', function() {
        var value = $(this).parent().find('input[name="qty"]').val();

        if (isNaN(value) || value < 0) {
            alertify.alert('Količina mora biti pozitivan ceo broj');
            return;
        }
        var cart_position = $(this).parents('.article_content').attr('cart_position');
        setArticleQtyInShopcart(cart_position, value);
    });
    $('.cart_request_refresh').on('click', function() {
        var value = $(this).parent().find('input[name="qty"]').val();

        if (isNaN(value) || value < 0) {
            alertify.alert('Količina mora biti pozitivan ceo broj');
            return;
        }
        var cart_position = $(this).parents('.article_content').attr('cart_position');
        setArticleQtyInShopcartRequest(cart_position, value);
    });
    $('.cart_refreshB2B').on('click', function() {
        var value = $(this).parent().find('input[name="qtyB2B"]').val();
        if (isNaN(value) || value < 0) {
            alertify.alert('Količina mora biti pozitivan ceo broj');
            return;
        }
        var cart_position = $(this).parents('.article_content').attr('cart_position');
        setArticleQtyInShopcartB2B(cart_position, value);
    });
    $('.cart_clear_article').on('click', function() {
        var c = confirm('Da li želite da količinu artikla postavite na 0 ?');
        if (c) {
            var cart_position = $(this).parents('.article_content').attr('cart_position');
            setArticleQtyInShopcart(cart_position, 0);
        }
    });
    $('.cart_clear_articleB2B').on('click', function() {
        var c = confirm('Da li želite da količinu artikla postavite na 0 ?');
        if (c) {
            var cart_position = $(this).parents('.article_content').attr('cart_position');
            setArticleQtyInShopcartB2B(cart_position, 0);
        }
    });

    $('.cart_remove_article').on('click', function() {

        var c = confirm('Ukloniti proizvod iz korpe?');
        if (c) {
            var cart_position = $(this).parents('.article_content').attr('cart_position');
            removeProdInCart(cart_position);
            //removeProdInCartB2B(cart_position);
        }

    });
    $('.cart_request_remove_article').on('click', function() {

        var c = confirm('Ukloniti proizvod iz korpe?');
        if (c) {
            var cart_position = $(this).parents('.article_content').attr('cart_position');
            removeProdInCartRequest(cart_position);
            //removeProdInCartB2B(cart_position);
        }

    });

    /*	small shopcart functions */


    $(".jq_smallShopcartItemDeleteButton").on('click', function() {
        var c = confirm('Ukloniti proizvod iz korpe?');
        if (c) {
            var cart_position = $(this).parents('.smallShopcartItemHolder').attr('productcartid');
            removeProdInCart(cart_position);
            //removeProdInCartB2B(cart_position);
        }

    });

    $(document).on("click", '.jq_compare', function(e) {

        if ($(this).attr('checked')) {
            removeFromCompare($(this).parents('.product').attr('productid'));
            $(this).removeAttr('style');

        } else {
            addToCompare($(this).parents('.product').attr('productid'), $(this).parents('.product').find(".jq_smallbox_image").attr('imglink'));
        }
    });

    $(document).on("click", '.cms_addToWishList', function(e) {

        if ($(this).find('.cms_iWishList').hasClass('-active')) {
            removeFromWishList($(this).parents('.product').attr('productid'));
            $(this).find('.cms_iWishList').removeClass('-active');

        } else {
            addToWishList($(this).parents('.product').attr('productid'));
        }
    });

    $(document).on("click", ".jq_removeFromCompareButton", function(e) {
        removeFromCompare($(this).parents('.jq_compareItemCont').attr('productid'));
    });

    $(document).on("click", ".compareButton", function(e) {
        window.location.href = 'uporedi';
    });

    $(document).on("click", ".cms_wishlistButton", function(e) {
        window.location.href = 'listazelja';
    });
	
	$('.cms_removeAllFromCompareButton').on('click', function(){
		/*$('.jq_compareItemCont').each(function(){
			removeFromCompare($(this).attr('productid'));
		});*/
        removeFromCompare(0,1);	
	});

    // log in modal
    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
    })

    $(function() {

        $('#login-form-link').click(function(e) {
            $("#login-form").delay(100).fadeIn(100);
            $("#registration-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#register-form-link').click(function(e) {
            $("#registration-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#login-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });

    });


    /*product page */
    $('.product_small_pic').on('click', function() {
        //var pic_src = $(this).children('img').attr('src');
        var pic_big = $(this).data('big-img');
        var pic_medium = $(this).data('medium-img');
        //alert(pic_medium);
        // $('.product_main_pic_holder').children('.highslide').attr('href', pic_big);
        $('.vise-pic-wraper').children('.highslide').attr('href', pic_big);
        $('.product_main_pic_holder').find('img').not(".akcija").attr('src', pic_medium);

        //$('.product_main_pic_holder').children('.highslide').attr('href', pic_src);
        //$('.product_main_pic_holder').find('img').attr('src', pic_src);

    });

    $('.forgot-password').on('click', function() {
        $('.modal').removeClass('fade').modal('hide');
    });

    /*	price slider	*/
    // var Myslider = $('#ex2').bootstrapSlider();

    $("#ex2").on("slideStop", function() {
        var values = Myslider.bootstrapSlider('getValue');
        var currpath = window.location.pathname + window.location.search;
        var questionmark = '?';
        if (currpath.search(/\?/g) == -1) { questionmark = '?'; }

        if (currpath.search(/&min=[0-9]*\.?[0-9]*/g) > -1) {
            currpath = currpath.replace(/&min=[0-9]*\.?[0-9]*/g, '&min=' + values[0]);
        } else {
            currpath = currpath + questionmark + '&min=' + values[0];
        }
        if (currpath.search(/&max=[0-9]*\.?[0-9]*/g) > -1) {
            currpath = currpath.replace(/&max=[0-9]*\.?[0-9]*/g, '&max=' + values[1]);
        } else {
            currpath = currpath + '&max=' + values[1];
        }

        window.location = currpath;
    });

    // .log in modal
    // search
    $('#search-button').on('click', function(event) {
        event.preventDefault();
        $(this).find('i').toggleClass('fa-search fa-times');
        $('.search-input').toggleClass('show');
        $('.search-input').focus();
    });

    $(".search-input").keypress(function(e) {
        if (e.which == 13) {
            $(this).removeClass('show');
            $('#search-button').find('i').toggleClass('fa-search fa-times');

        }
    });
    $('#search').click(function() {


        $('#search-input').focus();
    });
    // .search
    // small search button
    $('#search1').click(function() {

        $('#search-input1').css('margin-left', '10px');
        $('#search-input1').focus();
    });
    $('.search-button1').click(function() {
        hamburger_cross()
        $('#wrapper').toggleClass('toggled');

    });

    

    /*	CHANGE LANGUAGE  INPUT, A HREF*/

    $(".cms_changeLanguage").on("click", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "index.php",
            data: ({
                action: "changelang",
                langid: $(this).attr('langid')
            }),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR");
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });
	/*	SELECT LANGUAGE	 SELECT OPTION*/
    $(".cms_selectLanguage").on("change", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "index.php",
            data: ({
                action: "changelang",
                langid: $(this).val()
            }),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR");
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });
    /*  SELECT CURRENCY  SELECT OPTION*/
    $(".cms_selectCurrency").on("change", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "index.php",
            data: ({
                action: "changecurrency",
                currencyid: $(this).val()
            }),
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR");
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });

    $('#login-form').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#login-form').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        //console.log(values);
        if (values.login_form_username == '' || values.login_form_password == '') {
            alertify.alert('Potpunite sva polja.');
            return;
        }

        userLogin(values.login_form_username, values.login_form_password, values.login_form_rememberme);


    });

     $('#login-form_page').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#login-form_page').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        //console.log(values);
        if (values.login_form_username == '' || values.login_form_password == '') {
            alertify.alert('Potpunite sva polja.');
            return;
        }

        userLogin(values.login_form_username, values.login_form_password, values.login_form_rememberme);


    });


    $('.signOutMenu').on('click', function() {
        userLogout();
    });
    $('.signOutMenu2').on('click', function() {
        userLogout();
    });

    $('#registration-form').submit(function(event) {
        event.preventDefault();
        var values = {};
        var haserror = false;
        $('#registration-form').find("input").each(function() {
            if ($(this).val() == '') {
                $(this).parents(".form-group").addClass("has-error");
                $(this).next(".help-block").removeClass("hide");
                haserror = true;
            } else {
                $(this).parents(".form-group").removeClass("has-error");
                $(this).next(".help-block").addClass("hide");

            }
        });


        $.each($('#registration-form').serializeArray(), function(i, field) {
            console.log(field.value);
            values[field.name] = field.value;
            
        });
        
        values['usersDefaultLang'] = $('.usersDefaultLang').val();

        
        //console.log(values);
        if (!haserror) {
            userRegistration(values.first_name, values.last_name, values.email, values.password, values.password_confirmation, values.telefon, values.adresa, values.mesto, values.postanskibr,values.usersDefaultLang,values.birthday);
        } else {
            alertify.error('Sva polja su obavezna!');
        }
    });

    $('#lost-form').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#lost-form').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        console.log(values);
        lostPass(values.email);
    });

    $('#order_poruci').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#order_poruci').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        orderPoruci();
    });

    /*sakrivanje i prikazivanje uplatnice*/
    $('input[type=radio][name=payment]').change(function() {
        if (this.value == 'Uplatnicom') {
            $('.uplatnica_cont').removeClass('hidden');
            //alert('prikaz uplatnice');
        } else if (this.value == 'Pouzecem') {
            $('.uplatnica_cont').addClass('hidden');
            //alert('skrivanje uplatnice');
        }
    });
	
	/*sakrivanje i prikazivanje metode placanja*/
    $('input[type=radio][name=delivery]').change(function() {
        if (this.value == 'KurirskomSlužbom') {
            $('.delivery_service_cont').removeClass('hidden');
			$('.delivery_shop_cont').addClass('hidden');
			$('#deliveryZero').removeAttr('checked');
            //alert('prikaz kurirske službe');
        } else if (this.value == 'Lično') {
            $('.delivery_service_cont').addClass('hidden');
			$('.delivery_shop_cont').removeClass('hidden');
			$('#deliveryZero').attr('checked');
			$('#deliveryNotZero').removeAttr('checked');
            //alert('skrivanje kurirske službe');
        }
    });
	
    $('#order_delivery').submit(function(event) {
        event.preventDefault();
        var values = {};
		

        $.each($('#order_delivery').serializeArray(), function(i, field) {
            values[field.name] = field.value;
			//alert(field.value);
        });
        //console.log(values);
		setOrderPayment(values.payment);
    });
	
    $('#order_ordering').submit(function(event) {
        event.preventDefault();
        var values = {};
        $.each($('#order_ordering').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
		
		values['deliveryid'] = $("input[name='deliverypartner']:checked").val();
        //console.log(values);

        setOrderDelivery(values.delivery,values.deliveryid);


    });
	
    $('#order_orderingB2B').submit(function(event) {
        event.preventDefault();

        var values = {};
        $.each($('#order_orderingB2B').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
		
		values['deliveryid'] = $("input[name='deliverypartner']:checked").val();
        //console.log(values);

        setOrderDeliveryB2B(values.delivery,values.deliveryid);


    });

    /*#######################################################*/
	
	/**********************************************************************************************************************/
	//CONTACT 
	$(".jq_contact_form").on('submit', function(e) {
		e.preventDefault();
		if ($("#name").val() == '' || $("#email").val() == '' || $("#message").val() == '') {
			alertify.error('Popunite sva polja!');
		} else {
			$.ajax({
				type: "POST",
				data: {
					action: 'sendcontactform',
					name: $("#name").val(),
					mail: $("#email").val(),
					phone: $("#phone").val(),
					message: $("#message").val()
				},
				url: "index.php",
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("ERROR:" + errorThrown);
				},
				success: function(response) {
	
					$("#name").val('');
					$("#email").val('');
					$("#phone").val('');
					$("#message").val('');
					alertify.success('Poruka uspesno poslata');
				}
			});
		}
	});
	
	//UPDATE USER INFO 
	$(".jq_user_updatedata_form").on('submit', function(e) {
		e.preventDefault();
		if ($("#userName").val() == '' || 
			$("#userSurname").val() == '' || 
			$("#userEmail").val() == '' || 
			$("#userAddress").val() == '' || 
			$("#userCity").val() == '' || 
			$("#userZip").val() == '' || 
			$("#userPhone").val() == '' ) {
			alertify.error('Popunite sva obavezna polja!');
		} else {
			$.ajax({
				type: "POST",
				data: {
					action: 'userupdatedata',
					name: $("#userName").val(),
					surname: $("#userSurname").val(),
					email: $("#userEmail").val(),
					address: $("#userAddress").val(),
					city: $("#userCity").val(),
					zip: $("#userZip").val(),
					phone: $("#userPhone").val(),
					cellphone: $("#userCellPhone").val(),
                    birthday:$("#userBirthday").val()
				},
				url: "index.php",
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("ERROR:" + errorThrown);
				},
				success: function(response) {
					var str = window.location.pathname;
					if (str.indexOf("userpanel") >= 0)
					{
						window.location.reload();
					}else{
						window.location.href = 'pocetna';
					}
					alertify.success('Podaci su uspešno ažurirani.');
				}
			});
		}
	});
	
	//UPDATE PARTNER INFO 
	$(".jq_partner_updatedata_form").on('submit', function(e) {
		e.preventDefault();
		if ($("#partnerUserName").val() == '' || 
			$("#partnerUserSurname").val() == '' || 
			$("#partnerUserEmail").val() == '' || 
			$("#partnerUserAddress").val() == '' || 
			$("#partnerUserCity").val() == '' || 
			$("#partnerUserZip").val() == '' || 
			$("#partnerUserPhone").val() == '' ||
			$("#partnerName").val() == '' || 
			$("#partnerNumber").val() == '' ||
			$("#partnerCode").val() == '' ||
			$("#partnerContactPerson").val() == '' ||
			$("#partnerPhone").val() == '' ||
			$("#partnerEmail").val() == '' ||
			$("#partnerAddress").val() == '' ||
			$("#partnerCity").val() == '' ||
			$("#partnerZip").val() == '' ) {
			alertify.error('Popunite sva obavezna polja!');
		} else {
			$.ajax({
				type: "POST",
				data: {
					action: 'partnerupdatedata',
					name: $("#partnerUserName").val(),
					surname: $("#partnerUserSurname").val(),
					email: $("#partnerUserEmail").val(),
					address: $("#partnerUserAddress").val(),
					city: $("#partnerUserCity").val(),
					zip: $("#partnerUserZip").val(),
					phone: $("#partnerUserPhone").val(),
					cellphone: $("#partnerUserCellPhone").val(),
					partnername: $("#partnerName").val(),
					partnernumber: $("#partnerNumber").val(),
					partnercode: $("#partnerCode").val(),
					partnercontactperson: $("#partnerContactPerson").val(),
					partnerphone: $("#partnerPhone").val(),
					partnerfax: $("#partnerFax").val(),
					partneremail: $("#partnerEmail").val(),
					partnerwebsite: $("#partnerWebsite").val(),
					partneraddress: $("#partnerAddress").val(),
					partnercity: $("#partnerCity").val(),
					partnerzip: $("#partnerZip").val()
				},
				url: "index.php",
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("ERROR:" + errorThrown);
				},
				success: function(response) {
					var str = window.location.pathname;
					if (str.indexOf("userpanel") >= 0)
					{
						window.location.reload();
					}else{
						window.location.href = 'pocetna';
					}
					alertify.success('Podaci su uspešno ažurirani.');
				}
			});
		}
	});

    //UPDATE PARTNER INFO 
    $(".jq_partner_application_form").on('submit', function(e) {
        e.preventDefault();
        if ($("#partnerUserName").val() == '' || 
            $("#partnerUserSurname").val() == '' || 
            $("#partnerUserEmail").val() == '' || 
            $("#partnerUserPhone").val() == '' ||
            $("#partnerUserCellPhone").val() == '' ||
            $("#partnerUserAddress").val() == '' || 
            $("#partnerUserCity").val() == '' || 
            $("#partnerUserZip").val() == '' || 
            
            $("#partnerUserPassword").val() == '' ||
            $("#partnerUserRPassword").val() == '' || 

            $("#partnerName").val() == '' || 
            $("#partnerNumber").val() == '' ||
            $("#partnerCode").val() == '' ||
            $("#partnerContactPerson").val() == '' ||
            $("#partnerPhone").val() == '' ||
            $("#partnerEmail").val() == '' ||
            $("#partnerAddress").val() == '' ||
            $("#partnerCity").val() == '' ||
            $("#partnerZip").val() == '' ) {
            alertify.error('Popunite sva obavezna polja!');
        } else {
            $.ajax({
                type: "POST",
                data: {
                    action: 'partnerapplicationregister',

                    name: $("#partnerUserName").val(),
                    surname: $("#partnerUserSurname").val(),
                    birthday:$("#partnerUserBirthday").val(),
                    email: $("#partnerUserEmail").val(),
                    address: $("#partnerUserAddress").val(),
                    city: $("#partnerUserCity").val(),
                    zip: $("#partnerUserZip").val(),
                    phone: $("#partnerUserPhone").val(),
                    cellphone: $("#partnerUserCellPhone").val(),
                    defaultlang: $("#partnerUserDefaultLang").val(),
                    password: $("#partnerUserPassword").val(),
                    passwordconf: $("#partnerUserRPassword").val(),
                    partnername: $("#partnerName").val(),
                    partnernumber: $("#partnerNumber").val(),
                    partnercode: $("#partnerCode").val(),
                    partnercontactperson: $("#partnerContactPerson").val(),
                    partnerphone: $("#partnerPhone").val(),
                    partnerfax: $("#partnerFax").val(),
                    partneremail: $("#partnerEmail").val(),
                    partnerwebsite: $("#partnerWebsite").val(),
                    partneraddress: $("#partnerAddress").val(),
                    partnercity: $("#partnerCity").val(),
                    partnerzip: $("#partnerZip").val()
                },
                url: "index.php",
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("ERROR:" + errorThrown);
                },
                success: function(response) {
                    //window.location.href = 'pocetna';
                    //alertify.success('Vaš zahtev je uspešno prosleđen. Molimo vas sačekajte odobrenje naloga.');
                    if(response == 1){
                        alertify.success('Vaš zahtev je uspešno prosleđen. Molimo vas sačekajte odobrenje naloga.');
                         setTimeout(function(){
                            document.location.reload();
                    },2500);
                    }
            if(response == 0){
                alertify.error('E-mail adresa postoji');
            }
            if(response == 2){
                alertify.error('Šifre se ne poklapaju');
            }
            if(response == 3){
                alertify.error('greska-> Query Fail');
            }
            
           /* if(response == 4){
                alertify.error('Nedovoljne privilegije ili nepostojece!');
            }*/
                    /*var str = window.location.pathname;
                    if (str.indexOf("userpanel") >= 0)
                    {
                        window.location.reload();
                        alertify.success('Podaci su uspešno ažurirani.');
                    }else{
                        window.location.reload();

                    }*/
                    
                }
            });
        }
    });
	
	//*     SEARCH      */
	// search 
    $('.search').on('click', function() {
        setTimeout(function() {
            $('#mysearch-input').focus();
        }, 100);
        $('#search-input-holder').css('left', '0');
        $('body').css('overflow-y', 'hidden');
        $('.header-fixed').hide();
    })

    $('#close,#search2').on('click', function() {
        $('#search-input-holder').css('left', '100%');
        $('body').css('overflow-y', 'scroll');
    });

    // .search
	$(".js-example-basic-multiple").select2({
		
		
    });
	
    $('.cms_searchFormInput').on('keyup paste', function() {

        // attrval: ($('.cms_searchFilterButton').hasClass('collapsed'))? '':$(".cms_searchFilterAttrval").val()

        if ($(this).val() != '' && ($(this).val()).length > 2) {
            $('.cms_searchAllResultsButton').removeClass('hide').find('a').attr('href', 'pretraga?q=' + $(this).val());
            $('.cms_searchLoadingIcon').removeClass('hide');
            $.ajax({
                type: "POST",
                data: {
                    action: 'search',
                    q: $(".cms_searchFormInput").val(),
                    brend: ($('.cms_searchFilterButton').hasClass('collapsed')) ? '' : $(".cms_searchFilterBrend").val(),
                    category: ($('.cms_searchFilterButton').hasClass('collapsed')) ? '' : $(".cms_searchFilterCategory").val(),
					attrval: ($('.cms_searchFilterButton').hasClass('collapsed')) ? '' : $(".cms_searchFilterAttrval").val()
                },
                url: "index.php",
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("ERROR:" + errorThrown);
                },
                success: function(response) {
                    var a = JSON.parse(response);
                    $('.cms_searchResultCont').html('');
                    $('.cms_searchFoundTotalHolder').html(a[0]);
                    for (var i = 0; i < a[1].length; i++) {

                        var clone = $('.cms_productboxContModelTemplate').clone(true).removeClass('hide').removeClass('cms_productboxContModelTemplate');

                        $(clone).find('a').attr('href', a[1][i].productlink);
                        var img = 'fajlovi/noimg.png';
                        if (a[1][i].image != '') img = 'fajlovi/product/small/' + a[1][i].image
                        $(clone).find('.b-product-pic').css('background-image', "url('" + img + "')");

                        $(clone).find('.b-product-name').find('a').html(a[1][i].name+'<br />'+a['strings']['code']+a[1][i]['code']);
                        //brend = a[1][i].manufname;
                        //brend = brend.replace(/ */g ,'');
						b = a[1][i].brendimage;
                        //if (brend == 'PIAZZA') b = 'views/theme/img/piazza.jpg';
                        $(clone).find('.b-brend').find('img').attr('src', b);
                        $(clone).find('.cms_priceModalHolder').addClass('hide');
                        $(clone).find('.b-stiker-holder').html('');

                        if ((a[1][i].extradetail).length > 0) {
                            for (var j = 0; j < (a[1][i].extradetail).length; j++) {
                                console.log(a[1][i].extradetail[j].image);
                                var img = $(document.createElement('img')).addClass('img-responsive').attr('src', a[1][i].extradetail[j].image);
                                console.log(img);
                                $(clone).find('.b-stiker-holder').append(img);
                            }
                        }

                        if (a[1][i].rebate > 0) {
                            $(clone).find('.cms_productboxModalRebateImg').attr('src', a['strings']['actionimage']).removeClass('hide');
                            /*var oldprice = parseFloat(a[1][i].price) * ((parseFloat(a[1][i].tax) + 100) * 0.01) * ((parseFloat(a[1][i].nivpercent) + 100) * 0.01);
                            var newprice = parseFloat(a[1][i].price) * ((parseFloat(a[1][i].tax) + 100) * 0.01);*/
                            $(clone).find('.cms_productboxModalRebateAmount').removeClass('hide').html('-' + a[1][i]['actionrebate'] + '%')
                        }
                        if (a[1][i].nivpercent > 0) {
                            $(clone).find('.cms_productboxModalRebateImg').removeClass('hide');
                            $(clone).find('.cms_oldPriceAmountHolder').removeClass('hide').prepend((parseFloat(a[1][i].price) * ((parseFloat(a[1][i].tax) + 100) * 0.01) * ((parseFloat(a[1][i].nivpercent) + 100) * 0.01)).toFixed(2));
                        }

                        $(clone).appendTo($('.cms_searchResultCont'));
                    }

                    $('.cms_searchLoadingIcon').addClass('hide');

                }
            });
        }
    });

    $(".cms_searchFormButton").on('click', function(e) {
        e.preventDefault();
        $('.cms_searchFormInput').trigger('keyup');
    });
	
	
	/*	category Mobile Menu START	*/
	
	

    $('#jq_categoryMobileMenuTrigger, #jq_leftMenuTrigger2, #jq_leftMenuTrigger').on('click', function() {
		$('.jq_leftMenuSubBody').remove();
		menusubcategorydata(0);
        TweenMax.to($('.slide-menu'), 0.2, { left: "0" });
        $('.main-body-filter').show();
        $('body').css('overflow-y','hidden');
		
    });

    $('.jq_leftMenuCloseBtn, .main-body-filter').on('click', function() {
        $('.jq_leftMenuSubBody').remove();
        $('.slide-menu .head .title').html('proizvodi');
        TweenMax.to($('.slide-menu'), 0.2, { left: "-100%" });
        $('.main-body-filter').hide();
        $('body').css('overflow-y','auto');
    });


    $('.jq_forwardLeftMenuBtn').on('click', function() {
        var clone = $(this).parents('.jq_leftMenuBody').clone(true).addClass('jq_leftMenuSubBody');
        var currentName = $(this).parent('.items').find('.links').html();

        $(clone).css('left', '100%').attr('data-clickedname', currentName).appendTo('.body-container');
		$('.slide-menu .head .title').text(currentName);
		menusubcategorydata($(this).parent().attr('catid'));
    });

    $('.jq_leftMenuBackBtn').on('click', function() {
        var prevname = $('.body-container').find('.jq_leftMenuBody:last-child').prev('.jq_leftMenuBody').attr('data-clickedname');
        $('.slide-menu .head .title').text(prevname);
        TweenMax.to($('.jq_leftMenuBody:last-child'), 0.2, {
            left: "100%",
            onComplete: function() {
                $('.jq_leftMenuBody:last-child').remove();
                if ($('.jq_leftMenuBody').length == 1) {
                    $('.jq_leftMenuBackBtn').css('visibility', 'hidden');
                }
            }
        });

    });
	
	// var viewportHeight = $(window).height();
 //    var leftMenuHeight = $('.jq_leftMenuBody').height()
 //    console.log(leftMenuHeight);
 //    if (leftMenuHeight >= viewportHeight) {
 //        $('.body-container').css('overflow-y', 'scroll');
 //    } else {
 //        $('.body-container').css('overflow-y', 'hidden');
 //    }
	/*	category Mobile Menu END	*/
	
	
	
});	//	end document ready


/*
function initialize() {

    var map_cord1 = new google.maps.LatLng(43.322795, 21.910472);
    var map_cord2 = new google.maps.LatLng(43.323859, 21.928420);
	if(document.getElementById('map') != null)
	{
		var mapCanvas = document.getElementById('map');
		var mapOptions = {
			center: new google.maps.LatLng(43.3229294, 21.9194596),
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false
		}
		var map = new google.maps.Map(mapCanvas, mapOptions);
		var contentString = '<div id="content">' +
			'<b>Pro Electronic</b> <br> <small>060 / 4516 - 204</small>' +
			'</div>';
	
		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
	
		var marker1 = new google.maps.Marker({
			position: map_cord1,
			map: map,
			title: 'Pro Electronic"'
		});
		var marker2 = new google.maps.Marker({
			position: map_cord2,
			map: map,
			title: 'Pro Electronic 2"'
		});
		marker1.addListener('click', function() {
			infowindow.open(map, marker1);
		});
		marker2.addListener('click', function() {
			infowindow.open(map, marker2);
		});

	}
}*/



//refreshShopcartSmall();