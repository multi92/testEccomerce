 <div class="content-wrapper" currentview='home'>
 	<section class="content-header">
 		<h1>
 			Vaučeri
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
 			<li class="active"> Vaučeri</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
             	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                 
                 <?php endif;?>
                 <button class="btn btn-primary" id="listButton">Lista vaučer</button>
             </div>
         </div>
         
         <div class="row listCont">
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box">
                 
				  <div class="box-header">
                 	<h3 class="box-title">Dodaj vaučer</h3>
                 </div><!-- /.box-header -->
				  <div class="box-body">
				  	<div class="row verticalMargin30">
						<div class="col-sm-4">
							<div class="fomr-group">
								<label>Email</label>
								<input type="email" name="newCouponEmail" class="form-control jq_newCouponEmail" required="required">
							</div>
						</div>
						
						<div class="col-sm-2">
							<div class="fomr-group">
								<label>Vrednost kupona</label>
								<input type="email" name="newCouponValue" class="form-control jq_newCouponValue" required="required">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="fomr-group">
								<label> </label> <br>
								<a name="newCouponValue" class=" btn btn-primary jq_newCouponAddButton" disabled="disabled">Dodaj</a>
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
 									<th>Vaučer</th>
 									<th>Vrednost</th>
									<th>Zemlja</th>
 									<th>Email</th> 									
                                    <th>Status</th>
 									<th>Kreiran</th>
 									<th>Upotrebljen</th>
									<th>Generisan po</th>
									<th>Iskorišćen po</th>
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