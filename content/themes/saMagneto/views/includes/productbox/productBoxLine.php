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
<?php 	$havemandatoryattr=0;
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
<div class="h-product-holder pos product" itemscope itemtype="http://schema.org/Product" productid = "<?php echo $val->id; ?>">
	<!-- EXTRA DETAILS -->
                <div class="stiker-holder">
				<?php if(isset($val->extradetail) && count($val->extradetail)>0) { ?>
				<?php	foreach($val->extradetail as $ve){ ?>
                    <img src="<?php echo GlobalHelper::getImage($ve['image'], 'small');?>" alt="<?php echo $ve['name']; ?>" class="img-responsive">
                <?php   } ?>
				<?php } ?>
                </div>
				<!-- EXTRA DETAILS END-->
					<!-- ACTION -->
				<?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
                <img src="<?php echo $theme_conf["action"][$_SESSION["langid"]][1]; ?>" alt="<?php echo $language["productBoxLine"][1]; //Akcija ?>" class="img-responsive akcija2">
				<?php	} ?>
				<!-- ACTION END-->
    <span itemscope itemtype="http://schema.org/brand"><a href="<?php echo $val->productlink;?>" itemprop="url">
    <div class="col-sm-3 col-xs-4 h-product-col col-seter">
        <a href="<?php echo $val->productlink;?>" itemptop="url">
            <div class="h-product-pic pos">
                <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'thumb'); ?>" alt="<?php echo $ve['name']; ?>" class="img-responsive" itemprop="image">
			
				
				<!-- ACTION REBATE-->
				<?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
    				<span class="disc">- <?php echo floor($val->actionrebate);?>%</span>
				<?php } ?>
				<!-- ACTION REBATE END-->
				<!-- COMPARE -->
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
                <form  class="uporediForm-h">
                    <input type="checkbox" name="checkboxG1" id="checkboxUporedi<?php echo $val->id; ?>" class="css-checkbox uporedi_checkbox jq_compare" <?php echo $comparechk; ?> />
                    <label for="checkboxUporedi<?php echo $val->id; ?>" class="css-label upor"><?php echo $language["productBoxLine"][3]; //Uporedi ?></label> 
                </form> 
				<!-- COMPARE END-->
            </div>
        </a>
    </div>

    <div class="col-sm-9 col-xs-8 h-product-col col2 col-seter">
        <div class="row noMargin">
            <div class="col-lg-12">
                <div class="h-product-name">
                    <a href="<?php echo $val->productlink;?>" itemprop="url"><h4 itemprop="name"><?php echo $val->name;?></h4></a>
                    <small><strong><?php echo $language["productBoxLine"][5]; //Sifra artikla ?>: <?php echo $val->code;?></strong></small>
					<?php if($val->amount==0){ ?>
                    	<!-- <small class="nema-h" itemprop="availability"><strong itemscope itemtype="http://schema.org/OutOfStock">- <?php //echo $language["productBoxLine"][6]; //Nema na stanju ?></strong></small> -->
                    	<small class="nema-h" itemprop="availability" style="color:#f9ce09!Important; background-color: #2f343d; border-radius: 3px; padding: 3px 5px 3px 5px;">
                    		<strong itemscope itemtype="http://schema.org/OutOfStock"><?php echo $language["productBoxLine"][14]; //Pozovite ?></strong></small>
					 <?php } ?>  
					 <!-- BREND-->
    				<div class="h-product-brend">
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
					<!-- RATE-->
                    <!--<div class="rateYo rate-h" itemprop="aggregateRating"></div>-->
					<!-- RATE END-->
                </div>
            </div>
        </div>
		
		
        <div class="row noMargin">
            <div class="col-lg-9 col-sm-9 col-xs-7">
                <div class="h-product-attr">
				<?php if($val->haveattr ){ ?>
                    <ul class="h-product-attr-ul filter-color-ul">
						<?php foreach($val->attr as $aval){ ?>
						<?php if($aval["mandatory"]==1 && $val->type!='vp'){ ?>
							
							<?php 	$atrvalues='';
							        $cnt=0;
									foreach($aval["value"] as $avalue){ 
										$cnt++;
										array_push($attributedata,array($aval['attrid'],$avalue['attr_val_id']));
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
            </div>

            <div class="col-lg-3 col-sm-3 col-xs-5">
                <div class="h-product-price" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
                <?php if(!$shopProductPriceVisible && ($val->type=='r' || $val->type=='vpi-r')){
                		//echo 'Ulogujte se za cenu';  
               			echo '<p class="text-right" itemprop="lowPrice" style="color:#FF4747!important;" content="'.$language["productBoxLine"][15].'">'.$language["productBoxLine"][15].' </p>';
                
             	}?>
				<?php if($val->type=='q' && $havemandatoryattr==0){  
             			//echo 'Cena na upit';  
             			echo '<p class="text-right" itemprop="lowPrice" style="color:#f0ad4e!important;" content="'.$language["productBoxLine"][8].'">'.$language["productBoxLine"][8].' </p>';////Cena na upit
             		  } else if($val->type=='q' && $havemandatoryattr>0){  
             			//echo 'Cena na upit';  
             			echo '<p class="text-right" itemprop="lowPrice"  content="'.$language["productBoxLine"][8].'">'.$language["productBoxLine"][8].'</p>';////Cena na upit
             		  } else if($val->type=='vp'){  
             			//echo 'Cena na upit';  
             			echo '<p class="text-right" itemprop="lowPrice"  content="'.$language["productBoxLine"][12].'">'.$language["productBoxLine"][12].'</p>';////Cena na upit
             		  } else { ?>





						<?php if($val->visibleprice==1 && $val->type=='r' && $shopProductPriceVisible){ 
								if($vrebate>0){	?>
									<p class="text-right">
									<del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del>
									</p>
							<p class="text-right" itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?> <span 		itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
							
								<?php } else { ?>
									<p class="text-right">
									<del itemprop="highPrice"  content=""> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"></span></del>
									</p>
									<p class="text-right" itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
									<small class="go-right"></small>
								<?php } ?>
						<?php } ?>
						<?php if($val->visibleprice==0 && $val->type=='r'){ 
							echo '<p class="text-right" itemprop="lowPrice"  content="'.$language["productBoxLine"][13].'">'.$language["productBoxLine"][13].'</p>';////Pozovite
						} ?>
					<?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="h-product-cart cms_productInputDecIncCont" langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>' >
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
    				<a class="cms_addToWishList" title="<?php echo $language["productBoxLine"][7];// Dodaj u listu zelja?>">
						<i class="cms_iWishList material-icons wish-icons <?php echo $wishlistchk;?>" title="<?php echo $language["productBoxLine"][7];// Dodaj u listu zelja?>">favorite</i>
    				</a>
    			<?php } else { ?>
    				<a data-toggle="modal" data-target=".bs-example-modal-sm" title="<?php echo $language["productBoxLine"][7];// Dodaj u listu zelja?>">
						<i class="cms_iWishList material-icons wish-icons <?php echo $wishlistchk;?>" title="<?php echo $language["productBoxLine"][7];// Dodaj u listu zelja?>">favorite</i>
    				</a>
    			<?php } ?>
				<!-- WISHLIST END -->
				<?php if(($val->type=='r')){ ?>
					<?php if($havemandatoryattr==0 && ($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && !$sitetestmode && $val->visibleprice==1 && $val->price>0  && $shopProductPriceVisible){ ?>
						<input type="number" id="product_qty" class="dodaj-input hide cms_productQtyInput" 
							min="1" 
                            value="1" 
                            max="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $val->amount-OrderingHelper::ProductQtyInCartCheck($val->id);} ?>" 
                            maxquantity="<?php if($user_conf["add_product_with_stack_zero"][1]==0){ echo $user_conf["max_add_product_with_stack_zero"][1];} else { echo $val->amount-OrderingHelper::ProductQtyInCartCheck($val->id);} ?>" 
                            step="1" 
						/>
						<a class="sa-button -rounded -primary product_add_to_shopcart productBoxLine"
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
													<?php echo $language["productBoxLine"][10]; //Dodaj u korpu ?>
					</a>
					<?php } else { ?>
						<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBoxLine"][9]; //Detaljnije ?></a>
					<?php } ?>	
                <?php } ?>
                <?php if($val->type=='q' && $havemandatoryattr==0  && $shopProductPriceVisible){ ?>
        		 	<input type="number" id="product_request_qty" class="dodaj-input hide cms_productQtyInputRequest  " 
        		 			min="1" 
                            value="1" 
                            step="1"  
        		 	/>
                 	<a class="sa-button -rounded -warning product_add_to_shopcart_request productBoxLine"
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
        			<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBoxLine"][9]; //Detaljnije?></a>
        		<?}?>	
        		<?php if($val->type=='vp'){ ?>
        			<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBoxLine"][9]; //Detaljnije?></a>
        		<?}?>

                </div>
            </div>    
                
            
        </div>
    </div>

</div>