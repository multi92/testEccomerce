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
<div class="korpa-holder hidden-xs korpa-heading">
    <!-- QUANTITY REBATE ON -->
    <!-- PRODUCT INFO -->
    <div class="col-sm-4 col-xs-7 korpa korpa-proizvod col-seter">
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
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT QUANTITY REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][5]; //Količinski popust ?></p>

        </div>
        <!-- PRODUCT QUANTITY REBATE END-->
        <!-- PRODUCT REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>

        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT TOTAL REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][7]; //Ukupni popust ?></p>

        </div>
        <!-- PRODUCT TOTAL REBATE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][10]; //Ukupno bez PDV-a?></p>

        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][12]; //Ukupno bez PDV-a?></p>

        </div>
        <!-- PRODUCT VAT END-->
        <!-- PRODUCT TOTAL WITH VAT-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][11]; //Ukupno bez PDV-a?></p>

        </div>
        <!-- PRODUCT TOTAL WITH VAT END-->

        <!-- PRODUCT REMOVE BUTTON-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][13]; //Izbaci ?></p>

        </div>
        <!-- PRODUCT REMOVE BUTTON END-->
        <!-- QUANTITY REBATE ON END-->
    </div>
    <?php  } else { ?>
    <div class="korpa-holder hidden-xs korpa-heading">
    <!-- QUANTITY REBATE ON -->
    <!-- PRODUCT INFO -->
        <div class="col-sm-4 col-xs-7 korpa korpa-proizvod col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][1]; //Proizvod ?></p>
        </div>
        <!-- PRODUCT INFO END-->
        <!-- PRODUCT QUANTITY -->
        <div class="col-sm-2 col-xs-5 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][2]; //Količina ?></p>
        </div>
        <!-- PRODUCT QUANTITY END-->
        <!-- PRODUCT PRICE -->
        <div class="col-sm-2 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][16]; //Cena ?></p>
        </div>
        <!-- PRODUCT PRICE END-->
        <!-- PRODUCT REBATE -->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][6]; //Popust ?></p>
        </div>
        <!-- PRODUCT REBATE END-->
        <!-- PRODUCT TOTAL-->
        <div class="col-sm-2 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][17]; //Ukupno ?></p>
        </div>
        <!-- PRODUCT TOTAL END-->
        <!-- PRODUCT REMOVE BUTTON-->
        <div class="col-sm-1 col-xs-4 korpa  col-seter">
            <p class="title"><?php  echo $language["shopcarttable"][9]; //Izbaci ?></p>
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
            <div class="korpa-holder hidden-xs article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
            <?php if($quantity_rebate_on){ ?>
            <!-- QUANTITY REBATE ON -->
                    <!-- PRODUCT INFO -->
                    <div class="col-sm-4 col-xs-7 korpa korpa-proizvod col-seter">
                        
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
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont">
                        
                        <button id="decValue" class="cms_productInputDecButton">-</button>
                        <input type="number"  name="qty"  class="product-input num-check cms_productQtyInput"
                                min="<?php echo $cartprod['unitstep'];?>"
                                value="<?php echo $cartprod['qty'];?>"
                                step="<?php echo $cartprod['unitstep'];?>"
                                max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $product->amount;} ?>" 
                                maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $product->amount;} ?>" 
                        >
                        <button id="incValue" class="cms_productInputIncButton">+</button>
                        <a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][18]; //Osveži ?></a>
                    </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-cena col-seter">
                        
                        <span><?php echo number_format($cartprod['price'] * (1+$cartprod['tax']/100), 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT QUANTITY REBATE -->
                    
                    <div class="col-sm-1 col-xs-4 korpa korpa-popust col-seter">
                        <span><?php if(!$zero_rebate){
                                    echo $quantityrebate." %";
                                } else {
                                    echo '0 %';
                                }?>   
                        </span>
                    </div>
                    
                    <!-- PRODUCT QUANTITY REBATE END-->
                    <!-- PRODUCT REBATE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-popust col-seter">
                        
                        <span><?php if(!$zero_rebate){
                                    echo $cartprod['rebate']." %";
                                } else {
                                    echo '0 %';
                                }?>
                        </span>
                    </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT TOTAL REBATE -->
                    <?php if($quantity_rebate_on){ ?>
                    <div class="col-sm-1 col-xs-4 korpa korpa-popust col-seter">
                        
                        <span><?php echo $item_rebate; ?>%</span>
                    </div>
                    <?php } ?>
                    <!-- PRODUCT TOTAL REBATE END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
                        <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT REMOVE BUTTON-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
                        
                        <a role="button" class="sa-button -rounded -danger korpa-proizvod-izbaci cart_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php echo $language["shopcarttable"][9]; //Izbaci ?></span></a>
                    </div>
                    <!-- PRODUCT REMOVE BUTTON END-->
                <!-- QUANTITY REBATE ON END-->
                <?php } else { ?>
                <!-- QUANTITY REBATE OFF -->
                     <!-- PRODUCT INFO -->
                    <div class="col-sm-4 col-xs-7 korpa korpa-proizvod col-seter">
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
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont">
                        <button id="decValue" class="cms_productInputDecButton">-</button>
                        <input type="number" min="1" name="qty" value="<?php echo $cartprod['qty'];?>" class="product-input num-check cms_productQtyInput">
                        <button id="incValue" class="cms_productInputIncButton">+</button>
                        <a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][18]; //Osveži ?></a>
                    </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                    <div class="col-sm-2 col-xs-4 korpa korpa-cena col-seter">
                        <span><?php echo number_format($cartprod['price'] * (1+$cartprod['tax']/100), 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT REBATE -->
                    <div class="col-sm-1 col-xs-4 korpa korpa-popust col-seter">
                        <span><?php echo $item_rebate; ?>%</span>
                    </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT TOTAL-->
                    <div class="col-sm-2 col-xs-4 korpa korpa-ukupno col-seter">
                        <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                    </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT REMOVE BUTTON-->
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
                        <a role="button" class="sa-button -rounded -danger korpa-proizvod-izbaci cart_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php echo $language["shopcarttable"][9]; //Izbaci ?></span></a>
                    </div>
                    <!-- PRODUCT REMOVE BUTTON END-->
                <!-- QUANTITY REBATE OFF END-->
                <?php } ?>    
                </div>
                <!-- .KORPA VELIKA -->
                <!-- KORPA MALA -->
                <div class="korpa-holder-xs visible-xs article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
                <?php if($quantity_rebate_on){ ?>
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
                        <div class=" col-xs-4 korpa korpa-kolicina cms_productInputDecIncCont">
                            <button id="decValue" class="cms_productInputDecButton">-</button>
                            <input type="number" min="1" name="qty" value="<?php echo $cartprod['qty'];?>" class="product-input num-check cms_productQtyInput">
                            <button id="incValue" class="cms_productInputIncButton">+</button>
                            <p><a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][18]; //Osveži ?></a></p>
                        </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                        <div class=" col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc">Cena</p>
                            <span><?php echo number_format($cartprod['price'] * (1+$cartprod['tax']/100), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT QUANTITY REBATE -->
                        <div class=" col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc">Količinski rabat</p>
                            <span><?php if(!$zero_rebate){ echo $quantityrebate." %"; } else { echo '0 %'; }?></span>
                        </div>
                    <!-- PRODUCT QUANTITY REBATE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-xs-2 korpa korpa-popust">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][11]; //Popust ?></p>
                            <span><?php if(!$zero_rebate){ echo $cartprod['rebate']." %"; } else { echo '0 %'; }?></span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-xs-3 korpa korpa-popust">
                            <p class="small-cart-desc">Ukupni popust</p>
                            <span><?php echo $item_rebate; ?>%</span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT TOTAL-->
                        <div class="col-xs-10 korpa korpa-ukupno">
                            <p class="small-cart-desc">Ukupno</p>
                            <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL END-->
                    <!-- PRODUCT REMOVE-->
                        <div class="col-xs-2 korpa korpa-ukupno">
                            <a class="sa-button -rounded -danger cart_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="remove-text"><?php echo $language["shopcarttable"][9]; //Izbaci ?></span></a>
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
                        <div class=" col-xs-4 korpa korpa-kolicina cms_productInputDecIncCont">
                            <button id="decValue" class="cms_productInputDecButton">-</button>
                            <input type="number" min="1" name="qty" value="<?php echo $cartprod['qty'];?>" class="product-input num-check cms_productQtyInput">
                            <button id="incValue" class="cms_productInputIncButton">+</button>
                            <p><a class="korpa-osvezi cart_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][18]; //Osveži ?></a></p>
                        </div>
                    <!-- PRODUCT QUANTITY END-->
                    <!-- PRODUCT PRICE -->
                        <div class=" col-xs-3 korpa korpa-cena">
                            <p class="small-cart-desc">Cena</p>
                            <span><?php echo number_format($cartprod['price'] * (1+$cartprod['tax']/100), 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT PRICE END-->
                    <!-- PRODUCT REBATE-->
                        <div class=" col-xs-3 korpa korpa-popust">
                            <p class="small-cart-desc"><?php echo $language["shopcarttable"][11]; //Popust ?></p>
                            <span><?php echo $item_rebate; ?>%</span>
                        </div>
                    <!-- PRODUCT REBATE END-->
                    <!-- PRODUCT TOTAL-->
                        <div class="col-xs-4 korpa korpa-ukupno">
                            <p class="small-cart-desc">Ukupno</p>
                            <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?></span>
                        </div>
                    <!-- PRODUCT TOTAL-->
                    <!-- PRODUCT REMOVE-->
                        <div class="col-xs-2 korpa korpa-ukupno">
                            <a class="sa-button -rounded -danger cart_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="remove-text"><?php echo $language["shopcarttable"][9]; //Izbaci ?></span></a>
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
                
            <!-- TABLE ROW PRODUCTITEM -->

            <!-- KORPA VELIKA -->
                <div class="korpa-holder hidden-xs article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
                    <div class="col-sm-4 col-xs-7 korpa korpa-proizvod col-seter">
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
                   
                    <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter cms_productInputDecIncCont">
                        <button id="decValue" class="cms_productInputDecButton">-</button>
                        <input type="number" min="1" name="qty" value="<?php echo $cartprod['qty'];?>" class="product-input num-check cms_productQtyInput">
                        <button id="incValue" class="cms_productInputIncButton">+</button>
                        <a class="korpa-osvezi cart_request_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][18]; //Osveži ?></a>
                    </div>
                    <div class="col-sm-5 col-xs-12 korpa korpa-ukupno col-seter">
                        <span class="warning-info">NAPOMENA: Ovaj proizvod je na upit i neće se tretirati kao naručen.</span>
                    </div>
                    <div class="col-sm-1 col-xs-4 korpa korpa-ukupno col-seter">
                        <a role="button" class="sa-button -rounded -danger cart_request_remove_article"><span><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff;"></i></span> <span class="remove-text"><?php echo $language["shopcarttable"][9]; //Izbaci ?></span></a>
                    </div>
                </div>
            <!-- .KORPA VELIKA -->
            <!-- KORPA MALA -->
                <div class="korpa-holder-xs visible-xs article_content" cart_position="<?php echo $cartprod['cartposition'] ?>">
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
                    <div class=" col-xs-4 korpa korpa-kolicina cms_productInputDecIncCont">
                        <button id="decValue" class="cms_productInputDecButton">-</button>
                        <input type="number" min="1" name="qty" value="<?php echo $cartprod['qty'];?>" class="product-input num-check cms_productQtyInput">
                        <button id="incValue" class="cms_productInputIncButton">+</button>
                        <p><a class="korpa-osvezi cart_request_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $language["shopcarttable"][18]; //Osveži ?></a></p>
                    </div>   
                    <div class=" col-xs-10 korpa korpa-ukupno ">
                            <span class="warning-info">NAPOMENA: Ovaj proizvod je na upit i neće se tretirati kao naručen.</span>
                    </div>
                    <div class=" col-xs-2 korpa korpa-ukupno ">
                             <a class="sa-button -rounded -danger cart_request_remove_article"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="remove-text"><?php echo $language["shopcarttable"][9]; //Izbaci ?></span> </a>
                    </div> 
                </div>
            <!-- .KORPA MALA -->
        <!-- TABLE ROW PRODUCTITEM END-->
        <?php } ?>
<!-- TABLE DATA SHOPCART REQUEST END #################################################################################################################################################################################################-->
        </div>
                <hr>
                <div class="row noMargin">
                    <div class="col-sm-6">
                        <form action="">
                            <h4 class="aditi"><?php echo $language["shopcarttable"][19]; //KOMENTAR - Dodatne napomene u vezi sa narudžbinom ?></h4>
                            <textarea class="form-control jq_shopcartComment" col="50" rows="7" style="max-width: 500px; min-width:290px;"><?php if(isset($_SESSION['shopcart_comment'])) echo $_SESSION['shopcart_comment']; ?></textarea>
                        </form>
                    </div>
                    <div class="col-sm-6 sve-korpa">
                        <h4><p class="go-left"><?php echo $language["shopcarttable"][17]; //Ukupno ?>:</p> <p class="go-right"><?php echo number_format($total_price_pdv, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4><br>
                        <h4><p class="go-left"><?php echo $language["shopcarttable"][20]; //Ušteda ?>:</p> <p class="go-right"><?php echo number_format($total_rebate, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4><br>
                        <?php $delivery_cost=0; 
                        if(number_format($total_price_pdv, 2, ",", ".")>$user_conf["free_delivery_from"]){
                            $delivery_cost=0;
                        } else {
                            $delivery_cost= $user_conf["delivery_cost"][1];
                        }
                        if($delivery_cost>0){
                            
                            //echo $delivery_cost;
                            ?>
                        <h4><p class="go-left"><?php echo $language["shopcarttable"][14]; //Troškovi dostave ?>:</p> <p class="go-right"> <?php $delivery_cost; ?>
                            <?php
                        }
                        ?>
                    </p>
                </h4>
                        <br>
                        <h4><p class="go-left total-price-cart"><?php echo $language["shopcarttable"][21]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right total-price-cart"><?php echo number_format($total_price_pdv+$delivery_cost, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                        <a href="pocetna" class="btn myBtn sve-btn add2cart cart-button korpa-button2 "></i><?php echo $language["shopcarttable"][22]; //Nastavi kupovinu ?></a>
                        <?php if(($total_price_pdv+$delivery_cost)>=$user_conf["minimal_order_limit"][1]) { ?>
                        <a href="checkout" class="btn myBtn sve-btn add2cart cart-button korpa-button2 jq_shopcartNextButton fin-btn"></i><?php echo $language["shopcarttable"][23]; //Završi kupovinu ?></a>
                        <?php } else { ?>
                        <a class="btn add2cart cart-button korpa-button2"></i><?php echo $language["shopcarttable"][24]; //Minimalni iznos narudžbine je ?> <?php echo $user_conf["minimal_order_limit"][1];?> <?php echo $language["moneta"][1]; ?></a>
                        <?php } ?>
                        <small class="text-center"><?php echo $language["shopcarttable"][25]; //Sve cene su sa uračunatim PDV-om, nema dodatnih skrivenih troškova. Klikom na dugme, prihvatate ?> <a href="" style="color:red;"><?php echo $language["shopcarttable"][26]; //Uslove kupovine ?></a></small>
                    </div>
                </div>
                <hr>
                <div class="row noMargin">
                    <div class="col-sm-6 col-xs-12">
                        <h4 class="aditi"><?php echo $language["shopcarttable"][24]; //Minimalni iznos narudžbine je ?> <?php echo $user_conf["minimal_order_limit"][1];?> <?php echo $language["moneta"][1]; ?></h4>
                        <h4 class="aditi"><?php echo $language["shopcarttable"][27]; //Za iznose narudžbine preko ?> <?php echo $user_conf["free_delivery_from"][1];?> <?php echo $language["moneta"][1]; ?> - <span style="color:red;"><?php echo $language["shopcarttable"][28]; //BESPLATNA DOSTAVA. ?></span></h4>
                    </div>
                    <div class="col-sm-3 col-xs-6 cart-col">
                        <?php include("app/controller/controller_orderHelpMenu.php")?>
                    </div>
                    <div class="col-sm-3 col-xs-6 cart-col">
                        <h4 class="aditi"><?php echo $language["shopcarttable"][29]; //Dodatne pogodnosti za registrovane kupce ?></h4>
                        <a href="register" class="btn myBtn cart-reg"><?php echo $language["shopcarttable"][30]; //REGISTRUJTE SE ?></a>
                        <a class="btn myBtn cart-pri" data-toggle="modal" data-target=".bs-example-modal-sm"><?php echo $language["shopcarttable"][31]; //PRIJAVITE SE ?></a>
                    </div>
                </div>
            </div> 
        </div>
        
</section>