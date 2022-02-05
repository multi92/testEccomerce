<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-picture-o"></i> Galerija <?php echo $viewtype;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
			<li><a href="gallery"><i class="fa fa-picture-o"></i> Lista Galerija</a></li>
			<li class="active"> Galerija</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>

		<div class="row">
			<div class="col-sm-12 verticalMargin10">
				<button class="btn btn-primary" id="listButton">Lista galerija</button>
			</div>
		</div>
		<div class="row addChangeCont">
			<div class="col-xs-12">
				<div class="box ">
					<div class="box-header"></div>
					<div class=" box-body ">
						<h2>Opšte informacije</h2>
						<hr> 
						<div class="loaded" id=''></div>

						<?php 
						$q = "SELECT *, (SELECT name FROM gallery_tr WHERE galleryid = ".$command[2]." AND langid = l.id ) as nametr,
						(SELECT description FROM gallery_tr WHERE galleryid = ".$command[2]." AND langid = l.id ) as descriptiontr,
						(SELECT position FROM gallery WHERE id = ".$command[2]." ) as position,
						(SELECT sort FROM gallery WHERE id = ".$command[2]." ) as sort,
						(SELECT img FROM gallery WHERE id = ".$command[2]." ) as img,
						(SELECT `delete` FROM gallery WHERE id = ".$command[2]." ) as `delete`
						FROM languages l";

						$res = mysqli_query($conn, $q);
						$posrow = mysqli_fetch_assoc($res);

						?>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Pozicija</label>
									<select class="form-control galleryPositionSelect" <?php if($posrow['delete'] == 0) echo 'disabled'; ?>>
										<option value="gal" <?php if($posrow['position'] == 'gal') echo "selected='selected'"; ?>>Galerija</option>
										<option value="vid" <?php if($posrow['position'] == 'vid') echo "selected='selected'"; ?>>Video galerija</option>
										<option value="news" <?php if($posrow['position'] == 'news') echo "selected='selected'"; ?>>Vest</option>
										<option value="page" <?php if($posrow['position'] == 'page') echo "selected='selected'"; ?>>Stranica</option>
										<option value="page" <?php if($posrow['position'] == 'slider') echo "selected='selected'"; ?>>Slajder</option>
										
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Sort</label>
									<input type="number" class="form-control gallerySortInput" <?php if($posrow['delete'] == 0) echo 'disabled'; ?> value="<?php echo $posrow['sort']; ?>" />
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Default slika</label>
									<input type="text" class="form-control galleryDefaultImageInput" value="<?php echo $posrow['img']; ?>" />
								</div>
							</div>
							<div class="clearfix"></div>
							<?php 
							mysqli_data_seek($res, 0);
							while($row = mysqli_fetch_assoc($res)){
								echo '<div class="col-sm-4 galleryDataCont" langid="'.$row['id'].'" defaultlang="'.$row['default'].'">
								<div class="form-group">
								<label>Naziv galerije <span>'.$row['name'].'</span></label>
								<input type="text" class="form-control galleryDataName" value="'.$row['nametr'].'" />
								</div>
								<div class="form-group">
								<label>Opis galerije <span>'.$row['name'].'</span></label>
								<textarea class="form-control galleryDataDescription">'.$row['descriptiontr'].'</textarea>
								</div>
								</div>';	
							}
							?>

							<div class="col-sm-12">
								<button class="btn btn-primary verticalMargin10" id="changeDesc">Snimi</button>                    
							</div>

						</div>

						<hr>
						<?php if($posrow['position'] == 'slider') {?>
							<h2>Slike slajdera</h2>
						<?php } else { ?>
							<h2>Slike galerije</h2>
						<?php } ?>
						
						<hr> 
						<div class="row">
							<div class="col-sm-12 itemsCont sortable" id="links" >
								<?php 
								$q = "SELECT * FROM galleryitem WHERE galleryid = ".$command[2]." ORDER BY sort ASC";
								$res = mysqli_query($conn, $q);
								while($row = mysqli_fetch_assoc($res)){
									if($row['type'] == 'img'){
										echo '<div class="galleryItemCont ui-state-default" style="background-image:url(../'.$row['item'].');">
										<input type="button" class="btn btn-danger galleryItemButton" itemid="'.$row['id'].'" value="X">
										<input type="button" class="btn btn-danger pull-right galleryItemDetailButton" value="Detalji">
										</div>';	
									}
									else if($row['type'] == 'vid'){
										echo '<div class="galleryItemCont relativePosition ui-state-default" >
										<video width="250" height="130" controls><source src="../'.$row['item'].'" type="video/mp4"></video>
										<input type="button" class="btn btn-danger galleryItemButton topPosition" itemid="'.$row['id'].'" value="X">
										<input type="button" class="btn btn-danger pull-right galleryItemDetailButton topPosition rightPosition" value="Detalji">
										</div>';
									}
									else if($row['type'] == 'yt'){
										echo '<div class="galleryItemCont relativePosition ui-state-default" >
										<iframe width="250" height="150" src="'.$row['item'].'" frameborder="0" allowfullscreen></iframe>
										<input type="button" class="btn btn-danger galleryItemButton topPosition" itemid="'.$row['id'].'" value="X">
										<input type="button" class="btn btn-danger pull-right galleryItemDetailButton topPosition rightPosition" value="Detalji">
										</div>';	
									}
								}
								?>

							</div>
						</div>

						<hr>
						<h2>Dodaj/Izmeni informacije o slici</h2>
						<hr> 
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group row verticalMargin10">

											<div class="col-sm-12">
												<label class="_margineTop20">Tip</label>
												<select class="form-control addGalleryItemType">
													<option value="img" selected >Slika</option>
													<option value="vid" >Video</option>
													<option value="yt" >Youtube video</option>
												</select>
											</div>
											<div class="clearfix"></div>
											<div class="col-sm-12">
												<label class="_margineTop20">Putanja do sadrzaja</label>
												<input type="text" class="form-control addGalleryItemLink"/>
											</div>


											<div class="clearfix"></div>

											<?php 
											$hide="";
											if($posrow['position'] != 'slider'){ 
												$hide="hide";
											}?>
											<div class="col-sm-6 <?php echo $hide;?>">
												<label class="_margineTop20">Prikazi info segment</label>
												<select class="form-control addGalleryItemShowInfo">
													<option value="n" >Ne</option>
													<option value="y" selected >Da</option>
												</select>
											</div>
											<div class="col-sm-6 <?php echo $hide;?>">
												<label class="_margineTop20">Pozicija info segmenta</label>
												<select class="form-control addGalleryItemInfoPosition">
													<option value="l"  >Levo</option>
													<option value="c" selected>Centralno</option>
													<option value="r" >Desno</option>
												</select>
											</div>

											<div class="col-sm-12 <?php echo $hide;?>">
												<label class="_margineTop20">Slika info segmenta</label>
												<input type="text" class="form-control addGalleryItemInfoImg"/>
											</div>

											<div class="clearfix"></div>

											<?php
											foreach ($langfull as $val) {
												echo '<div class="form-group col-sm-12 newGalleryItemDescCont" langid="'.$val['id'].'" defaultlang="'.$val['default'].'">
												<label class="_margineTop20">' . ucfirst($val['name']) . ' naslov</label>
												<input type="text" class="form-control newGalleryItemTitle" />
												<label class="_margineTop20">' . ucfirst($val['name']) . ' opis</label>
												<textarea class="form-control newGalleryItemDesc"></textarea>
												</div>

												';
											}
											?>
											<div class="clearfix"></div>
											<div class="col-sm-12">
												<label class="_margineTop20">Link</label>
												<input type="text" class="form-control addGalleryItemJumpLink"/>
											</div>

										</div>
									</div>
									<?php include('slider.php');?>
								</div>
								<div class="row">
										<div class="col-sm-12 _margineTop20">
											<button class="btn btn-primary verticalMargin10 addGalleryItem">Dodaj</button>
											<button class="btn btn-primary verticalMargin10 saveGalleryItem" style="display:none;">
												Snimi
											</button>
											<button class="btn btn-primary verticalMargin10 addGalleryItemNewForm"
											style="display:none;">Dodaj novu stavku
										</button>
									</div>
								</div>	
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

		</section>
		<!-- /.content -->
	</div>

