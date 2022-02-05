<?php $viewtype=''; if($currentview=='prepare'){ $viewtype='- Izveštaj'; }  ?>

<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-columns"></i> Izveštaj <?php echo $viewtype;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li><a href="dashboard"><i class="fa fa-columns"></i> Lista Izveštaja</a></li>
			<li class="active"> Izveštaj</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<div class="row">
            <div class="col-sm-12 verticalMargin10">
            	
                <button class="btn btn-primary" id="listButton">Lista Izveštaj</button>
                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        
        <div class="box box-primary box-body runReportCont hide" >
       		<div class="loaded" id=''></div>
            
            <div class="row">
				<div class="col-sm-12">
                	<div class="form-group">
                        <h1>Izveštaj</h1>
                        <h2 class="reportCode">Šifra</h2>
                        <h2 class="reportName">Naziv</h2>
                        <h2 class="reportDescription">Opis</h2>
                    </div>
                </div>            
            	<div class="clearfix"></div>
                <hr>
                         
            	<div class="col-sm-12 reportInputData" >
                    <div class="form-group report-parameters hide">
                        <h1>Parametri izveštaja</h1>
                    </div> 
                	




                </div>
                

            </div>
            

            <a class="btn btn-primary runReportButton">Pokreni</a>  
        </div>
          
	</section>
	<!-- /.content -->
</div>