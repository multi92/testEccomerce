<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Sifrarnik
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
			<li class="active"> Sifrarnik</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>

		<div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="toggleProductcode">Sifrarnik</button>
            </div>
        </div>
        
        <div class="box box-primary box-body productcodeCont" >
        	<h4 class="box-title">Sifrarnici</h4>
            <div class="row">
                <div class="col-sm-3 listExtraDetail">
                	<ul class="list-group">
                    	<?php
							$query = "SELECT * FROM productcode";
							$re = mysqli_query($conn, $query);
							while($arow = mysqli_fetch_assoc($re))
							{
								echo '<li class="list-group-item pointer productcodeListItem" productcodeid = "'.$arow['id'].'">
										<a>'.$arow['name'].'</a>
										<span class="pull-right"><button class="btn btn-xs btn-danger deleteProductcodeButton">X</button></span>
									  </li>';
							}
						?>
                    </ul>
                    
                    <a class="btn btn-default btn-block btn-social addProductcodeFormButton">
                        <i class="fa fa-plus"></i> Dodaj novi sifrarnik
                      </a>
                </div>
                <div class="col-sm-6 dataProductcode hide" productcodeDataid="">
                	
                	<div class="row ">
                    	<div class="col-md-4">
                            <h4></h4>
                            <div class="form-group">
                                <label>Naziv</label>
                                <input type="text" class="form-control nameProductcode"	 />
                            </div>
                        </div>
                        <div class="col-md-8 productcodeItemBigCont">
                        	<table class="table table-condensed table-striped">
                            	<thead>
                                	<th>atribut</th>
                                    <th>vrednost atributa</th>
                                    <th>sifra</th>
                                    <th></th>
                                </thead>
                                <tbody class="productcodeItemCont">
                                	
                                </tbody>
                            </table>
                            
                            <div class="row">
                            
                            	<div class="col-sm-4">
                                	<div class="form-group">
                                    	<label>atribut</label>
                                        <select class="form-control addProductcodeAttrSelect">
                                        	<option value=""></option>
                                        	<?php 
												$q = "SELECT * FROM attr ";
												$res = mysqli_query($conn, $q);
												
												while($row = mysqli_fetch_assoc($res)){
													echo "<option value='".$row['id']."'>".$row['name']."</option>";	
												}
											?>
                                        </select>
                                    </div>
                                 </div>   
                                 <div class="col-sm-4 addProductcodeAttrvalCont hide">
                                    <div class="form-group">
                                    	<label>vrednost atributa</label>
                                        <select class="form-control addProductcodeAttrvalSelect">
                                        	
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 addProductcodeValueCont hide">
                                    <div class="form-group">
                                    	<label>sifra</label>
                                        <input type="text" class="form-control addProductcodeValueInput" />
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-primary addProductcodeItemButton " >dodaj</button>
                            
                        </div>
                    </div>

                    <button class="btn btn-primary saveProductcodeButton " >Snimi</button>
                </div>
            </div>
        </div>

	</section>
	<!-- /.content -->
</div>
