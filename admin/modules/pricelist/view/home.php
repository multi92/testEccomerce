 <div class="content-wrapper" currentview='home'>

  <section class="content-header -breadcrumbColor">
    <h1>
      <i class="fa fa-newspaper-o"></i> Cenovnici
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
      <li class="active"><i class="fa fa-newspaper-o"></i> Cenovnici</li>
    </ol>
  </section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
             	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                 <button class="btn btn-primary" id="addButton">Novi cenovnik</button>
                 <?php endif;?>
                 <button class="btn btn-primary" id="listButton">Lista cenovnika</button>
                 <button class="btn btn-primary" id="toggleImportProducts">Uvezi proizvode</button>
             </div>
         </div>
         
         <div class="box box-primary box-body importProductsCont" style="display:none;">
        	<h4 class="box-title">Uvoz proizvoda</h4>
			<i class="fa fa-refresh fa-spin fa-2x loadingIconImport hide"></i>
            <div class="row">
            	
                <div class="col-sm-12 ">
					<form id="jq_importFilePricelistForm" action="" method="post" enctype="multipart/form-data">
						<div class="row">
                        	<div class="col-sm-6">
                                <select class="form-control jq_pricelistImportSelectCont" required name="pricelistid">
                                    <option value="0" > --- Izaberite cenovnik --- </option>
                                    <?php 
                                        $q = "SELECT * FROM pricelist ORDER BY name ASC";
                                        $res = mysqli_query($conn, $q);
                                        if(mysqli_num_rows($res) > 0){
                                            while($row = mysqli_fetch_assoc($res)){
                                                echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
							<label>Fajl za uvoz (.xls/.xlsx)</label>
							<input type="file" name="importfilepricelist" class=" jq_importFilePricelist" required />
						</div>
						<div class="form-group">
							<label> </label>
							<input type="submit" name="" value="Uvezi" class="btn btn-primary jq_importFilePricelistButton" />
						</div>
					</form>
					
					<div class="callout callout-success jq_importFileSuccess hide">
						<h4>Uspešno dodati proizvodi!</h4>
					</div>
					<div class="callout callout-danger jq_importFileFail hide">
						<h4>Greška prilikom dodavanja proizvoda!</h4>
						<p></p>
					</div>
					
                </div>
            </div>
        </div>
         
         <div class="row listCont">
             <div class="col-xs-12">
               <!-- /.box -->
 
               <div class="box">
                 <div class="box-header">
                   <h3 class="box-title">Lista svih prodavnica u bazi</h3>
                 </div><!-- /.box-header -->
                 <div class="box-body">
                 	
                     <table id="listtable" class="table table-bordered table-striped">
 								<thead>
 								  <tr>
 									<th>Redni broj</th>
 									<th>Naziv</th>
 									<th>Opis</th>
									<th>Sort</th>
 									<th>Status</th>
 									<th>Izmeni</th> 
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