<?php $viewtype=''; if($currentview=='run'){ $viewtype='- Izveštaj'; }  //var_dump($_SESSION['reportinputscolected']); ?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
    <section class="content-header -breadcrumbColor">
        <h1>
            <i class="fa fa-columns"></i> Izveštaj <?php //echo $viewtype;?>
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
       
        
        <div class="box box-primary box-body " >
            <div class="row listCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Izveštaj - <span class="reportCodeInfo"></span> <span class="reportNameInfo"></span></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    
                    <table id="reportDataTable" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>Rb.</th>
                                    
                                  </tr>
                                </thead>
                            </table>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div>
            

            <a class="btn btn-primary printReportButton hide">Štampaj</a>  
            <a class="btn btn-primary exportToCsvReportButton ">CSV</a> 
        </div>
          
    </section>
    <!-- /.content -->
</div>