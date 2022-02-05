
<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper productData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-archive"></i> Informacije o proizvodu <span class="productNameHeader hide"></span> <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li><a href="product"><i class="fa fa-archive"></i> Proizvodi</a></li>
 			<li class="active"> Informacije o proizvodu</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 		<div class="loadingIcon" style="position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 9999; background: url('plugins/loaders/giphy3.gif') 50% 50% no-repeat #fff;">
 			<i class="fa fa-refresh fa-spin fa-2x  hide"></i>
 		</div>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton"><i class="fa fa-th-list" aria-hidden="true"></i> Lista proizvoda</button>
             </div>
         </div>
         
        <div class="row addChangeCont hide"><!-- ADD CHANGE CONT -->
         	 <div id="productHeader" class="col-lg-9 col-md-8 col-sm-12 col-xs-12 productHeader">
         	 	<div class="box box-widget widget-user-2 " >
        			<!-- Add the bg color to the header using any of the bg-* classes -->
        			<div class="widget-user-header bg-yellow">
        				<div class="widget-user-image">
        					<img class="img-square productImageHeader img-responsive" src="" alt="" style="height: 65px;"> 
        				</div>
        				<!-- /.widget-user-image -->
        				<h3 class="widget-user-username productNameHeader"></h3>
        				<h5 class="widget-user-desc productCategoryHeader"></h5>
        			</div>
        			<div class="box-footer no-padding">
        			  <ul class="nav nav-stacked">
        			    <li>
        			    	<div class="row" style="margin:0; padding: 5px 5px; font-size: 22px; vertical-align: middle;">
        			    		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			    			<span class="" style="font-size: 22px;">Status</span> <span class="pull-right badge bg-green productActiveHeader" style="font-size: 22px;"></span> 
        			    		</div>
        			    	</div>
        			    </li>
        			    <li>
        			    	<div class="row" style="margin:0; padding: 5px 5px; font-size: 22px; vertical-align: middle;">
        			    		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			    			<span class="" style="font-size: 22px;">Tip</span> <span class="pull-right badge bg-purple productTypeHeader" style="font-size: 22px;"></span> 
        			    		</div>
        			    	</div>
        			    </li>
        			    <li>
        			    	<div class="row" style="margin:0; padding: 5px 5px; font-size: 22px; vertical-align: middle;">
        			    		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			    			<span class="" style="font-size: 22px;">Količina na stanju</span> <span class="pull-right badge bg-aqua productAmountHeader" style="font-size: 22px;">0</span> 
        			    		</div>
        			    	</div>
        			    </li>
        			    <li>
        			    	<div class="row" style="margin:0; padding: 5px 5px; font-size: 22px; vertical-align: middle;">
        			    		<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			    			<span class="" style="font-size: 22px;">Poreska stopa</span> <span class="pull-right badge bg-aqua productTaxValueHeader" style="font-size: 22px;">0</span> 
        			    		</div>
        			    	</div>
        			    </li>
        			    <li>
        			    	<div class="row" style="margin:0; padding: 5px 5px; font-size: 22px; vertical-align: middle;">
        			    		<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-6">
        			    			<span class="" style="font-size: 22px;">B2C Cena</span> <span class="pull-right badge bg-blue productB2CPriceHeader" style="font-size: 22px;">0</span> 
        			    		</div>

        			    		<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-6">
        			    			<span class="" style="font-size: 22px;">B2C Cena sa PDV-om</span> <span class="pull-right badge bg-blue productB2CPriceWithVatHeader" style="font-size: 22px;">0</span>
        			    		</div>
        			    	</div>
        			    	 
        			    	
        			    </li>
        			    <li class="hide">
        			    	<div class="row " style="margin:0; padding: 5px 5px; font-size: 22px; vertical-align: middle;">
        			    		<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-6">
        			    			<span class="" style="font-size: 22px;">B2B Cena</span> <span class="pull-right badge bg-red productB2BPriceHeader" style="font-size: 22px;">0</span>
        			    		</div>

        			    		<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-6">
        			    			<span class="" style="font-size: 22px;">B2B cena sa PDV-om</span> <span class="pull-right badge bg-red productB2BPriceWithVatHeader" style="font-size: 22px;">0</span>
        			    		</div>
        			    	</div>
        			    	
        			    </li>
        			  </ul>
        			</div>
        		</div>
         	 </div>
         	<div id="productHeaderStatustics" class="col-lg-3 col-md-4 col-sm-12 col-xs-12 productHeader">
         		<?php if($settings["show_product_visit_box"][1]=='1'){?>
         	 	<div class="info-box bg-red-active productVisitBox" style="display: flex;  justify-content: space-between; align-items: center;">						   
					<div class="info-box-content " style="margin-left: 0;">
						<span class="info-box-text" style="padding-left: 15px;"><h4><b> <i class="fa fa-star-o"></i> BROJ PREGLEDA </b></h4></span>
					</div>
					<span class="info-box-icon bg-red productVisitCount" style="float:right!imortant;">0</span>
					<!-- /.info-box-content -->
        		</div>
        		<?php } ?>
        		<?php if($settings["show_product_order_box"][1]=='1'){?>
        		<div class="info-box bg-red-active productOrderBox" style="display: flex;  justify-content: space-between; align-items: center;">						   
					<div class="info-box-content " style="margin-left: 0;">
						<span class="info-box-text" style="padding-left: 15px;"><h4><b> <i class="fa fa-shopping-cart"></i> DO SADA PORUČENO </b></h4></span>					  
					</div>
					 <span class="info-box-icon bg-red productOrderCount" style="float:right!imortant;">0</span>
					<!-- /.info-box-content -->
        		</div>
        		<?php } ?>
        		<?php if($settings["show_product_order_finished_box"][1]=='1'){?>
        		<div class="info-box bg-red-active productOrderFinishedBox" style="display: flex;  justify-content: space-between; align-items: center;">						   
					<div class="info-box-content " style="margin-left: 0;">
						<span class="info-box-text" style="padding-left: 15px;"><h4><b> <i class="fa fa-money"></i> DO SADA PRODATO </b></h4></span>
					</div>
					<span class="info-box-icon bg-red productOrderCount" style="float:right!imortant;">0</span>
					<!-- /.info-box-content -->
        		</div>
        		<?php } ?>
         	</div>         	 
            <div class="col-xs-12">
 					<div class="box"><!-- BOX -->
 							<div class="box-header"></div>
                    		<div class="box-body"><!-- BOX BODY -->	
								<div class="row"><!-- BOX ROW -->
								 	<div class="col-md-12" id="milan">
                        				<div class="nav-tabs-custom ">
                        					<ul class="nav nav-tabs hide">
                        					    <li class="active"><a href="#opsta" data-toggle="tab"><b>OPŠTI PODACI</b></a></li>
                        					    <!-- <li><a href="#partijska" data-toggle="tab">Партијска евиденција</a></li>
                        					    <li><a href="#aktivnosti" data-toggle="tab">Активности</a></li>
                        					    <li><a href="#incidenti" data-toggle="tab">Инциденти</a></li>
                        					    <li><a href="#drustvene" data-toggle="tab">Друштвене организације</a></li>
                        					    <li><a href="#drzavne" data-toggle="tab">Државне организације</a></li>
                        					    <li><a href="#dokumenta" data-toggle="tab">Документа</a></li> -->
                        					</ul>
                        					<div class="tab-content"><!-- TAB CONTENT -->
                        			    <div class="active tab-pane" id="opsta"><!-- TAB -->
                        			  		
											<div class="row"><!-- TAB ROW -->
												<div class="col-sm-12">
												<div class="row">	
													<div class="col-sm-12">
														<h2><b><span class="">DETALJI PROIZVODA</span></b></h2>
														<hr> 
													</div>
													<div class="col-sm-12">
														<br>
														<h4><b>Naziv proizvoda</b></h4>
           													<div class="row productNameCont" style="background: rgb(248, 255, 208);">
                    											 
                    										</div>
														<hr> 
													</div>
													<div class="col-sm-12">
														<br>
														<h4><b>Alternativni naziv proizvoda</b></h4>
           													<div class="row productAlterNameCont" style="background: rgb(248, 255, 208);">
                    											 
                    										</div>
														<hr> 
													</div>
													<div class="col-sm-2">
														<div class="form-group">
															<label><b>Šifra</b></label>
															<input type="text" class="form-control productCode" placeholder="Šifra" style="background-color:lightyellow; ">
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label><b>Barkod</b></label>
															<input type="text" class="form-control productBarcode" placeholder="Barkod" style="background-color:lightyellow; ">
														</div>
													</div>
													<div class="col-sm-2">
															<div class="form-group">
																<label><b>Status</b></label>
																<div class="input-group" style="width: 100%;">
																	<select class="form-control productActive" style="width: 100%;">
																		<option value="y" class="background-status-y">Aktivan</option>
																		<option value="n" class="background-status-n">Neaktivan</option>
																	</select>
																	
																</div>
																
															</div>
													</div>
													<div class="col-sm-4">
															<div class="form-group">
																<label><b>Tip</b></label>
																<div class="input-group" style="width: 100%;">
																<select class="form-control productType" style="width: 100%;">
																	<option value="n" class="background-type-n">---</option>
     																<option value="r" class="background-type-r">Regularan</option>
     																<option value="q" class="background-type-q">Na upit</option>
     																<option value="i" class="background-type-i">Info</option>
     																<option value="vp" class="background-type-vp">Grupni proizvod</option>
     																<option value="vpi-r" class="background-type-vpi-r">Član grupnog proizvoda - Regularan</option>
     																<option value="vpi-q" class="background-type-vpi-q">Član grupnog proizvoda - Na upit</option>
																</select>
																</div>
															</div>
													</div>
													
													
												</div>
												</div>
												<div class="col-sm-12">
											 		<div class="row">
											 			<div class="col-sm-2">
															<div class="form-group">
																<label><b>Rabat u %</b></label>
																	<input type="number" class="form-control productRebate" placeholder="Vrednost rabata u %" value="0" style="background-color:lightyellow; ">
															</div>
														</div>
											 			<div class="col-sm-2">
															<div class="form-group">
																<label><b>PDV STOPA</b></label>
																<div class="input-group" style="width: 100%;">
																<select class="form-control productTax" style="width: 100%;">
																	<option value="0" >---</option>
     																<?php
                          												  $query = "SELECT t.id, t.name, t.value FROM `tax` AS t ORDER BY t.id ASC";
                          												  $res = mysqli_query($conn, $query);
                          												    while($row = mysqli_fetch_assoc($res)){ ?>
                          												      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['value']."%"; ?></option>  
                          												  <?php }
                          												?>
																</select>
																</div>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label><b>Brend</b></label>
																<div class="input-group" style="width: 100%;">
																<select class="form-control productBrend" style="width: 100%;">
																	<option value="0">---</option>
     																<?php
                          												  $query = "SELECT b.id, b.name FROM `brend` AS b ORDER BY b.name ASC";
                          												  $res = mysqli_query($conn, $query);
                          												    while($row = mysqli_fetch_assoc($res)){ ?>
                          												      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>  
                          												  <?php }
                          												?>
																</select>
																</div>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label><b>Kolekcija</b></label>
																<div class="input-group" style="width: 100%;">
																<select class="form-control productCollection" style="width: 100%;">
																	<option value="0" >---</option>
     																
																</select>
																</div>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label><b>Vidljivost cene</b></label>
																<div class="input-group" style="width: 100%;">
																<select class="form-control productPriceVisibility" style="width: 100%;">
																	<option value="n" >Sakrivena cena</option>
     																<option value="a" >Vidljiva cena za sve korisnike</option>
     																<option value="c" >Vidljiva cena samo za Ulogovane B2C korisnike</option>
     																<!-- <option value="b" >Vidljiva cena samo za Ulogovane B2B korisnike</option>
     																<option value="cb" >Vidljiva cena za Ulogovane B2C i B2B korisnike</option> -->
																</select>
																</div>
															</div>
														</div>
											 		</div>
											 	</div>
											 	
                        			  			<div class="col-sm-12">
											 	<div class="row">
											 		<div class="col-sm-12">
														<br>
														<h4><b>Proizvođač</b></h4>
														<div class="row productManufnameCont " style="background: rgb(248, 255, 208);"></div>
													</div>
													<div class="col-sm-2" style="background: rgb(248, 255, 208); overflow: hidden;">
														<div class="form-group">
															<label><b>Kod proizvođača</b></label>
															<input type="text" class="form-control productManufcode" placeholder="Kod proizvođača">
														</div>
													</div>
													<div class="col-sm-10" style="background: rgb(248, 255, 208); ">
														<div class="form-group" >
															<label>&nbsp;</label>
															<div class="form-control" style="border:0; background: transparent;"></div>
														</div>
													</div>
												</div>
												</div>
												<div class="col-sm-12">
											 	<div class="row">
											 		<div class="col-sm-12">
														<br>
														<h4><b>Jedinica mere</b></h4>
														<div class="row productUnitNameCont " style="background: rgb(248, 255, 208);"></div>
													</div>
													<div class="col-sm-2" style="background: rgb(248, 255, 208); overflow: hidden;">
														<div class="form-group" >
															<label><b>Korak jedinice mere</b></label>
															<input type="number" class="form-control productUnitstep" placeholder="Korak jedinice mere">
														</div>
													</div>
													<div class="col-sm-10" style="background: rgb(248, 255, 208); ">
														<div class="form-group" >
															<label>&nbsp;</label>
															<div class="form-control" style="border:0; background: transparent;"></div>
														</div>
													</div>
												</div>
												</div>
												<div class="col-sm-12">
											 	<div class="row">
											 		<div class="col-sm-12">
														<br>
														<h4><b>Reci za pretragu</b></h4>
														<div class="row productSearchwordsCont " style="background: rgb(248, 255, 208);"></div>
													</div>
												</div>
												</div>
												<div class="col-sm-12 hide">
											 	<div class="row">
											 		<div class="col-sm-12">
														<br>
														<h4><b>Developer</b></h4>
														<div class="row productDeveloperCont " style="background: rgb(248, 255, 208);"></div>
													</div>
													<div class="col-sm-6" style="background: rgb(248, 255, 208); overflow: hidden;">
														<div class="form-group">
															<label><b>Link ka developeru</b></label>
															<input type="text" class="form-control productDeveloperLink" placeholder="Link ka developeru">
														</div>
													</div>
													<div class="col-sm-2" style="background: rgb(248, 255, 208); ">
														<div class="form-group" >
															<label><b>Broj preuzimanja</b></label>
															<input type="text" class="form-control productNumberOfDownloads" placeholder="Broj preuzimanja">
														</div>
													</div>
													<div class="col-sm-4" style="background: rgb(248, 255, 208); ">
														<div class="form-group" >
															<label>&nbsp;</label>
															<div class="form-control" style="border:0; background: transparent;"></div>
														</div>
													</div>
												</div>
												</div>
												<div class="col-sm-12">
											 	<div class="row">
													<div class="col-sm-12">
														<br>
														<h4><b>Opis proizvoda</b></h4>
														<div class="row productDescriptionCont " style="background: rgb(248, 255, 208);"></div>
													</div>
												</div>
												</div>
												<div class="col-sm-12">
											 	<div class="row">
													<div class="col-sm-12">
														<br>
														<h4><b>Karakteristike proizvoda</b></h4>
														<div class="row productCharacteristicsCont " style="background: rgb(248, 255, 208);"></div>
													</div>
												</div>
												</div>
												<div class="col-sm-12">
											 	<div class="row">
													<div class="col-sm-12">
														<br>
														<h4><b>Specifikacija proizvoda</b></h4>
														<div class="row productSpecificationCont " style="background: rgb(248, 255, 208);"></div>
													</div>
												</div>
												</div>
												<div class="col-sm-12 hide">
											 	<div class="row">
													<div class="col-sm-12">
														<br>
														<h4><b>Model</b></h4>
														<div class="row productModelCont" style="background: rgb(248, 255, 208);"></div>
													</div>
												</div>
												</div>
												<div class="col-sm-12">
												<div class="row" style="background: #eee;">
                    							    <div class="col-md-12" >
                    							        <button class="btn btn-primary verticalMargin10 saveAddChange">Snimi</button>
                    							    </div>
                    							</div>
                    							</div>
												
                        			  		</div><!-- TAB ROW END -->     
                        			    </div><!-- TAB END -->
                        					</div><!-- TAB CONTENT END -->
										</div>	
								 	</div>
                        		 	<br>                     
                     			</div><!-- BOX ROW END-->
 							</div><!-- BOX BODY END-->
            		</div><!-- BOX END-->
           	</div>
           	<div class="col-xs-12 hide">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">


						 </div>	
					</div>
				</div>
			</div>
           	<div id="productWarehouseSection" class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<h2><b><i class="fa fa-money" aria-hidden="true"></i> CENE I KOLIČINE</b></h2>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #eee;">
										<br>
										<h4><b>Dodaj cenu i količinu</b></h4>
									</div>
									<div class="col-sm-12 "  style="background-color: #eee;">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label><b>Odaberite magacin</b></label>
													<div class="input-group" style="width: 100%;">
														<select class="form-control selectWarehouse" style="width: 100%;">
     														<?php
                          										  $query = "SELECT w.warehouseid, w.name FROM `warehouse` AS w ORDER BY w.warehouseid ASC";
                          										  $res = mysqli_query($conn, $query);
                          										    while($row = mysqli_fetch_assoc($res)){ ?>
                          										      <option value="<?php echo $row['warehouseid']; ?>"><?php echo $row['name']; ?></option>  
                          										  <?php }
                          										?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label><b>Količina</b></label>
													<input type="number" class="form-control newProductAmount" placeholder="Količina" value="0">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label><b>Cena(Cena bez pdv-a)</b></label>
													<input type="number" class="form-control newProductPrice" placeholder="Cena" value="0">
												</div>
											</div>
											<div class="col-sm-12">
												<button class="btn btn-primary addProductWarehouse" type="submit" >Dodaj</button>
												<br><br><br>
											</div>
										</div>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-12">
										<br>
										<h4><b>Cene i količine proizvoda u magacinima</b></h4>	
									</div>	
									<div class="col-sm-12" style="background: rgb(248, 255, 208);">

										<div class=" productWarehouseCont table-responsive" style="background: rgb(248, 255, 208);">
											<br>
											<table id="tableProductWarehouse" class="table table-bordered table-striped tableProductWarehouse" style="background: #fff;">
                                        		<thead>
                                        		    <tr>
                                        		        <th>R.b.</th>
                                        		        <th>Magacin</th>
                                        		        <th>Količina</th>
                                        		        <th>Cena</th>
                                        		        <th>Cena sa PDV-om</th>
                                        		        <th>Cena sa PDV-om i Web rabatom</th>
                                        		        <th></th>
                                        		    </tr>
                                        		</thead>
                                        	</table>
										</div>
									</div>	
								</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
			<div id="productImagesSection" class="col-xs-12 ">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<h2><b><i class="fa fa-picture-o"></i> SLIKE PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #eee;">
										<br>
										<h4><b>Dodaj novu sliku proizvoda</b></h4>
									</div>
							 	</div>
							</div>
							<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
							<div class="col-sm-12 "  style="background-color: #eee;">
								<div class="row">
							 		<div class="col-sm-12" >
										 
            							    <div id="selectImage" class="form_group">
            							        <label>Putanja do slike</label><br/>
            							        <input name="file" type="file" class="form-control proidimage" placeholder="Odaberite sliku" id="proidimage" style="display:none;" >

												<input name="proidimageselectedpath" type="text" class="form-control proidimageselectedpath" placeholder="Putanja do slike" id="proidimageselectedpath"  disabled><br>
												<button type="button" class="btn btn-primary" style="display:block;width:160px; height:30px;" onclick="document.getElementById('proidimage').click()">Odaberite sliku...</button>
            							        
            							    </div>
            							
									</div>

							 	</div>
								
							</div>
							<div class="col-sm-12" style="background-color: #eee;">
								<br>
								<button class="submit btn btn-primary addProductImage" type="submit"  >Dodaj</button>
								<br><br>
							</div>
							<div class="col-sm-12 ">
								<div id="image_preview" class="row image_preview" style="margin-top: 15px;">	
									<ul class="list-group" id="sortable" style="display: flex;">
					
            					    </ul>
            					    <div class="cl"></div>
								</div>
								
							</div>
							</form> 
						 </div>	
					</div>
				</div>
			</div>
           	<div id="productCategorySection" class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<h2><b><i class="fa fa-list-alt"></i> KATEGORIJE PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #eee;">
										<br>
										<h4><b>Dodaj novu kategoriju</b></h4>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12 "  style="background-color: #eee;">
											 	<div class="row">
											 		<div class="col-sm-12">
															<div class="form-group">
																<label><b>Odaberite kategoriju</b></label>
																<div class="input-group" style="width: 100%;">
																<select class="form-control productCategory" style="width: 100%;" productcategoryid=""  style="width: 100%;" required>
                    												<option value="0">---</option>
																	<?php
																		function get_all_deepest_cat($parid, $string)
																		{
																			global $conn;
																			$tmpstring = $string;
																			$query = "SELECT * FROM category WHERE parentid = ".$parid." ORDER BY name ASC ";
																			
																			$r = mysqli_query($conn,$query);
																			if(mysqli_num_rows($r) > 0)
																			{
																				while($row = mysqli_fetch_assoc($r))
																				{
																					$tmpstring = $string." >> ".$row['name'];
																					get_all_deepest_cat($row["id"],$tmpstring);		
																				}
																			}else{
																				echo '<option value="'.$parid.'">'.$string.'</option>';	
																			}
																		}
																		
																		function all_cat_php()
																		{
																			global $conn;
																			$query = "SELECT * FROM category WHERE parentid = 0 ORDER BY name ASC";
																			$result = mysqli_query($conn, $query);
																			$i = 1;
																			$bdata = array();
																			while($ar = mysqli_fetch_assoc($result))
																			{
																				get_all_deepest_cat($ar["id"],$ar["name"]);
																				
																			}	
																		}
																		
																		all_cat_php();
																		
																		
																	?>
                    												
                    											</select>
                    											</div>
															</div>
													</div>
											 		<div class="col-sm-12">
														<button class="btn btn-primary addProductCategory" type="submit" >Dodaj</button>
														<br><br><br>
													</div>
													
											 	</div>
											</div>
											<div class="col-sm-12">
											 	<div class="row" style="background: rgb(248, 255, 208);">
											 		<div class="col-sm-12">
														<br>
														<h4><b>Dodeljene kategorije</b></h4>
														
													</div>
												</div>
											</div>
											<div class="col-sm-12" style="background: rgb(248, 255, 208);">
														<div class="table-responsive" >
                                        				     <table id="tableProductCategorys" class="table table-bordered table-striped tableProductCategorys" style="background: #fff;">
                                        				        <thead>
                                        				            <tr>
                                        				                <th>R.b.</th>
                                        				                <th>Kategorija</th>
                                        				                <th>Hijerarhija</th>
                                        				                <th></th>
                                        				            </tr>
                                        				        </thead>
                                        				        
                                        				    </table>
                                        				</div>
											</div>
											<div class="col-sm-12 hide">
												<!-- 255, 216, 208 -->
											 	<div class="row" style="background: rgb(255, 216, 208);">
											 		<div class="col-sm-12">
														<br>
														<h4><b>Dodeljene Externe kategorije</b></h4>
														
													</div>
												</div>
											</div>
											<div class="col-sm-12 hide" style="background: rgb(255, 216, 208);">
														<div class="table-responsive" >
                                        				     <table id="tableProductExternalCategorys" class="table table-bordered table-striped tableProductExternalCategorys" style="background: #fff;">
                                        				        <thead>
                                        				            <tr>
                                        				                <th>R.b.</th>
                                        				                <th>Ext. Kategorija</th>
                                        				                <th>Hijerarhija ext. kategorija</th>
                                        				                
                                        				            </tr>
                                        				        </thead>
                                        				        
                                        				    </table>
                                        				</div>
											</div>
						 </div>	
					</div>
				</div>
			</div>
			<div id="productExtraDetailSection" class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #fff;">
										<h2><b><i class="fa fa-bookmark"></i> EXTRA DETALJI PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<h4><b>Odaberite extra detalje proizvoda</b></h4>
									</div>
							 	</div>
							</div>
							
							<div class="col-sm-12" style="background: rgb(248, 255, 208);padding-top: 10px;">
								<div class="row">	
								<?php 
									$query = "SELECT * FROM extradetail ORDER BY name ASC";
                    				$re = mysqli_query($conn, $query);
                    					        
                    				while($row = mysqli_fetch_assoc($re)){ ?>
                    					<div class="col-sm-3 productExtraDetailICheck <?php echo $row['id'];?>_productExtraDetailItem">
											<div class="form-group">
            						      		<input type="checkbox">
										  		<label><?php echo $row['name'];?></label>
										  	</div>
										</div>
							
								<?php } ?>	
								</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
			<div id="productAttributeSection" class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #fff;">
										<h2><b><i class="fa fa-cogs"></i> ATRIBUTI PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<h4><b>Atributi proizvoda po kategoriji</b></h4>
									</div>
							 	</div>
							</div>
											
							<div class="col-sm-12" style="/*background: rgb(248, 255, 208);*/">
								<div class="row attrProdCont">	
								
								</div>
							</div>
							<div class="col-sm-12 hr">
							 	<div class="row">
							 		<div class="col-sm-12">
							 			<br>
										<br>
										<br>
									</div>
							 	</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
           	<div id="productFilesSection" class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #fff;">
										<h2><b><i class="fa fa-files-o"></i> FAJLOVI PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #eee;">
										<h4><b>DODAJ NOVI FAJL</b></h4>
									</div>
							 	</div>
							</div>
							<form id="uploadProductFile" action="" method="post" enctype="multipart/form-data">
							<div class="col-sm-12 "  style="background-color: #eee; ">
								<div class="row">
									
										<div class="col-sm-4">
											<div class="form-group">
												<label><b>Tip</b></label>
												<div class="input-group" style="width: 100%;">
														<select class="form-control selectFileType" name="selectFileType" style="width: 100%;">
															<!-- <option value='n'>---</option> -->
															
															<option   value='file'>Fajl (.xls | .xlsx | .doc | .docx | .pdf)</option>
															<!--<option class="hide" value='vid'>Video</option>
															<option class="hide" value='yt'>Youtube video (Embedded link)</option> -->
														</select>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label><b>Naziv dokumenta</b></label>
												<input type="text" class="form-control productFileName" name="productFileName" placeholder="Naziv dokumenta">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
															
												<label for="InpProductFile" >Odaberite dokument</label>
												<input name="productFile" type="file" id="productFile" class="form-control productFilePath" placeholder="Odaberite dokument" id="InpProductFile" style="display:none;">

												
												<button type="button" class="btn btn-primary" style="display:block;width:160px; height:30px;" onclick="document.getElementById('productFile').click()">Odaberite fajl...</button>
															
											</div>
										</div>
										<div class="col-sm-12">
											<button class="btn btn-primary saveAddProductFile" type="submit" >Snimi</button>
								
											<br><br><br>
										</div>
									
								</div>
							</div>
							</form>
							<div class="col-sm-12 ">
							 	<div class="row">
							 		<div class="col-sm-12">			
										<h4><b>PRILOŽENI DOKUMENTI</b></h4>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
									<div class="table-responsive">
                                     		     <table id="tableProductFiles" class="table table-bordered table-striped tableProductFiles">
                                     		        <thead>
                                     		            <tr>
                                     		                <th>R.b.</th>
                                     		                <th>Tip</th>
                                     		                <th>Naziv</th>
                                     		                <th>Fajl</th>
                                     		                <th>Status</th>
                                     		                <th>Sort</th>
                                     		                <th></th>
                                     		            </tr>
                                     		        </thead>
                                     		        
                                     		    </table>
                                     		</div>
									</div>
							 	</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
			<div id="productDownloadSection" class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #fff;">
										<h2><b><i class="fa fa-files-o"></i> PRILOZI PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #eee;">
										<h4><b>DODAJ NOVI PRILOG</b></h4>
									</div>
							 	</div>
							</div>
							<form id="addProductDownload" action="" method="post" enctype="multipart/form-data">
							<div class="col-sm-12 "  style="background-color: #eee; ">
								<div class="row">
									
										<div class="col-sm-4">
											<div class="form-group">
												<label><b>Tip</b></label>
												<div class="input-group" style="width: 100%;">
														<select class="form-control selectDownloadType" name="selectDownloadType" style="width: 100%;">
															<!-- <option value='n'>---</option> -->
															<option  value='yt'>YouTube Video (Embedded link)</option> 
															<option  value='vid'>Video</option>
															<option value='ico'>Ikona</option>
															
															
														</select>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label><b>Primarni sadržaj priloga</b></label>
												<input type="text" class="form-control productDownloadContent" name="productDownloadContent" placeholder="Primarni sadržaj priloga">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label><b>Sekundarni sadržaj priloga</b></label>
												<input type="text" class="form-control productDownloadContentFace" name="productDownloadContentFace" placeholder="Sekundarni sadržaj priloga">
											</div>
										</div>
										<div class="col-sm-12">
											<button class="btn btn-primary saveAddProductDownload" type="submit" >Snimi</button>
								
											<br><br><br>
										</div>
									
								</div>
							</div>
							</form>
							<div class="col-sm-12 ">
							 	<div class="row">
							 		<div class="col-sm-12">			
										<h4><b>PRILOŽENI PRILOZI</b></h4>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
									<div class="table-responsive">
                                     		     <table id="tableProductDownload" class="table table-bordered table-striped tableProductDownload">
                                     		        <thead>
                                     		            <tr>
                                     		                <th>R.b.</th>
                                     		                <th>Tip</th>
                                     		                <th>Naziv</th>
                                     		                <th>Fajl</th>
                                     		                <th>Status</th>
                                     		                <th>Sort</th>
                                     		                <th></th>
                                     		            </tr>
                                     		        </thead>
                                     		        
                                     		    </table>
                                     		</div>
									</div>
							 	</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
			<div id="productAppSection" class="col-xs-12 hide">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row" style="margin:0;">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<h2><b><i class="fa fa-crosshairs" aria-hidden="true"></i> STORE LINKOVI PROIZVODA</b></h2>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12" style="background-color: #eee;">
										<br>
										<h4><b>Dodaj "Store" link proizvoda</b></h4>
									</div>
									<div class="col-sm-12 "  style="background-color: #eee;">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label><b>Odaberite tip "Store" linka</b></label>
													<div class="input-group" style="width: 100%;">
														<select class="form-control selectApplicationType" style="width: 100%;">
															<option value='n'>---</option>
															<option value='googleplay'>Google Play</option>
															<option value='appstore'>App Store</option>
															<option value='amazon'>Amazon</option>
															<option value='steam'>Steam</option>
															<option value='oculus'>Oculus Rift</option>
															<option value='facebook'>Facebook</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-sm-8">
												<div class="form-group">
													<label><b>"Store" Link</b></label>
													<input type="text" class="form-control newProductAppLink" placeholder='Unesite "Store" Link' value="">
												</div>
											</div>
											<div class="col-sm-12">
												<button class="btn btn-primary addProductApplication" type="submit" >Dodaj</button>
												<br><br><br>
											</div>
										</div>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-12">
										<br>
										<h4><b>Dodeljeni "Store" Linkovi proizvoda</b></h4>	
									</div>	
									<div class="col-sm-12" style="background: rgb(248, 255, 208);">

										<div class=" productApplicationCont table-responsive" style="background: rgb(248, 255, 208);">
											<br>
											<table id="tableProductApplication" class="table table-bordered table-striped tableProductWarehouse" style="background: #fff;">
                                        		<thead>
                                        		    <tr>
                                        		        <th>R.b.</th>
                                        		        <th>Tip "Store" Linka</th>
                                        		        <th>"Store" Link</th>
                                        		        <th>Status</th>
                                        		        <th>Sort</th>
                                        		        <th></th>
                                        		    </tr>
                                        		</thead>
                                        	</table>
										</div>
									</div>	
								</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
		   	<div id="productVideoSection" class="col-xs-12 hide">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row">
						 	<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
										<hr>	
										<br>
										<h4><b>PODNETI DOKUMENTI</b></h4>
										<br>
										<hr>
									</div>
							 	</div>
							</div>
							<div class="col-sm-12">
							 	<div class="row">
							 		<div class="col-sm-12">
									<div class="table-responsive">
                                     		     <table id="tableProductVideo" class="table table-bordered table-striped tableProductVideo">
                                     		        <thead>
                                     		            <tr>
                                     		                <th>R.b.</th>
                                     		                <th>Tip dokumenta</th>
                                     		                <th>Naziv</th>
                                     		                <th>Datum dokumenta</th>
                                     		                <th>Status</th>
                                     		                <th>Rešen</th>
                                     		                <th></th>
                                     		            </tr>
                                     		        </thead>
                                     		    </table>
                                     		</div>
									</div>
							 	</div>
							</div>
						 </div>	
					</div>
				</div>
			</div>
        </div><!-- ADD CHANGE CONT END-->
           
 	</section>
 	<?php if($currentview=='change'){
			include('sidehotlinkbutton.php');
		}?>
 	<?php if($currentview=='change'){
			include('sidehotlink.php');
		}?>
 	<!-- /.content -->
</div>

 <div class="modal fade" id="imgAttrModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
			<div class="form-group">
 	        	<label>Izaberite atribut</label>
            	<select class="form-control imgAttrModalSelect">

				</select>
          	</div>
            <div class="form-group">
 	        	<label></label>
	           	<select class="form-control imgAttrValueModalSelect" style="display:none;">
               	
				</select>
          	</div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default saveImgAttrValueButton" >Snimi</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
        </div>
      </div>
    </div>
</div>