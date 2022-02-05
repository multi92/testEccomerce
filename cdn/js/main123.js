$(document).ready(function() {

	$('#delivery1, #delivery2').on('click', function(){
		$('.delivery_service_cont').find('input[type="radio"]').each(function(){
			$(this).prop('checked', false);		
		});	
		$(this).next('input[type="radio"]').prop('checked', true);
	});
	$('.jq_shopcartNextButton').on('click', function(e){
		$this = $(this);
		e.preventDefault();	
		e.stopImmediatePropagation();	
		var data = {
			action : 'updateshopcartcomment',
			comment: $('.jq_shopcartComment').val()
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
	
	/*	show Section userpanel	*/
	
	/*$.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
			var startdate =  $('.jq_startDateInput').val();
			var enddate =  $('.jq_endDateInput').val();
			var date = parseFloat( data[2] ) || 0; // use data for the age column
	 
			if ( ( isNaN( startdate ) && isNaN( enddate ) ) ||
				 ( isNaN( startdate ) && date <= enddate ) ||
				 ( startdate <= date   && isNaN( enddate ) ) ||
				 ( startdate <= date   && date <= enddate ) )
			{
				return true;
			}
			return false;
		}
	);
	*/
	
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

    //dodaj u korpu B2B
    $(".product_dodaj_u_korpuB2B").on('click', function() {
        $this = $(this);
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
                    var productQty = $($this).parent().find('#product_qty').val();
                    var attr = $($this).attr('attr');
                    var flag = 1;
                    var atr = {};
                    var i = 0;
                    var finalattr = '';

                    if ($($this).hasClass('b2baddtocart')) {
                        finalattr = attr;
                    } else {
                        $(".jq_proDetAttrCont[mandatory='1']").each(function() {
                            var items = $(this).find('.jq_proDetAttrItem.selected').length;

                            if (items > 0) {
                                atr[i] = [$(this).attr('attrid'), $(this).find('.jq_proDetAttrItem.selected').attr('attrvalid')];
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
                        switch (currentLang) {
                            case '1':
                                msg = 'Izaberite atribute proizvoda.';
                                break;
                            case '2':
                                msg = 'Choose products attributes.';
                                break;
                            case '3':
                                msg = 'Изаберите атрибуте производа.';
                                break;

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
                        addTocartB2B(productID, productName, productPrice, prodrebate, prodtax, productPic, productQty, finalattr, currentLang);
                    }
                } else {
                    alertify.error('Morate se logovati kako bi dodali proizvod u korpu.');
                }
            }
        });



    });
    //dodaj u korpu
    $(".product_dodaj_u_korpu").on('click', function() {
        var productID = $(this).attr('prodid');
        var productName = $(this).attr('prodname');
        var productPic = $(this).attr('prodpic');

        var productPrice = $(this).attr('prodprice');
        var prodtax = $(this).attr('prodtax');
        var prodrebate = $(this).attr('prodrebate');
        var currentLang = $(this).attr('lang');
        var productQty = $(this).parent().find('#product_qty').val();

        var attrsid = $.map($(".attr-val-select"), function(n) {
            return n.id;
        });
        var atr = {};
        var atrval = "-1";

        var flag = 1;
        var i = 0;

        $(".jq_proDetAttrCont[mandatory='1']").each(function() {
            var items = $(this).find('.jq_proDetAttrItem.selected').length;

            if (items > 0) {
                atr[i] = [$(this).attr('attrid'), $(this).find('.jq_proDetAttrItem.selected').attr('attrvalid')];
            } else {
                atr[i] = [$(this).attr('attrid'), -1];
                flag = 0;
            }
            i++;

        });
        console.log(atr);




        if (flag == 0) {
            var msg = "";
            switch (currentLang) {
                case '1':
                    msg = 'Izaberite atribute proizvoda.';
                    break;
                case '2':
                    msg = 'Choose products attributes.';
                    break;
                case '3':
                    msg = 'Изаберите атрибуте производа.';
                    break;

            }
            alertify.error(msg);
            //showNotification(msg, 'error');
        } else {

            addTocart(productID, productName, productPrice, prodrebate, prodtax, productPic, productQty, JSON.stringify(atr), currentLang);
        }
    });
    //dodaj u korpu END

    $('.jq_proDetAttrItem').on("click", function() {
        $(this).parent('.jq_proDetAttrCont').find('.jq_proDetAttrItem').each(function() {
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');
    });

    $(".jq_attrSelectValueCheckbox").on("click", function() {

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
    $('.categorySelectFilter').on('change', function() {
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
                var currpath1 = currpath2.replace('?&', '');
            }

        } else {
            var currpath1 = currpath + '?&sort=' + $(this).val();
        }
        window.location = window.location.pathname + currpath1;
    });


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

    $(document).on("click", ".jq_removeFromCompareButton", function(e) {
        removeFromCompare($(this).parents('.jq_compareItemCont').attr('productid'));
    });

    $(document).on("click", ".compareButton", function(e) {
        window.location.href = 'uporedi';
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
    var Myslider = $('#ex2').bootstrapSlider();

    $("#ex2").on("slideStop", function() {
        var values = Myslider.bootstrapSlider('getValue');
        var currpath = window.location.pathname + window.location.search;
        var questionmark = '';
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

    // .small search button

    /*	small shopcart hover	*/
    $('.jq_smallShopcartHolder').on("mouseover", function() {
        $(".jq_smallShopcartDetailCont").removeClass('hide');
    });
    $('.jq_smallShopcartHolder').on("mouseleave", function() {
        setTimeout(function() {
            if (!$(".jq_smallShopcartDetailCont").is(':hover')) {
                $(".jq_smallShopcartDetailCont").addClass('hide');
            }
        }, 900);
    });
    $('.jq_smallShopcartDetailCont').on("mouseleave", function() {
        setTimeout(function() {
            $(".jq_smallShopcartDetailCont").addClass('hide');
        }, 500);
    });

    /*	change language	 */

    $(".jq_changelang").on("click", function(e) {
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


    $('#signOutMenu').on('click', function() {
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
            values[field.name] = field.value;
        });
        console.log(values);
        if (!haserror) {
        	console.log(values.birthady);
            userRegistration(values.first_name, values.last_name, values.email, values.password, values.password_confirmation, values.telefon, values.adresa, values.mesto, values.postanskibr,values.birthday);
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
    $(".input-group-btn .dropdown-menu li a").click(function() {

        var selText = $(this).html();

        //working version - for single button //
        //$('.btn:first-child').html(selText+'<span class="caret"></span>');  

        //working version - for multiple buttons //
        $(this).parents('.input-group-btn').find('.btn-search').html(selText);

    });

    $('.carousel').carousel({
        interval: 5000
    });


    var one = $("#one");
    var two = $("#two");
    var tree = $("#tree");

    one.owlCarousel({
        loop: true,
        margin: 5,
        // nav: true,
        autoplay: true,
        autoplayTimeout: 3500,
        autoplaySpeed: 2500,
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 1
            },
            500: {
                items: 3
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1199: {
                items: 4
            }
        }
    });
    two.owlCarousel({
        loop: true,
        margin: 5,
        // nav: true,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplaySpeed: 2500,
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 1
            },
            500: {
                items: 3
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1199: {
                items: 4
            }
        }
    });
    tree.owlCarousel({
        loop: true,
        margin: 10,
        // nav: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplaySpeed: 1000,
        responsive: {
            0: {
                items: 2
            },
            500: {
                items: 2
            },
            600: {
                items: 4
            },
            1199: {
                items: 6
            }
        }
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
            $("#register-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#register-form-link').click(function(e) {
            $("#register-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#login-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });

    });

    // .log in modal
    $('.burger').click(function() {
        $('.small-menu').slideToggle();
    })
    $('.small-drop-triger').on('click', function() {
        $(this).find('.small-drop-mil').slideToggle();
    });
    // scroll to top 
    $(window).scroll(function() {
        if ($(this).scrollTop() > 150) {
            $('.go-top').fadeIn(150);
        } else {
            $('.go-top').fadeOut(150);
        }
    });

    // Animate the scroll to top
    $('.go-top').click(function(event) {
        event.preventDefault();

        $('html, body').animate({ scrollTop: 0 }, 'slow');
    })
    // .scroll to top
    $(".vise-pic").fancybox();
    // increment-decrement
    (function() {

        window.inputNumber = function(el) {

            var min = el.attr('min') || false;
            var max = el.attr('max') || false;

            var els = {};

            els.dec = el.prev();
            els.inc = el.next();

            el.each(function() {
                init($(this));
            });

            function init(el) {

                els.dec.on('click', decrement);
                els.inc.on('click', increment);

                function decrement() {
                    var value = el[0].value;
                    value--;
                    if (!min || value >= min) {
                        el[0].value = value;
                    }
                }

                function increment() {
                    var value = el[0].value;
                    value++;
                    if (!max || value <= max) {
                        el[0].value = value++;
                    }
                }
            }
        }
    })();

    inputNumber($('.input-number'));




    // .korpa
    // uporedi
    $('#izbaci1').on('click', function() {

        $('.izbaci1').remove();

    });
    $('#izbaci2').on('click', function() {

        $('.izbaci2').remove();

    });
    $('#izbaci3').on('click', function() {

        $('.izbaci3').remove();

    });
    $('#izbaci4').on('click', function() {

        $('.izbaci4').remove();

    });

    // .uporedi
});

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
                message: $("#message").val()
            },
            url: "index.php",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR:" + errorThrown);
            },
            success: function(response) {

                $("#name").val('');
                $("#email").val('');
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
				cellphone: $("#userCellPhone").val()
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




// GMap

// function ucitajMojuMapu() {
// 	if($("#map").length>0){
// 	    var mapDiv = document.getElementById('map');

// 	    var mapOptions = {
// 	        center: new google.maps.LatLng(43.3229294, 21.9194596), //setovanje pozicije za prikaz mape
// 	        zoom: 16, //zoom level na mapi
// 	        panControl: false, // pan map kontrola
// 	        styles: [{
// 	            "featureType": "administrative",
// 	            "elementType": "labels",
// 	            "stylers": [{
// 	                "visibility": "off"
// 	            }]
// 	        }, {
// 	            "featureType": "poi",
// 	            "elementType": "labels",
// 	            "stylers": [{
// 	                "visibility": "off"
// 	            }]
// 	        }, {
// 	            "featureType": "road",
// 	            "elementType": "labels",
// 	            "stylers": [{
// 	                "visibility": "on"
// 	            }]
// 	        }],
// 	        zoomControl: true, //zoom kontrole +/-
// 	        mapTypeControl: false, //kontrola tipa mape opcija
// 	        scaleControl: false, //skaliranje
// 	        streetViewControl: false, //street view
// 	        overviewMapControl: true, //map kopntrole
// 	        rotateControl: true, //rotacija mape
// 	        scrollwheel: false //gasi scrollwhell za zoom na mapi
// 	            //mapTypeId: google.maps.MapTypeId.HYBRID //postavljanje tipa mape (tipovi: ROADMAP, HYBRID, SATELLITE, TERRAIN)
// 	            //disableDefaultUI:true
// 	    }

// 	    var cord1 = new google.maps.LatLng(43.322795, 21.910472);
// 	    var cord2 = new google.maps.LatLng(43.323859, 21.928420);

// 	    // var markerOptions = {
// 	    //     position: { lat: 43.322795, lng: 21.910472 }
// 	        // position2: { lat: 43.323859, lng: 21.928420 }
// 	        // icon: 'views/theme/img/placeholder.png',
// 	        // animation: google.maps.Animation.BOUNCE
// 	            // icon:"/img/placeholder.png"
// 	    // }

// 	    var map = new google.maps.Map(mapDiv, mapOptions);

// 	    var marker = new google.maps.Marker(markerOptions);
// 	    marker.setMap(map);


// 	    function placeMarker(map, location) {

// 	        var position = new google.maps.Marker({
// 	            position: cord1,
// 	            map: map
// 	        });
// 	 		var position2 = new google.maps.Marker({
// 	            position: cord2,
// 	            map: map
// 	        });
// 	 		 // console.log(position2);
// 	    }

// 	}
// }

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
}

google.maps.event.addDomListener(window, 'load', initialize);

refreshShopcartSmall();