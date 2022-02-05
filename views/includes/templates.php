<li class="items jq_smallMenuItemHolderTemplate hide">
	<a href="" class="links jq_forwardLeftMenuName"></a>
	<i class="material-icons icons jq_forwardLeftMenuBtn">keyboard_arrow_right</i>
</li>


<div class="thumbnails hide cms_productThumbnailsHolderTemplate">
	<div class="col-md-3 col-sm-6 col-seter thumb-div ">
		<div class="product-sec-pic cms_productSmallImage">
			<img src="views/theme/img/placeholderphoto1to1.jpg" alt="" class="img-responsive" itemprop="image">
		</div>
	</div>
</div>


<div class="fast-color hide jq_fastlookAttrContTemplate">
	<p class="jq_fastlookAttrTitle"></p>
	<ul class="product-boja-ul jq_proDetAttrCont atributi jq_fastlookAttrItemsHolder" mandatory="" attrid="">
		
		
		
	</ul>
</div>


<a class="product-attr-triger hide jq_fastlookAttrItemContTempate">
	<li class="product-boja-li jq_proDetAttrItem inline-block" attrvalid="" >
		<div class="fast-color-pik dimension55x55">
			<img src="" alt="prod" class="img-responsive product-boja-pic">
			<img src="views/theme/img/check.png" alt="check" class="img-responsive fast-check jqCheck">
		</div>
		<div class="fast-size-pik dimension55x55">
			<span></span>
			<img src="views/theme/img/check.png" alt="check" class="img-responsive fast-check jqCheck" >
		</div>
	</li>
</a>



<!-- PRODUCT BOX -->

<div class="col-lg-2 col-sm-3 col-xs-4  col-seter cms_productboxContModelTemplate hide">
	<div class="b-product-holder cms_product" proid="0">
		<div class="b-product pos">
			<div class="b-stiker-holder">
				
			</div>
			<img src="<?php echo $user_conf["no_img"][1];?>" alt="akcija" class="img-responsive akcija hide cms_productboxModalRebateImg">
			<span class="hide cms_productboxModalRebateAmount"> - 0 % </span>
					<a href="">
				<div class="b-product-pic" >
				</div>
			</a>
			<!--<div class="b-brend">
				<a href=""><img src="<?php //echo $user_conf["no_img"][1];?>" alt="<?php //echo $user_conf["company"][1];?>" class="img-responsive"></a>
			</div>-->
			<div class="b-product-name transition">
				<a href=""></a>
			</div>
			<div class="b-product-price">
				<del class="hide go-right cms_oldPriceAmountHolder"> <?php echo $language["moneta"][1]; //Moneta ?></del>
				<small class="go-left cms_priceModalHolder" style="font-size: 1.6rem;color:red;"> <?php echo $language["moneta"][1]; //Moneta ?></small>
			</div>
			
		</div>  
	</div>
</div>


<button class="btn btn-primary partnerAddressSelectBTNTemplate hide" partnerid="0" partneraddressid="0" style="padding:2px 6px!important;"><?php echo $language["commercialist_select_address_btn"][1]; ?></button>
<button class="btn btn-success float-right partnerInfoBTNTemplate hide" partnerid="0" partneraddressid="0" style="padding:2px 6px!important;"><?php echo $language["commercialist_more_info_btn"][1]; ?></button>
<button class="btn btn-primary float-right partnerSelectBTNTemplate hide" partnerid="0" partneraddressid="0" style="padding:2px 6px!important;"><?php echo $language["commercialist_select_btn"][1]; ?></button>