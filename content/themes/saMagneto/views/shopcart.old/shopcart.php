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
            <p class="title"><?php  echo $language["shopcarttable"][8]; //Cena sa popustom?></p>

        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>

        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
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
            <p class="title"><?php  echo $language["shopcarttable"][3]; //Cena ?></p>
        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>
        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT PRICE WITH REBATE-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][8]; //Cena sa popustom?></p>
        </div>
        <!-- PRODUCT PRICE WITH REBATE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>
        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
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
                        <div class=" col-sm-3 col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][3]; //Cena?></p>
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
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][8]; //Cena sa popustom?></p>
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
                        <div class=" col-xs-4 korpa korpa-cena">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][3]; //Cena ?></p>
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
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][8]; //Cena sa popustom?></p>
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
                        <div class="col-xs-4 korpa korpa-ukupno">
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
        <div class="row noMargin">
            
            <div class="col-sm-6 col-seter">
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
				
                    if(floatval(round($total,2)-round($total_rebate,2)+round($total_tax,2)-((isset($_SESSION['voucher']['value']))? $_SESSION['voucher']['value']:0))>floatval($user_conf["free_delivery_from"][1])){
                        $delivery_cost=0;
                    } else {
                        $delivery_cost= $user_conf["delivery_cost"][1];
                    }
                    if($delivery_cost>0){?>
                        <h4><p class="go-left"><?php echo $language["shopcart"][8]; //Troškovi dostave ?>:</p> <p class="go-right"> + <?php echo number_format(round($delivery_cost,2), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                    <?php } ?>
						<div class="clearfix"></div>
                        <hr >
                        
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
                            <a href="checkout" class="sa-button  -rounded -success _half-width cms_order-to-checkout fin-btn"><?php echo $language["shopcart"][13]; //Završi kupovinu ?></a>
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
                    
                    <?php if(isset($_SESSION['loginstatus']) && ($_SESSION["email"]==$user_conf["offer_email"][1]) ){ ?>   
                    <hr>
                        <h4 class="aditi">Kreirajte brzu ponudu.</h4>
                        <a href="checkout_fast_offer" class="sa-button -rounded offer-button cms_order-to-checkout-offer">POSALJI PONUDU</a>
                    <hr>
                    <?php } ?>
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