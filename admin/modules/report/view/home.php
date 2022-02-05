
<!-- Content Wrapper. Contains page content -->
   
<div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
      <h1>
        <i class="fa fa-columns"></i> Izveštaji
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li class="active"><i class="fa fa-columns"></i> Izveštaji</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
            	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                <button class="btn btn-primary" id="addButton">Novi izveštaj</button>
                <?php endif;?>
                <button class="btn btn-primary" id="listButton">Lista izveštaja</button>
                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        
        <div class="box box-primary box-body addChangeCont " style="display:none;">
       		<div class="loaded" id=''></div>
            
            <div class="checkbox">
            	<label>
               		<input type="radio" name="bannerside" class="leftcheck" side="left" alt="Ukljuci na levoj koloni na stranici" />
                	Leva strana
                </label>
            </div>
            <div class="checkbox">
            	<label>
               		<input type="radio" name="bannerside" class="rightcheck" side="right" alt="Ukljuci na desnoj koloni na stranici" />
                	Desna strana
                </label>
            </div>
            
            <div class="row">
            	<div class="col-sm-4">
                	<div class="form-group">
                        <label>Naziv banera</label>
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
                  <h3 class="box-title">Lista svih izveštaja u bazi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	
                    <table id="example1" class="table table-bordered table-striped">
								<thead>
								  <tr>
                                    <th>Rb.</th>
									<th>Šifra</th>
									<th>Naziv</th>
									<th>Opis</th>
                                    <th>Izmeni</th>
                                    <th>Pokreni</th>
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


  