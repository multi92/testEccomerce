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
<!-- MANDATORY ATRIBUTE CHECK END-->
<div class="xs-product-holder pos product" itemscope itemtype="http://schema.org/Product" productid = "<?php echo $val->id; ?>">
	<!-- ACTION -->
	<?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
    	<img src="<?php echo $theme_conf["action"][$_SESSION["langid"]][1]; ?>" alt="<?php echo $language["xsProductBox"][1]; //Akcija ?>" class="img-responsive akcija">
	<?php	} ?>
	<!-- ACTION END-->
	<!-- WISHLIST-->
    <!-- <a href=""><img src="views/theme/img/icons/heart-with-plus-symbol.png" alt="<?php //echo $language["xsProductBox"][2]; //Lista Želja ?>" class="img-responsive zelja" title="Dodaj u listu želja"></a>  -->
	<!-- WISHLIST END-->

	<!-- COMPARE -->
	<?php /*	$comparechk='';
				if(isset($_SESSION['compare'])){
					foreach($_SESSION['compare'] as $ckey => $cval){
						if($cval[0] == $val->id){
							$comparechk='checked';
							break;
						}
					}
				} 
			*/	?>
    <!--<form  class="uporediForm">
		<input type="checkbox" name="checkboxG1" id="checkboxUporedi<?php //echo $val->id; ?>" class="css-checkbox uporedi_checkbox jq_compare" <?php //echo $comparechk; ?> />
        <label for="checkboxUporedi<?php //echo $val->id; ?>" id="checkboxLabelUporedi<?php //echo $val->id; ?>" class="css-label upor"><?php //echo $language["productBoxLine"][3]; //Uporedi ?></label> 
    </form>--:
	 COMPARE END -->
	<!-- EXTRA DETAILS -->
    <div class="stiker-holder">
	<?php if(isset($val->extradetail) && count($val->extradetail)>0) { ?>
		<?php	foreach($val->extradetail as $ve){ ?>
			<img src="<?php echo GlobalHelper::getImage($ve['image'], 'small');?>" alt="<?php echo $ve['name']; ?>" class="img-responsive">
		<?php   } ?>
	<?php } ?>
    </div>
	<!-- EXTRA DETAILS END-->
	<!-- ACTION REBATE-->
	<?php if($val->actionrebate>0 && $val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
    	<span class="disc">- <?php echo floor($val->actionrebate);?>%</span>
	<?php } ?>
	<!-- ACTION REBATE END-->

     <div class="xs-product-pic">
         <a href="<?php echo $val->productlink;?>" itemprop="url"><img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'thumb'); ?>" alt="<?php echo $val->name;?>" class="img-responsive" itemprop="image"></a>
     </div>
     <div class="xs-product-brend hide">
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
     <div class="xs-product-name">
         <a href="<?php echo $val->productlink;?>" itemprop="url"><span itemprop="name"><?php echo $val->name;?></span></a><br><br>
         <span>Šifra:<?php echo $val->code;?></span>
     </div>    
     <div class="xs-product-price" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
     <?php if(!$shopProductPriceVisible && ($val->type=='r' || $val->type=='vpi-r')){
            //echo 'Cena na upit';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice" style="color:#f0ad4e;" content="'.$language["xsProductBox"][12].'">'.$language["xsProductBox"][12].' </p>';////Cena na upit
               			
                
     }?>
     <?php if($val->type=='q' && $havemandatoryattr==0){ 
		     	//echo 'Cena na upit';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice" style="color:#f0ad4e;" content="'.$language["xsProductBox"][8].'">'.$language["xsProductBox"][8].' </p>';////Cena na upit
     } else if($val->type=='q' && $havemandatoryattr>0){  
     			//echo 'Cena na upit';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice"  content="'.$language["xsProductBox"][8].'">'.$language["xsProductBox"][8].'</p>';////Cena na upit
     } else if($val->type=='vp'){
     			//echo 'Grupno proizvod - Raspon cena';  
             	echo '<br>';
             	echo '<p itemprop="lowPrice"  content="'.$language["xsProductBox"][10].'">'.$language["xsProductBox"][10].'</p>';////Raspon cena
     } else { ?>
     			<?php if($val->visibleprice==1 && ($val->type=='r' || $val->type=='vpi-r')){ ?>
     				<?php if(($_SESSION['shoptype']=='b2c') && (($val->pricevisibility=='a') || 
                                                                (($val->pricevisibility=='c') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged'))
                                                               )  ){?>
							<?php if($vrebate>0){	?>
								<p><del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></p>			
								<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?> <span itemprop="	priceCurrency" 	content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]	; //RSD ?></span></p>			
							<?php } else { ?>			
								<p></p>			
								<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" 
									content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>	
							<?php } ?>	
					<?php } ?>
					<?php if(($_SESSION['shoptype']=='b2b') && (($val->pricevisibility=='a') || 
                                                                (($val->pricevisibility=='b') && ($_SESSION['loginstatus'] == 'logged')) || 
                                                                (($val->pricevisibility=='cb') && ($_SESSION['loginstatus'] == 'logged'))
                                                               ) ){?>
						<?php if($user_conf["b2b_show_prices_with_vat"][1]==0){?>
							<?php if($vrebate>0){	?>
								<p><del itemprop="highPrice"  content="<?php echo number_format(round($vprice,2),2);?>"><?php echo number_format(round($vprice,2),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></p>			
								<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1-($vrebate/100)),2),2);?>"><?php echo number_format(round($vprice*(1-($vrebate/100)),2),2);?> <span itemprop="priceCurrency" 	
									content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]	; //RSD ?></span></p>			
							<?php } else { ?>			
								<p></p>			
								<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice,2),2);?>"><?php echo number_format(round($vprice,2),2);?> <span itemprop="priceCurrency" 
									content="<?php echo $language["moneta"][1]; 	//RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>	
							<?php } ?>

						<?php } else {?>
							<?php if($vrebate>0){	?>
								<p><del itemprop="highPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" 
									content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></p>			
								<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100))*(1	-($vrebate/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2),2);?> <span 
									itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]	; //RSD ?></span></p>			
							<?php } else { ?>			
								<p></p>			
								<p itemprop="lowPrice"  content="<?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?>"><?php echo number_format(round($vprice*(1+($vtax/100)),2),2);?> <span itemprop="priceCurrency" 
									content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>	
							<?php } ?>
						<?php } ?>
					<?php } ?>
	 			<?php } ?>
	 			<?php if($val->visibleprice==0 && ($val->type=='r' || $val->type=='vpi-r')){
	 				//echo '<br>';
             		//echo '<p class="hide" itemprop="lowPrice"  content="'.$language["xsProductBox"][9].'">'.$language["xsProductBox"][9].'</p>';////Pozovite
	 			} ?>
     <?php } ?>
     </div>
     <div class="xs-product-btn-holder">
         <a href="<?php echo $val->productlink;?>" class="sa-button -rounded -primary xs-product-btn hide"><?php echo $language["xsProductBox"][7]; //Detaljije ?></a>
     </div>
</div>                