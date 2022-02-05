<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
     <base href="/" />
    <!-- <base href="<?php //echo BASE_URL;?>" /> -->
    <meta name="robots" content="noindex" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $user_conf["sitetitle"][1];?></title>
    <?php include("plugins/facebook.opengraf.php");?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $user_conf["favicon"][1]; ?>">
 <!-- Reset CSS -->
<!--     <link rel="stylesheet" href="cdn/css/reset.css">  -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="cdn/css/bootstrap.min.css">
	<!-- Alertify-->
    <link rel="stylesheet" href="cdn/alertify/themes/alertify.core.css"/>
    <link rel="stylesheet" href="cdn/alertify/themes/alertify.custom.css"/>
    <!-- Select plugin -->
    <link rel="stylesheet" href="cdn/css/select2.min.css"/>
    <link rel="stylesheet" href="cdn/datatables/dataTables.bootstrap.css"/>

    <!-- THEME PLUGINS CSS LOAD -->
    <?php include($system_conf["theme_path"][1]."config/plugins_css.php");?>
    <!-- THEME PLUGINS CSS LOAD END -->
    
    
    <!-- star rating -->
    <link rel="stylesheet" href="cdn/css/jquery.rateyo.min.css">

   
	<!-- Price slider -->
    <!-- PRICE SLIDER IZBACITI -->
	<!-- <link rel="stylesheet" href="cdn/css/priceslider.css" > -->
    <!-- My CSS -->
    <link rel="stylesheet" href="cdn/css/cms.css">
    <link rel="stylesheet" href="cdn/css/helpers.css">
    <link rel="stylesheet" href="<?php echo $system_conf["theme_path"][1];?>cdn/css/custom.css?<?php echo microtime(true);?>">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    
</head>
<?php $body_backgroundstyle='class="-body-bckg"';
    if(isset($user_conf["default_background_img"][1]) && strlen($user_conf["default_background_img"][1])>0) { 
        $body_backgroundstyle='style="background-image: url('.$user_conf["default_background_img"][1].');"';
 }  ?>
<body <?php echo $body_backgroundstyle;?> >
   <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script src='https://www.google.com/recaptcha/api.js'></script>




   <!-- <div class="corner1 hide" style="background-image: url('<?php echo GlobalHelper::getImage('fajlovi/banners/baneri/banner3.jpg', 'big'); //  ?>');"><a href="pocetna"></a></div> 
   <div class="corner2 hide" style="background-image: url('<?php echo GlobalHelper::getImage('fajlovi/banners/baneri/banner2.jpg', 'big'); //  ?>');"><a href="pocetna"></a></div> -->


    

    