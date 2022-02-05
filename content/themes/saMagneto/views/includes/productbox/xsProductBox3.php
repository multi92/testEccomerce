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
<!-- MANDATORY ATRIBUTE CHECK END-->
<div class="xs-product-holder pos product" itemscope itemtype="http://schema.org/Product" productid = "<?php echo $val->id; ?>">
	<!-- ACTION -->
	<?php if($val->actionrebate>0){ $lg=$_SESSION["langid"]; ?>
    <img src="<?php echo $theme_conf["action"][$lg][1]; ?>" alt="<?php echo $language["xsProductBox"][1]; //Akcija ?>" class="img-responsive akcija">
	<?php	} ?>
	<!-- ACTION END-->
	<!-- WISHLIST-->
    <!--<a href=""><img src="views/theme/img/icons/heart-with-plus-symbol.png" alt="<?php //echo $language["xsProductBox"][2]; //Lista Želja ?>" class="img-responsive zelja" title="Dodaj u listu želja"></a>
	-->
	<!-- WISHLIST END-->
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
    <form  class="uporediForm">
		<input type="checkbox" name="AcheckboxG1" id="TcheckboxUporedi<?php echo $val->id; ?>" class="css-checkbox uporedi_checkbox jq_compare" <?php echo $comparechk; ?> />
        <label for="TcheckboxUporedi<?php echo $val->id; ?>" class="css-label upor"><?php echo $language["productBoxLine"][3]; //Uporedi ?></label> 
    </form>
	<!-- COMPARE END -->
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
	<?php if($val->actionrebate>0){ ?>
    <span class="disc">- <?php echo $val->actionrebate;?>%</span>
	<?php } ?>
	<!-- ACTION REBATE END-->

     <div class="xs-product-pic">
         <a href="<?php echo $val->productlink;?>" itemprop="url"><img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'thumb'); ?>" alt="<?php echo $val->name;?>" class="img-responsive" itemprop="image"></a>
     </div>
     <div class="xs-product-name">
         <a href="<?php echo $val->productlink;?>" itemprop="url"><span itemprop="name"><?php echo $val->name;?></span></a> <br> <br>
         <span>Šifra:<?php echo $val->code;?></span>
     </div>    
     <div class="xs-product-price" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">

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






	 <?php if(($val->visibleprice==1) && $shopProductPriceVisible){ 
				if($vrebate>0){	?>
					<p><del itemprop="highPrice"  content="<?php echo round($vprice*(1+($vtax/100)),2);?>"><?php echo round($vprice*(1+($vtax/100)),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></del></p>
					<p itemprop="lowPrice"  content="<?php echo round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2);?>"><?php echo round($vprice*(1+($vtax/100))*(1-($vrebate/100)),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
				<?php } else { ?>
					<p></p>
					<p itemprop="lowPrice"  content="<?php echo round($vprice*(1+($vtax/100)),2);?>"><?php echo round($vprice*(1+($vtax/100)),2);?> <span itemprop="priceCurrency" content="<?php echo $language["moneta"][1]; //RSD ?>"><?php echo $language["moneta"][1]; //RSD ?></span></p>
				<?php } 
	 } ?>
     </div>
     <div class="xs-product-btn-holder">
         <a href="<?php echo $val->productlink;?>" class="btn myBtn xs-product-btn"><?php echo $language["xsProductBox"][7]; //Detaljije ?></a>
     </div>
</div>                