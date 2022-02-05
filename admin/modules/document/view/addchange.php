<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-book"></i> Dokumenta <?php echo $viewtype;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li><a href="document"><i class="fa fa-book"></i> Lista dokumenata</a></li>
			<li class="active"></i> Dokumenta</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
		
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista dokumenata</button>
            </div>
        </div>
        
        <div class="box box-primary box-body addChangeCont hide" >
       		<div class="loaded" id=''></div>
        	<div class="row">
            	<div class="col-sm-6">
                	<div class="form-group">
                    	<label class="control-label">Putanja dokumenta</label>
                        <input type="text" class="form-control documentPath" />
                    </div>
                   
                    <div class="row addChangeLangCont">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Ime za prikazivanje dokumenta</label>
                                <input type="text" class="form-control documentName" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Ime za prikazivanje dokumenta</label>
                                <input type="text" class="form-control documentName" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Ime za prikazivanje dokumenta</label>
                                <input type="text" class="form-control documentName" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    	<label>Slika dokumenta</label>
                        <input type="text" class="form-control documentImage" />
                    </div>
                    <div class="form-group">
                    	<label>Delovodni broj</label>
                        <input type="text" class="form-control documentDelovodni" />
                    </div>
                    <div class="form-group">Datum zavodjenja</label>
                        <input type="text" class="form-control documentDate" />
                    </div>
                    <div class="form-group">Tip</label>
                        <select class="form-control documentType" id="documentType" currentDocumentType="file">
                            <option value="file">Fajl</option>
                            <option value="folder">Folder</option>
                        </select>

                    </div>
                </div>
            </div>
           
            <button class="btn btn-primary saveAddChange">Snimi</button>
            
        </div>
          
	</section>
	<!-- /.content -->
</div>
