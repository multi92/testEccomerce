<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-table"></i> Javna nabavka <?php echo $viewtype;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li><a href="dashboard"><i class="fa fa-table"></i> Lista Javnih nabavki</a></li>
			<li class="active"> Javna nabavka</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>

        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista javnih nabavki</button>
            </div>
        </div>
        
        <div class="row addChangeCont jq_javneid" javneid="<?php if(isset($command[2])) {echo $command[2];} ?>">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header"></div>
                    <div class="box-body">
                    	
                        <div class="form-group">
                            <label>Datum isteka vazenja</label>
                            <input type="text" class="form-control input-lg expiredate">
                        </div>
                    
                        <div class="row addChangeLangCont">
                        	
                        </div> 
                        
                        <?php if($command[1] == 'add')
                      		echo '<a class="btn btn-primary saveNewJavneButton">Snimi</a>';
							else{
								echo '<a class="btn btn-primary saveAddChange">Snimi</a>';	
							}	
                        ?>
										 
                    </div>
				</div><!-- /.box -->
            </div><!-- /.col -->
          </div>
          
	</section>
	<!-- /.content -->
</div>
