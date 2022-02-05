<div class="page-head">

				<ol class="breadcrumb"  itemscope itemtype="http://schema.org/BreadcrumbList">
  					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="<?php  echo HOME_PAGE ;?>" itemprop="item">
  							<span itemprop="name"><?php echo $language["global"][3]; ?></span>
  						</a>
  					</li>
					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="korpa" itemprop="item">
  							<span itemprop="name"><?php echo $language["shopcart"][1]; //Korpa ?></span>
  						</a>
  					</li>
					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="order_address" itemprop="item">
  							<span itemprop="name"><?php echo $language["order"][1]; //Adresa placanja ?></span>
  						</a>
  					</li>
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $language["order"][2]; //Adresa dostave ?></span>
  					</li>
				</ol>

</div>
<section>
    <div class="container">
        <div class="content-page">
           <div class="row noMargin">
            <div class="col-md-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified order-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="order_address" >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;" >1</p> <?php echo $language["order"][1]; //Adresa placanja ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="#adresa2" aria-controls="home" role="tab" data-toggle="tab" style="border-left: 1px solid #ccc;">
                                <p class="order-number" style="background:#f9ce09!important; color:#333!important;">2</p> <?php echo $language["order"][2]; //Adresa dostave ?> <i class="fa fa-arrow-circle-right"  style="color:#f9ce09;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a >
                                <p class="order-number">3</p> <?php echo $language["order"][3]; //Način plaćanja ?></a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a >
                                <p class="order-number">4</p> <?php echo $language["order"][4]; //Način dostave ?></a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a >
                                <p class="order-number">5</p> <?php echo $language["order"][5]; //Pregled porudzbine ?></a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content order-tab-content">
                        
                        <div role="tabpanel" class="tab-pane active" id="adresa2">
                            <div class="row">
                                <div class="col-md-3 col-sm-4">
                                    <div class="order-user-info">
                                        <div class="order-user-head">
                                            <h4><?php echo $language["order_address_delivery"][1]; //Vaši podaci ?></h4>
                                        </div>
                                        <div class="order-user-body">
                                            <small><?php echo $language["order_address_delivery"][2]; //Ime i prezime ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['ime']." ".$_SESSION['prezime'];}?> </p>
                                            <br>
                                            <small><?php echo $language["order_address_delivery"][5]; //Adresa ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['adresa'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address_delivery"][6]; //Grad ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['mesto'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address_delivery"][7]; //Postanski broj ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['postbr'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address_delivery"][8]; //Telefon ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['telefon'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address_delivery"][8]; //Email adresa ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['email'];}?></p>
                                        </div>
                                    </div>
                                </div>
                                <form id="order_address_delivery" method="post" class="order-address-form">
                                <div class="col-md-9 col-sm-8">
                                    <p><?php echo $language["order_address_delivery"][10]; //Opis ?></p>
                                    <div class="row">
                                        <form action="" class="order-address-form">
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address_delivery"][3]; //Ime  ?></label>
                                                <input type="text" name="ime" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['ime']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address_delivery"][4]; //Prezime ?></label>
                                                <input type="text" name="prezime" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['prezime']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address_delivery"][5]; //Adresa ?></label>
                                                <input type="text" name="adresa" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['adresa']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address_delivery"][8]; //Telefon ?></label>
                                                <input type="text" name="telefon" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['telefon']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for=""><?php echo $language["order_address_delivery"][6]; //Grad ?></label>
                                                        <input type="text" name="mesto" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['mesto']."'";}?> required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for=""><?php echo $language["order_address_delivery"][7]; //Postanski broj ?></label>
                                                        <input type="text" name="postbr" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['postbr']."'";}?> required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address_delivery"][9]; //Email ?></label>
                                                <input type="email" name="email" class="order-address-input oai2 disabledInput"  <?php if($logged){echo "value='".$_SESSION['email']."'";}?> required>
                                            </div>
                                    </div>
                                    <small><?php echo $language["order_address_delivery"][11]; //* - sva polja su obavezna ?></small>
                                    <br>
                                    <a class="btn myBtn newData cms_newDataButton"><?php echo $language["order_address_delivery"][12]; //Nastavite sa drugim podacima ?></a>
                                </div>
                            </div>
                            <div class="row marginTop30">
                                <div class="col-md-12">
                                    <div class="order-login">
                                        <a href="order_address" class="btn myBtn text-left"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php echo $language["order_address_delivery"][13]; //Vrati se na adresa plaćanja ?></a>
                                        <button class="btn myBtn go-right" type="submit" value="Submit" name="order_address"><?php echo $language["order_address_delivery"][14]; //Nastavi na način plaćanja ?> <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        </div>
        
    </div>
</section>