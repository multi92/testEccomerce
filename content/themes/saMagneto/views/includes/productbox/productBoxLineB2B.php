<!-- TR PRODUCT -->
<?php 
    $vprice=0;
    $vtax=0;
    $vrebate=0;
    $vqtyrebate=0;          
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
<?php   $havemandatoryattr=0;
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
<?php $attributedata=array();?>
<!-- MANDATORY ATRIBUTE CHECK END-->
                <tr class="table-row" productid = "<?php echo $val->id; ?>">
                    <!-- TD IMAGE-->
                    <td class="table-items"><img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'thumb'); ?>" imagebig="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'big'); ?>" class="img-responsive image -big"></td>
                    <!-- TD IMAGE END-->
                    <!-- TD PRODUCTNAME-->
                    <td class="table-items -b2b-line-product-name"><a href="<?php echo $val->productlink;?>"><?php echo $val->name; ?></a></td>
                    <!-- TD PRODUCTNAME END-->
                    <!-- TD PRODUCTCODE-->
                    <td class="table-items"><?php echo $val->code;?></td>
                    <!-- TD PRODUCTCODE END-->
                    <!-- TD IN STOCK-->
                    <td class="table-items">
                        <?php if($val->amount==0){ ?>
                            <i class="fa fa-phone-square" aria-hidden="true" style="color:#f9ce09; font-size: large;"></i>     
                        <?php } else { ?>
                            <?php if($shopProductPriceVisible){?>
                            <?php echo $val->amount;?>
                            <?php } else {?>
                            <?php echo '---';?>
                            <?php } ?>    
                        <?php } ?>
                    </td>
                    <!-- TD IN STOCK END-->
                    <!-- TD UNITNAME-->
                    <td class="table-items"><?php echo $val->unitstep." ".$val->unitname;?></td>
                    <!-- TD UNITNAME END-->
                    <!-- TD MANDATORY ATTRIBUTES-->
                    <td class="table-items">
                    <?php $i=0; 
                          $mandatory=0;
                          foreach($val->attr as $av){
                            if($av['mandatory']==1){
                                $mandatory++;
                            }
                            //$mandatory+=$av['mandatory'];
                                             
                            $i++;
                            if($i<8){
                                $avalstr='';
                                if(isset($av['value']) && count($av['value'])>0){
                                    foreach($av['value'] as $atrval){ 
                                        array_push($attributedata,array($av['attrid'],$atrval['attr_val_id']));
                                        
                                        if($av['mandatory']==1){
                                            if($atrval['mainimage']!=''){
                                                $avalstr.='<div style="background-image:url('.$atrval['mainimage'].');width:10px; height:10px;display:inline-block; background-size:cover; background-position:center;background-repeat:no-repeat "></div>';
                                            }else if($atrval['maincolor']!=''){
                                                $avalstr.='<div style="background-color:'.$atrval['maincolor'].';width:10px; height:10px; display:inline-block;"></div>'.' ';
                                            }else {
                                                $avalstr.=$atrval['attr_val_name'].' '; 
                                            }
                                        }
                                    }
                                    echo '<small>'.$av['name'].': '.$avalstr.'</small><br>';
                                }
                            }
                         }
                    ?> 
                    </td>
                    <!-- TD MANDATORY ATTRIBUTES END-->
                    <!-- TD PRICE-->
                    <td class="table-items -orange">
                        <?php if($val->type=='q' || $val->type=='vp' || $val->type=='vpi-q'){  
                                echo '---';  
                              } else {
                                if($val->visibleprice==1 && $shopProductPriceVisible){
                                    if($vprice>0){
                                        if($user_conf["b2b_show_prices_with_vat"][1]==0){
                                            echo number_format(round($vprice,2),2);
                                        } else {
                                          echo number_format(round($vprice*(1+($vtax/100)),2),2);  
                                        }  
                                    } else {
                                        echo '---';
                                    }
                                    
                                } else {
                                    echo $language["productBoxLineB2B"][10]; //Pozovite 
                                }
                              }
                        ?>
                    </td>
                    <!-- TD PRICE END-->
                    <!-- TD REBATE-->
                    <td class="table-items -green">
                        <?php if($val->type=='q' || $val->type=='vp' || $val->type=='vpi-q'){  
                                echo '---';  
                              } else {
                                if($val->visibleprice==1  && $shopProductPriceVisible){
                                    if($vprice>0){
                                        echo $vrebate."%"; 
                                    } else {
                                        echo '---'; 
                                    }
                                } else {
                                    echo $language["productBoxLineB2B"][10]; //Pozovite 
                                }
                              }
                        ?>
                    </td>
                    <!-- TD REBATE END-->
                    <!-- TD ITEMVALUE-->
                    <td class="table-items -red">
                        <?php if($val->type=='q' || $val->type=='vp' || $val->type=='vpi-q'){  
                                echo '---';  
                              } else {

                                if($val->visibleprice==1  && $shopProductPriceVisible){
                                if($vprice>0){
                                if($user_conf["b2b_show_prices_with_vat"][1]==0){
                                    if($vrebate>0){
                                        echo number_format(round($vprice*(1-($vrebate/100)),2),2);
                                    } else {
                                        echo number_format(round($vprice,2),2);
                                    }
                                } else {
                                    if($vrebate>0){
                                        echo number_format(round($vprice*(1-($vrebate/100))*(1+($vtax/100)),2),2);
                                    } else {
                                        echo number_format(round($vprice*(1+($vtax/100)),2),2);
                                    }
                                }
                                } else {
                                    echo '---';
                                }
                                } else{
                                    echo $language["productBoxLineB2B"][10]; //Pozovite
                                }
                              }
                        ?>
                    </td>
                    <!-- TD ITEMVALUE-->
                    <!-- TD QUANTITY-->
                    <?php if(($val->type!='vp') && $shopProductPriceVisible){ ?>
                    <?php if($val->type=='r' || $val->type=='vpi-r'){ ?>
                    <td class="table-items cms_productInputDecIncCont" langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>'>
                        <button id="decValue" class="cms_productInputDecButton">-</button>
                        <input type="number" id="product_qty"  class="small-b2b-number num-check cms_productQtyInput" 
                            min="1" 
                            value="1"
                            max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ 
                                            echo $user_conf["max_add_product_with_stack_zero"][1];
                                        } else { 
                                            if($val->type=='r' || $val->type=='vpi-r'){
                                                echo $val->amount-OrderingHelper::ProductQtyInCartCheck($val->id);
                                            } 
                                            if($val->type=='q' || $val->type=='vpi-q'){
                                                echo $val->amount-OrderingHelper::ProductRequestQtyInCartCheck($val->id);
                                            }
                                        } ?>" 
                            maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ 
                                            echo $user_conf["max_add_product_with_stack_zero"][1];
                                        } else { 
                                            if($val->type=='r' || $val->type=='vpi-r'){
                                                echo $val->amount-OrderingHelper::ProductQtyInCartCheck($val->id);
                                            } 
                                            if($val->type=='q' || $val->type=='vpi-q'){
                                                echo $val->amount-OrderingHelper::ProductRequestQtyInCartCheck($val->id);
                                            }
                                        } 
                                        ?>" 
                                    
                            step="1">
                        <button id="incValue" class="cms_productInputIncButton">+</button>
                    </td>
                    <?php } else { ?>
                        <td class="table-items cms_productInputDecIncCont" langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>'>
                        <button id="decValue" class="cms_productInputDecButtonRequest">-</button>
                        <input type="number" id="product_request_qty"  class="small-b2b-number num-check  cms_productQtyInputRequest" 
                            min="1" 
                            value="1"        
                            step="1">
                        <button id="incValue" class="cms_productInputIncButtonRequest">+</button>
                    </td>




                    <?php }  ?>
                    <?php } else { ?>
                    <td class="table-items cms_productInputDecIncCont">
                        ---
                    </td>
                    <?php }  ?>
                    <!-- TD QUANTITY END-->
                    <!-- TD ADD TO CHART-->
                    <!-- PRODUCTTYPE IS PRODUCT REGULAR-->
                    <?php if(($val->type=='r' || $val->type=='vpi-r') && $shopProductPriceVisible ){ ?>
                    <?php if(($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && $val->price>0 && $val->visibleprice==1  ){ ?>
                        <td class="table-items -add-buttons">
                            <!-- ADD PRODUCT WITH ATRIBUTES TO SHOPCART-->
                            <a type="submit" class="sa-button -rounded -primary num-check-button product_add_to_shopcartB2B b2baddtocart dualcode" 
                               prodid="<?php echo $val->id;?>"
                               prodname="<?php echo $val->name;?>"
                               prodpic="<?php echo $val->image;?>"
                               prodprice="<?php echo $vprice;?>"
                               prodtax="<?php echo $vtax;?>"
                               prodrebate="<?php echo $vrebate;?>"
                               attr='<?php echo json_encode($attributedata);?>'
                               lang="<?php echo $_SESSION['langid'];?>"
                               langcode="<?php echo $_SESSION['langcode'];?>"
                               unitname="<?php echo $val->unitname;?>"
                               unitstep="<?php echo $val->unitstep;?>"
                               >
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </a>
                             <!-- ADD PRODUCT WITH ATRIBUTES TO SHOPCART END-->
                            <!-- INFO PRODUCT QUANTITY IN SHOPCART-->
                            <a class="sa-button -rounded -info cms_product_with_attribut_quantity_in_chart" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>' disabled="disabled">
                            <?php if(OrderingHelper::IsInCartCheck($val->id, json_encode($attributedata))){ 
                                        echo OrderingHelper::QtyInCartCheck($val->id, json_encode($attributedata))." ".$val->unitname; 
                                        
                                  } else { 
                                    echo '0 '.$val->unitname; 
                                }?>            
                            </a>
                            <!-- INFO PRODUCT QUANTITY IN SHOPCART END-->  
                        </td>

                    <?php }?>
                    <?php if(($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && $val->price>0 && $val->visibleprice==0){ ?>
                        <td class="table-items -add-buttons">
                            <!-- PRODUCT AMOUNT IS ZERO SHOW INFO-->
                            <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info"><?php echo $language["productBoxLineB2B"][8]; //Detaljnije?></a>
                        </td>
                    <?php }?>
                    <?php if($val->amount==0 || $val->price==0){ ?>
                        <td class="table-items -add-buttons">
                            <!-- PRODUCT AMOUNT IS ZERO SHOW INFO-->
                            <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info"><?php echo $language["productBoxLineB2B"][8]; //Detaljnije?></a>
                        </td>
                    <?php }?>
                    <?php } ?>
                         
                    <!-- PRODUCTTYPE IS PRODUCT ON REQUEST-->
                    <?php if(($val->type=='q' || $val->type=='vpi-q') && $shopProductPriceVisible){ ?>
                        <td class="table-items -add-buttons">
                            <a type="submit" class="sa-button -rounded -warning product_add_to_shopcart_requestB2B b2baddtocart dualcode"
                               prodid="<?php echo $val->id;?>"
                               prodname="<?php echo $val->name;?>"
                               prodpic="<?php echo $val->image;?>"
                               prodprice="<?php echo $vprice;?>"
                               prodtax="<?php echo $vtax;?>"
                               prodrebate="<?php echo $vrebate;?>"
                               attr='<?php echo json_encode($attributedata);?>'
                               lang="<?php echo $_SESSION['langid'];?>"
                               langcode="<?php echo $_SESSION['langcode'];?>"
                               unitname="<?php echo $val->unitname;?>"
                               unitstep="<?php echo $val->unitstep;?>"
                            ><?php echo $language["productBoxLineB2B"][9]; //Na upit?></a>
                            <a class="sa-button -rounded -info cms_product_with_attribut_quantity_in_chart_request" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>' disabled="disabled">
                            <?php if(OrderingHelper::IsInCartRequestCheck($val->id, json_encode($attributedata))){ 
                                        echo OrderingHelper::QtyInCartRequestCheck($val->id, json_encode($attributedata))." ".$val->unitname; 
                                        
                                  } else { 
                                    echo '0 '.$val->unitname; 
                                }?>            
                            </a>
                        </td>
                    <?php } ?>
                    <?php if(($val->type=='vp') && $shopProductPriceVisible){ ?>
                        <td class="table-items -add-buttons">
                            <!-- VIRTUAL PRODUCT-->
                            <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info"><?php echo $language["productBoxLineB2B"][8]; //Detaljnije?></a>
                        </td>
                     <?php } ?>
                     <?php if(!$shopProductPriceVisible){ ?>
                        <td class="table-items -add-buttons">
                            <!-- VIRTUAL PRODUCT-->
                            <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info"><?php echo $language["productBoxLineB2B"][8]; //Detaljnije?></a>
                        </td>
                     <?php } ?>
                    <!-- TD ADD TO CHART END-->
                    <!-- TD CHART STATUS-->
                     <td class="table-items ">
                    <?php if(OrderingHelper::IsInCartCheck($val->id, json_encode($attributedata)) || OrderingHelper::IsInCartRequestCheck($val->id, json_encode($attributedata))){?>
                        <!-- IN CART -->
                            <span class="jq_productLineOK"  prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>' ><i class="fa fa-2x fa-check-square" aria-hidden="true" style="color:#00970C"></i></span>
                    <?php } else {?>
                        <!-- NOT IN CART -->
                            <span class="jq_productLineOK"  prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>'><i class="fa fa-2x fa-window-close" aria-hidden="true" style="color:red;"></i></span>
                    <?php }?>
                        <!-- LOADING SPINNER -->
                        <span class="hide jq_productLineSpinner"><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true" style="color:#C4161C"></i></span>
                    </td>
                    <!-- TD CHART STATUS END-->
                </tr>
<!-- TR PRODUCT END -->
                