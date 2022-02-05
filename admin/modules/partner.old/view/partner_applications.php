
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
  
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-users"></i> Partneri - Zahtevi za otvaranje partnerskih naloga
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li><a href="dashboard"><i class="fa fa-users"></i> Partneri</a></li>
        <li class="active"><i class="fa fa-columns"></i> Zahtevi</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">

                <button class="btn btn-primary" id="listButton">Lista partnera</button>
                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        

        
        <div class="row listCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista zahteva</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                	
                    <table id="partnerApplicationsListTable" class="table table-bordered table-striped">
								<thead>
								  <tr>
                    <th>Korisnik</th>
                    <th>Email</th>
                    <th>Naziv firme</th>
                    <th>PIB</th>
                    <th>Maticni broj</th>
                    <th>Kontakt osoba</th>
                    <th>Telefon firme</th>
                    <th>Fax firme</th>
                    <th>Email firme</th>
                    <th>Website firme</th>
                    <th>Adresa firme</th>
                    <th>Grad</th>
                    <th>Poštanski broj</th>
                    <th>Status</th>
                    <th ></th>
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


  