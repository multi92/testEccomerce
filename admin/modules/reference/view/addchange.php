<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header">
 		<h1>
 			Reference
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
 			<li class="active"> Gradovi</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista referenci</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
					 	<div class="form-group">
							<label>Slika</label>
							<input type="text" class="form-control referenceImageInput" />
						</div>
						<div class="form-group">
							<label>Link</label>
							<input type="text" class="form-control referenceLinkInput" />
						</div>
						 <div class="row">
						 
							<div class="clearfix"></div>
							
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Grad </label>
									<a class="pull-right"  href="city">Izmeni gradove</a>
									<div class="row cityCont">
										<div class="col-sm-12 citySelectHolder">
											<select class="form-control citycont" >
												<option value="">-- izaberite grad --</option>
												<?php
				
													$query = "SELECT * FROM city ORDER BY name ASC";
													$r = mysqli_query($conn,$query);
													if(mysqli_num_rows($r) > 0)
													{
														while($row = mysqli_fetch_assoc($r)){
															echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';		
														}
													}	
												
												?>
											</select>
										</div>
									
									</div>	
								 </div>
							</div>
							
							
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Branša </label>
									<a class="pull-right"  href="branch">Izmeni branše</a>
									<div class="row branchCont">
										<div class="col-sm-12 branchSelectHolder">
											<select class="form-control branchcont"  >
												<option value="">-- izaberite branšu --</option>
												<?php
				
													$query = "SELECT * FROM branch ORDER BY name ASC";
													$r = mysqli_query($conn,$query);
													if(mysqli_num_rows($r) > 0)
													{
														while($row = mysqli_fetch_assoc($r)){
															echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';		
														}
													}	
												
												?>
											</select>
										</div>
									
									</div>	
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
 
 