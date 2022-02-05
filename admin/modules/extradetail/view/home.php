 <div class="content-wrapper" currentview='home'>
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-bookmark"></i> Extra detalji
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li class="active"><i class="fa fa-bookmark"></i> Extra detalji</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
             	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                 <button class="btn btn-primary" id="addButton">Novi extra detalj</button>
                 <?php endif;?>
                 <button class="btn btn-primary" id="listButton">Lista extra detalja</button>
             </div>
         </div>
         
         <div class="row listCont">
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box">
                 <div class="box-header">
                   <h3 class="box-title">Lista svih extra detalja u bazi</h3>
                 </div><!-- /.box-header -->
                 <div class="box-body">
                 	
                     <table id="listtable" class="table table-bordered table-striped">
 								<thead>
 								  <tr>
 									<th>Redni broj</th>
 									<th>Ime</th>
 									<th>Status</th>
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