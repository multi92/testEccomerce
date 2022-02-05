

<div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-list-alt"></i> Tekstovi
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-list-alt"></i> Tekstovi</li>
      </ol>
    </section>
    
	<section class="content-header">
		<div class="row">
			
		</div>
	</section>
	
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        	<div class="col-xs-12">
       			<div class="box">
          			<div class="box-header">
          				<div class="col-sm-4">
							<div class="form-group">
								<label>Pretraga</label>
								<input type="text" class="form-control searchInput"  />
							</div>
          				</div>
          			</div>
          			<div class="box-body">
        	<?php
				
				$q = "SELECT * FROM languages";
				$res = mysqli_query($conn, $q);
				while($data = mysqli_fetch_assoc($res))
				{
					echo '<div class="col-sm-4 '.$data['name'].' langCont" lang="'.$data['shortname'].'">
							<h3 >'.ucfirst($data['name']).'</h3>
							<div class="row">
								<div class="col-xs-12"><hr style="border-top:#999 1px solid;" /></div>
							</div>';
							include_once("../app/configuration/system.configuration.php");
							include("../".$system_conf["theme_path"][1]."lang/".$data['shortname'].".php");
							
							$head = "";
							foreach($language as $key=>$value)
							{						
								if($key[0]!='#'){
									$head = $key;
									echo '<h4 style="text-transform: capitalize;">'.$key.'</h4>';
									echo '<hr>';
								
									foreach($value as $k=>$v)
									{
										echo '<input type="text" class="form-control marginVertical5" section="'.$key.'" key="'.$k.'" value="'.$v.'" />';	
									}
									echo '<hr>';

								} else {
									$head = $key;
									echo '<h4 class="hide" style="text-transform: capitalize;">'.$key.'</h4>';
									echo '<hr class="hide">';
								
									foreach($value as $k=>$v)
									{
										echo '<input type="text" class="form-control marginVertical5 hide" section="'.$key.'" key="'.$k.'" value="'.$v.'" />';	
									}
									echo '<hr class="hide">';
								}
								
							}
					echo '</div>';
				}		
			?>



					</div>
					<div class="box-footer">
    					<div class="col-xs-12">
            				<button class="btn btn-primary saveTranslate">Snimi</button> 
            			</div>
  					</div>
				</div>
			</div>
        </div>
 		
        
          
      <!-- Your Page Content Here -->
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->