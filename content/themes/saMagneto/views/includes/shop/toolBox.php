<div class="tool-box">
	<ul class="list clearfix">
		<!--COMPARE -->
		<li class="items">
			<small class="text"><?php echo $language["productView"][1]; //Uporedi ?></small>
			<?php $i=0; if(isset($_SESSION['compare'])){ ?>
			<?php 	 foreach($_SESSION['compare'] as $key=>$val){ $i++;?>
			<div class="compare compareItemCont jq_compareItemCont" productid = "<?php echo $val[0]; ?>">
				<a class="jq_removeFromCompareButton _absolutePosCentar"><i class="material-icons delete" title="Izbaci">delete</i></a>
				<img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val[1], 'thumb')?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive image">
			</div>
			<?php 	}  ?>
			
			<!--<div class="compare">
				<i class="material-icons delete" title="Izbaci">delete</i>
				<img src="img/noimage.png" alt="seeyou" class="img-responsive image">
			</div>-->
			<?php } ?> 
			<?php for ($x = 1; $x <= (4-$i); $x++) {?>
			<div class="compare">

				<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["no_img"][1];?>" alt="<?php echo $language["productView"][1]." ".$x; //Uporedi ?>" class="img-responsive image">
			</div>
			<?php } ?>
			
			<?php if(isset($_SESSION['compare']) && count($_SESSION['compare'])>0){ ?>
			<button class="btn myBtn compare-btn  compareButton" title="Uporedi" value="Uporedi" ><i class="material-icons">compare_arrows</i></button>
				<!--<input type="button" title="Uporedi" value="Uporedi" class="btn button compare-btn">
				<input type="button" value="Uporedi" class="btn myBtn uporediBtn compareButton">
				<button class="btn button compare-btn" title="Uporedi"><i class="material-icons">compare_arrows</i></button>-->
				<?php } else { ?>
				<button class="btn myBtn compare-btn" title="Uporedi" value="0" ><i class="material-icons">compare_arrows</i></button>
				<?php	} ?>
			</li>
			<!--COMPARE END-->
			<li class="items">
				<form action="" method="" class="_go-right cms_productMinMax">
					<small class="text"><?php echo $language["productView"][9]; //Cena ?></small>
					<input type="number" placeholder="Min." class="field cms_minProductValue" value="<?php if(isset($_GET['min'])){ echo $_GET['min']; }?>">
					<span> - </span>
					<input type="number" placeholder="Max." class="field cms_maxProductValue" value="<?php if(isset($_GET['max'])){ echo $_GET['max']; }?>">
					<button class="btn myBtn range-btn cms_productsMinMaxButton">OK</button>
				</form>
			</li>
			<!--SORT -->
			<li class="items">
				<?php 
				$sorting='';
				if(isset($_GET['sort'])){ 
					$sorting = $_GET['sort'];
				}
				?>
				<small class="text"><?php echo $language["productView"][3]; //Sortiraj po ?></small>
				<select class="select cms_CategorySortFilter" name="" id="">
					<option value="" <?php if($sorting==''){echo 'selected';}?> ><?php echo $language["productView"][4]; //----- ?></option>
					<option value="asc" <?php if($sorting=='asc'){echo 'selected';}?>><?php echo $language["productView"][5]; //Cena rastuća ?></option>
					<option value="desc" <?php if($sorting=='desc'){echo 'selected';}?>><?php echo $language["productView"][6]; //Cena padajuća ?></option>
				</select>
			</li>
			<!--SORT END -->
			
            <!--ITEMS -->
			<li class="items">
            	<small class="text"><?php echo $language["productView"][11]; //Ukupno ?></small>
                <span><?php if(isset($prodata[0])) echo $prodata[0]; ?></span>
            </li>
            <li class="items">
				<?php 
				$limit='';
				if(isset($_GET['limit'])){ 
					$limit = $_GET['limit'];
				}
				?>
				<small class="text"><?php echo $language["productView"][7]; //Prikaži po stranici ?></small>
				<select class="select cms_CategoryLimitFilter" name="" id="">
					<option value="<?php echo $user_conf["product_per_page"][1]?>" <?php if($limit==$user_conf["product_per_page"][1]){echo 'selected';}?>><?php echo $user_conf["product_per_page"][1]?></option>
					<option value="20" <?php if($limit=='20'){echo 'selected';}?>>20</option>
					<option value="50" <?php if($limit=='50'){echo 'selected';}?>>50</option>
					<option value="100"<?php if($limit=='100'){echo 'selected';}?>>100</option>
				</select>
			</li>
			<!--ITEMS END-->
			<!--VIEW TYPE -->
			<?php if(!isset($_SESSION['type']) || $_SESSION['type']!='commerc') {?>
			<li class="items">
				<small class="text"><?php echo $language["productView"][8]; //Prikaz ?></small>
				<form action="" method="post">
					<button name="changeviewtype" value="1" class="display prikazBTN <?php if(isset($_SESSION['viewtype']) && $_SESSION['viewtype']==1){echo 'active'; }?>"><i class="material-icons">view_module</i></button>
					<?php if(isset($_SESSION['type']) && $_SESSION['type']=='partner'){ ?>
					<button name="changeviewtype" value="3" class="display prikazBTN <?php if(isset($_SESSION['viewtype']) && $_SESSION['viewtype']==3){echo 'active'; }?>"><i class="material-icons">reorder</i></button>
					<?php } else { ?>
					<button name="changeviewtype" value="2" class="display prikazBTN <?php if(isset($_SESSION['viewtype']) && $_SESSION['viewtype']==2){echo 'active'; }?>"><i class="material-icons">reorder</i></button>
					<?php } ?>
				</form>
			</li>
		<?php } ?>
			<!--VIEW TYPE END -->
			<?php if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged" && isset($_SESSION["shoptype"]) && $_SESSION["shoptype"]=="b2b" && $user_conf["download_category_pricelist"][1]==1){?>
			<li class="items">
				<small class="text"><?php echo $language["productView"][10]; //Download cenovnika ?></small>
				<button name="exportCategoryPriceList" class="display cms_exportCategoryPriceListBTN "><i class="material-icons">get_app</i></button>
			</li>
			<?php } ?>
		</ul>
	</div>