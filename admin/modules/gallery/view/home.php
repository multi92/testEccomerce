<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
        <h1>
            <i class="fa fa-picture-o"></i> Galerije
        </h1>
        <ol class="breadcrumb" style="right:60px; top:10px;">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li class="active"><i class="fa fa-picture-o"></i> Galerije</li>

        </ol>
        <div style="height: 100%;
                    background: #575757;
                    position: absolute;
                    top: 0;
                    right: 0;
                    width:50px;"
        >
            <a href='gallery/config' class="btn btn-settings" ><i class="fa fa-cog" style="margin-top: 11px;
   font-size: 25px;
   color: #fff;"></i> </a>
        </div>
    </section>

   <!-- Main content -->
    <section class="content">
        <div id="blueimp-gallery" class="blueimp-gallery">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>
        <div class="row">
            <div class="col-sm-12 verticalMargin10">
                <button class="btn btn-primary" id="listButton">Lista galerija</button>
	            <button class="btn btn-primary" id="toggleAddGallery">Dodaj novu galleriju</button>
            </div>
        </div>
        <div class="box box-primaty box-body addNewGallery" style="display: none;">
            <h4 class="box-title">Nova Galerija</h4>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group ">
                                    <label>Pozicija</label>
                                    <select class="form-control newGalleryPositionSelect" >
                                        <option value="gal" >Galerija</option>
                                        <option value="slider" >Slajder</option>
                                        <option value="vid" >Video galerija</option>
                                        <option value="news" >Vest</option>
                                        <option value="page" >Stranica</option>
                                        
                                    </select>
                                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control galleryNewName">
                    </div>
                    <div class="form-group" style="display: none;">
                        <label>Description</label>
                        <input type="text" class="form-control galleryNewDescription">
                    </div>

                    <button class="btn btn-primary" id="galleryAddButton">Dodaj</button>
                </div>
            </div>
        </div>

        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
        
        <div class="box box-primary box-body addChangeCont" style="display:none;">
            <div class="loaded" id=''></div>

            <div class="row">
                <div class="col-sm-12 itemsCont" id="links">
                    <div class="galleryItemCont">
                        <!--                    	<a href="../fajlovi/prijatelji/cvecara.jpg">-->
                        <!--                        	<img src="../fajlovi/prijatelji/cvecara.jpg" height="100">-->
                        <!--                        </a>-->
                        <input type="button" class="btn btn-danger galleryItemButton" value="X">
                        <input type="button" class="btn btn-danger pull-right galleryItemDetailButton"
                               value="Detalji">
                    </div>
                </div>
            </div>

            <hr/>
            <div class="row">
                <input type="hidden" id="gallery-id">
                <div class="col-md-12">
                    <div class="col-md-2">Naziv Galerije</div>
                    <div class="col-md-5"><input type="text" id="gname" class="form-control"></div>
                    <div class="col-md-8"></div>
                </div>
                <div class="col-md-12" style="display: none;">

                    <div class="col-md-2">Kratak opis Galerije</div>
                    <div class="col-md-5"><input type="text" id="gdesc" class="form-control"></div>
                    <div class="col-md-8"></div>
                </div>
                <div class="col-md-12" style="">

                    <div class="col-md-2">Sort</div>
                    <div class="col-md-5"><input type="number" id="gsort" class="form-control"></div>
                    <div class="col-md-8"></div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-2">
                        <button class="btn btn-primary verticalMargin10" id="changeDesc">Snimi</button>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-8"></div>
                </div>
            </div>
            <hr/>

            <div class="form-group row verticalMargin10">
                <div class="col-sm-2">
                    <label>Tip</label>
                    <select class="form-control addGalleryItemType">
                        <option value="image" selected >Slika</option>
                    </select>
                </div>
                <div class="col-sm-5">
                    <label>Putanja do sadrzaja</label>
                    <input type="text" class="form-control addGalleryItemLink"/>
                </div>
                <div class="col-sm-5">
                    <label>Link</label>
                    <input type="text" class="form-control addGalleryItemJumpLink"/>
                </div>

               <div class="col-md-12 no_padding">
                    <div class="col-md-2">
                        <label>Redni broj</label>
                        <input type="number" min="1" id="sortnum" class="form-control"/>
                    </div>
                    <div class="col-md-10"></div>
                </div>

               <div class="clearfix"></div>

               <?php
                foreach ($langfull as $val) {
					
                    echo '<div class="form-group col-sm-4" langid="" defaultlang="">
								<label class="hidden">' . ucfirst($val['name']) . ' title</label>
								<input class="hidden" type="text" class="form-control newGalleryItemTitle" /><br />
								<label>' . ucfirst($val['name']) . ' opis</label>
								<textarea class="form-control newGalleryItemDesc"></textarea>
							</div>
					';
					
                }
                ?>
                <div class="col-sm-12">
                    <button class="btn btn-primary verticalMargin10 addGalleryItem">Dodaj</button>
                    <button class="btn btn-primary verticalMargin10 saveGalleryItem" style="display:none;">
                        Snimi
                    </button>
                    <button class="btn btn-primary verticalMargin10 addGalleryItemNewForm" style="display:none;">Dodaj novu stavku
                    </button>
                </div>
          </div>
       </div>

        <div class="row listCont">
            <div class="col-xs-12 hidden">
                <?php if ($_SESSION['add'] == 1 || $_SESSION['user_type'] == "admin") : ?>
                   <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Dodaj novu galeriju</h3>
                       </div>
                        <!-- /.box-header -->
                        <div class="box-body row">
                            <div class="col-sm-3">
                                <!--                            	<label>Pozicija</label>-->
                                <!--                            	<select class="form-control addNewGallerySelect">-->
                                <!--                                	<option value=""></option>-->
                                <!--                                    <option value="home">Slider pocetna</option>-->
                                <!--                                    <option value="gallery">Slider galerija</option>-->
                                <!--                                    <option value="gallery-imgs">Galerija slika</option>-->
                                <!--                                    <option value="gallery-video">Galerija klipova</option>-->
                                <!--                                </select>-->
                            </div>
                            <div class="clearfix"></div>
                            <?php
                            foreach ($langfull as $val) {
                                echo '<div class="form-group col-sm-4">
										<label>' . ucfirst($val[1]) . '</label>
										<input type="text" class="form-control newGallery_' . $val[0] . '" /><br />
										<label>' . ucfirst($val[1]) . ' opis</label>
										<textarea class="form-control newGalleryDesc_' . $val[0] . '"></textarea>
									</div>
									';
                            }
                            ?>
                            <div class="col-sm-12">
                                <button class="btn btn-primary" id="addNewGalleryButton">Dodaj galeriju
                                </button>
                            </div>
                        </div>
                    </div>
               <?php endif; ?>
            </div>
            <div class="col-xs-12">
                <!-- /.box -->

               <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lista svih galerija u bazi</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                       <table id="example1" class="table table-bordered table-striped">
                           <thead>
                            <tr>
                                <th>Redni broj</th>
                                <th>Naslov</th>
                                <th>Dodata</th>
                                <th>Zadnja izmena</th>
                                <th>Menjao</th>
                                <th>Pozicija</th>
                                <th>Status</th>
								<th>Sort</th>
                                <th>Izmeni</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

       <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->



