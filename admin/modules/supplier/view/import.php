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
         
         <div class="row addChangeCont ">
			 <div class="col-xs-12">
				<div class="box box-primary box-body importProductsCont">
				<h4 class="box-title">Uvoz proizvoda</h4>
				<i class="fa fa-refresh fa-spin fa-2x loadingIconImport hide"></i>
				<div class="row">
					<div class="col-sm-12 ">
						 
						<form id="jq_importFilePricelistForm" action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>Dobavljač</label>
								<select name="importfilepricelist_type">
									<option value="0"> --- izaberite dobavljača --- </option>
									<?php 
										$q = "SELECT * FROM suppliers WHERE importtype IN ('xls','xlsx') ORDER BY sort ASC";
										$res = mysqli_query($conn, $q);
										if(mysqli_num_rows($res) > 0){
											while($row = mysqli_fetch_assoc($res)){
												echo '<option value="'.$row['internalcode'].'">'.$row['name'].'</option>';
											}
										}
									?>
								</select>
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
			</div><!-- /.box -->
			 </div><!-- /.col -->

    </div>

</div>
           
</section>
 	<!-- /.content -->
 </div>
 