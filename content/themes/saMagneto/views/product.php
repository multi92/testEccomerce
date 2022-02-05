<?php $shopProductPriceVisible=false;?>

<?php if($_SESSION['shoptype']=='b2c'){
           if(     ($product->pricevisibility=='a') || 
                   (($product->pricevisibility=='c') && ($_SESSION['loginstatus'] == 'logged')) || 
                   (($product->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged')))
           {        
               $shopProductPriceVisible=true; 
           }    
        }
?>
<?php if($_SESSION['shoptype']=='b2b'){ 
           if(    ($product->pricevisibility=='a') || 
                   (($product->pricevisibility=='b') && ($_SESSION['loginstatus'] == 'logged')) || 
                   (($product->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged')))
           {
               $shopProductPriceVisible=true;
           }
         }
?> 



<div class="page-head">
    <ol class="breadcrumb">
        <li>
            <a href="<?php  echo HOME_PAGE ;?>">
                <span><?php echo $language["global"][3]; ?></span>
            </a>
        </li>
        <?php 
            $path = "";
            $cnt=0;
            $count=count($command);
            $productCategoryPath='';
            $productCategoryName='';
            foreach($command as $k=>$v){
                $cnt++;
                $path .= $v."/"; 
                if($cnt==$count){ ?>
                    <li class="active"><span><?php echo $product->name; ?></span></li>
                <?php } else { ?>
                    <?php if($cnt==$count-1){ $productCategoryPath=$path;$productCategoryName=ucfirst(rawurldecode($v)); }?>
                    <li><a href="<?php  echo $path ;?>"><span><?php echo ucfirst(rawurldecode($v)); ?></span></a></li>
                <?php }
                }
            ?>
    </ol>
</div>
<?php $attributedata=array();?>
<section class="product-page">
    <div class="container">
        <div class="content-page">
            <div class="row marginBottom30 _unmargin">
                <div class="col-md-12 col-seter">
                    <h2 class="product-head-name"><?php echo $product->name; ?></h2>
                    <small><strong><?php echo $language["product"][1]; //Šifra artikla:?> <?php echo $product->code; ?></strong></small>
                    <div class="main-rate">
                        <!--PRODUCT RATE AND SCORE-->
                        <!--<div class="go-left rate-p"></div>
                    <p class="go-left">(<span itemprop="ratingCount">12</span>)</p>
                    <p class="go-left" itemprop="ratingValue"><strong>Ocena:</strong> 4.7</p> -->
                        <!--PRODUCT RATE AND SCORE END -->
                    </div>
                </div>
            </div>
            <div class="row _unmargin">
                <div class="col-lg-9 col-md-10 col-sm-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-5 product-col-holder col-seter">
                            <div class="product-pic pos">
                                <!-- PRODUCT IMAGE -->
                                <!-- <div class="easyzoom easyzoom--overlay"> -->
                                    <a class="img-product-gallery" data-fancybox="gallery" href="<?php echo GlobalHelper::getImage('fajlovi/product/'.$product->pictures[0]['img'], 'big'); ?>">
                                        <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$product->pictures[0]['img'], 'big'); ?>" alt="<?php echo $product->name; ?>" class="img-responsive product-image" itemprop="image">
                           
                                    </a>
                                <!-- </div> -->
                                <!-- PRODUCT IMAGE END -->
                                <!-- ACTION -->
                                <?php if($product->actionrebate>0 && $product->pricevisible==1 && ($product->type=='r' || $product->type=='vpi-r') && $shopProductPriceVisible){ ?>
                                <img src="<?php echo $theme_conf["action"][$_SESSION["langid"]][1]; ?>" alt="
                                <?php echo $language["product"][34]; //Akcija ?>" class="img-responsive akcija3">
                                <span class="disc">- <?php echo floor($product->actionrebate);?>%</span>
                                <?php } ?>
                                <!-- ACTION END-->
                                <!-- <img src="views/theme/img/icons/garancija2god.png" alt="garancija" class="img-responsive garancija"> -->
                                <!-- EXTRA DETAILS -->
                                <div class="stiker-holder2">
                                    <?php if(isset($product->extradetail) && count($product->extradetail)>0) { ?>
                                    <?php   foreach($product->extradetail as $ve){ ?>
                                    <img src="<?php echo GlobalHelper::getImage($ve['image'], 'small');?>" alt="<?php echo $ve['name']; ?>" class="img-responsive">
                                    <?php   } ?>
                                    <?php } ?>
                                </div>
                                <!-- EXTRA DETAILS END -->
                            </div>
                            <!-- PRODUCT IMAGES -->
                            <div class="row ">
                                <div class="thumbnails">
                                    <?php  foreach ($product->pictures as $pic) { ?>
                                    <div class="col-md-3 col-sm-3 col-xs-4 col-seter thumb-div">
                                        <a href="<?php echo GlobalHelper::getImage('fajlovi/product/'.$pic['img'], 'big'); ?>" data-standard="<?php echo GlobalHelper::getImage('fajlovi/product/'.$pic['img'], 'big'); ?>">
                                            <div class="product-sec-pic dsn_thumb-prod-image-holder transition"><img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$pic['img'], 'big'); ?>" alt="" class="img-responsive dsn_thumb-prod-image" itemprop="image"></div>
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- PRODUCT IMAGES END -->
                            <!-- TWITTER TWEET BUTTON-->
                            <div class="social-share-holder">
                                <div class="contact-social-ul">
                                    <?php if($socialnet_conf["twitter_share"][1]==1){?>
                                    <span>
                                        <?php echo $socialnet_conf["twitter_share_btn"][1];?>
                                    </span>
                                    <?php } ?>
                                </div>
                            <!-- TWITTER TWEET BUTTON END-->
                            <!-- FACEBOOK LIKE SHARE -->
                            <div class="fb-share-button" data-href="<?php echo $_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];?>" data-layout="button_count">
                            </div>
                            <div class="fb-like" data-href="<?php echo $_SERVER['HTTP_REFERER'].$_SERVER['REQUEST_URI'];?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                            <!-- FACEBOOK LIKE SHARE END-->
                            </div>
                            
                            <!-- PRODUCT NONMANDATORY ATRIBUTES -->
                            <!-- |->COUNT NONMANDATORY ATRIBUTES -->
                            <?php   $c=0;
                            foreach($product->attrs AS $aval){
                                if($aval['mandatory']==0){
                                    $c++;
                                }
                            } 
                            ?>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-7 product-col-holder product col-seter" productid="<?php echo $product->id;    ?>">
                                <div class="product-info pos">
                                    <div class="top-info-holder clearfix">
                                        <h2><?php echo $product->name; ?></h2>
                                        <h4><?php echo $language["product"][1]; //Šifra artikla:?> <?php echo $product->code; ?></h4>
                                        <h4><?php echo $language["product"][33]; //Kategorija:?> <a href="<?php echo $productCategoryPath;?>"><?php echo $productCategoryName;?></a></h4>
                                     <!-- PRODUCT AMOUNT -->   
                                    <?php if($product->type=='r' || $product->type=='vpi-r'){ ?>
                                    <div class="stock-holder">
                                        <?php if($product->amount==0 || !$shopProductPriceVisible){ ?>
                                        <!-- <p class="stock stock-no" itemprop="availability" href="http://schema.org/OutOfStock"><i class="fa fa-times" aria-hidden="true"></i>
                                            <?php //echo $language["product"][2]; //Nije na stanju?>
                                        </p> -->
                                        <p class="stock stock-no" itemprop="availability" href="http://schema.org/OutOfStock" style="color:#f9ce09!Important; background-color: #2f343d; border-radius: 3px; padding: 0px 5px 0px 5px;"><i class="fa fa-phone-square" aria-hidden="true" style="color:#f9ce09; "></i>
                                            <?php echo $language["product"][35]; //Pozovite?>
                                        </p>
                                        <?php } else { ?>
                                        <p class="stock stock-yes" itemprop="availability" href="http://schema.org/InStock"><i class="fa fa-check" aria-hidden="true"></i>
                                            <?php echo $language["product"][3]; //Na stanju?>
                                        </p>
                                        <p class="stock stock-num hide" itemprop="availability"><strong><?php echo $language["product"][4]; //Stanje:?></strong>
                                            <?php echo $product->amount.' '.$product->unitname;?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                        <!-- PRODUCT AMOUNT END-->
                                        <!-- NON MANDATORY SPECIFICATION ATTR -->
                                    <br>
                                    <div class="product-spec-attr">                                        
                                        <ul class="list">
                                            <?php   
                                            $product_spec_attr='';
                                                $attrCount=1;
                                                foreach($product->attrs as $aval){
                                                if($attrCount<=$theme_conf["specificatioн_nonmandatory_attributes"][1]){
                                                    if($aval['mandatory']==0 && $aval['specification_flag']==1){
                                                        $attrvalCount=count($aval['value']);
														
                                                        if($attrvalCount>0){
															$attrstr=$aval['name'].": ";
                                                            $i=1;
                                                            foreach($aval['value'] as $adval){
                                                                if($i==$attrvalCount){
                                                                    $attrstr.=$adval['attr_val_name'];
                                                                }else{
                                                                    $attrstr.=$adval['attr_val_name'].",";
                                                                }
                                                                $i++;
                                                            } 
															$product_spec_attr.='<li class="items">'.$attrstr.'</li>';
                                                        }
                                                        
                                                        
                                                        $attrCount++;
                                                    }
                                                }

                                                } 
                                            ?>
                                            <?php echo $product_spec_attr; ?>
                                        </ul>
                                    </div>

                                    <!-- NON MANDATORY SPECIFICATION ATTR END -->
                                    </div>   
                                    <hr> 
                                    <!-- PRODUCT BREND -->
                                     <?php if(!is_null($product->brendid) && $product->brendid>0){?>
                                    <div class="product-brand">
                                         
                                        <!-- <img src="fajlovi/brendovi/amibo.jpg" alt="brend" class="img-responsive"> -->
                                       
                                                <?php if(!is_null($product->brendhasimage) && $product->brendhasimage>0){?>
                                                    <a class="" brendid="<?php echo $product->brendid; ?>">
                                                        <img src="<?php echo $product->brendimage; ?>" alt="<?php echo $product->brendname; ?>" class="img-responsive" itemprop="image">
                                                    </a>
                                            <?php } else { ?>
                                                <a class="" brendid="<?php echo $product->brendid; ?>">
                                                    <span alt="<?php echo $product->brendname; ?>"><?php echo $product->brendname; ?></span>
                                                </a>
                                            <?php } ?>
                                        
                                    </div>
                                    <?php } ?>
                                    <!-- PRODUCT BREND END -->
                                    
                                    <!-- PRODUCT MANDATORY ATRIBUTES -->
                                    <!-- |->COUNT MANDATORY ATRIBUTES -->
                                    <?php   $cm=0;
                                        foreach($product->attrs AS $aval){
                                            if($aval['mandatory']==1){
                                            $cm++;
                                            }
                                        } 
                                    ?>
                                    <!-- |->COUNT MANDATORY ATRIBUTES END -->

                                    <?php   if(isset($product->attrs) && count($product->attrs)>0 && $cm>0 && $product->type!='vp') { ?>
                                    <br>    
                                    <div class="product-attr">
                                        <?php $checkget = false; ?>
                                        <?php if(isset($_GET['at'])){ $checkget = true;} ?>
                                        <?php foreach($product->attrs AS $aval){ ?>
                                        <?php if($aval['mandatory']==1 && count($aval['value'])>0){ //CHECK MANDATORY?>
                                        <p>
                                            <?php echo $aval['name'];?> *</p>
                                        <?php $advalcnt=count($aval['value']); ?>
                                        <ul class="product-attr-ul cms_proDetAttrCont atributi" mandatory="1" attrid="<?php echo $aval['attrid']; ?>">
                                            <?php foreach($aval['value'] as $adval){ ?>
                                                <?php array_push($attributedata,array($aval['attrid'],$adval['attr_val_id']));?>
                                            <?php $check = "";
                                          $ch="";
                                          $show="";
                                          if($checkget){
                                            if(in_array($adval['attr_val_id'], $_GET['at'])){ $check = "selected";  $ch="checked"; $show="show";    $flag_collapsed=true; }
                                          }
                                    ?>
                                            <?php if($adval['mainimage']!=''){ ?>
                                            <a class="product-attr-triger">
                                        <li class="product-attr-li cms_proDetAttrItem <?php echo $check?>" <?php echo $ch; ?> style="background-image: url('<?php echo $adval['mainimage']; ?>')" attrvalid="<?php echo $adval['attr_val_id']; ?>">
                                            <i class="fa fa-check <?php echo $show; ?>" aria-hidden="true"></i>
                                        </li>
                                    </a>
                                            <?php }else if($adval['maincolor']!=''){ ?>
                                            <a class="product-attr-triger">
                                        <li class="product-attr-li cms_proDetAttrItem <?php echo $check?>" <?php echo $ch; ?> style="background-color: <?php echo $adval['maincolor']; ?>" attrvalid="<?php echo $adval['attr_val_id']; ?>">
                                            <i class="fa fa-check <?php echo $show; ?>" aria-hidden="true"></i>
                                        </li>
                                    </a>
                                            <?php }else { ?>
                                            <a class="product-attr-triger">
                                        <li class="product-attr-li cms_proDetAttrItem <?php echo $check?>" <?php echo $ch; ?>  attrvalid="<?php echo $adval['attr_val_id']; ?>">
                                        <?php echo $adval['attr_val_name']; ?>
                                            <i class="fa fa-check <?php echo $show; ?>" aria-hidden="true"></i>
                                        </li>
                                    </a>
                                            <?php } ?>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                    <!-- PRODUCT MANDATORY ATRIBUTES END-->

                                    <!-- PRODUCT PRICE -->
                                    <?php if($product->type=='r' || $product->type=='vpi-r'){ ?>
                                    <?php if($product->pricevisible==1 && $product->price>0){?>
                                    <div class="product-price">
                                    <!-- B2C PRICE -->
                                        <?php if(($_SESSION['shoptype']=='b2c') && $shopProductPriceVisible){?>
                                             <?php if($product->rebate>0){ ?>
                                             <p class="real-price">
                                                 <del>
                                                     <?php echo number_format(round($product->price*(1+($product->tax/100)),2),2);?>
                                                     <?php echo $language["moneta"][1];?></del>
                                             </p>
                                             <p class="discount-price" itemprop="price" content="<?php echo round($product->price*(1+($product->tax/100)),2)*(1-($product->rebate/100)); ?>">
                                                <span class="price-title"><?php echo $language["product"][12]; //Cena ?></span>
                                            <?php echo number_format(round($product->price*(1+($product->tax/100)),2)*(1-($product->rebate/100)),2); ?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1];?>"><?php echo $language["moneta"][1];?></span></p>
                                            <p class="unit-measure">(<?php echo $language["product"][24]; // Cena za ?> <span class="unit-value"><?php echo $product->unitstep;?> <?php echo $product->unitname;?></span>)</p>
                                            <p class="savings"><?php echo $language["product"][23]; // Ušteda ?>
                                                <?php echo number_format(round($product->price*(1+($product->tax/100)),2)*(($product->rebate/100)),2); ?>
                                                <?php echo $language["moneta"][1];?>
                                            </p>
                                            <?php } else { ?>
                                            <p class="discount-price" itemprop="price" content="<?php echo number_format(round($product->price*(1+($product->tax/100)),2),2);?>">
                                                <span class="price-title">Cena</span>
                                                <?php echo number_format(round($product->price*(1+($product->tax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1];?>"><?php echo $language["moneta"][1];?></span></p>
                                            <?php } ?>
                                        <?php } ?>
                                    <!-- B2C PRICE END-->
                                    <!-- B2B PRICE -->
                                        <?php if(($_SESSION['shoptype']=='b2b') && $shopProductPriceVisible){ ?>
                                        <?php if($user_conf["b2b_show_prices_with_vat"][1]==0){?>
                                             <?php if($product->rebate>0){ ?>
                                             <p class="real-price">
                                                 <del>
                                                     <?php echo $language["product"][25]; // VP cena ?> <?php echo number_format(round($product->price,2),2);?>
                                                     <?php echo $language["moneta"][1];?>        
                                                </del>
                                             </p>
                                             <p class="discount-price" itemprop="price" content="<?php echo round($product->price,2)*(1-($product->rebate/100)); ?>">
                                                <span class="price-title"><?php echo $language["product"][25]; // VP cena ?></span> <?php echo number_format(round($product->price,2)*(1-($product->rebate/100)),2); ?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1];?>"><?php echo $language["moneta"][1];?></span></p>
                                            <p class="unit-measure">(<?php echo $language["product"][24]; // Cena za ?> <span class="unit-value"><?php echo $product->unitstep;?> <?php echo $product->unitname;?></span>)</p>
                                            <p class="savings"><?php echo $language["product"][23]; // Ušteda ?>
                                                <?php echo number_format(round($product->price,2)*(($product->rebate/100)),2); ?>
                                                <?php echo $language["moneta"][1];?>
                                            </p>
                                            <?php } else { ?>
                                            <p class="discount-price" itemprop="price" content="<?php echo number_format(round($product->price,2),2);?>">
                                                <span class="price-title"><?php echo $language["product"][25]; // VP cena ?></span> <?php echo number_format(round($product->price,2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1];?>"><?php echo $language["moneta"][1];?></span></p>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if($product->rebate>0){ ?>
                                             <p class="real-price">
                                                 <del>
                                                     <?php echo $language["product"][25]; // VP cena ?> <?php echo number_format(round($product->price*(1+($product->tax/100)),2),2);?>
                                                     <?php echo $language["moneta"][1];?>        
                                                </del>
                                             </p>
                                             <p class="discount-price" itemprop="price" content="<?php echo round($product->price*(1+($product->tax/100)),2)*(1-($product->rebate/100)); ?>">
                                                <span class="price-title"><?php echo $language["product"][25]; // VP cena ?></span> <?php echo number_format(round($product->price*(1+($product->tax/100)),2)*(1-($product->rebate/100)),2); ?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1];?>"><?php echo $language["moneta"][1];?></span></p>
                                            <p class="unit-measure">(<?php echo $language["product"][24]; // Cena za ?> 
                                                <span class="unit-value"><?php echo $product->unitstep;?> <?php echo $product->unitname;?></span>)</p>
                                            <p class="savings"><?php echo $language["product"][23]; // Ušteda ?>
                                                <?php echo number_format(round($product->price*(1+($product->tax/100)),2)*(($product->rebate/100)),2); ?>
                                                <?php echo $language["moneta"][1];?>
                                            </p>
                                            <?php } else { ?>
                                            <p class="discount-price" itemprop="price" content="<?php echo number_format(round($product->price*(1+($product->tax/100)),2),2);?>">
                                                <span class="price-title"><?php echo $language["product"][25]; // VP cena ?></span> <?php echo number_format(round($product->price*(1+($product->tax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1];?>"><?php echo $language["moneta"][1];?></span></p>
                                            <?php } ?>

                                        <?php } ?>
                                        <?php } ?>
                                    <!-- B2B PRICE END-->
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if(!$shopProductPriceVisible && ($product->type=='r' || $product->type=='vpi-r')){?>
                                        <div class="product-price ">
                                        <p class="discount-price" itemprop="price" content="<?php echo $language["product"][36]; // Ulogujte se za cenu ?>" style="color:#FF4747;"><?php echo $language["product"][36]; // Ulogujte se za cenu ?></p>
                                        </div>
                                    <?php }?>
                                    <?php if(($product->type=='q' || $product->type=='vpi-q') && $shopProductPriceVisible){ ?>
                                    <div class="product-price ">
                                        <p class="discount-price" itemprop="price" content="Cena na upit" style="color:#f0ad4e;"><?php echo $language["product"][26]; // Cena na upit ?></p>
                                    </div>
                                    <?php } ?>
                                    <?php if(($product->type=='vp') && $shopProductPriceVisible){ ?>
                                    <div class="product-price ">
                                        <p class="discount-price" itemprop="price" content="Raspon cena" style="color:#05668D;"><?php echo $language["product"][27]; // Raspon cena ?></p>
                                    </div>
                                    <?php } ?>
                                    <!-- PRODUCT PRICE END-->
                                    <!-- QUANTITY REBATE -->
                                    <div class="product-disc">
                                        <?php if( ($user_conf["quantity_rebate"][1]==1 && $_SESSION['type']=='user') || 
                                               ($user_conf["quantity_rebate"][1]==2 && $_SESSION['type']=='partner') || 
                                               ($user_conf["quantity_rebate"][1]==2 && $_SESSION['type']=='commerc') || 
                                               ($user_conf["quantity_rebate"][1]==3)
                                        ){ ?>
                                        <?php if($product->type=='r' || $product->type=='vpi-r'){ ?>
                                        <?php if(isset($product->quantityrebate) && count($product->quantityrebate)>0) { ?>
                                        <table class="table table-bordered disc-product-table">
                                            <tr>
                                                <th><?php echo $language["product_quantity_rebate_table"][1]; // Količina ?> (<?php echo $product->unitname ;?>)</th>
                                                <th><?php echo $language["product_quantity_rebate_table"][2]; // Popust ?></th>
                                            </tr>
                                            <?php   foreach($product->quantityrebate as $qrve){ ?>
                                            <?php   $full_rebate=0;
                                              $max_rebate=0;
                                              if(isset($product->maxrebate) && $product->maxrebate>0 && $product->maxrebate!==NULL){
                                                  $max_rebate=$product->maxrebate;
                                              }
                                              $item_rebate=0;
                                              $item_rebate=($product->rebate+((100-$product->rebate)*($qrve["rebate"]/100)));
                                              
                                              if($item_rebate>=$max_rebate){
                                                  if($max_rebate>0){
                                                      $full_rebate=$max_rebate;
                                                  } else {
                                                      $full_rebate=$item_rebate;
                                                  }
                                              } else {
                                                  $full_rebate=$item_rebate;
                                              }
                                                /*<?php echo $qrve["rebate"];?> */
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $qrve["quantity"];?>+</td>
                                                <td>
                                                    <?php echo round($product->price*(1+($product->tax/100))*(1-($full_rebate/100)),2);?> RSD</td>
                                            </tr>
                                            <?php  } ?>
                                        </table>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                        <!-- QUANTITY REBATE END-->
                                    </div>
                                    <div class="bottom-info-holder clearfix">
                                        <div class="product-compare-wish">
                                        <!-- PRODUCT COMPARE -->
                                        <?php   $comparechk='';
                                        if(isset($_SESSION['compare'])){
                                            foreach($_SESSION['compare'] as $ckey => $cval){
                                                if($cval[0] == $product->id){
                                                    $comparechk='checked';
                                                    break;
                                                }
                                            }
                                        } 
                                        ?>
                                        <form class="uporediForm">
                                            <input type="checkbox" name="checkboxG1" id="checkboxUporedi<?php echo $product->id; ?>" class="css-checkbox uporedi_checkbox jq_compare" <?php echo $comparechk; ?> />
                                            <label for="checkboxUporedi<?php  echo $product->id; ?>" class="css-label upor" title="<?php echo $language["product"][29]; // Uporedi proizvod ?>">
                                                <?php // echo $language["productBoxLine"][3]; //Uporedi ?>
                                                <i class="material-icons icons">compare_arrows</i>
                                            </label>
                                        </form>
                                        <div class="wish-product-btn">
                                            <?php   $wishlistchk='';
                                                    if(isset($_SESSION['wishlist'])){
                                                        foreach($_SESSION['wishlist'] as $ckey => $cval){
                                                            if($cval[0] == $product->id){
                                                                $wishlistchk='-active';
                                                                break;
                                                            }
                                                        }
                                                    } 
                                            ?>
                                            <i class="cms_iWishList material-icons wish-icons cms_addToWishList <?php echo $wishlistchk;?>" title="<?php echo $language["product"][30]; // Dodaj listu želja ?>">favorite</i>
                                        </div>
                                        <div class="wish-product-btn" onclick="window.print();">
                                            <i class="cms_iWishList material-icons wish-icons " title="<?php echo $language["product"][31]; // Štampaj stranicu ?>">print</i>
                                        </div>

                                        <!-- PRODUCT COMPARE END-->
                                    </div>
                                    <!-- QUANTITY REBATE END -->
    
                    
                                    <!-- PRODUCT ADD 2 CHART -->

                                     <?php $shopTypeAddToShopCartClass='';?>
                                    <?php $shopTypeAddToShopCartRequestClass='';?>
                                    <?php if($_SESSION['shoptype']=='b2c'){?>
                                    <?php $shopTypeAddToShopCartClass='product_add_to_shopcart';?>
                                    <?php $shopTypeAddToShopCartRequestClass='product_add_to_shopcart_request';?>   
                                    <?php }?>
                                    <?php if($_SESSION['shoptype']=='b2b'){?>
                                    <?php $shopTypeAddToShopCartClass='product_add_to_shopcartB2B';?>
                                    <?php $shopTypeAddToShopCartRequestClass='product_add_to_shopcart_requestB2B';?>
                                    <?php }?>   

                                    <?php if($product->type=='r' || $product->type=='vpi-r'){ ?>
                                    <?php if(($product->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && !$sitetestmode && $product->pricevisible==1 && $product->price>0 && $shopProductPriceVisible){ ?>
                                    <div class="product-cart cms_productInputDecIncCont " langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $product->id;?>" attr='<?php echo json_encode($attributedata);?>'>
                                        <div>
                                           <button id="decValue" class="cms_productInputDecButton dec-value">-</button>
                                        <input type="number" class="product-input cms_productQtyInput" id="product_qty" name="product_qty" value="1" <?php //if($product->unitstep>0){ echo $product->unitstep; } else {echo '1';}?>
                                        min="1"
                                        <?php //if($product->unitstep>0){ echo $product->unitstep; } else {echo '1';}?>
                                        step="1"
                                        <?php //if($product->unitstep>0){ echo $product->unitstep; } else {echo '1';}?>
                                        max="
                                        <?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $product->amount-OrderingHelper::ProductQtyInCartCheck($product->id);} ?>"
                                        maxquantity="
                                        <?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $product->amount-OrderingHelper::ProductQtyInCartCheck($product->id);} ?>"
                                        >
                                        <button id="incValue" class="cms_productInputIncButton inc-value">+</button> 
                                        </div>
                                        


                                        <a class="sa-button -rounded <?php echo $shopTypeAddToShopCartClass; //IMPORTANT?> product"
                                     prodid="<?php echo $product->id; ?>"
                                     prodname="<?php echo $product->nametr; ?>"
                                     prodpic="<?php echo $product->pictures[0]['img']; ?>"
                                     prodprice="<?php echo $product->price;?>"
                                     prodtax="<?php echo $product->tax;?>"
                                     prodrebate="<?php echo $product->rebate;?>"
                                     attr='<?php echo json_encode($attributedata);?>'
                                     lang="<?php echo $_SESSION['langid']; ?>"
                                     langcode="<?php echo $_SESSION['langcode'];?>"
                                     unitname="<?php echo $product->unitname;?>"
                                     unitstep="<?php echo $product->unitstep;?>"
                                     ><?php echo $language["product"][28]; // Dodaj u korpu ?> </a>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                   <!--  </div> -->
                                    


                                    <?php if(($product->type=='q' || $product->type=='vpi-q') && $shopProductPriceVisible){ ?>
                                    <div class="product-cart cms_productInputDecIncCont" langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $product->id;?>" attr='<?php echo json_encode($attributedata);?>'>
                                        <div>
                                           <button id="decValue" class="cms_productInputDecButtonRequest dec-value">-</button>
                                            <input type="number" class="product-input cms_productQtyInputRequest" id="product_request_qty" name="product_request_qty" 
                                            value="1" <?php //if($product->unitstep>0){ echo $product->unitstep; } else {echo '1';}?>
                                            min="1"<?php //if($product->unitstep>0){ echo $product->unitstep; } else {echo '1';}?>
                                            step="1"<?php //if($product->unitstep>0){ echo $product->unitstep; } else {echo '1';}?>
                                        
                                            >
                                            <button id="incValue" class="cms_productInputIncButtonRequest inc-value">+</button> 
                                        </div>
                                        
                                        <a class="sa-button -rounded -warning <?php echo $shopTypeAddToShopCartRequestClass; //IMPORTANT?> product"
                                    prodid="<?php echo $product->id; ?>"
                                    prodname="<?php echo $product->nametr; ?>"
                                    prodpic="<?php echo $product->pictures[0]['img']; ?>"
                                    prodprice="<?php echo $product->price;?>"
                                    prodtax="<?php echo $product->tax;?>"
                                    prodrebate="<?php echo $product->rebate;?>"
                                    attr='<?php echo json_encode($attributedata);?>'
                                    lang="<?php echo $_SESSION['langid']; ?>"
                                    langcode="<?php echo $_SESSION['langcode'];?>"
                                    unitname="<?php echo $product->unitname;?>"
                                    unitstep="<?php echo $product->unitstep;?>"
                                    ><?php echo $language["product"][32]; // Na upit ?></a>
                                    </div>
                                    <?php } ?>
                                    <!-- PRODUCT ADD 2 CHART END -->
                                    <!-- RECOMMENDED PRICE -->
                                    <br>
                                    <?php if($shopProductPriceVisible){?>
                                    <div class="requ cms_recommendedPriceCont hide">
                                        <p class="text cms_recommendedPriceDefaultText"><?php echo $language["asking_price_default_text"][1]; ?></p>
                                        <div class="form ">
                                            <form class="cms_recommendedPriceForm">
                                                <input class="field -price cms_recommendedPrice" type="text" placeholder="<?php echo $language["asking_price_pltext"][1];?>" prodid="<?php echo $product->id; ?>">
                                                <input class="field cms_recommendedPriceEmail" type="email" placeholder="<?php echo $language["asking_price_email_pltext"][1];?>">
                                                <a class="myBtn cms_sendRecommendedPriceButton" >Pošalji</a>
                                            </form>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- RECOMMENDED PRICE END -->
                                </div>
                           </div>    
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-seter">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-description ">
                                        <p class="title after"><?php echo $language["product_details"][1]; // Opis ?></p>
                                        <?php if(isset($product->description) && $product->description != '') { ?>
                                        
                                            <?php echo html_entity_decode($product->description); ?>
                                        
                                        <?php } ?>
                                        <?php   
                                            $product_spec_attr='';
                                                $attrCount=1;
                                                foreach($product->attrs as $aval){
                                                if($attrCount<=$theme_conf["specificatioн_nonmandatory_attributes"][1]){
                                                    if($aval['mandatory']==0 && $aval['specification_flag']==1){
                                                        $attrvalCount=count($aval['value']);
                                                        
                                                        if($attrvalCount>0){
                                                            $attrstr=$aval['name'].": ";
                                                            $i=1;
                                                            foreach($aval['value'] as $adval){
                                                                if($i==$attrvalCount){
                                                                    $attrstr.=$adval['attr_val_name'];
                                                                }else{
                                                                    $attrstr.=$adval['attr_val_name'].",";
                                                                }
                                                                $i++;
                                                            } 
                                                            $product_spec_attr.='<li class="items">'.$attrstr.'</li>';
                                                        }
                                                        
                                                        
                                                        $attrCount++;
                                                    }
                                                }

                                                } 
                                            ?>
                                         <?php echo $product_spec_attr; ?>
                                    </div>
                                </div>
                                <?php if($product->type!='vp'){ ?>
                                <div class="col-md-12">
                                        <div class="product-info-tabs">
                                            <!-- Nav tabs -->
                                            <?php $act='active';?>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <?php if(isset($product->specification) && $product->specification != '') { ?>
                                                <li role="presentation" class="<?php echo $act;?>"><a href="#specification" aria-controls="home" role="tab" data-toggle="tab"><?php echo $language["product_details"][2]; // Specifikacija ?></a></li>
                                                <?php $act='';} ?>
                                                <?php if(isset($product->characteristics) && $product->characteristics != '') { ?>
                                                <li role="presentation" class="<?php echo $act;?>"><a href="#characteristics" aria-controls="home" role="tab" data-toggle="tab"><?php echo $language["product_details"][6]; // Karakteristike ?></a></li>
                                                <?php $act='';} ?>
                                                <?php if(isset($product->documents) && count($product->documents) > 0) { ?>
                                                <li role="presentation" class="<?php echo $act;?>"><a href="#docs" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $language["product_details"][3]; // Dokumenta ?></a></li>
                                                <?php $act='';} ?>
                                                <?php if(isset($product->videos) && count($product->videos) > 0) { ?>
                                                <li role="presentation" class="<?php echo $act;?>"><a href="#video_p" aria-controls="messages" role="tab" data-toggle="tab"><?php echo $language["product_details"][4]; // Video ?></a></li>
                                                <?php $act='';} ?>
                                            </ul>
                                            <!-- Tab panes -->
                                            <?php $act='active';?>
                                            <div class="tab-content">
                                                <?php if(isset($product->specification) && $product->specification != '') { ?>
                                                <div role="tabpanel" class="tab-pane <?php echo $act;?>" id="specification">
                                                    
                                                    <?php echo $product->specification; ?>
                                                    
                                                   
                                                    <?php 
                                                    $mandatory_specification_str='';
                                                    $nonmandatory_specification_str='';
                                                    foreach($product->attrs AS $aval){
                                                        if($aval['mandatory']==1){

                                                            $attrstr=$aval['name'].": ";
                                                            $attrvalCount=count($aval['value']);
                                                            if($attrvalCount>0){
                                                                $i=1;
                                                                foreach($aval['value'] as $adval){
                                                                    if($i==$attrvalCount){

                                                                        $attrstr.=$adval['attr_val_name'];

                                                                    }else{

                                                                        $attrstr.=$adval['attr_val_name'].",";

                                                                    }
                                                                 $i++;
                                                                } 

                                                            }
                                                        
                                                            $mandatory_specification_str.='<li class="items">'.$attrstr.'</li>';
                                                        
                                                        } else {

                                                            $attrstr=$aval['name'].": ";
                                                            $attrvalCount=count($aval['value']);
                                                            if($attrvalCount>0){
                                                                $i=1;
                                                                foreach($aval['value'] as $adval){
                                                                    if($i==$attrvalCount){
                                                                        $attrstr.=$adval['attr_val_name'];
                                                                    }else{
                                                                        $attrstr.=$adval['attr_val_name'].",";
                                                                    }
                                                                 $i++;
                                                                } 

                                                            }
                                                        
                                                            $nonmandatory_specification_str.='<li class="items">'.$attrstr.'</li>';

                                                        }
                                                    }

                                                    ?>
                                                <ul>
                                                    <?php echo $mandatory_specification_str;?>
                                                    <?php //echo $nonmandatory_specification_str;?>
                                                </ul>


                                                </div>
                                                <?php $act='';} ?>
                                                <?php if(isset($product->characteristics) && strlen($product->characteristics) > 0) { ?>
                                                    <div role="tabpanel" class="tab-pane <?php echo $act;?>" id="characteristics">
                                                    <br/>
                                                    <p><?php echo $product->characteristics; // Karakteristike proizvida?></p>
                                                    
                                                </div>
                                                <?php $act='';} ?>
                                                <?php if(isset($product->documents) && count($product->documents) > 0) { ?>
                                                <div role="tabpanel" class="tab-pane <?php echo $act;?>" id="docs">
                                                    <p><strong><?php echo $language["product_details"][5]; // Klikom na ikonicu ili... ?></strong></p>
                                                    <?php foreach($product->documents as $dkey=>$dval){ ?>
                                                    <p><a href="<?php echo $dval['content']; ?>" target="_blank"><img src="<?php echo $system_conf["theme_path"][1];?>img/icons/pdf.png" alt="<?php echo rawurldecode(basename($dval['content'])); ?>" class="img-responsive">&nbsp;<?php echo rawurldecode(basename($dval['content'])); ?></a></p>
                                                    <?php } ?>
                                                </div>
                                                <?php $act='';} ?>
                                                <?php if(isset($product->videos) && count($product->videos) > 0) { ?>
                                                <div role="tabpanel" class="tab-pane <?php echo $act;?>" id="video_p">
                                                    
                                                        <?php foreach ($product->videos as $val) { ?>
                                                        	<div class="p-video-holder embed-responsive embed-responsive-16by">
                                                        <iframe class="embed-responsive-item" width="100%" height="100%" src="<?php echo $val["content"]; ?>" frameborder="0" allowfullscreen></iframe>
                                                         </div>
                                                        <?php } ?>

                                                   
                                                </div>
                                                <?php $act='';} ?>
                                            </div>
                                        </div>
                                </div>
                                <?php }else{ ?>
                                <div class="col-md-12 ">
                                <div class="table-responsive grouped-table">
                                   <!--  <div class="product-description">
                                        <p class="title">Članovi grupnog proizvoda</p>
                                    
                                    </div> -->
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th><?php echo $language["groupedProductBoxLineTable"][1]; // Slika ?></th>
                                            <th><?php echo $language["groupedProductBoxLineTable"][2]; // Šifra ?></th>
                                            <th><?php echo $language["groupedProductBoxLineTable"][3]; // Artikal ?></th>
                                            <th><?php echo $language["groupedProductBoxLineTable"][4]; // Količina ?></th>
                                            <th><?php echo $language["groupedProductBoxLineTable"][5]; // Jed. mere ?></th>
                                            <th><?php echo $language["groupedProductBoxLineTable"][6]; // Cena ?></th>
                                            <th></th>
                                            <th></th>
                                            
                                        </tr>
                                        <?php if(isset($product->relations) && count($product->relations) > 0) { ?>

                                            <?php foreach($product->relations as $rkey=>$rval){ ?>
                                                <?php if($rval['id'] == 2){?>
                                                    <?php foreach($rval['prodata'][1] as $rpkey=>$val){ //var_dump($val->image);?>
                                                    
                                                        <?php include($system_conf["theme_path"][1]."views/includes/productbox/groupedProductBoxLine.php");?>
           
                                                    <?php }?>
                                                <?php } ?>
                                            <?php } ?>
                                         <?php } ?>
                                    </table>
                                    
                                </div>
                                </div>
                                <?php } ?>
                            
                             </div>
                        </div>
                        <!-- LAST SEEN PRODUCTS -->
                        <?php if(is_array($lastSeen[1]) && count($lastSeen[1]) > 0) { ?>
                        <div class="row noMargin">
                            <div class="col-md-12 col-xs-12">
                                <div class="small-product-head">
                                    <h4 class="after title"><?php echo $language["product"][21]; // posledenje gledano ?></h4>
                                </div>
                            </div>
                            <?php $itemCount=0; ?>
                            <?php foreach ($lastSeen[1] as $val) { ?>
                                <?php $itemCount++;?>
                                <?php if($itemCount<=$theme_conf["products_in_last_seen_section"][1]) {?>
                                    <div class="col-md-2 col-sm-3 col-xs-4 xsProduct-col col-seter">
                                        <?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <!-- LAST SEEN PRODUCTS END -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-12 col-seter">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- SHOP HELP LINKS -->
                            <div class="order-help-menu">
                                <?php include("app/controller/controller_orderHelpMenu.php")?>
                            </div>
                            <!-- SHOP HELP LINKS END -->
                            <div class="product-page-banners">
                                <?php include_once("app/controller/controller_banner_right.php");?>
                                
                            </div> 
                        </div>
                    </div>
                    <?php if(isset($product->simularprod[1]) && count($product->simularprod[1]) > 0) { ?>
                    <div class="row _unmargin">
                        <div class="similar-products">
                            <div class="col-md-12">
                                <div class="small-product-head">
                                    <h4 class="after title"><?php echo $language["product"][18]; // slicni proizvodi ?></h4>
                                </div>
                            </div>
                            <?php $itemCount=0; ?>
                            <?php foreach ($product->simularprod[1] as $val) { ?>
                                <?php $itemCount++;?>
                                <?php if($itemCount<=$theme_conf["products_in_similar_products_section"][1]) {?>
                                    <div class="col-lg-6 col-md-12 col-sm-3 col-xs-4 _col-xs-50 col-seter">
                                        <?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
                <!--
        <div class="row">
            <div class="col-md-12">
                <h4>Pitanja i odgovori</h4>
                
            </div>
            <div class="col-md-12">
                <a class="add-coment" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Dodajte komentar ili pitanje</a>
                <div class="collapse" id="collapseExample">
                    <div class="well">
                        <form action="" class="coment-form">
                            <label for="">Vaše ime</label><br>
                            <input type="text" class="coment-name"><br>
                            <label for="">Email</label><br>
                            <input type="text" class="coment-email"><br>
                            <label for="">Upišite komentar</label><br>
                            <textarea name="" id="" cols="100" rows="7"></textarea><br>
                            <a href="" class="btn myBtn coment-btn">Pošalji</a>
                            <p><small>SoftArt zadržava pravo izbora komentara koji će biti objavljeni. <br>
                            Komentare koji sadrže govor mržnje, psovke i uvrede ne objavljujemo.
                            </small></p>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <?php //include("views/includes/commentbox/commentBox.php");?>
                <?php //include("views/includes/commentbox/commentBox.php");?>
                <?php //include("views/includes/commentbox/commentBox.php");?>
                <?php //include("views/includes/commentbox/commentBox.php");?>
                <div class="more-com">
                  <a href="" class="btn myBtn more-com-btn"><i class="fa fa-angle-down" aria-hidden="true"></i> Prikaži više</a>  
                </div>
                
            </div>
        </div>-->
                <!-- SIMILAR PRODUCTS -->
           <!--      <?php // if(isset($product->simularprod[1]) && count($product->simularprod[1]) > 0) { ?>
                <div class="row noMargin">
                    <div class="col-md-12">
                        <div class="small-product-head">
                            <h4 class="after title">Slični proizvodi</h4>
                        </div>
                    </div>
                    <?php // foreach ($product->simularprod[1] as $val) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-4 xsProduct-col col-seter">
                        <?php // include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox.php");?>
                    </div>
                    <?php // } ?>
                </div>
                <?php // } ?> -->
                <!-- SIMILAR PRODUCTS END-->
            </div>
        </div>
</section>