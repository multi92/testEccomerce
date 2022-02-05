

<div class="my-main-menu">
        <div class="container header-container">
            <div class="row flex-align">
				
				<div class="col-xs-4 visible-xs">
					<div id="jq_leftMenuTrigger2" class="small-products-button">
						<i class="material-icons icons">apps</i>&nbsp;proizvodi
					</div>
				</div>

				<div class="col-xs-8 col-sm-3 col-md-4 col-lg-3 main-menu-col">
					<div class="logo-holder" itemscope itemtype ="http://schema.org/logo">
					<a href="pocetna"><img itemprop="ImageObject" src="<?php echo $user_conf["sitelogo"][1];?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"></a>
                    </div>
                </div>

                <!-- <div class="col-sm-3 col-md-4 col-xs-8 main-menu-col"> -->
                    <!-- <div class="logo-holder" itemscope itemtype ="http://schema.org/logo"> -->
					<!-- <a href="pocetna"><img itemprop="ImageObject" src="<?php echo $user_conf["sitelogo"][1];?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"></a> -->
                    <!-- </div>
                </div> -->
				
                <div class="col-sm-6 col-md-5 col-xs-2 main-menu-col  pos">
					<!-- SEARCH -->
                    <form class="mySearch-form hidden-xs" action="pretraga" role="search" autocomplete="off" method="get" name="<?php echo $language["topmenu"][1];?>">
                        
						
						<?php if($theme_conf["search_box_with_categories"][1]==1) {?>
                        <select name="cat" id="cat" class="mySearch-select" >
							<option value="0"><?php echo $language["topmenu"][2];?></option>
							<?php
							$searchcatid =0;
							if(isset($_GET['cat']) && $_GET['cat'] != ""){
								$searchcatid = $_GET['cat'];	
							} 
							?>
							<?php foreach($catcont as $key=>$catval){ ?>
							<?php 
								$sel='';
								//echo $searchcatid.'='.$catval['catid'];
								if(isset($searchcatid) && ($searchcatid==$catval['catid']) ){
									$sel='selected';
								}
							?>
							<option value="<?php echo $catval['catid'];?>" <?php echo $sel;?> ><?php echo $catval['catname'];?></option>
							<?php } ?>                       
                        </select>
						<?php } ?>
						<input name="q" type="text" id="mySearch-input1" placeholder="<?php echo $language["topmenu"][1];?>..." autocomplete="off" value="<?php  if(isset($_GET["q"]) && strlen($_GET["q"])>0){ echo $_GET["q"]; }?>">
                        
	                        <ul class="qSearchCont" style="display: none;"></ul>
                        
                        <button class="btn myBtn mySearch-button"><?php // echo $language["topmenu"][3];?><i class="material-icons">search</i></button>
                        <a class="btn myBtn advanced search "><?php echo $language["topmenu"][4];?></a>
                    </form>
                    <ul class="cont-list hidden-sm hidden-xs hide">
						<li class="items">
							<span class="static"><?php // echo $language["header"][6]; //Telefon?> <i class="material-icons icons">phone</i></span> 
							<a href="tel:<?php echo $user_conf["phone"][1];?>"><span class="dinamic"><?php echo $user_conf["phone"][1];?></span></a>
						</li>
						<li class="items">
							<span class="static"><?php // echo $language["header"][7]; //Email?> <i class="material-icons icons">email</i></span>
							<a href="mailto:<?php echo $user_conf["contact_address"][1];?>"><span class="dinamic"><?php echo $user_conf["contact_address"][1];?></span></a>
						</li>
					</ul>
					<!-- SEARCH END -->
                    <!-- small navigation -->
                    <div class="burger visible-xs go-right">
                        <div class="burger1"></div>
                        <div class="burger2"></div>
                        <div class="burger3"></div>
                    </div>
                    <!-- .small navigation -->
                </div>
				
				<div class="col-sm-3 col-md-3 hidden-sm hidden-xs">
					<ul class="cart-list">
                        <?php if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged') {?>
						<li class="cms_wishlistButton">
							
							<a >
								<?php  if(isset($_SESSION['wishlist']) && count($_SESSION['wishlist']) > 0) {?>
								<span class="wish-count"><?php echo count($_SESSION['wishlist']);?></span>
							<?php } else {?>
								<span class="wish-count">0</span>
							<?php }?>
								<!-- <img src="<?php // echo $system_conf["theme_path"][1].$theme_conf["wishlist"][1]; ?>" alt="<?php // echo $language["global"][7]; //Lista želja ?>" class="img-responsive -wishlist" title="<?php // echo $language["global"][7]; //Lista želja ?>"> -->
								<!-- icons -->
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["wishlist"][1]; ?>" class="img-responsive" title="<?php  echo $language["header"][8]; //Lista zelja?>">
								<!-- icons end -->
								<span class="wish-name _hidden-mob"><?php  echo $language["header"][8]; //Lista zelja?></span>
							</a>
							
						</li>
					<?php } else { ?>
						<li>
							<a data-toggle="modal" data-target=".bs-example-modal-sm">
							<span class="wish-count">0</span>
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["wishlist"][1]; ?>" class="img-responsive" title="<?php  echo $language["header"][8]; //Lista zelja?>">
								<span class="wish-name _hidden-mob"><?php  echo $language["header"][8]; //Lista zelja?></span>
							</a>
						</li>
					<?php }?>
						<li>
							<a href="korpa" id="korpa" class="korpa-head cms_smallShopcartHolder">
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["shopchart"][1]; ?>" alt="<?php echo $language["global"][8]; //Korpa ?>" class="cart-img img-responsive" title="<?php echo $language["global"][8]; //Korpa ?>">
								<span class="cms_shopcartCount  myspan-car "><?php if(isset($_SESSION['shopcart'])){echo OrderingHelper::GetCartCount()+OrderingHelper::GetCartRequestCount();} else {echo '0';} ?></span>
								<?php $hideShopcartRequest='hide'; ?>
								<?php if(isset($_SESSION['shopcart_request']) && count($_SESSION['shopcart_request'])>0){ 
									$hideShopcartRequest=''; 
								}?>
								<span class="cart-name"><?php echo $language["global"][8]; //Korpa ?></span>
							</a>
							<!-- <a href="korpa" id="korpa" class="korpa-head cms_smallShopcartHolder hide">
								<i class="material-icons icons cms_shopcartRequestIcon <?php //echo $hideShopcartRequest;?>">insert_comment</i>
								<span class="cms_shopcartRequestCount myspan-car <?php //echo $hideShopcartRequest;?>"><?php //if(isset($_SESSION['shopcart_request'])){echo OrderingHelper::GetCartRequestCount();} else {echo '0';} ?></span>
							</a> -->

						</li>
						<!-- login start -->
						<?php if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged"){?>

						<?php if(isset($_SESSION["type"]) && $_SESSION["type"]=="commerc"){?>
							<!-- <li ><a href="commercialist_select_partner"  ><i class="material-icons" style="font-size: 18px;vertical-align: middle; padding-left:3px;">group</i></a></li> -->
						<?php } ?>
						
						<li class="is-loggedin">
							<a href="userpanel" >
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["user"][1]; ?>" alt="<?php echo $language["header"][1];?>" class="img-responsive" title="<?php  echo $language["header"][1];?>">
								<span class="user-name"><?php echo $_SESSION['ime']; ?></span>
							</a>
							<div class="signout-drop">
								<a class="signOutMenu" title="<?php  echo $language["header"][3];?>" > <?php  echo $language["header"][3];?> </a>
							</div>
						</li>
						<?php } else { ?>
						<li>
							<a data-toggle="modal" data-target=".bs-example-modal-sm">
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["user"][1]; ?>" alt="<?php  echo $language["topmenu"][14]; //Prijavi se?>" class="img-responsive" title="<?php  echo $language["topmenu"][14]; //Prijavi se?>">
								<span class="user-name"><?php  echo $language["topmenu"][14]; //Prijavi se?></span>
							</a>
						</li>
						<?php }?>
						<!-- login end -->
                    </ul>
				</div>
            </div>
        </div>
</div>
 <div class="navigation-holder hidden-xs bckg-primary">
        <div class="container bckg-primary">
            <div class="row bckg-primary">
                <div class="col-md-12">
                    <nav class="navigation" itemscope itemtype ="http://schema.org/SiteNavigationElement">
                        <ul class="nav-ul">
                        <?php if(!isset($_SESSION["loginstatus"]) || $_SESSION["loginstatus"]!="logged"){?>
							<!-- <li class="nav-li hidden-sm hidden-xs"><a href="b2blogin">B2B</a></li> -->
						<?php }?>
						<li class="nav-li hidden-sm hidden-xs"><a href="shop">ONLINE SHOP - PROIZVODI</a></li>
						<li class="nav-li visible-sm sm-menu-trigger hidden-xs" id="jq_leftMenuTrigger"><a><?php echo $val['value']; ?> PROIZVODI <i class="material-icons icons">apps</i></a></li>
						<?php foreach($topmenudata as $key=>$val){ ?>
						<?php $act = '';
							  if($command[0] == $val['baselink']) $act = 'active';
						?>
						<?php if($val['menutype']=='s'){ ?>
								<li class="nav-li"><a href="<?php echo $val['link']; ?>"    ><?php echo $val['value']; ?></a></li>
						<?php } ?>
						<?php if($val['menutype']=='sdd'){ ?>
								<li class="nav-li last-laptop"  ><a><?php echo $val['value']; ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
									<div class="nav-main-drop">
										<ul class="nav-main-drop-ul">
										<?php foreach($val["childs"] as $cval){ ?>
											<li class="nav-main-drop-li"  ><a href="<?php echo $cval['baselink']; ?>"  ><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $cval['value']; ?></a></li>
										<?php } ?>
										</ul>
									</div> 
								</li>
						<?php } ?>
						<?php // if($val['menutype']=='catfw'){ ?>
							
                            
                            
							<?php // } ?>
						<?php } ?>
						<li class="nav-li distributer hide"><span>Ovlašćeni distributer </span><img src="fajlovi/brendovi/makita150x30.jpg" alt=""></li>
                        </ul>
                        <div>
                        <!-- <select name="changeCurrency"  class=" mil-lang cms_selectCurrency hide">
							<?php 
								$db = Database::getInstance();
								$mysqli = $db->getConnection();
								$mysqli->set_charset("utf8");

								$q = "SELECT * FROM currency ORDER BY `primary` ASC";
								$res = $mysqli->query($q);
								if($res->num_rows > 0){
									while($row = $res->fetch_assoc())
								{
									$selected='';
								if($_SESSION["currencyid"]==$row['id']){
									$selected='selected';
								}
							echo '<option  value="'.$row['id'].'" currencyid="'.$row['id'].'" '.$selected.'>'.ucfirst($row["code"]).'</option>';

								}
							}
							?> 
						</select>
                        <select name="changeLanguage"  class=" mil-lang cms_selectLanguage">
							<?php 
								$db = Database::getInstance();
								$mysqli = $db->getConnection();
								$mysqli->set_charset("utf8");

								$q = "SELECT * FROM languages ORDER BY `default` ASC";
								$res = $mysqli->query($q);
								if($res->num_rows > 0){
									while($row = $res->fetch_assoc())
								{
									$selected='';
								if($_SESSION["langid"]==$row['id']){
									$selected='selected';
								}
							echo '<option  value="'.$row['id'].'" langid="'.$row['id'].'" '.$selected.'>'.ucfirst($row["name"]).'</option>';

								}
							}
							?> 
						</select> -->
						</div>
                    </nav>
                </div>
            </div>
        </div>
</div>
<!-- small menu -->
<div class="menu" >
        <ul class="list">
		<?php foreach($topmenudata as $key=>$val){ ?>
			<?php if($val['menutype']=='s'){ ?>
				<li class="items">
					<a  class="links" href="<?php echo $val['link']; ?>"  >
						<?php echo $val['value']; ?>
					</a>
				</li>
			<?php } ?>
			<?php if($val['menutype']=='sdd'){ ?>
				<li class="items">
					<a class="links"> 
						<?php echo $val['value']; ?>  
					</a>
					<i class="fa fa-angle-down" aria-hidden="true"></i>
					<div class="dropdown-small">
						<ul class="list">
							<?php foreach($val["childs"] as $cval){ ?>
								<li class="items"><a href="<?php echo $cval['baselink']; ?>" class="links"><?php echo $cval['value']; ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</li>
			<?php } ?>
			<?php if($val['menutype']=='catfw'){ ?>
				<li class="items">
					<a class="links" href="<?php echo $val['link']; ?>"  >
						<?php echo $val['value']; ?>
					</a>
				</li>
			<?php } ?>
		<?php } ?>

		<?php foreach($headermenudata AS $hval){ ?>
						<?php if($hval['menutype']=='s'){ ?>
							<li class="items">
								<a class="links" href="<?php echo $hval['link'];?>" 
									><?php echo $hval['value'];?>
										
									</a>
							</li>
						<?php } ?>
		<?php } ?>
		<li class="items hide">
			<select name="changeCurrency"  class="go-right mil-lang cms_selectCurrency">
							<?php 
								$db = Database::getInstance();
								$mysqli = $db->getConnection();
								$mysqli->set_charset("utf8");

								$q = "SELECT * FROM currency ORDER BY `primary` ASC";
								$res = $mysqli->query($q);
								if($res->num_rows > 0){
									while($row = $res->fetch_assoc())
								{
									$selected='';
								if($_SESSION["currencyid"]==$row['id']){
									$selected='selected';
								}
							echo '<option  value="'.$row['id'].'" currencyid="'.$row['id'].'" '.$selected.'>'.ucfirst($row["code"]).'</option>';

								}
							}
							?> 
						</select>
		</li>
		<li class="items hide">
			<select name="changeLanguage"  class="go-right mil-lang cms_selectLanguage">
							<?php 
								$db = Database::getInstance();
								$mysqli = $db->getConnection();
								$mysqli->set_charset("utf8");

								$q = "SELECT * FROM languages ORDER BY `default` ASC";
								$res = $mysqli->query($q);
								if($res->num_rows > 0){
									while($row = $res->fetch_assoc())
								{
									$selected='';
								if($_SESSION["langid"]==$row['id']){
									$selected='selected';
								}
							echo '<option  value="'.$row['id'].'" langid="'.$row['id'].'" '.$selected.'>'.ucfirst($row["name"]).'</option>';

								}
							}
							?> 
						</select>
		</li>
        </ul>
</div>
<!-- .small menu -->
<?php include($system_conf["theme_path"][1]."views/includes/header-fixed.php");?>

<div class="distributer-xs text-center hide">
	<span>Ovlašćeni distributer </span><img src="fajlovi/brendovi/makita150x30.jpg" alt="">
</div>