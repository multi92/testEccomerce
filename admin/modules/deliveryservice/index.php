<?php
	
	$query = "SELECT * FROM  deliveryservice ";
	$re = mysqli_query($conn, $query);
	if(mysqli_num_rows($re) > 0)
	{
		$userscont = array();
		while($row = mysqli_fetch_assoc($re))
		{
			array_push($userscont, $row);
		}	
	}
?>
<!-- Content Wrapper. Contains user content -->
   
<div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kurirske sluzbe
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
        <li class="active">Kurirske sluzbe</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
            	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                	<button class="btn btn-primary" id="addUsersButton">Nova kurirska sluzba</button>
                <?php endif;?>
                <button class="btn btn-primary" id="listUsersButton">Lista kurirskih sluzbi</button>
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
        
		
        
		<div class="box box-primary box-body addChangeUsersCont " style="display:none;" >
       		<div class="loadedusers" usersid=''></div>


            <div class="form-horizontal">
                <div class="box-body">
					
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Naziv</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceName" placeholder="Ime">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Šifra</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceCode" placeholder="Šifra">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Adresa</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceAddress" placeholder="Adresa">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Grad</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceCity" placeholder="Grad">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Poštanski broj</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceZip" placeholder="Poštanski broj">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Telefon</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryservicePhone" placeholder="Telefon">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceEmail" placeholder="Email">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Website</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceWebsite" placeholder="Website">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Link ka stranici za praćenje pošiljaka - kurirske službe</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceWebsiteTrackingLink" placeholder="Link ka stranici za praćenje pošiljaka - kurirske službe">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Slika</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceImage" placeholder="Slika">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Sort</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control deliveryserviceSort" placeholder="Sort">
                        </div>
                    </div>
					
                    </div>
                    
                </div><!-- /.box-body -->

				                
                <div class="box-footer">
                	<?php if($_SESSION['change'] == 1) : ?>
                	<button class="btn btn-primary" id="saveUsers" currentid="">Snimi</button> 
                    <?php endif;?>  
                </div><!-- /.box-footer -->
				
				 <hr />

				<div class="clearfix"></div>

             </div>
            
       

        <div class="row listUsersCont" style="display:block;" >
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista svih kurirskih sluzbi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	
                    <?php 
						if(empty($userscont))
						{
					?>
                    	<div class="alert alert-warning alert-dismissable darkgraycolor">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h4>
                                <i class="icon fa fa-warning"></i> "Paznja!"
                            </h4>
                            Ne postoje podaci u bazi! 
                        </div>    
                    <?php		
						}
						else
						{
							echo '<table id="example1" class="table table-bordered table-striped">
								<thead>
								  <tr>
									<th>Redni broj</th>
									<th>Naziv</th>
									<th>Šifra</th>
									<th>Tel.</th>
									<th>Email</th>
									<th>Website</th>
									<th>Sort</th>
									<th>Status</th>
									<th>Izmeni</th>
								  </tr>
								</thead>
								<tbody>';
							$i = 1;
							foreach($userscont as $key=>$val)
							{
								if($val['active']=='y')
								{
									$status='Aktivan';
								}else{
									$status='Neaktivan';
								}

								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$val['name'].'</td>
									<td>'.$val['code'].'</td>
									<td>'.$val['phone'].'</td>
									<td>'.$val['email'].'</td>
									<td>'.$val['website'].'</td>
									<td>'.$val['sort'].'</td>
									<td><select class="form-control selectStatus background-'.$val['status'].'" id="'.$val['id'].'" currentstatus="'.$val['status'].'">
										 <option value="v" '.(($val['status'] == 'v')? "selected='selected'":"").'>Vidljiva</option>
										 <option value="h" '.(($val['status'] == 'h')? "selected='selected'":"").'>Sakrivena</option>
										 <option value="a" '.(($val['status'] == 'a')? "selected='selected'":"").'>Arhivirano</option>
									 </select></td>
									<td>
										<button class="btn btn-primary changeUsersButton" usersid="'.$val['id'].'">Izmeni</button>';
										if($_SESSION['delete'] == 1 || $val['type'] == "admin" )
										{
											echo '<button class="btn btn-danger deleteUsersButton" usersid="'.$val['id'].'">Obrisi</button>';
										}
									echo '</td>
								  </tr>';	
								  $i++;
							}
									
							echo '</tbody>
                  			</table>';
						}	
					?>
                

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div>
            
                 
          
          
         <div class="box box-danger box-body errorAddChangeUsersCont " style="display: none;"><h4>Nedovoljno privilegija!</h4></div> 
      <!-- Your Page Content Here -->
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

