<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-file-text-o"></i> Stranica <?php echo $viewtype;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
			<li><a href="dashboard"><i class="fa fa-file-text-o"></i> Lista Stranica</a></li>
			<li class="active"> Stranica</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
		
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista stranica</button>
            </div>
        </div>
        
        <div class="row addChangeCont hide">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header"></div>
                    <div class="box-body">
                    	<div class="checkbox">
                            <label>
                                <input type="checkbox" class="leftcheck" alt="Ukljuci levu kolonu na stranici" value="">
                                Leva kolona
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="rightcheck" alt="Ukljuci desnu kolonu na stranici" value="">
                                Desna kolona
                            </label>
                        </div>
                            <div class="form-group titleCont">
                            <label>Naziv stranice</label>
                            <input type="text" class="form-control titleInput" placeholder="Naziv stranice">
                        </div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Galerija vesti</label>
									<a class="pull-right"  href="gallery">Izmeni galerije</a>
									<div class="row categoryCont">
										<div class="col-sm-12 gallerySelectHolder">
											<select class="form-control gallerycont" galleryid="" >
												<option value="0">-- izaberite galeriju --</option>
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
                        
                        <div class="row addChangeLangCont">
                        	
                        </div> 
                        
                        <a class="btn btn-primary saveAddChange">Snimi</a>                       
                    </div>
				</div><!-- /.box -->
            </div><!-- /.col -->
          </div>
          
	</section>
	<!-- /.content -->
</div>
