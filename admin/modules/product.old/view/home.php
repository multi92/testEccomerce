<div class="content-wrapper">
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-archive"></i> Proizvodi
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-archive"></i> Proizvodi</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <?php if($module_conf["show_extradetail"][1]==1){?>
                <button class="btn btn-primary" id="toggleExtraDetail">Extra detalji</button>
                <?php }?>
                <?php if($module_conf["show_relations"][1]==1){?>
                <button class="btn btn-primary" id="toggleRealtions">Relacije</button>
                <?php }?>
                <button class="btn btn-primary" id="toggleNewProduct">Novi proizvod</button>
                <?php if($module_conf["show_brend"][1]==1){?>
				<button class="btn btn-primary <?php echo ($module_conf["show_brend_button"][1] == '0')? 'hide':' '; ?>" id="toggleNewBrand">Brendovi</button>
                <?php }?>
                <?php if($module_conf["show_import_product"][1]==1){?>
				<button class="btn btn-primary" id="toggleImportProducts">Uvezi proizvode</button>
                <?php }?>
                <?php if($module_conf["show_barometar"][1]==1){?>
				<button class="btn btn-primary" id="copy_barometar">Kopiraj barometar</button>
                <?php }?>
            </div>
        </div>
		<div class="row" style="height=400px; min-height:auto;">
			<?php 
					$q = "SELECT SUM(IF(p.`active`='y', 1,0)) AS astatus,SUM(IF(p.`active`='n', 1,0)) AS nstatus,count(p.ID) AS `totalcnt`, 0 AS `flag` 
							FROM product AS p GROUP BY `flag`";
					$re = mysqli_query($conn, $q);
					$row = mysqli_fetch_assoc($re);
			?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					
					<span class="info-box-icon bg-green"><i class="ion ion-ios-box-outline"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Broj aktivnih proizvoda</span>
						<span class="info-box-number"><?php echo $row["astatus"]?> / <?php echo $row["totalcnt"]?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">

					<span class="info-box-icon bg-red"><i class="ion ion-ios-box-outline"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Broj neaktivnih proizvoda</span>
						<span class="info-box-number"><?php echo $row["nstatus"]?> / <?php echo $row["totalcnt"]?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<?php 
					$q = "SELECT count(pr.id) AS `cnt` FROM (SELECT  p.id AS id
							FROM product AS p 
							LEFT JOIN product_file AS pf ON p.id=pf.productid AND pf.`type`='img'
							WHERE pf.productid IS NOT NULL
							GROUP BY p.id) AS pr";
					$re = mysqli_query($conn, $q);
					$row = mysqli_fetch_assoc($re);
					?>
					<span class="info-box-icon bg-aqua"><i class="ion ion-android-image"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Broj proizvoda sa slikom </span>
						<span class="info-box-number"><?php echo $row["cnt"]?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</div>
        
        <div class="box box-primary box-body newProductCont" style="display:none;">
        	<h4 class="box-title">Novi proizvod</h4>
            <div class="row">
  				<div class="col-sm-3">
                	<div class="form-group">
                    	<label>Sifra proizvoda</label>
                        <input type="text" class="form-control newProductCode" />
                    </div>
                </div>
                <div class="col-sm-3">
                	<div class="form-group">
                    	<label>Naziv proizvoda</label>
                        <input type="text" class="form-control newProductName" />
                    </div>
                </div>
                <div class="col-sm-1">
                	<div class="form-group">
   		                <label>&nbsp;</label>
                		<button class="btn btn-primary form-control newProductAddButton">Dodaj</button>
                    </div>
                </div>
                
                
            </div>
        </div>
        
        <div class="box box-primary box-body extraDetailCont" style="display:none;">
        	<h4 class="box-title">Extra detalji</h4>
            <div class="row">
                <div class="col-sm-3 listExtraDetail">
                	<ul class="list-group">
                    	<?php
							$query = "SELECT * FROM extradetail";
							$re = mysqli_query($conn, $query);
							while($arow = mysqli_fetch_assoc($re))
							{
								echo '<li class="list-group-item pointer extraDetailListItem" extraDetailid = "'.$arow['id'].'">
										<a>'.$arow['name'].'</a>
										<span class="pull-right"><button class="btn btn-xs btn-danger deleteExtraDetailButton">X</button></span>
									  </li>';
							}
						?>
                    </ul>
                    
                    <a class="btn btn-default btn-block btn-social addExtradetailFormButton">
                        <i class="fa fa-plus"></i> Dodaj novi extra detalj
                      </a>
                </div>
                <div class="col-sm-6 dataExtraDetail" extraDetailDataid="">
                	<div class="form-group statusExtraDetailCont hide">
                    	<label>Status</label>
                        <select class="form-control statusExtraDetail">
                        	<option value="v">Vidljivo</option>
                            <option value="h">Sakriveno</option>
                        </select>

                    </div>
                	<div class="row extradetailNameCont">
                    
                    </div>
                    <div class="form-group showInWelcomepageExtraDetailCont hide">
                    	<label>Prikaži na početnoj</label>
                    	<select class="form-control showInWelcomepageExtraDetail">
                    	    	<option value="y">Da</option>
                    	        <option value="n">Ne</option>
                    	</select>
                	</div>
                	<div class="form-group showInWebShopExtraDetailCont hide">
                    	<label>Prikaži u webshop-u</label>
                    	<select class="form-control showInWebShopExtraDetail">
                    	    	<option value="y">Da</option>
                    	        <option value="n">Ne</option>
                    	</select>
                	</div>
                	<div class="form-group banerExtraDetailCont hide">
                    	<label>Baner</label>
                    	<select class="form-control banerExtraDetail">
                    	    	<option value="0">---</option>
                    	    	<?php
							$query = "SELECT * FROM banner";
							$re = mysqli_query($conn, $query);
							while($arow = mysqli_fetch_assoc($re))
							{?>
								<option value="<?php echo $arow['id']; ?>"><?php echo $arow['name']; ?></option>
							<?php }
						?>
                    	</select>
                	</div>
                    <button class="btn btn-primary saveExtraDetailButton hide" >Snimi</button>
                </div>
            </div>
        </div>
        
        <div class="box box-primary box-body relationsCont" style="display:none;">
        	<h4 class="box-title">Relacije</h4>
            <div class="row">
                <div class="col-sm-3 listRelations">
                	<ul class="list-group">
                    	<?php
							$query = "SELECT * FROM relations";
							$re = mysqli_query($conn, $query);
							while($arow = mysqli_fetch_assoc($re))
							{
								echo '<li class="list-group-item pointer relationsListItem" relationsid = "'.$arow['id'].'">
										<a>'.$arow['name'].'</a>
									  </li>';
							}
						?>
                    </ul>
                    
                </div>
                <div class="col-sm-6 dataRelations" relationsDataid="">
                	<div class="form-group statusRelationsCont hide">
                    	<label>Status</label>
                        <select class="form-control statusRelations">
                        	<option value="v">Vidljivo</option>
                            <option value="h">Sakriveno</option>
                        </select>
                    </div>
                	<div class="row relationsNameCont">
                    
                    </div>

                    <button class="btn btn-primary saveRelationsButton hide" >Snimi</button>
                </div>
            </div>
        </div>
		
		 <div class="box box-primary box-body importProductsCont" style="display:none;">
        	<h4 class="box-title">Uvoz proizvoda</h4>
            <div class="row">
                <div class="col-sm-12 ">
                	
					
					 <form id="jq_importFileForm" action="" method="post" enctype="multipart/form-data">
						
						<div class="form-group">
							<label>Fajl za uvoz (.csv)</label>
							<input type="file" name="importfile" class=" jq_importFile" required />
						</div>
						<div class="form-group">
							<label> </label>
							<input type="submit" name="" value="Uvezi" class="btn btn-primary jq_importFileButton" />
						</div>
						
					</form>
					
					<div class="callout callout-success jq_importFileSuccess hide">
						<h4>Uspešno dodati proizvodi!</h4>
					</div>
					<div class="callout callout-danger jq_importFileFail hide">
						<h4>Greška prilikom dodavanja proizvoda!</h4>
						<p></p>
					</div>
					
                </div>
            </div>
        </div>
        
        <div class="box box-primary box-body">
        	<h4 class="box-title">Pretraga proizvoda</h4>
            <div class="row">
				<div class="col-sm-12">
					
					<div class="checkbox">
						<label><input type="checkbox" class="jq_imageY" > Sa slikom </label>
					</div>
					<div class="checkbox">
						<label><input type="checkbox" class="jq_imageN" > Bez slike </label>
					</div>
				
					<div class="checkbox">
						<label><input type="checkbox" class="jq_activeY" > Aktivni </label>
					</div>
					<div class="checkbox">
						<label><input type="checkbox" class="jq_activeN" > Neaktivni </label>
					</div>
					<div class="checkbox">
						<label>Tip</label>
						<select class="jq_typeSearchCont">
							<option value="0">Svi</option>
							<option value="r">Regularan</option>
							<option value="q">Na upit</option>
							<option value="vp">Grupni</option>
							<option value="vpi-r">Član grupnog proizvoda - Regularan</option>
                            <option value="vpi-q">Član grupnog proizvoda - Na upit</option>
						</select>
					</div>
					
					
				</div>
                <div class="col-sm-4">
                	<input type="text" class="form-control serachProductInput" /> 
                    <button class="btn btn-primary verticalMargin10 searchProductButton">Pronadji</button>
                </div>
            </div>
        </div>
        
        <div class="row productTableCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista proizvoda</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	
					
                    <table id="example1" class="table table-bordered table-striped">
								<thead>
								  <tr>
									<th>Sifra</th>
                                    <th>Barkod</th>
									<th>Naziv</th>
									<th>Šifra proizvodjača</th>
									<th>Tip</th>
									<th>Status</th>
									<th>Sort</th>
                                    <th>Sifrarnik</th>
									<th>Izmeni</th>
								  </tr>
								</thead>
                            </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div>
        
        <div class="box box-primary box-body productDataCont hide" productid="">
            <div class="row">
                        <div class="col-md-10">
                            <h4 class="box-title">Detalji proizvoda</h4>
                        </div>
                        <div class="col-md-2">
                             <a href="" target="_blank" class="btn btn-primary showProductButton hide">Pogledaj proizvod</a>
                        </div>
            </div>    
            
            <hr />
            		<h5>Naziv proizvoda</h5>
           			<div class="row productNameCont">
                    	 
                    </div>
                    
                    <hr />
                   
                    
           			<div class="row">
                     	<div class="col-md-2">
                        	<label>Aktivan</label>
                        	<input type="checkbox" class="productActive" />
							<br />
							<div class="<?php echo ($module_conf["show_extrawarrnity"][1]!='1')? 'hide':''; ?>">
								<label>Produ. garancija</label>
                        		<input type="checkbox" class="productExtendWarrnity" />
							</div>
                        </div>
                        <div class="col-md-2">
                        	<label>Sifra *</label>
                        	<input type="text" class="form-control productCode" required/>
                        </div>
                        
                        <div class="col-md-3 <?php echo ($module_conf["show_barcode"][1]!='1')? 'hide':''; ?>">
                        	<label>Barkod</label>
                        	<input type="text" class="form-control productbarcode" />
                        </div>
                        
                        <div class="col-md-2 <?php echo ($module_conf["show_manufcode"][1]!='1')? 'hide':''; ?>">
                        	<label>Šifra proizvodjaca</label>
                        	<input type="text" class="form-control productManufcode" />
                        </div>
                                                
                        <div class="col-md-3 <?php echo ($module_conf["show_brend"][1]!='1')? 'hide':''; ?>">
                        	<div class="form-group">
								<label>Brend</label>
								<select class="form-control brendselect2 select2-hidden-accessible productBrend" style="width: 100%;" tabindex="-1" aria-hidden="true">
								  
								  <option value="0"> -- izaberite brend -- </option>
								  <?php
										$query = "SELECT * FROM brend";
										$re = mysqli_query($conn, $query);
										while($arow = mysqli_fetch_assoc($re))
										{
											echo '<option value="'.$arow['id'].'">'.$arow['name'].'</option>';
										}
									?>
							  	  </select>
							  </div>
							
                        </div>
                     </div>
                     
                     <div class="row">
                     	
                        <div class="col-md-1  <?php echo ($module_conf["show_amount"][1]!='1')? 'hide':''; ?>">
                        	<label>Količina</label>
                        	<input type="text" class="form-control productQuantity" style="text-align: right;"/>
                        </div>

                        <div class="col-md-2  <?php echo ($module_conf["show_unitstep"][1]!='1')? 'hide':''; ?>">
                            <label>Korak jed. mere</label>
                            <input type="number" class="form-control productUnitStep" style="text-align: right;"/>
                        </div>
                        
                        <div class="col-md-1 <?php echo ($module_conf["show_rebate"][1]!='1')? 'hide':''; ?>">
                        	<label>Rabat</label>
                        	<input type="number" class="form-control productRebate" style="text-align: right;"/>
                        </div>
                        
                        <div class="col-md-2 <?php echo ($module_conf["show_priceB2C"][1]!='1')? 'hide':''; ?>">
                        	<label>Cena B2C</label>
                        	<input type="text" class="form-control productPriceB2C" style="text-align: right;"/>
                        </div>
                        <div class="col-md-2 <?php echo ($module_conf["show_priceB2CWithVat"][1]!='1')? 'hide':''; ?>">
                            <label>Cena B2C sa porezom</label>
                            <input type="text" class="form-control productPriceB2CWithVat" style="text-align: right;" disabled/>
                        </div>
                        <div class="col-md-2 <?php echo ($module_conf["show_priceB2B"][1]!='1')? 'hide':''; ?>">
                        	<label>Cena B2B</label>
                        	<input type="text" class="form-control productPriceB2B" style="text-align: right;"/>
                        </div>
                        <div class="col-md-2 <?php echo ($module_conf["show_priceB2BWithVat"][1]!='1')? 'hide':''; ?>">
                            <label>Cena B2B sa porezom</label>
                            <input type="text" class="form-control productPriceB2BWithVat" style="text-align: right;" disabled/>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-2 <?php echo ($module_conf["show_tax"][1]!='1')? 'hide':''; ?>">
                            <label>Porez *</label>
                            <select class="form-control productTax" required>
                                <option value=""></option>
                                <?php 
                                    $query = "SELECT * FROM tax";
                                    $re = mysqli_query($conn, $query);
                                    while($arow = mysqli_fetch_assoc($re))
                                    {
                                        echo '<option value="'.$arow['id'].'">'.$arow['name'].' - '.$arow['value'].'%</option>';
                                    }
                                ?>
                            </select>
                            
                        </div>
						<div class="col-md-2 <?php echo ($module_conf["show_type"][1]!='1')? 'hide':''; ?>">
							<label>Tip proizvoda</label>
                            <select class="form-control productType">
									<option value="r">Regularan</option>
									<option value="q">Na upit</option>
									<option value="vp">Grupni</option>
                                    <option value="vpi-r">Član grupnog proizvoda - Regularan</option>
                                    <option value="vpi-q">Član grupnog proizvoda - Na upit</option>
							</select>
                        </div>
                        
                     </div>
					<div class="<?php echo ($module_conf["show_unitname"][1]!='1')? 'hide':''; ?>">
                        <h4 >Jedinica mere *</h4>
                        <div class="row productUnitNameCont "></div>
                    </div>
					<div class="<?php echo ($module_conf["show_manufname"][1]!='1')? 'hide':''; ?>">
                    	<h4 >Ime proizvodjaca</h4>
                    	<div class="row productManufnameCont "></div>
					</div>
                    
					<div class="<?php echo ($module_conf["show_searchwords"][1]!='1')? 'hide':''; ?>">
                    	<h4>Reci za pretragu</h4>
                    	<div class="row productSearchwordsCont "></div>
					</div>

					<div class="<?php echo ($module_conf["show_description"][1]!='1')? 'hide':''; ?>">
                        <h4>Opis *</h4>
                        <div class="row productDescriptionCont"></div>
                    </div>

                    <div class="<?php echo ($module_conf["show_specification"][1]!='1')? 'hide':''; ?>">
                        <h4>Specifikacija</h4>
                        <div class="row productSpecificationCont"></div>
                    </div>
					
					<div class="<?php echo ($module_conf["show_characteristics"][1]!='1')? 'hide':''; ?>">
						<h4>Karakteristike</h4>
						<div class="row productCharacteristicsCont"></div>
                    </div>
					
					<div class="<?php echo ($module_conf["show_model"][1]!='1')? 'hide':''; ?>">
						<h4>Model</h4>
						<div class="row productModelCont"></div>
                    </div>
					
					
					
					
					                         
                        
					<div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary verticalMargin10 saveProductButton">Snimi</button>
                        </div>
                    </div>
                    
                    <hr />
                    
                    <h5 class="<?php echo ($module_conf["show_extradetail"][1]!='1')? 'hide':''; ?>">Extra detalji proizvoda</h5>
                    <div class="row <?php echo ($module_conf["show_extradetail"][1]!='1')? 'hide':''; ?>">
						<?php
                            $query = "SELECT * FROM extradetail";
                            $re = mysqli_query($conn, $query);
                            
                            while($row = mysqli_fetch_assoc($re))
                            {
                                echo '<div class="col-sm-2 '.$row['id'].'_productExtraDetailItem">
                                    <label>'.$row['name'].'</label>
                                    <input type="checkbox"  /> 
                                </div>';	
                            }
                        ?>
                    </div>
                    
            <hr />
            <h5>Kategorija proizvoda *</h5>
            <div class="row categoryCont">			
                <div class="col-sm-5 verticalMargin10 categorySelectHolder">
					<select class="form-control categoryselect2 productcategorycont" style="width: 100%;" tabindex="-1" aria-hidden="true" productcategoryid="" required>
                    	<option value="0">-- izaberite kategoriju --</option>
						<?php
							function get_all_deepest_cat($parid, $string)
							{
								global $conn;
								$tmpstring = $string;
								$query = "SELECT * FROM category WHERE id = ".$parid;
								
								$r = mysqli_query($conn,$query);
								if(mysqli_num_rows($r) > 0)
								{
							
								$row = mysqli_fetch_assoc($r);
									if($row['parentid'] == 0)
									{
										$tmpstring .= ">>".$row['name'];
										return $tmpstring;
									}
									else
									{		
										return ">>".$row['name'].get_all_deepest_cat($row["parentid"],$tmpstring);		
									}
								}	
							}
							
							function all_cat_php()
							{
								global $conn;
								$query = "SELECT * FROM category ";
								$result = mysqli_query($conn, $query);
								$i = 1;
								$bdata = array();
								while($ar = mysqli_fetch_assoc($result))
								{
									if($ar["parentid"] == 0)
									{
										$data = array();
										array_push($data, $ar["id"]);
										array_push($data, $ar["name"]);
										array_push($bdata, $data);
										
									}
									else
									{
										$data = explode(">>", get_all_deepest_cat($ar["parentid"],""));
										unset($data[0]);
										array_push($data,$ar["id"]); 
										$data = array_reverse($data);		
										array_push($data, $ar["name"]);
										array_push($bdata, $data);
									}
								}
								return $bdata;	
							}
							
							foreach(all_cat_php() as $key=>$val)
							{
								$id = $val[0];
								unset($val[0]);
								echo '<option value="'.$id.'">'.implode(" >> ", $val).'</option>';	
								
							}
							
						?>
                    	
                    </select>
                </div>
                <div class="col-sm-5 verticalMargin10 categoryButtonHolder">
                      <a class="btn btn-default btn-block btn-social addCategoryFieldButton verticalMargin10">
                        <i class="fa fa-plus"></i> Dodaj novo polje za kategoriju
                      </a>
                </div>
                
                
            </div>
            
			<?php if($user_conf["quantity_rebate"][1] > 0){ ?>
			<hr />         
            <div class="row <?php echo ($module_conf["show_quantityrebate"][1]!='1')? 'hide':''; ?> ">
				<div class="col-sm-4">
												
					<h4>Kolicinski rabati</h4>
					<table>
						<tr class="jq_productQuantityRebateTemplate hide">
								<td class="jq_productQuantityHolder"></td>
								<td><span class="jq_productRebateHolder"></span>%</td>
								<td><select class="form-control input-sm jq_productStatusHolder">
										<option value="h">Sakriven</option>
										<option value="v">Vidljiv</option>
									</select></td>
								<td><button class="btn btn-xs btn-danger deleteProductQuantityRebateItem">X</button></td>
							</tr>
					</table>
					
					<table class="table table-striped table-condensed jq_productQuantityRebateCont" id="sortable">
						<thead>
							<tr>
								<th>Kolicina</th>
								<th>Rabat</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					
				</div>
				<div class="col-sm-6">
					<h4>&nbsp;</h4>
					
					<form>
						<div class="form-group">
							<label>Kolicina</label>
							<input type="text" class="form-control jq_productNewQuantityInput" />
						</div>
						<div class="form-group">
							<label>Rabat</label>
							<input type="text" class="form-control jq_productNewRebateInput" />
						</div>
						<div class="form-group">
							<label>Cena sa PDV</label>
							<input type="text" class="form-control jq_productNewRebatePriceInput" />
						</div>
					</form>
					
					<button class="btn btn-primary verticalMargin10 jq_addProductQuantityReabateButton">Dodaj rabat</button>
				</div>
			</div>
			<?php } ?>
			
			
			<?php if($module_conf["show_barometar"][1]==1){?> 
            <hr />
            
           
            <div class="row ">
				<div class="col-sm-4">
												
					<h4>Barometar</h4>
					
					<div class="form-group">
						<label>Izaberite datum</label>
						<input class="form-control jq_BarometarDateInput" />
					</div>
					
					
					<table>
						<tr class="jq_productBarometarTemplate hide">
								<td class="jq_productBarometarMinHolder"></td>
                                <td class="jq_productBarometarMaxHolder"></td>
                                <td class="jq_productBarometarObjectHolder"></td>
								<td><button class="btn btn-xs btn-danger deleteProductBarometarItem">X</button></td>
							</tr>
					</table>
					
					<table class="table table-striped table-condensed jq_productBarometarCont" id="sortable">
						<thead>
							<tr>
								<th>Min cena</th>
								<th>Max cena</th>
								<th>Pijaca</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					
				</div>
				<div class="col-sm-6">
					<h4>&nbsp;</h4>
					
					<form>
						
						<div class="form-group">
							<label>Min cena</label>
							<input type="text" class="form-control jq_productNewBarometarMinInput" />
						</div>
						<div class="form-group">
							<label>Max cena</label>
							<input type="text" class="form-control jq_productNewBarometarMaxInput" />
						</div>
						<div class="form-group">
							<label>Pijaca</label>
							<select class="form-control jq_productNewBarometarObjectSelect">
                            	<option value="0"> --- Izaberite pijacu --- </option>
								<?php
                                    $query = "SELECT * FROM object ORDER BY name ASC";
                                    $re = mysqli_query($conn, $query);
                                    
                                    while($row = mysqli_fetch_assoc($re))
                                    {
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';	
                                    }
                                ?>					
                            </select>
						</div>
					</form>
					
					<button class="btn btn-primary verticalMargin10 jq_addProductBarometarButton">Dodaj</button>
				</div>
			</div>
            <?php } ?>        
            <h5 class="<?php echo ($module_conf["show_relations"][1]!='1')? 'hide':''; ?>">Relacije proizvoda</h5>
           
            <div class="row <?php echo ($module_conf["show_relations"][1]!='1')? 'hide':''; ?>">
    			<div class="col-sm-12">
                	 <ul class="nav nav-tabs navTabsCont">
                        
                     </ul>
                     
                     <div class="tab-content relationsTabCont">
                     
                     </div>
                </div>
            </div>
            
            <hr />
            
            <h5 class="<?php echo ($module_conf["show_file"][1]!='1')? 'hide':''; ?>">Dokumenta proizvoda</h5>
            <div class="row <?php echo ($module_conf["show_file"][1]!='1')? 'hide':''; ?>">
                    	<div class="col-sm-2">
                        	<div class="form-group">
                            	<label>Tip</label>
                                <select class="form-control newProductDownloadType">
                                	<option value="doc">dokument</option>
                                    <option value="yt">youtube</option>
                                    <option value="ext">eksterni link</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                        	<div class="form-group">
                            	<label>Putanja</label>
                               	<input type="text" class="form-control newProductDownloadContent" />
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                        	<div class="form-group">
                            	<label>Putanja slike</label>
                                <input type="text" class="form-control newProductDownloadContentimg" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                        	<button class="btn btn-primary addProductDownload">Dodaj</button>
                        </div>
                    </div>
      
            <div class="row productDownloadCont <?php echo ($module_conf["show_file"][1]!='1')? 'hide':''; ?>">
                    	<div class="col-sm-12">
                        	<table class="table table-condensed table-responsive">
                            	<thead>
                                	<tr>
                                    	<td>Tip</td>
                                        <td>Sadrzaj</td>
                                        <td>Slika</td>
                                        <td></td>
                                    </tr>
                                     <!--	category item template 	 -->	
                                    <tr class="hide productDownloadItemTemplate">
                                        <td>dokument</td>
                                        <td><a href="">Ime fajla.pdf</a></td>
                                        <td><img src="" height="50" data-featherlight=""  /></td>
                                        <td><button class="btn btn-danger deleteProductDownload">Obrisi</button></td>
                                    </tr>
                                </thead>
                                <tbody class="productDownloadItemCont">
                                	 
                                </tbody>
                            </table>
                        </div>
                    </div>
            
            
            <hr />
            <h5>Slike proizvoda</h5>  
            
            <div id="image_preview">
            	<ul class="list-group" id="sortable">

                </ul>
                <div class="cl"></div>
            </div>
            <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                <div id="selectImage" class="form_group">
                    <label>Izaberite sliku</label><br/>
                    <input type="file" name="file" id="file" class="form-control" required />
                    <input type="hidden" name="proid" id="proidimage" value="" />
                    <input type="submit" value="Dodaj" class="submit btn btn-primary" />
                </div>
            </form> 
            
            <hr />
            
            <h5 class="<?php echo ($module_conf["show_attr"][1]!='1')? 'hide':''; ?>">Atributi proizvoda</h5>
            <div class="row attrProdCont <?php echo ($module_conf["show_attr"][1]!='1')? 'hide':''; ?>">
                <div class="col-sm-2">
                	<h3>Ime atributa</h3>
                    
                </div>
            </div>
        </div>
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

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