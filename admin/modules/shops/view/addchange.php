<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-newspaper-o"></i> Prodavnica <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li><a href="dashboard"><i class="fa fa-newspaper-o"></i> Prodavnice</a></li>
 			<li class="active"> Prodavnica</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista prodavnica</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
                     	 <div class="row addChangeLangCont">
                         		
                         </div>
                     
						 <div class="row">
						 	
							<div class="col-sm-6 ">
								
								<div class="form-group">
									<label>Fiksni telefon</label>
									<input type="text" class="form-control shopsPhoneInput" placeholder="Fiksni telefon ">
								</div>
								<div class="form-group">
									<label>Mobilni telefon</label>
									<input type="text" class="form-control shopsMobileInput" placeholder="Mobilni telefon">
								</div>
								<div class="form-group">
									<label>Fax</label>
									<input type="text" class="form-control shopsFaxInput" placeholder="Fax ">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" class="form-control shopsEmailInput" placeholder="Email ">
								</div>
								<div class="form-group">
									<label>Kordinate</label>
									<input type="text" class="form-control shopsCoordinatesInput" placeholder="Kordinate prodavnice ">
								</div>
								<div class="form-group">
									<label>Slika</label>
									<input type="text" class="form-control shopsImageInput" placeholder="Slika prodavnice ">
								</div>
								<div class="form-inline form-group">
									<label>Radno vreme radni dan</label>
									<div class="row">
										<div class="col-sm-4">
											<label>Od: </label>
											<input type="text" class="form-control shopsWorkTimeWeekFrom" placeholder="  ">
										</div>
										<div class="col-sm-4">
											<label>Do: </label>
											<input type="text" class="form-control shopsWorkTimeWeekTo" placeholder="  ">
										</div>
									</div>
									
									<label>Radno vreme subota</label>
									<div class="row">
										<div class="col-sm-4">
											<label>Od: </label>
											<input type="text" class="form-control shopsWorkTimeSaturdayFrom" placeholder="  ">
										</div>
										<div class="col-sm-4">
											<label>Do: </label>
											<input type="text" class="form-control shopsWorkTimeSaturdayTo" placeholder="  ">
										</div>
									</div>
									
									<label>Radno vreme nedelja</label>
									<div class="row">
										<div class="col-sm-4">
											<label>Od: </label>
											<input type="text" class="form-control shopsWorkTimeSundayFrom" placeholder="  ">
										</div>
										<div class="col-sm-4">
											<label>Do: </label>
											<input type="text" class="form-control shopsWorkTimeSundayTo" placeholder="  ">
										</div>
									</div>
									
								</div>
								<div class="form-group">
									<label>Tip</label>
									<select class="form-control shopsTypeInput" >
										<option value=""> --- Izaberite tip --- </option>
										<option value="m">Maloprodaja</option>
										<option value="v">Veleprodaja</option>
									</select>
								</div>
								
								
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Grad </label>
									<a class="pull-right"  href="city">Izmeni gradove</a>
									<div class="row cityCont">
									<div class="col-sm-12 citySelectHolder">
									<select class="form-control newscitycont" newswarehouseid="" >
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
							
							<div class="clearfix"></div>
							
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Magacin </label>
									<a class="pull-right"  href="warehouse">Izmeni magacin</a>
									<div class="row categoryCont">
									<div class="col-sm-12 warehouseSelectHolder">
									<select class="form-control newswarehousecont" newswarehouseid="" >
										<option value="">-- izaberite magacin --</option>
										<?php
		
											$query = "SELECT * FROM warehouse ORDER BY name ASC";
											$r = mysqli_query($conn,$query);
											if(mysqli_num_rows($r) > 0)
											{
												while($row = mysqli_fetch_assoc($r)){
													echo '<option value="'.$row['warehouseid'].'">'.$row['name'].'</option>';		
												}
											}	
										
										?>
								
											</select>
										</div>
									
									</div>	
								 </div>
							</div>
							
							<div class="clearfix"></div>
							
							<div class="col-sm-6 ">
								<div class="form-group">
									<label>Galerija prodavnice</label>
									<a class="pull-right"  href="gallery">Izmeni galerije</a>
									<div class="row categoryCont">
									<div class="col-sm-12 gallerySelectHolder">
									<select class="form-control newsgallerycont" newsgalleryid="" >
										<option value="">-- izaberite galeriju --</option>
										<?php
		
											$query = "SELECT * FROM gallery WHERE status = 'v' ORDER BY name ASC";
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