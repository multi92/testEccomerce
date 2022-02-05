function saveReservationData(customerName, customerLastName, customerEmail, customerPhone, customerAddress, customerCity, customerZipCode, customerPaymentType, recipientName, recipientLastName, recipientPhone, recipientAddress, recipientCity, recipientZipCode, deliveryType, deliveryPersonalId, deliveryServiceId,shopcartTotal,orderComment){
    var data = {
        action: 'savereservationdata',
        customername:customerName,
        customerlastname:customerLastName,
        customeremail:customerEmail,
        customerphone:customerPhone,
        customeraddress:customerAddress,
        customercity:customerCity,
        customerzipcode:customerZipCode,
        customerpaymenttype:customerPaymentType,
        recipientname:recipientName,
        recipientlastname:recipientLastName,
        recipientphone:recipientPhone,
        recipientaddress:recipientAddress,
        recipientcity:recipientCity,
        recipientzipcode:recipientZipCode,
        deliverytype:deliveryType,
        deliverypersonalid:deliveryPersonalId,
        deliveryserviceid:deliveryServiceId,
        comment:orderComment
    };
     $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            if(response=='set'){
                window.location.href='shop';
            }
        }
    });
}


function createFastReservation(customerName, customerLastName, customerEmail, customerPhone, customerAddress, customerCity, customerZipCode, customerPaymentType, recipientName, recipientLastName, recipientPhone, recipientAddress, recipientCity, recipientZipCode, deliveryType, deliveryPersonalId, deliveryServiceId,shopcartTotal,orderComment,grr){
    var data = {
        action: 'setfastorderinfodata',
        customername:customerName,
        customerlastname:customerLastName,
        customeremail:customerEmail,
        customerphone:customerPhone,
        customeraddress:customerAddress,
        customercity:customerCity,
        customerzipcode:customerZipCode,
        customerpaymenttype:customerPaymentType,
        recipientname:recipientName,
        recipientlastname:recipientLastName,
        recipientphone:recipientPhone,
        recipientaddress:recipientAddress,
        recipientcity:recipientCity,
        recipientzipcode:recipientZipCode,
        deliverytype:deliveryType,
        deliverypersonalid:deliveryPersonalId,
        deliveryserviceid:deliveryServiceId,
        comment:orderComment,
        grr:grr
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            if(response=='fastorderinfodataset'){
             
                var data = {
                    action : 'checkStockAvailability'
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
                            var data = {
                                action : 'create_reservation',
                                grr: 'p'
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
                        }else{
                            if(a['itemcount']==a['offstock']){
                                alertify.alert("Odabrani proizvodi nisu više dostupni. Proizvodi iz korpe će biti uklonjeni!", function (e) {
                                    if(e) {
                                        //EMPTY SHOPCHART*/
                                        
                                        var data = {
                                            action : 'emptycart'
                                        };
                                        $.ajax({
                                            type: "POST",
                                            data: data,
                                            url: "index.php",
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                alert("ERROR:" + errorThrown);
                                            },
                                            success: function (response) {
                                                window.location.href='shop';
                                            }
                                        }); 
            
            
                                                
            
                                    } 
                                });
    
                            } else {
                                alertify.alert("Određeni proizvodi u odabranoj količini nisu više dostupni! Da li želite da korigujete količine i uklonite nedostupne proizvode iz korpe?", function (e) {
                                    if(e){
                                       var data = {
                                            action : 'removeZeroQtyProductsFromCart'
                                        };
                                        $.ajax({
                                            type: "POST",
                                            data: data,
                                            url: "index.php",
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                alert("ERROR:" + errorThrown);
                                            },
                                            success: function (response) {
                                                window.location.reload();
                                            }
                                        }); 
                    
                                    } 
                                });
    
                            }

                        }
                    }
                }); 
            } else{
                alert('Err55');
            }
        }
    });

}
function askingPrice(elem){
    var data = {
        action: 'sendrecommendedprice',
        price: $(elem).parents('.cms_recommendedPriceCont').find('.cms_recommendedPrice').val(),
        email: $(elem).parents('.cms_recommendedPriceCont').find('.cms_recommendedPriceEmail').val(),
        productid: $(elem).parents('.cms_recommendedPriceCont').find('.cms_recommendedPrice').attr('prodid')
    };
    
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
            //console.log(response);
            var res = JSON.parse(response);
            $('.cms_recommendedPriceCont').html("<p>"+res[1]+"</p>");
        }
    })
    
}


function acceptCookies(){
    var data = {
        action: 'acceptcookies'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            var a = response;
            if(a==1){
                $('.cookies-holder').addClass('hide');
            }
            //window.location.reload();
        }
    });

}
function splashscreenValidation(validationcode){
    var data = {
        action: 'splashscreenvalidation',
        validationcode:validationcode
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();
        }
    });

}
function get_datatable_language(langid, langcode){
    var language = {};

   switch(langcode) {
        case 'lat':
            language = {
                "emptyTable":     "Nema podataka za prikaz",
                "info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
                "infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
                "infoFiltered":   "(filtrirano od _MAX_ podataka)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Prikaži _MENU_ podataka",
                "loadingRecords": "Učitavanje...",
                "processing":     "Obrada...",
                "search":         "Pretraga:",
                "zeroRecords":    "Nema rezultata za zadati kriterijum",
                "paginate": {
                    "first":      "Prva",
                    "last":       "Poslednja",
                    "next":       "Sledeća",
                    "previous":   "Predhodna"
                            }
                       };
        break;
        case 'cir':
            language = {
                "emptyTable":     "Нема података за приказ",
                "info":           "Приказ _START_ до _END_ од _TOTAL_ података",
                "infoEmpty":      "Приказ 0 до 0 од 0 података",
                "infoFiltered":   "(филтрирано од _MAX_ података)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Прикажи _MENU_ података",
                "loadingRecords": "Учитаванје...",
                "processing":     "Обрада...",
                "search":         "Претрага:",
                "zeroRecords":    "Нема резултата за задати критеријум",
                "paginate": {
                    "first":      "Прва",
                    "last":       "Последња",
                    "next":       "Следећа",
                    "previous":   "Претходна"
                            }
                       };
         break;
         case 'eng':
            language = {
                "emptyTable":     "No data to display",
                "info":           "Display _START_ to _END_ from _TOTAL_ rows",
                "infoEmpty":      "Display 0 to 0 from 0 rows",
                "infoFiltered":   "(filtered from _MAX_ rows)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Show _MENU_ rows",
                "loadingRecords": "Loading...",
                "processing":     "Processing...",
                "search":         "Search:",
                "zeroRecords":    "Nema rezultata za zadati kriterijum",
                "paginate": {
                    "first":      "First",
                    "last":       "Last",
                    "next":       "Next",
                    "previous":   "Previous"
                            }
                       };
         break;
        default:
            language = {
                "emptyTable":     "Nema podataka za prikaz",
                "info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
                "infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
                "infoFiltered":   "(filtrirano od _MAX_ podataka)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Prikaži _MENU_ podataka",
                "loadingRecords": "Učitavanje...",
                "processing":     "Obrada...",
                "search":         "Pretraga:",
                "zeroRecords":    "Nema rezultata za zadati kriterijum",
                "paginate": {
                    "first":      "Prva",
                    "last":       "Poslednja",
                    "next":       "Sledeća",
                    "previous":   "Predhodna"
                            }
                       };
    }
    return language;
}

function orderSetInfoData(customerName, customerLastName, customerEmail, customerPhone, customerAddress, customerCity, customerZipCode, customerVoucher ,customerPaymentType, recipientName, recipientLastName, recipientPhone, recipientAddress, recipientCity, recipientZipCode, deliveryType, deliveryPersonalId, deliveryServiceId){
    var data = {
        action: 'setorderinfodata',
        customername:customerName,
        customerlastname:customerLastName,
        customeremail:customerEmail,
        customerphone:customerPhone,
        customeraddress:customerAddress,
        customercity:customerCity,
        customerzipcode:customerZipCode,
        customervoucher:customerVoucher,
        customerpaymenttype:customerPaymentType,
        recipientname:recipientName,
        recipientlastname:recipientLastName,
        recipientphone:recipientPhone,
        recipientaddress:recipientAddress,
        recipientcity:recipientCity,
        recipientzipcode:recipientZipCode,
        deliverytype:deliveryType,
        deliverypersonalid:deliveryPersonalId,
        deliveryserviceid:deliveryServiceId
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            if(response=='orderinfodataset'){
                window.location.href = "checkout_confirmation";
            }
        }
    });

}

function orderOfferSetInfoData(customerName, customerLastName, customerEmail, customerPhone){
    var data = {
        action: 'setorderofferinfodata',
        customername:customerName,
        customerlastname:customerLastName,
        customeremail:customerEmail,
        customerphone:customerPhone
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            if(response=='orderofferinfodataset'){
                var dataorder = {
                    action: 'create_offer'
                };

                $.ajax({
                    type: "POST",
                    data: dataorder,
                    url: "index.php",
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("ERROR:" + errorThrown);
                    },
                    success: function (response) {
                        //var a = JSON.parse(response);
                        //alert(a.status);
                        //if(a.status=='success'){
                            window.location.href = "shop";
                        //}
                    }
                });





                //window.location.href = "checkout_confirmation";
            }
        }
    });

}

function get_commercialist_partners(){
   var partnerid = $('.container_commercilalist_partner').attr('partnerid');
   var partneraddressid = $('.container_commercilalist_partner').attr('partneraddressid');
   var langid=$('.container_commercilalist_partner').attr('langid');
   var langcode=$('.container_commercilalist_partner').attr('langcode');

   //IMPORTANT 
   var language = {};
   language = get_datatable_language(langid,langcode);
   //IMPORTANT END
   


   $("#commercilalist_partner").DataTable({
            stateSave: true,
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"index.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getcommercialistpartner',
                    partnerid : function() { return  $('.container_commercilalist_partner').attr('partnerid') },
                    partneraddressid : function() { return $('.container_commercilalist_partner').attr('partneraddressid') }
                }),
                error: function(){  // error handling
                    $(".commercilalist_partner-grid-error").html("");
                    $("#commercilalist_partner").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronađenih podataka</th></tr></tbody>');
                    $("#commercilalist_partner-grid_processing").css("display","none");
                },
                dataSrc: function(a){
                    console.log(a);
                     for(var i = 0; i < a.aaData.length;i++)
                     {
                     var partnerAddress = '';
                     if(a.aaData[i][3].length>0){
                        var partnerAddress = '<div class="row"> <div class="col-lg-12"><label>'+a.aaData[i][2]+'</label>';

                        for(var j = 0; j < a.aaData[i][3].length;j++)
                        {

                            partnerAddressRow='<div class="row">';
                            partnerAddressRow=partnerAddressRow+'<div class="col-lg-9">'+a.aaData[i][3][j].objectname+' - '+a.aaData[i][3][j].address+', '+a.aaData[i][3][j].city+' '+a.aaData[i][3][j].zip+'</div>';
                            partnerAddressRow=partnerAddressRow+'<div class="col-lg-3 partnerAddressSelectCont">';//<button class="btn btn-primary -child partnerAddressSelectBTN" style="padding:2px 4px!important;" partnerid="'+a.aaData[i][99]+'" partneraddressid="'+a.aaData[i][3][j].partneraddressid+'">Izaberi adresu partnera</button></div>';
                            var clone = $('.partnerAddressSelectBTNTemplate').clone(true).removeClass('partnerAddressSelectBTNTemplate').addClass('partnerAddressSelectBTN').removeClass('hide');
                            $(clone).attr('partnerid', a.aaData[i][99]);
                            $(clone).attr('partneraddressid', a.aaData[i][3][j].partneraddressid);
                            
                           // partnerAddressRow.append(clone);
                            partnerAddressRow=partnerAddressRow+clone.get(0).outerHTML+'</div>';
                            partnerAddress=partnerAddress+partnerAddressRow;

                        }
                        partnerAddress=partnerAddress+'</div></div>';
                     } else {
                        partnerAddress = a.aaData[i][2];
                     }
                     
                     
                     a.aaData[i][2] = partnerAddress;


                     var infoBTN = '';
                     var clone = $('.partnerInfoBTNTemplate').clone(true).removeClass('partnerInfoBTNTemplate').addClass('partnerInfoBTN').removeClass('hide');
                            $(clone).attr('partnerid', a.aaData[i][99]);
                            $(clone).attr('partneraddressid', 0);
                        infoBTN = clone.get(0).outerHTML;
                    
                     var selectBTN = '';
                     var clone = $('.partnerSelectBTNTemplate').clone(true).removeClass('partnerSelectBTNTemplate').addClass('partnerSelectBTN').removeClass('hide');
                            $(clone).attr('partnerid', a.aaData[i][99]);
                            $(clone).attr('partneraddressid', 0);
                        selectBTN = clone.get(0).outerHTML;
                     
                     
                     a.aaData[i][3] = infoBTN +"&nbsp;&nbsp;"+ selectBTN;

                     
                     //a.aaData[i][5] = selectBTN;
                     }

                    $(".loadingIcon").addClass("hide"); 
                    $(".runReportCont").removeClass('hide');
                    
                    return a.aaData;
                }
            },
            "language": language
        }).on('click','.partnerInfoBTN', function(){
            alert('partnerid='+$(this).attr('partnerid')+' partneraddressid='+$(this).attr('partneraddressid'));        
            // var documentid=$(this).attr('documentid');
            // if(documentid !='' && documentid>0 ){
            //     var getUrl = window.location;
            //     var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+"/invoice/change/"+documentid;
            //     var win = window.open(baseUrl, '_blank');
            //     win.focus();
            // } else {
            //     alert('Došlo je do greške. LOCATE_DOC_0001');
            // }
            
        }).on('click','.partnerSelectBTN', function(){
            //alert('partnerid='+$(this).attr('partnerid')+' partneraddressid='+$(this).attr('partneraddressid'));   
            commercialistSelectPartner($(this).attr('partnerid'),$(this).attr('partneraddressid'));                 
        }).on('click','.partnerAddressSelectBTN', function(){
            //alert('partnerid='+$(this).attr('partnerid')+' partneraddressid='+$(this).attr('partneraddressid'));   
            commercialistSelectPartner($(this).attr('partnerid'),$(this).attr('partneraddressid'));      
        });
}

function commercialistSelectPartner(partnerid,partneraddressid){
    var data = {
        action: 'setcommercialistpartner',
        partnerid:partnerid,
        partneraddressid:partneraddressid
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.href = "commercialist_select_partner";
        }
    });
}
function commercialistPartnerInfo(partnerid,partneraddressid){
    var data = {
        action: 'commercialistpartnerinfo',
        partnerid:partnerid,
        partneraddressid:partneraddressid
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            //if(response == 0){
            //    alertify.error('Error: 2001. User data not updated!!!');
            //}
        }
    });
}
function commercialistSelectPartnerWithAddress(partnerid,partneraddressid){
    var data = {
        action: 'setcommercialistpartner',
        partnerid:partnerid,
        partneraddressid:partneraddressid
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
           window.location.href = "commercialist_select_partner";
        }
    });
}

function commercialist_remove_select_partner(){
    var data = {
        action: 'removecommercialistselectedpartner'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();

        }
    });
}


function userLogDataInsertUpdate(){
    var data = {
        action: 'userlogdatauinsertpdate'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            //if(response == 0){
            //    alertify.error('Error: 2001. User data not updated!!!');
            //}

        }
    });
}


function addToShopcart(id, ime, cena, rebate, tax, slika, kolicina, attr, lang, langcode, unitname, unitstep) {
    var d = {
        action : 'prodhaveattrs',
        id: id
    }
    $.ajax({
        type: 'POST',
        data: d,
        url: 'index.php',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            console.log(response);
            if (response == 1) {
                alert('ima attr');
                location.href = '?page=proizvod&id=' + id;
                return;
            }
            else {
                var data = {
                    action : 'addtocart',
                    id: id,
                    name: ime,
                    price: cena,
                    rebate: rebate,
                    tax: tax,
                    pic: slika,
                    qty: kolicina,
                    attr: attr,
                    unitname: unitname,
                    unitstep: unitstep
                };
                $.ajax({
                    type: "POST",
                    data: data,
                    url: "index.php",
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("ERROR:" + errorThrown);
                    },
                    success: function (response) {
                        //alert(response);
                        var a = JSON.parse(response);
                        var shopcartitemcount = a[0].shopcartitemcount;
                        var lastaddedproductqty = a[0].lastaddedproductqty;
                        var newshopcartcount = parseInt(shopcartitemcount); 
                        $(".cms_shopcartCount").text(newshopcartcount);
                        //var shopcartcount = $(".cms_shopcartCount").text();
                        //
                       
                        //$("#cart_item_counter").html(coun);
                        $( ".cms_productInputDecIncCont" ).each(function() {
                            //alert($( this ).attr('prodid')+'   = '+id);
                             //alert(JSON.parse($( this ).attr('attr')));
                            //alert($( this ).attr('attr')+'   =   '+attr);
                            if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                var max =  parseFloat($( this ).find('.cms_productQtyInput').attr('maxquantity'));
                                var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $( this ).find('.cms_productQtyInput').attr('max',newMaxQuantity);

                            }
                            
                        });
                        if($(".product_add_to_shopcart").hasClass('add2cart')){
                        $( ".cms_productInputDecIncCont" ).each(function() {
                            //alert($( this ).attr('prodid')+'   = '+id);
                             //alert(JSON.parse($( this ).attr('attr')));
                            //alert(JSON.parse($( this ).attr('attr'))+'   =   '+attr);
                            if( ($( this ).attr('prodid')==id) && (JSON.parse($( this ).attr('attr'))==attr)){
                                var max =  parseFloat($( this ).find('.cms_productQtyInput').attr('maxquantity'));
                                var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $( this ).find('.cms_productQtyInput').attr('max',newMaxQuantity);

                            }
                            
                        });
                        }
                        if($(".product_add_to_shopcart").hasClass('product')){
                            var max =  parseFloat($(".product_add_to_shopcart").parent().find('.cms_productQtyInput').attr('maxquantity'));
                            var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $(".product_add_to_shopcart").parent().find('.cms_productQtyInput').attr('max',newMaxQuantity);
                        }


                        
                        var addToChartModal = $(".addToChartModal");

                        addToChartModal.find('.add-to-chart-modal-body-productname').html('<b>'+ime+'</b>');
                        addToChartModal.find('.add-to-chart-modal-body-productimage').attr('src','fajlovi/product/small/'+slika);

                        addToChartModal.css('display','block');



                        var msg = "";
                        switch (langcode) {
                            case 'lat':
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                                break;
                            case 'eng':
                                msg = 'Product '+ime+' has been added to the cart.';
                                break;
                            case 'cir':
                                msg = 'Производ '+ime+' је додат у корпу.';
                                break;
                            default:
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                        }
                        alertify.success(msg);
                    }
                });
            }
        }
    });


}
function addToShopcartRequest(id, ime, cena, rebate, tax, slika, kolicina, attr, lang, langcode, unitname, unitstep) {
    var d = {
        action : 'prodhaveattrs',
        id: id
    }
    $.ajax({
        type: 'POST',
        data: d,
        url: 'index.php',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            console.log(response);
            if (response == 1) {
                alert('ima attr');
                location.href = '?page=proizvod&id=' + id;
                return;
            }
            else {
                var data = {
                    action : 'addtocartrequest',
                    id: id,
                    name: ime,
                    price: cena,
                    rebate: rebate,
                    tax: tax,
                    pic: slika,
                    qty: kolicina,
                    attr: attr,
                    unitname: unitname,
                    unitstep: unitstep
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
                        var shopcartitemcount = a[0].shopcartitemcount;
                        var lastaddedproductqty = a[0].lastaddedproductqty;
                        var newshopcartcount = parseInt(shopcartitemcount); 
                        $(".cms_shopcartCount").text(newshopcartcount);

                        $( ".cms_productInputDecIncCont" ).each(function() {
                            if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                var max =  parseFloat($( this ).find('.cms_productQtyInput').attr('maxquantity'));
                                var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $( this ).find('.cms_productQtyInput').attr('max',newMaxQuantity);

                            }
                            
                        });

                        var msg = "";
                        switch (langcode) {
                            case 'lat':
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                                break;
                            case 'eng':
                                msg = 'Product '+ime+' has been added to the cart.';
                                break;
                            case 'cir':
                                msg = 'Производ '+ime+' је додат у корпу.';
                                break;
                            default:
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                        }
                        alertify.success(msg);
                    }
                });
            }
        }
    });


}


function addToShopcartB2B(id, ime, cena, rebate, tax, slika, kolicina, attr, lang, langcode, unitname, unitstep) {

//    var base = jQuery('base')[0].baseURI;
    var d = {
        action : 'prodhaveattrs',
        id: id
    }
    $.ajax({
        type: 'POST',
        data: d,
        url: 'index.php',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            console.log(response);
            if (response == 1) {
                //alert('ima attr');
                location.href = '?page=proizvod&id=' + id;
                return;
            }
            else {
                var data = {
                    action : 'addtocartB2B',
                    id: id,
                    name: ime,
                    price: cena,
                    rebate: rebate,
                    tax: tax,
                    pic: slika,
                    qty: kolicina,
                    attr: attr,
                    unitname: unitname,
                    unitstep: unitstep
                };
                $.ajax({
                    type: "POST",
                    data: data,
                    url: "index.php",
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("ERROR:" + errorThrown);
                    },
                    success: function (response) {
                        //alert(response);
                        var coun = JSON.parse(response);
                        var a = JSON.parse(response);
                        var shopcartitemcount = a[0].shopcartitemcount;
                        var lastaddedproductqty = a[0].lastaddedproductqty;
                        var newshopcartcount = parseInt(shopcartitemcount); 
                        $(".cms_shopcartCount").text(newshopcartcount);



              
                        if($(".product_add_to_shopcartB2B").hasClass('b2baddtocart')){
                             $( ".cms_productInputDecIncCont" ).each(function() {
                            //alert($( this ).attr('prodid')+'   = '+id);
                           //alert(JSON.parse($( this ).attr('attr')));
                            //alert($( this ).attr('attr')+'   =   '+attr);
                            if( ($( this ).attr('prodid')==id)){
                                var max =  parseFloat($( this ).find('.cms_productQtyInput').attr('maxquantity'));
                                var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $( this ).find('.cms_productQtyInput').attr('max',newMaxQuantity);

                            }
                            
                        });


                        } else {
                            //set rest quantity and new max quantity
                        $( ".cms_productInputDecIncCont" ).each(function() {
                            //alert($( this ).attr('prodid')+'   = '+id);
                           //alert(JSON.parse($( this ).attr('attr')));
                            //alert($( this ).attr('attr')+'   =   '+attr);
                            if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                var max =  parseFloat($( this ).find('.cms_productQtyInput').attr('maxquantity'));
                                var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $( this ).find('.cms_productQtyInput').attr('max',newMaxQuantity);

                            }
                            
                        });

                        }
                         
                        
                        if($(".product_add_to_shopcartB2B").hasClass('product')){
                            var max =  parseFloat($(".product_add_to_shopcartB2B").parent().find('.cms_productQtyInput').attr('maxquantity'));
                            var cartQuantity =  parseFloat(lastaddedproductqty);
                                var newMaxQuantity = Math.round((max-cartQuantity)*100)/100  ;
                                $(".product_add_to_shopcartB2B").parent().find('.cms_productQtyInput').attr('max',newMaxQuantity);
                        }

                        
                        var viewtype = '';
                        //check if function called from B2BLineProductBox for Regular Type
                        $( ".product_add_to_shopcartB2B" ).each(function() {
                            if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                if($( this ).hasClass('dualcode')){
                                    viewtype='B2BLine';
                                }
                            }
                            
                        });
                       
                        //if function called from B2BLineProductBox set check icon
                        if(viewtype='B2BLine'){
                             //show quantity from shopcart
                             $( ".cms_product_with_attribut_quantity_in_chart" ).each(function() {
                                if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                    $( this ).text(lastaddedproductqty);
                                }
                            
                            });
                             $( ".jq_productLineOK" ).each(function() {
                                if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                    $( this ).html('<i class="fa fa-2x fa-check-square" aria-hidden="true" style="color:#00970C"></i>');
                                }
                            
                            });
                        }

                        //product_add_to_shopcart_requestB2B

                        var msg = "";
                        switch (langcode) {
                            case 'lat':
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                                break;
                            case 'eng':
                                msg = 'Product '+ime+' has been added to the cart.';
                                break;
                            case 'cir':
                                msg = 'Производ '+ime+' је додат у корпу.';
                                break;
                            default:
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                        }
                        alertify.success(msg);
                    }
                });
            }
        }
    });
}


function addToShopcartRequestB2B(id, ime, cena, rebate, tax, slika, kolicina, attr, lang, langcode, unitname, unitstep) {
    var d = {
        action : 'prodhaveattrs',
        id: id
    }
    $.ajax({
        type: 'POST',
        data: d,
        url: 'index.php',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            console.log(response);
            if (response == 1) {
                alert('ima attr');
                location.href = '?page=proizvod&id=' + id;
                return;
            }
            else {
                var data = {
                    action : 'addtocartrequestb2b',
                    id: id,
                    name: ime,
                    price: cena,
                    rebate: rebate,
                    tax: tax,
                    pic: slika,
                    qty: kolicina,
                    attr: attr,
                    unitname: unitname,
                    unitstep: unitstep
                };
                $.ajax({
                    type: "POST",
                    data: data,
                    url: "index.php",
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("ERROR:" + errorThrown);
                    },
                    success: function (response) {
                        //alert(response);
                        var coun = JSON.parse(response);
                        var a = JSON.parse(response);
                        var shopcartitemcount = a[0].shopcartitemcount;
                        var lastaddedproductqty = a[0].lastaddedproductqty;
                        var newshopcartcount = parseInt(shopcartitemcount); 
                        $(".cms_shopcartCount").text(newshopcartcount);

                        

                        var viewtype = '';
                        //check if function called from B2BLineProductBox for Regular Type
                        $( ".product_add_to_shopcart_requestB2B" ).each(function() {
                            if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                if($( this ).hasClass('dualcode')){
                                    viewtype='B2BLine';
                                }
                            }
                            
                        });

                        //if function called from B2BLineProductBox set check icon
                        if(viewtype='B2BLine'){
                             //show quantity from shopcart
                             $( ".cms_product_with_attribut_quantity_in_chart_request" ).each(function() {
                                if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                    $( this ).text(lastaddedproductqty);
                                }
                            
                            });
                             $( ".jq_productLineOK" ).each(function() {
                                if( ($( this ).attr('prodid')==id) && ($( this ).attr('attr')==attr)){
                                    $( this ).html('<i class="fa fa-2x fa-check-square" aria-hidden="true" style="color:#00970C"></i>');
                                }
                            
                            });
                        }

                        var msg = "";
                        switch (langcode) {
                            case 'lat':
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                                break;
                            case 'eng':
                                msg = 'Product '+ime+' has been added to the cart.';
                                break;
                            case 'cir':
                                msg = 'Производ '+ime+' је додат у корпу.';
                                break;
                            default:
                                msg = 'Proizvod '+ime+' je dodat u korpu.';
                        }
                        alertify.success(msg);
                    }
                });
            }
        }
    });


}

//prazni $_SESSION['shopcart'];
function emptyCart(){
    var data = {
        action : 'emptycart'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            var msg = "Ispraznjena korpa";
            alertify.success(msg);
        }
    });
}
function changeProdQtyInCart(cartPosition, qty){
    var data = {
        action : 'changeProdQtyInCart',
        cartposition: cartPosition,
        qty: qty
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
                var msg = "chaned";
                alertify.success(msg);
            }
            else{
                var msg = "error prod in cart not exist";
                alertify.error(msg);
            }

        }
    });
}
function removeProdInCart(cartPosition){
    var data = {
        action : 'removeProdInCart',
        cartposition: cartPosition
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
                window.location.reload();
            }
            else{
                window.location.reload();
                //var msg = "error prod in cart not exist";
                //alertify.error(msg);
            }

        }
    });
}
function removeProdInCartRequest(cartPosition){
    var data = {
        action : 'removeProdInCartRequest',
        cartposition: cartPosition
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
                var msg = "chaned";
                window.location.reload();
                alertify.success(msg);
            }
            else{
                window.location.reload();
                //var msg = "error prod in cart not exist";
                //alertify.error(msg);
            }

        }
    });
}
function removeProdInCartB2B(cartPosition){
    var data = {
        action : 'removeProdInCartB2B',
        cartposition: cartPosition
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
                var msg = "chaned";
                window.location.reload();
                alertify.success(msg);
            }
            else{
                window.location.reload();
                //var msg = "error prod in cart not exist";
                //alertify.error(msg);
            }

        }
    });
}
function addProdToWatched(prodid){
    var data = {
        action : 'addProdToWatched',
        prodid: prodid
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
                var msg = "chaned";
                alertify.success(msg);
            }
            else{
                var msg = "error";
                alertify.error(msg);
            }

        }
    });
}

function createReservation(){
    var data = {
        action : 'createReservation'
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
                var msg = "added success";
                alertify.success(msg);
            }
            else{
                var msg = "error create";
                alertify.error(msg);
            }

        }
    });
}

function addToCompare(prodid, img){
	var data = {
        action : 'addToCompare',
        prodid: prodid
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
			   
			   createCompareSmallBox(prodid, img);
			   /*	need add image to toolbox	*/
			   
                var msg = "Dodato u uporedjivanje";
                alertify.success(msg);
            }
            else{
                var msg = "Nije dodato u uporedjivanje";
                alertify.error(msg);
            }
			window.location.reload();
        }
    });	
}

function removeFromCompare(prodid, removeall=0 ){
    var data = {
            action : 'removeFromCompare',
            prodid: prodid,
            removeall:removeall
        };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();
        }
    });     
}

function addToWishList(prodid){
    var data = {
        action : 'addToWishList',
        prodid: prodid
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
                var msg = "Proizvod je dodat u Listu želja";
                alertify.success(msg);
            }
            else{
                var msg = "Proizvod nije dodato u listu želja.";
                alertify.error(msg);
            }
            window.location.reload();
        }
    }); 
}



function removeFromWishList(prodid){
    var data = {
        action : 'removeFromWishList',
        prodid: prodid
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();
        }
    });     
}


function setArticleQtyInShopcart(cart_position, qty) {
    var data = {
        action: 'setarticleqtyinshopcart',
        cart_position: cart_position,
        qty: qty
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();
        }
    });
}

function setArticleQtyInShopcartRequest(cart_position, qty) {
    var data = {
        action: 'setarticleqtyinshopcartrequest',
        cart_position: cart_position,
        qty: qty
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();
        }
    });
}
function setArticleQtyInShopcartB2B(cart_position, qty) {
    var data = {
        action: 'setarticleqtyinshopcartB2B',
        cart_position: cart_position,
        qty: qty
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            window.location.reload();
        }
    });
}

function setOrderingPayment(paymenttype){
    var data = {
        action: 'setorderingaddress',
        ime: ime,
        prezime: prezime,
        adresa: adresa,
        telefon: telefon,
        mesto: mesto,
        postbr: postbr,
        email: email
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
                window.location.href = "order_address_delivery";
            }

        }
    });
}

function setOrderingAddress(ime, prezime, adresa, telefon, mesto, postbr, email){
    var data = {
        action: 'setorderingaddress',
        ime: ime,
        prezime: prezime,
        adresa: adresa,
        telefon: telefon,
        mesto: mesto,
        postbr: postbr,
        email: email
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
                window.location.href = "order_address_delivery";
            }

        }
    });
}
function setOrderingAddressDelivery(ime, prezime, adresa, telefon, mesto, postbr, email){
    var data = {
        action: 'setorderingaddressdelivery',
        ime: ime,
        prezime: prezime,
        adresa: adresa,
        telefon: telefon,
        mesto: mesto,
        postbr: postbr,
        email: email
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
                window.location.href = "order_payment";
            }

        }
    });
}
function removeOrderingAddress(){
    var data = {
        action: 'deleteorderingaddress'
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
                alertify.success('order address removed');
            }
            if(response == 0){
                alertify.error('order address was empty');
            }

        }
    });
}

function setOrderPayment(payment){
    var data = {
        action: 'setorderpayment',
        payment: payment
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
                window.location.href = "order_delivery";
            }
            if(response == 0){
                alertify.error('greska kod adrese');
                window.location.href = 'order_address';
            }

        }
    });
}

function setOrderDelivery(delivery,deliveryid){
    var data = {
        action: 'setorderdelivery',
        delivery: delivery,
		deliveryid: deliveryid
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
                window.location.href = "order_ordering";
            }
            if(response == 0){
                alertify.error('greska kod adrese');
                window.location.href = 'order_payment';
            }

        }
    });
}

function setOrderDeliveryB2B(delivery,deliveryid){
    var data = {
        action: 'setorderdelivery',
        delivery: delivery,
		deliveryid: deliveryid
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
                window.location.href = "order_ordering";
            }
            if(response == 0){
                alertify.error('greska kod adrese');
                window.location.href = 'korpa';
            }

        }
    });
}

function userLogin(username, pass, remmemberme) {
    var data = {
        action: 'partenrnotemptycart',
        username: username,
        pass: pass
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            if (response == 1) {
                alertify.confirm("Vaša kopra će biti ispražnjena.", function (e) {
                    if (e) {
                        emptyCart();
                        Login(username, pass, remmemberme);
                    } else {
                        alertify.success('Proverite korpu');
                    }
                });
				
            }
            else{
               Login(username, pass, remmemberme);
            }
			


        }
    })
}
function userRemmemberMe(username, pass, remmember_me) {
    var data = {
        action: 'remmemberme',
        username: username,
        pass: pass,
		remmember_me: remmember_me
    };

    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function (response) {
            
			
        }
    })
}

function Login(username, pass, remmemberme){
    var data = {
        action: 'userlogin',
        username: username,
        pass: pass
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
			
            if(response == 1){
				userRemmemberMe(username, pass, remmemberme);
                alertify.success('Logovanje uspešno');
                setTimeout(function(){
                   //window.location.reload();
                   window.location.href = 'shop';
                },1500);
            }
            if(response == 0){
                alertify.error('Pogrešna mail adresa ili šifra');
            }
            if(response == 2){
                alertify.error('Email adresa nije potvrđena');
            }
            if(response == 3){
                alertify.error('Email adresa nije potvrdđena');
            }
            if(response == 4){
                alertify.error('Nedovoljne privilegije ili nepostojeće!');
            }
			
        }
    })
}
function userLogout(){
    var data = {
        action: 'userlogout'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
            window.location.href = '';

        }
    })
}

function changePassword(){
	var data = {
        action: 'changepassword',
		oldpass: $("#old_pass").val(),
		newpass: $("#new_pass2").val()
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
			if(response == 1){
				alertify.success('Uspesno promenjena lozinka.');
				$('#ChangePassword').modal('hide');	
				$("#old_pass").val('');
				$("#new_pass1").val('');
				$("#new_pass2").val('');
				
			}else{
				alertify.error('Greska prilikom promene lozinke.');		
			}

        }
    })	
}

function orderPoruci(){
	
    var data = {
        action: 'orderporuci'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
			window.location.href = '';
        }
    })
}

function orderPoruciB2B(){
    var data = {
        action: 'orderporucib2b'
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
            window.location.href = '';
        }
    })
}

function userRegistration(name, lastname, email, password, passwordconf, telefon, adresa, mesto, postbr, defaultlang,birthday){
    var data = {
        action: 'userregister',
        name: name,
        lastname: lastname,
        email: email,
        password: password,
        passwordconf: passwordconf,
        telefon: telefon,
        adresa: adresa,
        mesto: mesto,
        postbr: postbr,
        defaultlang: defaultlang,
        birthday: birthday
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
            if(response == 1){
                alertify.success('Registracija uspesna, molimo vas da potvrdite vas mail');
                setTimeout(function(){
                    document.location.reload();
                },2500);
            }
            if(response == 0){
                alertify.error('e-mail adresa postoji');
            }
            if(response == 2){
                alertify.error('sifre se ne poklapaju');
            }
            if(response == 3){
                alertify.error('greska-> Query Fail');
            }
            if(response == 4){
                alertify.error('Nedovoljne privilegije ili nepostojece!');
            }
        }
    })
}
function lostPass(email){
    var data = {
        action: 'lostpass',
        email: email
    };
    $.ajax({
        type: "POST",
        data: data,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
            if(response == 1){
                alertify.success('Zahtev za resetovanje lozinke je poslat na Vaš mail.');
                setTimeout(function(){
                    document.location.reload();
                },2500);
            }
            if(response == 0){
                alertify.error('E-mail adresa ne postoji.');
            }

        }
    })
}

function addNewsletter(email){
    var data = {
        action: 'addnewsletter',
        email: email
    };
    $.ajax({
        type: "POST",
        data: data,
		async: true,
		crossDomain: true,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
            if(response == 1){
				alertify.success('Uspešno dodata email adresa.');	
				$('.newsletterInput').val('');
            }
            if(response == 0){
                alertify.error("Email adresa već postoji");
            }

        }
    })
}


function getDocumentItems(button){
	var data = {
		action: 'getdocumentitems',
		docid: $(button).attr('id')
	};
	$.ajax({
		type: "POST",
		data: data,
		url: "index.php",
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert("ERROR:" + errorThrown);
		},
		success: function(response){
			var res = JSON.parse(response);
			console.log(response);
			
			$('.jq_documentItemsModalTbody').html('');
			
			doctype = '';
			if($(button).attr('doctype') == 'r') doctype = "Racun ";
			if($(button).attr('doctype') == 'e') doctype = "Rezervacija ";
			$('.jq_itemsModalRok').remove();
			if($(button).attr('doctype') == 'p'){
				doctype = "Povrat robe ";
				$(document.createElement('th')).addClass('jq_itemsModalRok').html('Rok').insertAfter(".jq_itemsModalQty");
			}
			if($(button).attr('doctype') == 'k') doctype = "Knjižno odobrenje ";
			if($(button).attr('doctype') == 'z') doctype = "Zamena ";
			
			$('.jq_documentItemsModalDoctype').html(doctype);
			$('.jq_documentItemsModalDocNumber').html($(button).attr('docnumber'));
			
			var td = $(document.createElement('td'));
			
			for(var i = 0; i< res[1].length; i++){
				var tr = $(document.createElement('tr'));
				
				pdvprice = res[1][i]['price']*((res[1][i]['taxvalue']+100)/100);
				value = pdvprice*((100-res[1][i]['rebate'])/100);
				
				$($(td).clone(true)).html(res[1][i]['productname']).appendTo($(tr));
				
				var icon = '';
				if($(button).attr('doctype') == 'z'){
					icon = '<i class="fa fa-plus green" aria-hidden="true"></i>';
					if(parseInt(res[1][i][['quantity']]) < 0) icon = '<i class="fa fa-minus red" aria-hidden="true"></i>';
				}
				$($(td).clone(true)).html(res[1][i]['quantity']+" "+icon).appendTo($(tr));
				 
				if($(button).attr('doctype') == 'p'){
					var icon = '<i class="fa fa-ban red" aria-hidden="true"></i>';
					if(res[1][i]['rokstatus'] == 1) icon = '<i class="fa fa-check green" aria-hidden="true"></i>';
					$($(td).clone(true)).html(res[1][i]['bestbeforedate']+" "+icon).appendTo($(tr));		
				}
				$($(td).clone(true)).html(res[1][i]['rebate']).appendTo($(tr));
				$($(td).clone(true)).html(pdvprice).appendTo($(tr));
				$($(td).clone(true)).html(value).appendTo($(tr));
				
				
				
				$(tr).appendTo($('.jq_documentItemsModalTbody'));
			}
			
			$('.jq_documentDescriprionModalHolder').html(res[2]);
			
			$('#jq_documentItemsModalCont').modal('show');
		}
	})	
}

function menusubcategorydata(parentid){
	var data = {
        action: 'menusubcategorydata',
        catid: parentid
    };
    $.ajax({
        type: "POST",
        data: data,
		async: true,
		crossDomain: true,
        url: "index.php",
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("ERROR:" + errorThrown);
        },
        success: function(response){
			var res = JSON.parse(response);
			console.log(res);
            
			if($('.jq_leftMenuSubBody').length > 0)
			{	/*	sub	*/			
				$('.jq_leftMenuSubBody:last-child').find('.jq_smallLeftMenuItemCont').html('');
				for(var i = 0; i < res.length; i++){
					var clone = $('.jq_smallMenuItemHolderTemplate').clone(true).removeClass('hide').removeClass('jq_smallMenuItemHolderTemplate').attr('catid', res[i].id);
					$(clone).find('.jq_forwardLeftMenuName').attr('href',res[i].catobj.path ).html(res[i].name);
					$(clone).find('.jq_forwardLeftMenuBtn').addClass((res[i].childs > 0)? '':'hide');
					
					$(clone).appendTo($('.jq_leftMenuSubBody:last-child').find('.jq_smallLeftMenuItemCont'));
				}
				$('.jq_leftMenuBackBtn').addClass('material-icons').text('keyboard_arrow_left').css('visibility', 'visible');
				TweenMax.to($('.body-container').find('.jq_leftMenuSubBody:last-child'), 0.2, { left: "0" });		
			}else
			{	/*	root	*/
				$('.jq_smallLeftMenuItemCont').html('');
				for(var i = 0; i < res.length; i++){
					var clone = $('.jq_smallMenuItemHolderTemplate').clone(true).removeClass('hide').removeClass('jq_smallMenuItemHolderTemplate').attr('catid', res[i].id);
					$(clone).find('.jq_forwardLeftMenuName').attr('href',res[i].urlname ).html(res[i].name);
					$(clone).find('.jq_forwardLeftMenuBtn').addClass((res[i].childs > 0)? '':'hide');
					
					$(clone).appendTo($('.jq_smallLeftMenuItemCont'));
				}
			}

        }
    })	
}

function checkCoupon(){
	var $this = $('.cms_couponInput');
	var data = {
		action: 'getcoupon',
		coupon: $($this).val()
	};
	$.ajax({
		type : 'POST',
		url: "index.php",
		data : data,
		success : function(data){
			if(data == 0){
				window.location.reload();	
			}else{
				alert('Nevalidan kupon');	
			}
			
		},
		error : function(){
			alert("error");
		}
	});		
}

function removeCoupon(){
	var data = {
		action: 'removecoupon'
	};
	$.ajax({
		type : 'POST',
		url: "index.php",
		data : data,
		success : function(data){
			if(data == 0){
				window.location.reload();	
			}else{
				alert('Nevalidan kupon');	
			}
			
		},
		error : function(){
			alert("error");
		}
	});		
}


