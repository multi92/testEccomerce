<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-bookmark"></i> Dobavljač <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
 			<li><a href="extradetail"><i class="fa fa-bookmark"></i> Lista dobavljača</a></li>
 			<li class="active"> Dobavljač <?php echo $viewtype;?></li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista dobavljača</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 
						<div class="row">
						 	<div class="col-sm-6">
								<div class="form-group">
									<label>Ime dobavljača</label>
									<input type="text" class="form-control cln-name" placeholder="Ime dobavljača">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Šifra</label>
									<input type="text" class="form-control cln-code">
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>ID prefix</label>
									<input type="text" class="form-control cln-idprefix">
								</div>
							</div>
						 
							<div class="col-sm-6">
								<div class="form-group">
									<label>Marža (%)</label>
									<input type="text" class="form-control cln-margin">
								</div>
							</div>
						 	
							<div class="col-sm-6">
								<div class="form-group">
									<label>Dodati maržu kategorije</label>
									<input type="checkbox" class="form-control cln-addmargin">
								</div>
							</div>
							
							
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Tip dobavljača</label>
									<div class="row typeCont">
										<div class="col-sm-12 typeSelectHolder">
											<select class="form-control cln-type">
												<option value="0">-- izaberite tip --</option>
												<option value="primary">Primarni</option>
												<option value="secondary">Sekundarni</option>
											</select>
										</div>
									</div>	
								 </div>
							</div>
						 </div> 
						 
						
                        <div class="form-group">
                            <label>Sort</label>
                            <input type="number" class="form-control cln-sort" />
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
 
 