<?php $i=0; if(isset($_SESSION['compare']) && count($_SESSION['compare'])>0){ ?>
<div class="new-compare-holder">
    <div class="wrap">
        <div class="wrap-calc">
            <?php    foreach($_SESSION['compare'] as $key=>$val){ $i++;?>
                <div class="new-compare-box -active jq_compareItemCont" productid = "<?php echo $val[0]; ?>">
                    <span class="position-index"><?php echo $i; ?>.</span>
                    <div class="new-compare-image-holder" title="">
                        <img src="<?php echo GlobalHelper::getImage('fajlovi/product/'.$val[1], 'thumb')?>" alt="" class="image">
                    </div>
                    <?php include_once("app/class/Product.php") ;?>

                    <?php $compareProductData=array() ;?>
                    <?php $compareProductData=Product::getProductDataById($val[0]) ;?>
                    <span class="new-compare-name"><?php echo $compareProductData['name']; ?></span>
                    <a class="new-remove-compare jq_removeFromCompareButton"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>    
            <?php }?>
            <?php for ($x = 1; $x <= (4-$i); $x++) {  ?>
                <div class="new-compare-box">
                    <span class="position-index"><?php echo $i+$x; ?>.</span> 
                </div>
            <?php }?>

            <div class="new-compare-btns">
                <button class="sa-button -compare compareButton"><?php echo $language["bottom_compare"][1]; //Uporedi proizvode ?></button>
                <button class="btn -delete cms_removeAllFromCompareButton"><?php echo $language["bottom_compare"][2]; //Ukloni sve proizvode?></button>
            </div>
        </div>
    </div>
</div>

<?php } ?>

<div class="bottom-menu visible-sm visible-xs">
  <ul class="cart-list">
    <?php if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged') {?>
    <li class="cms_wishlistButton">
      <a>
        <?php  if(isset($_SESSION['wishlist']) && count($_SESSION['wishlist']) > 0) {?>
        <span class="wish-count -bottom"><?php echo count($_SESSION['wishlist']);?></span>
        <?php } else {?>
        <span class="wish-count -bottom">0</span>
        <?php }?>
        <!-- <img src="<?php // echo $system_conf["theme_path"][1].$theme_conf["wishlist"][1]; ?>" alt="<?php // echo $language["global"][7]; //Lista želja ?>" class="img-responsive -wishlist" title="<?php // echo $language["global"][7]; //Lista želja ?>"> -->
        <!-- icons -->
        <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["wishlist-bottom"][1]; ?>" class="img-responsive" title="<?php  echo $language["header"][8]; //Lista zelja?>">
        <!-- icons end -->
        <span class="wish-name -bottom"><?php  echo $language["header"][8]; //Lista zelja?></span>
      </a>
    </li>
    <?php } else { ?>
    <li>
      <a data-toggle="modal" data-target=".bs-example-modal-sm">
        <span class="wish-count -bottom">0</span>
        <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["wishlist-bottom"][1]; ?>" class="img-responsive" title="<?php  echo $language["header"][8]; //Lista zelja?>">
        <span class="wish-name -bottom"><?php  echo $language["header"][8]; //Lista zelja?></span>
      </a>
    </li>
    <?php }?>
    <li>
      <a href="korpa" id="korpa" class="korpa-head cms_smallShopcartHolder">
        <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["shopchart-bottom"][1]; ?>" alt="<?php echo $language["global"][8]; //Korpa ?>" class="img-responsive" title="<?php echo $language["global"][8]; //Korpa ?>">
        <span class="cms_shopcartCount  myspan-car -bottom"><?php if(isset($_SESSION['shopcart'])){echo OrderingHelper::GetCartCount()+OrderingHelper::GetCartRequestCount();} else {echo '0';} ?></span>
        <?php $hideShopcartRequest='hide'; ?>
        <?php if(isset($_SESSION['shopcart_request']) && count($_SESSION['shopcart_request'])>0){ 
              $hideShopcartRequest=''; 
        }?>
        <span class="cart-name -bottom"><?php echo $language["global"][8]; //Korpa ?></span>
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
          <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["user-bottom"][1]; ?>" alt="<?php echo $language["header"][1];?>" class="img-responsive" title="<?php  echo $language["header"][1];?>">
          <span class="user-name -bottom"><?php echo $_SESSION['ime']; ?></span>
        </a>
        <div class="signout-drop hide">
            <a id="signOutMenu" title="<?php  echo $language["header"][3];?>" > <?php  echo $language["header"][3];?> </a>
        </div>
    </li>
    <?php } else { ?>
    <li>
      <a data-toggle="modal" data-target=".bs-example-modal-sm">
        <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["user-bottom"][1]; ?>" alt="<?php  echo $language["header"][4]; //Prijavi se?>" class="img-responsive" title="<?php  echo $language["header"][4]; //Prijavi se?>">
        <span class="user-name -bottom"><?php  echo $language["header"][4]; //Prijavi se?></span>
      </a>
    </li>
    <?php }?>
    <!-- login end -->
    <li>
      <a class="advanced search">
        <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["search-bottom"][1]; ?>" class="img-responsive" title="Pretrazi">
      </a>
    </li>
    <?php if(isset($_SESSION["loginstatus"]) && $_SESSION["loginstatus"]=="logged"){?>
     <li class="">

            <a   title="<?php  echo $language["header"][3];?>" > <img src="<?php echo $system_conf["theme_path"][1].$theme_conf["logout"][1]; ?>" alt="<?php echo $language["header"][1];?>" class="img-responsive signOutMenu"> 
              <span class="cart-name -bottom"><?php  echo $language["header"][3];?></span>
            </a>

    </li>
    <?php }?>
  </ul>
</div>



<footer>
<!-- <footer style="background-image: url('<?php // echo  $theme_conf["footer_background"][1]; ?>');"> -->
    <div class="bg-dark footer-filter"></div>
    <div class="container no-bckg">
      <div class="row">
          <!-- newsletter -->
          <div class="col-xs-12  footer-links newsletter-foo">
            <h4><?php echo $language["newsletter"][5]; //Želite da najbolje ponude stižu direktno u vaš inbox? ?></h4>
            <form>
              <input type="email" class="newsletter newsletterInput1" placeholder="<?php echo $language["newsletter"][3]; //Vaša email adresa ?>">
              <button class="btn myBtn newsletter-btn addNewsletterButton1" type="button"><?php echo $language["newsletter"][4]; //Pošalji ?></button>
            </form>
            <p><?php echo $language["newsletter"][2]; //Prijavite se za naš newsletter i prvi saznajte... ?></p>
          </div>
          <!-- newsletter end-->
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-6 footer-links location _col-xs-100" itemscope itemtype ="http://schema.org/logo">
                <h4 class="after"><?php //echo $user_conf["company"][1];?></h4>
                <img src="<?php echo $user_conf["sitelogo_footer"][1]; ?>" alt="<?php echo $user_conf["sitetitle"][1];?>" class="img-responsive footer-logo" itemprop="ImageObject">
                <ul>
                  <li><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["placeholder"][1]; ?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"> <?php echo $user_conf["address"][1].", ".$user_conf["zip"][1]." ".$user_conf["city"][1].", ".$user_conf["country"][1]; ?></li>

                  <li><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["smartphone"][1]; ?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"> <a href="tel:<?php echo $user_conf["phone"][1]; ?>"><?php echo $user_conf["phone"][1]; ?></a></li>

                  <li><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["home_phone"][1]; ?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"> <a href="tel:<?php echo $user_conf["home_phone"][1]; ?>"><?php echo $user_conf["home_phone"][1]; ?></a></li>
                  

                  <li><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["mail"][1]; ?>" alt="<?php echo $user_conf["sitetitle"][1]; ?>" class="img-responsive"><a href="mailto:<?php echo $user_conf["contact_address"][1]; ?>"><?php echo $user_conf["contact_address"][1]; ?></a></li>
                  <li><b>PIB:</b> 104983212</li>
                  <li><b>MB:</b> 20286709</li>
                </ul>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-6 footer-links -xs50 brzi-foo">
            <h4 class="after"><?php echo $language["footer"][2]; //Brzi linkovi ?></h4>
            <ul>
              <?php foreach($footerSpeedLinkMenu as $k=>$fslmval) { ?>
              <li><a href="<?php echo $fslmval['link']; ?>"> <?php echo $fslmval['value']; ?></a></li>
              <?php } ?>
            </ul>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-6 footer-links -xs50 pomoc-foo">
          <h4 class="after"><?php echo $language["footer"][3]; //Pomoć pri kupovini ?></h4>
          <ul>
            <?php foreach($footerHelpMenu as $k=>$fhmval) { ?>
            <li><a href="<?php echo $fhmval['link']; ?>"> <?php echo $fhmval['value']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-md-5 col-xs-12 footer-links footer-cate">
          <h4 class="after"><?php echo $language["footer"][7]; //Kategorije ?></h4>
          <ul>
            

            <?php foreach($catcont as $key=>$cval){ ?>
              <li><a href="<?php echo rawurlencode($cval['catpathname']); ?>"> <?php echo $cval['catname']; ?></a></li>
              <?php } ?>  
          </ul>
        </div>
        <div class="col-md-12 col-xs-12">
          <ul class="teh-list">
            <?php foreach($headermenudata AS $hval){ ?>
              <?php if($hval['menutype']=='s'){ ?>
                <li>
                  <a href="<?php echo $hval['link'];?>" itemprop="url"><?php echo $hval['value'];?></a>
                </li>
              <?php } ?>
            <?php } ?>
          </ul>
        </div>
    </div>
<?php if($theme_conf["show_footer_social_networks_holder"][1]==1) {?>
<div class="row">
    <div class="col-md-12 col-xs-12 text-center social-foo">
        <h4><?php echo $language["footer"][4]; //Pratite nas ?></h4>
        <ul class="social-ul-foo">
          <?php if(strlen($theme_conf["facebook_link"][1])>0 && strlen($theme_conf["facebook_icon"][1])>0 ) {?>
          <li><a href="<?php echo $theme_conf["facebook_link"][1]; ?>" target="_blank" title="Facebook"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["facebook_icon"][1]; ?>" alt="social softart" class="img-responsive"></a></li>
          <?php } ?>
          <?php if(strlen($theme_conf["youtube_link"][1])>0 && strlen($theme_conf["youtube_icon"][1])>0) {?>
          <li><a href="<?php echo $theme_conf["youtube_link"][1]; ?>" target="_blank" title="Youtube"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["youtube_icon"][1]; ?>" alt="social softart" class="img-responsive"></a></li>
          <?php } ?>
		        <?php if(strlen($theme_conf["instagram_link"][1])>0 && strlen($theme_conf["instagram_icon"][1])>0) {?>
          <li><a href="<?php echo $theme_conf["instagram_link"][1]; ?>" target="_blank" title="Instagram"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["instagram_icon"][1]; ?>" alt="social softart" class="img-responsive"></a></li>
          <?php } ?>
          <?php if(strlen($theme_conf["twitter_link"][1])>0 && strlen($theme_conf["twitter_icon"][1])>0) {?>
          <li><a href="<?php echo $theme_conf["twitter_link"][1]; ?>" target="_blank" title="Twitter"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["twitter_icon"][1]; ?>" alt="social softart" class="img-responsive"></a></li>
          <?php } ?>
          <?php if(strlen($theme_conf["linkedin_link"][1])>0 && strlen($theme_conf["linkedin_icon"][1])>0) {?>
          <li><a href="<?php echo $theme_conf["linkedin_link"][1]; ?>" target="_blank" title="Linkedin"><img src="<?php echo $system_conf["theme_path"][1].$theme_conf["linkedin_icon"][1]; ?>" alt="social softart" class="img-responsive"></a></li>
          <?php } ?>
        </ul>
    </div>
</div> 
<?php } ?>


</div>
</div>
</footer>
<div class="container">
<div class="row ">
    <div class="col-md-12">
        <ul class="bank-foo">
			<li><a href="" target="_blank"><img src="fajlovi/icons/creditcards/american-express.png" alt="AmericanExpress" loading="lazy" title="AmericanExpress" class="img-responsive"></a></li>
         	<li><a href="" target="_blank"><img src="fajlovi/icons/creditcards/visa.png" alt="Visa" loading="lazy" title="Visa" class="img-responsive"></a></li>
			<li><a href="" target="_blank"><img src="fajlovi/icons/creditcards/mastercard.png" alt="Mastercard" loading="lazy" title="Mastercard" class="img-responsive"></a></li>
         	<li><a href="" target="_blank"><img src="fajlovi/icons/creditcards/maestro.png" alt="Maestro" loading="lazy" title="Maestro" class="img-responsive"></a></li>
			<li><a href="" target="_blank"><img src="fajlovi/icons/creditcards/dina.png" alt="Dinacard" loading="lazy" title="Dinacard" class="img-responsive"></a></li>
			
			<!-- <li><a href="https://www.kombank.com/" target="_blank"><img src="fajlovi/icons/creditcards/Komercijalna_banka_logo_and_wordmark.svg.png" alt="Komercijalna" class="img-responsive"></a></li> -->
			<!-- <li><a href="https://www.bancaintesa.rs/" target="_blank"><img src="fajlovi/icons/creditcards/banca-intesa.png" alt="Bancaintesa" loading="lazy" title="Bancaintesa" class="img-responsive"></a></li> -->
			
			<!-- <li><a href="http://www.wspay.rs" title="WSpay - Web Secure Payment Gateway" target="_blank"><img src="fajlovi/icons/creditcards/wsPayWebSecureLogo-118x50-transparent.png" alt="WSpay" class="img-responsive"></a></li> -->
      <li><a href="https://rs.visa.com/pay-with-visa/security-and-assistance/protected-everywhere.html" target="_blank"><img src="fajlovi/icons/creditcards/visa-ver.png" alt="Visa verificated" loading="lazy" title="Visa verificated" class="img-responsive"></a></li>
			<!-- <li><a href="https://www.mastercard.rs/sr-rs/consumers/find-card-products/credit-cards.html" target="_blank"><img src="fajlovi/icons/creditcards/master-secure.jpg" alt="Master secure" loading="lazy" title="Master secure" class="img-responsive"></a></li> -->
              
       </ul>
    </div>
  </div>
</div>

<div class="footer-bottom end" style="background-color:#000!important;">
    <div class="container no-bckg">
        <div class="row">
            <div class="col-md-12">
                <p class="go-left">Designed & Developed by <a href="http://softart.rs/">SoftArt</a></p>
                <p class="go-right">Copyright &copy; 2021 <a href="#"><?php echo $user_conf["company"][1];?></a>. <?php echo $language["footer"][6]; //Sva prava zadržana ?></p>
            </div>
        </div>
    </div>
</div>

<!-- go to top -->
<a href="#" class="go-top"><i class="fa fa-angle-up fa-2x" aria-hidden="true"></i></a>
<!-- .go to top -->
