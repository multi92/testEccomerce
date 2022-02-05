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

            <p class="title"><?php  echo $language["shopcarttable"][12]; //PDV stopa ?>%</p>

        </div>

        <!-- PRODUCT VAT END-->

        <!-- PRODUCT TOTAL WITH VAT-->

        <div class="col-sm-1 col-xs-4 korpa  col-seter">

            <p class="title"><?php  echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>



        </div>

        <!-- PRODUCT TOTAL WITH VAT-->

        <!-- PRODUCT REMOVE BUTTON-->

        <div class="col-sm-1 col-xs-4 korpa  col-seter">

            <p class="title"><?php  echo $language["shopcarttable"][13]; //Izbaci ?></p>



        </div>

        <!-- PRODUCT REMOVE BUTTON END-->

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

            <p class="title"><?php  echo $language["shopcarttable"][12]; //PDV stopa ?> %</p>

        </div>

        <!-- PRODUCT VAT END-->

         <!-- PRODUCT TOTAL WITH VAT-->

        <div class="col-sm-1 col-xs-4 korpa  col-seter">

            <p class="title"><?php  echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>



        </div>

        <!-- PRODUCT TOTAL WITH VAT-->

        <!-- PRODUCT REMOVE BUTTON-->

        <div class="col-sm-1 col-xs-4 korpa  col-seter">

            <p class="title"><?php  echo $language["shopcarttable"][13]; //Izbaci ?></p>

        </div>

        <!-- PRODUCT REMOVE BUTTON END-->

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

                        

                        <button id="decValue" class="cms_productInputDecButton">-</button>

                        <input type="number"  name="qty"  class="product-input num-check cms_productQtyInput"

                                min="1"

                                value="<?php echo $cartprod['qty'];?>"

                                step="1"

                                max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                        >

                        <button id="incValue" class="cms_productInputIncButton">+</button>

              

                        <a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

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

                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">

                        <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>

                    </div>

                    <!-- PRODUCT TOTAL END-->

                    <!-- PRODUCT REMOVE BUTTON-->

                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">

                        

                        <a role="button" class="sa-button -rounded -danger korpa-proizvod-izbaci cart_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php // //Izbaci ?></span></a>

                    </div>

                    <!-- PRODUCT REMOVE BUTTON END-->

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

                        <button id="decValue" class="cms_productInputDecButton">-</button>

                        <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                             min="1"

                                             value="<?php echo $cartprod['qty'];?>"

                                             step="1"

                                             max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                             maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                        >

                        <button id="incValue" class="cms_productInputIncButton">+</button>

                        <a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

                    </div>

                    <!-- PRODUCT QUANTITY END-->

                    <!-- PRODUCT PRICE -->

                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter">

                        <!-- <span><?php //echo number_format($cartprod['price'] , 2, ",", "."); ?></span> -->

                        <span><?php echo number_format($cartprod['price']*(1-($item_rebate/100)) *(1+($cartprod['tax']/100)) , 2, ",", "."); ?></span>

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

                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">

                        <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>

                    </div>

                    <!-- PRODUCT TOTAL VITH VAT END-->

                    <!-- PRODUCT REMOVE BUTTON-->

                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">

                        <a role="button" class="sa-button -rounded -danger korpa-proizvod-izbaci cart_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php // //Izbaci ?></span></a>

                    </div>

                    <!-- PRODUCT REMOVE BUTTON END-->

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

                            <button id="decValue" class="cms_productInputDecButton">-</button>

                            <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                                 min="1"

                                                 value="<?php echo $cartprod['qty'];?>"

                                                 step="1"

                                                 max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                                 maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                            >

                            <button id="incValue" class="cms_productInputIncButton">+</button>

                            <a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

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

                           <!--  <p class="small-cart-desc"><?php //echo $language["shopcarttable"][8]; //Cena sa popustom?></p>

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

                        <div class="col-sm-4 col-xs-3 korpa korpa-ukupno">

                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>

                            <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>

                        </div>

                    <!-- PRODUCT TOTAL WITH VAT END-->

                    <!-- PRODUCT REMOVE-->

                        <div class="col-sm-1 col-xs-12 korpa korpa-ukupno ">

                            <a class="sa-button -rounded -danger cart_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="remove-text"><?php echo $language["shopcarttable"][13]; //Izbaci ?></span></a>

                        </div>

                    <!-- PRODUCT REMOVE END-->

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

                            <button id="decValue" class="cms_productInputDecButton">-</button>

                            <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                                 min="1"

                                                 value="<?php echo $cartprod['qty'];?>"

                                                 step="1"

                                                 max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                                 maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                            >

                            <button id="incValue" class="cms_productInputIncButton">+</button>

                            <a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

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

                            <!-- <p class="small-cart-desc"><?php //echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>

                            <span><?php //echo number_format((round($cartprod['price']*$cartprod['qty'],2)-(round($cartprod['price']*$cartprod['qty']*($item_rebate/100),2))), 2, ",", "."); ?></span> -->

                        </div>

                    <!-- PRODUCT TOTAL-->

                    <!-- PRODUCT VAT-->

                        <div class="col-xs-2 korpa korpa-ukupno hide">

                            <!-- <p class="small-cart-desc"><?php //echo $language["shopcarttable"][12]; //PDV?></p>

                            <span><?php //echo number_format($cartprod['tax'], 2, ",", "."); ?></span> -->

                        </div>

                    <!-- PRODUCT VAT-->

                    <!-- PRODUCT TOTAL WITH VAT-->

                        <div class="col-xs-6 korpa korpa-ukupno">

                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][11]; //Ukupno sa PDV-om?></p>

                            <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>

                        </div>

                    <!-- PRODUCT TOTAL WITH VAT-->

                    <!-- PRODUCT REMOVE-->

                        <div class="col-xs-1 korpa korpa-ukupno">

                            <a class="sa-button -rounded -danger cart_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="remove-text"><?php echo $language["shopcarttable"][13]; //Izbaci ?></span></a>

                        </div>

                    <!-- PRODUCT REMOVE END-->

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

                        <button id="decValue" class="cms_productInputDecButton">-</button>

                        <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                             min="1"

                                             value="<?php echo $cartprod['qty'];?>"

                                             step="1"

                                             max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                             maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                        >

                        <button id="incValue" class="cms_productInputIncButton">+</button>

                        <a class="korpa-osvezi cart_request_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

                    </div>

                    <div class="col-sm-7 col-xs-12 korpa korpa-ukupno col-seter">

                        <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>

                    </div>

                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">

                        <a role="button" class="sa-button -rounded -danger cart_request_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php //echo $language["shopcarttable"][13]; //Izbaci ?></span></a>

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

                        <button id="decValue" class="cms_productInputDecButton">-</button>

                        <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                             min="1"

                                             value="<?php echo $cartprod['qty'];?>"

                                             step="1"

                                             max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                             maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                        >

                        <button id="incValue" class="cms_productInputIncButton">+</button>

                        <a class="korpa-osvezi cart_request_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

                    </div>   

                    <div class=" col-xs-10 korpa korpa-ukupno ">

                            <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>

                    </div>

                    <div class=" col-xs-2 korpa korpa-ukupno ">

                             <a class="sa-button -rounded -danger cart_request_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="remove-text"><?php echo $language["shopcarttable"][13]; //Izbaci ?></span> </a>

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

                        <button id="decValue" class="cms_productInputDecButton">-</button>

                        <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                             min="1"

                                             value="<?php echo $cartprod['qty'];?>"

                                             step="1"

                                             max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                             maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                        >

                        <button id="incValue" class="cms_productInputIncButton">+</button>

                        <a class="korpa-osvezi cart_request_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

                    </div>

                    <div class="col-sm-6 col-xs-12 korpa korpa-ukupno col-seter">

                        <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>

                    </div>

                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">

                        <a role="button" class="sa-button -rounded -danger cart_request_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php //echo $language["shopcarttable"][13]; //Izbaci ?></span></a>

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

                        <button id="decValue" class="cms_productInputDecButton">-</button>

                        <input type="number" name="qty" class="product-input num-check cms_productQtyInput"

                                             min="1"

                                             value="<?php echo $cartprod['qty'];?>"

                                             step="1"

                                             max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>" 

                                             maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $cartprod['amount'];} ?>"

                                >

                        <button id="incValue" class="cms_productInputIncButton">+</button>

                        <a class="korpa-osvezi cart_request_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][14]; //Osveži ?></a>

                    </div>   

                    <div class=" col-xs-10 korpa korpa-ukupno ">

                            <span class="warning-info"><?php echo $language["shopcarttable_request_note"][1]; //NAPOMENA:?></span>

                    </div>

                    <div class=" col-xs-2 korpa korpa-ukupno ">

                             <a class="sa-button -rounded -danger cart_request_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="remove-text"><?php echo $language["shopcarttable"][13]; //Izbaci ?></span> </a>

                    </div> 

                </div>

            <!-- .KORPA MALA -->

        <!-- TABLE ROW PRODUCTITEM END-->  

        <?php } ?>

        <?php } ?>

<!-- TABLE DATA SHOPCART REQUEST END #################################################################################################################################################################################################-->

        </div>

        <hr>

<!-- SHOPCART CHECKOUT CUSTOMER INFO SETION-->

<section>

    <div class="container cart-container">

        <div class="content-page">

            <div class="row noMargin">

            <form id="cms_order-customer-form" metod="POST" role="FORM">

                <div class="col-sm-12">

                    



                        <!-- CUSTOMER DELIVERY SHIPPING AND PAYMENT -->

                       

                        <div class="row">

                            <div class="checkout-form clearfix">

                                <div class="col-md-12">

                                    <h4 class="title"><?php echo $language["shopcart_checkout"][1]; //Podaci za dostavu i plaćanje?></h4>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][1]; //Ime ?>

                                        <input type="text" name="customerName" class="field" 

                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][1]; //Ime ?>" 

                                                           value="<?php if($logged){ if(isset($_SESSION['order']['customer']['name'])){ echo $_SESSION['order']['customer']['name']; } else { echo $_SESSION['ime'] ;}} else {if(isset($_SESSION['order']['customer']['name'])){ echo $_SESSION['order']['customer']['name']; }}?>" 

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][3]; //Prezime ?>

                                        <input type="text" name="customerLastName" class="field" 

                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][3]; //Prezime ?>" 

                                                           value="<?php if($logged){ if(isset($_SESSION['order']['customer']['lastname'])){ echo $_SESSION['order']['customer']['lastname']; } else { echo $_SESSION['prezime'] ;}} else {if(isset($_SESSION['order']['customer']['lastname'])){ echo $_SESSION['order']['customer']['lastname']; }}?>" 

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][5]; //Email ?>

                                        <input type="email" name="customerEmail" class="field" 

                                                            placeholder="<?php echo $language["shopcart_checkout_customer"][5]; //Email ?>" 

                                                            value="<?php if($logged){ if(isset($_SESSION['order']['customer']['email'])){ echo $_SESSION['order']['customer']['email']; } else { echo $_SESSION['email'] ;}} else {if(isset($_SESSION['order']['customer']['email'])){ echo $_SESSION['order']['customer']['email']; }}?>"  

                                                           

                                                            title="<?php echo $language["shopcart_checkout_customer"][7]; //Molimo vas unesite validnu Email adresu ?>"

                                                            

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][8]; //Broj telefona ?>

                                        <input type="text" name="customerPhone" class="field"

                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][8]; //Broj telefona ?>" 

                                                           value="<?php if($logged){ if(isset($_SESSION['order']['customer']['phone'])){ echo $_SESSION['order']['customer']['phone']; } else { echo $_SESSION['telefon'] ;}} else { if(isset($_SESSION['order']['customer']['phone'])){ echo $_SESSION['order']['customer']['phone']; } }?>"  

                                                          

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][10]; //Adresa ?>

                                        <input type="text" name="customerAddress" class="field"

                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][10]; //Adresa ?>" 

                                                           value="<?php if($logged){ if(isset($_SESSION['order']['customer']['address'])){ echo $_SESSION['order']['customer']['address']; } else { echo $_SESSION['adresa'] ;}} else { if(isset($_SESSION['order']['customer']['address'])){ echo $_SESSION['order']['customer']['address']; } }?>" 

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][12]; //Mesto ?>

                                        <input type="text" name="customerCity" class="field"

                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][12]; //Mesto ?>" 

                                                           value="<?php if($logged){ if(isset($_SESSION['order']['customer']['city'])){ echo $_SESSION['order']['customer']['city']; } else { echo $_SESSION['mesto'] ;}} else { if(isset($_SESSION['order']['customer']['city'])){ echo $_SESSION['order']['customer']['city']; } }?>" 

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][14]; //Postanski broj ?>

                                        <input type="text" name="customerZipCode" class="field"

                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][14]; //Postanski broj ?>" 

                                                           value="<?php if($logged){ if(isset($_SESSION['order']['customer']['zip'])){ echo $_SESSION['order']['customer']['zip']; } else { echo $_SESSION['postbr'] ;}} else { if(isset($_SESSION['order']['customer']['zip'])){ echo $_SESSION['order']['customer']['zip']; } }?>"

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_customer"][16]; //Način plaćanja ?>



                                        <label class="my-label payment-option jq_payment-option <?php if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='p'){ echo '-checked'; }?>" value="p"><i class="material-icons icons"><?php if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='p'){ echo 'check_box'; }else{ echo 'check_box_outline_blank'; }?></i><?php echo $language["shopcart_checkout_customer"][17]; //Pouzećem ?></label>

                                        

                                        <label class="my-label payment-option jq_payment-option <?php if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='u'){ echo '-checked'; }?>" value="u"><i class="material-icons icons"><?php if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='u'){ echo 'check_box'; }else{ echo 'check_box_outline_blank'; }?></i><?php echo $language["shopcart_checkout_customer"][18]; //Pouzećem ?></label>

                                        

                                        <!-- <label class="my-label payment-option jq_payment-option <?php //if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='k'){ echo '-checked'; }?>" value="k"><i class="material-icons icons"><?php //if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='k'){ echo 'check_box'; }else{ echo 'check_box_outline_blank'; }?></i><?php //echo $language["shopcart_checkout_customer"][19]; //Pouzećem ?></label> -->



















                                        <select class="field cms_customerPaymentMethod hide" name="customerPaymentMethod" 

                                                              

                                                              paymentType="<?php if(!isset($_SESSION['order']['paymenttype'])){ echo 'n'; } else { echo $_SESSION['order']['paymenttype']; }?>"

                                        >

                                            <?php if($_SESSION['shoptype'] == 'b2b'){ ?>

                                                <option value="v" <?php if(!isset($_SESSION['order']['paymenttype'])){ echo 'selected="selected"'; }?> ><?php echo $language["shopcart_checkout_customer"][21]; //Virman ?></option>

                                            <?php }else{ ?>

                                                <option value="n" <?php if(!isset($_SESSION['order']['paymenttype'])){ echo 'selected="selected"'; }?> >- - - -</option>

                                                <option value="p" <?php if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='p'){ echo 'selected="selected"'; }?> ><?php echo $language["shopcart_checkout_customer"][17]; //Pouzećem ?></option>

                                                <option value="u" <?php if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='u'){ echo 'selected="selected"'; }?>><?php echo $language["shopcart_checkout_customer"][18]; //Uplatnicom ?></option>

                                                <!-- <option value="k" <?php //if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype']=='k'){ echo 'selected="selected"'; }?>><?php //echo $language["shopcart_checkout_customer"][19]; //Karticom ?></option> -->

                                            <?php } ?>

                                        </select>

                                    </label>

                                </div>

                            

                            </div>       

                        </div>



                        <!-- CUSTOMER DELIVERY SHIPPING AND PAYMENT END -->



                        <!-- RECIPIENT TRIGGER CHECKBOX -->

                        <!-- RECIPIENT TRIGGER CHECK -->

                        <?php $checkRecipient='';?>

                        <?php if(isset($_SESSION['order']['recipient']) && count($_SESSION['order']['recipient'])>0){

                            foreach($_SESSION['order']['recipient'] as $rval){

                                $checkRecipient.=$rval;

                            }



                        }?>



                        <?php if(isset($_SESSION['order']['recipient']) && $checkRecipient!='' && strlen($checkRecipient)>0){ //  

                            $checked='-checked';

                            $ielement='check_box';

                            $blockElementShowHide='style="display:block;"';

                            $disabled='';



                        } else {

                            $checked='';

                            $ielement='check_box_outline_blank';

                            $blockElementShowHide='style="display:none;"';

                            $disabled='disabled="disabled"';

                        }

                        ?>

                        <hr>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="recipient-address">

                                    <label class="my-label dn_recipient-address-trigger <?php echo $checked; ?>">

                                        <i class="material-icons icons"><?php echo $ielement; ?></i>

                                            <?php echo $language["shopcart_checkout"][2]; //Koristi drugu adresu dostave?>

                                    </label>

                                </div>

                            </div>

                        </div>

                        <!-- RECIPIENT TRIGGER CHECKBOX END -->

                        

                        <!-- RECIPIENT SHIPPING -->

                        <hr>

                        <div class="row">

                            <div class="checkout-form -hidden clearfix" id="dn_checkout-form-recipient" <?php echo $blockElementShowHide;?> >

                                

                                <div class="col-md-12">

                                    <h4 class="title"><?php echo $language["shopcart_checkout"][3]; //Podaci za dostavu?></h4>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_recipient"][1]; //Ime ?>

                                        <input type="text" name="recipientName" class="field cms_recipient" <?php echo $disabled;?>

                                                           placeholder="<?php echo $language["shopcart_checkout_recipient"][1]; //Ime ?>" 

                                                           value="<?php if(isset($_SESSION['order']['recipient']['name'])){ echo $_SESSION['order']['recipient']['name']; }?>"  

                                                          

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_recipient"][3]; //Prezime ?>

                                        <input type="text" name="recipientLastName" class="field cms_recipient" <?php echo $disabled;?>

                                                           placeholder="<?php echo $language["shopcart_checkout_recipient"][3]; //Ime ?>" 

                                                           value="<?php if(isset($_SESSION['order']['recipient']['lastname'])){ echo $_SESSION['order']['recipient']['lastname']; }?>"  

                                                          

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_recipient"][5]; //Broj telefona ?>

                                        <input type="text" name="recipientPhone" class="field cms_recipient" <?php echo $disabled;?>

                                                           placeholder="<?php echo $language["shopcart_checkout_recipient"][5]; //Broj telefona ?>" 

                                                           value="<?php if(isset($_SESSION['order']['recipient']['phone'])){ echo $_SESSION['order']['recipient']['phone']; }?>"  

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_recipient"][7]; //Adresa ?>

                                        <input type="text" name="recipientAddress" class="field cms_recipient" <?php echo $disabled;?>

                                                           placeholder="<?php echo $language["shopcart_checkout_recipient"][7]; //Adresa ?>" 

                                                           value="<?php if(isset($_SESSION['order']['recipient']['address'])){ echo $_SESSION['order']['recipient']['address']; }?>"  

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_recipient"][9]; //Mesto ?>

                                        <input type="text" name="recipientCity" class="field cms_recipient" <?php echo $disabled;?>

                                                           placeholder="<?php echo $language["shopcart_checkout_recipient"][9]; //Mesto ?>" 

                                                           value="<?php if(isset($_SESSION['order']['recipient']['city'])){ echo $_SESSION['order']['recipient']['city']; }?>"  

                                                           

                                        >

                                    </label>

                                </div>

                                <div class="col-xs-6 _col-xs-100">

                                    <label class="my-label">

                                        <?php echo $language["shopcart_checkout_recipient"][11]; //Postanski broj ?>

                                        <input type="text" name="recipientZipCode" class="field cms_recipient" <?php echo $disabled;?>

                                                           placeholder="<?php echo $language["shopcart_checkout_recipient"][11]; //Postanski broj ?>" 

                                                           value="<?php if(isset($_SESSION['order']['recipient']['city'])){ echo $_SESSION['order']['recipient']['city']; }?>"  

                                                           

                                        >

                                    </label>

                                </div>

                                <hr>

                            </div>       

                        </div>

                        

                        <!-- RECIPIENT SHIPPING END -->

                        

                        <!-- DELIVERY METHOD -->

                        <?php $deliveryOnOffStatus=''?>

                        <?php $deliveryElementStatus=''?>

                        <?php $deliveryPesonalElement='';?>

                        <?php $deliveryPesonalElementCheckedClass='';?>

                        <?php $deliveryPesonalElementCheckedAttr='';?>

                        <?php $deliveryPesonalElementCheckedDisplayStyle='';?>

                        <?php $deliveryServiceElement='';?>

                        <?php $deliveryPesonalServiceCheckedClass='';?>

                        <?php $deliveryPesonalServiceCheckedAttr='';?>

                        <?php $deliveryPesonalServiceCheckedDisplayStyle='';?>

                        <?php if($user_conf["order_personal_pickup_on_off"][1]==0 && $user_conf["order_delivery_service_on_off"][1]==0 ){ 

                            $deliveryOnOffStatus='h'; 

                            $deliveryElementStatus='hide';



                            $deliveryPesonalElement='hide';

                            $deliveryPesonalElementCheckedClass='';

                            $deliveryPesonalElementCheckedAttr='';

                            $deliveryPesonalElementCheckedDisplayStyle='style="display:none;"';



                            $deliveryServiceElement='hide';

                            $deliveryPesonalServiceCheckedClass='';

                            $deliveryPesonalServiceCheckedAttr='';

                            $deliveryPesonalServiceCheckedDisplayStyle='style="display:none;"';

                        } else{ 

                            if($user_conf["order_personal_pickup_on_off"][1]==1 && $user_conf["order_delivery_service_on_off"][1]==0 && count($ShopData[1])>0){

                                $deliveryOnOffStatus='p';



                                $deliveryPesonalElement='';

                                $deliveryPesonalElementCheckedClass="-checked";

                                $deliveryPesonalElementCheckedAttr='checked="checked"';

                                $deliveryPesonalElementCheckedDisplayStyle='style="display:block;"';



                                $deliveryServiceElement='hide';

                                $deliveryPesonalServiceCheckedClass='';

                                $deliveryPesonalServiceCheckedAttr='';

                                $deliveryPesonalServiceCheckedDisplayStyle='style="display:none;"';

                            }

                            if($user_conf["order_personal_pickup_on_off"][1]==0 && $user_conf["order_delivery_service_on_off"][1]==1 && count($DeliveryService[1])>0 ){

                                $deliveryOnOffStatus='d';



                                $deliveryPesonalElement='hide';

                                $deliveryPesonalElementCheckedClass="";

                                $deliveryPesonalElementCheckedAttr='';

                                $deliveryPesonalElementCheckedDisplayStyle='style="display:none;"';



                                $deliveryServiceElement='';

                                $deliveryPesonalServiceCheckedClass='-checked';

                                $deliveryPesonalServiceCheckedAttr='checked="checked"';

                                $deliveryPesonalServiceCheckedDisplayStyle='style="display:block;"';

                            }

                        

                            if($user_conf["order_personal_pickup_on_off"][1]==1 && $user_conf["order_delivery_service_on_off"][1]==1  && count($ShopData[1])>0  && count($DeliveryService[1])>0 ){

                                if(isset($_SESSION['order']['delivery']['type'])){

                                    if($_SESSION['order']['delivery']['type']=='p'){

                                        $deliveryOnOffStatus='p';



                                        $deliveryPesonalElement='';

                                        $deliveryPesonalElementCheckedClass="-checked";

                                        $deliveryPesonalElementCheckedAttr='checked="checked"';

                                        $deliveryPesonalElementCheckedDisplayStyle='style="display:block;"';



                                        $deliveryServiceElement='';

                                        $deliveryPesonalServiceCheckedClass='';

                                        $deliveryPesonalServiceCheckedAttr='';

                                        $deliveryPesonalServiceCheckedDisplayStyle='style="display:none;"';

                                    }

                                    if($_SESSION['order']['delivery']['type']=='d'){

                                        $deliveryOnOffStatus='d';  



                                        $deliveryPesonalElement='';

                                        $deliveryPesonalElementCheckedClass="";

                                        $deliveryPesonalElementCheckedAttr='';

                                        $deliveryPesonalElementCheckedDisplayStyle='style="display:none;"';



                                        $deliveryServiceElement='';

                                        $deliveryPesonalServiceCheckedClass='-checked';

                                        $deliveryPesonalServiceCheckedAttr='checked="checked"';

                                        $deliveryPesonalServiceCheckedDisplayStyle='style="display:block;"';

                                    }

                                } else {

                                    $deliveryOnOffStatus='p';  



                                    $deliveryPesonalElement='';

                                    $deliveryPesonalElementCheckedClass="-checked";

                                    $deliveryPesonalElementCheckedAttr='checked="checked"';

                                    $deliveryPesonalElementCheckedDisplayStyle='style="display:block;"';



                                    $deliveryServiceElement='';

                                    $deliveryPesonalServiceCheckedClass='';

                                    $deliveryPesonalServiceCheckedAttr='';

                                    $deliveryPesonalServiceCheckedDisplayStyle='style="display:none;"';   

                                }

                            }

                        }?>

                        <div class="row">

                            <div class="checkout-form -delivery clearfix cms_delivery_metod <?php echo $deliveryElementStatus; ?>" deliverymetod="<?php echo $deliveryOnOffStatus; ?>" >

                                <div class="col-md-12">

                                    <h4 class="title"><?php echo $language["shopcart_checkout"][4]; //Način dostave ?></h4>

                                </div>

                                <div class="col-xs-6 <?php echo $deliveryPesonalElement; ?>">

                                    <label class="my-label">

                                        <input type="radio" name="delivery" value="p" class="cms_delivery_choise-trigger cms_delivery_personal <?php echo $deliveryPesonalElementCheckedClass; ?>" <?php echo $deliveryPesonalElementCheckedAttr; ?> >

                                        <?php echo $language["shopcart_checkout"][5]; //Lično preuzimanje ?>

                                    </label>

                                </div>

                                <div class="col-xs-6 <?php echo $deliveryServiceElement; ?>">

                                    <label class="my-label">

                                        <input type="radio" name="delivery" value="d" class="cms_delivery_choise-trigger cms_delivery_service <?php echo $deliveryPesonalServiceCheckedClass; ?>" <?php echo $deliveryPesonalServiceCheckedAttr; ?>>

                                        <?php echo $language["shopcart_checkout"][6]; //Kurirskom službom ?>

                                    </label>

                                </div>  

                                <div class="col-xs-12">

                                    <div class="cms_delivery_pickup_checkout-choise <?php echo $deliveryPesonalElement; ?>" <?php echo $deliveryPesonalElementCheckedDisplayStyle; ?> >

                                        <div class="table-responsive">

                                            <table class="table table-striped table-bordered checkout-delivery-table">

                                                <tr>

                                                    <th></th>

                                                    <th><?php echo $language["shopcart_checkout_delivery_personal_table"][1]; //Naziv ?></th>

                                                    <th><?php echo $language["shopcart_checkout_delivery_personal_table"][2]; //Adresa ?></th>

                                                    <th><?php echo $language["shopcart_checkout_delivery_personal_table"][3]; //Grad ?></th>

                                                    <th><?php echo $language["shopcart_checkout_delivery_personal_table"][4]; //Telefon ?></th>

                                                    <th><?php echo $language["shopcart_checkout_delivery_personal_table"][5]; //Email ?></th>

                                                </tr>

                                                <?php if($user_conf["order_delivery_service_on_off"][1]==1){?>

                                                <?php foreach($ShopData[1] as $sval) { ?>

                                                <tr>

                                                    <td>

                                                        <input type="radio" name="deliveryPersonal" class="cms_delivery_personal_input" 

                                                                            deliveryserviceid="<?php echo $sval->id;?>" 

                                                                            value="<?php echo $sval->id;?>" 

                                                                            <?php if(isset($_SESSION['order']['delivery']['deliverypersonalid']) && $sval->id==$_SESSION['order']['delivery']['deliverypersonalid'] 

                                                                                       && isset($_SESSION['order']['delivery']['type']) && $_SESSION['order']['delivery']['type'] == 'p'){ 

                                                                                        echo ' checked="checked" '; 

                                                                            }?>

                                                        >

                                                    </td>

                                                    <td><strong><?php echo $sval->name; ?></strong></td>

                                                    <td><?php echo $sval->address; ?></td>

                                                    <td><?php echo $sval->cityname; ?></td>

                                                    <td><?php echo $sval->phone; ?></td>

                                                    <td><?php echo $sval->email; ?></td>

                                                    

                                                </tr>

                                                <?php } ?>

                                            <?php } else { ?>

                                             <tr>

                                                <td>

                                                        <input type="radio" name="deliveryPersonal" class="cms_delivery_personal_input" 

                                                                            deliveryserviceid="0" 

                                                                            value="0"

                                                                            checked="checked"  

                                                        >

                                                    </td>

                                                <td><strong>---</strong></td>

                                                    <td>---</td>

                                                    <td>---</td>

                                                    <td>---</td>

                                                    <td>---</td>



                                            </tr>   

                                            <?php } ?>

                                            </table>

                                        </div>

                                    </div>

                                    <?php if($user_conf["order_delivery_service_on_off"][1]==1){?>

                                    <div class="cms_delivery_service_checkout-choise <?php echo $deliveryServiceElement; ?>" <?php echo $deliveryPesonalServiceCheckedDisplayStyle; ?> >

                                        <div class="table-responsive">

                                            <table class="table table-striped table-bordered checkout-delivery-table">

                                                <tr>

                                                        <th></th>

                                                        <th><?php echo $language["shopcart_checkout_delivery_service_table"][1]; //Kurirska služba ?></th>

                                                        <th><?php echo $language["shopcart_checkout_delivery_service_table"][2]; //Telefon ?></th>

                                                        <th><?php echo $language["shopcart_checkout_delivery_service_table"][3]; //Email ?></th>

                                                        <th><?php echo $language["shopcart_checkout_delivery_service_table"][4]; //Web sajt ?></th>

                                                </tr>

                                                <?php if($user_conf["order_delivery_service_on_off"][1]==1){?>

                                                <?php foreach($DeliveryService[1] as $dval) { ?>

                                                <tr>

                                                    <td>

                                                        <input type="radio" name="deliveryService" class="cms_delivery_service_input" 

                                                                            deliveryserviceid="<?php echo $dval->id;?>" 

                                                                            value="<?php echo $dval->id;?>"

                                                                            <?php if(isset($_SESSION['order']['delivery']['deliveryserviceid']) && $dval->id==$_SESSION['order']['delivery']['deliveryserviceid'] 

                                                                                       && isset($_SESSION['order']['delivery']['type']) && $_SESSION['order']['delivery']['type'] == 'd'){ 

                                                                                        echo ' checked="checked" '; 

                                                                            }?> 

                                                        >

                                                    </td>

                                                    <td><strong><?php echo $dval->name; ?></strong></td>

                                                    <td><?php echo $dval->phone; ?></td>

                                                    <td><?php echo $dval->email; ?></td>

                                                    <td><?php echo $dval->website; ?></td>

                                                    

                                                </tr>

                                                <?php } ?>

                                            <?php } else { ?>

                                            <tr>

                                                <td>

                                                        <input type="radio" name="deliveryService" class="cms_delivery_service_input" 

                                                                            deliveryserviceid="0" 

                                                                            value="0"

                                                                            checked="checked"  

                                                        >

                                                    </td>

                                                <td><strong>---</strong></td>

                                                    <td>---</td>

                                                    <td>---</td>

                                                    <td>---</td>



                                            </tr>

                                            <?php } ?>

                                            </table>

                                        </div>

                                    </div>

                                    <?php } ?>  

                                </div>  

                            </div>

                        </div>

                        <!-- DELIVERY METHOD END -->



                        



                       



                         

                </div>

            </form>

                

            </div>

        </div> 

    </div>        

</section>



























<!-- SHOPCART CHECKOUT CUSTOMER INFO SETION END-->

        <div class="row noMargin">

            

            <div class="col-sm-12 col-seter">

                <div class="left-cart-panel">

                    <?php if($theme_conf["voucher_system"][1]==1){?>

                    <h4 class="aditi"><?php echo $language["shopcart"][9]; //ONLINE VAUČER KOD  ?></h4>

                    <div class="cart-vaucher-holder">

                        <input type="text" class="cart-vaucher-input cms_couponInput" placeholder="<?php echo $language["shopcart"][10]; //Unesite kod vaučera  ?>" /><button class="sa-button -rounded -info cms_couponButton"><?php echo $language["shopcart"][11]; //UPOTREBITE KOD  ?></button>

                    </div>

                    <?php if(strlen($theme_conf["voucher_image"][1])>0){?>

                    <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["voucher_image"][1];?>" class="img-responsive hidden-xs"/>

                    <?php } ?>

                    <hr>

                    <?php } ?>

                    

                

                </div>

                

            </div>

            

            <div class="col-sm-12 sve-korpa col-seter">

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

				

                    if(floatval(round($total,2)-round($total_rebate,2)+round($total_tax,2)-((isset($_SESSION['voucher']['value']))? $_SESSION['voucher']['value']:0))>floatval($user_conf["free_delivery_from"][1])){

                        $delivery_cost=0;

                    } else {

                        $delivery_cost= $user_conf["delivery_cost"][1];

                    }

                    if($delivery_cost>0){?>

                        <h4><p class="go-left"><?php echo $language["shopcart"][8]; //Troškovi dostave ?>:</p> <p class="go-right"> + <?php echo number_format(round($delivery_cost,2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>

                    <?php } ?>

						<div  class="clearfix hide"></div>

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

                            <h4><p class="go-left"><?php echo $language["shopcart"][17]; //Iznos vaučera ?>:</p> <p class="go-right "><?php echo '-'.number_format($_SESSION['voucher']['value'], 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?> <a class="sa-button -danger -rounded cms_couponRemove ">X</a></p>

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

                        <br> <br>

                    <!-- COMMENT -->

                        <h4 class="go-left"><?php echo $language["shopcart"][2]; //KOMENTAR - Dodatne napomene u vezi sa narudžbinom ?></h4>

                        <textarea class="form-control cms_shopcartComment" col="50" rows="5" style="max-width: 100%; min-width:290px;"><?php if(isset($_SESSION['order']['comment'])) echo $_SESSION['order']['comment']; ?></textarea>

                    <!-- COMMENT END-->

                        <br>

                    <!-- ACCEPT TERMS -->

                        <div class="row">

                            <div class="col-md-12">

                                <div class="checkout-terms">

                                    <label class="my-label dn_accept-terms cms_accept-terms">

                                        <i class="material-icons icons">check_box_outline_blank</i>

                                       <?php echo $language["shopcart_checkout"][7]; // Pročitao/la sam i saglasan/na sam sa ?><a href="<?php echo $theme_conf["terms_and_conditions_link"][1]; ?>" target="_blank" class="links"><?php echo $language["shopcart_checkout"][8]; // uslovima kupovine. ?></a>

                                    </label>

                                </div> 

                            </div> 

                        </div>

                        <!-- ACCEPT TERMS END -->

                        <div class="row">

                                <div class="col-sm-12">

                                    <div class="captchaHolder">

                                                <span class="jq_captcha"><?php echo rand(1,10); ?> + <?php echo rand(1,10); ?>  </span> =

                                                <input type="text" class="form-control captcha-input jq_captcha-input" placeholder="Unesite zbir">                                  

                                        </div>

                                    <?php //if(isset($_SESSION['order']['paymenttype']) && $_SESSION['order']['paymenttype'] == 'k'){ ?>

                                        

                                        <!--<div class="g-recaptcha pull-left" data-sitekey="6LdFJrIZAAAAAI_EZli4k0Sd52AkErdp4oHbQu8w"></div>       -->

                                    <?php //} else { ?>

                                      <!--   <input class="hide g-recaptcha-response" value="p" /> -->

                                    <?php //} ?>  

                                </div>

                        </div>

                    <!-- MINIMAL ORDER & FREE DELIVERY INFO SECTION--> 

                        <h4 class="aditi"><?php echo $language["shopcart"][14]; //Minimalni iznos narudžbine je ?> <?php echo $user_conf["minimal_order_limit"][1];?> <?php echo $language["moneta"][1]; ?></h4>

                        <?php if($user_conf["free_delivery_from"][1]>0){ ?>

                        <h4 class="aditi"><?php echo $language["shopcart"][15]; //Za iznose narudžbine preko ?> <?php echo $user_conf["free_delivery_from"][1];?> <?php echo $language["moneta"][1]; ?> - <span style="color:red;"><?php echo $language["shopcart"][16]; //BESPLATNA DOSTAVA. ?></span>

                        </h4>



                        <?php } ?>

                    <!-- MINIMAL ORDER & FREE DELIVERY INFO SECTION END--> 

                         <br>

                    <!-- FINISH OR CONTINUE ORDER -->

                            <a href="shop" class="sa-button   -success _half-width jq_saveCustomerData"><?php echo $language["shopcart"][12]; //Nastavi kupovinu ?></a>

                        <?php if(($total_price_pdv+$delivery_cost)>=$user_conf["minimal_order_limit"][1]  || ((!isset($_SESSION['shopcart']) || count($_SESSION['shopcart'])==0) && (isset($_SESSION['shopcart_request']) || count($_SESSION['shopcart_request'])>0)) ) { ?>

                            <a  class="sa-button   -success _half-width cms_order-onestep-to-finish fin-btn" lang="<?php echo $_SESSION['langid'];?>" langcode="<?php echo $_SESSION['langcode'];?>" ><?php echo $language["shopcart"][13]; //Završi kupovinu ?></a>

                        <?php } else { ?>

                            <a class="sa-button   -danger _half-width"><?php echo $language["shopcart"][14]; //Minimalni iznos narudžbine je ?> <?php echo $user_conf["minimal_order_limit"][1];?> <?php echo $language["moneta"][1]; ?></a>

                        <?php } ?>

                    <!-- FINISH OR CONTINUE ORDER END-->

                    <!-- INFO DESCRIPTION NOTE SECTION-->

                        <?php if($language["shopcartnote"][1]!='' && strlen($language["shopcartnote"][1])>0){ ?>

                            <br>

                            <small class="text-center"><?php echo $language["shopcartnote"][1]; //SHOPCHART NOTE ?></small>

                        <?php } ?>

                    <!-- INFO DESCRIPTION NOTE SECTION-->

                    <br>

                    <?php if(isset($_SESSION['loginstatus']) && ($_SESSION["email"]==$user_conf["offer_email"][1]) ){ ?> 

                    <hr>

                        <h4 class="aditi">Kreirajte brzu ponudu.</h4>

                        <a href="checkout_fast_offer" class="sa-button -rounded offer-button cms_order-to-checkout-offer">POSALJI PONUDU</a>

                    <hr>

                    <?php } ?>

                   

                    </div>

            </div>

        </div> 

    </div>    

</section>