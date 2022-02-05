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
            <span itemprop="name"><?php echo $language["shopcart_checkout_fast_offer"][1]; //Podaci o porudžbini ?></span>
        </li>
    </ol>
</div>

<section>
    <div class="container cart-container">
        <div class="content-page">
            <div class="row noMargin">
            <form id="cms_order-offer-form" metod="POST" role="FORM">
                <div class="col-sm-9 col-sm-push-3 col-seter">
                    

                        <!-- CUSTOMER DELIVERY SHIPPING AND PAYMENT -->
                       
                        <div class="row">
                            <div class="checkout-form clearfix">
                                <div class="col-md-12">
                                    <h4 class="title"><?php echo $language["shopcart_checkout_fast_offer"][1]; //Podaci za dostavu i plaćanje?></h4>
                                </div>
                                <div class="col-xs-6 _col-xs-100">
                                    <label class="my-label">
                                        <?php echo $language["shopcart_checkout_customer"][1]; //Ime ?>
                                        <input type="text" name="customerName" class="field" 
                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][1]; //Ime ?>" 
                                                           value="<?php if($logged){ if(isset($_SESSION['offer']['customer']['name'])){ echo $_SESSION['offer']['customer']['name']; } else { echo '' ;}} else {if(isset($_SESSION['offer']['customer']['name'])){ echo $_SESSION['offer']['customer']['name']; }}?>" 
                                                           
                                                           oninvalid="this.setCustomValidity('<?php echo $language["shopcart_checkout_customer"][2]; //Molimo vas unesite vaše ime ?>')"
                                        >
                                    </label>
                                </div>
                                <div class="col-xs-6 _col-xs-100">
                                    <label class="my-label">
                                        <?php echo $language["shopcart_checkout_customer"][3]; //Prezime ?>
                                        <input type="text" name="customerLastName" class="field" 
                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][3]; //Prezime ?>" 
                                                           value="<?php if($logged){ if(isset($_SESSION['offer']['customer']['lastname'])){ echo $_SESSION['offer']['customer']['lastname']; } else { echo '' ;}} else {if(isset($_SESSION['offer']['customer']['lastname'])){ echo $_SESSION['offer']['customer']['lastname']; }}?>" 
                                                           
                                                           oninvalid="this.setCustomValidity('<?php echo $language["shopcart_checkout_customer"][4]; //Molimo vas unesite vaše Prezime ?>')"
                                        >
                                    </label>
                                </div>
                                <div class="col-xs-6 _col-xs-100">
                                    <label class="my-label">
                                        <?php echo $language["shopcart_checkout_customer"][5]; //Email ?>
                                        <input type="email" name="customerEmail" class="field" 
                                                            placeholder="<?php echo $language["shopcart_checkout_customer"][5]; //Email ?>" 
                                                            value="<?php if($logged){ if(isset($_SESSION['offer']['customer']['email'])){ echo $_SESSION['offer']['customer']['email']; } else { echo '' ;}} else {if(isset($_SESSION['offer']['customer']['email'])){ echo $_SESSION['offer']['customer']['email']; }}?>"  
                                                             
                                                            title="<?php echo $language["shopcart_checkout_customer"][7]; //Molimo vas unesite validnu Email adresu ?>"
                                                            oninvalid="this.setCustomValidity('<?php echo $language["shopcart_checkout_customer"][6]; //Molimo vas unesite vaš Email ?>')"
                                        >
                                    </label>
                                </div>
                                <div class="col-xs-6 _col-xs-100">
                                    <label class="my-label">
                                        <?php echo $language["shopcart_checkout_customer"][8]; //Broj telefona ?>
                                        <input type="text" name="customerPhone" class="field"
                                                           placeholder="<?php echo $language["shopcart_checkout_customer"][8]; //Broj telefona ?>" 
                                                           value="<?php if($logged){ if(isset($_SESSION['offer']['customer']['phone'])){ echo $_SESSION['offer']['customer']['phone']; } else { echo '' ;}} else { if(isset($_SESSION['offer']['customer']['phone'])){ echo $_SESSION['offer']['customer']['phone']; } }?>"  
                                                           
                                                           oninvalid="this.setCustomValidity('<?php echo $language["shopcart_checkout_customer"][9]; //Molimo vas unesite vaš broj telefona ?>')"
                                        >
                                    </label>
                                </div>
                                
                                
                                
                                
                            
                            </div>       
                        </div>



                       

                        <!-- SUBMIT BUTTONS -->
                        <div class="row">
                            <div class="checkout-finish-btn clearfix">
                                <div class="col-xs-6 ">
                                    <a href="korpa" class="sa-button -danger"><i class="material-icons icons">keyboard_arrow_left</i><?php echo $language["shopcart_checkout_fast_offer"][9]; // Vratite se na korpu ?></a>
                                </div>
                                <div class="col-xs-6 _col-xs-100">
                                    <button type="submit" class="sa-button -rounded offer-button cms_finish_order" lang="<?php echo $_SESSION['langid'];?>" langcode="<?php echo $_SESSION['langcode'];?>"><?php echo $language["shopcart_checkout_fast_offer"][10]; // Završite kupovinu ?></button>
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