<div class="content-wrapper" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
	<section class="content-header">
		<h1>
			Baner
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
			<li class="active"> Baneri</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<div class="row">
            <div class="col-sm-12 verticalMargin10">
            	<?php if($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                <button class="btn btn-primary" id="addButton">Novi baner</button>
                <?php endif;?>
                <button class="btn btn-primary" id="listButton">Lista banera</button>
                
            </div>
        </div>
        
        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i> 
       
        
        <div class="box box-primary box-body addChangeCont hide" >
       		<div class="loaded" id=''></div>
            
            <div class="row">
				<div class="col-sm-2">
                	<div class="form-group">
                        <label>Pozicija</label>
                        <select class="form-control positionSelect" >
                            <option value="l">Levo</option>
                            <option value="c">Centralno</option>
                            <option value="r">Desno</option>
                        </select>
                    </div>
                </div> 
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Stranica banera</label>
                        <input type="text" class="form-control pageBanner" placeholder="Stranica banera">
                    </div>
                </div>           
            	<div class="clearfix"></div>
            
            	<div class="col-sm-4">
                	<div class="form-group">
                        <label>Naziv banera</label>
                        <input type="text" class="form-control titleBanner" placeholder="Naziv banera">
                    </div>
                </div>
                

            </div>
            
            <div class="row addChangeLangCont">
            
            </div>

            <a class="btn btn-primary saveAddChange">Snimi</a>  
        </div>
          
	</section>
	<!-- /.content -->
</div>
