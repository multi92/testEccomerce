<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <base href="saMagneto" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Softart DEVELOP MODE</title>
    <link rel="shortcut icon" type="image/x-icon" href="">
 <!-- Reset CSS -->
<!--     <link rel="stylesheet" href="cdn/css/reset.css">  -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../../cdn/css/bootstrap.min.css">
	<!-- Alertify-->
    <link rel="stylesheet" href="../../../cdn/alertify/themes/alertify.core.css"/>
    <link rel="stylesheet" href="../../../cdn/alertify/themes/alertify.custom.css"/>
    <!-- Select plugin -->
    <link rel="stylesheet" href="../../../cdn/css/select2.min.css"/>

    <!-- THEME PLUGINS CSS LOAD -->
    <?php include("config/plugins_css.php");?>
    <!-- THEME PLUGINS CSS LOAD END -->
    
    
    <!-- star rating -->
    <link rel="stylesheet" href="../../../cdn/css/jquery.rateyo.min.css">

   
	<!-- Price slider -->
    <!-- PRICE SLIDER IZBACITI -->
	<link rel="stylesheet" href="../../../cdn/css/priceslider.css" >
    <!-- My CSS -->
    <link rel="stylesheet" href="../../../cdn/css/cms.css">
    <link rel="stylesheet" href="../../../cdn/css/helpers.css">
    <link rel="stylesheet" href="cdn/css/custom.css">

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


    <!-- <div class="corner1" style="background-image: url('views/theme/img/corner1.jpg');"></div> -->
    <!-- <div class="corner2" style="background-image: url('views/theme/img/corner2.jpg');"></div> -->



    <div class="main-body-filter"></div>


    <div class="slide-menu">
        <div class="head">
            <i class="icons jq_leftMenuBackBtn -back"></i>
            <h2 class="title">Proizvodi</h2>
            <i class="material-icons icons jq_leftMenuCloseBtn">close</i>
        </div>
        
        <div class="body-container">

            <div class="body jq_leftMenuBody" data-clickedname='Proizvodi'>
                <ul class="list">
                    <li class="items">
                        <a href="" class="links">Udžbenici</a>
                        <i class="material-icons icons jq_forwardLeftMenuBtn">keyboard_arrow_right</i>
                    </li>
                    <li class="items">
                        <a href="" class="links">Sveske</a>
                        <i class="material-icons icons jq_forwardLeftMenuBtn">keyboard_arrow_right</i>
                    </li>
                    <li class="items">
                        <a href="" class="links">Rančevi i školske torbe</a>
                        <i class="material-icons icons jq_forwardLeftMenuBtn">keyboard_arrow_right</i>
                    </li>
                </ul>
            </div>

        </div>

    </div>