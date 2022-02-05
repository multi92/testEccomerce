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
<?php 	$havemandatoryattr=0;
	if($val->haveattr ){  
		foreach($val->attr as $aval){  
			if($aval["mandatory"]==1){ 
				$havemandatoryattr++;
			}
		}  
	} 
?>
        <?php $shopTypeAddToShopCartClass='';?>
        <?php $shopTypeAddToShopCartRequestClass='';?>
        <?php $shopProductPriceVisible=false;?>

        <?php if($_SESSION['shoptype']=='b2c'){

                $shopTypeAddToShopCartClass='product_add_to_shopcart';
                $shopTypeAddToShopCartRequestClass='product_add_to_shopcart_request';
                if(     ($val->pricevisibility=='a') || 
                        (($val->pricevisibility=='c') && ($_SESSION['loginstatus'] == 'logged')) || 
                        (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged')))
                {        
                    $shopProductPriceVisible=true; 
                }    
             }
        ?>
        <?php if($_SESSION['shoptype']=='b2b'){
        
                $shopTypeAddToShopCartClass='product_add_to_shopcartB2B';
                $shopTypeAddToShopCartRequestClass='product_add_to_shopcart_requestB2B';
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
<div class="s-product-holder pos product" itemscope itemtype="http://schema.org/Product" productid = "<?php echo $val->id; ?>">
	<!-- ACTION -->
    <?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
    <img src="<?php echo $theme_conf["action"][$_SESSION["langid"]][1]; ?>" alt="<?php echo $language["productBox"][1]; //Akcija ?>" class="img-responsive akcija">
    <?php   } ?>
    <!-- ACTION END-->
	<div class="s-product-help">
	<!-- WISHLIST -->
	<?php 	$wishlistchk='';
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
    <a data-toggle="modal" data-target=".bs-example-modal-sm">
        <i class="cms_iWishList material-icons wish-icons <?php echo $wishlistchk;?>" title="<?php echo $language["productBox"][7];// Dodaj u listu zelja?>">favorite</i>
    </a>
    <?php } ?>
	<!-- WISHLIST END -->
	<!-- COMPARE -->
    <form  class="uporediForm ">
		<?php 	$comparechk='';
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
        <label for="checkboxUporedi<?php echo $val->id; ?>" class="css-label upor"><?php echo $language["productBox"][3]; //Uporedi ?></label> 
    </form>
	<!-- COMPARE END-->
	</div>
	

	<!-- COMPARE END-->                                    
    <!-- EXTRA DETAILS -->
    <div class="stiker-holder">
		<?php if(isset($val->extradetail) && count($val->extradetail)>0) { ?>
		<?php	foreach($val->extradetail as $ve){ ?>
			<img src="<?php echo GlobalHelper::getImage($ve['image'], 'small');?>" alt="<?php echo $ve['name']; ?>" class="img-responsive">
		<?php   } ?>
        
		<?php } ?>
    </div>
	<!-- EXTRA DETAILS END-->
	
    <a href="<?php echo $val->productlink;?>" itemprop="url">
        <div class="s-product-pic">
            <!-- ACTION REBATE-->
            <?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
                <span class="disc">- <?php echo floor($val->actionrebate);?>%</span>
            <?php } ?>
            <!-- ACTION REBATE END-->
            <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'small'); ?>" alt="<?php echo $val->name;?>" class="img-responsive" itemprop="image">
        </div>
    </a>
	<!-- BREND-->
    <div class="s-product-brend">
    	<?php if(!is_null($val->brendid) && $val->brendid>0){?>
        	<?php if(!is_null($val->brendhasimage) && $val->brendhasimage>0){?>
       			 <a class="" brendid="<?php echo $val->brendid; ?>">
            		<img src="<?php echo $val->brendimage; ?>" alt="<?php echo $val->brendname; ?>" class="img-responsive" itemprop="image">
        		 </a>
    		<?php } else { ?>
    			<a class="" brendid="<?php echo $val->brendid; ?>">
    				<span alt="<?php echo $val->brendname; ?>"><?php echo $val->brendname; ?></span>
        		</a>
    		<?php } ?>
        <?php } ?>
    </div>
    <!-- BREND END-->
	<!-- PRODUCT INFO-->
    <div class="s-product-name">
        <a href="<?php echo $val->productlink;?>" itemprop="url"><span itemprop="name" class="name"><?php echo $val->name;?></span></a> <br>
        <small class="code"><?php echo $language["productBox"][5]; //Šifra artikla: ?> <?php echo $val->code;?></small>
		<?php if($val->amount==0){ ?>
			<!-- <small class="availability" style="color:red;" class="go-right" itemprop="availability"><span itemscope itemtype="http://schema.org/OutOfStock"><?php //echo $language["productBox"][6]; //Nema na stanju ?></span></small> -->
            <small class="availability" style="color:#f9ce09; background-color: #2f343d; padding: 3px 5px 3px 5px; border-radius: 3px;" class="go-right" itemprop="availability"><span itemscope itemtype="http://schema.org/OutOfStock"><?php echo $language["productBox"][15]; //Pozovite ?></span></small>
        <?php } ?>    
        <!-- <small style="color:green;" class="go-right" itemprop="availability"><span itemscope itemtype="http://schema.org/InStock">- Na stanju</span></small> -->
    </div>
	<!-- PRODUCT INFO END-->
	<!-- ATRIBUTES-->
	
    <div class="s-product-attr hide">
        <ul class="s-product-attr-ul">
        	<?php $i=0; 
                          $mandatory=0;
                          foreach($val->attr as $av){
                            $mandatory+=$av['mandatory'];
                                             
                            $i++;
                            if($i<8 && $av['mandatory']==1 && $val->type!='vp'){
                                $avalstr='';
                                if(isset($av['value']) && count($av['value'])>0){
                                    foreach($av['value'] as $atrval){ 
                                        array_push($attributedata,array($av['attrid'],$atrval['attr_val_id']));
                                        if($atrval['mainimage']!=''){
                                            echo '<a class="s-prod-a"><li class="s-product-attr-li" style="background-image:url('.$atrval['mainimage'].'); height:18px;display:inline-block; background-size:cover; background-position:center;background-repeat:no-repeat "></li></a>';
                                        }else if($atrval['maincolor']!=''){
                                            echo '<a class="s-prod-a"><li class="s-product-attr-li" style="background-color:'.$atrval['maincolor'].';"></li></a>';
                                        }else {
                                            echo '<a class="s-prod-a"><li class="s-product-attr-li">'.$atrval['attr_val_name'].'</li></a>';
                                        }
                                    }
                                }
                            }
                         }
            ?> 
        </ul>
    </div>
	<!-- ATRIBUTES END-->
	<!-- RATE-->
    <!--<div class="rateYo" itemprop="aggregateRating"></div>-->
	<!-- RATE END-->

    <div class="s-product-price">
        <div class="price-help " itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
             <?php if(!$shopProductPriceVisible && ($val->type=='r' || $val->type=='vpi-r')){
                //echo 'Ulogujte se za cenu';  
                echo '<br>';
                echo '<p itemprop="lowPrice" style="color:#FF4747;" content="'.$language["productBox"][16].'">'.$language["productBox"][16].' </p>';////Ulogujte se za cenu
             }?>

       		 <?php if($val->type=='q' && $havemandatoryattr==0){  
             	//echo 'Cena na upit';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice" style="color:#f0ad4e;" content="'.$language["productBox"][8].'">'.$language["productBox"][8].' </p>';////Cena na upit
             } else if($val->type=='q' && $havemandatoryattr>0){  
             	//echo 'Cena na upit';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice"  content="'.$language["productBox"][8].'">'.$language["productBox"][8].'</p>';////Cena na upit
             } else if($val->type=='vp'){  
             	//echo 'Virtuelni proizvod';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice"  content="'.$language["productBox"][12].'">'.$language["productBox"][12].'</p>';////Raspon cena
             } else { ?>
                <?php /*echo '<pre>';var_dump($val->pricevisibility) ;echo '</pre>';*/?>
				<?php if($val->visibleprice==1 && $val->type=='r'){ ?>
					<?php if(($_SESSION['shoptype']=='b2c') && (($val->pricevisibility=='a') || 
                                                                (($val->pricevisibility=='c') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged'))
                                                               ) 
                          ){?>
						<?php if($vrebate>0){	?>
            				<small><del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></small>
            				<br>
            				<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
						<?php } else { ?>
							<small></small>
            				<br>
            				<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>	
						<?php } ?>
					<?php } ?>
					<?php if(($_SESSION['shoptype']=='b2b')  && (($val->pricevisibility=='a') || 
                                                                (($val->pricevisibility=='b') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged'))
                                                               ) 
                             ){?>
					   <?php if($user_conf["b2b_show_prices_with_vat"][1]==0){?>
						  <?php if($vrebate>0){	?>
            			 	   <small class="b2b-small-price-productbox">
            				    	<del itemprop="highPrice"  content="<?php echo number_format(round($vprice,2),2);?>"><?php echo $language["productBox"][14].' '.number_format(round($vprice,2),2); //VP CENA?> 
            						<span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span>
            				    	</del>
            				    </small>
            				    <br>
            				    <p class="b2b-price-productbox" itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1-($vrebate/100)),2),2);?>"><?php echo $language["productBox"][14].' '.number_format(round($vprice*(1-($vrebate/100)),2),2); //VP CENA?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
            				
						  <?php } else { ?>
						      	<small></small>
            				    <br>
            				
            				    <p  class="b2b-small-price-productbox" itemprop="lowPrice"  content="<?php echo number_format(round($vprice,2),2);?>"><?php echo $language["productBox"][14].' '.number_format(round($vprice,2),2); //VP CENA?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>	
						  <?php } ?>
					   <?php } else {?>
						  <?php if($vrebate>0){	?>
            				    <small class="b2b-small-price-productbox">
            				    	<del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo $language["productBox"][14].' '.number_format(round($vprice*(1+($vtax/100)),2),2); //VP CENA?> 
            				    		<span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span>
            				    	</del>
            				    </small>
            				    <br>
            				    <p class="b2b-price-productbox" itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1-($vrebate/100))*(1+($vtax/100)),2),2);?>"><?php echo $language["productBox"][14].' '.number_format(round($vprice*(1-($vrebate/100))*(1+($vtax/100)),2),2);//VP CENA?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
            				
						  <?php } else { ?>
							 <small></small>
            				    <br>
            				
            				    <p class="b2b-price-productbox" itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo $language["productBox"][14].' '.number_format(round($vprice*(1+($vtax/100)),2),2); //VP CENA?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>	
						  <?php } ?>
					   <?php } ?>
					<?php } ?>
				<?php } ?> 
				<?php if($val->visibleprice==0 && $val->type=='r'){
					echo '<br>';
             		echo '<p itemprop="lowPrice"  content="'.$language["productBox"][13].'">'.$language["productBox"][13].'</p>';////Pozovite
				 } ?>
			<?php } ?>
        </div>
        
        <?php /*&& (                                            ($val->pricevisibility=='a') || 
                                                                (($val->pricevisibility=='c') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged'))
                                                               ) */
        ?>
        <div class="price-help cms_productInputDecIncCont" langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>' >
        <?php if($val->type=='r'){ ?>
			<?php if($havemandatoryattr==0 && ($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && !$sitetestmode && $val->visibleprice==1 && $val->price>0 && $shopProductPriceVisible){ ?>
				<input type="number" id="product_qty" class="dodaj-input hide cms_productQtyInput" 
						min="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                        value="1"<?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?> 
                        max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $val->amount-OrderingHelper::ProductQtyInCartCheck($val->id);} ?>" 
                        maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $val->amount-OrderingHelper::ProductQtyInCartCheck($val->id);} ?>" 
                        step="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                        
				/>
				<a class="sa-button -rounded -primary <?php echo $shopTypeAddToShopCartClass; //IMPORTANT?> add2cart"
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
													 <!-- <i class="fa fa-cart-plus" aria-hidden="true"></i> -->
                                                     <i class="material-icons">add</i>
													<?php  echo $language["productBox"][10]; //Dodaj u korpu?>
				</a>
			<?php } else { ?>
				<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
			<?php } ?>
		<?php } ?>
        <?php if($val->type=='q' && $havemandatoryattr==0 && $shopProductPriceVisible){ ?>
        		 <input type="number" id="product_request_qty" class="dodaj-input hide cms_productQtyInputRequest" 
        		 		min="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
                        value="1"<?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?> 
                        
                        step="1" <?php //if($val->unitstep>0){ echo $val->unitstep; } else {echo '1';}?>
        		 />
                 <a class="sa-button -rounded -warning <?php echo $shopTypeAddToShopCartRequestClass; //IMPORTANT?> add2cart"
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
													><?php echo $language["productBox"][11]; //Na upit?></a>
        <?php } else if($val->type=='q' && $havemandatoryattr>0){ ?>
        		<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
        <?}?>	
        <?php if($val->type=='vp'){ ?>
        		<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
        <?}?>
        </div>
    </div>
</div>