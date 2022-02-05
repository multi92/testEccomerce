<div class="content-wrapper">
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-list-alt"></i> Kategorije
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-list-alt"></i> Kategorije</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>

		<div class="row">
            <div class="col-sm-12 verticalMargin10">
                <a class="btn btn-primary" href="categoryexternal" target="_blank">Relacije kategorija</a>
            </div>
        </div>
        
        <?php 
			/*function get_all_deepest_cat($parid, $string)
			{
				global $conn;
				$tmpstring = $string;
				$query = "SELECT * FROM category WHERE id = ".$parid." ";
				
				$r = mysqli_query($conn,$query);
				if(mysqli_num_rows($r) > 0)
				{
					$row = mysqli_fetch_assoc($r);
					if($row['parentid'] == 0)
					{
						$tmpstring .= ">>".$row['name'];
						return $tmpstring;
					}
					else
					{		
						return ">>".$row['name'].get_all_deepest_cat($row["parentid"],$tmpstring);		
					}
				}	
			}
			
			function all_cat_php()
			{
				global $conn;
				
				$query = "SELECT s.name as sname , ce.* FROM `category_external` ce 
							LEFT JOIN suppliers s ON ce.suppliersid = s.id
							where ce.id NOT IN (SELECT parentid FROM `category_extra`) ORDER BY ce.suppliersid ASC";
				
				$query = "SELECT * FROM category ";
				$result = mysqli_query($conn, $query);
				$i = 1;
				$bdata = array();
				while($ar = mysqli_fetch_assoc($result))
				{
					if($ar["parentid"] != 0)
					{
						$data = explode(">>", get_all_deepest_cat($ar["parentid"],""));
						unset($data[0]);
						array_push($data,$ar["id"]); 
						$data = array_reverse($data);		
						array_push($data, $ar["name"]);
						array_push($bdata, $data);
					}
				}
				return $bdata;	
			}
			
			$categorylist = all_cat_php();
			*/
		?>
		
        <div class="box box-primary box-body categoryRelationsCont" style="display:none;">
        	<h4 class="box-title">Relacije kategorija</h4>
            <div class="row">
                <div class="col-sm-10">
                	<div class="row">
                    	
                   
						
						<?php
							
							/*function get_all_deepest_catex($parid, $string)
							{
								global $conn;
								$tmpstring = $string;
								$query = "SELECT ce.*
									FROM category_external ce WHERE ce.id = ".$parid."  ";
								
								$r = mysqli_query($conn,$query);
								if(mysqli_num_rows($r) > 0)
								{
									$row = mysqli_fetch_assoc($r);
									if($row['parentid'] == 0)
									{
										$tmpstring .= ">>".$row['name'];
										return $tmpstring;
									}
									else
									{		
										return ">>".$row['name'].get_all_deepest_catex($row["parentid"],$tmpstring);										
									}
								}
							}
							
							function all_cat_phpex()
							{
								global $conn;
								$query = "SELECT s.name as sname , ce.*,
										(SELECT COUNT(productid) FROM productcategory_external WHERE categoryid = ce.id GROUP BY categoryid) as totalproducts,
										(SELECT COUNT(pce.productid) FROM productcategory_external pce 
										LEFT JOIN productwarehouse pw ON pce.productid = pw.productid
										WHERE categoryid = ce.id AND pw.amount > 0 GROUP BY categoryid) as totalproductsavailable 
										FROM `category_external` ce
										LEFT JOIN suppliers s ON ce.suppliersid = s.id
										where ce.categoryid = 0 AND ce.id NOT IN (SELECT parentid FROM `category_external`) ORDER BY ce.suppliersid ASC";
								$result = mysqli_query($conn, $query);
								$i = 1;
								$bdata = array();
								while($ar = mysqli_fetch_assoc($result))
								{
									if($ar["parentid"] == 0)
									{
										$data = array();
										array_push($data, $ar["id"]);
										array_push($data, $ar["categoryid"]);
										array_push($data, $ar["sname"]);
										array_push($data, $ar["name"]);
										array_push($bdata, $data);
									}
									else
									{
										$data = explode(">>", get_all_deepest_catex($ar["parentid"],""));
										unset($data[0]);
										array_push($data, $ar["sname"]);
										array_push($data,$ar["categoryid"]);
										array_push($data,$ar["id"]); 
										$data = array_reverse($data);	
										
										$prods = '<span class="text-danger">'.intval($ar["totalproductsavailable"]).'</span> / '.intval($ar["totalproducts"]);
										if(intval($ar["totalproducts"]) > 0){
											$prods = '<span class="text-success">'.intval($ar["totalproductsavailable"]).'</span> / '.intval($ar["totalproducts"]);	
										}
											
										array_push($data, $ar["name"]." - ".$prods );
										array_push($bdata, $data);
									}
								}
								return $bdata;	
							}
							*/
							/*foreach(all_cat_phpex() as $key=>$val)
							{
								
								$id = $val[0];
								$catid = $val[1];
								unset($val[1]);
								unset($val[0]);
								echo '<div class="col-sm-12">
										<div class="col-sm-6"><p catid="'.$id.'"><b>'.implode(" >> ", $val).'</b></p></div>
										<div class="col-sm-6">
											<select class="form-control categoryList" pntcatid="'.$id.'">';
												echo "<option value='0' > -- izaberite kategoriju -- </option>";
												
													foreach($categorylist as $ke=>$va)
													{
														$selected = '';
														if($va[0] == $catid){
															$selected = " selected='selected' ";
														}
														$normalcatid = $va[0];
														unset($va[0]);
														echo "<option value='".$normalcatid."' ".$selected." >".implode(" >> ", $va)."</option>";														
													}
												
											echo '</select>
										</div>
									</div>';
								/*echo '<tr>
										<td>
											<p catid="'.$id.'"><b>'.implode(" >> ", $val).'</b></p>

										</td>
										<td class="categoryListCont">
											<select class="form-control categoryList" pntcatid="'.$id.'">';
												echo "<option value='0' > -- izaberite kategoriju -- </option>";
												
													foreach($categorylist as $ke=>$va)
													{
														$selected = '';
														if($va[0] == $catid){
															$selected = " selected='selected' ";
														}
														$normalcatid = $va[0];
														unset($va[0]);
														echo "<option value='".$normalcatid."' ".$selected." >".implode(" >> ", $va)."</option>";														
													}
												
											echo '</select>
										</td>
									</tr>';* /
								
								//echo '<option value="'.$id.'">'.implode(" >> ", $val).'</option>';	
							}
							*/
						?>
						
                     </div>
                   
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
                        <h2 class="box-title">Kategorije</h2>
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
            	<div class="box box-primary box-body detailCategoryCont" catid="">
                    <h2 class="box-title">Detalji kategorije</h2>
                    <hr>
					<div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ID kategorije</label>
                                <input type="text" disabled id="catID" />
                            </div>
                        </div>
						
						<div class="col-md-12">
                            <div class="form-group">
                                <label>Marža (%)</label>
                                <input type="text" id="catMargin" />
                            </div>
                        </div>
						
						<div class="col-md-12">
                            <div class="form-group">
                                <label>URL ime</label>
                                <input type="text" id="catSlug" style="background-color: #f00; color: #fff;" />
                            </div>
                        </div>

                    </div>
                    <div class="row newCatNameCont">
                    	<?php 
							
							$query = "SELECT * FROM languages";
							$res = mysqli_query($conn, $query);
							
							while($row = mysqli_fetch_assoc($res)){
								echo '<div class="col-sm-4 newCatNameHolder" langid="'.$row['id'].'" defaultlang="'.$row['default'].'">
									<h4>'.$row['name'].'</h4>
                                    <div class="form-group">
										<label>Naziv kategorije</label>
										<input type="text" class="form-control categoryName" />
									</div>
									<div class="form-group">
                                        <label>Opis kategorije</label>
										<textarea class="form-control categoryDescription"></textarea>
									</div>
								</div>';
								
							}	
						?>
                    </div>
                    
                    <div class="row categoryStatusCont">
                    	<div class="col-sm-4">
                        	<h4>Status B2C</h4>
                            <div class="form-group">
                                <label>Prikaz kategorije</label>
                                <input type="checkbox" class="b2ccategory" />
                            </div>
                            <div class="form-group">
                                <label>Prikaz cene</label>
                                <input type="checkbox" class="b2cprice" />
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                        	<h4>Status B2B</h4>
                            <div class="form-group">
                                <label>Prikaz kategorije</label>
                                <input type="checkbox" class="b2bcategory" />
                            </div>
                            <div class="form-group">
                                <label>Prikaz cene</label>
                                <input type="checkbox" class="b2bprice" />
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
                        <div class="col-sm-12 verticalMargin10">
                        	<button class="btn btn-primary addCategoryDetail">Dodaj</button>
                        </div>
                    </div>
                    
                    <div class="row mainColorCont hide">
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
                    
                    <hr>
                    <h2 class="box-title">Atributi kategorije</h2>
                  
                    <div class="row">
						<div class="col-sm-6">
							<h4>Izaberite atribut: </h4>
                        	<select class="form-control allAttrList">
                            	<?php
									$query = "SELECT * FROM attr";
									$re = mysqli_query($conn, $query);
									while($row = mysqli_fetch_assoc($re)){
										echo "<option value='".$row['id']."'>".$row['name']."</option>";	
									}
								?>
                            </select>
                            <button class="btn btn-primary verticalMargin10 addCategoryAttrButton">Dodaj atribut</button>
                        </div>
                    	<div class="col-sm-12">
                        
							<h4>Dodeljeni atributi</h4>
                            <p class="infotext">*Za promenu redosleda prevucite dodeljeni atribut na željeno mesto</p>
                            <ul class="list-group categoryAttrCont" id="sortable">
                            </ul>
                        </div>
                        
                    </div>
					
                    <hr>
                    <h2 class="box-title">Količinski rabati</h2>
                    <hr>
                    
                    <div class="row">
                    	<div class="col-sm-4">
                        		                        
                        	
							<table>
								<tr class="jq_categoryQuantityRebateTemplate hide">
										<td class="jq_categoryQuantityHolder"></td>
										<td><span class="jq_categoryRebateHolder"></span>%</td>
										<td><select class="form-control input-sm jq_categoryStatusHolder">
												<option value="h">Sakriven</option>
												<option value="v">Vidljiv</option>
											</select></td>
										<td><button class="btn btn-xs btn-danger deleteCategoryQuantityRebateItem">X</button></td>
									</tr>
							</table>
							
							<table class="table table-striped table-condensed jq_categoryQuantityRebateCont" id="sortable">
								<thead>
									<tr>
										<th>Količina</th>
										<th>Rabat</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
                            
                        </div>
                        <div class="col-sm-6">
                        	<h4>&nbsp;</h4>
                        	
							<form>
								<div class="form-group">
									<label>Količina</label>
									<input type="text" class="form-control jq_categoryNewQuantityInput" />
								</div>
								<div class="form-group">
									<label>Rabat</label>
									<input type="text" class="form-control jq_categoryNewRebateInput" />
								</div>
							</form>
                            
                            <button class="btn btn-primary verticalMargin10 jq_addCategoryQuantityReabateButton">Dodaj rabat</button>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->