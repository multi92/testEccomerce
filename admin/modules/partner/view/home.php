
<!-- Content Wrapper. Contains page content -->
   
<div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-users"></i> Partneri
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-users"></i> Partneri</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
            	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                <button class="btn btn-primary" id="addButton">Novi partner</button>
              <?php endif;?>
                <button class="btn btn-primary" id="listButton">Lista partnera</button>
              <?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                <button class="btn btn-primary" id="partnerApplicationsButton">Zahtevi za otvaranje partnerskog naloga</button>
              <?php endif;?>  
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        

        
        <div class="row listCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista svih partnera</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                	
                    <table id="partnerListTable" class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th>Redni broj</th>
							<th>Naziv</th>
							<th>PIB</th>
							<th>Adresa</th>
							<th>Email</th>
							<th>Tip</th>
							<th>Sort</th>
							<th>Status</th>
							<th>Izmeni</th>
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


  