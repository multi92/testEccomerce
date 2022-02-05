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
					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="order_address" itemprop="item">
  							<span itemprop="name"><?php echo $language["order"][2]; //Adresa dostave ?></span>
  						</a>
  					</li>
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $language["order"][3]; //Nacin placanja ?></span>
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
                            <a href="order_address"  style="border-left: 1px solid #ccc;" >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">1</p> <?php echo $language["order"][1]; //Adresa placanja ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="order_address_delivery"  >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">2</p> <?php echo $language["order"][2]; //Adresa dostave ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active" >
                            <a href="#placanje" aria-controls="profile" role="tab" data-toggle="tab">
                                <p class="order-number" style="background:#f9ce09!important; color:#333!important;">3</p> <?php echo $language["order"][3]; //Način plaćanja ?> <i class="fa fa-arrow-circle-right"  style="color:#f9ce09;"aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a href="#dostava" aria-controls="messages" role="tab" data-toggle="tab">
                                <p class="order-number">4</p> <?php echo $language["order"][4]; //Način dostave ?></a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a href="#pregled" aria-controls="settings" role="tab" data-toggle="tab">
                                <p class="order-number">5</p> <?php echo $language["order"][5]; //Pregled porudzbine ?></a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <form id="order_delivery" method="post" action="">
                    <div class="tab-content order-tab-content">
                        <div role="tabpanel" class="tab-pane active" id="placanje">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?php echo $language["order_payment"][1]; //Opis ?></p>
                                </div>
                                
                                <div class="col-xs-12 col-xs">
                                    <a class="chose-paymant">
                                        <div class="order-paymant-check pos cms_payment <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Pouzecem') echo 'active' ?>" id="payment1" name="payment" value="Pouzecem" paymenttype='1'>
                                            <h4><?php echo $language["order_payment"][2]; //Plaćanje pouzećem ?></h4>
                                            <p><?php echo $language["order_payment"][3]; //Plaćanje prilikom preuzimanja pošiljke ?></p>
                                            <div class="order-check-holder">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input id="payment1" type="radio" name="payment" value="Pouzecem" <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Pouzecem') echo 'checked="checked"' ?>>
                                    </a>
                                </div>
                                <div class="col-xs-4 col-xs hide">
                                    <a class="chose-paymant">
                                        <div class="order-paymant-check pos cms_payment trigger-collapse <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Uplatnicom') echo 'active' ?>" id="payment2" name="payment" value="Uplatnicom" paymenttype='2' >
                                            <h4><?php echo $language["order_payment"][4]; //Plaćanje uplatnicom ?></h4>
                                            <p><?php echo $language["order_payment"][5]; //Izgled vaše uplatnice pogledajte ispod ?></p>
                                            <div class="order-check-holder">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                         <input id="payment2" type="radio" name="payment" value="Uplatnicom"  <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Uplatnicom') echo 'checked="checked"' ?>>
                                    </a>
                                </div>
                                <div class="col-xs-4 col-xs hide">
                                    <a class="chose-paymant disabledInput">
                                        <div class="order-paymant-check pos cms_payment <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Karticom') echo 'active' ?>" id="payment3" name="payment" value="Karticom" paymenttype='3' >
                                            <h4><?php echo $language["order_payment"][6]; //Plaćanje karticom ?></h4>
                                            <p><?php echo $language["order_payment"][7]; //Molimo Vas unesite validne podatke ?></p>
                                            <div class="order-check-holder">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input id="payment3" type="radio" name="payment" value="Karticom"  <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Karticom') echo 'checked="checked"' ?>>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="collapse" id="collapseUpl" <?php if(isset($ord_adr['payment']) && $ord_adr['payment'] == 'Uplatnicom'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
                                        <div class="well">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3><?php echo $language["order_payment"][8]; //Nalog za uplatu ?></h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form action="" class="uplForm">
                                                    <div class="col-xs-5 col-xs">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for=""><?php echo $language["order_payment"][9]; //Uplatilac ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="<?php echo $ord_adr['ime'] . ' '.$ord_adr['prezime'].', '.$ord_adr['mesto'].', '.$ord_adr['adresa'] ?>" >
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for=""><?php echo $language["order_payment"][10]; //Svrha uplate ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="Placanje racuna" >
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for=""><?php echo $language["order_payment"][11]; //Primalac ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="Ime firme d.o.o ; Neka Ulica 123/12 ; 18000 Nis "  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-7 col-xs">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-xs-6">
                                                                <label for=""><?php echo $language["order_payment"][12]; //Šifra plaćanja ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="112" >
                                                            </div>
                                                            <div class="col-sm-3 col-xs-6">
                                                                <label for=""><?php echo $language["order_payment"][13]; //Valuta ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="RSD" >
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for=""><?php echo $language["order_payment"][14]; //Iznos ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="<?php echo $ukupan_iznos ?>" >
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label for=""><?php echo $language["order_payment"][15]; //Račun primaoca ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="123-45678-900" >
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for=""><?php echo $language["order_payment"][16]; //Model ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="97" >
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <label for=""><?php echo $language["order_payment"][17]; //Poziv na broj ?></label>
                                                                <input type="text" class="uplInput disabledInput" value="1234545665" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row marginTop30">
                                <div class="col-md-12">
                                    <div class="order-login">
                                        <a href="order_address_delivery" class="btn myBtn text-left" ><i class="fa fa-angle-left" aria-hidden="true"></i> <?php echo $language["order_payment"][18]; //Vrati se na adresa dostave ?></a>
                                        <button class="btn myBtn go-right" type="submit" value="Submit" name="order_delivery"><?php echo $language["order_payment"][19]; //Nastavi na način dostave ?> <i class="fa fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
        </div>
        
    </div>
</section>