<?php
	
	$query = "SELECT * FROM  user ";
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
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-users"></i> Korisnici 
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-users"></i> Korisnici</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
            	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                	<button class="btn btn-primary" id="addUsersButton">Novi korisnik</button>
                <?php endif;?>
                <button class="btn btn-primary" id="listUsersButton">Lista korisnika</button>
                <button class="btn btn-primary" id="userGroupsButton">Grupe korisnika</button>
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
        
		<div class="row userGroupsCont" style="display:none;" >
            <div class="col-xs-12">
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h2 >Grupe korisnika</h2>

                    </div><!-- /.box-header -->
                    <div class="box-body">
                    	<h4>Nova grupa</h4>
                        
                        <div class="row">
                        	<div class="col-sm-3">
                            	<div class="form-group">
                                    <label>Ime</label>
									<input type="text" class="form-control addGroupNameInput" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                            	<div class="row">
                                	<div class="col-sm-2 form-group">
                                        <label>See</label><br />
                                        <input type="checkbox" class="addGroupSee" />
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label>Add</label><br />
										<input type="checkbox" class="addGroupAdd" />
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label>Change</label><br />
										<input type="checkbox" class="addChange" />
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label>Delete</label><br />
										<input type="checkbox" class="addGroupDelete" />
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label>Activate</label><br />
										<input type="checkbox" class="addGroupActivate" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            	<a class="btn btn-primary addNewGroupButton">Dodaj</a>
                            </div>
                        </div>
                        
                        <hr />
                        
                        <div class="row">
                        	<div class="col-sm-12">
                            	<ul class="list-group">
                            	<?php
									$query = "SELECT * FROM usergroup ORDER BY name ASC";
									$re = mysqli_query($conn, $query);
									if(mysqli_num_rows($re) > 0)
									{
										while($row = mysqli_fetch_assoc($re))
										{
											$see = $add = $delete = $change = $activate = "";
											if($row['see'] == 1) $see = "checked='checked'";
											if($row['add'] == 1) $add = "checked='checked'";
											if($row['delete'] == 1) $delete = "checked='checked'";
											if($row['change'] == 1) $change = "checked='checked'";
											if($row['activate'] == 1) $activate = "checked='checked'";
										  echo '
										  <li class="list-group-item" groupid="'.$row['id'].'">
											<div class="row">
												<div class="col-sm-12">
													<h3>'.$row['name'].'</h3>
												</div>
												<div class="col-sm-2 form-group">
													<label>See</label><br />
													<input type="checkbox" class="addGroupSee" '.$see.' />
												</div>
												<div class="col-sm-2 form-group">
													<label>Add</label><br />
													<input type="checkbox" class="addGroupAdd" '.$add.' />
												</div>
												<div class="col-sm-2 form-group">
													<label>Change</label><br />
													<input type="checkbox" class="addGroupChange" '.$change.' />
												</div>
												<div class="col-sm-2 form-group">
													<label>Delete</label><br />
													<input type="checkbox" class="addGroupDelete" '.$delete.' />
												</div>
												<div class="col-sm-2 form-group">
													<label>Activate</label><br />
													<input type="checkbox" class="addGroupActivate" '.$activate.' />
												</div>
												<div class="col-sm-2">
													
													<button type="button" class="btn btn-primary saveGroupItem" >Snimi</button>
													<button type="button" class="btn btn-danger deleteGroupItem" >Obrisi</button>
												</div>
											</div>                                	
										  </li>';
										}
									}
								?>
                            	</ul>
                            </div>
                        </div>
                        
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div> 
        
		<div class="box box-primary box-body addChangeUsersCont " style="display:none;" >
       		<div class="loadedusers" usersid=''></div>


            <div class="form-horizontal">
                <div class="box-body">
					<div class="form-group">
					<div class="col-sm-12" >
						<img class="profile-user-img img-responsive img-square usersHeaderUsersPicture" style="margin:auto;" src="fajlovi/noimg.png" alt="User profile picture">
						<h3  class="profile-username text-center headH usersHeaderUsersName">Ime</h3>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-2">
							<input type="hidden" name="user_status" id="user_status" value="">
							<button class="btn btn-primary" id="userActivate">Aktiviraj korisnika</button>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-primary jq_userSendNewPasswordButton" >Generiši i pošalji novu lozinku <i class="fa fa-spinner fa-spin hide " aria-hidden="true"></i></button>
						</div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary jq_userChangePasswordButton" >Izmeni lozinku <i class="fa fa-spinner fa-spin hide " aria-hidden="true"></i></button>
                        </div>
					</div>
                    <div class="row changUsersPasswordCont hide" style="background-color:#d9d9d9;" userid="">
                        <hr style="margin: 6px 0;">
                        <div class="col-xs-11">
                            <div class="form-group">
                                <label class="usersChangePasswordLabel" style="color:black; font-size: 18px; padding-left: 12px;">Pomena šifre</label>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="form-group" style="text-align: right; padding-right: 12px;">
                                <a class="closeUsersChangePasswordCont"><i class="fa fa-close" style="color:black; font-size: 18px; cursor: pointer; "></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-2">
                            <div class="form-group" style="padding-left: 12px;">
                                <label>Nova šifra</label>
                                <input type="password" class="form-control usersNewPassword">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group" style="padding-left: 12px;">
                                <label>Ponovite novu šifru</label>
                                <input type="password" class="form-control usersRepeatNewPassword" >
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="col-sm-4" style="padding-left: 30px;">
                            <div class="form-group">
                                <a class="btn btn-primary saveUsersChangePasswordBTN">Promeni šifru i pošalji email</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 6px 0;">
                    </div>
                	<div class="form-group">
                        <label class="col-sm-2 control-label">Tip korisnika</label>
                        <div class="col-sm-8">
                        	<select class="form-control usersType verticalMargin10">
                            	<option value="admin">Admin</option>
                                <option value="moderator">Moderator</option>
                                <option value="partner">Partner</option>
                                <option value="user">Korisnik</option>
                                <option value="commerc">Komercijalista</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Partner</label>
                        <div class="col-sm-8">
                        	<select class="form-control partnerSelect verticalMargin10">
                            		<option value="0"></option>
                                <?php 
									$queryp = "SELECT * FROM partner ORDER BY name ASC";
									$rep = mysqli_query($conn, $queryp);
									while($rowp = mysqli_fetch_assoc($rep))
									{	
										echo '<option value="'.$rowp['id'].'">'.$rowp['name'].'</option>';
									}
								?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Primarni jezik *</label>
                        <div class="col-sm-8">
                            <select class="form-control usersSelectDefaultLang verticalMargin10">
                                    <option value="0">---Nije izabrano---</option>
                                <?php 
                                    $queryp = "SELECT * FROM languages ORDER BY id ASC";
                                    $rep = mysqli_query($conn, $queryp);
                                    while($rowp = mysqli_fetch_assoc($rep))
                                    {   
                                        echo '<option value="'.$rowp['id'].'">'.$rowp['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ime *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersName" placeholder="Ime">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Prezime *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersSurname" placeholder="Prezime">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Datum rodjenja</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersBirthday" placeholder="Datum rodjenja">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Korisnicko ime *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersUsername" placeholder="Korisnicko ime">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Adresa *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersAddress" placeholder="Adresa">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Grad *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersCity" placeholder="Grad">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Poštanski broj *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersZip" placeholder="Poštanski broj">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Telefon *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersPhone" placeholder="Telefon">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-2 control-label">Mobilni telefon</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersMobile" placeholder="MobilniTelefon">
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-sm-2 control-label">Slika</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control usersPicture" placeholder="Putanja do slike">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-12 " style="color:red;">Sva polja obeležena * su obavezna!</label>
                    </div>
                    
                </div><!-- /.box-body -->

				<!-- privilages form template	-->                
                <div class="col-md-2 col-sm-3 hide privilagesModuleTemplate" moduleid="">
                    <div class="">
                        <label class="moduleLabel"></label><br />
                        <select class="form-group selectGroupSelect">
                        	<option value=""></option>
                        <?php
							/*	$re iz dela o grupama	*/
							mysqli_data_seek($re, 0);
							while($row = mysqli_fetch_assoc($re))
							{
								echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
							}
						?>
						</select>
                    </div>
                </div>
                        
                <div class="box-body">
                	<h3>Privilegije korisnika</h3>
                	<div class="row privilagesCont">
                        
                	</div>
                </div>
                
                <div class="box-footer">
                	<?php if($_SESSION['change'] == 1) : ?>
                	<button class="btn btn-primary" id="saveUsers">Snimi</button> 
                    <?php endif;?>  
                </div><!-- /.box-footer -->
             </div>
            
        </div>

        <div class="row listUsersCont" style="display:block;" >
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista svih korisnika</h3>
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
                            Ne postoje korisnici u bazi! 
                        </div>    
                    <?php		
						}
						else
						{
							echo '<table id="example1" class="table table-bordered table-striped">
								<thead>
								  <tr>
									<th>Redni broj</th>
									<th>Ime</th>
									<th>Prezime</th>
									<th>Korisnicko ime</th>
									<th>Email</th>
									<th>Tip</th>
									<th>Status</th>
									<th>Izmeni</th>
								  </tr>
								</thead>
								<tbody>';
							$i = 1;
							foreach($userscont as $key=>$val)
							{
								if($val['status']==3)
								{
									$status='Aktivan';
								}else{
									$status='Neaktivan';
								}
                                $type = "";
                                switch ($val['type']) {
                                    case "admin":
                                        $type = "Administrator";
                                        break;
                                    case "partner":
                                        $type = "Partner";
                                        break;
                                    case "moderator":
                                        $type = "Moderator";
                                         break;
                                    case "user":
                                        $type = "Korisnik";
                                         break;
                                    case "commerc":
                                        $type = "Komercijalista";
                                         break;
                                }


								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$val['name'].'</td>
									<td>'.$val['surname'].'</td>
									<td>'.$val['username'].'</td>
									<td>'.$val['email'].'</td>
									<td>'.$type.'</td>
									<td>'.$status.'</td>
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

