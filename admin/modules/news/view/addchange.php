<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-newspaper-o"></i> Vest <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
 			<li><a href="dashboard"><i class="fa fa-newspaper-o"></i> Vesti</a></li>
 			<li class="active"> Vest</li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista vesti</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
                     	
						 <div class="row">
						 	<div class="col-sm-6">
								<div class="form-group">
									<label>Slika vesti</label>
									<input type="text" class="form-control mainimage" placeholder="putanja do slike">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Datum vesti</label>
									<input type="text" class="form-control newsdate">
								</div>
							</div>
						 
						 	<div class="col-sm-6">
								<div class="form-group">
							<label>Kategorija vesti</label>
							<a class="pull-right"  href="newscategory">Izmeni kategorije</a>
							<div class="row categoryCont">
							<div class="col-sm-12  categorySelectHolder">
							<select class="form-control newscategorycont" newscategoryid="" >
							<option value="0">-- izaberite kategoriju --</option>
						<?php
							function get_all_deepest_cat($parid, $string)
							{
								global $conn;
								$tmpstring = $string;
								$query = "SELECT * FROM newscategory WHERE id = ".$parid;
								
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
								$query = "SELECT * FROM newscategory ";
								$result = mysqli_query($conn, $query);
								$i = 1;
								$bdata = array();
								while($ar = mysqli_fetch_assoc($result))
								{
									if($ar["parentid"] == 0)
									{
										$data = array();
										array_push($data, $ar["id"]);
										array_push($data, $ar["name"]);
										array_push($bdata, $data);
										
									}
									else
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
							
							foreach(all_cat_php() as $key=>$val)
							{
								$id = $val[0];
								unset($val[0]);
								echo '<option value="'.$id.'">'.implode(" >> ", $val).'</option>';	
								
							}
							
						?>
                    	
									</select>
								</div>
							
							</div>	
						 </div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Galerija vesti</label>
									<a class="pull-right"  href="gallery">Izmeni galerije</a>
									<div class="row categoryCont">
									<div class="col-sm-12 gallerySelectHolder">
									<select class="form-control newsgallerycont" newsgalleryid="" >
									<option value="0">-- izaberite galeriju --</option>
									<?php
	
										$query = "SELECT * FROM gallery WHERE status = 'v' ORDER BY name ASC";
										$r = mysqli_query($conn,$query);
										if(mysqli_num_rows($r) > 0)
										{
											while($row = mysqli_fetch_assoc($r)){
												echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';		
											}
										}	
									
									?>
								
											</select>
										</div>
									
									</div>	
								 </div>
							</div>
						 </div>
						 
                         <div class="row addChangeLangCont">
                         	
                         </div> 
                         <br>
                         <a class="btn btn-primary saveAddChange">Snimi</a>                       
                     </div>
 				</div><!-- /.box -->
             </div><!-- /.col -->
           </div>
		   
            
   
            </div>
           
 	</section>
 	<!-- /.content -->
 </div>