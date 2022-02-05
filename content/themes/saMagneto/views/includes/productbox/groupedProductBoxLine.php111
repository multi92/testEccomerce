<!-- VIRTUAL PRODUCT ITEM CALCULATIONS--> 
                                        <?php 
                                               $vprice=0;
                                               $vtax=0;
                                               $vrebate=0;
                                               $vqtyrebate=0;  
                                             //var_dump($val);       
                                               if($val->visibleprice==1){  
                                                    $vprice=$val->price; 
                                                   $vtax=$val->tax;
                                                $vrebate=$val->rebate;
                                                }else{  
                                                    $vprice='0';
                                                    $vtax='0';
                                                    $vrebate='0';
                                                };
                                            ?>
                                            <!-- MANDATORY ATRIBUTE CHECK-->
                                            <?php    $havemandatoryattr=0;
                                                if($val->haveattr ){  
                                                   foreach($val->attr as $aval){  
                                                        if($aval["mandatory"]==1){ 
                                                         $havemandatoryattr++;
                                                     }
                                                  }  
                                             } 
                                            ?>
                                            <?php $shopProductPriceVisible=false;?>

                                            <?php if($_SESSION['shoptype']=='b2c'){
                                                         if(     ($val->pricevisibility=='a') || 
                                                                 (($val->pricevisibility=='c') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                 (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged')))
                                                         {        
                                                             $shopProductPriceVisible=true; 
                                                         }    
                                                      }
                                              ?>
                                              <?php if($_SESSION['shoptype']=='b2b'){ 
                                                         if(    ($val->pricevisibility=='a') || 
                                                                 (($val->pricevisibility=='b') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                 (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged')))
                                                         {
                                                             $shopProductPriceVisible=true;
                                                         }
                                                       }
                                              ?> 
                                            <!-- MANDATORY ATRIBUTE CHECK END-->
                                            <?php $attributedata=array();?>

                                        <!-- VIRTUAL PRODUCT ITEM CALCULATIONS END-->
<!-- VIRTUAL PRODUCT ITEM -->                               
                                        <tr class="product " itemscope itemtype="http://schema.org/Product" productid = "<?php echo $val->id; ?>">
                                            <td>
                                                <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'small'); ?>" alt="<?php echo $val->name; ?>" class="img-responsive trigerLarge">
                                                <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'small'); ?>" alt="<?php echo $val->name; ?>" class="img-responsive large-image">
                                                <?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
                                                    <span class="disc">- <?php echo floor($val->actionrebate);?>%</span>
                                                <?php } ?>
                                            </td>
                                            
                                            <td><b class="f-s14"><?php echo $val->code; ?></b></td>
                                            <td><a href="<?php echo $val->productlink; ?>"><b class="f-s14"><?php echo $val->name; ?></b></a>
                                               
                                                <div class="h-product-attr">
                                                <?php if($val->haveattr ){ ?>
                                                     <ul class="h-product-attr-ul filter-color-ul">
                                                         <?php foreach($val->attr as $aval){ ?>
                                                         <?php if($aval["mandatory"]==1 && $val->type!='vp'){ ?>
                                                             
                                                             <?php   $atrvalues='';
                                                                     $cnt=0;
                                                                     foreach($aval["value"] as $avalue){ 
                                                                         $cnt++;
                                                                         if($avalue["mainimage"]!=''){
                                                                             $atrvalues.='<div class="filter-color-li filter-color-sqr filter-color-div" style="background-image:'.$avalue["mainimage"].'"></div>';
                                                                         } else if($avalue["maincolor"]!=''){
                                                                             $atrvalues.='<div class="filter-color-li filter-color-sqr filter-color-div" style="background-color:'.$avalue["maincolor"].'"></div>';
                                                                         } else {
                                                                             if($cnt==1){
                                                                             $atrvalues.=$avalue["attr_val_name"];
                                                                             } else {
                                                                             $atrvalues.=', '.$avalue["attr_val_name"];  
                                                                             }
                                                                         }
                                                                         
                                                                     }
                                                             ?>
                                                             
                                                             <li class="h-product-attr-li"><strong style="float: left;margin-right: 10px;"><?php echo $aval["name"]; ?>:</strong> <?php echo $atrvalues; ?></li>
                                                         <?php } ?>
                                                         <?php } ?>
                                                     </ul>
                                                 <?php } ?>
                                                </div>
                                            </td>
                                            
                                            <td><?php if($val->amount==0){ ?>
                                                        <!-- <small class="availability" style="color:red;"  itemprop="availability"><span itemscope itemtype="http://schema.org/OutOfStock"><?php //echo 'Nema na stanju'; ?></span></small> -->
                                                        <small class="availability" style="color:#f9ce09!Important; background-color: #2f343d; border-radius: 3px; padding: 3px 5px 3px 5px;"  itemprop="availability">
                                                          <span itemscope itemtype="http://schema.org/OutOfStock"><?php echo $language["groupedProductBoxLineTable"][7]; ?></span></small>
                                                <?php } else { ?>
                                                        <small class="availability" style="color:green;"  itemprop="availability"><span itemscope itemtype="http://schema.org/OutOfStock"><?php echo $language["groupedProductBoxLineTable"][8]; ?></span></small>
                                                <?php }?> 
                                            </td>
                                            <td><?php echo $val->unitstep.' '.$val->unitname; ?></td>
                                            <!--PRODUCT PRICE  -->
                                            <td><?php if(($val->type=='q' || $val->type=='vpi-q') && $havemandatoryattr==0){  
                                                            //echo 'Cena na upit';  
                                                             echo '<p itemprop="lowPrice" style="color:#f0ad4e;" content="'.$language["productBox"][8].'">'.$language["productBox"][8].' </p>';////Cena na upit
                                                      } else if(($val->type=='q' || $val->type=='vpi-q') && $havemandatoryattr>0){  
                                                            //echo 'Cena na upit';  
                                                             echo '<p itemprop="lowPrice"  content="'.$language["productBox"][8].'">'.$language["productBox"][8].'</p>';////Cena na upit
                                                      } else if($val->type=='vp'){  
                                                             //echo 'Virtuelni proizvod';  
                                                            echo '<p itemprop="lowPrice"  content="'.$language["productBox"][12].'">'.$language["productBox"][12].'</p>';////Raspon cena
                                                      } else { ?>
                                                          <?php if($val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r') && $shopProductPriceVisible){ ?>
                                                          <!-- B2C PRICE -->
                                                              <?php if($_SESSION['shoptype']=='b2c'){?>
                                                                  <?php if($vrebate>0){   ?>
                                                                  <!-- B2C PRICE HAS REBATE-->
                                                                      <!-- OLD PRICE -->
                                                                      <small>
                                                                          <del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>">
                                                                              <?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> 
                                                                              <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span>
                                                                          </del>
                                                                      </small>
                                                                      <!-- OLD PRICE END-->
                                                                      <br>
                                                                      <!-- NEW PRICE -->
                                                                      <p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?>">
                                                                          <?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?> 
                                                                          <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span>
                                                                      </p>
                                                                      <!-- NEW PRICE END-->
                                                                  <!-- B2C PRICE HAS REBATE END-->
                                                                  <?php } else { ?>
                                                                  <!-- B2C PRICE NO REBATE-->
                                                                      <!-- OLD PRICE -->
                                                                      <small></small>
                                                                      <!-- OLD PRICE END-->
                                                                      <br>
                                                                      <!-- NEW PRICE -->
                                                                      <p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>">
                                                                          <?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> 
                                                                          <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span>
                                                                      </p>
                                                                      <!-- NEW PRICE END-->
                                                                  <!-- B2C PRICE NO REBATE END-->   
                                                                  <?php } ?>
                                                              <?php } ?>
                                                              <!-- B2C PRICE END-->
                                                              <!-- B2B PRICE -->
                                                              <?php if($_SESSION['shoptype']=='b2b'){?>
                                                              <?php if($user_conf["b2b_show_prices_with_vat"][1]==0){?>
                                                                  <?php if($vrebate>0){   ?>
                                                                      <small><del itemprop="highPrice"  content="<?php echo number_format(round($vprice,2),2);?>"><?php echo 'VP Cena '.number_format(round($vprice,2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></small>
                                                                        <br>
                                                                      <p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1-($vrebate/100)),2),2);?>"><?php echo 'VP Cena '.number_format(round($vprice*(1-($vrebate/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
                            
                                                                  <?php } else { ?>
                                                                      <small></small>
                                                                       <br>
                                                                 
                                                                        <p itemprop="lowPrice"  content="<?php echo number_format(round($vprice,2),2);?>"><?php echo 'VP Cena '.number_format(round($vprice,2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>    
                                                                  <?php } ?>
                                                              <?php } else {?>
                                                                  <?php if($vrebate>0){   ?>
                                                                      <small><del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo 'VP Cena '.number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></small>
                                                                        <br>
                                                                      <p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1-($vrebate/100))*(1+($vtax/100)),2),2);?>"><?php echo 'VP Cena '.number_format(round($vprice*(1-($vrebate/100))*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
                            
                                                                  <?php } else { ?>
                                                                      <small></small>
                                                                       <br>
                                                                 
                                                                        <p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo 'VP Cena '.number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>    
                                                                  <?php } ?>



                                                              <?php } ?>

                                                              <?php } ?>
                                                        <!-- B2B PRICE END-->
                                                    <?php } ?> 
                                                    <?php if($val->visibleprice==0 && ($val->type=='r' || $val->type=='vpi-r')){
                                                   
                                                        echo '<p itemprop="lowPrice"  content="'.$language["productBox"][13].'">'.$language["productBox"][13].'</p>';////Pozovite
                                                     } ?>
                                                <?php } ?>
                                            </td>
                                            <!--PRODUCT PRICE END-->
                                            <!--PRODUCT HELP  -->
                                            <td>
                                                    <div class="s-product-help">
                                                       <!-- WISHLIST -->
                                                       <?php   $wishlistchk='';
                                                                   if(isset($_SESSION['wishlist'])){
                                                                       foreach($_SESSION['wishlist'] as $ckey => $cval){
                                                                           if($cval[0] == $val->id){
                                                                               $wishlistchk='-active';
                                                                               break;
                                                                           }
                                                                       }
                                                                   } 
                                                           ?>
                                                    <?php if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged') {?>
                                                       <a class="cms_addToWishList">
                                                           <i class="cms_iWishList material-icons wish-icons <?php echo $wishlistchk;?>" title="<?php echo $language["productBox"][7];// Dodaj u listu zelja?>">favorite</i>
                                                       </a>
                                                    <?php } else { ?>
                                                       <a data-toggle="modal" data-target=".bs-example-modal-sm" >
                                                           <i class="cms_iWishList material-icons wish-icons <?php echo $wishlistchk;?>" title="<?php echo $language["productBox"][7];// Dodaj u listu zelja?>">favorite</i>
                                                       </a>
                                                    <?php } ?>
                                                       <!-- WISHLIST END -->
                                                       <!-- COMPARE -->
                                                       <form  class="uporediForm ">
                                                           <?php   $comparechk='';
                                                                   if(isset($_SESSION['compare'])){
                                                                       foreach($_SESSION['compare'] as $ckey => $cval){
                                                                           if($cval[0] == $val->id){
                                                                               $comparechk='checked';
                                                                               break;
                                                                           }
                                                                       }
                                                                   } 
                                                           ?>
                                                           <input type="checkbox" name="compare" id="checkboxUporedi<?php echo $val->id; ?>" class="css-checkbox uporedi_checkbox jq_compare" <?php echo $comparechk; ?> />
                                                           <label for="checkboxUporedi<?php echo $val->id; ?>" class="css-label upor" title="Uporedite proizvod"><?php // echo $language["productBox"][3]; //Uporedi ?> 
                                                           <i class="material-icons icons">compare_arrows</i>
                                                           </label>
                                                       </form>
                                                       <!-- COMPARE END-->
                                                       </div>
                                           
                                            </td>
                                            <!--PRODUCT HELP END  -->
                                            <td class="text-center">
                                                <?php if(($val->type=='r' || $val->type=='vpi-r')){ ?>
                                                     <?php if($havemandatoryattr==0 && ($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && !$sitetestmode && $val->visibleprice==1 && $val->price>0 && $shopProductPriceVisible){ ?>
                                                     <div class="product-cart cms_productInputDecIncCont " langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>'>    
                                                         <input type="number" id="product_qty" class="dodaj-input hide" 
                                                                 min="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                                                                 value="1"<?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?> 
                                                                 max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $val->amount;} ?>" 
                                                                 maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $val->amount;} ?>" 
                                                                 step="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                                                         />
                                                         <a class="sa-button -rounded -primary <?php echo $shopTypeAddToShopCartClass; //IMPORTANT?> add2cart"
                                                                                             prodid="<?php echo $val->id;?>"
                                                                                             prodname="<?php echo $val->name;?>"
                                                                                             prodpic="<?php echo $val->image;?>"
                                                                                             prodprice="<?php echo $val->price;?>"
                                                                                             prodtax="<?php echo $val->tax;?>"
                                                                                             prodrebate="<?php echo $val->rebate;?>"
                                                                                             attr='<?php echo json_encode($attributedata);?>'
                                                                                             lang="<?php echo $_SESSION['langid'];?>"
                                                                                             langcode="<?php echo $_SESSION['langcode'];?>"
                                                                                             unitname="<?php echo $val->unitname;?>" 
                                                                                             unitstep="<?php echo $val->unitstep;?>"
                                                                                             >
                                                                                              <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                                                             <?php echo $language["productBox"][10]; //Dodaj u korpu?>
                                                             <!-- <img src="views/theme/img/icons/cart.png" alt="cart softart" class="img-responsive" title="Dodaj u korpu"> -->
                                                             
                                                         </a>
                                                        </div>
                                                     <?php } else { ?>
                                                         <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
                                                     <?php } ?>
                                                 <?php } ?>
                                                 <?php if(($val->type=='q' || $val->type=='vpi-q') && $havemandatoryattr==0 && $shopProductPriceVisible){ ?>
                                                  <div class="product-cart cms_productInputDecIncCont " langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>'> 
                                                          <input type="number" id="product_request_qty" class="dodaj-input hide" 
                                                                 min="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                                                                 value="1"<?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?> 
                                                                 step="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                                                          />
                                                          <a class="sa-button -rounded -warning <?php echo $shopTypeAddToShopCartRequestClass; //IMPORTANT?> add2cart"
                                                                                             prodid="<?php echo $val->id;?>"
                                                                                             prodname="<?php echo $val->name;?>"
                                                                                             prodpic="<?php echo $val->image;?>"
                                                                                             prodprice="<?php echo $val->price;?>"
                                                                                             prodtax="<?php echo $val->tax;?>"
                                                                                             prodrebate="<?php echo $val->rebate;?>"
                                                                                             attr='<?php echo json_encode($attributedata);?>'
                                                                                             lang="<?php echo $_SESSION['langid'];?>"
                                                                                             langcode="<?php echo $_SESSION['langcode'];?>"
                                                                                             unitname="<?php echo $val->unitname;?>"
                                                                                             unitstep="<?php echo $val->unitstep;?>"
                                                                                             ><?php echo $language["productBox"][10]; //Na upit?></a>
                                                  </div>
                                                 <?php } else if(($val->type=='q' || $val->type=='vpi-q') && $havemandatoryattr>0){ ?>
                                                         <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
                                                 <?}?>   
                                                 <?php else if($val->type=='vp'){ ?>
                                                         <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
                                                 <?} else{?>
                                                         <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
                                                  <?} ?>
                                            </td>

                                                 
                                     
</tr>
<!-- VIRTUAL PRODUCT ITEM END -->  