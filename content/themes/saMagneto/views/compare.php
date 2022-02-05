<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
  					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
  							<span itemprop="name"><?php echo $language["global"][3]; ?></span>

  						</a>
						
  					</li>
  					
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $language["compare"][1];?></span>
  					</li>
				</ol>

</div>
<section>
    <div class="container">
    	<div class="content-page">
    		<div class="row">
            <div class="col-md-12 uporedi-tabela">
                <div class="table-responsive">
                    <table class="table">
						<?php if(is_array($compareprods) && count($compareprods) > 0){ ?>
                        <tr>
							<th style="width:12%;"></th>
							<?php foreach ($compareprods as $prod) { ?>
                            <th class="izbaci1" style="width:22%;"><a role="button"><small id="izbaci1">
							<a role="button" class="izbaci1 prod_compare_remove" onclick="remove_compare_prod(<?php echo $prod->id ?>)" prodid="<?php echo $prod->id ?>">
								<?php echo $language["compare"][2];?>
							</a>
							<i class="fa fa-times"  aria-hidden="true"></i></small></a></th>
							<?php } ?>
                        </tr>
                        <tr>
                            <td><b><?php echo $language["compare"][3];?></b></td>
							<?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1">
                                <div class="uporedi-pic-holder" style="background-image:url('<?php echo GlobalHelper::getImage('fajlovi/product/'.$prod->pictures[0]['img'], 'small'); ?>');"></div>
                            </td>
							<?php } ?>
                        </tr>
                        <tr>
                            <td><b><?php echo $language["compare"][4];?></b></td>
							<?php foreach ($compareprods as $prod) { ?>
                            <td  class="izbaci1"><?php echo $prod->name; ?></td>
							<?php } ?>
                        </tr>
                        <tr>
                            <td><b><?php echo $language["compare"][5];?></b></td>
							<?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1"><?php if($prod->pricevisible) echo number_format($prod->price*(1 + $prod->tax/100)*(1 - $prod->rebate/100), 2, ",", ".") ?> <?php echo $language["moneta"][1];?></td>
							<?php } ?>
                        </tr>
                        <tr>
                            <td><b><?php echo $language["compare"][6];?></b></td>
							<?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1"><?php echo $prod->manufname; ?></td>
							<?php } ?>
                        </tr>
                        <tr>
                            <td><b><?php echo $language["compare"][7];?></b></td>
							<?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1" style="white-space: normal;"><?php echo nl2br(html_entity_decode($prod->description)); ?></td>
							<?php } ?>
                        </tr>
  					<tr>
						<td><b><?php echo $language["compare"][8];?></b></td>
					    <?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1" style="white-space: normal;"><?php echo nl2br(html_entity_decode($prod->characteristics)); ?></td>
                        <?php } ?>
					</tr>
					<tr>
						<td><b><?php echo $language["compare"][9];?></b></td>
					    <?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1" style="white-space: normal;"><?php echo nl2br(html_entity_decode($prod->specification)); ?></td>
                        <?php } ?>
					</tr>
					<tr>
						<td><b><?php echo $language["compare"][10];?></b></td>
					    <?php foreach ($compareprods as $prod) { ?>
                            <td class="izbaci1" style="white-space: normal;"><?php echo nl2br(html_entity_decode($prod->model)); ?></td>
                        <?php } ?>
					</tr>
					
					<?php foreach ($attrprodsdata as $attrdata) { ?>
                        <tr>
                            <th><?php echo ucfirst($attrdata['name']); ?></th>
                            <?php foreach ($attrdata['attrvals'] as $attrval) { ?>
                                <td class="izbaci1"><?php echo ucfirst($attrval); ?> </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                        <tr>
						<td><b></b></td>
					    <?php foreach ($compareprods as $val) { ?>
						
							<?php 
							//echo "<pre>";
							//var_dump($val);
							//echo "</pre>";
							$vprice=0;
							$vtax=0;
							$vrebate=0;
							if($val->pricevisible==1){  
								$vprice=$val->price; 
								$vtax=$val->tax;
								$vrebate=$val->rebate;
							}else{  
								$vprice='0';
								$vtax='0';
								$vrebate='0';
							};
							?>
							
							<?php 	
								//var_dump($val);
								$havemandatoryattr=0;
								if($val->haveAttr ){  
								foreach($val->attrs as $aval){  
									if($aval["mandatory"]==1){ 
										$havemandatoryattr++;
									}
								}  
								} 
							?>
						<td class="izbaci1">
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

						<div class="price-help cms_productInputDecIncCont" langcode="<?php echo $_SESSION['langcode']?>" prodid="<?php echo $val->id;?>" attr='<?php echo json_encode($attributedata);?>' >
							
        <?php if($val->type=='r'){ ?>
			<?php if($havemandatoryattr==0 && ($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0) && !$sitetestmode && $val->pricevisible==1 && $val->price>0){ ?>
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
													 <i class="fa fa-cart-plus" aria-hidden="true"></i> 
													<?php echo $language["productBox"][10]; //Dodaj u korpu?>
				</a>
			<?php } else { ?>
				<a href="<?php echo $val->productlink;?>" class="sa-button -rounded -info det-prod-butt"><?php echo $language["productBox"][9]; //Detaljnije?></a>
			<?php } ?>
		<?php } ?>
        <?php if($val->type=='q' && $havemandatoryattr==0){ ?>
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
						</td>
						<?php } ?>
					</tr>
						<?php } else { ?>
                    <h1><?php echo $language["compare"][12];?></h1>
						<?php } ?>
                    </table>
                </div>
            </div>
        </div>
    	</div>
        
    </div>
</section>