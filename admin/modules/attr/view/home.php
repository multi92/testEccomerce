<div class="content-wrapper" currentview='attr'>
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-cogs"></i> Atributi
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-cogs"></i> Atributi</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
        
        
        <div class="box box-primary box-body newAttrCont">
        	<h4 class="box-title">Novi atribut</h4>
            <div class="row">
                <?php 
					foreach($langfull as $v)
					{
						echo '<div class="col-sm-4 newAttrNameCont" langid="'.$v['id'].'" defaultlang="'.$v['default'].'">
								<div class="form-group">
                                <h4>'.ucfirst($v['name']).'</h4>
								<label>Naziv atributa</label>
								<input type="text" class="form-control newattr" />
								</div>
							</div>';	
					}
				?>
            </div>
            <a class="btn btn-primary" id="addNewAttr">Snimi</a>
        </div>
        
        <div class="row">
        	<div class="col-sm-3">
            	<div class="box box-primary box-body listAttrCont">
                    <h4 class="box-title">Lista atributa</h4>
                    <div class="form-group">
                    	<label>Pretraga: </label>
                        <input type="text" class="form-control jq_attrSearchInput" />
                    </div>
                    <ul class="list-group jq_attrSearchListCont">
                    	<?php
							$query = "SELECT * FROM attr";
							$re = mysqli_query($conn, $query);
							while($arow = mysqli_fetch_assoc($re))
							{
								echo '<li class="list-group-item" attrid="'.$arow['id'].'" search="'.strtolower($arow['name']).'">
										<span class="pull-right"><button class="btn btn-xs btn-danger">X</button></span>
										<a>'.$arow['name'].'</a>
									</li>';
							}
						?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-9 stickyTop">
            	<div class="box box-primary box-body detailAttrCont"  attrid="">
                    <h4 class="box-title">Detalji atributa</h4>
                    <div class="row detailAttrHolder">
                    	
                    </div>
                    
                    <a class="btn btn-primary hide" id="changeAttrSave">Snimi</a>
                    
                    <hr />
                    
                    <h4 class="box-title">Dodatni prilozi</h4>
                    
                    <div class="row attrDownloadFormCont hide">
                    	<div class="col-sm-2">
                        	<div class="form-group">
                            	<label>Tip</label>
                                <select class="form-control newAttrDownloadType">
                                	<option value="doc">Dokument</option>
                                    <option value="yt">Youtube</option>
                                    <option value="ext">Eksterni link</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                        	<div class="form-group">
                            	<label>Putanja</label>
                               	<input type="text" class="form-control newAttrDownloadContent">
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                        	<div class="form-group">
                            	<label>Putanja slike</label>
                                <input type="text" class="form-control newAttrDownloadContentimg">
                            </div>
                        </div>
                        <div class="col-sm-12">
                        	<button class="btn btn-primary addAttrDownload">Dodaj</button>
                        </div>
                    </div>
                    
                    
                    <div class="row attrDownloadCont hide">
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
                                    <tr class="hide attrDownloadItemTemplate">
                                        <td>Dokument</td>
                                        <td><a href="">Ime fajla.pdf</a></td>
                                        <td><img src="" height="50" data-featherlight=""></td>
                                        <td><button class="btn btn-danger deleteAttrDownload">Obriši</button></td>
                                    </tr>
                                </thead>
                                <tbody class="productDownloadItemCont">
                                	
                                 </tbody>
                            </table>
                        </div>
                    </div> 
                    
                    
                    <hr />
                                       
                    <h4 class="box-title">Vrednosti atributa</h4>
                    
                    <ul id="sortable" class="list-group listAttrValCont">
						
                    </ul>
                    
                    <div class="newAttrValCont hide">
                        <h4 class="box-title ">Nova vrednost atributa</h4>
                        <div class="row addNewAttrValCont">
                            <?php
                            foreach($langfull as $v)
                            {
                                echo '<div class="col-sm-4 newAttrValNameCont" langid="'.$v['id'].'" defaultlang="'.$v['default'].'">
                                        <div class="form-group">
                                        <label>'.ucfirst($v['name']).'</label>
                                        <input type="text" class="form-control newAttrValName" />
                                        </div>
                                    </div>';	
                            }
                            ?>
                            <div class="col-xs-12"><a class="btn btn-primary btn-sm" id="addNewAttrVal">Dodaj</a></div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        
        

        
        
        
    	<div class="row">
        	<div class="col-sm-4">
            	<div id="tree"></div>
            </div>
        	<div class="col-sm-6">
            	
            </div>        	
        </div>
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->