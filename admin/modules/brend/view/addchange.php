<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-star"></i> Brend <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li><a href="dashboard"><i class="fa fa-star"></i> Brendovi</a></li>
 			<li class="active"> Brend</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista brendova</button>
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
                                    <label>Slika</label>
                                    <input type="text" class="form-control brendImageInput" placeholder="Slika">
                                </div>
                            </div>
							<div class="col-sm-6 ">
                                
                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="text" class="form-control brendLinkInput" placeholder="Ime">
                                </div><!-- 
                                <div class="form-group">
                                    <label>Opis</label>
                                    <textarea class="form-control pricelistDescriptionTextarea" placeholder="Opis"></textarea>
                                </div> -->
                            </div>
                            <div class="col-sm-6 ">
                                
                                <div class="form-group">
                                    <label>Link target</label>
                                    <select class="form-control brendLinkTarget" >
                                        <option value="_self">Self</option>
                                        <option value="_blank">Blank</option>
                                     </select>
                                </div><!-- 
                                <div class="form-group">
                                    <label>Opis</label>
                                    <textarea class="form-control pricelistDescriptionTextarea" placeholder="Opis"></textarea>
                                </div> -->
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