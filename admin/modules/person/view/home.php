
<!-- Content Wrapper. Contains page content -->
   
<div class="content-wrapper ">
  
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-male"></i> Osoblje
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-male"></i> Osoblje</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
            	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                <button class="btn btn-primary" id="addButton">Nova stavka</button>
                <?php endif;?>
                <button class="btn btn-primary" id="listButton">Lista stavki</button>                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        
        <div class="box box-primary box-body addChangeCont " style="display:none;">
       		<div class="loaded" id=''></div>
            
            
            
            <div class="row">
            	<div class="col-sm-4">
                	<div class="form-group">
                        <label>Naziv stavke</label>
                        <input type="text" class="form-control titleBanner" placeholder="Naziv banera">
                    </div>
                </div>
                

            </div>
            
            <div class="row">
            <?php
				foreach($langfull as $val)
				{
					echo '<div class="col-sm-4">
							<h3 class="box-title">'.ucfirst($val[1]).'</h3>
									
							<div id="editor'.$val[0].'"></div>
						</div>';	
				}
			?>
            </div>

            <button class="btn btn-primary" id="saveAddChangeForm">Snimi</button>
        </div>
        
        <div class="row listCont">
            <div class="col-xs-12">
              <!-- /.box -->

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista svih stavki u bazi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	
                    <table id="example1" class="table table-bordered table-striped">
								<thead>
								  <tr>
									<th>Redni broj</th>
									<th>Ime i prezime</th>
									<th>Telefon</th>
									<th>Titula</th>
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


  