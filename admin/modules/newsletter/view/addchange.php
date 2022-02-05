<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header">
 		<h1>
 			Vest
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
 			<li class="active"> Vesti</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista vesti</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
                     	<div class="form-group">
                             <label>Slika vesti</label>
                             <input type="text" class="form-control mainimage" placeholder="putanja do slike">
                         </div>
						 <div class="row">
							 <div class="col-sm-3 verticalMargin10 typeCont">
							 	 <label>Tip vesti</label>
								 <select class="form-control typeSelect">
									<option value="n">Vest</option>
									<option value="o">Oglas</option>
								 </select>
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