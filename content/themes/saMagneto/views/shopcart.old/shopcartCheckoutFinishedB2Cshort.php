<div class="page-head">
    <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
                <span itemprop="name"><?php echo $language["global"][3]; ?></span>
            </a>
        </li>
        <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <span itemprop="name"><?php echo $language["shopcart"][1]; //Korpa ?></span>
        </li>
    </ol>
</div>

<?php $quantity_rebate_on = false; //QUANTITY REBATE VIEW FLAG
    if($user_conf["quantity_rebate"][1]==1 || $user_conf["quantity_rebate"][1]==3) { $quantity_rebate_on=true; } // SET QUANTITY REBATE VIEW FLAG FROM USER CONFIGURATION
?>
<section>
    <div class="container cart-container">
        <div class="content-page">
            <div class="row noMargin">
                <div class="col-xs-12 checkout-confirmation-info-box">
                    <h4 class="title -confirm">Vaša porudžbina broj <span class="dinamic"><?php echo $documentData->number; ?></span> je uspešno prosleđena!</h4>
                </div>
            </div>
            <div class="row noMargin">
                <div class="col-xs-12 _col-xs-100 checkout-confirmation-info-box">
                    <h4 class="title"><?php echo $language["shopcart_checkout"][1]; //Podaci za dostavu i plaćanje?></h4>
                    <div class="my-label-holder">
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][1]; //Ime ?>:</span> <span class="dinamic"><?php  echo $documentData->documentdetail['customername']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][3]; //Prezime ?>:</span> <span class="dinamic"><?php  echo $documentData->documentdetail['customerlastname']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][5]; //Email ?>:</span><span class="dinamic"><?php  echo $documentData->documentdetail['customeremail']; ?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][8]; //Broj telefona ?>:</span><span class="dinamic"><?php  echo $documentData->documentdetail['customerphone']; ?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][10]; //Adresa ?>:</span> <span class="dinamic"><?php  echo $documentData->documentdetail['customeraddress']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][12]; //Mesto ?>:</span><span class="dinamic"><?php  echo $documentData->documentdetail['customercity']; ?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][14]; //Postanski broj ?>:</span><span class="dinamic"><?php  echo $documentData->documentdetail['customerzip']; ?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][16]; //Način plaćanja ?>:</span><span class="dinamic"> <?php 
							if($documentData->payment=='p'){ 
								echo $language["shopcart_checkout_customer"][17]; //Pouzećem 
							} 
							if($documentData->payment=='u'){
								echo  $language["shopcart_checkout_customer"][18]; //Uplatnicom
							}
							if($documentData->payment=='k'){
								echo $language["shopcart_checkout_customer"][19]; //Karticom
							}
                            if($documentData->payment=='v'){
                                echo $language["shopcart_checkout_customer"][21]; //Virman
                            }  
					 ?>
					 </span>
                    </label>
                    </div>
                </div>
                <?php $checkRecipient=$documentData->documentdetail['recipientname'];?>
                <?php $checkRecipient.=$documentData->documentdetail['recipientlastname'];?>
                <?php $checkRecipient.=$documentData->documentdetail['recipientphone'];?>
                <?php $checkRecipient.=$documentData->documentdetail['recipientaddress'];?>
                <?php $checkRecipient.=$documentData->documentdetail['recipientcity'];?>
                <?php $checkRecipient.=$documentData->documentdetail['recipientzip'];?>

                <?php if(strlen($checkRecipient)>0 && $checkRecipient!=''){?>
                <div class="col-xs-12 _col-xs-100 checkout-confirmation-info-box">
                    <h4 class="title"><?php echo $language["shopcart_checkout"][3]; //Podaci za dostavu?></h4>
                    <div class="my-label-holder">
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][1]; //Ime ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['recipientname']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][3]; //Prezime ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['recipientlastname']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][5]; //Broj telefona ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['recipientphone']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][7]; //Adresa ?>:</span><span class="dinamic"><?php echo $documentData->documentdetail['recipientaddress']; ?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][9]; //Mesto ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['recipientcity']; ?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][11]; //Postanski broj ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['recipientzip']; ?></span>
                    </label>
                    </div>
                </div>
                <?php } ?>
                <?php if($documentData->documentdetail['deliverytype']!='h'){?>
                <div class="col-xs-12 _col-xs-100 checkout-confirmation-info-box">
                   
                    <?php if($documentData->documentdetail['deliverytype']=='p' && $documentData->documentdetail['deliveryshopid']>0 && count($documentData->documentdetail['deliveryshopdata'])>0){?>
                     <h4 class="title"><?php echo $language["shopcart_checkout"][4]; //Način dostave ?> - <?php echo $language["shopcart_checkout"][5]; //Lično preuzimanje?></h4>
                       
                        <!-- delivery personal info -->
                        <div class="my-label-holder">
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][1]; //Naziv ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryshopdata']['name'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][2]; //Adresa ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryshopdata']['address'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][3]; //Grad ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryshopdata']['cityname'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][4]; //Telefon ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryshopdata']['phone'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][5]; //Email ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryshopdata']['email'];?>&nbsp;</span>
                            </label>

                        </div>
                        <!-- delivery personal info END -->
                        
                    <?php }?>
                    <?php if($documentData->documentdetail['deliverytype']=='d' && $documentData->documentdetail['deliveryserviceid']>0 && count($documentData->documentdetail['deliveryservicedata'])>0){ ?>
                     <h4 class="title"><?php echo $language["shopcart_checkout"][4]; //Način dostave ?> - <?php echo $language["shopcart_checkout"][6]; //Kurirskom službom?></h4>
                   
                        <?php //var_dump($deliveryServiceInfoData);?>
                        <div class="my-label-holder">
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][1]; //Kurirska služba ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryservicedata']['name']; ?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][2]; //Telefon ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryservicedata']['phone']; ?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][3]; //Email ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryservicedata']['email']; ?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][4]; //Web sajt ?>:</span> <span class="dinamic"><?php echo $documentData->documentdetail['deliveryservicedata']['website']; ?></span>
                            </label>
                        </div>
                    
                    <?php }?>
                </div>
                <?php } ?>
            </div>   
           <div class="row noMargin">
<!-- TABLE HEADER SHOPCART AND SHOPCARTREQUEST #######################################################################################################################################################################################-->
 <?php  if($quantity_rebate_on){ ?>
	<div class="korpa-holder hidden-xs hidden-sm korpa-heading">
    <!-- QUANTITY REBATE ON -->
    <!-- PRODUCT INFO -->
    <div class="col-sm-6 col-xs-7 korpa korpa-proizvod col-seter">
        <p class="title"><?php  echo $language["shopcarttable"][1]; //Proizvod ?></p>
        </div>
        <!-- PRODUCT INFO END-->
        <!-- PRODUCT QUANTITY -->
        <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][2]; //Količina ?></p>

        </div>
        <!-- PRODUCT QUANTITY END-->
        <!-- PRODUCT PRICE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][3]; //Cena ?></p>

        </div>
        
        <div class="col-sm-2 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>

        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT TOTAL REBATE -->
        <!-- <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  //echo $language["shopcarttable"][7]; //Ukupni popust ?></p>

        </div> -->
        <!-- PRODUCT TOTAL REBATE END-->
        <!-- PRODUCT PRICE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][8]; //Cena sa popustom?></p>

        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>

        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][12]; //PDV stopa ?></p>
        </div>
        <!-- PRODUCT VAT END-->
        <!-- PRODUCT TOTAL WITH VAT-->
        <div class="col-sm-2 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>

        </div>
        <!-- PRODUCT TOTAL WITH VAT-->
        
        <!-- QUANTITY REBATE ON END-->
    </div>
    <?php  } else { ?>
    <div class="korpa-holder hidden-xs hidden-sm korpa-heading">
    <!-- QUANTITY REBATE ON -->
    <!-- PRODUCT INFO -->
        <div class="col-sm-7 col-xs-7 korpa korpa-proizvod col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][1]; //Proizvod ?></p>
        </div>
        <!-- PRODUCT INFO END-->
        <!-- PRODUCT QUANTITY -->
        <div class="col-sm-2 col-xs-5 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][2]; //Količina ?></p>
        </div>
        <!-- PRODUCT QUANTITY END-->
        <!-- PRODUCT PRICE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][3]; //Cena ?></p>
        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>
        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT PRICE WITH REBATE-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][8]; //Cena sa popustom?></p>
        </div>
        <!-- PRODUCT PRICE WITH REBATE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>
        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter hide">
            <p class="title"><?php  echo $language["shopcarttable"][12]; //PDV stopa ?></p>
        </div>
        <!-- PRODUCT VAT END-->
         <!-- PRODUCT TOTAL WITH VAT-->
        <div class="col-sm-2 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>

        </div>
        <!-- PRODUCT TOTAL WITH VAT-->
        
        <!-- QUANTITY REBATE ON END-->
    </div>
    <?php  } ?>


<!-- TABLE HEADER SHOPCART  AND SHOPCARTREQUEST END #################################################################################################################################################################################-->
    <?php $total = 0; ?>
    <?php $total_rebate = 0; ?>
    <?php $total_price = 0; ?>
    <?php $total_tax = 0; ?>
    <?php $total_price_pdv = 0; ?>
<!-- TABLE DATA SHOPCART ############################################################################################################################################################################################################-->

    <?php foreach ($documentData->documentitem as $key => $cartprod) { ?>
        <?php //var_dump($cartprod);?>
    <!-- TABLE ROW PRODUCTITEM -->
        <!-- CALCULATE ITEM QUANTITY REBATE -->
        <?php $quantityrebate = 0; ?>
        <?php if($quantity_rebate_on){ ?>
        <?php   if(isset($cartprod['quantityrebate']) && count($cartprod['quantityrebate'])>0) { 
                    foreach($cartprod['quantityrebate'] as $qrval) { 
                        if( intval($cartprod['qty'])>=intval($qrval["quantity"]) ) { 
                            $quantityrebate=($qrval["rebate"]) ;
                        } 
                    }
                } else {  
                    $quantityrebate=0 ; 
                } 
        ?>
        <?php } ?>
        <!-- CALCULATE ITEM QUANTITY REBATE END-->
        <!-- CALCULATE ITEM DATA -->
        <?php
                    $total += $cartprod['price']  * $cartprod['qty'];
                    $item_rebate = 0; 
                    $item_rebate=($cartprod['rebate']+((100-$cartprod['rebate'])*($quantityrebate/100)));
                    $zero_rebate=false;
                    if(($item_rebate>=$cartprod['maxrebate'] || is_null($cartprod['maxrebate'])) && $user_conf["act_priority"]==0){
                        $item_rebate=$cartprod['maxrebate'];
                        $zero_rebate=true;
                    }
                    $total_rebate += $cartprod['price']  * $cartprod['qty']*($item_rebate/100);
                    $article_total_price = $cartprod['price']  * $cartprod['qty'] * (1-($item_rebate/100));
                    $article_total_price_pdv = $cartprod['price'] * $cartprod['qty'] * (1-($item_rebate/100)) * ((100+$cartprod['tax'])/100);
                    $total_price += $article_total_price;
                    $total_tax +=$article_total_price * (($cartprod['tax'])/100);
                    $total_price_pdv += $article_total_price_pdv;
        ?>
        <!-- CALCULATE ITEM DATA END -->
            <!-- KORPA VELIKA -->
            <div class="korpa-holder hidden-xs hidden-sm article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
            <?php if($quantity_rebate_on){ ?>
            <!-- QUANTITY REBATE ON -->
                    <!-- PRODUCT INFO -->
                    <div class="col-sm-6 col-xs-7 korpa korpa-proizvod col-seter">
                        
                        <div class="korpa-proizvod-pic">

                            <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$cartprod['pic'], 'thumb');?>" alt="korpa" class="img-responsive">
                        </div>
                        <a href="<?php echo $cartprod['link']?>" class="korpa-proizvod-name"><?php echo $cartprod['name']?></a>
                        <br>
                        <!-- ITEM ATRIBUTES -->
                        <?php 
                           $attributes=''; 
                           $i=0;
                            foreach ($cartprod['attrn'] as $attr) { 
                                $i++;
                                if($i==1){
                                    $attributes.=$attr['attrname'].':'.$attr['attrvalname'];
                                } else {
                                    $attributes.=','.$attr['attrname'].':'.$attr['attrvalname'];
                                }
                           } 
                        ?>
                        <!--<small>Šifra: </small>-->
                        <small><?php echo $attributes;?></small>
                        <!-- ITEM ATRIBUTES END-->
                    </div>
                    <!-- PRODUCT INFO END-->
                    <!-- PRODUCT QUANTITY -->
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                        <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                    </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter">
                        
                        <!-- <span><?php //echo number_format($cartprod['price'] , 2, ",", "."); ?></span> -->
                        <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100))*(1+($cartprod['tax']/100)) , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT QUANTITY REBATE -->
                    
                    <div class="col-sm-2 col-xs-4 korpa korpa-popust col-seter hide">
                        <table width="100%">
                            <tr>
                                <th width="33%" style="text-align: center;"><?php echo $language["shopcarttable"][5]; //Kolicinski popust?></th>
                                <th width="33%" style="text-align: center;border-right: #ccc 1px solid;"><?php echo $language["shopcarttable"][6]; //Popust?></th>
                                <th width="33%" style="text-align: center;"><?php echo $language["shopcarttable"][7]; //Ukupni popust?></th>
                            </tr>
                            <tr>
                                <!-- QUANTITY REBATE -->
                                <td width="33%" style="text-align: center;">
                                    <?php if(!$zero_rebate){
                                            echo $quantityrebate." %";
                                        } else {
                                            echo '0 %';
                                        }?> 
                                </td>
                                <!-- QUANTITY REBATE END-->
                                <!-- REBATE -->
                                <td width="33%" style="text-align: center;border-right: #ccc 1px solid;">       
                                    <?php if(!$zero_rebate){
                                            echo $cartprod['rebate']." %";
                                        } else {
                                            echo '0 %';
                                        }?>

                                </td>
                                <!-- REBATE END-->
                                <!-- TOTAL REBATE -->
                                <td width="33%" style="text-align: center;">
                                    <?php echo $item_rebate; ?>%
                                </td>
                                <!-- TOTAL REBATE END-->
                            </tr>
                        </table>
                        
                         
                    </div>
                    
                    <!-- PRODUCT QUANTITY REBATE END-->
                    
                    <!-- PRODUCT PRICE WITH REBATE-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter hide">
                        <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100)) , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE WITH REBATE END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter hide">
                        <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT VAT-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter hide">
                        <span><?php echo number_format($cartprod['tax'], 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT VAT END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-2 col-xs-4 korpa korpa-ukupno col-seter">
                        <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                   
                <!-- QUANTITY REBATE ON END-->
                <?php } else { ?>
                <!-- QUANTITY REBATE OFF -->
                     <!-- PRODUCT INFO -->
                    <div class="col-sm-7 col-xs-7 korpa korpa-proizvod col-seter">
                        <div class="korpa-proizvod-pic">
                            <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$cartprod['pic'], 'thumb');?>" alt="korpa" class="img-responsive">
                        </div>
                        <a href="<?php echo $cartprod['link']?>" class="korpa-proizvod-name"><?php echo $cartprod['name']?></a>
                        <br>
                        <!-- ITEM ATRIBUTES -->
                        <?php 
                           $attributes=''; 
                           $i=0;
                            foreach ($cartprod['attrn'] as $attr) { 
                                $i++;
                                if($i==1){
                                    $attributes.=$attr['attrname'].':'.$attr['attrvalname'];
                                } else {
                                    $attributes.=','.$attr['attrname'].':'.$attr['attrvalname'];
                                }
                           } 
                        ?>
                        <!--<small>Šifra: </small>-->
                        <small><?php echo $attributes;?></small>
                        <!-- ITEM ATRIBUTES END-->
                    </div>
                    <!-- PRODUCT INFO END-->
                    <!-- PRODUCT QUANTITY -->
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                        <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                    </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter">
                       <!--  <span><?php echo number_format($cartprod['price'] , 2, ",", "."); ?></span> -->
                       <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100))*(1+($cartprod['tax']/100)) , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT REBATE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-popust col-seter hide">
                        <span><?php echo $item_rebate; ?>%</span>
                    </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT PRICE WITH REBATE-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter hide">
                        <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100)) , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE WITH REBATE END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter hide">
                        <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT VAT-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter hide">
                        <span><?php echo number_format($cartprod['tax'], 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT VAT END-->
                    <!-- PRODUCT TOTAL WITH VAT-->
                    <div class="col-sm-2 col-xs-4 korpa korpa-ukupno col-seter">
                        <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL VITH VAT END-->
                    
                <!-- QUANTITY REBATE OFF END-->
                <?php } ?>    
                </div>
                <!-- .KORPA VELIKA -->
                <!-- KORPA MALA -->
                <div class="korpa-holder-xs visible-xs visible-sm article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
                <?php if($quantity_rebate_on){ ?>
                    <!-- PRODUCT INFO -->
                        <div class=" col-sm-8 col-xs-7 korpa korpa-proizvod">
                            <div class="korpa-proizvod-pic">
                                <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$cartprod['pic'], 'thumb');?>" alt="korpa" class="img-responsive">
                            </div>
                            <a href="<?php echo $cartprod['link']?>" class="korpa-proizvod-name"><?php echo $cartprod['name']?></a>
                            <br>
                            <!-- ITEM ATRIBUTES -->
                            <?php 
                            $attributes=''; 
                            $i=0;
                            foreach ($cartprod['attrn'] as $attr) { 
                                $i++;
                                if($i==1){
                                    $attributes.=$attr['attrname'].':'.$attr['attrvalname'];
                                } else {
                                    $attributes.=','.$attr['attrname'].':'.$attr['attrvalname'];
                                }
                            } 
                            ?>
                            <!--<small>Šifra: </small>-->
                            <small><?php echo $attributes;?></small>
                            <!-- ITEM ATRIBUTES END-->
                            
                        </div>
                    <!-- PRODUCT INFO END-->
                    <!-- PRODUCT QUANTITY -->
                        <div class=" col-sm-4 col-xs-5 korpa korpa-kolicina cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                            <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                        </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                        <div class=" col-sm-3 col-xs-3 korpa korpa-cena hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][3]; //Cena?></p>
                            <span><?php echo number_format($cartprod['price'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT QUANTITY REBATE -->
                        <div class=" col-sm-2 col-xs-3 korpa korpa-cena hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][5]; //Količinski popust?></p>
                            <span><?php if(!$zero_rebate){ echo $quantityrebate." %"; } else { echo '0 %'; }?></span>
                        </div>
                    <!-- PRODUCT QUANTITY REBATE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-sm-1 col-xs-3 korpa korpa-popust hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][6]; //Popust ?></p>
                            <span><?php if(!$zero_rebate){ echo $cartprod['rebate']." %"; } else { echo '0 %'; }?></span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-sm-3 col-xs-3 korpa korpa-popust hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][7]; //Ukupni popust ?></p>
                            <span><?php echo $item_rebate; ?>%</span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT PRICE -->
                        <div class=" col-sm-3 col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][3]; //Cena ?></p>
                             <span><?php echo number_format($cartprod['price'] * (1-($item_rebate/100))*(1+($cartprod['tax']/100)), 2, ",", "."); ?></span>
                            <!-- <p class="small-cart-desc"><?php //echo $language["shopcarttable"][8]; //Cena sa popustom?></p>
                            <span><?php //echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span> -->
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT TOTAL-->
                        <div class="col-sm-3 col-xs-3 korpa korpa-ukupno hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][10]; //Ukupno bez PDV-om?></p>
                            <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT VAT-->
                        <div class="col-sm-3 col-xs-3 korpa korpa-ukupno hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][12]; //PDV?></p>
                            <span><?php echo number_format($cartprod['tax'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT VAT END-->
                    <!-- PRODUCT TOTAL WITH VAT-->
                        <div class="col-sm-6 col-xs-3 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>
                            <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL WITH VAT END-->
                    
                 <?php } else { ?>
                     <!-- PRODUCT INFO -->
                        <div class=" col-xs-8 korpa korpa-proizvod">
                            <div class="korpa-proizvod-pic">
                                <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$cartprod['pic'], 'thumb');?>" alt="korpa" class="img-responsive">
                            </div>
                            <a href="<?php echo $cartprod['link']?>" class="korpa-proizvod-name"><?php echo $cartprod['name']?></a>
                            <br>
                            <!-- ITEM ATRIBUTES -->
                            <?php 
                            $attributes=''; 
                            $i=0;
                            foreach ($cartprod['attrn'] as $attr) { 
                                $i++;
                                if($i==1){
                                    $attributes.=$attr['attrname'].':'.$attr['attrvalname'];
                                } else {
                                    $attributes.=','.$attr['attrname'].':'.$attr['attrvalname'];
                                }
                            } 
                            ?>
                            <!--<small>Šifra: </small>-->
                            <small><?php echo $attributes;?></small>
                            <!-- ITEM ATRIBUTES END-->
                            
                        </div>
                    <!-- PRODUCT INFO END-->
                    <!-- PRODUCT QUANTITY -->
                        <div class=" col-xs-4 korpa korpa-kolicina cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                            <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                        </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                        <div class=" col-xs-4 korpa korpa-cena hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][3]; //Cena ?></p>
                            <span><?php echo number_format($cartprod['price'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-xs-2 korpa korpa-popust hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][6]; //Popust ?></p>
                            <span><?php echo $item_rebate; ?>%</span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT PRICE WITH REBATE-->
                        <div class=" col-xs-4 korpa korpa-cena hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][8]; //Cena sa popustom?></p>
                            <span><?php echo number_format($cartprod['price'] * (1-($item_rebate/100)), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE WITH REBATE END-->
                    <!-- PRODUCT TOTAL-->
                        <div class="col-xs-4 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][3]; //Cena ?></p>
                             <span><?php echo number_format($cartprod['price'] * (1-($item_rebate/100))*(1+($cartprod['tax']/100)), 2, ",", "."); ?></span>
<!--                             <p class="small-cart-desc"><?php //echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>
                            <span><?php //echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span> -->
                        </div>
                    <!-- PRODUCT TOTAL-->
                    <!-- PRODUCT VAT-->
                        <div class="col-xs-2 korpa korpa-ukupno hide">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][12]; //PDV?></p>
                            <span><?php echo number_format($cartprod['tax'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT VAT-->
                    <!-- PRODUCT TOTAL WITH VAT-->
                        <div class="col-xs-6 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>
                            <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL WITH VAT-->
                    
                <?php } ?>    
                </div>
                    <!-- .KORPA MALA -->
                    <!-- TABLE ROW PRODUCTITEM END-->
                    <?php } ?>
<!-- TABLE DATA SHOPCART END #########################################################################################################################################################################################################-->
        </div>
        <hr>
        <div class="row noMargin">
           <!--  <div class="col-sm-6 col-seter">
                <div class="left-cart-panel">    
                    <div class="hidden-xs">
                        <?php // include("app/controller/controller_orderHelpMenu.php")?>  
                    </div>
                </div>
                
            </div> -->

            <div class="col-sm-6 sve-korpa col-seter">
                <h4 class="hide"><p class="go-left"><?php echo $language["shopcart"][3]; //Ukupno?>:</p> <p class="go-right"><?php echo number_format($total, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br class="hide">
                <h4 class="hide"><p class="go-left"><?php echo $language["shopcart"][4]; //Popust?>:</p> <p class="go-right"><?php echo '-'.number_format(round($total_rebate, 2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br class="hide">
                <hr class="hide">
                <h4 class="hide"><p class="go-left"><?php echo $language["shopcart"][5]; //Ukupno sa popustom bez PDV-a?>:</p> <p class="go-right"><?php echo number_format(round($total,2)-round($total_rebate,2), 2, ",", "."); //echo number_format($total_price, 4, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br class="hide">
                <h4 class="hide"><p class="go-left"><?php echo $language["shopcart"][6]; //PDV?>:</p> <p class="go-right"><?php echo '+'.number_format(round($total_tax,2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br class="hide">
                <?php $delivery_cost=0; 
                    if(floatval(round($total,2)-round($total_rebate,2)+round($total_tax,2)-((isset($_SESSION['voucher']['value']))? $_SESSION['voucher']['value']:0))== 0 || floatval(round($total,2)-round($total_rebate,2)+round($total_tax,2)-((isset($_SESSION['voucher']['value']))? $_SESSION['voucher']['value']:0))>floatval($user_conf["free_delivery_from"][1])){
                        $delivery_cost=0;
                    } else {
                        $delivery_cost= $user_conf["delivery_cost"][1];
                    }
                    if($delivery_cost>0){?>
                        <h4><p class="go-left"><?php echo $language["shopcart"][8]; //Troškovi dostave ?>:</p> <p class="go-right"> <?php $delivery_cost; ?></p></h4>
                    <?php } ?>
                        <hr class="hide">
                        
                        <?php //$_SESSION['voucher']=array();?>
                        <?php //$_SESSION['voucher']['id'] = 1;?>
                        <?php //$_SESSION['voucher']['code'] = '7b7f7sd8sdffsa5';?>
                        <?php ///$_SESSION['voucher']['value'] = 500;?>
                    <!-- TOTAL WITH VAT SECTION -->
                         <h4 class="aditi"><b><?php echo $user_conf["footnote_delivery_cost"][1].$user_conf["free_delivery_from"][1].' '.$language["moneta"][1].$user_conf["footnote_delivery_cost1"][1]; ?></b></h4>
                        <?php if(isset($_SESSION['voucher']['code']) && $_SESSION['voucher']['code']!='' && isset($_SESSION['voucher']['value']) && $_SESSION['voucher']['value']>0) { //IMPORTANT IMA VAUCER?>
                        <!-- HAS VOUCHER SECTION -->
                            <h4><p class="go-left"><?php echo $language["shopcart"][7]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right "><?php echo number_format(round($total,2)-round($total_rebate,2)+round($total_tax,2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p>
                            </h4><br>
                            <h4><p class="go-left"><?php echo $language["shopcart"][17]; //Iznos vaučera ?>:</p> <p class="go-right "><?php echo '-'.number_format($_SESSION['voucher']['value'], 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p>
                            </h4><br>
                            <hr>
                            <h4><p class="go-left total-price-cart"><?php echo $language["shopcart"][7]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right total-price-cart"><?php echo number_format(round($total,2)-round($total_rebate,2)+round($total_tax,2)+floatval($delivery_cost)-$_SESSION['voucher']['value'], 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p>
                            </h4>
                        <!-- HAS VOUCHER SECTION END-->
                        <?php  } else { ?>
                        <!-- NO VOUCHER SECTION -->
                            <h4><p class="go-left total-price-cart"><?php echo $language["shopcart"][7]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right total-price-cart"><?php echo number_format(round($total,2)-round($total_rebate,2)+round($total_tax,2)+floatval($delivery_cost), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p>
                            </h4>
                        <!-- NO VOUCHER SECTION -->
                        <?php  } ?>
                    <!-- TOTAL WITH VAT SECTION END-->
                        <br>
                    <!-- COMMENT -->
                    <div class="checkout-confirmation-amount-comment-box clearfix">
                        <h4><?php echo $language["shopcart"][2]; //KOMENTAR - Dodatne napomene u vezi sa narudžbinom ?></h4>
                        <?php //echo substr($documentData->comment, 5); ?>
                        <p><?php if(strlen(substr($documentData->comment, 5))>0) { echo substr($documentData->comment, 5); } else { echo 'Nema napomena u vezi sa porudžbinom.';} ?></p>
                    </div>
                    <!-- COMMENT END-->
                    <br>
            </div>
        </div> 
    </div>
    <div class="row noMargin">
            <div class="col-xs-12 text-right col-seter">
                <a href="shop" class="sa-button  -rounded -success _half-width" style="margin-bottom: 50px;color:#fff;">Nastavite kupovinu</a>
            </div>
        </div>
</section>