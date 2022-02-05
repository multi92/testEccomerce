<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-male"></i> Osoblje <?php echo $viewtype;?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li><a href="person"><i class="fa fa-male"></i> Lista osoblja</a></li>
			<li class="active"> Osoblje</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<div class="row">
            <div class="col-sm-12 verticalMargin10">
            	
                <button class="btn btn-primary" id="listButton">Lista osoblja</button>
                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        
        <div class="box box-primary box-body addChangeCont " >
       		<div class="loaded" id=''></div>
            
            <div class="row">
            	<div class="col-sm-4">
                	<div class="form-group">
                        <label>Ime i prezime</label>
                        <input type="text" class="form-control namePerson" placeholder="Ime i prezime">
                    </div>
                </div>
			</div>
			<div class="row">
				<div class="col-sm-4">
                	<div class="form-group">
                        <label>Telefon</label>
                        <input type="text" class="form-control phonePerson" placeholder="Telefon">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
			<div class="row">
				<div class="col-sm-4">
                	<div class="form-group">
                        <label>Titula</label>
                        <input type="text" class="form-control titlePerson" placeholder="Titula">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
			<div class="row">
				<div class="col-sm-4">
                	<div class="form-group">
                        <label>Slika</label>
                        <input type="text" class="form-control picturePerson" placeholder="Slika">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
			<div class="row">
				<div class="col-sm-4">
                	<div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control emailPerson" placeholder="Email">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
			<div class="row">
				<div class="col-sm-4">
                	<div class="form-group">
                        <label>Sort</label>
                        <input type="number" class="form-control sortPerson" placeholder="Sort">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="row addChangeLangCont">

            </div>
			
			

            <a class="btn btn-primary saveAddChange">Snimi</a>  
        </div>
          
	</section>
	<!-- /.content -->
</div>
