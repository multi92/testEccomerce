<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
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
            	
                <button class="btn btn-primary" id="listButton">Lista Izveštaja</button>
                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        
        <div class="box box-primary box-body addChangeCont hide" >
       		<div class="loaded" id=''></div>
            
            <div class="row">
				            
            	<div class="col-sm-2">
                	<div class="form-group">
                        <label>Šifra izveštaja</label>
                        <input type="text" class="form-control reportCode" placeholder="Šifra izveštaja">
                    </div>
                </div>
            	<div class="col-sm-6">
                	<div class="form-group">
                        <label>Naziv izveštaja</label>
                        <input type="text" class="form-control reportName" placeholder="Naziv izveštaja">
                    </div>
                </div>
                <div class="col-sm-4">
                	<div class="form-group">
                        <label>Grupa privilegija</label>
                        <select class="form-control reportUserGroup"></select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12">
                	<div class="form-group">
                        <label>Opis izveštaja</label>
                        <textarea type="text" class="form-control reportDescription" placeholder="Opis izveštaja"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Kod izveštaja</label>
                        <div >
                            <button class="btn btn-primary endReport">###</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Ubaci parametar</button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a class="stringReportInput">String</a></li>
                                    <li class="hide"><a class="floatReportInput">Float</a></li>
                                    <li><a class="dateReportInput">Datum</a></li>
                                    
                                    <li class="divider"></li>
                                    <li class="hide"><a class="productReportInput">Proizvod</a></li>
                                    <li class="hide"><a class="productsReportInput">Proizvodi</a></li>
                                    <li class="divider"></li>
                                    <li><a class="partnerReportInput">Partner</a></li>
                                    <li class="hide"><a class="partnersReportInput">Partneri</a></li>
                                    <li class="hide"><a class="partnerTypeReportInput">Tip partnera</a></li>
                                    <li class="divider"></li>
                                    <li class="hide"><a class="documentReportInput">Dokument</a></li>
                                    <li class="hide"><a class="documentTypeReportInput">Tip dokumenta</a></li>
                                    <li class="divider"></li>
                                    <li class="hide"><a class="warehouseReportInput">Magacin</a></li>
                                    <li class="divider"></li>
                                    <li class="hide"><a class="userReportInput">Korisnik</a></li>
                                    <li class="hide"><a class="loggedUserReportInput">Logovani korisnik</a></li>
                                </ul>
                            </div>
                        </div>
                        <textarea class="form-control reportText" rows="25"></textarea>
                    </div>
                </div>
            </div>

            <a class="btn btn-primary saveAddChange">Snimi</a>  
        </div>
          
	</section>
	<!-- /.content -->
</div>
