<?php if(isset($_SESSION['loginstatus']) && $_SESSION['loginstatus']=='logged' && $_SESSION['type']=='partner'){
		$order_del="order_orderingB2B";
		} else {
		$order_del="order_ordering";
		}	
?>
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
  						<a href="order_address_delivery" itemprop="item">
  							<span itemprop="name"><?php echo $language["order"][2]; //Adresa dostave ?></span>
  						</a>
  					</li>
					<li itemprop="itemListElement" itemscope
      				itemtype="http://schema.org/ListItem">
  						<a href="order_payment" itemprop="item">
  							<span itemprop="name"><?php echo $language["order"][3]; //Nacin placanja ?></span>
  						</a>
  					</li>
  					<li class="active" itemprop="itemListElement" itemscope
      					itemtype="http://schema.org/ListItem">
  						<span itemprop="name"><?php echo $language["order"][4]; //Nacin dostave ?></span>
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
                        <li role="presentation" class="active">
                            <a href="order_payment" >
                                <p class="order-number" style="background:#18AC62!important; color:#333!important;">3</p> <?php echo $language["order"][3]; //Način plaćanja ?> <i class="fa fa-check-circle" style="color:#18AC62;" aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="active" >
                            <a href="#dostava" aria-controls="messages" role="tab" data-toggle="tab">
                                <p class="order-number" style="background:#f9ce09!important; color:#333!important;">4</p> <?php echo $language["order"][4]; //Način dostave ?> <i class="fa fa-arrow-circle-right"  style="color:#f9ce09;"aria-hidden="true"></i></a>
                        </li>
                        <li role="presentation" class="disabled" disabled>
                            <a href="#pregled" aria-controls="settings" role="tab" data-toggle="tab">
                                <p class="order-number">5</p> <?php echo $language["order"][5]; //Pregled porudzbine ?></a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <form id="<?php echo $order_del ;?>" method="post" action="">
                    <div class="tab-content order-tab-content">
                        
                        <div role="tabpanel" class="tab-pane active" id="dostava">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?php echo $language["order_delivery"][1]; //Opis ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-xs">
                                    <a class="chose-paymant" >
                                        <div class="order-paymant-check pos trigger-collapse2 <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'Lično') echo 'active' ?>">
                                            <h4><?php echo $language["order_delivery"][2]; //Lično preuzimanje ?></h4>
                                            <p><?php echo $language["order_delivery"][3]; //Odaberite radnju za preuzimanje ?></p>
                                            <div class="order-check-holder">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input id="delivery1" type="radio" name="delivery" value="Lično" <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'Lično') echo 'checked="checked"' ?>>
                                        
                                    </a>
                                </div>
                                <div class="col-xs-6 col-xs">
                                    <a class="chose-paymant" >
                                        <div class="order-paymant-check pos trigger-collapse3 <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'KurirskomSlužbom') echo 'active' ?>">
                                            <h4><?php echo $language["order_delivery"][4]; //Kurirskom službom ?></h4>
                                            <p><?php echo $language["order_delivery"][5]; //Odaberite kurirsku službu za dostavu ?></p>
                                            <div class="order-check-holder">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input id="delivery2" type="radio" name="delivery" value="KurirskomSlužbom" <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'KurirskomSlužbom') echo 'checked="checked"' ?>>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 collapseParent">
                                     <?php  $deliveryid=0;
                                        if(isset($_SESSION["ordering_address"]["deliveryid"]) && $_SESSION["ordering_address"]["deliveryid"]!=''){
                                            $deliveryid=$_SESSION["ordering_address"]["deliveryid"];
                                        }
                                    ?>
                                    <?php if(count($ShopData[1])>0) { ?>
                                    <div class="collapse" id="collapseDelivery2" <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'Lično'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
                                        <div class="well">
                                            <h4><?php echo $language["order_delivery"][6]; //Odaberite radnju u kojoj želite da preuzmete narudžbinu ?></h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered order-table">
                                                    <tr>
                                                        <th><?php echo $language["order_delivery_personal_table"][1]; //Naziv ?></th>
                                                        <th><?php echo $language["order_delivery_personal_table"][2]; //Adresa ?></th>
                                                        <th><?php echo $language["order_delivery_personal_table"][3]; //Grad ?></th>
                                                        <th><?php echo $language["order_delivery_personal_table"][4]; //Telefon ?></th>
                                                        <th><?php echo $language["order_delivery_personal_table"][5]; //Email ?></th>
                                                        <th></th>
                                                    </tr>
                                                    <?php foreach($ShopData[1] as $sval) { ?>
                                                    <tr>
                                                        <td><?php echo $sval->name; ?></td>
                                                        <td><?php echo $sval->address; ?></td>
                                                        <td><?php echo $sval->cityname; ?></td>
                                                        <td><?php echo $sval->phone; ?></td>
                                                        <td><?php echo $sval->email; ?></td>
                                                        <td class="text-center">
                                                            <input id="deliveryL<?php echo $sval->id;?>" type="radio" name="deliverypartner" deliveryserviceid="<?php echo $sval->id;?>" value="<?php echo $sval->id;?>" <?php if($sval->id==$deliveryid && isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'Lično'){ echo ' checked="checked" '; }?>>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div class="collapse" id="collapseDelivery2" <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'Lično'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
                                        <div class="well">
                                            <h4><?php echo $language["order_delivery"][7]; //Adresa na kojoj možete da preuzmete narudžbinu je ?>:</h4>
                                            <p><strong><?php echo $user_conf["company"][1]; ?></strong></p>
                                            <p><strong><?php echo $user_conf["address"][1]; ?></strong></p>
                                            <p><strong><?php echo $user_conf["zip"][1]." ".$user_conf["city"][1]; ?></strong></p>
                                            <input id="deliveryZero" type="radio" name="deliverypartner" deliveryserviceid="0" value="0" <?php if($deliveryid==0 && isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'Lično'){ echo ' checked="checked" '; }?>>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="collapse" id="collapseDelivery3" <?php if(isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'KurirskomSlužbom'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
                                        <div class="well">
                                            <h4><?php echo $language["order_delivery"][8]; //Odaberite kurirsku službu kojom želite da Vam pošaljemo narudžbinu ?></h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered order-table">
                                                    <tr>
                                                        <th><?php echo $language["order_delivery_service_table"][1]; //Kurirska služba ?></th>
                                                        <th><?php echo $language["order_delivery_service_table"][2]; //Telefon ?></th>
                                                        <th><?php echo $language["order_delivery_service_table"][3]; //Email ?></th>
                                                        <th><?php echo $language["order_delivery_service_table"][4]; //Web sajt ?></th>
                                                        <th></th>
                                                    </tr>
                                                        <?php foreach($DeliveryService[1] as $dval) { ?>
                                                        <tr>
                                                            <td><strong><?php echo $dval->name; ?></strong></td>
                                                            <td><?php echo $dval->phone; ?></td>
                                                            <td><?php echo $dval->email; ?></td>
                                                            <td><?php echo $dval->website; ?></td>
                                                            <td class="text-center"><input id="deliveryKS<?php echo $dval->id;?>" type="radio" name="deliverypartner" deliveryserviceid="<?php echo $dval->id;?>" value="<?php echo $dval->id;?>" <?php if($dval->id==$deliveryid && isset($ord_adr['delivery']) && $ord_adr['delivery'] == 'KurirskomSlužbom'){ echo ' checked="checked" '; }?>></td>
                                                        </tr>
                                                        <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row marginTop30">
                                <div class="col-md-12">
                                    <div class="order-login">
                                        <a href="order_payment" class="btn myBtn text-left"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php echo $language["order_delivery"][9]; //Vrati se na način plaćanja ?></a>
                                        <button class="btn myBtn go-right" type="submit" value="Submit" name="order_ordering"><?php echo $language["order_delivery"][10]; //Nastavi na pregled porudžbine ?><i class="fa fa-angle-right" aria-hidden="true"></i></button>
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