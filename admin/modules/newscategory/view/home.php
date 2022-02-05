<div class="content-wrapper">
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-newspaper-o"></i> Kategorije vesti
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-newspaper-o"></i> Kategorije vesti</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>

		<div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="toggleCategoryRelations">Relacije kategorija vesti</button>
            </div>
        </div>
        
        <div class="box box-primary box-body categoryRelationsCont" style="display:none;">
        	<h4 class="box-title">Relacije kategorija vesti</h4>
            <div class="row">
                <div class="col-sm-6">
                	
                	<table>
                    	<tbody>
                    	<?php
							$query = "SELECT * FROM category_external";
							$re = mysqli_query($conn, $query);
							while($arow = mysqli_fetch_assoc($re))
							{
								echo '<tr>
										<td>
											<input type="text" class="form-control" value="'.$arow['name'].'" catid="'.$arow['id'].'" />
										</td>
										<td class="categoryListCont">
											<select class="form-control categoryList" pntcatid="'.$arow['id'].'">';
												echo "<option value='0' > -- izaberite kategoriju -- </option>";
												$q = "SELECT * FROM newscategory";
												$res = mysqli_query($conn, $q);
												if(mysqli_num_rows($res) > 0){
													while($row = mysqli_fetch_assoc($res)){
														$selected = "";
														if($arow['newscategoryid'] == $row['id']) $selected = "selected";
														echo "<option value='".$row['id']."' ".$selected.">".$row['name']."</option>";	
													}
												}
											echo '</select>
										</td>
									</tr>';
							}
						?>
                     	</tbody>
                    </table>
                   
                </div>
                <div class="col-sm-6 dataExtraDetail" extraDetailDataid="">
                	<div class="form-group statusExtraDetailCont hide">
                    	<label>Status</label>
                        <select class="form-control statusExtraDetail">
                        	<option value="v">Vidljivo</option>
                            <option value="h">Sakriveno</option>
                        </select>
                    </div>
                	<div class="row extradetailNameCont">
                    
                    </div>

                    <button class="btn btn-primary saveExtraDetailButton hide" >Snimi</button>
                </div>
            </div>
        </div>
		
        <div class="row">
        	<div class="col-sm-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <h2 class="box-title">Kategorije Vesti</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="tree"></div>
                            </div>
                        </div>
                    </div>
                </div>
            	
            </div>
            <div class="col-sm-9">

                <div class="box box-primary detailCategoryCont" catid="">
                <div class="box-body">
                    <h2 class="box-title">Detalji kategorije</h2>
                    <hr>
					<div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ID kategorije</label>
                                <input type="text" disabled id="catID" />
                            </div>
                        </div>

                    </div>
                    <div class="row newCatNameCont">
                    	<?php 
							$query = "SELECT * FROM languages";
							$res = mysqli_query($conn, $query);
							
							while($row = mysqli_fetch_assoc($res)){
								echo '<div class="col-sm-4 newCatNameHolder" langid="'.$row['id'].'" defaultlang="'.$row['default'].'">
								    <p>'.ucfirst($row['name']).'</p>
									<div class="form-group">
										<label>Naziv</label>
										<input type="text" class="form-control categoryName" />
									</div>
									<div class="form-group">
										<label>Opis</label>
										<textarea class="form-control categoryDescription"></textarea>
									</div>
								</div>';
								
							}	
						?>
                    </div>
                    
                    <div class="row categoryStatusCont">
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Prikaži kategoriju</label>
                                <input type="checkbox" class="categoryVisible" />
                            </div>
                        </div>
                    </div>
					<div class="row categoryIconCont">
					    <div class="col-sm-12">
                        	<div class="form-group">
                            	<label>Ikona kategorije</label>
                                <input type="text" class="form-control categoryNewIcon" />
                            </div>
                        </div>
					</div>
					<div class="row categoryColorCont">
					    <div class="col-sm-12">
                        	<div class="form-group">
                            	<label>Boja kategorije: <span class="hide">nije izabrana</span></label></label>
                                <input type="color" class="form-control categoryNewColor" />
                            </div>
                        </div>
					</div>
                    
                    
                    <div class="row">
                        <div class="col-sm-2 verticalMargin10">
                            <button class="btn btn-primary saveCategory" style="margin-left: 6px;">Snimi</button>
                        </div>  
                        <div class="col-sm-4 verticalMargin10">
                        </div>    
       
                        <div class="col-sm-6 verticalMargin10">
                            <button class="btn btn-primary addCategory pull-right" >Dodaj kao podkategoriju</button>
                            <button class="btn btn-primary addCategoryMain pull-right" style="margin-right: 10px;">Dodaj glavnu kategoriju</button>
                        </div>
                            
                            
                        
                    </div>
                    
                    <hr>
                    <h2 class="box-title">Slike kategorije</h2>
                    <hr>
                    
                    <div class="row">
                    	<div class="col-sm-12">
                        	<div class="form-group">
                            	<label>Dodaj novu sliku kategorije</label>
                                <input type="text" class="form-control categoryNewImage" />
                                <button class="btn btn-primary verticalMargin10 addNewCategoryImageButton">Dodaj</button>
                            </div>
                        </div>
                        
                        <!--	category image template	-->
                    	<div class="col-md-2 col-sm-4 col-xs-3 verticalMargin10 hide categoryMainImageTemplate " catdetaildid="" >
                        	<img src="../images/pantelejska-crkva.JPG" class="img-responsive" data-featherlight="../images/pantelejska-crkva.JPG" />
                            <input type="radio" value="" class="primaryCategoryImage" name="primaryCategoryImage"  />
                            <a class="btn btn-danger btn-xs deleteMainImageButton" style="position: absolute; right: 15px; top: 0px;">X</a>
                        </div>
                        
                        <div class="categoryMainImageCont">
                        </div>
                        
                    </div>
                    
                                        
                    <hr>
                    <h2 class="box-title">Dodatni prilozi</h2>
                    <hr>
                    
					<div class="row">
                    	<div class="col-sm-2">
                        	<div class="form-group">
                            	<label>Tip</label>
                                <select class="form-control newCategoryDetailType">
                                	<option value="doc">Dokument</option>
                                    <option value="yt">Youtube</option>
                                    <option value="ext">Eksterni link</option>
                                    <option value="icon">Ikona</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                        	<div class="form-group">
                            	<label>Putanja</label>
                               	<input type="text" class="form-control newCategoryDetailContent" />
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                        	<div class="form-group">
                            	<label>Putanja slike</label>
                                <input type="text" class="form-control newCategoryDetailContentimg" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                        	<button class="btn btn-primary addCategoryDetail">Dodaj</button>
                        </div>
                    </div>
                    
                    <div class="row mainColorCont">
                        <div class="col-sm-9 form-group">
                            <label>Boja: <span class="hide">nije izabrana</span></label>
                            <input type="color" class="form-control categoryColorLink">
                        </div>
                    </div>
                    
                    <div class="row categoryDetailCont">
                    	<div class="col-sm-12">
                        	<table class="table table-condensed table-responsive">
                            	<thead>
                                	<tr>
                                    	<td>Tip</td>
                                        <td>Sadržaj</td>
                                        <td>Slika</td>
                                        <td></td>
                                    </tr>
                                     <!--	category item template 	 -->	
                                    <tr class="hide categoryDetailItemTemplate">
                                        <td>Dokument</td>
                                        <td><a href="">Ime fajla.pdf</a></td>
                                        <td><img src="../images/pantelejska-crkva.JPG" height="50" data-featherlight="../images/pantelejska-crkva.JPG"  /></td>
                                        <td><button class="btn btn-danger deleteCategoryDetail">Obriši</button></td>
                                    </tr>
                                </thead>
                                <tbody class="categoryDetailItemCont">
                                	 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                    
                    <hr />

                </div>
            </div>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->