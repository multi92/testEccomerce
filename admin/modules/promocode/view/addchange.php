<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-percent"></i> Vaučer 
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li><a href="voucher"><i class="fa fa-percent"></i> Lista vaučera</a></li>
 			<li class="active"> Vaučer</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista vaučera</button>
             </div>
         </div>
         
         <div class="row addChangeCont ">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
					 	
						 <div class="row verticalMargin30">
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Naziv </label>
									<input type="text" class="form-control voucherNameInput" placeholder="Naziv">
								</div>
								<div class="form-group">
									<label>Vaučera</label>
									<input type="text" class="form-control voucherInput" placeholder="Vaučer" disabled="disabled">
								</div>
								<div class="form-group">
									<label>Datum isteka</label>
									<input type="text" class="form-control voucherExipratinDateInput" placeholder="Datum isteka">
								</div>
								<div class="form-group voucherValue">
									<label>Vrednost u %</label>
									<input type="number" class="form-control voucherValueInput" placeholder="Vrednost u %">
								</div>
								<div class="form-group">
									<label>Tip</label>
									<select   class="form-control voucherTypeInput" disabled="disabled">
										<option value="a">Odnosi se na sve</option>
										<option value="c">Na dodeljene kategorije</option>
										<option value="p">Na dodeljene proizvode</option>
									</select>
									
								</div>
								<div class="form-group">
									<label>Primeni na proizvode sa aktivnim popustom</label>
									<select   class="form-control voucherApplyOnProductWithRebateInput" disabled="disabled">
										<option value="y">Da</option>
										<option value="n">Ne</option>
									</select>
									
								</div>
								<div class="form-group">
									<label>Magacin</label>
									<select class="form-control voucherWarehouseIdInput" disabled="disabled">
									<option value="0">---</option>
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
						 
                         <br>
                         <a class="btn btn-primary saveAddChange">Snimi</a>     

                     </div>
                     <hr>
                     <div class="box-body voucher_category hide">
                     	<h4>Kategorije</h4>
                     	<div class="row " style="background: rgb(248, 255, 208); margin-right: 0px;  margin-left: 0px;">
                     		<div class="col-sm-8 ">
								<div class="form-group">
									<label>Kategorija </label>
									<select   class="form-control newCategoryId" style="width:100%" >
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
																echo '<option value="'.$row["id"].'">'.$tmpstring.'</option>';
																get_all_deepest_cat($row["id"],$tmpstring);		
															}
														}else{
															//echo '<option value="'.$parid.'">'.$string.'</option>';	
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
															echo '<option value="'.$ar["id"].'">'.$ar["name"].'</option>';
															get_all_deepest_cat($ar["id"],$ar["name"]);
															
														}	
													}
													
													all_cat_php();
													
													
												?>
									</select>
								</div>
							</div>
							<div class="col-sm-2 ">
								<div class="form-group">
									<label>Vrednost u %</label>
									<input type="number" class="form-control newCategoryValue" placeholder="Vrednost">
								</div>
							</div>
							<div class="col-sm-2 ">
								<div class="form-group">
									<a class="btn btn-primary form-control addCategory" style="margin-top: 24px;">Dodaj</a>
								</div>
							</div>
                     	</div>
                     	<div class="row " style=" margin-right: 0px;  margin-left: 0px;" >
                     		<div class="col-sm-12" style="background: rgb(248, 255, 208);">

										<div class=" voucherCategoryCont table-responsive" style="background: rgb(248, 255, 208);">
											<br>
											<table id="tableVoucherCategory" class="table table-bordered table-striped tableVoucherCategory" style="background: #fff;">
                                        		<thead>
                                        		    <tr>
                                        		        <th>R.b.</th>
                                        		        <th>Kategorija</th>
                                        		        <th>Putanja</th>
                                        		        <th>Vrednost popusta u %</th>
                                        		        <th></th>
                                        		    </tr>
                                        		</thead>
                                        	</table>
										</div>
							</div>	
                     	</div>
                     	
                     </div>
                     <div class="box-body voucher_product hide">
                     	<h4>Proizvodi</h4>
                     	<div class="row " style="background: rgb(248, 255, 208);  margin-right: 0px;  margin-left: 0px;">
                     		<div class="col-sm-8 ">
								<div class="form-group">
									<label>Proizvod </label>
									<select   class="form-control newProductId" style="width:100%">
										<option value="0">---</option>
										<?php /*global $conn;
											  $query = "SELECT p.* FROM product AS p WHERE p.code!='' AND p.active='y' ORDER BY code ASC";
											  $result = mysqli_query($conn, $query);
											  $i = 1;
											  $bdata = array();
											  while($ar = mysqli_fetch_assoc($result))
											  {
											  	echo '<option value="'.$ar["id"].'">'.$ar["code"].' | '.$ar["barcode"].' | '.$ar["name"].'</option>';
											  	
											  }	*/?>
									</select>
								</div>
							</div>
							<div class="col-sm-2 ">
								<div class="form-group">
									<label>Vrednost u %</label>
									<input type="number" class="form-control newProductValue" placeholder="Vrednost">
								</div>
							</div>
							<div class="col-sm-2 ">
								<div class="form-group">
									<label>&nbsp;</label>
									<a class="btn btn-primary form-control addProduct" style="">Dodaj</a>
								</div>
							</div>
                     	</div>
                     	<div class="row " style=" margin-right: 0px;  margin-left: 0px;" >
                     		<div class="col-sm-12" style="background: rgb(248, 255, 208);">

										<div class=" voucherProductCont table-responsive" style="background: rgb(248, 255, 208);">
											<br>
											<table id="tableVoucherProduct" class="table table-bordered table-striped tableVoucherProduct" style="background: #fff;">
                                        		<thead>
                                        		    <tr>
                                        		        <th>R.b.</th>
                                        		        <th>Šifra</th>
                                        		        <th>Barkod</th>
                                        		        <th>Proizvod</th>
                                        		        <th>Kategorija</th>
                                        		        <th>Putanja kategorije</th>
                                        		        <th>Vrednost popusta u %</th>
                                        		        <th></th>
                                        		    </tr>
                                        		</thead>
                                        	</table>
										</div>
							</div>	
                     	</div>
                     </div>

 				</div><!-- /.box -->
             </div><!-- /.col -->
           </div>
		   
            
   
            </div>
           
 	</section>
 	<!-- /.content -->
 </div>