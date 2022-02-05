<div class="page-head">
    <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
                <span itemprop="name"><?php echo $language["global"][3]; ?></span>
              </a>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="korpa" itemprop="item">
                <span itemprop="name"><?php echo $language["shopcart"][1]; //Korpa ?></span>
              </a>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="order_address" itemprop="item">
                <span itemprop="name"><?php echo $language["order"][1]; //Adresa placanja ?></span>
              </a>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="order_address_delivery" itemprop="item">
                <span itemprop="name"><?php echo $language["order"][2]; //Adresa dostave ?></span>
              </a>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="order_payment" itemprop="item">
                <span itemprop="name"><?php echo $language["order"][3]; //Nacin placanja ?></span>
              </a>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="order_payment" itemprop="item">
                <span itemprop="name"><?php echo $language["order"][4]; //Nacin dostave ?></span>
              </a>
        </li>
        <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <span itemprop="name"><?php echo $language["order"][5]; //Pregled porudzbine ?></span>
        </li>
    </ol>
</div>
<section>
    <div class="container">
        <div class="content-page">
          <div class="row noMargin">
            <div class="col-md-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified order-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="order_address"  style="border-left: 1px solid #ccc;" >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">1</p> <?php echo $language["order"][1]; //Adresa placanja ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="order_address_delivery"  >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">2</p> <?php echo $language["order"][2]; //Adresa dostave ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="order_payment" >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">3</p> <?php echo $language["order"][3]; //Način plaćanja ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="order_delivery" >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">4</p> <?php echo $language["order"][4]; //Način dostave ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="#pregled" aria-controls="settings" role="tab" data-toggle="tab">
                                <p class="order-number" style="background:#f9ce09!important; color:#333!important;">5</p> <?php echo $language["order"][5]; //Pregled porudzbine ?> <i class="fa fa-arrow-circle-right"  style="color:#f9ce09;"aria-hidden="true"></i></a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <form id="order_poruci" method="post" action="">
                        <div class="tab-content order-tab-content">
                            <div role="tabpanel" class="tab-pane active" id="pregled">
                                <div class="row">
                                    <div class="korpa-heading hidden-xs">
                                        <div class="col-sm-4 text-center">
                                            <p>
                                                <?php echo $language["shopcarttable"][1]; //Proizvod ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <p>
                                                <?php echo $language["shopcarttable"][16]; //Cena ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <p>
                                                <?php echo $language["shopcarttable"][6]; //Popust ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <p>
                                                <?php echo $language["shopcarttable"][2]; //Količina ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <p>
                                                <?php echo $language["shopcarttable"][17]; //Ukupno ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php $total = 0; ?>
                                    <?php $total_rebate = 0; ?>
                                    <?php $total_price = 0; ?>
                                    <?php $total_tax = 0; ?>
                                    <?php $total_price_pdv = 0; ?>
                                    <?php foreach ($shopcart as $key => $cartprod) { ?>
                                    <!-- CALCULATE ITEM QUANTITY REBATE -->
                                    <?php $quantityrebate = 0; ?>
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
                                    <div class="korpa-holder hidden-xs" cart_position="<?php echo $cartprod['cartposition']; ?>">
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
                                                <br>
                                            </div>
                                            <div class="col-sm-2 col-xs-4 korpa korpa-cena col-seter">
                                                <span><?php echo number_format($cartprod['price'] * (1+$cartprod['tax']/100), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></span>
                                            </div>
                                            <div class="col-sm-2 col-xs-4 korpa korpa-popust col-seter">
                                                <span><?php echo $item_rebate; ?>%</span>
                                            </div>
                                            <div class="col-sm-2 col-xs-5 korpa korpa-kolicina col-seter text-center">
                                                <h3><?php echo $cartprod['qty'];?></h3>
                                            </div>
                                            <div class="col-sm-2 col-xs-4 korpa korpa-ukupno col-seter">
                                                <span><?php echo number_format($article_total_price_pdv, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></span>
                                            </div>
                                        </div>
                                        <!-- .KORPA VELIKA -->
                                        <!-- KORPA MALA -->
                                        <div class="korpa-holder-xs visible-xs" cart_position="<?php echo $cartprod['cartposition']; ?>">
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
                                                    <br>
                                                </div>
                                                <div class=" col-xs-4 korpa korpa-kolicina">
                                                    <h3 class="text-center"><?php echo $language["shopcarttable"][2]; //Količina ?>: <?php echo $cartprod['qty'];?></h3>
                                                </div>
                                                <div class=" col-xs-4 korpa korpa-cena">
                                                    <span><?php echo $language["shopcarttable"][16]; //Cena ?>: <?php echo number_format($cartprod['price'] * (1+$cartprod['tax']/100), 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></span>
                                                </div>
                                                <div class=" col-xs-4 korpa korpa-popust">
                                                    <span><?php echo $language["shopcarttable"][11]; //Popust ?>: <?php echo $item_rebate; ?>%</span>
                                                </div>
                                                <div class="col-xs-4 korpa korpa-ukupno">
                                                    <span><?php echo $language["shopcarttable"][17]; //Ukupno ?>: <?php echo number_format($article_total_price_pdv, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></span>
                                                </div>
                                            </div>
                                            <!-- .KORPA MALA -->
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <form action="">
                                                    <h4><?php echo $language["shopcarttable"][19]; //KOMENTAR - Dodatne napomene u vezi sa narudžbinom ?></h4>
                                                    <p>
                                                        <?php if(isset($_SESSION['shopcart_comment'])) echo $_SESSION['shopcart_comment']; ?>
                                                    </p>
                                                </form>
                                            </div>
                                            <div class="col-sm-6 col-md-ofset-6 sve-korpa">
                                                <h4><p class="go-left"><?php echo $language["shopcarttable"][17]; //Ukupno ?>:</p> <p class="go-right"><?php echo number_format($total_price_pdv, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                                                <br>
                                                <h4><p class="go-left"><?php echo $language["shopcarttable"][20]; //Ušteda ?>:</p> <p class="go-right"><?php echo number_format($total_rebate, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                                                <br>
                                                <?php   $delivery_cost=0; 
                      if(number_format($total_price_pdv, 2, ",", ".")>$user_conf["free_delivery_from"]){
                        $delivery_cost=0;
                      } else {
                        $delivery_cost= $user_conf["delivery_cost"][1];
                      }
                      if($delivery_cost>0){ //echo $delivery_cost; ?>
                                                <h4><p class="go-left"><?php echo $language["shopcarttable"][14]; //Troškovi dostave ?>:</p> <p class="go-right"> <?php $delivery_cost; ?>
                      <?php
                      }
                  ?>
                                    <br>
                                    <h4><p class="go-left total-price-cart"><?php echo $language["shopcarttable"][21]; //Ukupno za plaćanje sa PDV-om ?>:</p> <p class="go-right total-price-cart"><?php echo number_format($total_price_pdv+$delivery_cost, 2, ",", "."); ?> <?php echo $language["moneta"][1]; ?></p></h4>
                                                <button type="submit" class="btn myBtn sve-btn">
                                                    <?php echo $language["shopcarttable"][32]; //Prosledi porudžbinu ?></button>
                                                <br>
                                                <small class="text-center"><?php echo $language["shopcarttable"][25]; //Sve cene su sa uračunatim PDV-om, nema dodatnih skrivenih troškova. Klikom na dugme, prihvatate ?> <a href="" style="color:red;"><?php echo $language["shopcarttable"][26]; //Uslove kupovine ?></a></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>  
        </div>
        
    </div>
</section>