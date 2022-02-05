<div class="content-wrapper">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-list"></i> Meni
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
			<li class="active"><i class="fa fa-list"></i> Meni</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
		
        <div class="row">
            <div class="col-sm-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <h2 class="box-title">Meni lista</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="tree"></div>
                            </div>
                        </div>
                    </div>
                </div>
     
            </div>
            
            <div class="col-sm-8">
            <div class="box box-primary">
                <div class="box-body">
            	<div class="row">
                    <div class="col-sm-12 verticalMargin10 hide">
                        <button class="btn btn-primary verticalMargin10" id="addMenusButton">Kreiraj podmeni</button>
                    </div>
                </div>
                <hr />
            	<div class="meniDataCont" id='' parentid=''>
                   <div class="row form-group">
                   		<div class="col-sm-6">
                        	<label>Status: </label>
                            <select class="form-control statusMenu">
                                <option value="v">Vidljivo</option>
                                <option value="h">Sakriveno</option>
                                <option value="a">Arhiva</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                        	<label>Sort: </label>
                       		<input type="number" class="form-control sortMenuNumber" min="0" disabled />
                        </div>
						<div class="col-sm-12">
                        	<label>Slika: </label>
                       		<input type="text" class="form-control menuImageInput"/>
                        </div>                        
                   </div>
                   <hr />
                   <div class="langInputCont">
                       
                   </div>
                   
                   <div class="form-group">
						
                        <div class="row">
                        	<div class="col-sm-3">
                            	<label>Tip linka:</label>
                            	<select class="form-control linkTypeMenu">
                                    <option value="i">Na sajtu</option>
                                    <option value="e">Udaljena stranica</option>
                                    <option value="f">Dokument na sajtu</option>
                                </select>
                            </div>
                            <div class="col-sm-9">
                            	<label>Link:</label>
                            	<input type="text" class="form-control menuLink" />
                            </div>
                        </div>

                   </div>
				   <div class="form-group">
						
                        <div class="row">
                        	<div class="col-sm-3">
                            	<label>Tip menija:</label>
                            	<select class="form-control menuType">
                                    <option value="s">Single</option>
                                    <option value="sdd">DropDown</option>
                                    <option value="ddfw">DropDown celom širinom</option>
									<option value="cat">Kategorije</option>
									<option value="catfw">Kategorije celom širinom</option>
                                </select>
                            </div>
                            <div class="col-sm-9">
                            	
                            </div>
                        </div>

                   </div>
                   
                </div>
                <button class="btn btn-primary saveMenuData">Snimi</button>


            </div>


            </div>
        </div>    
        </div>
        
        
        
	</section>
	<!-- /.content -->
</div>
