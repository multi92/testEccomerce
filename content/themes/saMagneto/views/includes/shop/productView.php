<?php include($system_conf["theme_path"][1]."views/includes/shop/toolBox.php");?>
<br>
<!--VIEW TYPE 1-->
<?php if($_SESSION['viewtype']==1){?>
<div class="row noMargin">
	<?php foreach($prodata[1] as $val){ ?>
	<div class="col-lg-4 col-sm-4 col-xs-6 _unpadding border-seter">
		<?php include($system_conf["theme_path"][1]."views/includes/productbox/productBox.php");?>
	</div>
	<?php } ?>
</div>
<?php } ?>
<!--VIEW TYPE 1 END-->
<!--VIEW TYPE 2-->
<!-- PRODUCT BOX LINE -->
<?php if($_SESSION['viewtype']==2){?>
<div class="row noMargin">
	<?php foreach($prodata[1] as $val){ ?>
	<?php include($system_conf["theme_path"][1]."views/includes/productbox/productBoxLine.php");?>
	<?php } ?>
</div>
<?php } ?>
<!-- PRODUCT BOX LINE  END-->
<!--VIEW TYPE 2 END-->
<!--VIEW TYPE 3-->
<!-- PRODUCT BOX LINE  B2B-->
<?php if($_SESSION['viewtype']==3){ ?>
	<!-- <div class="row noMargin"> -->
	    <!-- <div class="col-md-10"> -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered -product-b2b-table">
                <tr class="table-row">
 					<th class="table-head"><?php echo $language["productBoxLineTableB2B"][1];//Slika ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][2];//Naziv ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][3];//Šifra ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][4];//Jed.mere ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][5];//Stanje ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][6];//Atributi ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][7];//Cena (RSD) ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][8];//Popust ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][9];//Ukupno (RSD) ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][10];//Količina ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][11];//Dodaj ?></th>
                    <th class="table-head"><?php echo $language["productBoxLineTableB2B"][12];//U korpi ?></th>

                </tr>
                <?php //foreach($prodata[1] as $val){ ?>
					<?php //include($system_conf["theme_path"][1]."views/includes/productbox/productBoxLineB2B.php");?>
				<?php //} ?>
                <?php 
						// $final_single_proddata=array();
						// $final_proddata=array();
						// $final_proddata[0]=$prodata[0];
						// $final_proddata[1]=array();
						// //var_dump($final_proddata[1]);
						// //echo '<pre>';
						// //var_dump($prodata[1]);
						// //echo '</pre>';
						
						
						// foreach($prodata[1] as $key=>$val){
						// 	$data = array();
						// 	$mandatory=0;	
							
						// 	if(count($val->attr)>0){
						// 	for($i = 0; $i < count($val->attr); $i++){
						// 		$mandatory+=$val->attr[$i]["mandatory"];
								
						// 		if($val->attr[$i]["mandatory"]==1 && $val->attr[$i]["categoryid"]==$lastcatid){ 
						// 			$tmp_attr_lang_id = $val->attr[$i]["lang_id"];
						// 			$tmp_attr_name = $val->attr[$i]["name"];
						// 			$tmp_attr_mandatory = $val->attr[$i]["mandatory"];
								
						// 			$tmp_attr_id = $val->attr[$i]["attrid"];
						// 			$data[$i] = array();
								
						// 			foreach($val->attr[$i]['value'] as $k=>$v){
										
						// 				array_push($data[$i], array('attr_lang_id'=>$tmp_attr_lang_id,
						// 											'attr_name'=>$tmp_attr_name,
						// 											'mandatory'=>$tmp_attr_mandatory,
						// 											'attrid'=>$tmp_attr_id,
						// 											'attr_val_id'=>$v['attr_val_id'],
						// 											'attr_val_name'=>$v['attr_val_name'],
						// 											'mainimage'=>$v['mainimage'],
						// 											'maincolor'=>$v['maincolor']));
						// 			}	
						// 		}					
						// 	}
						// 	}
							
						// 	if($mandatory==0){
						// 			array_push($final_proddata[1],new ProductSmall($val->id,
						// 		                                    $val->code,
						// 											$val->barcode,
						// 											$val->image,
						// 											$val->name,
						// 											$val->categorypath,
						// 											$val->productlink,
						// 											$val->price,
						// 											$val->rebate,
						// 											$val->tax,
						// 											$val->amount,
						// 											$val->extradetail,
						// 											$val->visibleprice,
						// 											$val->haveattr,
						// 											$val->desc,
						// 											$val->type,
						// 											$val->actionrebate,
						// 											$val->attr,
						// 											Product::getProductQuantityRebate($val->id),
						// 											$val->maxrebate,
						// 											$val->brendid,
						// 											$val->brendname,
						// 											$val->brendhasimage,
						// 											$val->brendimage,
						// 											$val->unitname,
						// 											$val->unitstep
						// 											)
						// 					);
						// 	} else {
						// 		 // echo '<pre>';
						// 		 // var_dump($data);
						// 		 // echo '</pre>';
						// 		$final = array();
				
						// 	$final = Product::req($data);
						// 	//var_dump($final);
						// 	if(count($final)>0){
						// 	foreach($final as $v){
						// 		$attr_arr_final=array();
						// 		//$attr_value_arr_final=array();
						// 		foreach($v as $vv){
						// 		$attr_value_arr_final=array();
						// 		array_push($attr_value_arr_final,array('attr_val_id'=>$vv["attr_val_id"],
						// 											   'attr_val_name'=>$vv["attr_val_name"],
						// 											   'mainimage'=>$vv["mainimage"],
						// 											   'maincolor'=>$vv["maincolor"]
						// 												)
								
						// 					);
						// 		array_push($attr_arr_final,array('lang_id'=>$vv["attr_lang_id"],
						// 										 'name'=>$vv["attr_name"],
						// 										 'mandatory'=>$vv["mandatory"],
						// 										 'attrid'=>$vv["attrid"],
						// 										 'value'=>$attr_value_arr_final
						// 										)
						// 					);
						// 		}
						// 		// echo '<pre>'; var_dump($attr_arr_final); echo '</pre>';
						// 		array_push($final_proddata[1],new ProductSmall($val->id,
						// 		                                    $val->code,
						// 											$val->barcode,
						// 											$val->image,
						// 											$val->name,
						// 											$val->categorypath,
						// 											$val->productlink,
						// 											$val->price,
						// 											$val->rebate,
						// 											$val->tax,
						// 											$val->amount,
						// 											$val->extradetail,
						// 											$val->visibleprice,
						// 											$val->haveattr,
						// 											$val->desc,
						// 											$val->type,
						// 											$val->actionrebate,
						// 											$attr_arr_final,
						// 											Product::getProductQuantityRebate($val->id),
						// 											$val->maxrebate,
						// 											$val->brendid,
						// 											$val->brendname,
						// 											$val->brendhasimage,
						// 											$val->brendimage,
						// 											$val->unitname,
						// 											$val->unitstep
						// 											)
						// 					);
						// 	}
						// 	} else {
						// 		$attr_arr_final=array();
						// 		array_push($final_proddata[1],new ProductSmall($val->id,
						// 		                                    $val->code,
						// 											$val->barcode,
						// 											$val->image,
						// 											$val->name,
						// 											$val->categorypath,
						// 											$val->productlink,
						// 											$val->price,
						// 											$val->rebate,
						// 											$val->tax,
						// 											$val->amount,
						// 											$val->extradetail,
						// 											$val->visibleprice,
						// 											$val->haveattr,
						// 											$val->desc,
						// 											$val->type,
						// 											$val->actionrebate,
						// 											$attr_arr_final,
						// 											Product::getProductQuantityRebate($val->id),
						// 											$val->maxrebate,
						// 											$val->brendid,
						// 											$val->brendname,
						// 											$val->brendhasimage,
						// 											$val->brendimage,
						// 											$val->unitname,
						// 											$val->unitstep
						// 											)
						// 					);
								
						// 	}

						// 	}
							
							
						// }

					?>
					<?php //echo '<pre>'; var_dump($final_proddata[1]);echo '</pre>';?>

					<?php  foreach($prodata[1] as $key=>$val) { 
								include($system_conf["theme_path"][1]."views/includes/productbox/productBoxLineB2B.php");
							  } 
					?> 
                
            </table>
        </div>
    <!-- </div> -->
    <!-- </div> -->
	<div class="image-modal">
    	<div class="image-holder"></div>
    	<i class="material-icons icons">close</i>
	</div>

<?php } ?>
<!-- PRODUCT BOX LINE  B2B END-->
<!--VIEW TYPE 3 END-->
<!--PAGINATION-->
<div class="row noMargin">
	<div class="col-md-12 col-seter marginTop30">
		<nav aria-label="Page navigation">
			<ul class="pagination">
				<?php 	
				if($pagination[0] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[0].'&'.$getnopage.'" aria-label="'.$language["gallery_pagination"][1].'"><span aria-hidden="true">&laquo;</span></a></li>';
				if($pagination[1] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[1].'&'.$getnopage.'">&lsaquo;</a></li>';
				if($pagination[2] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[2].'&'.$getnopage.'">'.$pagination[2].'</a></li>';
				if($pagination[3] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[3].'&'.$getnopage.'">'.$pagination[3].'</a></li>';
				if($pagination[4] != '') echo '<li class="active"><a href="'.implode("/", $command).'/?p='.$pagination[4].'&'.$getnopage.'">'.$pagination[4].'</a></li>';
				if($pagination[5] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[5].'&'.$getnopage.'">'.$pagination[5].'</a></li>';
				if($pagination[6] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[6].'&'.$getnopage.'">'.$pagination[6].'</a></li>';
				if($pagination[7] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[7].'&'.$getnopage.'">&rsaquo;</a></li>';
				if($pagination[8] != '') echo '<li><a href="'.implode("/", $command).'/?p='.$pagination[8].'&'.$getnopage.'" aria-label="'.$language["gallery_pagination"][2].'"><span aria-hidden="true">&raquo;</span></a></li>';
				?>
			</ul>
		</nav>
	</div>
</div>
				<!--PAGINATION END-->
