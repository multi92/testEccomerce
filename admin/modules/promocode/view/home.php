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
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Vaučer</label>
								<input type="text" name="newVoucher" class="form-control jq_voucher" required="required">
							</div>
						</div>
						
						
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Tip</label>
								<select  name="newVoucherType" class="form-control jq_newVoucherType" required="required">
									<option value="a">Odnosi se na sve</option>
									<option value="c">Na dodeljene kategorije</option>
									<option value="p">Na dodeljene proizvode</option>
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
                          			      <option value="<?php echo $row['warehouseid']; ?>"><?php echo $row['name']; ?></option>  
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
 									<th>Vaučer</th>
									<th>Magacin</th>
 									<th>Tip</th> 									
                                    <th>Datum isteka</th>
 									<th>Status</th>
 									<th>Primeni na proizvode sa aktivnim popustom</th>
									<th></th>
 								  </tr>
 								</thead>
                             </table>
                 </div><!-- /.box-body -->
				 
				
               </div><!-- /.box -->
             </div><!-- /.col -->
	
           </div>
           
 	</section>
 	<!-- /.content -->
 </div>