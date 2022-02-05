
<div class="header-fixed navbar-fixed-top hidden-xs hidden-sm">
<?php if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged" && isset($_SESSION["type"]) && $_SESSION["type"]=="commerc"){?>
<?php 	include('app/controller/core/controller_header_commercialist_bar.php');?>
<?php } ?><!-- header-fixed-top -->
	<div class="top-menu nfixed_help8 hide">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 top-menu-col">
					<ul class="top-menu-left-ul" >
						<?php  foreach($headermenudata AS $hval){ ?>
							<?php  if($hval['menutype']=='s'){ ?>
								<li><a href="<?php  echo $hval['link'];?>" itemprop="url"><?php  echo $hval['value'];?></a></li>
							<?php  } ?>
						<?php  } ?>
						
					</ul>
				</div>
				<div class="col-xs-6 top-menu-col">
					<ul class="top-menu-right-ul go-right">
						<li><a class="search"><img src="<?php echo $system_conf["theme_path"][1];?>img/icons/loupe.png" alt="icon softart" class="img-responsive visible-xs"></a></li>
						<!--<li><a href="zelja.php"><img src="views/theme/img/icons/like.png" alt="icon softart" class="img-responsive" title="Lista želja"></a></li>-->
						
						<li><a href="korpa" id="korpa" class="korpa-head pos cms_smallShopcartHolder">
								<img src="<?php echo  $system_conf["theme_path"][1].$theme_conf["shopchart"][1]; ?>" alt="<?php echo $language["global"][8]; //Korpa ?>" class="img-responsive" title="<?php echo $language["global"][8]; //Korpa ?>">
								<span class="jq_smallShopcartCount smallShopcartCount myspan-car cms_smallShopcartCount"></span>
							</a>
                            <div class="cart-slide hidden-xs">
                                <div class="cart-slide-body ">
								
									<i class="fa fa-refresh fa-spin cms_smallShopcartSpiner" style="font-size:24px"></i>
									<div class="cms_smallShopcartItemCont hide">
                                   		<div class="cart-slide-item clearfix">
                                        <i class="fa fa-times-circle-o cart-slide-close" aria-hidden="true" title="Izbacite proizvod"></i>
                                        <a href="">
                                        <div class="cart-slide-pic">
                                                <img src="<?php echo $system_conf["theme_path"][1];?>img/prod3.jpg" alt="item" class="img-responsive cart-slide-img">
                                        </div>
                                        </a>
                                        <div class="cart-slide-name">
                                            <a href="">
                                                <p>Ime proizvoda ime proizvoda u dva reda test test test proizvod</p>
                                            </a>
                                            <ul class="cart-slide-attr-ul cms_smallShopcartAttrCont">
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Boja:</small> <small>Crvena ;</small></li>
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Boja:</small><div class="cart-slide-attr-box"></div> ;</li>
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Boja:</small><div class="cart-slide-attr-bckg" style="background-image: url('img/pat.jpg');"></div> ;</li>
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Snaga:</small> <small>23456 ;</small></li>
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Velicina:</small> <small>XXXL ;</small></li>
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Velicina:</small> <small>XXXL ;</small></li>
                                                <li class="cart-slide-attr-li"><small class="cart-slide-attr-name">Velicina:</small> <small>XXXL ;</small></li>
                                                

                                            </ul>
                                        </div>
                                        <div class="cart-slide-amount">
                                            <p class="cart-slide-price">200.000 din.</p>
                                            <form action="" method="">
                                                <button class="minus-btn">-</button>
                                                <input type="number" value="1">
                                                <button class="plus-btn">+</button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                    </div>

                                </div>
                                <div class="cart-slide-total clearfix">
                                    <p class="go-left"><span>Za uplatu:</span> <span class="cms_smallShopcartTotalPDV font-weight-bold"></span> <span>din.</span></p>
                                    <a href="korpa"><button class="btn myBtn go-right">Završi kupovinu</button></a>
                                </div>
                            </div>
                        </li>
						<?php if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged') {?>
						<li ><a href="userpanel"  title="<?php echo $language["header"][1];?>" ><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["user"][1]; ?>" alt="" class="img-responsive"> <span><?php echo $_SESSION['ime']." ".$_SESSION['prezime'] ?></span> </a></li>
						<li ><a  id="signOutMenu" title="<?php echo $language["header"][1];?>" ><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["logout"][1]; ?>" alt="<?php echo $language["header"][1];?>" class="img-responsive"> </a></li>
					<?php } else { ?>
						<li ><a type="button" data-toggle="modal" data-target=".bs-example-modal-sm" itemprop="url" title="<?php echo $language["header"][2];?>" ><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["login"][1]; ?>" alt="<?php echo $language["header"][2]; // Prijavite se?>" class="img-responsive"> </a></li>
					<?php }  ?>
					</ul>
					<select name="changeLanguage"  class="go-right mil-lang cms_selectLanguage hide">
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
				</div>
			</div>
		</div>
	</div>
	<div class="menu-fixed-holder">
		<div class="container">
			<div class="row flex-align">
				<div class="col-md-3 col-sm-2">
					<div class="logo-holder nfixed_help2" itemscope itemtype ="http://schema.org/logo">
						<a href="pocetna"><img itemprop="ImageObject" src="<?php echo $user_conf["sitelogo"][1];?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"></a>
					</div>
				</div>
				<div class="col-md-2 col-sm-3 hide">
					<div class="navigation-holder nfixed_help">
						<nav class="navigation">
							<ul class="nav-ul">
						<?php foreach($topmenudata as $key=>$val){ ?>
						<?php $act = '';
							  if($command[0] == $val['baselink']) $act = 'active';
						?>
						<?php if($val['menutype']=='catfw'){ ?>
						
                            <li class="nav-li main-drop-triger pos nfixed_help3" itemprop="name"><a href="shop" itemprop="url"><?php echo $val['value']; ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <div class="main-drop nfixed_help4">
                                    <ul class="main-drop-ul">
										<?php foreach($catcont as $key=>$cval){ ?>
											
										<?php if(count($cval["catchilds"])>0) { ?>
										 <li class="main-drop-li" itemprop="name"><a href="<?php echo rawurlencode($cval['catname']); ?>" class="main-drop-a" itemprop="url"><?php echo $cval['catname']; ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                            <div class="sec-drop nfixed_help9">
                                                <div class="row">
													
												<?php foreach($cval["catchilds"] as $kcc=>$ccval){ ?>
													<div class="col-sm-4">
                                                        <ul class="sec-drop-ul">
													<?php if(count($ccval["catchilds"])>0) { ?>
															<li class="sec-drop-li nfixed_help11" itemprop="name"><a href="<?php echo rawurlencode($cval['catname']).'/'.rawurlencode($ccval['name']); ?>" class="soc-drop-a1" itemprop="url"><img src="<?php echo GlobalHelper::getImage(rawurldecode($ccval['catimage']), 'small'); ?>" alt="softart icon" class="img-responsive "><?php echo $ccval['name']; ?></a>
																<hr style="border-top:1px solid transparent;">
																<?php foreach($ccval["catchilds"] as $kccc=>$cccval) { ?>
																		<a href="<?php echo rawurlencode($cval['catname']).'/'.rawurlencode($ccval['name'])."/".rawurlencode($cccval['name']); ?>" class="soc-drop-a2" itemprop="url"><?php echo $cccval['name']; ?> </a>
																<?php }?>
																<hr>
															</li>
													
													<?php } else {?>
															<li class="sec-drop-li nfixed_help11" itemprop="name"><a href="<?php echo rawurlencode($cval['catname']).'/'.rawurlencode($ccval['name']); ?>" class="soc-drop-a1" itemprop="url"><img src="<?php echo GlobalHelper::getImage(rawurldecode($ccval['catimage']), 'small'); ?>" alt="softart icon" class="img-responsive "><?php echo $ccval['name']; ?></a><hr></li>
													
													<?php } ?>
														</ul>
                                                    </div>
												<?php } ?>	
												</div>
                                            </div>
                                        </li>	
										<?php } else { ?>
											<li class="main-drop-li" itemprop="name"><a href="<?php echo rawurlencode($catval['catname']); ?>" class="main-drop-a" itemprop="url"><?php echo $cval['catname']; ?> </a></li>
										<?php } ?>
										<?php } ?>
                                    </ul>
                                </div> 
                            </li>
							<?php } ?>
						<?php } ?>
		
							</ul>
						</nav>
					</div>

				</div>
				<div class="col-md-6 col-sm-7">
					<div class="my-main-menu nfixed_help5">
						<form action="pretraga" role="search" autocomplete="off" method="get" name="<?php echo $language["topmenu"][1];?>" class="mySearch-form nfixed_help6 hidden-xs">
                    		
                    		<select name="" id="" class="mySearch-select nfixed_help10">
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
                    		<input class="nfixed_help7"  name="q" type="text" id="mySearch-input" placeholder="<?php echo $language["topmenu"][1];?>..." autocomplete="off" value="<?php if(isset($_GET["q"]) && strlen($_GET["q"])>0){ echo $_GET["q"]; }?>">
                    		<button class="btn myBtn mySearch-button"><?php // echo $language["topmenu"][3];?><i class="material-icons">search</i></button>
                    		<a class="btn myBtn advanced search hide"><?php echo $language["topmenu"][4];?></a>
                		</form>
					</div>
					
				</div>
				<div class="col-sm-3">
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
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["shopchart"][1]; ?>" alt="<?php echo $language["global"][8]; //Korpa ?>" class="img-responsive" title="<?php echo $language["global"][8]; //Korpa ?>">
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
								<a id="signOutMenu" title="<?php  echo $language["header"][3];?>" > <?php  echo $language["header"][3];?> </a>
							</div>
						</li>
						<?php } else { ?>
						<li>
							<a data-toggle="modal" data-target=".bs-example-modal-sm">
								<img src="<?php echo $system_conf["theme_path"][1].$theme_conf["user"][1]; ?>" alt="<?php  echo $language["header"][4]; //Prijavi se?>" class="img-responsive" title="<?php  echo $language["header"][4]; //Prijavi se?>">
								<span class="user-name"><?php  echo $language["header"][4]; //Prijavi se?></span>
							</a>
						</li>
						<?php }?>
						<!-- login end -->
                    </ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- .header-fixed-top -->