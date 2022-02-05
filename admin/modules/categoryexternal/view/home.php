 <div class="content-wrapper" currentview='home'>
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-cogs"></i> Učitane kategorije
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna </a></li>
 			<li class="active"><i class="fa fa-cogs"></i> Učitane kategorije </li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista učitanih kategorija</button>
             </div>
         </div>
         
         <div class="row listCont">
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box">
                 <div class="box-header">
                   <h3 class="box-title">Lista svih učitanih kategorija u bazi</h3>
                   <div class="row">
                    	<div class="col-sm-1">
                           <div class="checkbox">
                                <label>Povezani</label>
                                <select class="jq_connectedCategorySearchCont form-control">
                                    <option value="0" selected="selected">Svi</option>
                                    <option value="y">Da</option>
                                    <option value="n">Ne</option>
                                </select>
                            </div>
                         </div>
                         <div class="col-sm-2">
                            <div class="checkbox">
                                <label>Dobavljač</label>
                                <select class="jq_supplierSearchCont form-control">
                                		<option value="0" selected="selected">Svi</option>
                                	 <?php 
										$query = "SELECT * FROM suppliers";
										$re = mysqli_query($conn, $query);
										while($arow = mysqli_fetch_assoc($re))
										{
											echo '<option value="'.$arow['id'].'">'.$arow['name'].'</option>';
										}
									?>
                                </select>
                            </div>
                            
                            
                        </div>
                   </div>
                 </div><!-- /.box-header -->
                 <div class="box-body">
                 	 <table id="listtable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Redni broj</th>
                                <th>Učitana kategorija</th>
                                <th>Ukupno proizvoda</th>
                                <th>Aktivnih proizvoda</th>
                                <th>Lokalna kategorija</th>
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