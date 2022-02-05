<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dokumenti
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active">Dokumenti</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista dokumenata</button>
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
      
        
        <div class="row listCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista svih dokumenata u bazi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	
                    <table id="example1" class="table table-bordered table-striped">
								<thead>
								  <tr>
									<th>Tip dokumenta</th>
									<th>Broj dokumenta</th>
                                    <th>Datum</th>
									<th>Datum valute</th>
									<th>Partner / Korisnik</th>
                                    <th>Magacin</th>
									<th>Povraćaj</th>
									<th>Sinhronizovan</th>
									<th>Status</th>
									<th></th>
								  </tr>
								</thead>
                            </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div>
          
      <!-- Your Page Content Here -->
    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
