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
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $language["order"][1]; //Adresa placanja ?></span>
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
                            <a href="#adresa" aria-controls="home" role="tab" data-toggle="tab">
                                <p class="order-number" style="background:#f9ce09!important; color:#333!important;">1</p> <?php echo $language["order"][1]; //Adresa placanja ?> <i class="fa fa-arrow-circle-right" style="color:#f9ce09;" aria-hidden="true"></i>
</a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a >
                                <p class="order-number">2</p> <?php echo $language["order"][2]; //Adresa dostave ?></a>
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
                        <div role="tabpanel" class="tab-pane active" id="adresa">
                            <div class="row">
                                <div class="col-md-3 col-sm-4">
                                    <div class="order-user-info">
                                        <div class="order-user-head">
                                            <h4><?php echo $language["order_address"][1]; //Vaši podaci ?></h4>
                                        </div>
                                        <div class="order-user-body">
                                            <small><?php echo $language["order_address"][2]; //Ime i prezime ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['ime']." ".$_SESSION['prezime'];}?> </p>
                                            <br>
                                            <small><?php echo $language["order_address"][5]; //Adresa ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['adresa'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address"][6]; //Grad ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['mesto'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address"][7]; //Postanski broj ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['postbr'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address"][8]; //Telefon ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['telefon'];}?></p>
                                            <br>
                                            <small><?php echo $language["order_address"][9]; //Email adresa ?></small>
                                            <br>
                                            <p><?php if($logged){echo $_SESSION['email'];}?></p>
                                        </div>
                                    </div>
                                </div>
                                <form id="order_address" method="post" class="order-address-form">
                                
                                <div class="col-md-9 col-sm-8">
                                    <p><?php echo $language["order_address"][10]; //Opis ?></p>
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address"][3]; //Ime  ?></label>
                                                <input type="text" name="ime" class="order-address-input disabledInput"   <?php if($logged){echo "value='".$_SESSION['ime']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address"][4]; //Prezime ?></label>
                                                <input type="text" name="prezime" class="order-address-input disabledInput"  <?php if($logged){echo "value='".$_SESSION['prezime']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address"][5]; //Adresa ?></label>
                                                <input type="text" name="adresa" class="order-address-input disabledInput"  <?php if($logged){echo "value='".$_SESSION['adresa']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address"][8]; //Telefon ?></label>
                                                <input type="text" name="telefon" class="order-address-input disabledInput"  <?php if($logged){echo "value='".$_SESSION['telefon']."'";}?> required>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for=""><?php echo $language["order_address"][6]; //Grad ?></label>
                                                        <input type="text" name="mesto" class="order-address-input disabledInput"  <?php if($logged){echo "value='".$_SESSION['mesto']."'";}?> required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for=""><?php echo $language["order_address"][7]; //Postanski broj ?></label>
                                                        <input type="text" name="postbr" class="order-address-input disabledInput"  <?php if($logged){echo "value='".$_SESSION['postbr']."'";}?> required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for=""><?php echo $language["order_address"][9]; //Email adresa ?></label>
                                                <input type="email" name="email" class="order-address-input disabledInput"  <?php if($logged){echo "value='".$_SESSION['email']."'";}?> required>
                                            </div>
                                        
                                    </div>
                                    <small><?php echo $language["order_address"][11]; //Sva polja su obavezna ?></small>
                                    <br>
                                    <a class="btn myBtn newData cms_newDataButton"><?php echo $language["order_address"][12]; //Nastavite sa drugim podacima ?></a>
                                </div>
                            </div>
                            
                            <div class="row marginTop30">
                                <div class="col-md-12">
                                    <div class="order-login">
                                        <?php if(!$logged) { ?>
                                            <p class="text-left"><?php echo $language["order_address"][13]; //Imate nalog? Ulogujte se kako bi nastavili sa kupovinom. ?></p>
                                            <a class="btn myBtn text-left" data-toggle="modal" data-target=".bs-example-modal-sm"><?php echo $language["order_address"][14]; //Ulogujte se ?></a>
                                        <?php } ?>
                                        
                                        <button class="btn myBtn go-right" type="submit" value="Submit" name="order_address"><?php echo $language["order_address"][15]; //Nastavi na adresa dostave ?> <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
    </div>
</section>