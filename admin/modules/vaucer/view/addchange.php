<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
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
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista vaučera</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
					 
					 	<div class="row verticalMargin30">
							<div class="col-sm-4">
								<div class="fomr-group">
									<label>Email</label>
									<input type="email" name="newCouponEmail" class="form-control jq_newCouponEmail" required="required">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="fomr-group">
									<label>Vrednost kupona</label>
									<input type="email" name="newCouponValue" class="form-control jq_newCouponValue" required="required">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="fomr-group">
									<label> </label> <br>
									<a name="newCouponValue" class=" btn btn-primary jq_newCouponAddButton">Dodaj</a>
								</div>
								
							</div>
						</div>
						
						
						 <div class="row">
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Naziv </label>
									<input type="text" class="form-control shopsNameInput" placeholder="Naziv prodavnice">
								</div>
								<div class="form-group">
									<label>Adresa</label>
									<input type="text" class="form-control shopsAddressInput" placeholder="Adresa prodavnice ">
								</div>
								<div class="form-group">
									<label>Fiksni telefon</label>
									<input type="text" class="form-control shopsPhoneInput" placeholder="Fiksni telefon ">
								</div>
								
							</div>
							
						 </div>
						 
                         <div class="row addChangeLangCont">
                         	
                         </div> 
                         <br>
                         <a class="btn btn-primary saveAddChange">Snimi</a>                       
                     </div>
 				</div><!-- /.box -->
             </div><!-- /.col -->
           </div>
		   
            
   
            </div>
           
 	</section>
 	<!-- /.content -->
 </div>