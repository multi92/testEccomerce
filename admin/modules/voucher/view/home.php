 <div class="content-wrapper" currentview='home'>
 	<section class="content-header -breadcrumbColor">
        <div class="row">
             <div class="col-sm-6 ">
 		         <h1 style="margin: 0; font-size: 24px;">
 		         	<i class="fa fa-percent"></i> Vaučer
 		         </h1>
            </div>
            <div class="col-sm-6 ">
               
                <div style="height: 100%;
                            background: #575757;
                            float:right;
                            top: 0;
                            
                            width:150px;
                           ">
        
                           
                        </div>
                         <ol class="breadcrumb" style="top:10px; float:right; background-color: transparent; margin-bottom: 0; ">
                            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
                            <li class="active"><i class="fa fa-percent"></i> Vaučer</li>
        
                            
                </ol>

            </div>
        </div>
    
 		
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
             	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                 
                 <?php endif;?>
                 <button class="btn btn-primary" id="listButton">Lista vaučera</button>

             </div>
         </div>
         
        <div class="row listCont">
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box" >
                 
				  <div class="box-header">
                 	<h3 class="box-title">Dodaj vaučer</h3>
                 </div><!-- /.box-header -->
				  <div class="box-body" style="background: rgb(248, 255, 208);">
				  	<div class="row verticalMargin30">
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Naziv</label>
								<input type="text" name="newVoucherName" class="form-control jq_voucherName" required="required">
							</div>
						</div>
						<!---<div class="col-sm-4">
							<div class="fomr-group">
								<label>Vaučer</label>
								<input type="text" name="newVoucher" class="form-control jq_voucher" required="required">
							</div>
						</div>
					-->
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Tip vaučera</label>
								<select  name="newVoucherQuantityDiscount" class="form-control jq_newVoucherQuantityDiscount" required="required">
									<option value="w">Welcome vaučer</option>
									<option value="hp">HappyBirthady vaučer</option>
									<option value="s">Standardni vaučer</option>
								</select>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Vaučer se odnosi na</label>
								<select  name="newVoucherType" class="form-control jq_newVoucherType" required="required">
									<option value="a">Odnosi se na sve</option>
									<option value="c">Na dodeljene kategorije</option>
									<option value="p">Na dodeljene proizvode</option>
								</select>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Tip popusta</label>
								<select  name="newVoucherType" class="form-control jq_newVoucherTypeDiscount" required="required">
									<option value="P">Popust izrazen u procentima</option>
									<option value="T">Totalni popust</option>
									<option value="I">Individualni popust</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Primeni na proizvode sa aktivnim popustom</label>
								<select  name="newVoucherApplyOnProductWithRebate " class="form-control jq_newVoucherApplyOnProductWithRebate" required="required">
									<option value="n">Ne</option>
									<option value="y">Da</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Magacin</label>
								<select  name="newCouponWarehouseId" class="form-control jq_newCouponWarehouseId" required="required">
									<option value="0">---</option>
									<?php
                          			  $query = "SELECT w.warehouseid, w.name FROM `warehouse` AS w ORDER BY w.warehouseid ASC";
                          			  $res = mysqli_query($conn, $query);
                          			    while($row = mysqli_fetch_assoc($res)){ ?>
                          			    	<?php if($row['name'] == "B2B"){ ?>
                          			      		<option hidden> value="<?php echo $row['warehouseid']; ?>"><?php echo $row['name']; ?></option> 
                          			      	<?php } else {?>
                          			      		<option value="<?php echo $row['warehouseid']; ?>"><?php echo $row['name']; ?></option>
                          			      	<?php }?> 
                          			  <?php }
                          			?>	
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Datum isteka</label>
								<input type="text" name="newVoucherExpirationDate " class="form-control jq_newVoucherExpirationDate" required="required" value="<?php echo date("d.m.Y");?>">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Slika</label>
								<input type="text" name="newVoucherImage" class="form-control jq_voucherImage" >
							</div>
						</div>
						<div class="col-sm-4">
							<div class="fomr-group">
								<label> </label> <br>
								<a name="addNewVoucherCode" class=" btn btn-primary jq_addNewVoucherButton" >Dodaj</a>
							</div>
							
						</div>
					</div>
				  </div>
				 
				 
				 <div class="box-header">
                   <h3 class="box-title">Lista svih vaučera u bazi</h3>
                 </div><!-- /.box-header -->
                 <div class="box-body">
                 	
                     <table id="listtable" class="table table-bordered table-striped">
 								<thead>
 								  <tr>
 									<th>Redni broj</th>
 									<th>Naziv</th>
 									<th>Tip vaučera</th>
									<th>Magacin</th>
 									<th>Tip</th> 									
                                    <th>Datum isteka</th>
 									<th>Status</th>
 									<th>Tip popusta</th>
 									<th>Primeni na proizvode sa aktivnim popustom</th>
									<th></th>
 								  </tr>
 								</thead>
                             </table>
                 </div><!-- /.box-body -->

                 
                 	<!--</div> -->
                 </div> 				
               </div><!-- /.box -->
             
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box" >
                 
				  <div class="box-header">
                 	<h3 class="box-title">Korisnički vaučeri</h3>
                 </div><!-- /.box-header -->
				  <div class="box-body" style="background: rgb(248, 255, 208);">
				  	<div class="row verticalMargin30">
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Aktivni korisnici</label>
								<select   class="form-control newUserId" style="width:100%" >
										<option value="0" >---</option>
														<?php															
															function all_usr_php()
															{
																global $conn;
																$query = "SELECT * FROM user AS u WHERE u.`type`='user'";
																$result = mysqli_query($conn, $query);
																$i = 1;
																$bdata = array();
																while($ar = mysqli_fetch_assoc($result))
																{
																echo '<option value="'.$ar["id"].'">'.$ar["name"].' '.$ar["surname"].' | '.$ar["email"].'</option>';
																		
																}	
															}
																	
										
											 				all_usr_php();
														
														?>
									</select>
							</div>
						</div>
						<!---<div class="col-sm-4">
							<div class="fomr-group">
								<label>Vaučer</label>
								<input type="text" name="newVoucher" class="form-control jq_voucher" required="required">
							</div>
						</div>
					-->
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Aktivni vaučeri</label>
								<select   class="form-control newVoucherId" style="width:100%" >
										<option value="0">---</option>
										<?php															
											function all_vouchers_php()
											{
												global $conn;
												$query = "SELECT * FROM voucher AS v WHERE v.`status`=\"y\"";
												$result = mysqli_query($conn, $query);
												$i = 1;
												$bdata = array();
												while($ar = mysqli_fetch_assoc($result))
												{
												echo '<option value="'.$ar["id"].'">'.$ar["name"].'</option>';
														
												}	
											}
											all_vouchers_php();	
										?>
								</select>
							</div>
						</div>
						
						<!--<div class="col-sm-4">
							<div class="fomr-group">
								<label>Vaučer se odnosi na</label>
								<select  name="newVoucherType" class="form-control jq_newVoucherType" required="required">
									<option value="a">Odnosi se na sve</option>
									<option value="c">Na dodeljene kategorije</option>
									<option value="p">Na dodeljene proizvode</option>
								</select>
							</div>
						</div>-->
						
						<div class="col-sm-4">
							<div class="fomr-group">
								<label> </label> <br>
								<a name="addNewUserVoucher" class=" btn btn-primary jq_addNewUserVoucherButton" >Dodaj</a>
							</div>
							
						</div>
					</div>
				  </div>
				 
				 
				 <div class="box-header">
                   <h3 class="box-title">Lista svih korisnika koji poseduju vaučer</h3>
                 </div><!-- /.box-header -->
                 <div class="box-body">
                 	
                     <table id="listvouchertable" class="table table-bordered table-striped">
 								<thead>
 								  <tr>
 									<th>Redni broj</th>
 									<th>Email korisnika</th>
 									<th>Kod vaučera</th>
 									<th>Status</th> 									
                                    <th>Datum kreiranja</th>
                                    <th>Iskorišćen dana</th>
									<th></th>
 								  </tr>
 								</thead>
                             </table>
                 </div><!-- /.box-body -->

                 
                 	<!--</div> -->
                 </div> 				
               </div><!-- /.box -->


             


             </div><!-- /.col -->

	
        </div>

	
        </div>
 		    
    </section>
 	<!-- /.content -->
 </div>