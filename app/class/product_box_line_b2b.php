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
<tr class="product" productid = "<?php echo $val->id; ?>">
					<?php $attributedata=array();?>
                    <td>
                        <div class="small-item-pic" imglink="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'thumb'); ?>" style="background-image:url('<?php echo GlobalHelper::getImage('fajlovi/product/'.$val->image, 'small');?>');"></div>&nbsp;<?php echo $val->code;?></td>
                    <td><?php  echo $val->name; ?></td>
                    <td>

						<?php $i=0; 
						  $mandatory=0;
									      foreach($val->attr as $av){
											 $mandatory+=$av['mandatory'];
											 
											$i++;
											if($i<8){
											$avalstr='';
											if(isset($av['value']) && count($av['value'])>0){
											foreach($av['value'] as $atrval){ 
												array_push($attributedata,array($av['attrid'],$atrval['attr_val_id']));
												if($atrval['mainimage']!=''){
													$avalstr.='<div style="background-image:url('.$atrval['mainimage'].');width:10px; height:10px;display:inline-block; background-size:cover; background-position:center;background-repeat:no-repeat;"></div>'.' ';
												}else if($atrval['maincolor']!=''){
													$avalstr.='<div style="background-color:'.$atrval['maincolor'].';width:10px; height:10px; display:inline-block;"></div>'.' ';
												}else {
													$avalstr.=$atrval['attr_val_name'].' ';	
												}
												
											}
											
											echo '<small>'.$av['name'].': '.$avalstr.'</small><br>';
											}
											}
					}?>
					</td>
					<?php if($val->amount==0){ ?>
                    <td><i class="fa fa-window-close" aria-hidden="true" style="color:red;"></i> </td>
					<?php } else { ?>
					 <td><i class="fa fa-check-square" aria-hidden="true" style="color:green;"></i> </td>
					<?php } ?>
					<?php   if($val->visibleprice==1){
									if($vrebate>0){
										echo ' <td>'.round($vprice,2).' RSD</td>';
										echo ' <td>'.$vrebate.'%</td>';
										echo ' <td>'.round($vprice*(1-($vrebate/100)),2).' RSD</td>';
									} else {
										echo ' <td>'.round($vprice,2).' RSD</td>';
										echo ' <td>0%</td>';
										echo ' <td>'.round($vprice,2).' RSD</td>';
									}
						} else{
                    echo '<td>Pozovite</td>';
                    echo '<td>-------</td>';
                    echo '<td>-------</td>';
						}?> 
                    <td>
						<?php if($val->amount>0 || $user_conf["add_product_with_stack_zero"][1]==0){ ?>
                        <input type="number" id="product_qty"  class="small-b2b-number num-check " min="0" value="1" >
						<a type="submit" class="myBtn num-check-button product_dodaj_u_korpuB2B b2baddtocart dualcode" 
									prodid="<?php echo $val->id;?>"
									prodname="<?php echo $val->name;?>"
									prodpic="<?php echo $val->image;?>"
									prodprice="<?php echo $vprice;?>"
									prodtax="<?php echo $vtax;?>"
									prodrebate="<?php echo $vrebate;?>"
									attr='<?php echo json_encode($attributedata);?>'
									lang="<?php echo $_SESSION['langid'];?>"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
							<?php if(OrderingHelper::IsInCartCheckB2B($val->id, json_encode($attributedata))){?>
							<span class="pull-right jq_productLineOK"><i class="fa fa-2x fa-check" aria-hidden="true" style="color:#00970C"></i></span>
							<?php } else {?>
							<span class="pull-right hide jq_productLineOK"><i class="fa fa-2x fa-check" aria-hidden="true" style="color:#00970C"></i></span>
							<?php }?>
							<span class="pull-right hide jq_productLineSpinner"><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true" style="color:#C4161C"></i></span>
						<?php }?>
						<?php if($val->amount==0){ ?>
						<a href="<?php echo $val->productlink;?>" class="btn myBtn2 det-prod-butt"><?php echo $language["product_box"][1];?>
						<?php }?>
					</td>
                    <td></td>
</tr>