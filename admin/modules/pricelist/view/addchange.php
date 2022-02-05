<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-newspaper-o"></i> Cenovnik <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li><a href="dashboard"><i class="fa fa-newspaper-o"></i> Cenovnici</a></li>
 			<li class="active"> Cenovnik</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista cenovnika</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
						 <div class="row">
							<div class="col-sm-6 ">
								
								<div class="form-group">
									<label>Ime</label>
									<input type="text" class="form-control pricelistNameInput" placeholder="Ime">
								</div>
								<div class="form-group">
									<label>Opis</label>
                                    <textarea class="form-control pricelistDescriptionTextarea" placeholder="Opis"></textarea>
								</div>
							</div>
							
                            <?php if($currentview == 'change') { ?>
                                <div class="col-sm-6">
                                	<div class="form-group ">
                                        <label>Šifra proizvoda</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control jq_pricelistAddNewItemInput" />
                                            <span class="input-group-btn">
                                                <a class="btn btn-primary jq_pricelistAddNewItemButton">Dodaj</a>
                                            </span>
                                        </div>
                                    </div>
                                	
                                    <table id="pricelistItemsTable" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <th></th>
                                            <th>Šifra</th>
                                            <th>Naziv</th>
                                            <th>Rabat</th>
                                            <th>Izmeni</th> 
                                          </tr>
                                        </thead>
                                     </table>
                                </div>
                            <?php } ?>
						
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