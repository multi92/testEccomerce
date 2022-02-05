<div class="content-wrapper">
    <section class="content-header -breadcrumbColor">
        <h1>
            <i class="fa fa-list-alt"> Podaešavanja
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li class="active"> <i class="fa fa-list-alt"> Podešavanja</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
        
        <div class="row">
        	    <div class="col-xs-12">
    			<div class="box">
        
        	<?php
				foreach($languages as $data)
				{
					
					echo '<div class="col-sm-4 '.$data[0].'">
							<h3>'.ucfirst($data[1]).'</h3>
							<div class="row">
								<div class="col-xs-12"><hr style="border-top:#999 1px solid;" /></div>
							</div>';
							require("../lang/".$data[0].".php");
							$head = "";
							foreach($language as $key=>$value)
							{						
								$head = $key;
								echo '<h4>'.$key.'</h4>';
		
								foreach($value as $k=>$v)
								{
									echo '<input type="text" class="form-control marginVertical5" section="'.$key.'" key="'.$k.'" value="'.$v.'" />';	
								}
							}
					echo '</div>';

				}		
			?>
					</div>
    </div>
        </div>
        
        
        
        
        
        
		<?php
			
			foreach($user_conf as $k=>$v){
				
				echo '<div class="box-body boxGroup" key="'.$k.'">
						<h3 class="groupName">'.ucfirst($k).'</h3>';		
				
				
				foreach($v as $key=>$val){
					echo '<div class="row groupItemRow" key="'.$val[0].'">
						<div class="col-sm-3">
							<p>'.str_replace("_", " ", $val[0]).'</p>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<input type="text" class="form-control valueInput" value="'.$val[1].'" />
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<input type="text" class="form-control commentInput" value="'.$val[2].'" />
							</div>
						</div>
					</div>';	
				}
				
				echo '</div>';
			}
			
		?>
        
        <a class="btn btn-primary saveUserConf">Snimi</a>

    </section>
    <!-- /.content -->
</div>
