<section>
	<div class="container">
		<div class="row">
			<div class="col-12">
				
				<?php include("app/controller/controller_topslider.php");?>
                <section class="banner-product">
                 
                <!-- <div class="container"> -->
                    <!-- <div class="row"> -->
                        <!-- <div class="col-md-9 col-md-push-3"> -->
                        <!-- EDD DATA -->

                    <?php foreach($eddata AS $eddval){ ?>
                    <?php if(isset($eddval["productdata"]) && count($eddval["productdata"][1])>3) {?>
                        <h4 class="marginBottom30 after index-slider-title"><?php echo $eddval["name"]; ?></h4>
                        <?php if(isset($eddval["banerdata"]) && count($eddval["banerdata"])>0) {?>
                        <!-- <div class="row noMargin">
                            <div class="col-md-12 col-seter">
                            <div class=""><!-- class="extradetail_baner" -->
                                <!-- <?php echo $eddval["banerdata"][0]["banervalue"]; ?>     -->
                            <!-- </div> -->
                            <!-- </div> -->
                        <!-- </div> --> 
                        <?php } ?>
                        <div class="row noMargin">
                            
                                <?php foreach($eddval["productdata"][1] as $val){ ?>
                                    <div class="col-sm-3 col-xs-6 col-seter">
                                    <?php include($system_conf["theme_path"][1]."views/includes/productbox/xsProductBox3.php");?>
                                    </div>
                                <?php } ?>
                            
                        </div>


                    <?php   } ?>
                    <?php } ?>
                    <!-- EDD DATA END-->




                <!-- SALE PRODUCT SEGMENT START -->
                <?php if($theme_conf["show_action_product_slider"][1]==1){ ?>
                    <?php include("app/controller/controller_sale_product_segment.php");?>
                <?php } ?>
                <!-- SALE PRODUCT SEGMENT END -->
               
                 <!-- <div class="wide-banners">
                    <ul class="list">
                        <li class="items">
                            <a href="" class="links">
                                <img src="fajlovi/theme/wide-banner1.jpg" alt="" class="img-responsive image">
                            </a>
                        </li>
                    </ul>
                </div> -->
                <!-- TOP PRODUCT SEGMENT START -->
                <?php //include("app/controller/controller_top_product_segment.php");?>
                <!-- TOP PRODUCT SEGMENT END -->
                <!-- <div class="wide-banners">
                    <ul class="list">
                        <li class="items">
                            <a href="" class="links">
                                <img src="fajlovi/theme/wide-banner1.jpg" alt="" class="img-responsive image">
                            </a>
                        </li>
                    </ul>
                </div> -->
                <!-- NEW PRODUCT SEGMENT START -->
                <?php //include("app/controller/controller_new_product_segment.php");?>
                <!-- NEW PRODUCT SEGMENT END -->
                <!-- </div> -->
                <!-- <div class="col-md-3 col-md-pull-9">
                    <?php // include_once("app/controller/controller_banner_left.php");?>
                </div> -->
                    <!-- </div> -->
                <!-- </div> -->
                </section>
			</div>
            
		</div>
		<!-- BRAND SLIDER START -->
                <h3 class="brand-slider-title after text-center"><?php echo $language["pocetna"][1]; //Brendovi u nasoj ponudi?></h3>
                <?php include("app/controller/controller_brendSlider.php");?>
                <!-- BRAND SLIDER END --> 
	</div>
</section>
   
<section >
    <!-- INFO PANEL -->
        <div class="container">
        <div class="info-baner-holder hidden-sm hidden-xs">
            <div class="row _unmargin">
                <div class="col-sm-4 col-xs-6 info-baner col-seter ">
                    <a href="<?php echo $theme_conf["hero_menu_link_1"][1]; // hero menu link 1?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_1"][1], 'small'); // hero menu image 1 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][1]; // Besplatna dostava ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 col-xs-6 info-baner col-seter">
                    <a href="<?php echo $theme_conf["hero_menu_link_2"][1]; // hero menu link 2?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_2"][1], 'small'); // hero menu image 2 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][2]; // kako kupiti ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6 info-baner col-seter hide">
                    <a href="<?php echo $theme_conf["hero_menu_link_3"][1]; // hero menu link 3?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_3"][1], 'small'); // hero menu image 3 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][3]; // Kolicinski popust ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 col-xs-6 info-baner col-seter">
                    <a href="<?php echo $theme_conf["hero_menu_link_4"][1]; // hero menu link 4?>">
                        <img src="<?php echo GlobalHelper::getImage($theme_conf["hero_menu_image_4"][1], 'small'); // hero menu image 4 ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive">
                        <div class="text-holder">
                            <p class="text"><?php echo $language["hero_menu_text"][4]; // Bezbedna kupovina ?></p>
                            <a href="" class="links"><?php echo $language["hero_menu_text"][5]; // Saznaj vise ?></a>
                        </div>
                    </a>
                </div> 
            </div>
        </div>
    </div>              
    <!-- INFO PANEL END -->
    <div class="container hide">
            <div class="content-page" style="padding: 20px 0;">

               <div class="row">
                <?php if($theme_conf["show_leftpanel_on_indexpage"][1]==1){
                         include($system_conf["theme_path"][1]."views/includes/shop/leftPanelOnIndexPage.php");
                }?>
                
                <?php if($theme_conf["show_leftpanel_on_indexpage"][1]==1){ ?>
                <div class="col-md-9">
                <?php } else { ?>
                <div class="col-md-12">
                <?php } ?>
                   
                    <?php if($theme_conf["show_action_product_slider"][1]==1){ ?>
                        <?php include("app/controller/controller_actionProductSlider.php");?>
                    <?php } ?>
                    <!-- BRAND SLIDER -->
                    <?php include("app/controller/controller_brendSlider.php");?>
                    <!-- BRAND SLIDER END -->
                    <!-- TOP PRODUCTS -->
                    <?php include("app/controller/controller_topProductSlider.php");?>
                    <!-- TOP PRODUCTS END-->
                    <!-- NEW PRODUCTS -->
                    <?php include("app/controller/controller_newProductSlider.php");?>
                    <!-- NEW PRODUCTS END-->
                </div>
                </div> 
            </div>
        
    </div>
</section>
