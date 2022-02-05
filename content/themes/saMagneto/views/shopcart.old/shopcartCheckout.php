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
        <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <span itemprop="name"><?php echo $language["shopcart_checkout"][1]; //Podaci o porudžbini ?></span>
        </li>
    </ol>
</div>

<section>
    <div class="container cart-container">
        <div class="content-page">
            <div class="row noMargin">
            <form id="cms_order-customer-form" metod="POST" role="FORM">
                <div class="col-sm-9 col-sm-push-3 col-seter">
                    

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
                                        <select class="field cms_customerPaymentMethod" name="customerPaymentMethod" 
                                                              
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
                                                    <td><?php echo $sval->name; ?></td>
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

                        <!-- SUBMIT BUTTONS -->
                        <div class="row">
                            <div class="checkout-finish-btn clearfix">
                                <div class="col-xs-6 _col-xs-100">
                                    <a href="korpa" class="sa-button -danger"><i class="material-icons icons">keyboard_arrow_left</i><?php echo $language["shopcart_checkout"][9]; // Vratite se na korpu ?></a>
                                </div>
                                <div class="col-xs-6 _col-xs-100">
                                    <button type="submit" class="sa-button cms_finish_order" lang="<?php echo $_SESSION['langid'];?>" langcode="<?php echo $_SESSION['langcode'];?>"><?php echo $language["shopcart_checkout"][10]; // Završite kupovinu ?></button>
                                </div> 
                            </div>     
                        </div>
                        <!-- SUBMIT BUTTONS END -->

                         
                </div>
            </form>
                <div class="col-sm-3 col-sm-pull-9 col-seter">
                    <?php include("app/controller/controller_orderHelpMenu.php")?>
                </div>
            </div>
        </div> 
    </div>        
</section>