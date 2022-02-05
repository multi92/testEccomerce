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
                <div class="col-xs-12 _col-xs-100 checkout-confirmation-info-box">
                    <h4 class="title"><?php echo $language["shopcart_checkout"][1]; //Podaci za dostavu i plaćanje?></h4>
                    <div class="my-label-holder">
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][1]; //Ime ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['customer']['name'])){ echo $_SESSION['order']['customer']['name']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][3]; //Prezime ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['customer']['name'])){ echo $_SESSION['order']['customer']['lastname']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][5]; //Email ?>:</span><span class="dinamic"><?php if(isset($_SESSION['order']['customer']['name'])){ echo $_SESSION['order']['customer']['email']; }?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][8]; //Broj telefona ?>:</span><span class="dinamic"><?php if(isset($_SESSION['order']['customer']['phone'])){ echo $_SESSION['order']['customer']['phone']; }?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][10]; //Adresa ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['customer']['address'])){ echo $_SESSION['order']['customer']['address']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][12]; //Mesto ?>:</span><span class="dinamic"><?php if(isset($_SESSION['order']['customer']['address'])){ echo $_SESSION['order']['customer']['city']; }?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][14]; //Postanski broj ?>:</span><span class="dinamic"><?php if(isset($_SESSION['order']['customer']['address'])){ echo $_SESSION['order']['customer']['zip']; }?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_customer"][16]; //Način plaćanja ?>:</span><span class="dinamic"> <?php if(isset($_SESSION['order']['paymenttype'])){
                                                                                                            if($_SESSION['order']['paymenttype']=='p'){ 
                                                                                                                echo $language["shopcart_checkout_customer"][17]; //Pouzećem 
                                                                                                            } 
                                                                                                            if($_SESSION['order']['paymenttype']=='u'){
                                                                                                                echo  $language["shopcart_checkout_customer"][18]; //Uplatnicom
                                                                                                            }
                                                                                                            if($_SESSION['order']['paymenttype']=='k'){
                                                                                                                echo $language["shopcart_checkout_customer"][19]; //Karticom
                                                                                                            } 
                                                                                                     }?>
                                                                                                     </span>
                    </label>
                    </div>
                </div>
                <?php $checkRecipient='';?>
                <?php if(isset($_SESSION['order']['recipient']) && count($_SESSION['order']['recipient'])>0){
                    foreach($_SESSION['order']['recipient'] as $rval){
                        $checkRecipient.=$rval;
                    }
                }?>
                <?php if(isset($_SESSION['order']['recipient']) && $checkRecipient!='' && strlen($checkRecipient)>0){?>
                <div class="col-xs-12 _col-xs-100 checkout-confirmation-info-box">
                    <h4 class="title"><?php echo $language["shopcart_checkout"][3]; //Podaci za dostavu?></h4>
                    <div class="my-label-holder">
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][1]; //Ime ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['recipient']['name'])){ echo $_SESSION['order']['recipient']['name']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][3]; //Prezime ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['recipient']['name'])){ echo $_SESSION['order']['recipient']['lastname']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][5]; //Broj telefona ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['recipient']['phone'])){ echo $_SESSION['order']['recipient']['phone']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][7]; //Adresa ?>:</span><span class="dinamic"><?php if(isset($_SESSION['order']['recipient']['address'])){ echo $_SESSION['order']['recipient']['address']; }?></span> 
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][9]; //Mesto ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['recipient']['address'])){ echo $_SESSION['order']['recipient']['city']; }?></span>
                    </label>
                    
                    <label class="checkout-confirmation-my-label">
                        <span class="static"><?php echo $language["shopcart_checkout_recipient"][11]; //Postanski broj ?>:</span> <span class="dinamic"><?php if(isset($_SESSION['order']['recipient']['address'])){ echo $_SESSION['order']['recipient']['zip']; }?></span>
                    </label>
                    </div>
                </div>
                <?php } ?>
                <?php if(isset($_SESSION['order']['delivery']) && isset($_SESSION['order']['delivery']['type']) && $_SESSION['order']['delivery']['type']!='h'){?>
                <div class="col-xs-12 _col-xs-100 checkout-confirmation-info-box">
                   
                    <?php if($_SESSION['order']['delivery']['type']=='p' && isset($_SESSION['order']['delivery']['deliverypersonalid']) && $_SESSION['order']['delivery']['deliverypersonalid']>0 ){?>
                     <h4 class="title"><?php echo $language["shopcart_checkout"][4]; //Način dostave ?> - <?php echo $language["shopcart_checkout"][5]; //Lično preuzimanje?></h4>
                        <?php if(count($deliveryPersonalInfoData)>0){ ?>
                        <!-- delivery personal info -->
                        <div class="my-label-holder">
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][1]; //Naziv ?>:</span> <span class="dinamic"><?php echo $deliveryPersonalInfoData['name'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][2]; //Adresa ?>:</span> <span class="dinamic"><?php echo $deliveryPersonalInfoData['address'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][3]; //Grad ?>:</span> <span class="dinamic"><?php echo $deliveryPersonalInfoData['cityname'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][4]; //Telefon ?>:</span> <span class="dinamic"><?php echo $deliveryPersonalInfoData['phone'];?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_personal_table"][5]; //Email ?>:</span> <span class="dinamic"><?php echo $deliveryPersonalInfoData['email'];?>&nbsp;</span>
                            </label>

                        </div>
                        <!-- delivery personal info END -->
                        <?php }?>
                    <?php }?>
                    <?php if($_SESSION['order']['delivery']['type']=='d' && isset($_SESSION['order']['delivery']['deliveryserviceid']) && $_SESSION['order']['delivery']['deliveryserviceid']>0 ){ ?>
                     <h4 class="title"><?php echo $language["shopcart_checkout"][4]; //Način dostave ?> - <?php echo $language["shopcart_checkout"][6]; //Kurirskom službom?></h4>
                    <?php if(count($deliveryServiceInfoData)>0){ ?>
                        <?php //var_dump($deliveryServiceInfoData);?>
                        <div class="my-label-holder">
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][1]; //Kurirska služba ?>:</span> <span class="dinamic"><?php echo $deliveryServiceInfoData['name']; ?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][2]; //Telefon ?>:</span> <span class="dinamic"><?php echo $deliveryServiceInfoData['phone']; ?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][3]; //Email ?>:</span> <span class="dinamic"><?php echo $deliveryServiceInfoData['email']; ?></span>
                            </label>
                            <label class="checkout-confirmation-my-label">
                                <span class="static"><?php echo $language["shopcart_checkout_delivery_service_table"][4]; //Web sajt ?>:</span> <span class="dinamic"><?php echo $deliveryServiceInfoData['website']; ?></span>
                            </label>
                        </div>
                    <?php }?>
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
    <div class="col-sm-2 col-xs-7 korpa korpa-proizvod col-seter">
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
            <p class="title"><?php  echo $language["shopcarttable"][4]; //VP Cena ?></p>

        </div>
        
        <div class="col-sm-2 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>

        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT TOTAL REBATE -->
        <!-- <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  //echo $language["shopcarttable"][7]; //Ukupni popust ?></p>

        </div> -->
        <!-- PRODUCT TOTAL REBATE END-->
        <!-- PRODUCT PRICE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][9]; //VP Cena sa popustom?></p>

        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>

        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
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
        <div class="col-sm-3 col-xs-7 korpa korpa-proizvod col-seter">
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
            <p class="title"><?php  echo $language["shopcarttable"][4]; //VP Cena ?></p>
        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>
        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT PRICE WITH REBATE-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][9]; //VP Cena sa popustom?></p>
        </div>
        <!-- PRODUCT PRICE WITH REBATE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>
        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
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
    <?php foreach ($shopcart as $key => $cartprod) { ?>
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
                    <div class="col-sm-2 col-xs-7 korpa korpa-proizvod col-seter">
                        
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
                        
                        <span><?php echo number_format($cartprod['price'] , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT QUANTITY REBATE -->
                    
                    <div class="col-sm-2 col-xs-4 korpa korpa-popust col-seter">
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
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter">
                        <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100)) , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE WITH REBATE END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
                        <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT VAT-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
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
                    <div class="col-sm-3 col-xs-7 korpa korpa-proizvod col-seter">
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
                        <span><?php echo number_format($cartprod['price'] , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT REBATE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-popust col-seter">
                        <span><?php echo $item_rebate; ?>%</span>
                    </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT PRICE WITH REBATE-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter">
                        <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100)) , 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE WITH REBATE END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
                        <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT VAT-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
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
                        <div class=" col-sm-3 col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][4]; //VP Cena?></p>
                            <span><?php echo number_format($cartprod['price'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT QUANTITY REBATE -->
                        <div class=" col-sm-2 col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][5]; //Količinski popust?></p>
                            <span><?php if(!$zero_rebate){ echo $quantityrebate." %"; } else { echo '0 %'; }?></span>
                        </div>
                    <!-- PRODUCT QUANTITY REBATE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-sm-1 col-xs-3 korpa korpa-popust">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][6]; //Popust ?></p>
                            <span><?php if(!$zero_rebate){ echo $cartprod['rebate']." %"; } else { echo '0 %'; }?></span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-sm-3 col-xs-3 korpa korpa-popust">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][7]; //Ukupni popust ?></p>
                            <span><?php echo $item_rebate; ?>%</span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT PRICE -->
                        <div class=" col-sm-3 col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][9]; //VP Cena sa popustom?></p>
                            <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT TOTAL-->
                        <div class="col-sm-3 col-xs-3 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][10]; //Ukupno bez PDV-om?></p>
                            <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT VAT-->
                        <div class="col-sm-3 col-xs-3 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][12]; //PDV?></p>
                            <span><?php echo number_format($cartprod['tax'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT VAT END-->
                    <!-- PRODUCT TOTAL WITH VAT-->
                        <div class="col-sm-5 col-xs-3 korpa korpa-ukupno">
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
                        <div class=" col-xs-4 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][4]; //VP Cena ?></p>
                            <span><?php echo number_format($cartprod['price'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-xs-2 korpa korpa-popust">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][6]; //Popust ?></p>
                            <span><?php echo $item_rebate; ?>%</span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT PRICE WITH REBATE-->
                        <div class=" col-xs-4 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][9]; //VP Cena sa popustom?></p>
                            <span><?php echo number_format($cartprod['price'] * (1-($item_rebate/100)), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE WITH REBATE END-->
                    <!-- PRODUCT TOTAL-->
                        <div class="col-xs-4 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>
                            <span><?php echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL-->
                    <!-- PRODUCT VAT-->
                        <div class="col-xs-2 korpa korpa-ukupno">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][12]; //PDV?></p>
                            <span><?php echo number_format($cartprod['tax'], 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT VAT-->
                    <!-- PRODUCT TOTAL WITH VAT-->
                        <div class="col-xs-5 korpa korpa-ukupno">
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
                   
<!-- TABLE DATA SHOPCART REQUEST #####################################################################################################################################################################################################-->
            <?php foreach ($shopcart_request as $key => $cartprod) { ?>
            <?php if($quantity_rebate_on){ ?>
            <!-- TABLE ROW PRODUCTITEM -->

            <!-- KORPA VELIKA -->
                <div class="korpa-holder hidden-xs hidden-sm article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
                    <div class="col-sm-2 col-xs-7 korpa korpa-proizvod col-seter">
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
                   
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                        <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                    </div>
                    <div class="col-sm-8 col-xs-12 korpa korpa-ukupno col-seter">
                        <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>
                    </div>
                </div>
            <!-- .KORPA VELIKA -->
            <!-- KORPA MALA -->
                <div class="korpa-holder-xs visible-xs visible-sm article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
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
                    <div class=" col-xs-4 korpa korpa-kolicina cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                        <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                    </div>   
                    <div class=" col-xs-12 korpa korpa-ukupno ">
                            <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>
                    </div>
                </div>
            <!-- .KORPA MALA -->
        <!-- TABLE ROW PRODUCTITEM END-->
   
        <?php } else { ?>  
                    <!-- TABLE ROW PRODUCTITEM -->

            <!-- KORPA VELIKA -->
                <div class="korpa-holder hidden-xs hidden-sm article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
                    <div class="col-sm-3 col-xs-7 korpa korpa-proizvod col-seter">
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
                   
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                        <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                    </div>
                    <div class="col-sm-7 col-xs-12 korpa korpa-ukupno col-seter">
                        <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>
                    </div>
                </div>
            <!-- .KORPA VELIKA -->
            <!-- KORPA MALA -->
                <div class="korpa-holder-xs visible-xs visible-sm article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
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
                    <div class=" col-xs-4 korpa korpa-kolicina cms_productInputDecIncCont" prodid="<?php echo $cartprod['id'];?>" attr='<?php echo $cartprod['attr'];?>'>
                        <span class="checkout-confirmation-amount"><?php echo $cartprod['qty'].' '.$cartprod['unitname']; ?></span>
                    </div>   
                    <div class=" col-xs-12 korpa korpa-ukupno ">
                            <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>
                    </div>
                </div>
            <!-- .KORPA MALA -->
        <!-- TABLE ROW PRODUCTITEM END-->  
        <?php } ?>
        <?php } ?>
<!-- TABLE DATA SHOPCART REQUEST END #################################################################################################################################################################################################-->
        </div>
        <hr>
        <div class="row noMargin">
            <div class="col-sm-6 col-seter">
                <div class="left-cart-panel">
                    <div class="hidden-xs">
                        <?php include("app/controller/controller_orderHelpMenu.php")?>  
                    </div>
                </div>
                
            </div>
            <div class="col-sm-6 sve-korpa col-seter">
                <h4><p class="go-left"><?php echo $language["shopcart"][3]; //Ukupno?>:</p> <p class="go-right"><?php echo number_format($total, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br>
                <h4><p class="go-left"><?php echo $language["shopcart"][4]; //Popust?>:</p> <p class="go-right"><?php echo '-'.number_format(round($total_rebate, 2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br>
                <hr>
                <h4><p class="go-left"><?php echo $language["shopcart"][5]; //Ukupno sa popustom bez PDV-a?>:</p> <p class="go-right"><?php echo number_format(round($total,2)-round($total_rebate,2), 2, ",", "."); //echo number_format($total_price, 4, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br>
                <h4><p class="go-left"><?php echo $language["shopcart"][6]; //PDV?>:</p> <p class="go-right"><?php echo '+'.number_format(round($total_tax,2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                <br>
                <?php $delivery_cost=0; 
                    if(number_format(round($total,2)-round($total_rebate,2)+round($total_tax,2), 2, ",", ".")>$user_conf["free_delivery_from"]){
                        $delivery_cost=0;
                    } else {
                        $delivery_cost= $user_conf["delivery_cost"][1];
                    }
                    if($delivery_cost>0){?>
                        <h4><p class="go-left"><?php echo $language["shopcart"][8]; //Troškovi dostave ?>:</p> <p class="go-right"> <?php $delivery_cost; ?></p></h4>
                    <?php } ?>
                        <hr>
                        
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
                            <h4><p class="go-left total-price-cart"><?php echo $language["shopcart"][7]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right total-price-cart"><?php echo number_format(round($total,2)-round($total_rebate,2)+round($total_tax,2)-$_SESSION['voucher']['value'], 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p>
                            </h4>
                        <!-- HAS VOUCHER SECTION END-->
                        <?php  } else { ?>
                        <!-- NO VOUCHER SECTION -->
                            <h4><p class="go-left total-price-cart"><?php echo $language["shopcart"][7]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right total-price-cart"><?php echo number_format(round($total,2)-round($total_rebate,2)+round($total_tax,2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p>
                            </h4>
                        <!-- NO VOUCHER SECTION -->
                        <?php  } ?>
                    <!-- TOTAL WITH VAT SECTION END-->
                        <br>
                    <!-- COMMENT -->
                        <div class="checkout-confirmation-amount-comment-box clearfix">
                            <h4><?php echo $language["shopcart"][2]; //KOMENTAR - Dodatne napomene u vezi sa narudžbinom ?></h4>
                            <p><?php if(isset($_SESSION['order']['comment']) && strlen($_SESSION['order']['comment'])>0) { echo $_SESSION['order']['comment']; } else { echo 'Nema napomena u vezi sa porudžbinom.';} ?></p>
                        </div>
                    <!-- COMMENT END-->
                        <br>
                    <!-- MINIMAL ORDER & FREE DELIVERY INFO SECTION--> 
                        <h4 class="aditi"><?php echo $language["shopcart"][14]; //Minimalni iznos narudžbine je ?> <?php echo $user_conf["minimal_order_limit"][1];?> <?php echo $language["moneta"][1]; ?></h4>
                        <?php if($user_conf["free_delivery_from"][1]>0){ ?>
                        <h4 class="aditi"><?php echo $language["shopcart"][15]; //Za iznose narudžbine preko ?> <?php echo $user_conf["free_delivery_from"][1];?> <?php echo $language["moneta"][1]; ?> - <span style="color:red;"><?php echo $language["shopcart"][16]; //BESPLATNA DOSTAVA. ?></span>
                        </h4>
                        <?php } ?>
                    <!-- MINIMAL ORDER & FREE DELIVERY INFO SECTION END--> 
                         <br>
                    <!-- FINISH OR CONTINUE ORDER -->
                            <a href="shop" class="sa-button  -rounded -success _half-width"><?php echo $language["shopcart"][12]; //Nastavi kupovinu ?></a>
                        <?php if(($total_price_pdv+$delivery_cost)>=$user_conf["minimal_order_limit"][1]  || ((!isset($_SESSION['shopcart']) || count($_SESSION['shopcart'])==0) && (isset($_SESSION['shopcart_request']) || count($_SESSION['shopcart_request'])>0)) ) { ?>
                            <a  href="checkout_finished" class="sa-button  -rounded -success _half-width cms_order-to-reservationB2B fin-btn"><?php echo $language["shopcart"][13]; //Završi kupovinu  ?></a>
                        <?php } else { ?>
                            <a class="sa-button  -rounded -danger _half-width"><?php echo $language["shopcart"][14]; //Minimalni iznos narudžbine je ?> <?php echo $user_conf["minimal_order_limit"][1];?> <?php echo $language["moneta"][1]; ?></a>
                        <?php } ?>
                    <!-- FINISH OR CONTINUE ORDER END-->
                    <!-- INFO DESCRIPTION NOTE SECTION-->
                        <?php if($language["shopcartnote"][1]!='' && strlen($language["shopcartnote"][1])>0){ ?>
                            <br>
                            <small class="text-center"><?php echo $language["shopcartnote"][1]; //SHOPCHART NOTE ?></small>
                        <?php } ?>
                    <!-- INFO DESCRIPTION NOTE SECTION-->
                    <br>
                    <hr>
                    <!-- LOGIN REGISTER SECTION-->   
                    <?php if(!isset($_SESSION['loginstatus'])){ ?>    
                        <h4 class="aditi"><?php echo $language["shopcart"][18]; //Dodatne pogodnosti za registrovane kupce ?></h4>
                        <a href="register" class="sa-button  -rounded -primary _half-width"><?php echo$language["shopcart"][19]; //REGISTRUJTE SE ?></a>
                        <a class="sa-button  -rounded -primary _half-width" data-toggle="modal" data-target=".bs-example-modal-sm"><?php echo$language["shopcart"][20]; //PRIJAVITE SE ?></a>
                     <hr>
                    <?php } ?>
                    <!-- LOGIN REGISTER SECTION END--> 
                    </div>
            </div>
        </div> 
    </div>    
</section>