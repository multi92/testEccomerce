<?//var_dump($_SESSION['search']['member']);?>
 <div class="content-wrapper" currentview='home'>
 	<section class="content-header -breadcrumbColor">
        <div class="row">
             <div class="col-sm-6 ">
 		         <h1 style="margin: 0; font-size: 24px;">
 		         	<i class="fa fa-archive"></i> Proizvodi
 		         </h1>
            </div>
            <div class="col-sm-6 ">
               
                <div style="height: 100%;
                            background: #575757;
                            float:right;
                            top: 0;
                            
                            width:150px;
                           ">
        
                            <a data-toggle="control-sidebar" class="btn btn-search detalj"><i class="fa fa-search" style="margin-right: 5px; font-size: 25px; color: #fff;"></i> Pretraga</a>
                        </div>
                         <ol class="breadcrumb" style="top:10px; float:right; background-color: transparent; margin-bottom: 0; ">
                            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
                            <li class="active"><i class="fa fa-archive"></i> Proizvodi</li>
        
                            
                </ol>

            </div>
        </div>
    
 		
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
             	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                 <button class="btn btn-primary" id="addButton" alt="Novi član"><i class="fa fa-plus-square" aria-hidden="true"></i> Novi unos</button>
              <?php endif;?>
                 <button class="btn btn-primary" id="listButton"><i class="fa fa-th-list" aria-hidden="true"></i> Lista proizvoda</button>
				          <!-- <button class="btn btn-primary" id="newsCategoryButton">Kategorije vesti</button> -->
             </div>
         </div>
         
         <div class="row listCont">
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box">
                 <div class="box-header">
                   <h3 class="box-title">Lista svih proizvoda u bazi</h3>
                 </div><!-- /.box-header -->
                 <div class="box-body table-responsive">
                 	
                     <table id="listtable" class="table table-bordered table-striped">
 								<thead>
                    <tr>
                        <th>R.b.</th>
                        <th>Sifra</th>
                        <th>Barkod</th>
                        <th>Slika</th>
                        <th>Naziv</th>
                        <th>Proizvodjač</th>
                        <th>Tip</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th>Sifrarnik</th>
                        <th>Količina</th>
                        <th>B2C cena</th>
                        <th>B2B cena</th>
                        
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
    <aside class="control-sidebar control-sidebar-dark control-search-sidebar">
        <?php include("sidesearch.php");?>
        </aside>
<div class="control-search-sidebar-bg"></div>

 </div>
 